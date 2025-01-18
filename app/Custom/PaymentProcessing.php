<?php

namespace App\Custom;

use App\Models\Fiat;
use App\Models\GeneralSetting;
use App\Models\UserStore;
use App\Models\UserStoreCustomer;
use App\Models\UserStoreInvoice;
use App\Services\Payments\NombaGateway;
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
                //use Nomba
                $gateWay = new NombaGateway();
                $response = $gateWay->initializePayment([
                    'amount'=>$order->amount,
                    'email'=>$customer->email??$web->email,
                    'reference'=>$order->paymentReference,
                    'callback_url'=>route('merchant.store.checkout.order.payment.process',['subdomain'=>$store->slug,'id'=>$order->reference]),
                    'currency'=>$order->currency
                ],[]);
                //check if response is okay
                if ($response['status']){
                    $result = [
                        'result'=>true,
                        'url'=>$response['data']['payment_url'],
                        'reference'=>$response['data']['orderReference']
                    ];
                }else{
                    logger($response);
                    $result = [
                        'result'=>false,
                        'message'=>'Unable to process your order. Redirecting your to the invoice page to use another method'
                    ];
                }
                break;
            default:
                //use flutterwave
                break;
        }

        return $result;
    }
    //verify transactions
    public function verifyOrderPayment($order,$reference)
    {
        switch ($order->currency) {
            case 'NGN':
                $gateWay = new NombaGateway();
                $response = $gateWay->verifyPayment($reference);

                //check if response is okay
                if ($response->ok()){
                    $res = $response->json();
                    $result = [
                        'data'=>$res,
                        'result'=>true
                    ];
                }else{
                    Log::info($response->body());
                    $result = [
                        'result'=>false,
                        'message'=>'PAYMENT.VERIFICATION.ERR'
                    ];
                }
                break;
            default:
                break;
        }

        return $result;
    }
    //initiate invoice payment
    public function initiateInvoicePayment(UserStoreInvoice $order,UserStore $store,GeneralSetting $web)
    {
        $customer = UserStoreCustomer::where('id',$order->customer)->first();
        $fiat = Fiat::where('code',$order->currency)->first();

        switch ($order->currency){
            case 'NGN':
                //use Nomba
                $gateWay = new NombaGateway();
                $response = $gateWay->initializePayment([
                    'amount'=>$order->amount,
                    'email'=>$customer->email??$web->email,
                    'reference'=>$order->paymentReference,
                    'callback_url'=>route('merchant.store.invoice.payment.process',['subdomain'=>$store->slug,'id'=>$order->reference]),
                    'currency'=>$order->currency
                ],[]);
                //check if response is okay
                if ($response['status']){
                    $result = [
                        'result'=>true,
                        'url'=>$response['data']['payment_url'],
                        'reference'=>$response['data']['orderReference']
                    ];
                }else{
                    logger($response);
                    $result = [
                        'result'=>false,
                        'message'=>'Unable to process your order. Redirecting your to the invoice page to use another method'
                    ];
                }

                break;
            default:
                //use stripe
                break;
        }

        return $result;
    }
}
