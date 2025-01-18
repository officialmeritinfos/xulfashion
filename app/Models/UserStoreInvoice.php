<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class UserStoreInvoice extends Model
{
    use HasFactory,Notifiable,SoftDeletes;
    protected $guarded=[];

    protected function items(): Attribute
    {
        return Attribute::make(
            get: fn ($value) =>explode(',', $value),
        );
    }
    protected function itemPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value) =>explode(',', $value),
        );
    }
    protected function itemQuantity(): Attribute
    {
        return Attribute::make(
            get: fn ($value) =>explode(',', $value),
        );
    }
    /**
     * Define the relationship: An invoice belongs to a customer.
     */
    public function customers()
    {
        return $this->belongsTo(UserStoreCustomer::class, 'customer');
    }
}
