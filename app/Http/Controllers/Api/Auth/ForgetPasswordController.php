<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ForgetPasswordRequest;
use App\Models\User;
use App\Notifications\ForgetPasswordNotification;
use App\Services\UserCodeService;
use App\Enums\TypeUserCodeEnum;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ForgetPasswordController extends MainController
{
    public function __construct(UserCodeService $userCodeService)
    {
        $this->userCodeService = $userCodeService;
    }

    public function ForgetPassword(ForgetPasswordRequest $request){
       
        $user=User::where('email',$request->email)->first();
        $otp = $this->userCodeService->generate($request->email,TypeUserCodeEnum::ResetPassword, 4, 10);

        $user->notify(new ForgetPasswordNotification($otp));

        return $this->messageSuccess( __('auth.send_code_successfully'));
    }


}
