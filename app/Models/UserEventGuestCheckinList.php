<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEventGuestCheckinList extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function guest()
    {
        return $this->belongsTo(UserEventGuest::class, 'guest_id');
    }

    public function event()
    {
        return $this->belongsTo(UserEventGuest::class, 'event_id');
    }

}
