<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserStoreOrderBreakdown extends Model
{
    use HasFactory;
    protected $guarded=[];

    // UserStoreOrderBreakdown
    public function product(): BelongsTo
    {
        return $this->belongsTo(UserStoreProduct::class,'product');
    }
    public function products()
    {
        return $this->belongsTo(UserStoreProduct::class, 'product', 'id');
    }
}
