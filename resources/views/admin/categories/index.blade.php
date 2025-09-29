@extends('admin.master')
@section('name_of_page')
    Categories
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
            <a href="{{ route('category.create') }}">
                <button type="button" class="button ">Create Category</button>
            </a>
            <br>
        </center>

        <table class="table" >
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Image</th>
                    <th scope="col">Description</th>
                    <th scope="col">Short Description</th>
                    <th scope="col">Showing</th>
                    <th scope="col">Trend</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <?php $x = 1; ?>
            <tbody>
                @foreach ($categories as $c)
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
                        <td>{{ $c->description }}</td>
                        <td>{{ $c->short_description }}</td>
                        <td>
                            @if ($c->showing == 1)
                                <span class="btn btn-primary"> Showing</span>
                            @else
                                <span class="btn btn-danger"> Not </span>
                            @endif
                        </td>
                        <td>
                            @if ($c->trend == 1)
                                <span class="btn btn-primary"> Trend</span>
                            @else
                                <span class="btn btn-danger"> Not </span>
                            @endif
                        </td>
                        <td>
                           <a href="{{route('category.show',['category'=>$c->id])}}"> <button type="button" class="btn btn-outline-success">view</button></a>
                           <a href="{{route('category.edit',['category'=>$c->id])}}"> <button type="button" class="btn btn-outline-warning">Edit</button></a>
                            @include('admin.layouts.delete',['date'=>$c->id])

                        </td>
                    </tr>
                @endforeach


            </tbody>
        </table>
    </div>
@endsection
