<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketCartItem extends Model
{
    use HasFactory;
    protected  $guarded =[];


    /**
     * Define the relationship between TicketCartItem and TicketCart.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticketCart()
    {
        return $this->belongsTo(TicketCart::class, 'ticket_cart_id');
    }

    /**
     * Define the relationship between TicketCartItem and UserEventTicket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userEventTicket()
    {
        return $this->belongsTo(UserEventTicket::class, 'user_event_ticket_id');
    }
}
