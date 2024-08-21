<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Scout\Searchable;

class UserStore extends Model
{
    use HasFactory,SoftDeletes,Notifiable,Searchable;
    protected $guarded=[];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country', 'iso2');
    }

    public function state()
    {
        return $this->hasOne(State::class, 'iso2', 'state');
    }

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class, 'service', 'id');
    }

    public function toSearchableArray()
    {
        $state = $this->state()->first();

        $array = [
            'name' => $this->name,
            'description' => $this->description,
            'country' => $this->country ? $this->country()->first()->name : null,
            'state' => $state ? $state->name : null,
            'city' => $this->city,
            'address' => $this->address,
            'service' => $this->serviceType ? $this->serviceType->name : null,
        ];

        return $array;
    }
}
