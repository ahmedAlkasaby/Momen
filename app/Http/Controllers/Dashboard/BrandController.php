<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Dashboard\MainController;
use App\Http\Requests\dashboard\BrandRequest;
use App\Services\ImageHandlerService;

class BrandController extends MainController
{
    /**
     * Display a listing of the resource.
     */
    protected $imageService;

    public function __construct(ImageHandlerService $imageService)
    {
        parent::__construct();
        $this->setClass('brands');
        $this->imageService = $imageService;
    }
    public function index()
    {
        $brands = Brand::filter(request(), "dashboard")->paginate($this->perPage);
        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
        $imageUrl = $this->imageService->uploadImage('brands', $request);
        $data = $request->except('image');

        $data['image'] = $imageUrl;
        Brand::create($data);
        return redirect()->route('dashboard.brands.index')->with('success', __('site.brand_created_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $brand = Brand::findOrFail($id);
        $imgUrl = $this->imageService->editImage($request, $brand, 'brands');
        $data = $request->except('image');

        $data['image'] = $imgUrl ?? $brand->image;
        $brand->update($data);
        return redirect()->route('dashboard.brands.index')->with('success', __('site.brand_updated_successfully'));
    }

    public function destroy(Brand $brand)
    {
        if ($brand->products()->count() > 0) {
            return redirect()->route('dashboard.brands.index')->with('error', __('site.brand_has_products'));
        }
        $this->imageService->deleteImage($brand->image);
        $brand->delete();
        return redirect()->route('dashboard.brands.index')->with('success', __('site.brand_deleted_successfully'));
    }
    
}
