<?php

namespace App\Http\Controllers\Web;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\WishListService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ToggleWishlistRequest;

class WishListController extends MainController
{
    protected $WishlistService;
    public function __construct(WishListService $WishlistService)
    {
        parent::__construct();
        $this->setClass('home');
        $this->WishlistService = $WishlistService;
    }
    public function index()
    {
        $user = auth()->user();
        $favorites = $user->favorites()->with('product')->where('favorite', 'yes')->paginate($this->perPage);
        
        return view('web.wishlist.index', compact('favorites'));
    }







    public function toggle(ToggleWishlistRequest $request)
    {
        $user = auth()->user();
        $product = Product::filter()->where('id', $request->product_id)->first();
        if (! $product) {
            return response()->json(['message' => __('api.product_not_found')], 404);
        }
        $message = __($this->WishlistService->toggle($user, $product));
        $toggle=$message==__('site.wishlist_added')?'no':'yes';
        return response()->json(['message' => $message,'toggle'=>$toggle ,'status' => 'success'], 200);
    }
}
