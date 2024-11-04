<?php

namespace App\Http\Controllers\Mobile\Ads;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\TicketCart;
use App\Models\UserEvent;
use App\Models\UserEventPurchase;
use App\Models\UserEventTicketBuyer;
use App\Services\Payments\FlutterwaveGateway;
use App\Services\Payments\PaystackGateway;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EventCheckoutController extends BaseController
{
    use Helpers;
    protected PaystackGateway $paystackGateway;
    protected FlutterwaveGateway $flutterwaveGateway;

    public function __construct(PaystackGateway $paystackGateway, FlutterwaveGateway $flutterwaveGateway)
    {
        $this->paystackGateway = $paystackGateway;
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

            // Verify the total amount against the cart total
            if ($request->total_amount != $calculatedTotal) {
                return response()->json([
                    'success' => false,
                    'message' => 'The total amount does not match the cart value. Please refresh the page and try again.',
                    'calculated_total' => $calculatedTotal
                ], 400);
            }

            // Determine the payment gateway based on predefined criteria
            $paymentGateway = $this->selectPaymentGateway($event->currency);
            $reference = $this->generateUniqueReference('user_event_purchases','reference');
            //Create buyer record
            $buyer = UserEventTicketBuyer::create([
                'user'=>$user->id,'event'=>$event->id,
                'email'=>$user->email,'name'=>$user->name,
                'phone'=>$user->phone,'country'=>$user->countryCode
            ]);
            // Create a purchase record
            $purchase = UserEventPurchase::create([
                'reference'=>$reference,'user_id'=>$user->id,
                'event_id'=>$event->id,'buyer'=>$buyer->id
            ]);


        }catch (\Exception $exception){
            DB::rollBack();
            logger($exception->getMessage().' on line '.$exception->getLine().' in '.$exception->getFile());
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ]);
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

    private function selectPaymentGateway($currency)
    {
        return strtoupper($currency) === 'NGN' ? $this->paystackGateway : $this->flutterwaveGateway;
    }
}
