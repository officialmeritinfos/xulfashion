<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAd extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded=[];

    public function service()
    {
        return $this->belongsTo(ServiceType::class,'serviceType');
    }

    public function users()
    {
        return $this->belongsTo(User::class,'user');
    }
}
