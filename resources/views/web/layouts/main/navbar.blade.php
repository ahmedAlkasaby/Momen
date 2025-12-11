  <nav class="nav">
      <div class="container d-flex justify-content-between">
          <div class="d-flex align-items-center">

              <button class="nav__toggle d-none">
                  <i class="fa-solid fa-bars"></i>
              </button>

              <div class="nav__logo">
                  <a href="home.html"><img src="{{ asset($settings['logo']) }}" alt="Logo"
                          height="70" /></a>
              </div>



              <ul class="nav__menu d-flex align-items-center gap-4">
                  <li class="nav__item"><a href="{{ route('home') }}"
                          class="nav__link nav__link--{{ $class == 'home' ? 'active': '' }}">{{ __('web.home') }}</a></li>
                  <li class="nav__item"><a href="{{ route('wishlist.index') }}" class="nav__link">{{ __('web.whislist') }}</a></li>
                  <li class="nav__item category-dropdown">
                      <a class="nav__link">{{ __('web.category') }}</a>
                      <img src="{{ asset('website/assets/category-arrow.svg') }}" class="category-arrow ms-2">

                      <div class="dropdown-menu category-menu">

                          @foreach ($categories as $parent)
                              <div class="dropdown-section">
                                  <h3 class="dropdown-title">
                                      <img src="{{ asset($parent->image) }}" alt="cat"
                                          class="me-2 dropdown-category-icon">
                                      {{ $parent->nameLang() }}
                                  </h3>

                                  @if ($parent->activeChildren && $parent->activeChildren->count() > 0)
                                      <ul class="dropdown-links">
                                          @foreach ($parent->activeChildren as $child)
                                              <li>
                                                  <a href="">
                                                      {{ $child->nameLang() }}
                                                  </a>
                                              </li>
                                          @endforeach
                                      </ul>
                                  @endif
                              </div>
                          @endforeach

                      </div>
                  </li>
                

                  <li class="nav__item"><a href="/about.html" class="nav__link">About</a></li>
                  <li class="nav__item"><a href="/contact_us.html" class="nav__link">Contact Us</a></li>
              </ul>
          </div>

          <!-- icons and sign in  -->
          <div class="nav__icons d-flex align-items-center gap-4">
              <button id="searchToggle" class="nav__searchIcon border-0 bg-transparent">
                  <img src="{{ asset('website/assets/search-normal.svg') }}" alt="search" />
              </button>
              <a href="/Cart.html" class="nav__cartIcon"><img src="{{ asset('website/assets/shopping-cart.svg') }}"
                      alt="cart" /></a>
              @if (Auth::check())
                  <a class="nav__person-icon" href="{{ route('profile.index') }}"><img
                          src="{{ asset('website/assets/profile.svg') }}" alt="cart" /></a>
              @else
                  <button class="nav__LogInbtn" data-bs-toggle="modal"
                      data-bs-target="#exampleModalToggle">Login</button>
              @endif
          </div>

      </div>
      @include('web.layouts.auth.main')
  </nav>
