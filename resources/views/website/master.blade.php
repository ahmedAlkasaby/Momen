<!DOCTYPE html>
<html lang="en">
@include('website.layout.head')

<body>

    @include('website.layout.perload')

    @include('website.layout.header')

   @yield('slider_under_header')

   @yield('content')

   @include('website.layout.top_of_footer')

    @include('website.layout.footer')

    @include('website.layout.copyrights')

    @include('website.layout.scripts')

</body>

</html>
