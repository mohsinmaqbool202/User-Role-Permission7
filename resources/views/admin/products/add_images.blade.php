@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add Images for <i class="text-primary">{{ $product->name }}</i></h2>
        </div>
        <div class="text-right" style="margin-bottom: 5px;">
            <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            <button type="button" class="close" data-dismiss="alert">×</button>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <p>{{ $message }}</p>
    </div>
@endif


<form method="post" action="{{route('product.store-multiple-images', $product_id)}}" enctype="multipart/form-data">
  {{csrf_field()}}

    <div class="input-group control-group increment" >
      <input type="file" name="images[]" class="form-control">
      <div class="input-group-btn"> 
        <button class="btn btn-success" type="button"><i class="glyphicon glyphicon-plus"></i>Add</button>
      </div>
    </div>
    <div class="clone" style="display:none;">
      <div class="control-group input-group" style="margin-top:10px">
        <input type="file" name="images[]" class="form-control">
        <div class="input-group-btn"> 
          <button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
        </div>
      </div>
    </div>

    <button type="submit" class="btn btn-primary" style="margin-top:10px">Submit</button>

</form> 

<table class="table table-bordered">
    <tr>
        <th style="text-align:center;">No</th>
        <th style="text-align:center;">Image</th>
        <th width="310px" style="text-align:center;">Action</th>
    </tr>
    @foreach($productImages as $image)
    <tr>
        <td style="text-align:center;">{{$image->id}}</td>
        <td style="text-align:center;">
            <img src="{{ asset('/images/backend_images/products/'.$image->image) }}" style="width: 70px;">
        </td>
        <td style="text-align:center;">
            @can('delete-image')
                <a class="btn btn-danger" href="{{ route('products.delete-image', $image->id) }}">Delete</a>
            @endcan
        </td>
    </tr>
    @endforeach
</table>

@endsection

@section('js_script')

<script type="text/javascript">

    $(document).ready(function() {

      $(".btn-success").click(function(){ 
          var html = $(".clone").html();
          $(".increment").after(html);
      });

      $("body").on("click",".btn-danger",function(){ 
          $(this).parents(".control-group").remove();
      });

    });

</script>

@endsection