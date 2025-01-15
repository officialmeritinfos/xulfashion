<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CurrencyExchangeService
{
    protected $primaryBaseUrl = 'https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@';
    protected $fallbackBaseUrl = 'https://currency-api.pages.dev/v1/currencies/';

    /**
     * Fetch exchange rate for a given currency with fallback support.
     *
     * @param string $currency (e.g., 'ngn', 'usd', 'eur')
     * @return array|null
     */
    public function getExchangeRate(string $currency): ?array
    {
        $currency = strtolower($currency);
        $date = now()->format('Y-m-d');  // Dynamic date

        // Cache results for 1 hour
        return Cache::remember("exchange_rate_{$currency}_{$date}", 3600, function () use ($currency, $date) {
            // Attempt fetching from the primary API
            $primaryUrl = "{$this->primaryBaseUrl}{$date}/v1/currencies/{$currency}.json";
            $response = Http::timeout(5)->get($primaryUrl);

            if ($response->successful()) {
                return $response->json();
            }

            // If primary fails, fallback to the secondary API
            $fallbackUrl = "https://{$date}.currency-api.pages.dev/v1/currencies/{$currency}.json";
            $fallbackResponse = Http::timeout(5)->get($fallbackUrl);

            if ($fallbackResponse->successful()) {
                return $fallbackResponse->json();
            }

            // If both APIs fail, return null
            return null;
        });
    }
}
