<div class="modal fade py-0" id="sizemodal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal__card">

            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <!-- #product card preview -->
                <div class="col-12 row">
                    <div class="col-md-4 col-12">
                        <img id="modal-product-image"
                             src="{{ asset('placeholder.png') }}"
                             class="product-card__img">
                    </div>

                    <div class="col-md-8 col-12">
                        <h6 class="mt-3" id="modal-product-name"></h6>

                        <p class="product-card__price mt-4 mb-0" id="modal-product-price"></p>

                        <p class="product-card__offer d-none" id="modal-product-offer">
                            <span></span> EGP
                        </p>
                    </div>
                </div>

                <hr class="mt-4">

                <!-- #colors -->
                <div class="col-12 ps-1 row">
                    <h5>{{ __('web.color') }}</h5>
                </div>

                <div id="modal-color-box"
                     class="row row-cols-4 row-cols-md-6 ps-2 g-2 color-options">
                    <!-- colors injected by JS -->
                </div>

                <hr class="mt-4">

                <!-- #sizes -->
                <div class="col-12 mb-3 ps-1 row">
                    <h5>{{ __('web.size') }}</h5>
                </div>

                <div id="modal-size-box"
                     class="size-group__options ps-3">
                    <!-- sizes injected by JS -->
                </div>

            </div>

            <div class="modal-footer">
                <button id="modal-add-to-cart"
                        type="button"
                        class="button__primary__large d-none d-md-block m-auto">
                    Add To Cart
                </button>

                <button id="modal-add-to-cart"
                        type="button"
                        class="button__primary__medium d-block d-md-none m-auto">
                        {{ __('web.add_to_cart') }}
                </button>
            </div>

        </div>
    </div>
</div>
