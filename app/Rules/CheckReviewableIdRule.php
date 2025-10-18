<?php

namespace App\Rules;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckReviewableIdRule implements ValidationRule
{
     protected $request;
     protected $userId;
    public function __construct($request,$userId)
    {
        $this->request = $request;
        $this->userId = $userId;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $type = $this->request->input('reviewable_type');
        if ($type === 'product' && !\App\Models\Product::where('id', $value)->exists()) {
            $fail(__('validation.product_not_found'));
        }
        
        if ($type === 'order' && !\App\Models\Order::where('id', $value)->exists()) {
            $fail(__('validation.order_not_found'));
        }
        if($type === 'order'){
            $review= Review::where('reviewable_id', $value)->where('reviewable_type', Order::class)->where('user_id', $this->userId)->first();
            if ($review) {
                $fail(__('validation.review_order_exists'));
            }
        }
        if($type === 'product'){
            $review= Review::where('reviewable_id', $value)->where('reviewable_type', Product::class)->where('user_id', $this->userId)->first();
            if ($review) {
                $fail(__('validation.review_product_exists'));
            }
        }
      

        
    }
}
