<?php

namespace App\Http\Controllers\Mobile\Ads;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\TicketCart;
use App\Models\UserEvent;
use App\Models\UserEventPurchase;
use App\Models\UserEventPurchaseTicket;
use App\Models\UserEventTicketBuyer;
use App\Services\Payments\FlutterwaveGateway;
use App\Services\Payments\NombaGateway;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EventCheckoutController extends BaseController
{
    use Helpers;
    protected NombaGateway $nombaGateway;
    protected FlutterwaveGateway $flutterwaveGateway;

    public function __construct(NombaGateway $nombaGateway, FlutterwaveGateway $flutterwaveGateway)
    {
        $this->nombaGateway = $nombaGateway;
        $this->flutterwaveGateway = $flutterwaveGateway;
    }
    //checkout-landing page
    public function checkoutLandingPage(Request $request,$eventId)
    {
        $user = Auth::user();
        $web = GeneralSetting::first();

        $event = UserEvent::where([
            'reference'=>$eventId,
            'status'=>1
        ]) ->first();

        if (empty($event)) {
            return back()->with('error','Event not found');
        }

        return view('mobile.ads.events.checkout.index')
            ->with([
                'user' => $user,
                'web' => $web,
                'pageName' => 'Payment Method',
                'siteName'=>$web->name,
                'event'=>$event,
            ]);
    }
    //process the checkout
    public function processCheckout(Request $request,$eventId)
    {
        $web = GeneralSetting::first();
        $user = Auth::user();

        $event = UserEvent::where([
            'reference'=>$eventId,
            'status'=>1
        ])->first();
        if (empty($event)) {
            return response()->json([
                'success' => false,
                'message' => 'Event not found',
            ],404);
        }
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|string|in:card,transfer',
            'amount' => 'required|numeric|min:0'
        ])->stopOnFirstFailure();
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->all(),
                'errors' => $validator->errors()
            ], 422);
        }
        try {
            DB::beginTransaction();
            $cart = $this->getUserCart($user);
            if (!$cart || $cart->items->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your cart is empty. Please add items before checking out.'
                ], 400);
            }

            $calculatedTotal = $this->calculateCartTotal($cart);
            $charge = $this->calculateCartCharge($cart);
            $priceToSettle = $this->calculateCartCost($cart);

            // Verify the total amount against the cart total
            if ($request->amount != $calculatedTotal) {
                return response()->json([
                    'success' => false,
                    'message' => 'The total amount does not match the cart value. Please refresh the page and try again.',
                    'calculated_total' => $calculatedTotal
                ], 400);
            }

            // Determine the payment gateway based on predefined criteria
            $paymentGateway = $this->selectPaymentGateway($event->currency);
            $reference = $this->generateUniqueReference('user_event_purchases','reference');
            $paymentRef = uniqid('txn_');
            //Create or retrieve buyer record
            $buyer = UserEventTicketBuyer::firstOrCreate(
                [
                    'user' => $user->id,
                    'event' => $event->id,
                    'email' => $user->email,
                ],
                [
                    'name' => $user->name,
                    'phone' => $user->phone,
                    'country' => $user->countryCode,
                ]
            );


            // Create a purchase record
            $purchase = UserEventPurchase::create([
                'reference'=>$reference,'user_id'=>$user->id,
                'event_id'=>$event->id,'buyer'=>$buyer->id,
                'purchaseCurrency' => $event->currency, 'price' => $calculatedTotal,
                'totalPrice' => $priceToSettle,'charge' => $charge,
                'paymentReference' => $paymentRef, 'paymentMethod'=>$request->payment_method,
                'status'=>2
            ]);

            // Create purchase ticket records
            foreach ($cart->items as $item) {
                UserEventPurchaseTicket::create([
                    'user_event_purchase_id' => $purchase->id,
                    'event_id' => $event->id,
                    'ticket_id' => $item->user_event_ticket_id,
                    'user_id' => $user->id,
                    'number_admits' => ($item->userEventTicket->ticketType=='group')?$item->userEventTicket->groupSize:1,
                    'quantity' => $item->quantity,
                    'price' => calculateTotalCostOnTicket($item->user_event_ticket_id),
                    'currency' => $event->currency,'charge'=>calculateChargeOnTicket($item->user_event_ticket_id,$item->quantity)
                ]);

                // Check if the ticket has limited quantity and decrement if applicable
                if ($item->userEventTicket->unlimited != 1) {
                    $groupSize = $item->userEventTicket->ticketType=='group'?$item->userEventTicket->groupSize:1;
                    $item->userEventTicket->decrement('quantity', $item->quantity*$groupSize);
                }
            }

            // Initialize payment through the selected gateway
            $paymentResponse = $paymentGateway->initializePayment([
                'amount' => $calculatedTotal,
                'currency' => $event->currency,
                'email' => $user->email,
                'reference' => $paymentRef,
                'callback_url'=>route('mobile.marketplace.events.cart.process.checkout.payment',['event'=>$event->reference,'payment'=>$purchase->reference])
            ],[
                'channels'=>['card'],
            ]);

            if (!$paymentResponse['status']) {
                DB::rollBack();
                logger('Payment Processor Error: '.$paymentResponse['message']);
                return response()->json([
                    'success' => false,
                    'message' => 'Payment initialization failed. Please try again.',
                    'error' => $paymentResponse['message'] ?? 'Unknown error'
                ], 400);
            }
            $cart->delete();
            $purchase->update([
                'paymentLink' => $paymentResponse['data']['payment_url']
            ]);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Payment initialized successfully.',
                'payment_url' => $paymentResponse['data']['payment_url']
            ]);

        }catch (\Exception $e){
            DB::rollBack();
            logger('Payment Processor Error: '.$e->getMessage().' on line '.$e->getLine());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during the checkout process. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    private function getUserCart($user)
    {
        // Fetch the authenticated user's cart
        return TicketCart::where('user_id', $user->id)->with('items.userEventTicket.event')->first();
    }

    private function calculateCartTotal($cart)
    {
        return $cart->items->sum(function ($item) {
            return calculateTotalCostOnTicket($item->user_event_ticket_id) * $item->quantity;
        });
    }
    private function calculateCartCharge($cart)
    {
        return $cart->items->sum(function ($item) {
            return calculateChargeOnTicket($item->user_event_ticket_id,$item->quantity);
        });
    }
    private function calculateCartCost($cart)
    {
        return $cart->items->sum(function ($item) {
            return calculateCostOnTicketWithoutCharge($item->user_event_ticket_id,$item->quantity);
        });
    }

    private function selectPaymentGateway($currency)
    {
        return strtoupper($currency) === 'NGN' ? $this->nombaGateway : $this->flutterwaveGateway;
    }
}
