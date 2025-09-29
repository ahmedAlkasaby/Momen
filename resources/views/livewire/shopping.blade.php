<div>
    {{-- The Master doesn't talk, he acts. --}}
     <!-- products -->
     <div class="product-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <div class="product-filters">
                        <ul>
                            @if ($id_of_categories==1000)
                            <li wire:click="all_of_products" class="active">All</li>
                            @else
                            <li class="">All</li>
                            @endif

                            @foreach ($categories as $c)
                                <a  wire:click="category({{$c->id}})"><li  @if($id_of_categories==$c->id)class="active"@endif >{{ $c->name }}</li></a>

                            @endforeach


                        </ul>
                    </div>
                </div>
            </div>
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
                            <span> @if ($p->qty<=5)
                                الكميه قابله للنفاز
                                 qty = {{ $p->qty }}

                                @endif
                            </span>
                            <br>
                            @if ($p->statue=='is added to cart')
                            <a class="cart-btn" ><i class="fas fa-shopping-cart" ></i>Is Added</a>
                            @else
                            <a class="cart-btn" wire:click='addToCart({{$p->id}})'><i class="fas fa-shopping-cart" ></i>Add To Cart</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- end products -->
</div>
