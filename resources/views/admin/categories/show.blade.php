@extends('admin.master')
@section('name-of_page')
 Show Category
@endsection
@section('content')
<div class="container mt-5">

    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Name Category</label>

        <input type="text" class="form-control" id="exampleFormControlInput1" readonly value="{{$category->name}}">
      </div>
      <div>
        <style>
            .img {
                width: 200px;
                height: 200px;
                overflow: hidden;
                border-radius: 10px;

            }
        </style>
        <td>
            <img src={{ asset('storage/' . $category->image) }} class="img" alt="...">
        </td>
      </div>
      <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Description</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" readonly name="description">{{$category->description}}</textarea>
      </div>
      <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Short Description</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="short_description" readonly>{{$category->short_description}}</textarea>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" readonly name="showing" @checked($category->showing==1)>
        <label class="form-check-label" for="flexCheckDefault">
        Showing
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="1" id="flexCheckChecked" readonly name="trend" @checked($category->trend==1)>
        <label class="form-check-label" for="flexCheckChecked">
          Trend
        </label>
      </div>

</div>

@endsection
