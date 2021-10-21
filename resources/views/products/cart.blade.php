<?php
	use App\Product;
	// dd(session('cart'));
?>
@extends('layouts.frontLayout.front_design')
@section('content')
<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{url('/')}}">Home</a></li>
				  <li class="active">Shopping Cart</li>
				</ol>
			</div>
			<div class="table-responsive cart_info">
				 @if(Session::has('flash_message_success'))  
			        <div class="alert alert-success alert-block">
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
						@if(session('cart'))
						@foreach(session('cart') as $id => $cart)
						<tr class="parent-div">
							<td class="cart_product">
								<a href=""><img src="{{ asset('/images/backend_images/products/'.$cart['image']) }}" alt="" width="70px;"></a>
							</td>
							<td class="cart_description">
								<p>{{ $cart['name'] }}</p>
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
								<p class="cart_total_price"><span>PKR:{{$cart['price'] * $cart['quantity']  }}</span></p>
							</td>
							<td>
								<button class="btn btn-danger btn-sm remove-from-cart"><i class="fa fa-trash-o"></i></button>
							</td>
						</tr>
						@php $total_amount += ($cart['price'] * $cart['quantity']); @endphp
						@endforeach
						@endif
					</tbody>
				</table>
			</div>
		</div>
</section> <!--/#cart_items-->

<section id="do_action">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				
			</div>
			<div class="col-sm-6">
				<div class="total_area">
					<ul>
						<li>Grand Total <span class="btn-secondary">
						 PKR {{$total_amount}}</span></li>
					</ul>
						<a class="btn btn-default update" href="{{url('/')}}">Continue Shopping</a>
						@if(count((array) session('cart')) > 0)
						<a class="btn btn-default check_out hiding" href="{{url('/checkout')}}">Check Out</a>
						@endif
				</div>
			</div>
		</div>
	</div>
</section><!--/#do_action-->

@endsection