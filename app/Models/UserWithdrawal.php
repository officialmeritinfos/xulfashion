<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWithdrawal extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function banks()
    {
        return $this->belongsTo(UserBank::class, 'payoutAccount', 'id');
    }
}
