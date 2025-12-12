<div class="card product-card">
    <div class="product">
        <div class="card product-card">
            <div class="product-card__image m-auto mt-3">
                <img src="{{ asset($product->image) }}" alt="Run Tight Trouser" class="product-card__img" />
                <img src="{{ $product->isFav() ? asset('website/assets/red-heart.svg') : asset('website/assets/heart.svg') }}"
                    class="product-card__addToFavIcon" data-id="{{ $product->id }}"
                    data-url="{{ route('wishlist.toggle') }}" data-heart="{{ asset('website/assets/heart.svg') }}"
                    data-red-heart="{{ asset('website/assets/red-heart.svg') }}" />


                
                <div class="product-card__counter">
                    <button onclick="updateCount(this, 1)"><img src={{ asset('website/assets/add-count.svg') }}
                            alt="Add"></button>
                    <span>1</span>
                    <button onclick="updateCount(this, -1)"><img src={{ asset('website/assets/negative.svg') }}
                            alt="Minus"></button>
                </div>
                <button class="open-modal-btn select-size-btn" data-product='@json($product->getWebModalData())'>
                    <img src="{{ asset('website/assets/add.svg') }}" class="me-1" style="width:13px;">
                    {{ __('web.select_size_color') }}
                </button>

            </div>

            <div class="card-body product-card__body">
                <h5 class="product-card__name">{{ $product->nameLang() }}</h5>
                <div class="product-card__priceOffer d-flex justify-content-between">
                    <p class="product-card__price">{{ $product->price }} EGP</p>
                 
                    @if ($product->hasOfferPrice())
                    <p class="product-card__offer"><span>{{ $product->offer_price }}</span> EGP</p>

                    @endif

                   
                </div>
                
                <div class="d-flex justify-content-between">
                    @if ($product->unit_id)
                    <p class="product-card__category">{{ $product->unit->nameLang() }}</p>
                    @endif
                    @if ($product->rate > 0)
                        
                    <div class="product-card__rate">
                        <img class="product-card__rateImg" src={{ asset('website/assets/star.svg') }} alt="starIcon" />
                        <span class="product-card__rateNo">({{ $product->rate }})</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <!-- your card content -->
</div>
