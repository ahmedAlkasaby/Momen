@extends('web.layouts.main.main')

@section('content')
    <div class="container">

        <h1 class="d-flex align-items-center justify-content-center">Wishlist</h1>
        <table class="table align-middle">
            @include('web.wishlist.includes.table_head')

            <tbody>
                @if ($favorites->count() > 0)
                    @each('web.wishlist.includes.data', $favorites, 'favorite')
                @else
                    <div class="d-flex align-items-center justify-content-center">
                        <h2>Wishlist is empty</h2>
                    </div>
                @endif
            </tbody>
        </table>


    </div>
@endsection
@section('mainFiles')
    <script src="{{ asset('website/scripts/remove-from-favorite.js') }}"></script>
@endsection
