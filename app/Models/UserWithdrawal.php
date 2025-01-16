<?php

namespace App\Models;

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
}
