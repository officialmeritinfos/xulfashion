<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAdView extends Model
{
    use HasFactory;
    protected $table='user_ads_views';
    protected $guarded=[];
}
