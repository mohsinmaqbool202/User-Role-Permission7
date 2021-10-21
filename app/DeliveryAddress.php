<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    protected $table = 'delivery_addresses';

    protected $fillable = [
            'customer_id',
            'customer_email',
            'name', 
            'address', 
            'city',
            'state',
            'pincode',
            'mobile'
    ];

    public function user()
    {
        return $this->belongsTo('App\Customer');
    }
}
