@extends('website.master')
@section('slider_under_header')
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Fresh and Organic</p>
                    <h1>{{$category->name}}</h1>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('css')
    <link rel="stylesheet" href={{ asset('assets/css/fixed_image.css') }}>
@endsection
@section('content')
    <!-- products -->
    <div class="product-section mt-150 mb-150">
        <div class="container">

            <div class="row product-lists">
                @foreach ($products as $p)
                    <div class="col-lg-4 col-md-6 text-center strawberry">
                        <div class="single-product-item">
                            <div class="product-image">
                                <a href="{{route('Product',['slug'=>$p->slug])}}"><img class="image" src={{ asset('storage/' . $p->image) }}
                                        alt=""></a>
                            </div>
                            <h3>{{ $p->name }}</h3>
                            <p class="product-price"><span>Per Kg</span> {{ $p->selling_price }}$ </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- end products -->
@endsection
