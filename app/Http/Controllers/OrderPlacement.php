<?php

namespace App\Http\Controllers;

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

class OrderPlacement extends Controller
{
    function __construct()
    {
        $this->middleware('permission:view-all-orders', ['only' => ['viewOrders']]);
    }


    public function addtocart(Request $request)
    {   

        #Check if Requested Quantity is available in stock or not
        $checkStock = Product::where('id',$request->product_id)->first();

        if($request->quantity > $checkStock->stock)
        {
            $resp = [

                'cart_count' => 'Cart('.count((array) session('cart')).')',
                'msg'        => 'Requested quantity is not available.'
            ];
            return $resp;
        }

        #Saving session_id to Session
        $session_id = Session::get('session_id');
        
        if(Session::has('session_id')){
            $request["session_id"] = $session_id;
            Session::put('session_id', $request["session_id"]);
        }
        else{
            $request["session_id"]  = STR::random(40);    
            Session::put('session_id', $request["session_id"]);
        }
       
        #Check if same product is already present in cart with same size and same session _id
        $checkCart = Cart::where('product_id', $request->product_id)->where('session_id',$session_id)->count();

        if($checkCart > 0){
            $resp = [

                'cart_count' => 'Cart('.count((array) session('cart')).')',
                'msg'        => 'Product already exist in cart.'
            ];
            return $resp;
        }
        else{

            $cartItem = Cart::create($request->all());
            
            $cart = session()->get('cart', []);
  
            if(isset($cart[$cartItem->id])) {
                $cart[$id]['quantity']++;
            } else {
                $cart[$cartItem->id] = [
                    "name"     => $checkStock->name,
                    "quantity" => $cartItem->quantity,
                    "price"    => $checkStock->price,
                    "image"    => $checkStock->image
                ];
            }
            session()->put('cart', $cart);
            

            $resp = [

                'cart_count' => 'Cart('.count((array) session('cart')).')',
                'msg'        => 'Product added to cart.'
            ];
            return $resp;
        }
    }


    public function cart()
    {   
        $session_id = Session::get('session_id');
        $userCart = Cart::where('session_id', $session_id)->get();
        return view('products.cart', compact('userCart'));
    }

