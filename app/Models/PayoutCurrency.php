<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayoutCurrency extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Retrieve the payout currency by the given currency code.
     * If the specified currency is not found, it defaults to the provided fallback currency.
     *
     * @param string $currency The currency code to look up.
     * @param string $default  The fallback currency code (default is 'USD').
     * @return \App\Models\PayoutCurrency|null The matching payout currency or the default.
     */
    public static function getCurrencyOrDefault($currency, $default = 'USD'): ?PayoutCurrency
    {
        return self::where('currency', $currency)->where('is_bank',true)->first()
            ?? self::where('currency', $default)->first();
    }

}
