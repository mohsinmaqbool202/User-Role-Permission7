<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;

class Cart extends Model
{
    protected $fillable = ['product_id', 'quantity', 'user_email', 'session_id'];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public static function cartCount()
    {
        $session_id = Session::get('session_id');
        $cartCount = Cart::where('session_id', $session_id)->sum('quantity');

        return $cartCount;
    }
    
}
