<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Response;
use App\Customer;
use Auth;
use Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Cart;
use App\Product;
use App\Services\IndexService;

class CustomerController extends Controller
{

    public function signup(Request $request)
    {
        $this->validate($request, [

            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]); 

        $data = $request->all();
        
        $userCount = Customer::where('email', $request->email)->count();
        if($userCount > 0)
        {
            return Response::json(['error'=>'true', 'data'=>'Email Already Exists.']);
        }
        else
        {
            $request["password"] = md5($request->password);
            Customer::create($request->all());
            return Response::json(['error'=> 'false', 'data'=>'You are signed up successfully']);
        }
    }

    public function login(Request $request)
    {
        $data = $request->input();
        $customer = Customer::where('email', $data['email'])->first();
        
        if($customer  && $customer->verified == 0)
        {
            return response()->json([
                'status' => 401,
                'message' => 'Your account is not active.Plz confirm your email!'
            ]);
        }



        $customerCount = Customer::where(['email'=> $data['email'], 'password'=> md5($data['password'])])->count();

       if($customerCount > 0)
       {
            Session::put('customerSession', $data['email']);
            if(Session::has('session_id'))
            {
                $session_id = Session::get('session_id');
                Cart::where('session_id', $session_id)->update(['user_email'=>$data['email']]);
            }

            $accessToken = $customer->createToken('authToken')->accessToken;

            return response()->json([
                'status'   => 200,
                'user'   => $customer,
                'access_token' => $accessToken,
                'token_type' => 'Bearer'
            ]);
            
        }
        else{
            return response()->json([
                'status'   => 401,
                'msg' => 'This email does not exist',
            ]);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return Response::json(['status'=> 200, 'data'=>'Your are logged out.']);

    }

    public function forgot(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
        ]);
        
        Password::sendResetLink(['email'=> $request->email]);
        return Response::json(['status'=>200, 'msg'=>'Reset password link send on your email id.']);
    }

    public function reset(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|max:25',
            'token' => 'required'
        ]);

        Customer::where('email', $request->email)->update(['password'=>md5($request->password)]);
        return Response::json(['status'=>200, 'msg'=>'Reset password link send on your email id.']);
    }

    public function account(Request $request)
    {
        $email = $request->user()->email;
        $customer = Customer::where('email', $email)->first();

        if($request->isMethod('post'))
        {
            $customer = Customer::find($customer->id);
            $customer->name = $request->name;
            $customer->address = $request->address;
            $customer->city = $request->city;
            $customer->state = $request->state;
            $customer->pincode = $request->pincode;
            $customer->mobile = $request->mobile;

            $customer->save();
            return Response::json(['status'=> 200, 'msg'=> 'Accoutn updated.']);
        }

        //for get request
        return Response::json(['status'=> 200, 'data'=> $customer]);
    }

    public function updatePassword(Request $request)
    {
        $data = $request->all();
        $email = $request->user()->email;
        $customer = Customer::where('email', $email)->first();

        #checking customer new & confirm pwd
        if($data['new_pwd'] != $data['confirm_pwd'])
        {
            return Response::json(['status'=> 200, 'data'=> 'Your new and confirm password are not correct']);

        }

        #checking user current pwd
        $current_pwd = Customer::where('password', md5($request['current_pwd']))->first();
        if(!$current_pwd)
        {
            return Response::json(['status'=> 200, 'data'=> 'Current Password is Incorrect.']);
        }
        else
        {

            $customer->password = md5($data['new_pwd']);
            $customer->save();
            return Response::json(['status'=> 200, 'data'=> 'Password updated.']);
        }
    }
}
