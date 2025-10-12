<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ImageHandlerService;
use App\Http\Requests\Api\ServiceRequest;

class ServiceController extends MainController
{

    protected $imageService;


    public function __construct(ImageHandlerService $imageService)
    {
        parent::__construct();
        $this->setClass('services');
        $this->imageService = $imageService;
    }
    public function index()
    {
        $services = Service::filter(request(), "dashboard")->paginate($this->perPage);
        return view('admin.services.index', compact('services'));
    }


    public function create()
    {
        return view('admin.services.create');
    }


    public function store(ServiceRequest $request)
    {
        $imageUrl = $this->imageService->uploadImage('services', $request);

        $data = $request->except('image');
        $data['image'] = $imageUrl ;
        Service::create($data);

        return redirect()->route('dashboard.services.index')->with('success', __('site.service_created_successfully'));
    }

    public function show(string $id)
    {
        $service = Service::findOrFail($id);
        return view('admin.services.show', compact('service'));
    }


    public function edit(string $id)
    {
        $service = Service::findOrFail($id);
        return view('admin.services.edit', compact('service'));
    }


    public function update(ServiceRequest $request, string $id)
    {
        $service = Service::findOrFail($id);

        $imgUrl = $this->imageService->editImage($request, $service, 'services');

        $data = $request->except('image');
        $data['image'] = $imgUrl ?? $service->image;

        $service->update($data);

        return redirect()->route('dashboard.services.index')->with('success', __('site.service_updated_successfully'));
    }


    public function destroy(Service $service)
    {
        if($service->categories()->count() > 0 || $service->products()->count() > 0){
            return redirect()->route('dashboard.services.index')->with('error', __('site.service_cant_be_deleted'));
        }
        $this->imageService->deleteImage($service->image);
        $service->delete();
        return redirect()->route('dashboard.services.index')->with('success', __('site.service_deleted_successfully'));
    }



    
}
