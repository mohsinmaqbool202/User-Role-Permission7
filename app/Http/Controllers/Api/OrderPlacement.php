<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use Session;
use App\Cart;
use App\Customer;
use App\DeliveryAddress;
use App\Order;
use App\OrderProduct;
use Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Response;

class OrderPlacement extends Controller
{
    public function addtocart(Request $request)
    {   
        #Check if Requested Quantity is available in stock or not
        $checkStock = Product::where('id',$request->product_id)->first();

        if($request->quantity > $checkStock->stock)
        {
            $resp = [

                'status' => 200,
                'msg'        => 'Requested quantity is not available.'
            ];
            return Response::json($resp);
        }

        #Saving session_id to Session
        $request["session_id"]  = STR::random(40);

        $cartItem = Cart::create($request->all());
        $resp = [

            'status' => 200,
            'msg'        => 'Product added to cart.'
        ];
        return Response::json($resp);
    }

    public function placeOrder(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();
            $customer = Customer::where('email', $request->email)->first();

            #prevent user from ordering out of stock products
            $customerCart = Cart::where('user_email', $request->email)->get();
            $grand_total = 0;

            foreach($customerCart as $cart){
                $grand_total += $cart->quantity * $cart->product->price;
                $product_stock = Product::getProductStock($cart->product_id);

                if($product_stock == 0 && $product_stock != null)
                {
                    Product::deleteProductFromCart($cart->product_code, $cart->session_id, $product_id = '');
                    return Response::json(['status'=> 200, 'msg'=> 'Some of the product is out of stock as some other customer has perchased it before you, please update your cart with some other product!']);
                }
                if($cart->quantity > $product_stock && $product_stock != null){
                    return Response::json(['status'=> 200, 'msg'=>'Your demanded quantity is more than product stock, please update your cart!']);
                }

                // prevent user from ordering disabled products
                $product_status = Product::getProductStatus($cart->product_id);
                if($product_status == 0){
                     Product::deleteProductFromCart($cart->product_code,$session_id,$cart->product_id);
                   return Response::json(['status'=> 200, 'msg'=> 'Disabled product removed from cart, please update your cart again!']);
                }
            }
      

            $order = new Order;
            $order->customer_id      = $customer->id;
            $order->payment_method   = 'COD';
            $order->grand_total      = $grand_total;
            $order->save();

            //saving order_product data
            $cart_data = Cart::where('user_email', $request->email)->get();
            foreach($cart_data as $cart){
                $order_product           = new OrderProduct;
                $order_product->order_id = $order->id;
                $order_product->customer_id  = $customer->id;
                $order_product->cart_id  = $cart->id;
                $order_product->save();
                
                //update product stock
                $old_stock = Product::where('id',$cart->product_id)->first();
                $new_stock = $old_stock->stock - $cart->quantity;
                if($new_stock < 0){
                  $new_stock = 0;
                }
                Product::where('id',$old_stock->id)->update(['stock'=>$new_stock]);
           }

            if($request['payment_method'] == 'COD'){
           
            #
            $orderDetail = Order::with('orders')->where('id', $order->id)->first();

            $email = $customer->email;
            $messageData = [
                'email'          => $customer->email,
                'name'           => $customer->name,
                'order_id'       => $order->id,
                'customer'       => $customer,
                'orderDetail'    => $orderDetail,
            ];

            Mail::send('emails.order', $messageData, function($message) use($email){
              $message->to($email)->subject('Order Placed');
             });
            
            #redirect user to thanks page after saving order
            return Response::json(['status'=>200, 'msg' => 'Order placed and email sent to your email']);
           }
           else{
            //redirect user to paypal page after saving order -remains to do
            return redirect('/paypal');
           }
        }
    }

     public function customerOrders(Request $request)
    {
        $email = $request->user()->email;
        $customer = Customer::where('email', $email)->first();

        $orders = Order::with('orders')->where('customer_id',$customer->id)->orderBy('id', 'desc')->get();
        
        $orders_arr = [];
        foreach($orders as $order)
        {
            $orders_detail['order_id'] = $order->id;
            $orders_detail['payment_method'] = $order->payment_method;
            $orders_detail['grand_total'] = $order->grand_total;

            $prod = '';
            foreach($order->orders as $pro)
            {
                $prod .= $pro->cart->product->name.',';
            }
            $orders_detail['products'] = $prod;
            $orders_arr[] = $orders_detail;
        }

        return Response::json(['status'=>200, 'orders'=>$orders_arr]);
    }
}
