<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\dashboard\AdditionRequest;
use App\Models\Addition;
use App\Services\ImageHandlerService;

class AdditionController extends MainController
{
    /**
     * Display a listing of the resource.
     */
    protected $imageService;
    public function __construct(ImageHandlerService $imageService)
    {
        parent::__construct();
        $this->setClass('additions');
        $this->imageService = $imageService;
    }
    public function index()
    {
        $additions = Addition::filter(request(), "dashboard")->paginate($this->perPage);
        return view('admin.additions.index', compact('additions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.additions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdditionRequest $request)
    {
        if ($request->type == "free") {
            $request->price = 0;
        }
        $imageUrl = $this->imageService->uploadImage('additions', $request);
        $data = $request->except('image');
        $data['image'] = $imageUrl;
        Addition::create($data);
        return redirect()->route('dashboard.additions.index')->with('success', __('site.addition_created_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $addition = Addition::find($id);
        return view('admin.additions.show', compact('addition'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $addition = Addition::find($id);
        return view('admin.additions.edit', compact('addition'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $addition = Addition::find($id);
        if ($request->type == "free") {
            $request->price = 0;
        }
        $imageUrl = $this->imageService->editImage($request, $addition, 'additions');
        $data = $request->except('image');
        $data['image'] = $imageUrl;
        $addition->update($data);

        return redirect()->route('dashboard.additions.index')->with('success', __('site.addition_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Addition $addition)
    {
        $this->imageService->deleteImage($addition->image);
        $addition->delete();
        return redirect()->route('dashboard.additions.index')->with('success', __('site.addition_deleted_successfully'));
    }
   
}
