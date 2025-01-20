<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserEventTicketBuyer extends Model
{
    use HasFactory,Notifiable;
    protected $guarded = [];

    /**
     * Define the relationship with the UserEventPurchase model.
     */
    public function purchases()
    {
        return $this->hasMany(UserEventPurchase::class, 'buyer', 'id');
    }
}
