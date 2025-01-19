<?php

namespace App\Http\Controllers\Mobile\Ads;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Mail\EventPurchaseConfirmation;
use App\Mail\EventPurchaseNotification;
use App\Models\GeneralSetting;
use App\Models\UserEvent;
use App\Models\UserEventPurchase;
use App\Models\UserEventPurchaseTicket;
use App\Services\Payments\FlutterwaveGateway;
use App\Services\Payments\NombaGateway;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EventCheckoutPaymentController extends BaseController
{
    protected NombaGateway $NombaGateway;
    protected FlutterwaveGateway $flutterwaveGateway;

    public function __construct(NombaGateway $NombaGateway, FlutterwaveGateway $flutterwaveGateway)
    {
        $this->NombaGateway = $NombaGateway;
        $this->flutterwaveGateway = $flutterwaveGateway;
    }

    //process checkout payment
    public function processCheckSuccessfulPayment(Request $request,$eventRef,$purchaseRef)
    {
        $user = Auth::user();
        $web = GeneralSetting::first();

        $event = UserEvent::where('reference',$eventRef)->firstOrFail();

        $purchase = UserEventPurchase::where([
            'event_id' => $event->id,
            'reference' => $purchaseRef,
            'user_id' => $user->id,
        ])->firstOrFail();

        $transactionId = $request->has('transaction_id')?$request->get('transaction_id'):$request->get('orderReference');

        return view('mobile.ads.events.checkout.success_page')->with([
            'user' => $user,
            'web' => $web,
            'pageName'=>'Payment Status',
            'siteName'=>$web->name,
            'purchase'=>$purchase,
            'event'=>$event,
            'transactionId'=>$transactionId
        ]);
    }
    //process checkout cancelled payment
    public function processCheckoutCancelledPayment(Request $request,$eventRef,$purchaseRef)
    {
        $user = Auth::user();
        $web = GeneralSetting::first();

        $event = UserEvent::where('reference',$eventRef)->firstOrFail();

        $purchase = UserEventPurchase::where([
            'event_id' => $event->id,
            'reference' => $purchaseRef,
            'user_id' => $user->id,
        ])->firstOrFail();

        $transactionId = $request->has('transaction_id')?$request->get('transaction_id'):$request->get('trxref');

        return view('mobile.ads.events.checkout.cancel_page')->with([
            'user' => $user,
            'web' => $web,
            'pageName'=>'Payment Status',
            'siteName'=>$web->name,
            'purchase'=>$purchase,
            'event'=>$event,
            'transactionId'=>$transactionId
        ]);
    }

    public function checkStatus(Request $request, $purchaseRef,$transactionId)
    {
        DB::beginTransaction();
        try {
            $purchase = UserEventPurchase::where([
                'reference'=>$purchaseRef,
                'user_id' => Auth::user()->id,
            ])->first();

            if (empty($purchase)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'We could not find this purchase',
                    'error' => 'Purchase not found'
                ], 500);
            }
            //check if the purchase was already successful

            if ($purchase->paymentStatus==1){

                return response()->json([
                    'status' => 'success',
                    'message' => 'Payment already received. Please click the next button to proceed to the next action.'
                ]);
            }

            // Check which gateway to use based on currency or other criteria
            $gateway = $this->determineGateway($purchase->purchaseCurrency);

            // Fetch payment status from the selected gateway
            $statusResponse = $gateway->verifyPayment($transactionId);

            if ($statusResponse['status']) {
                if ($statusResponse['data']['status']){

                    if ($statusResponse['data']['amount'] >= $purchase->price) {
                        //fetch purchase tickets
                        $tickets = UserEventPurchaseTicket::where([
                            'event_id' => $purchase->events->id,
                            'user_event_purchase_id' => $purchase->id,
                        ])->with('ticket')->get();
                        //update purchase
                        $purchase->update([
                            'paymentStatus' => 1,
                            'paymentId' => $statusResponse['data']['id'],
                            'processorFee' => $statusResponse['data']['fees'],
                            'datePaid' => Carbon::now($purchase->events->eventTimeZone)
                        ]);
                        //get the ticket and update quantity sold
                        foreach ($tickets as $ticket) {
                            $ticket->ticket->update([
                                'ticketSold' => $ticket->ticket->ticketSold + $ticket->quantity
                            ]);
                        }
                        $nextSettlement = Carbon::now($purchase->events->eventTimeZone)->addDays(config('app.settlementDay'));
                        // Check if the calculated date falls on a weekend and adjust to the next Monday
                        if ($nextSettlement->isWeekend()) {
                            $nextSettlement->next(Carbon::MONDAY);
                        }
                        //update the event total sales
                        $purchase->events->update([
                            'totalSales' => $purchase->events->totalSales + $purchase->price,
                            'currentBalance' => $purchase->events->currentBalance + $purchase->totalPrice,
                            'nextSettlement' => $nextSettlement
                        ]);

                        Mail::to($purchase->events->users->email)->queue(new EventPurchaseNotification($purchase,$purchase->events));//mail to merchant
                        Mail::to(\auth()->user()->email)->queue(new EventPurchaseConfirmation($purchase,$purchase->events));//mail to buyer

                        DB::commit();
                        return response()->json([
                            'status' => 'success',
                            'message' => 'Payment successful',
                            'url'   =>route('mobile.user.events.purchase.detail',['purchase'=>$purchase->reference])
                        ]);
                    }else{
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Your payment was received but only a partial amount was settled. Please contact our support team'
                        ],500);
                    }
                }else{
                    return response()->json([
                        'status' => 'pending',
                        'message' => 'Payment is still pending'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 'pending',
                    'message' => 'Payment is still pending'
                ]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            logger($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while checking the payment status. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function determineGateway($currency)
    {
        return strtoupper($currency) === 'NGN' ? $this->NombaGateway : $this->flutterwaveGateway;
    }
}
