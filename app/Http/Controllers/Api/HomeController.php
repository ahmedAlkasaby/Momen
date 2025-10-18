<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\HomeCollection;
use App\Http\Resources\Api\ProductCollection;
use App\Models\Product;
use App\Models\Slider;
use App\Services\HomeApiService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class HomeController extends MainController
{
    protected $homeApiService;

    public function __construct(HomeApiService $homeApiService)
    {
        $this->homeApiService = $homeApiService;
    }

    public function index(){
        $data = ['categories','unit', 'brand','favorites'];
        $products = Product::with($data)
            ->filter()->paginate($this->perPage);

        $data=new ProductCollection($products);
        $extra = $this->homeApiService->getExtraInCollection();

        return $this->sendDataCollection($data,__('site.home'),$extra);
    }


}
