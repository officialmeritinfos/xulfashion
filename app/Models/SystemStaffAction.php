<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;

class SystemStaffAction extends Model
{
    use HasFactory,MassPrunable;
    protected $guarded=[];

    public function prunable()
    {
        return static::where('created_at', '=>', now()->subMonth());
    }
}
