 <div class="Categories">
     <div class="container">
         <h1 class="my-5 Categories__title">
             Choose the best everyday wear
             <br />
             everyday wear
         </h1>
         <a href="#" class="Categories__SeeAll mb-2">See All Categories</a>
         <div class="swiper mySwiper">
             <div class="swiper-wrapper">
                 @for ($i = 0; $i < 15; $i++)
                     <a href="#" class="swiper-slide d-flex text-dark">
                         <svg class="swiper-slide__img me-1" width="42" height="26" viewBox="0 0 42 26"
                             fill="none" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink">
                             <rect y="0.399902" width="42" height="25.2" fill="url(#pattern0_230_13147)" />
                             <defs>
                                 <pattern id="pattern0_230_13147" patternContentUnits="objectBoundingBox" width="1"
                                     height="1">
                                     <use xlink:href="#image0_230_13147"
                                         transform="matrix(0.00293255 0 0 0.00488758 0 -0.0229715)" />
                                 </pattern>
                                 <image href="{{ asset('storage/Categories/categoryDefoult.png') }}" id="image0_230_13147"
                                     width="341" height="214" preserveAspectRatio="none" />
                             </defs>
                         </svg>

                         <h3 class="swiper-slide__title">Category {{ $i}}</h3>
                     </a>
                 @endfor
             </div>
         </div>
     </div>
 </div>
