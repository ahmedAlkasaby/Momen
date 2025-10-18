<?php

namespace App\Http\Controllers\Api;

use App\Helpers\PageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PageRequest;
use App\Http\Resources\Api\MainCollection;
use App\Http\Resources\Api\PageCollection;
use App\Http\Resources\Api\PageResource;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends MainController
{
    public function index(PageRequest $request){
        $pages=Page::where('type','page')->filter($request)->paginate($this->perPage);
        $extra['page_types'] = PageHelper::getPagesTypes();
        return $this->sendDataCollection(new MainCollection($pages,'pages'),__('site.pages'),$extra);
    }

    public function show($id){
        $page=Page::active()->where('id',$id)->first();
        if(! $page){
            return $this->messageError(__('api.page_not_found'));
        }
        return $this->sendData(new PageResource($page));
    }
}
