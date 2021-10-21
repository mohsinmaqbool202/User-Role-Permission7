@extends('layouts.frontLayout.front_design')
@section('content')

<section id="form" style="margin-top: 20px;"><!--form-->
	<div class="container">
		@if ($errors->any())
		    <div class="alert alert-danger">
		        <ul>
		          <li>Please fill all the fields.</li>
		        </ul>
		    </div>
	    @endif
	    @if(Session::has('flash_message_error'))  
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>{{ session::get('flash_message_error') }}</strong>
            </div>
        @endif 
	  	<form action="{{ url('/checkout') }}" method="post">
	  		{{csrf_field()}}
				<div class="row">
					<div class="col-sm-4 col-sm-offset-1">
						<div class="login-form"><!-- form-->
							<h2>Bill To</h2>
							  <div class="form-group">
								  <input type="text" name="billing_name" id="billing_name" value="{{ $customer->name }}" placeholder="Billing Name" class="form-control" />
								</div>
								<div class="form-group">
								  <input type="text" name="billing_address" id="billing_address" value="{{ $customer->address }}" placeholder="Billing Address" class="form-control" />
								</div>
								<div class="form-group">
								  <input type="text" name="billing_city" id="billing_city" value="{{ $customer->city }}" placeholder="Billing City" class="form-control" />
								</div>
								<div class="form-group">
								  <input type="text" name="billing_state" id="billing_state" value="{{ $customer->state }}" placeholder="Billing State" class="form-control" />
								</div>
								<div class="form-group">
								  <input type="text" name="billing_pincode" id="billing_pincode" value="{{ $customer->pincode }}" placeholder="Billing Pincode" class="form-control" />
								</div>
								<div class="form-group">
								  <input type="text" name="billing_mobile" id="billing_mobile" value="{{ $customer->mobile }}" placeholder="Billing Mobile" class="form-control" />
								</div>
								<div class="form-check">
	                  <input type="checkbox" value="{{ $customer->name }}" class="form-check-input" id="copyAddress">
	                  <label class="form-check-label" for="copyAddress">Shipping Address same as Billing Address</label>
	              </div>
						</div>
					</div>
					<div class="col-sm-1">
					</div>
					<div class="col-sm-4">
						<div class="signup-form"><!-- form-->
							<h2>Ship To</h2>
								<div class="form-group">
								  <input type="text" name="shipping_name" id="shipping_name" value="@if($shipping_address){{ $shipping_address->name }} @endif" placeholder="Shipping Name" class="form-control" />
								</div>
								<div class="form-group">
								  <input type="text" name="shipping_address" id="shipping_address" value="@if($shipping_address){{ $shipping_address->address }} @endif" placeholder="Shipping Address" class="form-control" />
								</div>
								<div class="form-group">
								  <input type="text" name="shipping_city" id="shipping_city" value="@if($shipping_address){{ $shipping_address->city }} @endif" placeholder="Shipping City" class="form-control" />
								</div>
								<div class="form-group">
								  <input type="text" name="shipping_state" id="shipping_state" value="@if($shipping_address){{ $shipping_address->state }} @endif" placeholder="Shipping State" class="form-control" />
								</div>
								<div class="form-group">
								  <input type="text" name="shipping_pincode" id="shipping_pincode" value="@if($shipping_address){{ $shipping_address->pincode }} @endif" placeholder="Shipping Pincode" class="form-control" />
								</div>
								<div class="form-group">
								  <input type="text" name="shipping_mobile" id="shipping_mobile" value="@if($shipping_address){{ $shipping_address->mobile }} @endif" placeholder="Shipping Mobile" class="form-control" />
								</div>
								<div class="form-group">
								  <input type="submit" value="Checkout" class="btn btn-warning">
								</div>
							</div><!--/ form-->
					</div>
				</div>
	    </form>	
	</div>
</section><!--/form-->

@endsection