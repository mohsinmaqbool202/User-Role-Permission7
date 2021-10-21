@extends('layouts.frontLayout.front_design')
@section('style')
<style>
    /*body { min-height: 100vh;background-image: linear-gradient(to top, #d9afd9 0%, #97d9e1 100%); }*/
    #exzoom {
        width: 350px;
    }
    /*.container { margin: 150px auto; max-width: 960px; }*/
    /*.hidden { display: none; }*/
</style>
@endsection
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
			<div class="col-sm-9 padding-right">
				<div class="features_items">
					<h2 class="title text-center">{{ $productDetail->name }}</h2>
				</div>
				<div class="product-details"><!--product-details-->
					<div class="col-sm-6">
						<div class="exzoom" id="exzoom">
						    <!-- Images -->
						    <div class="exzoom_img_box">
						      <ul class='exzoom_img_ul'>
						      	<li><img src="{{ asset( 'images/backend_images/products/'.$productDetail->image)}}"/></li>
						      	@foreach($product_imgs as $img)
						        <li><img src="{{ asset( 'images/backend_images/products/'.$img->image)}}"/></li>
						        @endforeach
						      </ul>
						    </div>
						    <div class="exzoom_nav"></div>
						</div>
					</div>
					<div class="col-sm-6">
						<form class="add-to-cartForm" action="javascript::void(0);" method="post">
							
							<input type="hidden" name="quantity"    value="1">
							<input type="hidden" name="product_id"    value="{{ $productDetail->id }}">
							<input type="hidden" name="user_email"    value="{{Session::get('customerSession')}}">
							<div class="product-information"><!--/product-information-->
								<img src="images/product-details/new.jpg" class="newarrival" alt="" />
								<h2>{{ $productDetail->name }}</h2>
								<p><b>Code:</b> {{ $productDetail->code }}</p>
								<p><b>Color:</b> {{ $productDetail->color }}</p>
								<p><b>Price:</b> PKR {{ $productDetail->price }}</p>
								<p><b>Available Stock:</b>
								    @if($productDetail->stock) 
								  	    {{$productDetail->stock}} Items 
								  	@else
								  		Out of Stock
								  	@endif
								</p>
								<p><b>Condition:</b> New</p>
								<span>
									@if($productDetail->stock)
									<button type="submit" class="btn btn-fefault cart addToCart" id="cartButton">
										<i class="fa fa-shopping-cart"></i>
										Add to cart
									</button>
									@endif
								</span>
							</div><!--/product-information-->
						</form>  
					</div>
				</div><!--/product-details-->
			</div>
		</div>
	</div>
</section>
@endsection