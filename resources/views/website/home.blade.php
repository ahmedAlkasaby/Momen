@extends('website.master')
@section('slider_under_header')
@include('website.layout.sliderInWelcome')

@endsection
@section('css')
<link rel="stylesheet" href={{asset("assets/css/fixed_image.css")}}>


@endsection
@section('content')
@include('website.layout.underSlider')

 <!-- product section -->
 <div class="product-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="section-title">
                    <h3><span class="orange-text">Our</span> Products</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, fuga quas itaque eveniet
                        beatae optio.</p>
                </div>
            </div>
        </div>

            @livewire('add-one-product-to-cart')

        
    </div>
</div>
<!-- end product section -->

@endsection
