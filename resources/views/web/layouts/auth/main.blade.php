      @if(!Auth::check())
      @include('web.layouts.auth.login-modal')

      @include('web.layouts.auth.signup-modal')

      @include('web.layouts.auth.forgot-password-modal')


      @endif