@extends('website.master')
@section('css')
@livewireStyles

@endsection
@section('slider_under_header')

    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>Fresh and Organic</p>
                        <h1>Cart</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->
    @if(\Session::has('message'))
        <div class="alert alert-success">{{ \Session::get('message') }}</div>
        {{ \Session::forget('message') }}
    @endif
@endsection

@section('content')
@if(\Session::has('error'))
<div class="alert alert-danger">{{ \Session::get('error') }}</div>
{{ \Session::forget('error') }}
@endif



    <!-- cart -->
  @livewire('carts')
@endsection
@section('js')
@livewireScripts

<script src="https://www.paypal.com/sdk/js?client-id={{env('PAYPAL_SANDBOX_CLIENT_ID')}}"></script>




    <script src="https://www.paypal.com/sdk/js?client-id=test&currency=USD"></script>
    <script src="app.js"></script>
@endsection
@section('css')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

@endsection
