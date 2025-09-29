<!doctype html>
<html lang="en">
 @include('admin.layouts.head')
  <body>
    @include('admin.layouts.navbar')
    <div class="container"><h3>@yield('name_of_page')</h3></div>

    @yield('content')
    @include('admin.layouts.footer')
    @include('admin.layouts.scripts')

  </body>
  <Style>
    body{
        margin: 0;
        padding: 0;
        font-family: Arial, Helvetica, sans-serif;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }
  </Style>

</html>
