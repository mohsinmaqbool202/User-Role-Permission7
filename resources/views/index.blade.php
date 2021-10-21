<?php
use App\Http\Controllers\IndexController;
?>
@extends('layouts.frontLayout.front_design')
@section('content')
	<section>
		<div class="container">
			<div class="row">
				@if(Session::has('flash_message_error'))  
		        <div class="alert alert-error alert-block" style="background-color: #f2dfd0;">
		            <button type="button" class="close" data-dismiss="alert">x</button>
		            <strong>{{ session::get('flash_message_error') }}</strong>
		        </div>
		   		@endif
		   		@if(Session::has('flash_message_success'))  
		        <div class="alert alert-success alert-block" style="background-color: #f2dfd0;">
		            <button type="button" class="close" data-dismiss="alert">x</button>
		            <strong>{{ session::get('flash_message_success') }}</strong>
		        </div>
		   		 @endif
				<div class="col-sm-3">
					<div class="left-sidebar">
						<h2>SIDEBAR</h2>
						<div class="panel-group category-products" id="accordian"><!--category-productsr-->
							
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="{{ url('/')}}"><i class="fa fa-home"></i> Home</a></h4>
								</div>
							</div>
							@if(Session::get('customerSession') != null)
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="{{url('/orders')}}"><i class="fa fa-crosshairs"></i> Orders</a></h4>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="{{ route('account.setting') }}"><i class="fa fa-user"></i> Account</a></h4>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="{{url('/wish-list')}}"><i class="fa fa-star"></i> Wishlist</a></h4>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="{{ url('/customer-logout') }}"><i class="fa fa-sign-out"></i> Logout</a></h4>
								</div>
							</div>
							@else
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="{{ url('/login-register') }}"><i class="fa fa-lock"></i> Login</a></h4>
								</div>
							</div>
							@endif

						</div><!--/category-products-->					
					</div>
				</div> 
				<!-- sidebar -->
				
				<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Features Items</h2>
						@foreach($products as $product)
						<div class="col-sm-3">
							<div class="product-image-wrapper">
								<div class="single-products">
									<div class="productinfo text-center">
										<img src="{{ asset('/images/backend_images/products/'.$product->image) }}" alt="" style="height: 250px;" />
										<h2>PKR:{{ $product->price }}</h2>
										<p>{{ $product->name }}</p>
									</div>
									<div class="product-overlay">
										<div class="overlay-content">
											<h2>PKR:{{ $product->price }}</h2>
											<p>{{ $product->name }}</p>
											<form  class="add-to-cartForm" action="javascript::void(0);">
												
												<input type="hidden" name="quantity" value="1">
												<input type="hidden" name="product_id" value="{{ $product->id }}">
							                    <input type="hidden" name="user_email" value="{{Session::get('customerSession')}}">
							                    <button type="submit" class="btn btn-default add-to-cart addToCart">
										        <i class="fa fa-shopping-cart"></i>
										            Add to cart
									            </button>
									            <a href="{{ route('product.detail', $product->id) }}" class="btn btn-default add-to-cart"><i class="fa fa-eye"></i>View Detail</a>
										    </form>
										</div>
									</div>
								</div>
								@php
									$wish_list_status = IndexController::CheckInWishlist($product->id);
								@endphp
								@if(!$wish_list_status)
								<div class="choose">
									<ul class="nav nav-pills nav-justified">
										<li>
											<form action="javascript::void(0);" class="wishlist_form text-center">
											<input type="hidden" name="user_email" value="{{Session::get('customerSession')}}">
											<input type="hidden" name="product_id" value="{{$product->id}}">
											<a href="#" class="addToWishList"><i class="fa fa-plus-square"></i>Add to wishlist</a>
										    </form>
										</li>
									</ul>
								</div>
								@endif
							</div>
						</div>
						@endforeach
					</div><!--features_items-->
				</div>
			</div>
		</div>
	</section>
@endsection
