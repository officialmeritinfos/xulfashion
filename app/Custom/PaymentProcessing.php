<?php

namespace App\Custom;

use App\Models\Fiat;
use App\Models\GeneralSetting;
use App\Models\UserStoreCustomer;
use Illuminate\Support\Facades\Log;

class PaymentProcessing
{
    //initiate order payment
    public function initiateOrderPayment($order,$store,$web)
    {
        $customer = UserStoreCustomer::where('id',$order->customer)->first();
        $fiat = Fiat::where('code',$order->currency)->first();

        switch ($order->currency){
            case 'NGN':
                //use paystack
                $data = [
                    'amount'=>$order->totalAmountToPay*$fiat->subUnit,
                    'email'=>$customer->email??$web->email,
                    'reference'=>$order->paymentReference,
                    'callback_url'=>route('merchant.store.checkout.order.payment.process',['subdomain'=>$store->slug,'id'=>$order->reference]),
                    'channels'=>["bank","ussd", "qr", "mobile_money", "bank_transfer"]
                ];
                $gateWay = new Paystack();
                $response = $gateWay->initializeTransaction($data);
                //check if response is okay
                if ($response->ok()){
                    $res = $response->json();
                    Log::info($res);
                    $result = [
                        'result'=>true,
                        'url'=>$res['data']['authorization_url'],
                        'reference'=>$res['data']['reference']
                    ];
                }else{
                    Log::info($response->body());
                    $result = [
                        'result'=>false,
                        'message'=>'Unable to process your order. Redirecting your to the invoice page to use another method'
                    ];
                }
                break;
            case 'GHS':
                //use paystack but different data
                break;
            default:
                //use stripe
                break;
        }

        return $result;
    }
}
