<?php

namespace App\Services;
use Illuminate\Http\Request;
use Response;
use App\Customer;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Cart;
use App\Product;
use App\WishList;


class IndexService
{
	public function gettAllProducts()
	{
		$result = ['status' => 200];

        try {

		    $result['products'] = Product::orderBy('id','DESC')->get();

        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return $result;
	}

	public function getProductById($id)
	{
		$result = ['status' => 200];

        try {

            $result['product'] = Product::find($id);
            if(!$result['product'])
            {
				$result = ['status' => 401];   
            }

            $result['images']  = $result['product']->images;

        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return $result;
	}

	public function saveProductToWishList(Request $request)
	{
		$result = ['status' => 200];

        try {

			$productCount = WishList::where('product_id', $request->product_id)
										->where('user_email',$request->user()->email)->count();

	        if($productCount > 0){

	            return $result = ['msg' => 'Product already included in wishlist.'];
	        }
	       
	        $request['user_email']  = $request->user()->email;
	        WishList::create($request->all());
	        $result = ['msg' => 'Product added in wishlist.'];

	    } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return $result;
	}

	public function viewAllWishList(Request $request)
	{
		$result = ['status' => 200];

        try {

			$user_email = $request->user()->email;
        	$result['wishLists'] = WishList::where('user_email', $user_email)->get();
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return $result;
	}

	public function deleteFromWishList($id)
	{
		$result = ['status' => 200];

        try {

			$wish = WishList::find($id);
			if(!$wish)
	        {
	            return $result = ['status'=>401, 'msg' => 'Product not found in wishlist'];

	        } 

	        $wish->delete();
	        $result = ['status'=>200, 'msg' => 'Product removed from wishlist'];

        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return $result;
	}
}