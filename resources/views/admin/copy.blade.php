<!doctype html>
<html lang="en">
 @include('admin.layouts.head')
  <body>
    @include('admin.layouts.navbar')
    <div class="card">
        <div class="card-body">
          @yield('name-of_page')
        </div>
      </div>
    @yield('content')
    @include('admin.layouts.footer')
    @include('admin.layouts.scripts')
  </body>
</html>
