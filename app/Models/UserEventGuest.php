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
        return $this->belongsTo(UserEventPurchase::class, 'purchase','id');
    }

    // Relationship with UserEvent
    public function event()
    {
        return $this->belongsTo(UserEvent::class, 'event', 'id');
    }
    public function events()
    {
        return $this->belongsTo(UserEvent::class, 'event', 'id');
    }

    // Relationship with UserEventTicket
    public function ticket()
    {
        return $this->belongsTo(UserEventPurchaseTicket::class, 'ticket_id');
    }
}
