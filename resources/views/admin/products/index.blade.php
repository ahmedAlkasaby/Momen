@extends('admin.master')
@section('name_of_page')
Products
@endsection
@section('css')
@livewireStyles
@endsection
@section('js')
@livewireScripts
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
        <a href="{{ route('product.create') }}">
            <button type="button" class="button ">Create Product</button>
        </a>
        <br>
    </center>

   @livewire('products-pagiate')
</div>

@endsection
