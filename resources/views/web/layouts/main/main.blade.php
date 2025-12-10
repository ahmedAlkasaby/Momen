<!DOCTYPE html>
<html lang="en">

@include('web.layouts.main.head')

<body style="min-height:100vh; display:flex; flex-direction:column;">

    @include('web.layouts.main.navbar')

    <main style="flex:1;">
        @yield('content')
    </main>

    @include('web.layouts.main.footer')

    @include('web.layouts.main.scripts')

</body>

</html>
