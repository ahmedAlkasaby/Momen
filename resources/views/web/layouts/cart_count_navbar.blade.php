<a href="/Cart.html" class="nav__cartIcon position-relative">
    <img src="{{ asset('website/assets/shopping-cart.svg') }}" alt="cart" />

    @if($cart_count > 0)
        <span id="cart-count"
              style="
                position:absolute;
                top:-8px;
                right:-10px;
                background:#e74c3c;
                color:#fff;
                padding:2px 6px;
                font-size:12px;
                border-radius:50%;
              ">
            {{ $cart_count }}
        </span>
    @endif
</a>
