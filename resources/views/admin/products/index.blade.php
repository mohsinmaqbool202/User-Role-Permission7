@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Products</h2>
            </div>
            <div class="text-right" style="margin-bottom: 5px;">
                @can('product-create')
                <a class="btn btn-success" href="{{ route('products.create') }}"> Create New Product</a>
                @endcan
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
            <th>Image</th>
            <th>Name</th>
            <th>Code</th>
            <th>Colour</th>
            <th>Price</th>
            <th>Stock</th>
            <th width="310px">Action</th>
        </tr>
	    @foreach ($products as $product)
	    <tr>
	        <td>{{ ++$i }}</td>
            <td>
                <img src="{{ asset('/images/backend_images/products/'.$product->image) }}" style="width: 50px;">
            </td>
	        <td>{{ $product->name }}</td>
            <td>{{ $product->code }}</td>
            <td>{{ $product->color }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->stock }}</td>
	        <td>
                <form action="{{ route('products.destroy',$product->id) }}" method="POST">

                    <a class="btn btn-info" href="{{ route('products.show',$product->id) }}">Show</a>
                    
                    @can('store-multiple-images')
                    <a class="btn btn-info" href="{{ route('product.store-multiple-images', $product->id) }}">Add Img</a>
                    @endcan

                    @can('product-edit')
                    <a class="btn btn-primary" href="{{ route('products.edit',$product->id) }}">Edit</a>
                    @endcan

                    @csrf
                    @method('DELETE')
                    @can('product-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>


    {!! $products->links() !!}

@endsection