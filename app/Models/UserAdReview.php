<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAdReview extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function reviewers()
    {
        return $this->belongsTo(User::class, 'reviewer', 'id');
    }

    // Define the relationship for the merchant
    public function merchants()
    {
        return $this->belongsTo(User::class, 'merchant', 'id');
    }
}
