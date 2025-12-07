<div class="Trending mt-5">
        <div class="container d-flex justify-content-between">
            <div class="Trending__title">
                <h3>{{ $section['title'] }}</h3>
            </div>
            <div class="Trending__seeAll">
                <a href="{{ $section['route'] }}">{{ __('web.see_all') }}</a>
            </div>
        </div>
        <div class="Trending__products">
            <div class="container">
                <div class="products-slider">
                    @foreach ($section['products'] as $product)
                    @include('web.home.includes.product_card')
                    @endforeach
                    
                </div>
                @include('web.home.includes.size_color_model')
            </div>
        </div>
    </div>