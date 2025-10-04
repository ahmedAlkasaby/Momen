<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ServiceRequest;
use App\Http\Resources\Api\ServiceCollection;
use App\Http\Resources\Api\ServiceResource;
use App\Models\Service;

class ServiceController extends MainController
{

    public function index(ServiceRequest $request)
    {
        $stores=Service::withCount(['categories','products'])->filter($request)->paginate($this->perPage);
        return $this->sendData(new ServiceCollection($stores));
    }


    public function show(string $id)
    {
        $service=Service::filter()->where('id',$id)->first();
        if (!$service) {
            return $this->messageError(__('site.not_found_store'), 404);
        }
        return $this->sendData(new ServiceResource($service));
    }



}
