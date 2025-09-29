@extends('admin.master')
@section('css')
    <link rel="stylesheet" href="template\assets\css\maps\css.css">
@endsection
@section('content')
    <style>
        .my-form {
            background-color: #333;
            color: #fff;
            padding: 20px;
            border: 1px solid #222;
            margin: 0 auto;
        }
    </style>
     @if (session()->has('message'))
     <div class="alert alert-success" role="alert">

           <button id="close-button"><span aria-hidden='true'>&times;</span></button>
           {{session()->get('message')}}
       </div>
     @endif
     <script>
         const closeButton = document.getElementById("close-button");

         closeButton.addEventListener("click", () => {
           const alert = closeButton.parentNode;
           alert.parentNode.removeChild(alert);
         });
         </script>

    <form class="my-form" action="{{ route('store_notification',['sale_id'=>$sale_id]) }}" method="post" >
        @csrf
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Greeting</label>
            <input type="text" class="form-control" id="exampleInputPassword1" name="greeting">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Body</label>
            <input type="text" class="form-control" id="exampleInputPassword1" name="body">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Action Text</label>
            <input type="text" class="form-control" id="exampleInputPassword1" name="action_text">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Action URL</label>
            <input type="text" class="form-control" id="exampleInputPassword1" name="action_url">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">End Part</label>
            <input type="text" class="form-control" id="exampleInputPassword1" name="end_part">
        </div>

        <br>


        <br>
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

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
