<!DOCTYPE html>
<html lang="en">

@include('web.layouts.main.head')

<body>
    @include('web.layouts.main.navbar')

    @yield('content')

    @include('web.layouts.main.footer')


    @include('web.layouts.main.scripts')

</body>

</html>
