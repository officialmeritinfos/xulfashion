<?php

namespace App\Services\Payments;

use App\Contracts\PaymentGatewayInterface;
use Illuminate\Support\Facades\Http;

class FlutterwaveGateway implements PaymentGatewayInterface
{
    protected $secretKey;
    public $url;
    public $pubKey;
    protected $amount;
    protected $currency;
    protected $callbackUrl;
    protected $paymentReference;
    protected $email;
    protected $channels;
    public function __construct()
    {
        $pubKey=config('constant.flutterwave.pubKey');
        $secKey=config('constant.flutterwave.secKey');

        $this->url = config('constant.flutterwave.url');
        $this->pubKey = $pubKey;
        $this->secretKey = $secKey;
    }

    public function initializePayment(array $data,array $options): array
    {
        $this->amount = $data['amount'];
        $this->currency = $data['currency'];
        $this->paymentReference = $data['reference'];
        $this->email = $data['email'];
        $this->callbackUrl = $data['callback_url'];
        $this->channels = implode(',',$options['channels']);

        $dataToSend = [
            'amount' => $this->amount,
            'currency' => $this->currency,
            'tx_ref' => $this->paymentReference,
            'redirect_url' => $this->callbackUrl,
            'customer'=>[
                'email' => $this->email,
            ],
            'payment_options'=>$this->channels,
            'configurations'=>[
                'session_duration'=>30,
                'max_retry_attempt'=>5
            ]
        ];

        $response = Http::withToken($this->secretKey)
            ->post($this->url.'payments', $dataToSend);
        $response->json();

        return [
            'status' => $response['status']=='success',
            'message' => $response['message'] ?? '',
            'data' => [
                'payment_url' => $response['data']['link'] ?? null,
            ],
        ];
    }

    public function verifyPayment(string $reference): array
    {
        $response = Http::withToken($this->secretKey)
            ->get($this->url."transactions/{$reference}/verify");
        $response->json();

        return [
            'status' => $response['status']=='success',
            'message' => $response['message'] ?? '',
            'data' => [
                'id' => $response['data']['id'] ?? null,
                'status'=>$response['data']['status']=='successful',
                'amount'=>$response['data']['amount'] ?? null,
                'channel'=>$response['data']['payment_type'] ?? null,
                'currency'=>$response['data']['currency'] ?? null,
                'fees'=>($response['data']['app_fee']+$response['data']['merchant_fee']) ?? null,
            ],
        ];
    }
}
