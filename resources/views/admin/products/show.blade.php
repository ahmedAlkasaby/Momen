@extends('admin.master')
@section('name-of_page')
 Show Product
@endsection
@section('content')
<div class="container mt-5">

    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Name Product</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" readonly placeholder="Name Of Product" name="name" value="{{$product->name}}">
      </div>
      <div>
        <label for="formFileLg" class="form-label">Image</label>
        <input class="form-control form-control-lg" id="formFileLg" type="file" name="image">
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Price</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" readonly name="price" value="{{$product->price}}">
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Selling Price</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" readonly name="selling_price" value="{{$product->selling_price}}">
      </div>

      <label class="form-label">Category</label>
      <select class="form-select" aria-label="Default select example"  name="category_id">

              <option selected >{{$product->category->name}}</option>

      </select>
      <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Description</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" readonly name="description" >{{$product->description}}</textarea>
      </div>
      <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Short Description</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" readonly name="short_description">{{$product->short_description}}</textarea>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" name="showing" readonly @checked($product->showing==1)>
        <label class="form-check-label" for="flexCheckDefault">
        Showing
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="1" id="flexCheckChecked" readonly name="trend" @checked($product->trend==1)>
        <label class="form-check-label" for="flexCheckChecked">
          Trend
        </label>
      </div>

      <!-- /resources/views/post/create.blade.php -->





<!-- Create Post Form -->
    </div>


@endsection
