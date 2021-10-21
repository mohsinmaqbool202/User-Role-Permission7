<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\ProductImages;
use App\WishList;
use Session;


class IndexController extends Controller
{
    public function index()
    {   
        $products = Product::all();
        return view('index', compact('products'));
    }

    public function productDetail($id)
    {
        $productDetail = Product::where('id', $id)->first();
        if(!$productDetail){
            abort(404);
        }

        #product images
        $product_imgs = $productDetail->images;
        return view('products.detail', compact('productDetail','product_imgs'));

    }

    #wish list functions
    public function addToWishList(Request $request)
    {
        $productCount = WishList::where('product_id', $request->product_id)->count();
        if($productCount > 0){
            echo 'false'; die;
        }
       
        $request['user_email']  = $request->user_email;
        WishList::create($request->all());
        echo 'true'; die;
    }

    public function viewWishList()
    {
        $user_email = Session::get('customerSession');
        $wishLists = WishList::where('user_email', $user_email)->get();

        return view('products.wish_list',compact('wishLists'));
    }

    public function deleteWishList($id)
    {
        $wish = WishList::find($id);
        if(!$wish)
        {
          abort(404);
        }

        $wish->delete();
        return back()->with('flash_message_success', 'Product has been removed from your wishlist');
    }

    public static function CheckInWishlist($p_id)
    {
        $user_email = Session::get('customerSession');
        return   WishList::where([
                                    ['product_id', $p_id],
                                    ['user_email',$user_email]
                                ])->count();
    }
}
