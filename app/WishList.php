<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{
    protected $fillable = ['product_id', 'user_email'];
    
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
