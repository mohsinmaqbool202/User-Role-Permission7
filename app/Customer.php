<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class Customer extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = ['name','email', 'password','verified'];

     public function deliveryAddress()
    {
        return $this->hasOne('App\DeliveryAddress');
    }
}
