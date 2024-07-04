<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class SystemStaff extends Model
{
    use HasFactory,Notifiable, HasRoles;
    protected $guarded=[];

    protected $guard_name = 'web';
}
