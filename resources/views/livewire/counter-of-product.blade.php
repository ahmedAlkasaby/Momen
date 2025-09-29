<div>
    @if ($message)
    <div class="alert alert-danger" role="alert">
        <button type="button" wire:click='closeAlert' class="btn btn-primary">X</button>   {{$message}}
      </div>
    @endif
    <div class="col-md-7">
        <div class="single-product-content">
            <h3>{{$product->name}}</h3>
            <p class="single-product-pricing"><span>Per Kg</span> ${{ $product->selling_price }}</p>
            <p>
                @if ($product->qty<=5)
                        الكميه قابله للنفاز
                         qty = {{ $p->qty }}
                @endif
                {{ $product->description }}.
            </p>
            <div class="single-product-form">
                    <input   type="number" id="myInput" readonly name="qty" value="{{$counter}}">
                    <button type="button" class="btn btn-success" wire:click='increase' >+</button>
                    <button type="button" class="btn btn-danger" wire:click='decrease'>-</button>
                    <br>
                    <button wire:click='add_to_cart' class="btn btn-warning"><i class="fas fa-shopping-cart"></i> Add To
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
