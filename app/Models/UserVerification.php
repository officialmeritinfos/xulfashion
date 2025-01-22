<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVerification extends Model
{
    use HasFactory;
    protected $guarded=[];

    /**
     * Relationship between model and User
     */
    public function users()
    {
        return $this->belongsTo(User::class,'user','id');
    }
    /**
     * Relationship between model and document type
     */
    public function docTypes()
    {
        return $this->belongsTo(UserVerificationDocumentType::class,'docType','slug');
    }
}
