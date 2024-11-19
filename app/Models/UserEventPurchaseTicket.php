<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEventPurchaseTicket extends Model
{
    use HasFactory;

    protected $guarded=[];

    // Relationship with UserEventTicket
    public function ticket()
    {
        return $this->belongsTo(UserEventTicket::class, 'ticket_id');
    }

    // Relationship with UserEvent
    public function event()
    {
        return $this->belongsTo(UserEvent::class, 'event_id');
    }

    // Relationship with UserEventPurchase
    public function purchase()
    {
        return $this->belongsTo(UserEventPurchase::class, 'user_event_purchase_id');
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the guests associated with the ticket.
     */
    public function guests()
    {
        return $this->hasMany(UserEventGuest::class, 'ticket_id', 'id');
    }
}
