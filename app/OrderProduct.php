<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = 'order_products';

    public function order(){
        return $this->belongsTo('App\Order');
    }
    public function customer(){
        return $this->belongsTo('App\Customer');
    }
    public function cart(){
        return $this->belongsTo('App\Cart');
    }
}
