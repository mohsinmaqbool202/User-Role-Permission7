@extends('layouts.frontLayout.front_design')
@section('content')

<section id="cart_items">
	<div class="container">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
			  <li><a href="{{ url('/') }}">Home</a></li>
			  <li class="active">Customer Orders</li>
			</ol>
		</div>
	</div>
</section> 

<section id="do_action">
	<div class="container">
		<div class="heading">
			<table id="example" class="table table-striped table-bordered">
				<thead>
					<tr>
					 <th>Order Id</th>
					 <th>Ordered Products</th>
					 <th>Payment Method</th>
					 <th>Grand Total</th>
					 <th>Created on</th>
					</tr> 
				</thead>	
				<tbody>
					@foreach($orders as $order)
					<tr>
						<td>{{$order->id}}</td>
						<td>
							@foreach($order->orders as $pro)
							  	<a href="#">{{$pro->cart->product->name}} | {{$pro->cart->product->code}}</a><br>
				    		@endforeach
						</td>
						<td>{{$order->payment_method}}</td>
						<td>{{$order->grand_total}}</td>
						<td>{{ $order->created_at->format('Y-m-d') }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</section>

@endsection
