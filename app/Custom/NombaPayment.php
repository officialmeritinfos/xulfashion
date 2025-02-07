<?php

namespace App\Custom;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NombaPayment
{
    protected string $secretKey;
    protected string $url;
    protected string $pubKey;
    protected string $clientId;
    protected string $accountId;
    protected ?string $accessToken = null;


    public function __construct()
    {
        $this->initializeConfig();
        $this->accessToken = $this->fetchAccessToken();
    }

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
        $response = Http::withToken($this->secretKey)->withHeaders([
            'accountId'=> $this->accountId
        ])
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
     * Fetches the list of banks from the external transfers API.
     *
     * This method sends a GET request to the API endpoint for fetching bank details.
     * The request includes an access token for authentication and an account ID in the headers.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response|null
     *         Returns the API response if the request is successful, or null if the request fails.
     *         Logs an error message with the response data in case of failure.
     */

    public function fetchBanks(): PromiseInterface|Response|null
    {
        $response = Http::withToken($this->accessToken)->withHeaders([
            'accountId'=> $this->accountId
        ])->get("{$this->url}transfers/banks");

        if ($response->ok()) {
            return $response;
        }
        Log::error('Failed to fetch banks', ['response' => $response->json()]);
        return null;
    }
    /**
     * Performs a bank account lookup to validate the provided bank details.
     *
     * This method sends a GET request to the bank lookup endpoint to validate the bank details
     * such as the bank code and account number. It uses the access token for authentication and
     * includes the account ID in the headers.
     *
     * @param array $data The bank account data containing:
     *                    - 'bankCode' (string): The code of the bank.
     *                    - 'accountNumber' (string): The bank account number to validate.
     *
     * @return \Illuminate\Http\Client\Response|null
     *         Returns the API response if the request is successful, or null if the request fails.
     *         Logs an error message with the response data in case of failure.
     */
    public function retrieveAccountDetail(array $data): ?Response
    {
        $response = Http::withToken($this->accessToken)->withHeaders([
            'accountId' => $this->accountId,
        ])->post("{$this->url}transfers/bank/lookup",$data);

        if ($response->ok()) {
            return $response;
        }
        Log::error('Failed to fetch account', ['response' => $response->json()]);
        return null;
    }

    public function transferToExternalAccount($data)
    {
        $response = Http::withToken($this->accessToken)->withHeaders([
            'accountId' => $this->accountId,
        ])->post("{$this->url}transfers/bank",$data);

        if ($response->ok()) {
            return $response;
        }
        Log::error('Failed to transfer to external account', ['response' => $response->json()]);
        return null;
    }

}
