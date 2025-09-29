@extends('admin.master')
@section('name-of_page')
 Edit Category
@endsection
@section('content')
<div class="container mt-5">
  <form action="{{route('category.update',['category'=>$category->id])}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Name Category</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Name Of Category" name="name" value="{{$category->name}}">
      </div>
      <div>
        <label for="formFileLg" class="form-label">Image</label>
        <input class="form-control form-control-lg" id="formFileLg" type="file" name="image">
      </div>
      <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Description</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description" >{{$category->description}}</textarea>
      </div>
      <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Short Description</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="short_description">{{$category->short_description}}</textarea>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" name="showing" @checked($category->showing==1)>
        <label class="form-check-label" for="flexCheckDefault">
        Showing
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="1" id="flexCheckChecked" name="trend" @checked($category->trend==1)>
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
