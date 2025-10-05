<?php

namespace App\Services;

use App\Models\City;
use App\Models\Region;

class CheckValidateAddressService{

    public function CheckValidateAddress($cityId,$regionId=null){
        $city=City::find($cityId);

        if(! $city->active){
            return __('api.city_not_active');
        }
        if($regionId){
            $region=Region::where('id',$regionId)->where('city_id',$cityId)->first();
            if(!$region){
                return __('api.region_not_found_in_city');
            }
            if(! $region->active){
                return __('api.region_not_active');
            }
        }

        return true;

    }
}
