<?php

namespace App\Services\Payments;

use App\Contracts\PaymentGatewayInterface;
use Illuminate\Support\Facades\Http;

class FlutterwaveGateway implements PaymentGatewayInterface
{
    protected $secretKey;
    public $url;
    public $pubKey;
    public function __construct()
    {
        $pubKey=config('constant.flutterwave.pubKey');
        $secKey=config('constant.flutterwave.secKey');

        $this->url = config('constant.flutterwave.url');
        $this->pubKey = $pubKey;
        $this->secretKey = $secKey;
    }

    public function initializePayment(array $data): array
    {
        $response = Http::withToken($this->secretKey)
            ->post($this->url.'payments', $data);

        return $response->json();
    }

    public function verifyPayment(string $reference): array
    {
        $response = Http::withToken($this->secretKey)
            ->get($this->url."transactions/{$reference}/verify");
        return $response->json();
    }
}
