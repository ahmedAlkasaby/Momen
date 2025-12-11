@extends('web.layouts.main.main')
@section('content')
    <div class="MyAccount">
        <div class="container">
            <div class="row mt-5 mb-3">
                <!-- Breadcrumb -->
            </div>
            <h1>My Account</h1>
            <div class="row MyAccount__Row mt-4">
                @include('web.profile.layouts.sidebar')
                <div class="offset-lg-1 col-lg-8  col-12">
                    @yield('profile-content')
                </div>
            </div>
        </div>
    </div>
@endsection
@section('mainFiles')
    <script src="{{ asset('website/scripts/MyAccount.js') }}"></script>
    <script src="{{ asset('website/scripts/DropImg.js') }}"></script>
@endsection
