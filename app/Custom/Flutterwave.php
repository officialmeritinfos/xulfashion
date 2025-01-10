<?php

namespace App\Custom;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Flutterwave
{
    public $url;
    public $secKey;
    public $pubKey;
    public function __construct()
    {

        switch (config('constant.flutterwave.live')){
            case true:
                $pubKey=config('constant.flutterwave.pubKey');
                $secKey=config('constant.flutterwave.secKey');
                break;
            default:
                $pubKey=config('constant.flutterwave.testPubKey');
                $secKey=config('constant.flutterwave.testSecKey');
                break;
        }

        $this->url = config('constant.flutterwave.url');
        $this->pubKey = $pubKey;
        $this->secKey = $secKey;
    }
    //create a virtual account
    public function createVirtualAccount($data): PromiseInterface|Response
    {
        return Http::withHeaders([
            "Authorization" =>'Bearer '.$this->secKey
        ])->post($this->url.'virtual-account-numbers',$data);
    }
    //verify transaction
    public function verifyTransaction($id)
    {
        return Http::withHeaders([
            "Authorization" =>'Bearer '.$this->secKey
        ])->get($this->url.'transactions'.$id.'/verify');
    }
    //initiate withdrawal
    public function initiateWithdrawal($data): PromiseInterface|Response
    {
        return Http::withHeaders([
            "Authorization" =>'Bearer '.$this->secKey
        ])->post($this->url.'transfers',$data);
    }
    //add beneficiary
    public function addBeneficiary($data): PromiseInterface|Response
    {
        return Http::withHeaders([
            "Authorization" =>'Bearer '.$this->secKey
        ])->post($this->url.'beneficiaries',$data);
    }
    /**
     * Verifies a bank account number by resolving it through the API.
     *
     * This method sends a POST request to the account resolution endpoint to validate the bank
     * account details, including the account number and associated bank code. It uses a
     * Bearer token for authentication.
     *
     * @param array $data The bank account data containing:
     *                    - 'accountNumber' (string): The bank account number to verify.
     *                    - 'bankCode' (string): The code of the bank associated with the account.
     *
     * @return \Illuminate\Http\Client\Response|null
     *         Returns the API response if the request is successful, or null if the request fails.
     *         Logs an informational message with the response data in case of failure.
     */
    public function verifyAccountNumber($data): ?Response
    {
        $response =  Http::withHeaders([
            "Authorization" =>'Bearer '.$this->secKey
        ])->post($this->url.'accounts/resolve',$data);

        if ($response->ok()) {
            return $response;
        }
        Log::info('Failed to retrieve account', ['response' => $response->json()]);
        return null;
    }
    /**
     * Fetches the list of banks for a specific country from the external API.
     *
     * This method sends a GET request to the API endpoint for fetching bank details
     * based on the provided country. The request includes an authorization token
     * in the headers for authentication.
     *
     * @param string $country The country code for which the bank list is to be fetched.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response|null
     *         Returns the API response containing the list of banks for the specified country.
     */

    public function fetchBank($country): PromiseInterface|Response|null
    {
        $response =  Http::withHeaders([
            "Authorization" =>'Bearer '.$this->secKey
        ])->get($this->url.'banks/'.$country);

        if ($response->ok()) {
            return $response;
        }
        Log::info('Failed to fetch banks', ['response' => $response->json()]);
        return null;
    }
    public function fetchBankBranches($id): PromiseInterface|Response|null
    {
        $response =  Http::withHeaders([
            "Authorization" =>'Bearer '.$this->secKey
        ])->get("{$this->url}banks/{$id}/branches");

        if ($response->ok()) {
            return $response;
        }
        Log::info('Failed to fetch banks branches', ['response' => $response->json()]);
        return null;
    }
}
