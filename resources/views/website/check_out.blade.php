@extends('website.master')

@section('slider_under_header')
<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Fresh and Organic</p>
                    <h1>Check Out Product</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->
@endsection
@section('content')
	<!-- check out section -->
	<div class="checkout-section mt-150 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-4">
					<div class="order-details-wrap">
						<table class="order-details">
							<thead>
								<tr>
									<th>Your order Details</th>
									<th>Price</th>
								</tr>
							</thead>
							<tbody class="order-details-body">
								<tr>
									<td>Product</td>
									<td>Total</td>
								</tr>
                                @php
                                    $total=0;
                                @endphp
                                @foreach ($carts as $cart)
                                <tr>
									<td>{{$cart->product->name}}</td>
									<td>${{$cart->product->selling_price*$cart->qty}}</td>
                                    @php
                                        $total=$cart->product->selling_price*$cart->qty
                                    @endphp
								</tr>
                                @endforeach


							</tbody>
							<tbody class="checkout-details">
								<tr>
									<td>Subtotal</td>
									<td>${{$total}}</td>
								</tr>
								<tr>
									<td>Shipping</td>
									<td>$50</td>
								</tr>
								<tr>
									<td>Total</td>
									<td>${{$total+50}}</td>
								</tr>
							</tbody>
						</table>
						<a href="{{route('carts.selling',['user_id'=>auth()->user()->id])}}" class="boxed-btn">Selling</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end check out section -->

@endsection
