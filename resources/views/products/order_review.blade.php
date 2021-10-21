<?php
	use App\Product;
?>
@extends('layouts.frontLayout.front_design')
@section('content')

<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{ url('/') }}">Home</a></li>
				  <li class="active">Order Review</li>
				</ol>
	   	</div>
			<div class="shopper-informations">
			<div class="row">
				@if(Session::has('flash_message_error'))  
		            <div class="alert alert-danger alert-block">
		                <button type="button" class="close" data-dismiss="alert">x</button>
		                <strong>{{ session::get('flash_message_error') }}</strong>
		            </div>
		        @endif 
			<div class="col-sm-4 col-sm-offset-1">
				<div class="login-form">
					<h2>Billing Details</h2>
					  <div class="form-group">
						  <b><span>Name: </span></b>{{ $customer->name }}
						</div>
						<div class="form-group">
						  <b><span>Address: </span></b>{{ $customer->address }}
						</div>
						<div class="form-group">
						  <b><span>City: </span></b>{{ $customer->city }}
						</div>
						<div class="form-group">
						  <b><span>State: </span></b>{{ $customer->state }}
						</div>
						<div class="form-group">
						  <b><span>Pincode: </span></b>{{ $customer->pincode }}
						</div>
						<div class="form-group">
						  <b><span>Mobile#: </span></b>{{ $customer->mobile }}
						</div>
				</div>
			</div>
			<div class="col-sm-1">
			</div>
			<div class="col-sm-4">
				<div class="signup-form"><!-- form-->
					<h2>Shipping Details</h2>
						<div class="form-group">
						  <b><span>Name: </span></b>{{ $shipping_address->name }}
						</div>
						<div class="form-group">
						  <b><span>Address: </span></b>{{ $shipping_address->address }}
						</div>
						<div class="form-group">
						  <b><span>City: </span></b>{{ $shipping_address->city }}
						</div>
						<div class="form-group">
						  <b><span>State: </span></b>{{ $shipping_address->state }}
						</div>
						<div class="form-group">
						  <b><span>Pincode: </span></b>{{ $shipping_address->pincode }}
						</div>
						<div class="form-group">
						  <b><span>Mobile#: </span></b>{{ $shipping_address->mobile }}
						</div>
					</div>
			</div>
		</div>
			</div>
			<div class="review-payment">
				<h2>Review & Payment</h2>
			</div>

			<div class="table-responsive cart_info">
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Image</td>
							<td class="description">Item</td>
							<td class="price">Price</td>
							<td class="quantity">Quantity</td>
							<td class="total">Total</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						@php $total_amount = 0; @endphp
						@foreach(session('cart') as $id => $cart)
							<tr class="parent-div">
								<td class="cart_product">
									<a href=""><img src="{{ asset('/images/backend_images/products/'.$cart['image']) }}" alt="" width="70px;"></a>
								</td>
								<td class="cart_description">
								  <h4><a href="">{{$cart['name']}}</a></h4>
							  </td>
								<td class="cart_price">
								<p>PKR:{{ $cart['price'] }}</p>
								</td>
								<td class="cart_quantity">
									<div class="cart_quantity_button">
									    <input type="hidden" id="cart_id" value="{{$id}}">
										<button class="cart_up">+</button>
									    <input class="cart_input text-center" type="text" name="quantity" value="{{ $cart['quantity'] }}" autocomplete="off" size="2" readonly>
									    <button class="cart_down">-</button>
									</div>
								</td>
								<td class="cart_total">
									<p class="cart_total_price">PKR:{{ $cart['price'] * $cart['quantity']  }}</p>
								</td>
								<td>
									<button class="btn btn-danger btn-sm remove-from-cart"><i class="fa fa-trash-o"></i></button>
								</td>
							</tr>
							@php $total_amount += ($cart['price'] * $cart['quantity']); @endphp
						@endforeach
							<tr>
								<td colspan="4">&nbsp;</td>
								<td colspan="2">
									<table class="table table-condensed total-result">
										<tr>
											<td>Cart Sub Total</td>
											<td><span class="btn-secondary">PKR {{ $total_amount }}</span></td>
										</tr>
										<tr>
											<td>Shipping Cost(+)</td>
											<td>00</td>
										</tr>
										<tr class="shipping-cost">
											<td>Discount(-)</td>
											<td>00</td>
										</tr>
										<tr>
											<td>Grand Total</td>
											<td>
												<span class="btn-secondary">PKR {{$total_amount}}</span>
											</td>
										</tr>
									</table>
								</td>
							</tr>
					</tbody>
				</table>
			</div>
			@if(count((array) session('cart')) > 0)
			<form method="post" action="{{url('place-order')}}" name="paymentForm" id="paymentForm" class="hiding">
				{{ csrf_field() }}
				<input type="hidden" name="grand_total" value="{{ $total_amount }}">
				<!-- <input type="hidden" name="coupon_code" value="{{ Session::get('CouponCode') }}"> -->
				<!-- <input type="hidden" name="coupon_amount" value="{{ Session::get('CouponAmount') }}"> -->
				<input type="hidden" name="shipping_charges" value="0">
				<div class="payment-options">
					<span>
						<label><strong>Select Payment Method:</strong></label>
					</span>
					<span>
						<label><input type="radio" name="payment_method" id="COD" value="COD"><strong> COD</strong></label>
					</span>
					<span >
						<input type="submit" class="btn btn-default check_out" value="Place Order" style="margin-top: -5px;" onclick="return selectPaymentMethod();">
					</span>
				</div>
			</form>
			@endif
		</div>
	</section> <!--/#cart_items-->

@endsection