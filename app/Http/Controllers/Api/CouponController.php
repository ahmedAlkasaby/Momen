<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CouponCollection;
use App\Http\Resources\Api\CouponResource;
use App\Http\Resources\Api\MainCollection;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends MainController
{
    public function index()
    {
        $coupons=Coupon::activeCoupons()->paginate($this->perPage);
        return $this->sendDataCollection(new MainCollection($coupons,'coupons'));
    }

    public function show($id)
    {
        $coupon=Coupon::activeCoupons()->find($id);
        if(!$coupon){
            return $this->messageError(__('api.coupon_not_found'));
        }
        return $this->sendData(new CouponResource($coupon));
    }
}
