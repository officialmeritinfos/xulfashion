<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAdReviewResponse extends Model
{
    use HasFactory;
    protected $table = 'user_ad_reviews_responses';
    protected $guarded=[];


    /**
     * Get the review that owns the response.
     */
    public function review()
    {
        return $this->belongsTo(UserAdReview::class, 'review', 'id');
    }

    /**
     * Get the user that owns the response.
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user', 'id');
    }
}
