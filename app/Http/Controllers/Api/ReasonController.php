<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\MainCollection;
use App\Http\Resources\Api\ReasonResource;
use App\Models\Reason;
use Illuminate\Http\Request;

class ReasonController extends MainController
{
    public function index(){
        $reasons=Reason::active()->paginate($this->perPage);
        return $this->sendDataCollection(new MainCollection($reasons,'reasons'));
    }

    public function show(string $id){
        $reason=Reason::active()->where('id',$id)->first();
        if(! $reason){
            return $this->messageError(__('api.reason_not_found'));
        }
        return $this->sendData(new ReasonResource($reason));

    }
}
