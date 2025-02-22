<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStoreCatalogCategory extends Model
{
    use HasFactory;
    protected $table='user_store_catalog_categories';
    protected $guarded=[];

    public function products()
    {
        return $this->hasMany(UserStoreProduct::class, 'category');
    }

    public function productCount()
    {
        return $this->products()->count();
    }
}
