<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class UserStoreCustomer extends Authenticatable
{
    use HasFactory,SoftDeletes,Notifiable;
    protected $guarded=[];

    protected $guard_name = 'customers';

    /**
     * Define the relationship: A customer can have many invoices.
     */
    public function invoices()
    {
        return $this->hasMany(UserStoreInvoice::class, 'customer');
    }
}
