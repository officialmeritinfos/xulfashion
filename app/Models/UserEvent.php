<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserEvent extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];

    /**
     * Define the relationship between UserEvent and UserEventTicket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany(UserEventTicket::class, 'event_id');
    }

    /**
     * Define the relationship between UserEvent and User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user', 'id');
    }

    public function purchases()
    {
        return $this->hasMany(UserEventPurchase::class, 'event_id');
    }
    public function state()
    {
        return $this->belongsTo(State::class, 'state', 'iso2');
    }

    public function country()
    {
        return $this->hasOneThrough(Country::class, State::class, 'iso2', 'iso2', 'state', 'country_code');
    }
    public function purchaseTickets()
    {
        return $this->hasMany(UserEventPurchaseTicket::class, 'event_id');
    }
    public function guests()
    {
        return $this->hasMany(UserEventGuest::class, 'event');
    }
    //hide venue or not
    public function hideVenue()
    {
        return $this->hideVenue==1;
    }
}
