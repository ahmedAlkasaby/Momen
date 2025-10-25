<?php

namespace App\Http\Controllers\Dashboard;


use App\Http\Controllers\Dashboard\MainController;
use App\Http\Requests\Dashboard\SizeRequest;
use App\Models\Size;

class SizeController extends MainController
{

    public function __construct()
    {
        parent::__construct();
        $this->setClass('sizes');
    }
    public function index()
    {
        $sizes = Size::filter(request(), "dashboard")->paginate($this->perPage);
        return view('admin.sizes.index', compact('sizes'));
    }

    public function create()
    {
        return view('admin.sizes.create');
    }


    public function store(SizeRequest $request)
    {

        $data = $request->all();
        Size::create($data);

        return redirect()->route('dashboard.sizes.index')->with('success', __('site.size_created'));
    }


    public function show(string $id)
    {
        $size = Size::findOrFail($id);
        return view('admin.sizes.show', compact('size'));
    }

    public function edit(string $id)
    {
        $size = Size::findOrFail($id);
        return view('admin.sizes.edit', compact('size'));
    }

    public function update(SizeRequest $request, string $id)
    {
        $size = Size::findOrFail($id);
        $data = $request->all();
        $size->update($data);

        return redirect()->route('dashboard.sizes.index')->with('success', __('site.size_updated'));
    }

    public function destroy(Size $size)
    {
        if ($size->P()->count() > 0) {
            return redirect()->route('dashboard.sizes.index')->with('error', __('site.size_has_products'));
        }
        $size->delete();
        return redirect()->route('dashboard.sizes.index')->with('success', __('site.size_deleted'));
    }

    
}
