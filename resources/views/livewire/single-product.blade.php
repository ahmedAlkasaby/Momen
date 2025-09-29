<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <!-- more products -->
    <div class="more-products mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="section-title">
                        <h3><span class="orange-text">Related</span> Products</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, fuga quas itaque eveniet
                            beatae optio.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($related_products as $i)
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="single-product-item">
                            <div class="product-image">
                                <a href="{{ route('Product', ['slug' => $i->slug]) }}"><img class="image"
                                        src={{ asset('storage/' . $i->image) }} alt=""></a>
                            </div>
                            <h3>{{ $i->name }}</h3>
                            <p class="product-price"><span>Per Kg</span> {{ $i->selling_price }}$ </p>
                            <span>
                                @if ($i->qty <= 5)
                                    الكميه قابله للنفاز
                                    qty = {{ $p->qty }}
                                @endif
                            </span>
                            <br>
                            @if (auth()->user())
                                @if ($i->user_of_product_id == auth()->user()->id && $i->statue == 'is added to cart')
                                    <a class="cart-btn"><i class="fas fa-shopping-cart"></i>Is Added</a>
                                @else
                                    <a class="cart-btn" wire:click='addToCart({{ $i->id }})'><i
                                            class="fas fa-shopping-cart"></i>Add To Cart</a>
                                @endif
                            @else
                                <a class="cart-btn" wire:click='addToCart({{ $i->id }})'><i
                                        class="fas fa-shopping-cart"></i>Add To Cart</a>
                            @endif

                            {{-- @if ($i->statue == 'is added to cart')
                            <a class="cart-btn" ><i class="fas fa-shopping-cart" ></i>Is Added</a>
                            @else
                            <a class="cart-btn" wire:click='addToCart({{$i->id}})'><i class="fas fa-shopping-cart" ></i>Add To Cart</a>
                            @endif --}}

                        </div>
                    </div>
                @endforeach


            </div>

        </div>
    </div>
    <!-- end more products -->
</div>
