<?php

namespace App\Models;

use App\Services\CurrencyExchangeService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWithdrawal extends Model
{
    use HasFactory;
    protected $guarded=[];

    /**
     * Relationship with UserBank (Payout Account).
     */
    public function banks()
    {
        return $this->belongsTo(UserBank::class, 'paymentDetails', 'reference');
    }


    /**
     * Relationship with Fiat Model for the 'currency' field.
     */
    public function fiats()
    {
        return $this->belongsTo(Fiat::class, 'currency', 'code');
    }

    /**
     * Relationship with Fiat Model for the 'fromCurrency' field.
     */
    public function fiatFroms()
    {
        return $this->belongsTo(Fiat::class, 'fromCurrency', 'code');
    }

    /**
     * Relationship with Fiat Model for the 'toCurrency' field.
     */
    public function fiatTos()
    {
        return $this->belongsTo(Fiat::class, 'toCurrency', 'code');
    }

    /**
     * Get the user that owns the withdrawal.
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user');
    }

    /**
     * Convert a given amount to the specified target currency.
     *
     * @param float|string|null $amount
     * @param string $targetCurrency
     * @return float|null
     */
    public function convertToCurrency(float|string|null $amount, string $targetCurrency): ?float
    {
        if ($amount && $this->currency && $targetCurrency) {
            $rateData = (new CurrencyExchangeService())->getExchangeRate($this->currency);


            if ($rateData && isset($rateData[strtolower($this->currency)][strtolower($targetCurrency)])) {

                $exchangeRate = $rateData[strtolower($this->currency)][strtolower($targetCurrency)];

                return str_replace(',', '', number_format($amount * $exchangeRate, 2));
            }
            // Return null if exchange rate is unavailable
            return null;
        }
        return null;

    }
}
