 <div class="Categories">
     <div class="container">
         <h1 class="my-5 Categories__title">
             {{ __('web.choose_wear_title') }}
             <br />
             {{ __('web.everyday_wear') }}
         </h1>
         <a href="#" class="Categories__SeeAll mb-2">{{ __('web.see_all_categories') }}</a>
         <div class="swiper mySwiper">
             <div class="swiper-wrapper">
                @foreach ($categories as $category)
                @include('web.home.includes.category_card')
                    
                @endforeach
               
             </div>
         </div>
     </div>
 </div>
