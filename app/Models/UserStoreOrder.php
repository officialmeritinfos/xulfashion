<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserStoreOrder extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function breakdowns(): HasMany
    {
        return $this->hasMany(UserStoreOrderBreakdown::class,'orderId');
    }

    public function customers()
    {
        return $this->belongsTo(UserStoreCustomer::class, 'customer', 'id');
    }

}
