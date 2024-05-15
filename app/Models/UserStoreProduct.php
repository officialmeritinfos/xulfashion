<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserStoreProduct extends Model
{
    use HasFactory,SoftDeletes,MassPrunable;
    protected $guarded=[];


    public function prunable()
    {
        return static::where('deleted_at', '=>', now()->subMonth());
    }

    protected function pruning(): void
    {
        $product = $this->id;

        UserStoreProductImage::where('product',$product->id)->delete();
        UserStoreProductColorVariation::where('product',$product->id)->delete();
        UserStoreProductSizeVariation::where('product',$product->id)->delete();
    }
}