    public function deleteCartProduct(Request $request)
    {

        $cartItem = Cart::find($request->cart_id);
        $cartItem->delete();

        if($request->cart_id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->cart_id])) {
                unset($cart[$request->cart_id]);
                session()->put('cart', $cart);
            }
            // session()->flash('flash_message_success', 'Product removed successfully');

            $session_id = Session::get('session_id');
            $userCart = Cart::where('session_id', $session_id)->get();
            $total_amount = 0;
            foreach($userCart as $cart)
            {
                $total_amount += $cart->product->price * $cart->quantity;
            }

            $resp = [
                'msg'         =>  'product removed from cart',
                'cart_count' => 'Cart('.count((array) session('cart')).')',
                'grand_total' => 'PKR:'.$total_amount,
            ];

            return $resp;
        }
    }

    public function updateCartQuantity(Request $request)
    {
        
        $getCartDetails = Cart::find($request->cart_id);
        $Product = Product::where('id', $getCartDetails->product_id)->first();
        
        $updated_quantity = $getCartDetails->quantity + $request->quantity;

        #check ifupdated quantity ==0
        if($updated_quantity == 0)
        {
            return $cartArr = [
                'msg'         =>  'abcc',
            ];

            return $cartArr;
        }

        if($Product->stock >= $updated_quantity)
        {
            #update quantity
            Cart::where('id', $request->cart_id)->increment('quantity', $request->quantity);

            $session_id = Session::get('session_id');
            $userCart = Cart::where('session_id', $session_id)->get();
            $cartCount = Cart::where('session_id', $session_id)->sum('quantity');
            $total_amount = 0;
            foreach($userCart as $cart)
            {
                $total_amount += $cart->product->price * $cart->quantity;
            }

            $cartArr = [
                'msg'         =>  true,
                'quantity'    =>  $updated_quantity,
                'sub_total'   => 'PKR:'.$updated_quantity * $Product->price,
                'grand_total' => 'PKR:'.$total_amount,
                'cart_count'  =>  $cartCount
            ];

            return $cartArr;
        }
        else
        {
            $cartArr = [
                'msg'         =>  false,
            ];

            return $cartArr;
        }   
    }

    public function checkout(Request $request)
    {
        $email = Session::get('customerSession');
        $customer = Customer::where('email', $email)->first();
        
        //check if shipping address already exist
        $shipping_address = DeliveryAddress::where('customer_id', $customer->id)->first();

         //For post Request
        if($request->isMethod('post'))
        {
            $this->validate($request, [

                'billing_name'        => 'required',
                'billing_address'     => 'required',
                'billing_city'        => 'required',
                'billing_state'       => 'required',
                'billing_pincode'     => 'required',
                'billing_mobile'      => 'required',
                'shipping_name'       => 'required',
                'shipping_address'    => 'required',
                'shipping_city'       => 'required',
                'shipping_state'      => 'required',
                'shipping_pincode'    => 'required',
                'shipping_mobile'     => 'required',

            ]);

            //update customer table with billing address data
            Customer::where('id', $customer->id)->update([
                                                       'name'=> $request->billing_name, 
                                                       'address'=>$request->billing_address, 
                                                       'city'=> $request->billing_city, 
                                                       'state'=> $request->billing_state, 
                                                       'pincode'=>$request->billing_pincode, 
                                                       'mobile'=>$request->billing_mobile
                                                    ]);

            
            //Now Insert Shipping data to delivery_address table
            if($shipping_address !=''){
              //update record
            DeliveryAddress::where('customer_id', $customer->id)->update([
                                                        'name'=> $request->shipping_name, 
                                                        'address'=>$request->shipping_address, 
                                                        'city'=> $request->shipping_city, 
                                                        'state'=> $request->shipping_state, 
                                                        'pincode'=>$request->shipping_pincode, 
                                                        'mobile'=>$request->shipping_mobile
                                                    ]);
            }
            else{
                $new_address = new DeliveryAddress;
                $new_address->customer_id     = $customer->id;
                $new_address->customer_email  = $customer->email;
                $new_address->name        = $request->shipping_name;
                $new_address->address     = $request->shipping_address;
                $new_address->city        = $request->shipping_city;
                $new_address->state       = $request->shipping_state;
                $new_address->pincode     = $request->shipping_pincode;
                $new_address->mobile      = $request->shipping_mobile;
                $new_address->save();  
            }

             //check pincode
            // $pincodeCount = DB::table('pincodes')->where('pincode', $request->shipping_pincode)->count();
            // if($pincodeCount == 0){
            //   return redirect()->back()->with('flash_message_error', 'Your location/pincode is not available for delivery, Please choose valid pincode');
            // }
            
            return redirect('/order-review');
        } 
        
        return view('products.checkout', compact('customer', 'shipping_address'));
    }

    public function orderReview()
    {
        $email = Session::get('customerSession');
        $customer = Customer::where('email', $email)->first();

        #shipping address
        $shipping_address = DeliveryAddress::where('customer_id', $customer->id)->first();

        #cart items
        $session_id = Session::get('session_id');
        $customerCart = Cart::where('session_id', $session_id)->get();

        return view('products.order_review', compact('customer', 'shipping_address', 'customerCart'));
    }

    public function placeOrder(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();
            $email = Session::get('customerSession');
            $customer = Customer::where('email', $email)->first();
            $session_id = Session::get('session_id');

            #prevent user from ordering out of stock products
            $customerCart = Cart::where('session_id', $session_id)->get();
          
            foreach($customerCart as $cart){

                $product_stock = Product::getProductStock($cart->product_id);

                if($product_stock == 0 && $product_stock != null)
                {
                    Product::deleteProductFromCart($cart->product_code, $session_id, $product_id = '');
                    return redirect('/cart')->with('flash_message_error', 'Some of the product is out of stock as some other customer has perchased it before you, please update your cart with some other product!');
                }
                if($cart->quantity > $product_stock && $product_stock != null){
                    return redirect('/cart')->with('flash_message_error', 'Your demanded quantity is more than product stock, please update your cart!');
                }

                // prevent user from ordering disabled products
                $product_status = Product::getProductStatus($cart->product_id);
                if($product_status == 0){
                     Product::deleteProductFromCart($cart->product_code,$session_id,$cart->product_id);
                    return redirect('/cart')->with('flash_message_error', 'Disabled product removed from cart, please update your cart again!');
                }
            }
      
            // $request['grand_total'] = Product::getGrandTotal();
            Session::put('grand_total', $request['grand_total']);

            $order = new Order;
            $order->customer_id      = $customer->id;
            // $order->shipping_charges = $request->shipping_charges;
            // $order->coupon_code      = $request->coupon_code;
            // $order->coupon_amount    = $request->coupon_amount;
            $order->payment_method   = $request->payment_method;
            $order->grand_total      = $request['grand_total'];
            $order->save();

            //saving order_product data
            $cart_data = Cart::where('session_id', Session::get('session_id'))->get();
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

            //removin session values
            Session::forget('session_id');
            Session::forget('cart');

            Session::put('order_id', $order->id);
            Session::put('grand_total', $request->grand_total);

            if($data['payment_method'] == 'COD'){
           
            #
            $orderDetail = Order::with('orders')->where('id', $order->id)->first();

            $email = $customer->email;
            $messageData = [
                'email'          => $customer->email,
                'name'           => $customer->name,
                'order_id'       => $order->id,
                'customer'           => $customer,
                'orderDetail'    => $orderDetail,
            ];

            Mail::send('emails.order', $messageData, function($message) use($email){
              $message->to($email)->subject('Order Placed');
             });
            
            #redirect user to thanks page after saving order
            return 'your order has placed';
           }
           else{
            //redirect user to paypal page after saving order -remains to do
            return redirect('/paypal');
           }
        }
    }

    public function customerOrders()
    {
        $email = Session::get('customerSession');
        $customer = Customer::where('email', $email)->first();

        $orders = Order::with('orders')->where('customer_id',$customer->id)->orderBy('id', 'desc')->get();
        return view('orders.customer_orders', compact('orders'));
    }

    #show all orders on admin dashboard
    public function viewOrders(Request $request)
    {
        $orders = Order::with('orders')->orderBy('id', 'desc')->paginate();
        // dd($orders);
        return view('admin.orders.view_orders', compact('orders'))
                                            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    static public function orderStatus($id)
    {
        $status = Order::find($id)->order_status;
        switch ($status) {
            case 1:
                return "New";
                break;
            case 2:
                return "Shipped";
                break;
            case 3:
                return "Delivered";
                break;
            case 4:
                return "Cancelled";
                break;
            
            default:
                return "New";
                break;
        }
    }
}
