@extends('web.layouts.app')
@section('title')
    Home
@endsection

@section('content')
    {{-- <div id="searchOverlay" class="search__overlay">
        <div class="container">
            <div class="search__box">
                <img src="assets/search-normal.svg" alt="search">
                <input type="text" class="search__input" placeholder="Search for products">
                <button id="closeSearch" class="search__close fa-2x">×</button>
            </div>

            <div class="recent__search">
                <h5>Recent Search</h5>
                <div class="search__tags">
                    <span class="search__tag">Shirts <span class="close__tag">×</span></span>
                    <span class="search__tag">Skirts <span class="close__tag">×</span></span>
                    <span class="search__tag">Jeans <span class="close__tag">×</span></span>
                    <span class="search__tag">Casual <span class="close__tag">×</span></span>
                    <span class="search__tag">Pants <span class="close__tag">×</span></span>
                    <span class="search__tag">Coats <span class="close__tag">×</span></span>
                    <span class="search__tag">Sneakers <span class="close__tag">×</span></span>
                </div>
            </div>

            <div class="search__suggestions">
                <div class="suggestion__item">
                    T-Shirt <i class="fas fa-chevron-right"></i>
                </div>

                <div class="suggestion__item">
                    Shirt Jackets <i class="fas fa-chevron-right"></i>
                </div>

                <div class="suggestion__item">
                    Boys T-Shirt <i class="fas fa-chevron-right"></i>
                </div>

                <div class="suggestion__item">
                    Shirt Jackets <i class="fas fa-chevron-right"></i>
                </div>

                <div class="suggestion__item">
                    Shirts in Clothing <i class="fas fa-chevron-right"></i>
                </div>

                <div class="suggestion__item">
                    Boys T-Shirt Boys Top <i class="fas fa-chevron-right"></i>
                </div>
            </div>
        </div>
    </div> --}}
    @include('web.home.includes.landing')

    @include('web.home.includes.categories')
    @foreach ($sections as $section)
    @include('web.home.includes.section')
        
    @endforeach
    
@endsection
