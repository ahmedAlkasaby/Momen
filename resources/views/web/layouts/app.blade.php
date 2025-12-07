<!DOCTYPE html>
<html lang={{$user_language}}  dir="{{ $user_dir  }}">

@include('web.layouts.main.head')

<body>
    @include('web.layouts.main.navbar')

    @yield('content')

    @include('web.layouts.main.footer')


    @include('web.layouts.main.scripts')

</body>

</html>
