  <nav class="nav">
      <div class="container d-flex justify-content-between">
          <div class="d-flex align-items-center">

              <button class="nav__toggle d-none">
                  <i class="fa-solid fa-bars"></i>
              </button>

              <div class="nav__logo">
                  <a href="home.html"><img src="{{ asset("website/assets/Mo'men Logo.svg") }}" alt="Logo"
                          height="70" /></a>
              </div>



              <ul class="nav__menu d-flex align-items-center gap-4">
                  <li class="nav__item"><a href="/home.html" class="nav__link nav__link--active">Home</a></li>
                  <li class="nav__item"><a href="/wishlist.html" class="nav__link">Wishlist</a></li>
                  <li class="nav__item category-dropdown">
                      <a class="nav__link">Category</a>
                      <img src="{{ asset('website/assets/category-arrow.svg') }}" class="category-arrow ms-2">


                      <div class="dropdown-menu category-menu">


                          <div class="dropdown-section ">
                              <h3 class="dropdown-title">
                                  <img src="{{ asset('website/assets/sale.svg') }}" alt="sale" class="me-2"> On
                                  Sale
                              </h3>
                              <ul class="dropdown-links sale-section">
                                  <li><a href="#">Unmissable offer! Up to 70% off</a></li>
                                  <li><a href="#">Buy 2 get 1 free</a></li>
                                  <li><a href="#">Buy one and get 50% off the second</a></li>
                              </ul>
                          </div>

                          <div class="dropdown-section">
                              <h3 class="dropdown-title">
                                  <img src="{{ asset('website/assets/man.svg') }}" alt="man" class="me-2"> For
                                  Men
                              </h3>
                              <ul class="dropdown-links">
                                  <li><a href="#">New In</a></li>
                                  <li><a href="#">All Clothes</a></li>
                                  <li><a href="#">Pants</a></li>
                                  <li><a href="#">Shorts</a></li>
                                  <li><a href="#">Jacket</a></li>
                                  <li><a href="#">Half sleeve t-shirt</a></li>
                              </ul>
                          </div>


                          <div class="dropdown-section">
                              <h3 class="dropdown-title">
                                  <img src="{{ asset('website/assets/kid.svg') }}" alt="kid" class="me-2"> For
                                  Kids
                              </h3>
                              <ul class="dropdown-links">
                                  <li><a href="#">New In</a></li>
                                  <li><a href="#">All Clothes</a></li>
                                  <li><a href="#">Pants</a></li>
                                  <li><a href="#">Shorts</a></li>
                                  <li><a href="#">Jacket</a></li>
                                  <li><a href="#">Half sleeve t-shirt</a></li>
                              </ul>
                          </div>


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
