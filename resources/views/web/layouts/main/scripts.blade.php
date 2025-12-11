<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

{{-- <script src="{{ asset('website/scripts/navbar.js') }}"></script> --}}
<script src="{{ asset('website/scripts/CategorySlider.js') }}"></script>
{{-- <script src="{{ asset('website/scripts/CountDown.js') }}"></script> --}}
<script src="{{ asset('website/scripts/Card.js') }}"></script>
@yield('scripts')
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="{{ asset('website/scripts/checkbox_once.js') }}"></script>
<script src="{{ asset('website/scripts/test_slider.js') }}"></script>
@if (!auth()->check())
    @include('web.layouts.auth.scripts.forget-password')
    @include('web.layouts.auth.scripts.login')
    @include('web.layouts.auth.scripts.signup')
@endif
@include('web.layouts.auth.scripts.toggle-wishlist')
@yield('mainFiles')
