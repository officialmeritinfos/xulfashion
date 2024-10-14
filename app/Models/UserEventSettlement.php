<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEventSettlement extends Model
{
    use HasFactory;
    protected $guarded=[];

    /**
     * Define the relationship to UserBank.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bank()
    {
        return $this->belongsTo(UserBank::class, 'payoutAccount', 'id');
    }
}
