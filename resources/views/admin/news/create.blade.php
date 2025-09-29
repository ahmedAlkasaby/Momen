@extends('admin.master')
@section('name-of_page')
    Create Product
@endsection
@section('content')
    <div class="container mt-5">
        <form action="{{ route('news.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Title</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Name Of Category"
                    name="title">
            </div>
            <div>
                <label for="formFileLg" class="form-label">Image</label>
                <input class="form-control form-control-lg" id="formFileLg" type="file" name="image">
            </div>
            <label class="form-label">Category</label>

            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description"></textarea>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Short Description</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="short_description"></textarea>
            </div>

            <br>
            <input type="submit" value="Submit" class="btn btn-primary">
            <br>

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
