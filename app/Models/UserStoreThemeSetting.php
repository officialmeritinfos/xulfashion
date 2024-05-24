<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStoreThemeSetting extends Model
{
    use HasFactory;
    protected $guarded=[];

//    protected $casts=[
//        'perkSection'=>'array',
//        'perkTitle'=>'array',
//        'perkContent'=>'array'
//    ];

    protected function perkTitle(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => json_decode($value),
            set: fn (string $value) => json_encode($value),
        );
    }
    protected function perkIcon(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => json_decode($value),
            set: fn (string $value) => json_encode($value),
        );
    }
    protected function perkContent(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => json_decode($value),
            set: fn (string $value) => json_encode($value),
        );
    }
}
