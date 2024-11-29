<?php

namespace App\Services\Payments;

use App\Contracts\PaymentGatewayInterface;
use Illuminate\Support\Facades\Http;

class PaystackGateway implements PaymentGatewayInterface
{
    protected string $secretKey;
    protected string $url;
    protected string $pubKey;

    protected ?int $amount = null;
    protected ?string $currency = null;
    protected ?string $callbackUrl = null;
    protected ?string $paymentReference = null;
    protected ?string $email = null;
    protected ?array $channels = null;
    protected ?array $metaData = null;

    public function __construct()
    {
        $this->initializeConfig();
    }

    /**
     * Initialize configuration values for Paystack.
     */
    protected function initializeConfig(): void
    {
        $isLive = config('constant.paystack.live');

        $this->url = config('constant.paystack.url');
        $this->pubKey = $isLive
            ? config('constant.paystack.livePubKey')
            : config('constant.paystack.testPubKey');
        $this->secretKey = $isLive
            ? config('constant.paystack.liveSecKey')
            : config('constant.paystack.testSecKey');
    }

    /**
     * Initialize payment on Paystack.
     *
     * @param array $data
     * @param array $options
     * @return array
     */
    public function initializePayment(array $data, array $options): array
    {
        $this->preparePaymentData($data, $options);

        $dataToSend = [
            'amount' => $this->amount,
            'currency' => $this->currency,
            'reference' => $this->paymentReference,
            'email' => $this->email,
            'callback_url' => $this->callbackUrl,
            'channels' => $this->channels,
            'metadata' => $this->metaData,
        ];

        $response = Http::withToken($this->secretKey)
            ->post("{$this->url}transaction/initialize", $dataToSend);

        return $this->formatResponse($response, ['payment_url' => 'data.authorization_url']);
    }

    /**
     * Verify payment by reference.
     *
     * @param string $reference
     * @return array
     */
    public function verifyPayment(string $reference): array
    {
        $response = Http::withToken($this->secretKey)
            ->get("{$this->url}transaction/verify/{$reference}");

        return $this->formatResponse($response, [
            'id' => 'data.id',
            'status' => 'data.status',
            'amount' => fn($data) => $data['data']['amount'] / 100,
            'channel' => 'data.channel',
            'currency' => 'data.currency',
            'fees' => fn($data) => ($data['data']['fees'] ?? 0) / 100,
        ]);
    }

    /**
     * Prepare payment data for initialization.
     *
     * @param array $data
     * @param array $options
     */
    protected function preparePaymentData(array $data, array $options): void
    {
        $this->amount = $data['amount'] * 100; // Convert to kobo
        $this->currency = $data['currency'];
        $this->paymentReference = $data['reference'];
        $this->email = $data['email'];
        $this->callbackUrl = $data['callback_url'];
        $this->channels = str_replace('transfer', 'bank_transfer', $options['channels']);
        $this->metaData = $options['metadata'] ?? [];
    }

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
            'status' => $response->ok() && ($response['status'] === true || $response['status'] === 'success'),
            'message' => $response['message'] ?? '',
            'data' => [],
        ];

        foreach ($fields as $key => $pathOrCallback) {
            if (is_callable($pathOrCallback)) {
                $data['data'][$key] = $pathOrCallback($response->json());
            } else {
                $data['data'][$key] = data_get($response->json(), $pathOrCallback);
            }
        }

        return $data;
    }
}
