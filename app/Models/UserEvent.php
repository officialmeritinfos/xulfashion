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
     * Convert start date timestamp to a Carbon instance with time zone.
     *
     * @return Carbon
     */
    public function getStartDateAttribute($value)
    {
        return Carbon::createFromTimestamp($value, $this->eventTimeZone);
    }

    /**
     * Convert end date timestamp to a Carbon instance with time zone.
     *
     * @return Carbon|null
     */
    public function getEndDateAttribute($value)
    {
        return $value ? Carbon::createFromTimestamp($value, $this->eventTimeZone) : null;
    }

    /**
     * Convert start time timestamp to a Carbon instance with time zone.
     *
     * @return Carbon|null
     */
    public function getStartTimeAttribute($value)
    {
        return $value ? Carbon::createFromTimestamp($value, $this->eventTimeZone) : null;
    }

    /**
     * Convert end time timestamp to a Carbon instance with time zone.
     *
     * @return Carbon|null
     */
    public function getEndTimeAttribute($value)
    {
        return $value ? Carbon::createFromTimestamp($value, $this->eventTimeZone) : null;
    }

    /**
     * Convert recurrence end date timestamp to a Carbon instance with time zone.
     *
     * @return Carbon|null
     */
    public function getRecurrenceEndDateAttribute($value)
    {
        return $value ? Carbon::createFromTimestamp($value, $this->eventTimeZone) : null;
    }

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
    /**
     * Get combined start date and time as a Carbon instance.
     *
     * @return Carbon|null
     */
    public function getStartDateTimeAttribute()
    {
        // Fetch startDate and startTime, and return combined Carbon instance
        if ($this->startDate && $this->startTime) {
            return Carbon::createFromTimestamp($this->startDate, $this->eventTimeZone)
                ->setTimeFrom(Carbon::createFromTimestamp($this->startTime, $this->eventTimeZone));
        }

        return null;
    }
}
