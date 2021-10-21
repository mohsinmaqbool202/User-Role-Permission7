@php
use \App\Http\Controllers\OrderPlacement;
@endphp

@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Customers</h2>
        </div>
    </div>
</div>


@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <p>{{ $message }}</p>
    </div>
@endif


<table class="table table-bordered">
  <tr>
     <th>Order Id</th>
     <th>Order Date</th>
     <th>Customer Name</th>
     <th>Email</th>
     <th>Order Products</th>
     <th>Order Amount</th>
     <th>Order Status</th>
     <th>Payment Method</th>
  </tr>
    @foreach ($orders as $key => $order)
    <tr>    
        <td>{{ $order->id }}</td>
        <td>{{ $order->created_at->format('Y-m-d') }}</td>
        <td>{{ $order->customer->name }}</td>
        <td>{{ $order->customer->email }}</td>
        <td>
            @foreach($order->orders as $ord)
                <span class="text-primary">{{ $ord->cart->product->name }},</span>
            @endforeach
        </td>
        <td>PKR:{{ $order->grand_total }}</td>
        <td><span class="badge badge-success">{{ OrderPlacement::orderStatus($order->id) }}</span></td>
        <td>{{ $order->payment_method }}</td>
    </tr>
    @endforeach
</table>

{!! $orders->render() !!}
@endsection