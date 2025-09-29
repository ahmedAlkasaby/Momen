@extends('website.master')
@section('slider_under_header')
    @include('website.layout.sliderUnderHeaderInShop')
@endsection
@section('css')
    <link rel="stylesheet" href={{ asset('assets/css/fixed_image.css') }}>
@endsection
@section('content')
   @livewire('shopping')
@endsection
