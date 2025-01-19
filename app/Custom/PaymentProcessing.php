<?php

namespace App\Custom;

use App\Models\Fiat;
use App\Models\GeneralSetting;
use App\Models\UserStore;
use App\Models\UserStoreCustomer;
use App\Models\UserStoreInvoice;
use App\Models\UserStoreOrder;
use App\Services\Payments\FlutterwaveGateway;
use App\Services\Payments\NombaGateway;
use Illuminate\Support\Facades\Log;

class PaymentProcessing
{
    protected NombaGateway $nombaGateway;
    protected FlutterwaveGateway $flutterwaveGateway;

    public function __construct(NombaGateway $nombaGateway, FlutterwaveGateway $flutterwaveGateway)
    {
        $this->nombaGateway = $nombaGateway;
        $this->flutterwaveGateway = $flutterwaveGateway;
    }

    //initiate order payment
    public function initiateOrderPayment(UserStoreOrder $order,UserStore $store,GeneralSetting $web)
    {
        $customer = UserStoreCustomer::where('id',$order->customer)->first();
        $fiat = Fiat::where('code',$order->currency)->first();

        // Select the payment gateway based on currency
        $paymentGateway = $this->selectPaymentGateway($order->currency);

        // Prepare payment data for gateway initialization
        $paymentData = [
            'amount'       => $order->amount,
            'email'        => $order->customers->email ?? $web->email,
            'reference'    => $order->paymentReference,
            'callback_url' => route('merchant.store.checkout.order.payment.process',[
                'subdomain'=>$store->slug,'id'=>$order->reference
            ]),
            'currency'     => $order->currency
        ];

        // Initialize payment with card payment channel
        $paymentResponse = $paymentGateway->initializePayment($paymentData, [
            'channels' => ['card'],
        ]);
        // Handle payment initialization failure
        if (!$paymentResponse['status']) {
            logger( $paymentResponse);
            return [
                'result'=>false,
                'message'=>"Unable to process your order. {$paymentResponse['message']}"
            ];

        }

        // Save the payment gateway reference and redirect URL
        $order->channelPaymentReference = $paymentResponse['data']['orderReference'];
        $order->save();

        // Return payment URL for redirection
        return [
            'result'=>true,
            'url'=>$paymentResponse['data']['payment_url'],
            'reference'=>$paymentResponse['data']['orderReference']
        ];

    }
    //verify transactions
    public function verifyOrderPayment(UserStoreOrder$order): array
    {
        //since the different payment gateways have different mechanism for verifying payment
        //we will use the paymentReference for verifying if NGN and paymentId if other
        //currencies e.g USD, GHS, ZAR etc
        if ($order->currency==='NGN'){
            $paymentReference = $order->channelPaymentReference;
        }else{
            $paymentReference = $order->channelPaymentId;
        }
        // Select the payment gateway based on currency
        $paymentGateway = $this->selectPaymentGateway($order->currency);
        //Response from the gateway
        $response = $paymentGateway->verifyPayment($paymentReference);
        if (!$response['status']) {
            Log::info($response);
            $result = [
                'result'=>false,
                'message'=>$response['message']??'An error occurred while verifying your payment. Please write to our support team with the Order Id.'
            ];
        }
        return [
            'data'=>$response,
            'result'=>true
        ];
    }
   //Select the payment gateway to use based off the currency
    private function selectPaymentGateway($currency): NombaGateway|FlutterwaveGateway
    {
        return strtoupper($currency) === 'NGN' ? $this->nombaGateway : $this->flutterwaveGateway;
    }
}
