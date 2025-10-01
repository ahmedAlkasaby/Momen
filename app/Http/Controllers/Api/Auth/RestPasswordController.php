<?php

namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RestPasswordRequest;
use App\Models\User;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class RestPasswordController extends MainController
{
    private $otp;
    public function __construct() {
        $this->otp=new Otp;
    }

    public function RestPassword(RestPasswordRequest $request){
       
        $user=User::where('email',$request->email)->first();

        if (Hash::check($request->password,$user->password)) {
            return $this->messageError(__('passwords.must_new_password_not_equal_old_password'),400);
        }

        $otp=$this->otp->validate($request->email,$request->code);

        if($otp->status==true){
            $user->update($request->only('password'));
            return $this->messageSuccess( __('passwords.reset_password_successfully'));
        }else{
            return $this->messageError($otp->message,400);
        }
    }
}
