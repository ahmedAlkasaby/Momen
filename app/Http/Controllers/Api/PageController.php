<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PageRequest;
use App\Http\Resources\Api\PageCollection;
use App\Http\Resources\Api\PageResource;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends MainController
{
    public function index(PageRequest $request){
        $pages=Page::where('type','page')->filter($request)->paginate($this->perPage);
        return $this->sendData(new PageCollection($pages));
    }

    public function show($id){
        $page=Page::active()->where('id',$id)->first();
        if(! $page){
            return $this->messageError(__('api.page_not_found'));
        }
        return $this->sendData(new PageResource($page));
    }
}
