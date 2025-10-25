<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Slider;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ImageHandlerService;
use App\Http\Requests\dashboard\SliderRequest;
use App\Http\Controllers\Dashboard\MainController;

class SliderController extends MainController
{
    protected $ImageService;
    public function __construct(ImageHandlerService $ImageService)
    {
        parent::__construct();
        $this->setClass('sliders');
        $this->ImageService = $ImageService;
    }
    public function index()
    {
        $sliders = Slider::with("product")->paginate($this->perPage);
        return view('admin.sliders.index', compact('sliders'));
    }


    public function create()
    {
        $products = Product::all()->mapWithKeys(fn($product) => [$product->id => $product->nameLang()])->toArray();
        return view('admin.sliders.create', compact('products'));
    }


    public function store(SliderRequest $request)
    {
        $imageUrl = $this->ImageService->uploadImage('sliders', $request);
        $data = $request->except('image');
        $data['image'] = $imageUrl;
        $data['type'] = $request->filled('product_id') && $request->product_id !== 'null'
            ? 'product'
            : 'link';

        Slider::create($data);
        return redirect()->route('dashboard.sliders.index')->with('success', __('site.slider_created_successfully'));
    }


    public function show(string $id)
    {
        $slider = Slider::find($id);
        $products = Product::all()->mapWithKeys(fn($product) => [$product->id => $product->nameLang()])->toArray();
        return view('admin.sliders.show', compact('slider', 'products'));
    }


    public function edit(string $id)
    {
        $slider = Slider::find($id);
        $products = Product::all()->mapWithKeys(fn($product) => [$product->id => $product->nameLang()])->toArray();
        return view('admin.sliders.edit', compact('slider', 'products'));
    }


    public function update(SliderRequest $request, string $id)
    {
        $slider = Slider::find($id);
        $imgUrl = $this->ImageService->editImage($request, $slider, 'sliders');
        $data = $request->except('image');
        $data['image'] = $imgUrl;
        $data['type'] = $request->filled('product_id') && $request->product_id !== 'null'
            ? 'product'
            : 'link';

        $slider->update($data);
        return redirect()->route('dashboard.sliders.index')->with('success', __('site.slider_updated_successfully'));
    }


    public function destroy(string $id)
    {
        $slider = Slider::find($id);
        $this->ImageService->deleteImage($slider, 'sliders');
        $slider->delete();
        return redirect()->route('dashboard.sliders.index')->with('success', __('site.slider_deleted_successfully'));
    }

    
}
