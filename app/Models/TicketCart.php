<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketCart extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Define the relationship between TicketCart and TicketCartItem.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(TicketCartItem::class, 'ticket_cart_id');
    }
}
