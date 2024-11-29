<?php

namespace App\Http\Controllers\Mobile\User\Events;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Jobs\SendEventGuestNotifications;
use App\Mail\GuestNotificationMail;
use App\Models\Country;
use App\Models\GeneralSetting;
use App\Models\UserEvent;
use App\Models\UserEventGuest;
use App\Models\UserEventGuestCheckinList;
use App\Models\UserEventNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Attendees extends BaseController
{
    public int $paginate=20;
    //landing page
    public function landingPage($eventId)
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();

        $event = UserEvent::where([
            'reference' => $eventId,
            'user' => $user->id
        ])->firstOrFail();

        $guests = UserEventGuest::where('event',$event->id)->with([
            'ticket.ticket','checkinDetails'
        ])->simplePaginate($this->paginate);

        return view('mobile.users.events.attendees.list')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' =>$event->title.': Guest List',
            'event' => $event,
            'guests' => $guests,
            'currency'=>Country::where('currency',$event->currency)->first(),
        ]);
    }
    //search guests
    public function searchGuests(Request $request, $eventRef)
    {
        $query = $request->input('query', '');

        $event = UserEvent::where([
            'reference' => $eventRef,
        ])->first();

        if ($query==''){
            $guests = UserEventGuest::where('event',$event->id)->with([
                'ticket.ticket','checkinDetails'
            ])->simplePaginate($this->paginate);
        }else{
            $guests = $event->guests()->where(function ($q) use ($query) {
                $q->where('ticketCode', 'like', "%$query%");
            })->with([
                'ticket.ticket','checkinDetails'
            ])->get();
        }

        return response()->json([
            'data' => $guests->map(function ($guest) use($event) {
                return [
                    'name' => $guest->name,
                    'email' => $guest->email,
                    'ticketCode' => $guest->ticketCode,
                    'ticket' => [
                        'name' => $guest->ticket->ticket->name,
                        'ticketType' => ucfirst($guest->ticket->ticket->ticketType),
                        'currencySymbol' => $guest->ticket->currency,
                        'price' => number_format($guest->ticket->price, 2),
                    ],
                    'checked_in_time' => optional($guest->checkinDetails)->checkin_time,
                    'checkin_url' => route('mobile.user.events.attendees.checkin', [ 'event' => $event->reference, 'guest' => $guest->id]),
                ];
            }),
        ]);
    }
    //check in guests
    public function checkInGuest(Request $request,$eventRef, $guestId)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();
            //event
            $event = UserEvent::where([
                'reference' => $eventRef,
                'user' => $user->id
            ])->first();

            if (empty($event)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'This guest or event does not belong to you.',
                ], 400);
            }

            $guest = UserEventGuest::where([
                'event' => $event->id,
                'id' => $guestId
            ])->first();


            if (empty($guest)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'This guest does not belong to you or this event.',
                ], 400);
            }

            if ($guest->checkedIn == 1) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Guest is already checked in.',
                ], 400);
            }

            $guest->checkedIn = 1;
            $guest->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Guest successfully checked in.',
            ]);
        } catch (\Exception $exception) {

            DB::rollBack();
            logger('Error checking in guest: ' . $exception->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'A server error occurred while processing your request.',
            ], 500);
        }
    }
    //check-in list
    public function checkInList($eventId)
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();

        $event = UserEvent::where([
            'reference' => $eventId,
            'user' => $user->id
        ])->firstOrFail();

        $guests = UserEventGuestCheckinList::where([
            'event_id'=>$event->id
        ])->with('guest')->simplePaginate($this->paginate);

        return view('mobile.users.events.attendees.checkin_list')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' =>$event->title.': Check-in List',
            'event' => $event,
            'guests' => $guests,
        ]);
    }
    //search checked-in guests
    public function searchCheckedInGuests(Request $request, $eventRef)
    {
        $query = $request->input('query', '');

        $event = UserEvent::where([
            'reference' => $eventRef,
        ])->first();

        if ($query==''){
            // Fetch only checked-in guests if no query is provided
            $guests = UserEventGuestCheckinList::where('event_id', $event->id)
                ->with(['guest.ticket.ticket'])
                ->simplePaginate($this->paginate);
        }else{
            $guests = UserEventGuestCheckinList::where('event_id', $event->id)
                ->whereHas('guest', function ($q) use ($query) {
                    $q->where('ticketCode', 'like', "%$query%");
                })
                ->with(['guest.ticket.ticket'])
                ->get();
        }

        return response()->json([
            'data' => $guests->map(function ($checkin) {
                $guest = $checkin->guest;

                return [
                    'name' => $guest->name,
                    'email' => $guest->email,
                    'ticketCode' => $guest->ticketCode,
                    'checked_in_time' => $checkin->checkin_time,
                    'checked_out_time' => $checkin->checkout_time,
                ];
            }),
        ]);
    }
    //process notify attendees
    public function processNotifyAttendees(Request $request,$eventId)
    {
        $user = Auth::user();
        $event = UserEvent::where('id', $eventId)
            ->where('user', $user->id)
            ->with('guests')
            ->firstOrFail();

        // Check if a notification was sent within the last 12 hours
        $lastNotification = UserEventNotification::where('event_id', $event->id)
            ->where('merchant_id', $user->id)
            ->latest('sent_at')
            ->first();

        if ($lastNotification && $lastNotification->sent_at->diffInHours(now()) < 12) {
            return response()->json([
                'status' => 'error',
                'message' => 'You can only send another notification after 12 hours.',
            ], 429);
        }

        foreach ($event->guests as $guest) {
            Mail::to($guest->email)->queue(new GuestNotificationMail($guest,$request->has('message')?false:true,$request->message));
        }

        // Log the notification in the database
        UserEventNotification::create([
            'event_id' => $event->id,
            'merchant_id' => $user->id,
            'sent_at' => now(),
            'message'=>$request->has('message')?$request->message:null
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Notification sent successfully to all guests.',
        ]);
    }
    //notify attendees
    public function notifyAttendees(Request $request,$eventId)
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();

        $event = UserEvent::where([
            'reference' => $eventId,
            'user' => $user->id
        ])->with('notifications')->firstOrFail();

        return view('mobile.users.events.attendees.notify')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' =>'Notify '.$event->title.' Guests',
            'event' => $event,
        ]);
    }
    //process attendee notification
    public function processAttendeeNotification(Request $request, $eventReference)
    {
        $user = Auth::user();

        try {
            // Validate input
            $request->validate([
                'notification_type' => 'required|string|in:reminder,custom',
                'message' => 'nullable|string|max:500',
                'event_id' => 'required|exists:user_events,id',
            ]);

            // Fetch the event based on the reference
            $event = UserEvent::where([
                'reference' => $eventReference,
                'user' => $user->id
            ])->firstOrFail();

            // Check if a notification was sent in the past 12 hours
            $lastNotification = UserEventNotification::where('event_id', $event->id)
                ->where('sent_at', '>=', now()->subHours(12))
                ->first();

            if ($lastNotification) {
                return response()->json([
                    'success' => false,
                    'message' => 'A notification for this event has already been sent in the last 12 hours.',
                ], 400);
            }

            // Prevent race conditions using DB transaction
            DB::beginTransaction();

            // Fetch the event and guests
            $guests = UserEventGuest::where('event', $event->id)->get();

            if ($guests->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No guests found for this event.',
                ], 404);
            }

            // Create the notification
            $notification = UserEventNotification::create([
                'event_id' => $event->id,
                'merchant_id' => Auth::id(),
                'message' => $request->notification_type === 'custom' ? $request->message : null,
                'sent_at' => now(),
            ]);

            // Dispatch the job
            SendEventGuestNotifications::dispatch($guests, $request->notification_type === 'reminder', $request->message);

            // Commit transaction
            DB::commit();

            // Return success response
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $notification->id,
                    'message' => $notification->message,
                    'sent_at' => $notification->sent_at->format('d M Y, h:i A'),
                    'merchant_name' => Auth::user()->name,
                ],
            ]);

        } catch (\Exception $e) {
            // Rollback transaction if something goes wrong
            DB::rollBack();

            // Log error for debugging
            logger('Notification Error: ' . $e->getMessage());

            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while sending the notification. Please try again.',
            ], 500);
        }
    }
    //send link to verify ticket
    public function sendTicketVerificationLink(Request $request,$eventId)
    {

    }

}
