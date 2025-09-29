<div>
    {{-- delete the element  --}}


    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <div class="cart-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="cart-table-wrap">
                        <table class="cart-table">
                            <thead class="cart-table-head">
                                <tr class="table-head-row">
                                    <th class="product-remove"></th>
                                    <th class="product-image">Product Image</th>
                                    <th class="product-name">Name</th>
                                    <th class="product-price">Price</th>
                                    <th class="product-quantity">Quantity</th>
                                    <th class="product-quantity">Actions</th>


                                    <th class="product-total">Total</th>
                                    <th class="product-total">Action</th>


                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                    $i = 0;
                                @endphp

                                @foreach ($carts as $c)
                                    <tr class="table-body-row">
                                        <td class="product-remove">
                                            <a href="#"><i class="far fa-window-close"></i></a>
                                        </td>
                                        <td class="product-image">
                                            <img src={{ asset('storage/' . $c->product->image) }} alt="">
                                        </td>
                                        <td class="product-name">{{ $c->product->name }}</td>
                                        <td class="product-price">${{ $c->product->selling_price }}</td>
                                        <td class="product-quantity">
                                            <input type="number" id="myInput" readonly value="{{ $c->qty }}">
                                        </td>
                                        <td class="product-quantity">
                                            <button type="button" class="btn btn-primary"
                                                wire:click='increaseQTY({{ $c->id }})'>+</button>
                                            <button type="button" class="btn btn-danger"
                                                wire:click='decreaseQTY({{ $c->id }})'>-</button>
                                        </td>
                                        <td class="product-total">{{ $c->qty * $c->product->selling_price }}</td>
                                        <td>
                                            @php
                                                $total += $c->qty * $c->product->selling_price;
                                            @endphp


                                            <a href="{{route('cart.delete',['id'=>$c->id])}}" onclick="return confirm('are sure fro delete')"><button type="submit" class="btn btn-danger"> Delete</button></a>


                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="total-section">
                        <table class="total-table">
                            <thead class="total-table-head">
                                <tr class="table-total-row">
                                    <th>Total</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="total-data">
                                    <td><strong>Subtotal: </strong></td>
                                    <td>${{ $total }}</td>
                                </tr>
                                @if(count($carts)>0)
                                <tr class="total-data">
                                    <td><strong>Shipping: </strong></td>
                                    <td>$45</td>
                                </tr>
                                <tr class="total-data">
                                    <td><strong>Total: </strong></td>
                                    <td>${{ $total + 45 }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="cart-buttons">

                            @if (count($carts)>0)
                              <a href="{{route('paypal_process')}}" class="boxed-btn black">PayPal</a>
                            <a href="{{route('myfatootah_checkout')}}" class="boxed-btn black">My Fatoorah</a> 
                            <a href="{{ route('selling_success') }}" class="boxed-btn black"> check out</a>

                            {{-- <a href="" class="boxed-btn black">Check Out</a> --}}
                            <div id="paypal-button-container"></div>
                            <p id="result-message"></p>
                            <!-- Replace the "test" client-id value with your client-id -->
                            @endif

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
