<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBank extends Model
{
    use HasFactory;
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
}
