@extends('admin.master')
@section('name-of_page')
 Category
@endsection
@section('content')
<div class="container mt-5">
  <form action="{{route('category.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Name Category</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Name Of Category" name="name">
      </div>
      <div>
        <label for="formFileLg" class="form-label">Image</label>
        <input class="form-control form-control-lg" id="formFileLg" type="file" name="image">
      </div>
      <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Description</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description"></textarea>
      </div>
      <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Short Description</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="short_description"></textarea>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" name="showing">
        <label class="form-check-label" for="flexCheckDefault">
        Showing
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="1" id="flexCheckChecked" name="trend">
        <label class="form-check-label" for="flexCheckChecked">
          Trend
        </label>
      </div>
      <br>
      <input type="submit" value="Submit" class="btn btn-primary" >
      <br>
      <!-- /resources/views/post/create.blade.php -->

<h1>Create Post</h1>

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
