<?php

namespace App\Http\Controllers\Mobile\User\Events;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Mail\GuestEventTicket;
use App\Models\GeneralSetting;
use App\Models\UserEventGuest;
use App\Models\UserEventPurchase;
use App\Models\UserEventPurchaseTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class BuyerPurchaseController extends BaseController
{
    //landing page
    public function landingPage(Request $request)
    {

    }
    //purchase detail
    public function purchaseDetail(Request $request,$purchaseRef)
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();

        $purchase= UserEventPurchase::where([
            'user_id' => $user->id,
            'reference' => $purchaseRef,
        ])->with([
            'events','guests','tickets.ticket'
        ])->firstOrFail();

        return view('mobile.users.events.purchases.buyer_purchase_detail')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' =>'Purchase Detail: '.$purchase->events->title,
            'purchase' => $purchase,
        ]);
    }
    //add guests
    public function addGuest($purchaseRef,$purchaseTicket)
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();
        $purchase= UserEventPurchase::where([
            'user_id' => $user->id,
            'reference' => $purchaseRef,
        ])->with([
            'events','guests',
        ])->firstOrFail();

        $ticket = UserEventPurchaseTicket::where([
            'id' => $purchaseTicket,
            'user_event_purchase_id' => $purchase->id,
        ])->with('ticket')->firstOrFail();

        return view('mobile.users.events.purchases.add_guests')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' =>'Add Guests: '.$ticket->ticket->name,
            'purchase' => $purchase,
            'ticket' => $ticket,
        ]);
    }
    //process ticket guest
    public function processGuestAddition(Request $request,$purchaseRef,$purchaseTicket)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();

            // Lock the purchase row to prevent concurrent modifications
            $purchase = UserEventPurchase::where([
                'user_id' => $user->id,
                'reference' => $purchaseRef,
            ])
                ->with(['events', 'guests'])
                ->lockForUpdate()
                ->first();

            if (empty($purchase)){
                return $this->sendError('validation.error', [
                    'error' => 'The purchase was not found',
                ]);
            }

            // Lock the ticket row to prevent concurrent guest additions
            $ticketPurchased = UserEventPurchaseTicket::where([
                'id' => $purchaseTicket,
                'user_event_purchase_id' => $purchase->id,
            ])
                ->with('ticket')
                ->lockForUpdate()
                ->first();
            if (empty($ticketPurchased)){
                return $this->sendError('validation.error', [
                    'error' => 'The ticket is not found',
                ]);
            }
            // Ensure the ticket belongs to the event in the purchase
            if ($ticketPurchased->event_id != $purchase->event_id) {
                return $this->sendError('validation.error', [
                    'error' => 'The ticket does not belong to this event.',
                ]);
            }

            // Validate request data
            $validator = Validator::make($request->all(), [
                'guests' => 'required|array',
                'guests.*.name' => 'required|string|max:150',
                'guests.*.email' => 'required|email|max:150',
                'guests.*.ticketCode' => 'required|string|max:15|unique:user_event_guests,ticketCode',
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', [
                    'error' => $validator->errors()->all(),
                ]);
            }

            // Check for duplicate ticket codes in the request
            $ticketCodes = array_column($request->guests, 'ticketCode');
            if (count($ticketCodes) !== count(array_unique($ticketCodes))) {
                return $this->sendError('guest.ticket.error', [
                    'error' => 'Duplicate ticket codes detected in the request.',
                ]);
            }

            // Calculate maximum guests allowed
            $maxGuests = $ticketPurchased->number_admits * $ticketPurchased->quantity;
            $existingGuestCount = $ticketPurchased->guests->count();
            $newGuestCount = count($request->guests);

            // Check if the total guests exceed the allowed limit
            if (($existingGuestCount + $newGuestCount) > $maxGuests) {
                return $this->sendError('guest.ticket.error', [
                    'error' => 'You cannot add more guests than the allowed limit for this ticket.',
                ]);
            }

            // Insert guests in a batch to minimize database interactions
            $guestsToInsert = [];
            foreach ($request->guests as $guest) {
                $guestsToInsert[] = [
                    'user' => auth()->id(),
                    'event' => $purchase->event_id,
                    'ticket_id' => $ticketPurchased->id,
                    'purchase' => $purchase->id,
                    'ticketCode' => $guest['ticketCode'],
                    'name' => $guest['name'],
                    'email' => $guest['email'],
                    'phone' => $guest['phone'] ?? null,
                    'sameAsBuyer' => 0,
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Batch insert
            UserEventGuest::insert($guestsToInsert);
            DB::commit();
            $ticketPurchased= $ticketPurchased->refresh();

            $this->sendMailToGuests($ticketPurchased);

            return $this->sendResponse([
                'redirectTo' => route('mobile.user.events.purchase.detail', [
                    'purchase' => $purchase->reference,
                ]),
                'redirects' => true,
            ], 'Guests successfully added.');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Error in ' . __METHOD__ . ': ' . $exception->getMessage());
            return $this->sendError('server.error', [
                'error' => 'A server error occurred while processing your request.',
            ]);
        }
    }
    /**
     * Send event tickets via email to all guests associated with a purchased ticket.
     *
     * This method iterates through the guests of a purchased ticket and queues
     * an email containing the ticket details to each guest.
     *
     * @param \App\Models\UserEventPurchaseTicket $ticketPurchased
     *        The purchased ticket instance whose guests will receive the emails.
     *
     * @return void
     */
    private function sendMailToGuests(UserEventPurchaseTicket$ticketPurchased)
    {
        foreach ($ticketPurchased->guests as $guest) {
            Mail::to($guest->email)->queue(new GuestEventTicket($guest->id));
        }
    }
    /**
     * Sends a ticket email to a specific guest for a purchased ticket.
     *
     * This method validates that the user owns the purchase, the ticket belongs to the purchase,
     * and the guest belongs to the ticket. If all conditions are satisfied, it queues an email
     * with the guest's ticket details.
     *
     * @param string $purchaseRef The reference for the purchase.
     * @param int $purchaseTicket The ID of the purchased ticket.
     * @param int $guestId The ID of the guest to whom the ticket email will be sent.
     *
     * @return \Illuminate\Http\JsonResponse JSON response indicating success or failure.
     */
    public function sendMailToGuest(string $purchaseRef, int $purchaseTicket, int $guestId)
    {
        try {
            $user = Auth::user();

            // Lock the purchase row to prevent concurrent modifications
            $purchase = UserEventPurchase::where([
                'user_id' => $user->id,
                'reference' => $purchaseRef,
            ])
                ->with(['events', 'guests'])
                ->lockForUpdate()
                ->firstOrFail();

            // Lock the ticket row to prevent concurrent guest additions
            $ticketPurchased = UserEventPurchaseTicket::where([
                'id' => $purchaseTicket,
                'user_event_purchase_id' => $purchase->id,
            ])
                ->with('ticket')
                ->lockForUpdate()
                ->firstOrFail();

            // Ensure the ticket belongs to the event in the purchase
            if ($ticketPurchased->event_id !== $purchase->event_id) {
                return $this->sendError('validation.error', [
                    'error' => 'The ticket does not belong to this event.',
                ]);
            }

            // Fetch the guest and validate ownership
            $guest = UserEventGuest::where([
                'id' => $guestId,
                'purchase' => $purchase->id,
                'ticket_id' => $ticketPurchased->id,
            ])
                ->with(['events', 'ticket.ticket', 'purchase'])
                ->firstOrFail();

            // Queue the mail
            Mail::to($guest->email)->queue(new GuestEventTicket($guest->id));

            return $this->sendResponse([
                'redirects' => false,
            ], 'Ticket successfully sent to Guest.');
        } catch (\Exception $exception) {
            Log::error('Error in ' . __METHOD__ . ': ' . $exception->getMessage());
            return $this->sendError('server.error', [
                'error' => 'A server error occurred while processing your request.',
            ]);
        }
    }

}
