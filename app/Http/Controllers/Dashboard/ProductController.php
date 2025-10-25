<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use App\Models\Size;
use App\Models\Unit;
use App\Services\ImageHandlerService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class ProductController extends MainController
{
    protected $imageService;
    protected $productService;

    public function __construct(ImageHandlerService $imageService, ProductService $productService)
    {
        parent::__construct();
        $this->setClass('products');
        $this->imageService = $imageService;
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $data = ['categories', 'service', 'unit', 'size', 'brand', 'children', 'parent'];
        $products = Product::with($data)->filter($request, 'admin')->paginate($this->perPage);

        $units = Unit::active()->get()->mapWithKeys(function ($unit) {
            return [$unit->id => $unit->nameLang()];
        })->toArray();
        $brands = Brand::active()->get()->mapWithKeys(function ($brand) {
            return [$brand->id => $brand->nameLang()];
        })->toArray();
        $categories = Category::active()
            ->with('parent')
            ->get()
            ->mapWithKeys(function ($category) {
                $label = $category->parent ? $category->parent->nameLang() . ' > ' . $category->nameLang() : $category->nameLang();
                return [$category->id => $label];
            })->toArray();
        return view('admin.products.index', get_defined_vars());
    }

    public function create()
    {
        $services = Service::active()->get();
        $brands = Brand::active()->get();
        $units = Unit::active()->get();
        $sizes = Size::active()->get();

        $categories = Category::active()
            ->with('parent')
            ->get()
            ->mapWithKeys(function ($category) {
                $label = $category->parent ? $category->parent->nameLang() . ' > ' . $category->nameLang() : $category->nameLang();
                return [$category->id => $label];
            });

        return view('admin.products.create', get_defined_vars());
    }



    public function store(ProductRequest $request)
    {
        $image = $this->imageService->uploadImage('products', $request);
        try {
            DB::transaction(function () use ($request, $image) {
                $data = $request->except('image');
                $data['image'] = $image;

                $product = Product::create($data);
                $product->categories()->sync($request->categories);

                $this->productService->handleProductChildren($request, $product);
            });
        } catch (\Throwable $e) {
            if (isset($data['image'])) {
                $this->imageService->deleteImage('products', $data['image']);
            }

            return redirect()->back()
                ->with('error', __('site.something_went_wrong'))
                ->withInput();
        }

        return redirect()->route('dashboard.products.index')->with('success', __('site.added_successfully'));
    }



    public function show(string $id)
    {
        $product = Product::with('children')->findOrFail($id);

        $services = Service::active()->get();
        $brands = Brand::active()->get();
        $units = Unit::active()->get();
        $sizes = Size::active()->get();

        $categories = Category::active()
            ->with('parent')
            ->get()
            ->mapWithKeys(function ($category) {
                $label = $category->parent ? $category->parent->nameLang() . ' > ' . $category->nameLang() : $category->nameLang();
                return [$category->id => $label];
            });

        return view('admin.products.edit', get_defined_vars());
    }

    public function edit(string $id)
    {
        $product = Product::with('children')->findOrFail($id);

        $services = Service::active()->get();
        $brands = Brand::active()->get();
        $units = Unit::active()->get();
        $sizes = Size::active()->get();

        $categories = Category::active()
            ->with('parent')
            ->get()
            ->mapWithKeys(function ($category) {
                $label = $category->parent ? $category->parent->nameLang() . ' > ' . $category->nameLang() : $category->nameLang();
                return [$category->id => $label];
            });

        return view('admin.products.edit', get_defined_vars());
    }


    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->except('image');


        if ($request->hasFile('image')) {
            $data['image'] = $this->imageService->uploadImage('products', $request);
        }

        try {
            DB::transaction(function () use ($product, $data, $request) {

                $product->update($data);
                $product->categories()->sync($request->categories);
                $product->deleteChildrenOldWhenNotSendInUpdate();
                $this->productService->handleProductChildren($request, $product);
            });
        } catch (\Throwable $th) {
            if (isset($data['image'])) {
                $this->imageService->deleteImage('products', $data['image']);
            }

            return redirect()->back()
                ->with('error', __('site.something_went_wrong'))
                ->withInput();
        }

        return redirect()->route('dashboard.products.index')->with('success', __('site.updated_successfully'));
    }




    public function destroy(string $id)
    {
        //
    }
    
    


    public function getCategoryByService($id)
    {
        $categories = Category::where('service_id', $id)->active()
            ->with('parent')
            ->get()
            ->mapWithKeys(function ($category) {
                $label = $category->parent ? $category->parent->nameLang() . ' > ' . $category->nameLang() : $category->nameLang();
                return [$category->id => $label];
            })->toArray();
        return response()->json([
            'success' => true,
            'categories' => $categories,
        ]);
    }
}
