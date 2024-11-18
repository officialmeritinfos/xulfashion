<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserEventGuest extends Model
{
    use HasFactory,Notifiable;
    protected $guarded=[];

    public function purchase()
    {
        return $this->belongsTo(UserEventPurchase::class, 'purchase');
    }

    // Relationship with UserEvent
    public function event()
    {
        return $this->belongsTo(UserEvent::class, 'event');
    }

    // Relationship with UserEventTicket
    public function ticket()
    {
        return $this->belongsTo(UserEventTicket::class, 'ticket_id');
    }
}
