@extends('website.master')
@section('slider_under_header')
    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>See more Details</p>
                        <h1>Single Cart</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->

@endsection
@section('content')
 <!-- single product -->
 <div class="single-product mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="single-product-img">
                    <img class="image_vol" src={{ asset('storage/' . $cart->product->image) }} alt="">
                </div>
            </div>
            <div class="col-md-7">
                <div class="single-product-content">
                    <h3>Green apples have polyphenols</h3>
                    <p class="single-product-pricing"><span>Per Kg</span> ${{ $cart->product->selling_price }}</p>
                    <p>{{ $cart->product->description }}.</p>
                    <div class="single-product-form">

                        <form action="{{ route('cart.update',['id'=>$cart->id]) }}" method="post">
                            @csrf
                            @method('put')
                            <input type="number" id="myInput" readonly name="qty" value="{{$cart->qty}}">
                            <button type="button" class="btn btn-success" onclick="increaseValue()">increase</button>
                            <button type="button" class="btn btn-danger" onclick="decreaseValue()">decrease</button>
                            <input type="hidden" name="product_id" value="{{ $cart->product_id }}">
                            <br>
                            <button type="submit" class="btn btn-warning"><i class="fas fa-shopping-cart"></i> Update
                                Cart</button>
                        </form>

                    </div>
                    <h4>Share:</h4>
                    <ul class="product-share">
                        <li><a href=""><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href=""><i class="fab fa-twitter"></i></a></li>
                        <li><a href=""><i class="fab fa-google-plus-g"></i></a></li>
                        <li><a href=""><i class="fab fa-linkedin"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end single product -->

@endsection
@section('js')
    <script>
        function increaseValue() {
            var myInput = document.getElementById('myInput');
            var currentValue = parseFloat(myInput.value) || 0;
            var newValue = currentValue + 1;
            if(newValue < {{$cart->product->qty}}){
                myInput.value = newValue;
            }
            // myInput.value = newValue;

        }
        function decreaseValue() {
            var myInput = document.getElementById('myInput');
            var currentValue = parseFloat(myInput.value) || 0;

            if (currentValue > 0) {
                var newValue = currentValue - 1;
                myInput.value = newValue;
            }
        }



    </script>
@endsection
