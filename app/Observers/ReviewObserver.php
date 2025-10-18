<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;

class ReviewObserver
{
    public function created(Review $review)
    {
      
        if ($review->reviewable_type === Product::class ) {
            $product = Product::find($review->reviewable_id);
            $rateAll = $product->rate_all + $review->rating;
            $rateCount = $product->rate_count + 1;
            $rate = round($rateAll / $rateCount, 2);
            $this->updateProductRate($product, $rateAll, $rateCount, $rate);
        }

        if ($review->reviewable_type === Order::class) {
            $this->updateOrderRate($review->reviewable_id, $review->rating, $review->comment);
        }
    }

    public function updated(Review $review)
    {
        if ($review->reviewable_type === Product::class) {
            $product = Product::find($review->reviewable_id);

            // لو المستخدم عدّل التقييم نفسه
            if ($review->isDirty('rating') && $review->active == 1) {
                $oldRating = $review->getOriginal('rating');
                $newRating = $review->rating;
                $rateAll = $product->rate_all + ($newRating - $oldRating);
                $rate = round($rateAll / $product->rate_count, 2);
                $this->updateProductRate($product, $rateAll, $product->rate_count, $rate);
            }

            // لو admin فعّل أو عطّل التقييم
            if ($review->isDirty('active')) {
                if ($review->active == 1) {
                    $rateAll = $product->rate_all + $review->rating;
                    $rateCount = $product->rate_count + 1;
                } else {
                    $rateAll = $product->rate_all - $review->rating;
                    $rateCount = max(0, $product->rate_count - 1);
                }

                $rate = $rateCount > 0 ? round($rateAll / $rateCount, 2) : 0;
                $this->updateProductRate($product, $rateAll, $rateCount, $rate);
            }
        }

        if ($review->reviewable_type === Order::class && $review->isDirty(['rating', 'comment'])) {
            $this->updateOrderRate($review->reviewable_id, $review->rating, $review->comment);
        }
    }

    public function deleted(Review $review)
    {
        if ($review->reviewable_type === Product::class && $review->active == 1) {
            $product = Product::find($review->reviewable_id);
            $rateAll = max(0, $product->rate_all - $review->rating);
            $rateCount = max(0, $product->rate_count - 1);
            $rate = $rateCount > 0 ? round($rateAll / $rateCount, 2) : 0;
            $this->updateProductRate($product, $rateAll, $rateCount, $rate);
        }
    }

    protected function updateProductRate(Product $product, $rateAll, $rateCount, $rate)
    {
        $product->update([
            'rate_all' => $rateAll,
            'rate_count' => $rateCount,
            'rate' => $rate,
        ]);
    }

    protected function updateOrderRate($orderId, $rate, $rateComment)
    {
        Order::where('id', $orderId)->update([
            'rate' => $rate,
            'rate_comment' => $rateComment,
        ]);
    }
}
