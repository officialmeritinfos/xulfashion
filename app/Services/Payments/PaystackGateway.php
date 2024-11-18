<?php

namespace App\Services\Payments;

use App\Contracts\PaymentGatewayInterface;
use Illuminate\Support\Facades\Http;

class PaystackGateway implements PaymentGatewayInterface
{
    protected mixed $secretKey;
    public mixed $url;
    public mixed $pubKey;

    protected $amount;
    protected $currency;
    protected $callbackUrl;
    protected $paymentReference;
    protected $email;
    protected $channels;
    protected $metaData;


    public function __construct()
    {
        $pubKey = config('constant.paystack.live')
            ? config('constant.paystack.livePubKey')
            : config('constant.paystack.testPubKey');

        $secKey = config('constant.paystack.live')
            ? config('constant.paystack.liveSecKey')
            : config('constant.paystack.testSecKey');

        $this->url = config('constant.paystack.url');
        $this->pubKey = $pubKey;
        $this->secretKey = $secKey;

        logger('Paystack PubKey:'.$pubKey );
        logger('Paystack SecKey:'.$secKey );
    }

    public function initializePayment(array $data, array $options): array
    {
        $this->amount = $data['amount'] * 100;
        $this->currency = $data['currency'];
        $this->paymentReference = $data['reference'];
        $this->email = $data['email'];
        $this->callbackUrl = $data['callback_url'];
        $this->channels = $options['channels'];
        $this->channels=str_replace('transfer','bank_transfer',$this->channels);
        $this->metaData = $options['metadata'];

        $dataToSend = [
            'amount' => $this->amount,
            'currency' => $this->currency,
            'reference' => $this->paymentReference,
            'email' => $this->email,
            'callback_url' => $this->callbackUrl,
            'channels' => $this->channels,
            'metadata' => $this->metaData
        ];

        $response = Http::withToken($this->secretKey)
            ->post($this->url.'transaction/initialize', $dataToSend);
        $response->json();

        return [
            'status' => $response['status']==true,
            'message' => $response['message'] ?? '',
            'data' => [
                'payment_url' => $response['data']['authorization_url'] ?? null,
            ],
            'error'=>$response
        ];
    }

    public function verifyPayment(string $reference): array
    {
        $response = Http::withToken($this->secretKey)
            ->get($this->url."transaction/verify/{$reference}");

        $response->json();

        return [
            'status' => $response['status']=='success',
            'message' => $response['message'] ?? '',
            'data' => [
                'id' => $response['data']['id'] ?? null,
                'status'=>$response['data']['status']=='success',
                'amount'=>($response['data']['amount']/100) ?? null,
                'channel'=>$response['data']['channel'] ?? null,
                'currency'=>$response['data']['currency'] ?? null,
                'fees'=>($response['data']['fees']/100) ?? null,
            ],
        ];
    }
}
