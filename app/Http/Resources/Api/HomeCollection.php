<?php

namespace App\Http\Resources\Api;

use App\Facades\SettingFacade as AppSettings;
use App\Http\Resources\Api\UserResource;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;


class HomeCollection extends ResourceCollection
{



    public function toArray(Request $request): array
    {
        $settings= AppSettings::all();
        $auth = Auth::guard('api')->user();
        $user =$auth ? User::find($auth->id) : null;
        $sliders=Page::where('type','slider')->active()->paginate(10);
        $sliderFeature=Page::where('type','slider')->where('feature',1)->active()->paginate(10);
        $categories=Category::with('children')->filter()->paginate(10);

        $data = ['categories','unit', 'size', 'brand'];
        
        $newProducts = Product::with($data)->where('is_new',1)
            ->filter()->paginate(10);
        $specialProducts = Product::with($data)->where('is_special',1)
            ->filter()->paginate(10);
        $filterProducts = Product::with($data)->where('is_filter',1)
            ->filter()->paginate(10);
        $offerProducts = Product::with($data)->where('is_offer',1)
            ->filter()->paginate(10);

      

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
            // 'notification_count'=>$user? $user->notificationsUnread()->count() : 0,
            'min_order'                    => $settings['min_order'] ?? 0,
            'max_order'                    => $settings['max_order'] ?? 0,
            'delivery_cost'                => $settings['delivery_cost'] ?? 0,
            'min_order_for_shipping_free'  => $settings['min_order_for_shipping_free'] ?? 0,

            // 'cart_total'=>$user ? $user->totalPriceInCart() : 0,
            'product_min'=>Product::filter()->min('price'),
            'product_max'=> Product::filter()->max('price'),
           
            'site_title'  => $settings['site_title'] ,
            'site_phone'  => $settings['site_phone'] ,
            'site_email'  => $settings['site_email'] ,
            'logo'        => $settings['logo'] ,
            'facebook'    => $settings['facebook'],
            'youtube'     => $settings['youtube'],
            'whatsapp'    => $settings['whatsapp'] ,
            'snapchat'    => $settings['snapchat'] ,
            'instagram'   => $settings['instagram'] ,
            'twitter'     => $settings['twitter'] ,
            'tiktok'      => $settings['tiktok'] ,
            'telegram'    => $settings['telegram'] ,
            // 'services'=>ServiceResource::collection($services),
            'sliders'=>PageResource::collection($sliders),
            'sliderFeature'=>PageResource::collection($sliderFeature),
            'categories'=>CategoryResource::collection($categories),
            'newProducts'=>ProductResource::collection($newProducts),
            'specialProducts'=>ProductResource::collection($specialProducts),
            // 'saleProducts'=>ProductResource::collection($saleProducts),
            'filterProducts'=>ProductResource::collection($filterProducts),
            'offerProducts'=>ProductResource::collection($offerProducts),
        ];
    }
}
