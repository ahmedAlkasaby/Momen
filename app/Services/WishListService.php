<?php

namespace App\Services;

class WishListService
{
    public function toggle($user, $product)
    {
        $favorite = $user->favorites()->where('product_id', $product->id)->first();
        if ($favorite) {
            $favorite->update(['favorite' => $favorite->favorite == 'yes' ? 'no' : 'yes']);
            $message = $favorite->favorite == 'no' ? 'site.wishlist_removed' : 'site.wishlist_added';
            return $message;
        } else {
            $user->favorites()->create([
                'product_id' => $product->id,
                'favorite' => 'yes'
            ]);
            return 'site.wishlist_added';
        }
    }
}
