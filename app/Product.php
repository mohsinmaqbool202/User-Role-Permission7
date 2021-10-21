<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   
    protected $fillable = [
        'name',
        'code',
        'color',
        'price', 
        'detail',
        'image',
        'stock',
        'status'
    ];

    public function images()
    {
        return $this->hasMany('App\ProductImages');
    }

    public static function getProductStock($p_id){
        $product_stock = Product::select('stock')->where('id', $p_id)->first();
        
        if($product_stock != null)
        {
         return $product_stock->stock;
        } 
        return null;
    }

    public static function getProductStatus($p_id)
    {
        $product_status = Product::select('status')->where('id',$p_id)->first();
        return $product_status->status;
    }
}
