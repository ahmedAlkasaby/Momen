<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\MainController;
use App\Models\User;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Notifications\ForgetPasswordNotification;


class ForgetPasswordController extends MainController
{
    private $otp;
    public function __construct() {
        $this->otp=new Otp;
    }

    public function ForgetPassword(Request $request){
        $validator=Validator::make($request->all(),[
            'email'=>'required|email|exists:users,email',
        ]);

        if($validator->fails()){
            return $this->sendError('error',$validator->errors(),403);
        }

        $user=User::where('email',$request->email)->first();

        $user->notify(new ForgetPasswordNotification());

        return $this->messageSuccess( __('auth.send_code_successfully'));
    }


}
