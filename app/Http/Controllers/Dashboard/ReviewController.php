<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ReviewRequest;
use App\Http\Controllers\Dashboard\MainController;

class ReviewController extends MainController
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setClass('reviews');
    }
    public function index()
    {
        $reviews = Review::paginate($this->perPage);
        return view('admin.reviews.index', compact('reviews'));
    }
    public function create()
    {
        $users = User::with('orders')
            ->get();

        $products = Product::all()->mapWithKeys(fn($product) => [$product->id => $product->nameLang()])->toArray();
        return view('admin.reviews.create', compact('users', 'products'));
    }
    public function store(ReviewRequest $request)
    {
        $data = $request->validated();

        $data['reviewable_type'] = \App\Models\Product::class;
        $data['reviewable_id'] = $data['product_id'];

        unset($data['product_id']);

        Review::create($data);

        return redirect()->route('dashboard.reviews.index')->with('success', __('site.created'));
    }
    
}
