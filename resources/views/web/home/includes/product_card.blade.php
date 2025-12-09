<div class="card product-card">
    <div class="product">
        <div class="card product-card">
            <div class="product-card__image m-auto mt-3">
                <img src="{{ asset($product->image) }}" alt="Run Tight Trouser" class="product-card__img" />

                <img src={{ asset('website/assets/heart.svg') }} alt="Heart" class="product-card__addToFavIcon"
                    onclick="toggleFav(this)" />
                <img src={{ asset('website/assets/red-heart.svg') }} alt="Heart"
                    class="product-card__addToFavIconDone" onclick="toggleFav(this)" />

                {{-- <img data-bs-toggle="modal" data-bs-target="#sizemodal" src="assets/add.svg" alt="Add to Cart"
                    class="product-card__addToCartIcon" />

                <div class="product-card__counter">
                    <button onclick="updateCount(this, 1)"><img src={{ asset('website/assets/add-count.svg') }}
                            alt="Add"></button>
                    <span>1</span>
                    <button onclick="updateCount(this, -1)"><img src={{ asset('website/assets/negative.svg') }}
                            alt="Minus"></button>
                </div> --}}
                <button class="open-modal-btn" data-product='@json($product->getWebModalData())'>
                    Select Size & Color
                </button>
            </div>

            <div class="card-body product-card__body">
                <h5 class="product-card__name">{{ $product->nameLang() }}</h5>
                <div class="product-card__priceOffer d-flex justify-content-between">
                    <p class="product-card__price">{{ $product->price }} EGP</p>

                    {{-- <p class="product-card__offer"><span>560</span> EGP</p> --}}
                </div>
                <div class="d-flex justify-content-between">
                    <p class="product-card__category">Men/ T-Shirt</p>
                    <div class="product-card__rate">
                        <img class="product-card__rateImg" src={{ asset('website/assets/star.svg') }} alt="starIcon" />
                        <span class="product-card__rateNo">(4.2)</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- your card content -->
</div>
