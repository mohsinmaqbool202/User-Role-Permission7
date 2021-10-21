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
     <th>No</th>
     <th>Name</th>
     <th>Email</th>
     <th>Address</th>
     <th>City</th>
     <th>State</th>
     <th>Pincode</th>
     <th>Mobile</th>
     <th>Status</th>
     <th>Registered on</th>
  </tr>
    @foreach ($customers as $key => $customer)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $customer->name }}</td>
        <td>{{ $customer->email }}</td>
        <td>{{ $customer->address }}</td>
        <td>{{ $customer->city }}</td>
        <td>{{ $customer->state }}</td>
        <td>{{ $customer->pincode }}</td>
        <td>{{ $customer->mobile }}</td>
        <td>
            @if($customer->verified == 1)
                <span class="badge badge-success">Active</span>
            @else
                <span class="badge badge-danger">In-active</span>
            @endif
        </td>
        <td>{{ $customer->created_at->format('d-m-Y') }}</td>
    </tr>
    @endforeach
</table>

{!! $customers->render() !!}

@endsection