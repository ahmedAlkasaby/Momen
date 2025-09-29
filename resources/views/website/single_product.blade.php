@extends('website.master')

@section('css')
    <link rel="stylesheet" href={{ asset('assets/css/fixed_image.css') }}>
    <link rel="stylesheet" href={{ asset('assets/css/volume_image.css') }}>
    <link rel="stylesheet" href={{ asset('assets/css/alert.css') }}>
    @livewireStyles
@endsection
@section('slider_under_header')
    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>See more Details</p>
                        <h1>Single Product</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('content')
    <!-- single product -->
    <div class="single-product mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="single-product-img">
                        <img class="image_vol" src={{ asset('storage/' . $product->image) }} alt="">
                    </div>
                </div>
                @livewire('counter-of-product',['product_of_slug'=>$product])
            </div>
        </div>
    </div>
    <!-- end single product -->
   @livewire('single-product',['related_products'=>$related_products])
@endsection
@section('js')
@livewireScripts
@endsection
