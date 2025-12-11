<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProductRequest;
use App\Http\Requests\Api\ToggleWishlistRequest;
use App\Http\Resources\Api\FavoriteCollection;
use App\Http\Resources\Api\ProductCollection;
use App\Models\Product;
use App\Models\User;
use App\Services\WishListService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends MainController
{
    protected $WishlistService;

    public function __construct(WishListService $WishlistService)
    {
        $this->WishlistService = $WishlistService;
    }
    public function index()
    {
        $auth = Auth::guard('api')->user();
        $user = User::find($auth->id);
        $favorites = $user->favorites()->with('product')->where('favorite', 'yes')->paginate($this->perPage);

        return $this->sendData(new FavoriteCollection($favorites), __('site.favorites'));
    }

    public function toggle(ToggleWishlistRequest $request)
    {
        $auth = Auth::guard('api')->user();
        $user = User::find($auth->id);
        $product = Product::filter()->where('id', $request->product_id)->first();
        if (! $product) {
            return $this->messageError(__('api.product_not_found'));
        }
        $message = $this->WishlistService->toggle($user, $product);
        return $this->messageSuccess($message);
    }
}
