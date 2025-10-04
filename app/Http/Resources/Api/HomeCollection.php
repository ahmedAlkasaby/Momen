<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\UserResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;
use App\Facades\SettingFacade as AppSettings;


class HomeCollection extends ResourceCollection
{



    public function toArray(Request $request): array
    {
        $auth = Auth::guard('api')->user();
        $user =$auth ? User::find($auth->id) : null;
        $setting= AppSettings::all();
        $sliders=Slider::filter()->paginate(10);
        $sliderFeature=Slider::where('feature',1)->filter()->paginate(10);
        $categories=Category::with('children')->filter()->paginate(10);
        $services=Service::filter()->paginate(10);
        $data=['categories','service','unit','size','brand','wishlists','cartItems'];


        $featureProducts=Product::with($data)
         ->withMin('children','price')
        ->withMax('children','price')
        ->withCount('activeReviews')
        ->withAvg('activeReviews','rating')
        ->withSum('cartItems as amount_in_all_carts', 'amount')->where('feature',1)->active()->paginate(10);
        $newProducts=Product::with($data)
         ->withMin('children','price')
        ->withMax('children','price')
        ->withCount('activeReviews')
        ->withAvg('activeReviews','rating')
        ->withSum('cartItems as amount_in_all_carts', 'amount')->where('new',1)->active()->paginate(10);
        $specialProducts=Product::with($data)
         ->withMin('children','price')
        ->withMax('children','price')
        ->withCount('activeReviews')
        ->withAvg('activeReviews','rating')
        ->withSum('cartItems as amount_in_all_carts', 'amount')->where('special',1)->active()->paginate(10);
        $saleProducts=Product::with($data)
         ->withMin('children','price')
        ->withMax('children','price')
        ->withCount('activeReviews')
        ->withAvg('activeReviews','rating')
        ->withSum('cartItems as amount_in_all_carts', 'amount')->where('sale',1)->active()->paginate(10);
        $filterProducts=Product::with($data)
         ->withMin('children','price')
        ->withMax('children','price')
        ->withCount('activeReviews')
        ->withAvg('activeReviews','rating')
        ->withSum('cartItems as amount_in_all_carts', 'amount')->where('filter',1)->active()->paginate(10);
        $offerProducts=Product::with($data)
         ->withMin('children','price')
        ->withMax('children','price')
        ->withCount('activeReviews')
        ->withAvg('activeReviews','rating')
        ->withSum('cartItems as amount_in_all_carts', 'amount')->where('offer',1)->active()->paginate(10);






        return [
            'products'=>ProductResource::collection($this->collection),
             'meta' => [
                'current_page' => $this->currentPage(),
                'last_page' => $this->lastPage(),
                'per_page' => $this->perPage(),
                'total' => $this->total(),
            ],
            'links' => [
                'first' => $this->url(1),
                'last' => $this->url($this->lastPage()),
                'prev' => $this->previousPageUrl(),
                'next' => $this->nextPageUrl(),
            ],
            'user'=>$user ? new UserResource($user) : null,
            'notification_count'=>$user? $user->notificationsUnread()->count() : 0,
            'min_order'=> $setting->min_order,
            'max_order'=> $setting->max_order,
            'delivery_cost'=> $setting->delivery_cost,
            'min_order_for_shipping_free'=> $setting->min_order_for_shipping_free,
            'cart_total'=>$user ? $user->totalPriceInCart() : 0,
            'product_min'=>Product::filter()->min('price'),
            'product_max'=> Product::filter()->max('price'),
            'site_title'=> $setting->site_title,
            'site_phone'=> $setting->site_phone,
            'site_email'=> $setting->site_email,
            'logo'=> $setting->logo,
            'facebook'=> $setting->facebook,
            'youtube'=> $setting->youtube,
            'whatsapp'=> $setting->whatsapp,
            'snapchat'=> $setting->snapchat,
            'instagram'=> $setting->instagram,
            'twitter'=> $setting->twitter,
            'tiktok'=> $setting->tiktok,
            'telegram'=> $setting->telegram,
            'services'=>ServiceResource::collection($services),
            'sliders'=>SliderResource::collection($sliders),
            'sliderFeature'=>SliderResource::collection($sliderFeature),
            'categories'=>CategoryResource::collection($categories),
            'featureProducts'=>ProductResource::collection($featureProducts),
            'newProducts'=>ProductResource::collection($newProducts),
            'specialProducts'=>ProductResource::collection($specialProducts),
            'saleProducts'=>ProductResource::collection($saleProducts),
            'filterProducts'=>ProductResource::collection($filterProducts),
            'offerProducts'=>ProductResource::collection($offerProducts),
        ];
    }
}
