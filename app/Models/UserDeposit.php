<?php

namespace App\Models;

use App\Services\CurrencyExchangeService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDeposit extends Model
{
    use HasFactory;
    protected $guarded=[];

    /**
     * Convert a given amount to the specified target currency.
     *
     * @param float|string|null $amount
     * @param string $targetCurrency
     * @return float|null
     */
    public function convertToCurrency(float|string|null $amount, string $targetCurrency): ?float
    {
        if (!$amount || !$this->currency || !$targetCurrency) {
            return null;
        }

        $exchangeService = new CurrencyExchangeService();
        $rateData = $exchangeService->getExchangeRate($this->currency);

        if ($rateData && isset($rates[strtolower($this->currency)][strtolower($targetCurrency)])) {

            $exchangeRate = $rates[strtolower($this->currency)][strtolower($targetCurrency)];
            return str_replace(',', '', number_format($amount * $exchangeRate, 2));
        }
        // Return null if exchange rate is unavailable
        return null;
    }
    /**
     * Get the user that owns the deposit.
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user');
    }
}
