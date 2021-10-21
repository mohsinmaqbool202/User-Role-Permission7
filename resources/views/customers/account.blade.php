@extends('layouts.frontLayout.front_design')
@section('content')

<section id="form" style="margin-top: 20px;">
		<div class="container">
			<div class="row">
				@if(Session::has('flash_message_success'))  
		        <div class="alert alert-success">
		            <button type="button" class="close" data-dismiss="alert">x</button>
		            <strong>{{ session::get('flash_message_success') }}</strong>
		        </div>
		        @endif 
		        @if(Session::has('flash_message_error'))  
		        <div class="alert alert-danger alert-block">
	            	<button type="button" class="close" data-dismiss="alert">x</button>
	            	<strong>{{ session::get('flash_message_error') }}</strong>
		        </div>
		     	@endif 
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form">
						<h2>Update Account</h2>
						<form id="accountForm" action="{{ url('/account') }}" method="post">
							{{ csrf_field() }}
							<input id="name" name="name" type="text" value="{{ $customer->name }}" placeholder="Name"/>	
							<input id="address" name="address" type="text" value="{{ $customer->address }}" placeholder="Address"/>
							<input id="city" name="city" type="text" value="{{ $customer->city }}" placeholder="City"/>
							<input id="state" name="state" type="text" value="{{ $customer->state }}" placeholder="State" />
							<input id="pincode" name="pincode" type="text" value="{{ $customer->pincode }}" placeholder="Pincode" style="margin-top: 10px;"/>
							<input id="mobile" name="mobile" type="text" value="{{ $customer->mobile }}" placeholder="Mobile"/>
							<button type="submit" class="btn btn-default">Update</button>
						</form>
					</div>
				</div>
				<div class="col-sm-1">
					<h2 class="or">OR</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form">
						<h2>Update Password</h2>
						<form id="account_Form" action="{{ url('/update-customer-pwd') }}" method="post">
							{{ csrf_field() }}
							<input type="password" name="current_pwd" id="current_pwd" placeholder="Current Password"/>
              				<span id="chkPwd"></span>
              				<input type="password" name="new_pwd" id="new_pwd" placeholder="New Password" />
             				<input type="password" name="confirm_pwd" id="confirm_pwd" placeholder="Confirm Password"/>
							<button type="submit" class="btn btn-default">Update</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection
