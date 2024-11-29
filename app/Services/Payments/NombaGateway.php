<?php

namespace App\Services\Payments;

use App\Contracts\PaymentGatewayInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NombaGateway implements PaymentGatewayInterface
{
    protected string $secretKey;
    protected string $url;
    protected string $pubKey;
    protected string $clientId;
    protected ?string $accessToken = null;

    protected $amount;
    protected $currency;
    protected $callbackUrl;
    protected $paymentReference;
    protected $email;
    protected $channels;

    public function __construct()
    {
        $this->initializeConfig();
        $this->accessToken = $this->fetchAccessToken();
    }

    /**
     * Initialize Nomba configuration values.
     */
    protected function initializeConfig(): void
    {
        $isLive = config('constant.nomba.live');

        $this->url = config('constant.nomba.url');
        $this->pubKey = $isLive
            ? config('constant.nomba.livePubKey')
            : config('constant.nomba.testPubKey');
        $this->secretKey = $isLive
            ? config('constant.nomba.liveSecKey')
            : config('constant.nomba.testSecKey');
        $this->clientId = config('constant.nomba.clientId');
    }

    /**
     * Fetch the access token using client credentials.
     *
     * @return string|null
     */
    protected function fetchAccessToken(): ?string
    {
        $response = Http::withToken($this->secretKey)
            ->post("{$this->url}auth/token/issue", [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->secretKey,
            ]);

        if ($response->ok() && isset($response['data']['access_token'])) {
            return $response['data']['access_token'];
        }

        // Log error or throw exception for debugging if needed
        Log::error('Failed to fetch Nomba access token', ['response' => $response->json()]);
        return null;
    }
    /**
     * Initialize payment.
     *
     * @param array $data
     * @param array $options
     * @return array
     */
    public function initializePayment(array $data,array $options): array
    {

    }

    /**
     * Verify payment by reference.
     *
     * @param string $reference
     * @return array
     */
    public function verifyPayment(string $reference):array
    {

    }
}
