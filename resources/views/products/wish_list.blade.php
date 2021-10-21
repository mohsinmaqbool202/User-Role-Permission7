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
				  <li class="active">Wish List</li>
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
							<td style="text-align: center;">Image</td>
							<td style="text-align: center;">Product Name</td>
							<td style="text-align: center;">Color</td>
							<td style="text-align: center;">Price</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						@foreach($wishLists as $wish)
						<tr>
							<td style="text-align: center;" >
								<a href="{{url('/product/'.$wish->product_id)}}"><img src="{{ asset('/images/backend_images/products/'.$wish->product->image) }}" alt="" width="60px;"></a>
							</td>
							<td style="text-align: center;"> <a href="{{url('/product/'.$wish->product_id)}}">{{$wish->product->name}}</a></td>
							<td style="text-align: center;"><p>{{$wish->product->color}}</p> </td>
							<td style="text-align: center;"> {{$wish->product->price}} </td>
							<td style="text-align: center;">
								<a title="Delete" href="{{url('delete-wish/'.$wish->id)}}" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
</section> <!--/#cart_items-->

@endsection