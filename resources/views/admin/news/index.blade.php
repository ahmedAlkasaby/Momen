@extends('admin.master')
@section('name_of_page')
Products
@endsection
@section('content')
<div class="container mt-5">
    <center>
        <style>
            button {
                padding: 20px 40px;
                font-size: 18px;
                background-color: #007bff;
                color: #ffffff;
                border: none;
                border-radius: 10px;
                cursor: pointer;
            }
        </style>
        <a href="{{ route('news.create') }}">
            <button type="button" class="button ">Create Post</button>
        </a>
        <br>
    </center>

    <table class="table" >
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Image</th>
                <th scope="col">Short Descriptiob</th>
                <th scope="col">Description</th>
            </tr>
        </thead>
        <?php $x = 1; ?>
        <tbody>
            @foreach ($posts as $c)
                <tr>
                    <th scope="row">{{ $x++ }}</th>
                    <td>{{ $c->name }}</td>
                    <style>
                        .img {
                            width: 200px;
                            height: 200px;
                            overflow: hidden;
                            border-radius: 10px;
                        }
                    </style>
                    <td>
                        <img src={{ asset('storage/' . $c->image) }} class="img" alt="...">
                    </td>
                    <td>{{ $c->short_description }}</td>
                    <td>{{ $c->description }}</td>
                    <td>
                        <a href="{{route('news.show',['news'=>$c->id])}}"> <button type="button" class="btn btn-outline-success">view</button></a>
                        <a href="{{route('news.edit',['news'=>$c->id])}}"> <button type="button" class="btn btn-outline-warning">Edit</button></a>
                         @include('admin.layouts.delete3',['date'=>$c->id])

                     </td>
                </tr>
            @endforeach


        </tbody>
    </table>
</div>

@endsection
