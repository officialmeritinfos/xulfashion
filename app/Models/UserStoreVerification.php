<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStoreVerification extends Model
{
    use HasFactory;
    protected $guarded=[];

    /*
     * Relationship between model and Store
     */

    public function stores()
    {
        return $this->belongsTo(UserStore::class,'store','id');
    }
}
