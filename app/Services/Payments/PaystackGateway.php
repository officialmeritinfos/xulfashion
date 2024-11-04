<?php

namespace App\Services\Payments;

use App\Contracts\PaymentGatewayInterface;
use Illuminate\Support\Facades\Http;

class PaystackGateway implements PaymentGatewayInterface
{
    protected mixed $secretKey;
    public mixed $url;
    public mixed $pubKey;
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
    }

    public function initializePayment(array $data): array
    {
        $response = Http::withToken($this->secretKey)
            ->post($this->url.'transaction/initialize', $data);

        return $response->json();
    }

    public function verifyPayment(string $reference): array
    {
        $response = Http::withToken($this->secretKey)
            ->get($this->url."transaction/verify/{$reference}");

        return $response->json();
    }
}
