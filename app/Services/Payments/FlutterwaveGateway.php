<?php

namespace App\Services\Payments;

use App\Contracts\PaymentGatewayInterface;
use Illuminate\Support\Facades\Http;

class FlutterwaveGateway implements PaymentGatewayInterface
{
    protected string $secretKey;
    protected string $url;
    protected string $pubKey;

    protected ?float $amount = null;
    protected ?string $currency = null;
    protected ?string $callbackUrl = null;
    protected ?string $paymentReference = null;
    protected ?string $email = null;
    protected ?string $channels = null;

    public function __construct()
    {
        $this->initializeConfig();
    }

    /**
     * Initialize configuration values for Flutterwave.
     */
    protected function initializeConfig(): void
    {
        $isLive = config('constant.flutterwave.live');

        $this->url = config('constant.flutterwave.url');
        $this->pubKey = $isLive
            ? config('constant.flutterwave.livePubKey')
            : config('constant.flutterwave.testPubKey');
        $this->secretKey = $isLive
            ? config('constant.flutterwave.liveSecKey')
            : config('constant.flutterwave.testSecKey');
    }

    /**
     * Initialize payment on Flutterwave.
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
            'tx_ref' => $this->paymentReference,
            'redirect_url' => $this->callbackUrl,
            'customer' => [
                'email' => $this->email,
            ],
            'payment_options' => $this->channels,
            'configurations' => [
                'session_duration' => 30,
                'max_retry_attempt' => 5,
            ],
        ];

        $response = Http::withToken($this->secretKey)
            ->post("{$this->url}payments", $dataToSend);

        return $this->formatResponse($response, ['payment_url' => 'data.link']);
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
            ->get("{$this->url}transactions/{$reference}/verify");

        return $this->formatResponse($response, [
            'id' => 'data.id',
            'status' => 'data.status',
            'amount' => 'data.amount',
            'channel' => 'data.payment_type',
            'currency' => 'data.currency',
            'fees' => ['data.app_fee', 'data.merchant_fee'],
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
        $this->amount = $data['amount'];
        $this->currency = $data['currency'];
        $this->paymentReference = $data['reference'];
        $this->email = $data['email'];
        $this->callbackUrl = $data['callback_url'];
        $this->channels = implode(',', $options['channels']);
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
            'status' => $response->ok() && ($response['status'] === 'success'),
            'message' => $response['message'] ?? '',
            'data' => [],
        ];

        foreach ($fields as $key => $path) {
            if (is_array($path)) {
                // Handle summing values for fields like 'fees'
                $data['data'][$key] = array_reduce($path, function ($carry, $item) use ($response) {
                    return $carry + data_get($response, $item, 0);
                }, 0);
            } else {
                $data['data'][$key] = data_get($response, $path);
            }
        }

        return $data;
    }
}
