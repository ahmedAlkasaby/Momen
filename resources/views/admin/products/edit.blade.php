@extends('admin.master')
@section('name-of_page')
 Edit Product
@endsection
@section('content')
<div class="container mt-5">
  <form action="{{route('product.update',['product'=>$product->id])}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Name Product</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Name Of Product" name="name" value="{{$product->name}}">
      </div>
      <div>
        <label for="formFileLg" class="form-label">Image</label>
        <input class="form-control form-control-lg" id="formFileLg" type="file" name="image">
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Qty</label>
        <input type="number" class="form-control" id="exampleFormControlInput1"
            name="qty">
    </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Price</label>
        <input type="text" class="form-control" id="exampleFormControlInput1"  name="price" value="{{$product->price}}">
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Selling Price</label>
        <input type="text" class="form-control" id="exampleFormControlInput1"  name="selling_price" value="{{$product->selling_price}}">
      </div>

      <label class="form-label">Category</label>
      <select class="form-select" aria-label="Default select example" name="category_id">
          @foreach ($categories as $c)
              <option @selected($product->category_id==$c->id) value="{{$c->id}}">{{$c->name}}</option>
          @endforeach
      </select>
      <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Description</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description" >{{$product->description}}</textarea>
      </div>
      <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Short Description</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="short_description">{{$product->short_description}}</textarea>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" name="showing" @checked($product->showing==1)>
        <label class="form-check-label" for="flexCheckDefault">
        Showing
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="1" id="flexCheckChecked" name="trend" @checked($product->trend==1)>
        <label class="form-check-label" for="flexCheckChecked">
          Trend
        </label>
      </div>
      <br>
      <input type="submit" value="Update" class="btn btn-primary" >
      <br>
      <!-- /resources/views/post/create.blade.php -->



@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Create Post Form -->
    </div>
</form>

@endsection
