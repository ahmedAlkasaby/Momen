<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ReviewRequest;
use App\Http\Requests\Api\ReviewUpdateRequest;
use App\Http\Resources\Api\ReviewCollection;
use App\Http\Resources\Api\ReviewResource;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends MainController
{

    public function index()
    {
        $auth = Auth()->guard('api')->user();
        $reviews = $auth->reviews()->with('reviewable')->paginate($this->perPage);
        return $this->sendDataCollection(new ReviewCollection($reviews));
    }

    public function show(Review $review)
    {
        $auth = Auth()->guard('api')->user();
        $review = $auth->reviews()->with('reviewable')->where('id', $review->id)->first();
        if (!$review) {
            return $this->messageError(__('api.review_not_found'));
        }
        return $this->sendData(new ReviewResource($review));
    }

    public function store(ReviewRequest $request)
    {
        $data = $request->validated();
        $data['reviewable_type'] = match ($request->input('reviewable_type')) {
            'product' => Product::class,
            'order'   => Order::class,
        };
        $auth = Auth()->guard('api')->user();

        $review = $auth->reviews()->create($data);
        return $this->messageSuccess(__('api.review_created'));
    }
    public function update(ReviewUpdateRequest $request, Review $review)
    {
        $auth = Auth()->guard('api')->user();
        $review = $auth->reviews()->where('id', $review->id)->first();
        if (!$review) {
            return $this->messageError(__('api.review_not_found'));
        }
        $data = $request->validated();
        $review = $review->update($data);
        return $this->messageSuccess(__('api.review_updated'));
    }
}
