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
    protected string $accountId;
    public ?string $accessToken = null;

    protected ?int $amount = null;
    protected ?string $currency = null;
    protected ?string $callbackUrl = null;
    protected ?string $paymentReference = null;
    protected ?string $email = null;
    protected ?array $channels = null;
    protected ?array $metaData = null;
    protected float $percentCharge = 1.5;

    public function __construct()
    {
        $this->initializeConfig();

        try {
            $this->accessToken = $this->fetchAccessToken();

            // Handle the case where the access token is null
            if (!$this->accessToken) {
                Log::warning('Nomba access token is null. Payment features may not work properly.');
            }

        } catch (\Exception $exception) {
            Log::error('Error initializing NombaGateway: ' . $exception->getMessage());
            $this->accessToken = null;
        }
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
        $this->clientId = $this->pubKey;
        $this->accountId = config('constant.nomba.accountId');

    }

    /**
     * Fetch the access token using client credentials.
     *
     * @return string|null
     */
    protected function fetchAccessToken(): ?string
    {

        try {
            $response = Http::timeout(10)
            ->withToken($this->secretKey)
                ->withHeaders(['accountId' => $this->accountId])
                ->post("{$this->url}auth/token/issue", [
                    'grant_type' => 'client_credentials',
                    'client_id' => $this->clientId,
                    'client_secret' => $this->secretKey,
                ]);

            if ($response->ok() && isset($response['data']['access_token'])) {
                return $response['data']['access_token'];
            }

            Log::error('Failed to fetch Nomba access token', ['response' => $response->json()]);
            return null;

        } catch (\Exception $exception) {
            Log::error('Network error while fetching Nomba access token: ' . $exception->getMessage());
            return null;
        }

    }
    /**
     * Initialize payment.
     *
     * @param array $data
     * @param array $options
     * @return array|null
     */
    public function initializePayment(array $data,array $options): ?array
    {
        $this->preparePaymentData($data, $options);

        $dataToSend = [
            'order'=>[
                'amount' => $this->amount,
                'currency' => $this->currency,
                'orderReference' => $this->paymentReference,
                'customerEmail' => $this->email,
                'callbackUrl' => $this->callbackUrl,
            ]
        ];


        $response = Http::withToken($this->accessToken)->withHeaders([
            'accountId' => $this->accountId,
        ])->post("{$this->url}checkout/order",$dataToSend);

        if (!$response->ok()) {
            Log::error('Failed to initiate order', ['response' => $response->json()]);
        }

        return $this->formatResponse($response, ['payment_url' => 'data.checkoutLink','orderReference'=>'data.orderReference']);
    }

    /**
     * Prepare payment data for initialization.
     *
     * @param array $data
     * @param array $options
     */
    protected function preparePaymentData(array $data, array $options): void
    {
        $this->amount = $data['amount'];
        $this->currency = $data['currency'];
        $this->paymentReference = $data['reference'];
        $this->email = $data['email'];
        $this->callbackUrl = $data['callback_url'];
    }

    /**
     * Verify payment by reference.
     *
     * @param string $reference
     * @return array|null
     */
    public function verifyPayment(string $reference):?array
    {

        $response = Http::withToken($this->accessToken)->withHeaders([
            'accountId' => $this->accountId,
        ])->get("{$this->url}checkout/transaction?idType=ORDER_REFERENCE&id={$reference}");

        if (!$response->ok()) {
            Log::error('Failed to verify checkout order', ['response' => $response->json()]);
        }
        return $this->formatResponse($response, [
            'id' => 'data.order.orderId',
            'status' => 'data.success',
            'amount' => 'data.order.amount',
            'currency' => 'data.order.currency',
            'reference' => 'data.order.orderReference'
        ]);

    }

    /**
     * Format the HTTP response.
     *
     * @param \Illuminate\Http\Client\Response $response
     * @param array $fields
     * @return array
     */
    /**
     * Format the HTTP response.
     *
     * @param \Illuminate\Http\Client\Response $response
     * @param array $fields
     * @return array
     */
    protected function formatResponse($response, array $fields): array
    {
        $data = [
            'status' => $response->ok() && ($response['code'] == '00' || $response['description'] == 'success'),
            'message' => $response['message']['message'] ?? '',
            'data' => [],
        ];

        // Extract required fields from the response
        foreach ($fields as $key => $pathOrCallback) {
            if (is_callable($pathOrCallback)) {
                $data['data'][$key] = $pathOrCallback($response->json());
            } else {
                $data['data'][$key] = data_get($response->json(), $pathOrCallback);
            }
        }

        // ✅ Calculate and add the fee only if 'amount' exists
        if (isset($data['data']['amount']) && is_numeric($data['data']['amount'])) {
            $fee = $data['data']['amount'] * $this->percentCharge / 100;
            $data['data']['fees'] = $fee;
        }

        // Set payment channel as 'Nomba'
        $data['data']['channel'] = 'Nomba';

        return $data;
    }



}
