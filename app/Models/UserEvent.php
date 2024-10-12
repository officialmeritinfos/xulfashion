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
}
