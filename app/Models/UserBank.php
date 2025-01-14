<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserBank extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded=[];

    /**
     * Boot method to handle model events.
     */
    protected static function boot()
    {
        parent::boot();

        // Hook into the creating event to set isPrimary
        static::creating(function ($userBank) {
            $userBank->isPrimary = self::isFirstAccount($userBank->user) ? 1 : 2;
        });
    }

    /**
     * Check if this is the first bank account for the user.
     *
     * @param int $userId
     * @return bool
     */
    public static function isFirstAccount($userId)
    {
        return self::where('user', $userId)->doesntExist();
    }
    // Relationship with Fiat model
    public function fiat()
    {
        return $this->belongsTo(Fiat::class, 'currency', 'code');
    }

    // Relationship with Country model through Fiat
    public function country()
    {
        return $this->hasOneThrough(
            Country::class,
            Fiat::class,
            'code',      // Foreign key on Fiat table
            'iso2',      // Foreign key on Country table
            'currency',  // Local key on UserBank table
            'country'    // Local key on Fiat table
        );
    }
}
