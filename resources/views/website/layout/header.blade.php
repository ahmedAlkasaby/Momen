 <!-- header -->
 <div class="top-header-area" id="sticker">
     <div class="container">
         <div class="row">
             <div class="col-lg-12 col-sm-12 text-center">
                 <div class="main-menu-wrap">
                     <!-- logo -->
                     <div class="site-logo">
                         <a href="index.html">
                             <img src="assets/img/logo.png" alt="">
                         </a>
                     </div>
                     <!-- logo -->

                     <!-- menu start -->
                     <nav class="main-menu">
                         <ul>

                             @auth
                                 @if (auth()->user()->is_admin == 1)
                                     <li><a href="{{ route('dashboard') }}">DashBoard</a></li>
                                 @endif
                             @endauth

                             <li class="{{ $data == 'home' ? 'current-list-item' : '' }}">
                                 <a href="/">Home</a>
                             </li>
                             <li><a href="about.html">About</a></li>
                             <li><a href="#">Pages</a>
                                 <ul class="sub-menu">
                                     <li><a href="about.html">About</a></li>
                                     @auth
                                         <li class="{{ $data == 'cart' ? 'current-list-item' : '' }}"><a
                                                 href="{{ route('cart.edit', ['user_id' => auth()->user()->id]) }}">Cart</a>
                                         </li>
                                         {{-- <li class="{{$data=='check_out'? 'current-list-item':''}}"><a href="{{route('carts.check_out',['user_id'=>auth()->user()->id])}}">Check Out</a></li> --}}
                                     @endauth
                                     <li><a href="contact.html">Contact</a></li>
                                     <li><a href="news.html">News</a></li>
                                     <li class="{{ $data == 'shop' ? 'current-list-item' : '' }}"><a
                                             href="{{ route('shop') }}">Shop</a></li>
                                 </ul>
                             </li>
                             <li>
                                 <a href="news.html">News</a>
                             </li>
                             <li><a href="{{ route('shop') }}">Shop</a></li>



                             </li>
                             <li><a href="contact.html">Contact</a></li>

                             @guest
                                 @if (Route::has('login'))
                                     <li class="nav-item">
                                         <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                     </li>
                                 @endif

                                 @if (Route::has('register'))
                                     <li class="nav-item">
                                         <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                     </li>
                                 @endif
                             @else
                                 <li class="nav-item dropdown">
                                     <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                         data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                         {{ Auth::user()->name }}
                                     </a>

                                     <div aria-labelledby="navbarDropdown">
                                         <a class="dropdown-item" href="{{ route('logout') }}"
                                             onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                             {{ __('Logout') }}
                                         </a>

                                         <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                             class="d-none">
                                             @csrf
                                         </form>
                                     </div>
                                 </li>
                             @endguest

                             @auth
                                 <li>
                                     <div class="header-icons">
                                         <a class="shopping-cart" href="{{ route('cart.edit') }}"><i
                                                 class="fas fa-shopping-cart"></i></a>

                                     </div>
                                 </li>
                             @endauth

                         </ul>
                     </nav>

                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- end header -->
