<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\CityCollection;
use App\Http\Resources\Api\CityResource;
use App\Models\City;



class CityController extends MainController
{
    public function index()
    {
        $cities=City::filter()->paginate($this->perPage);
        return $this->sendData(new CityCollection($cities));
    }

    public function show(string $id)
    {
        $city=City::filter()->find($id);
        if (!$city) {
            return $this->messageError(__('api.city_not_found'));
        }
        return $this->sendData(new CityResource($city));
    }
}
