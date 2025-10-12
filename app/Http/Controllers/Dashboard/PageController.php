<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ImageHandlerService;
use App\Http\Requests\dashboard\PageRequest;
use App\Http\Controllers\Dashboard\MainController;

class PageController extends MainController
{
    /**
     * Display a listing of the resource.
     */
    protected $imageService;
    public function __construct(ImageHandlerService $ImageService)
    {
        parent::__construct();
        $this->setClass('pages');
        $this->imageService = $ImageService;
    }
    public function index()
    {
        $pages = Page::paginate($this->perPage);
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PageRequest $request)
    {
        $imageUrl = $this->imageService->uploadImage('pages', $request);
        $data=$request->except('image');
        $data['image'] = $imageUrl;
        Page::create($data);
        return redirect()->route('dashboard.pages.index')->with('success', __('site.page_created_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.edit',compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PageRequest $request, string $id)
    {
        $page = Page::findOrFail($id);
        $imageUrl=$this->imageService->editImage($request,$page,'pages');
        $data=$request->except('image');
        $data["image"]=$imageUrl;
        $page->update($data);
        return redirect()->route('dashboard.pages.index')->with('success', __('site.page_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $page = Page::findOrFail($id);
        $this->imageService->deleteImage($page,'pages');
        $page->delete();
        return redirect()->route('dashboard.pages.index')->with('success', __('site.page_deleted_successfully'));
    }

    
}
