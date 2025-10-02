<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\MainController;
use App\Http\Requests\Api\CheckRegisterRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use App\Notifications\RegisterMail;
use App\Notifications\SendOtpMail;
use App\Services\UserCodeService;
use App\Enums\TypeUserCodeEnum;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;



class AuthController extends MainController
{


    public function __construct(UserCodeService $userCodeService)
    {
        $this->userCodeService = $userCodeService;
    }
     



    public function check_register(CheckRegisterRequest $request)
    {
        $otp = $this->userCodeService->generate($request->email,TypeUserCodeEnum::VerfiyEmail, 4, 10);
        Notification::route('mail', $request->email)
        ->notify((new SendOtpMail($otp))->delay(now()->addMinutes(1)));
        return $this->messageSuccess(__('auth.send_code_successfully'));
    }



    public function register(RegisterRequest $request)
    {
        $otp = $this->userCodeService->validate($request->email, $request->code);
        if($otp->status==true){
            $user = User::create($request->all());
            $user->devices()->create($request->all());
            $token = Auth::guard('api')->login($user);
        }else{
            return $this->messageError($otp->message,400);
        }
        $user->notify(new RegisterMail());

        return $this->sendData([
            'user' => new UserResource($user),
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ], __('auth.register_successfully'));
    }




    public function login(LoginRequest $request){
        $credentials = $request->only('email', 'password');
        $token=Auth::guard('api')->attempt($credentials);
        if (!$token) {
            return $this->messageError(__('auth.invalid_credentials'), 400);
        }
        $auth = Auth::guard('api')->user();

        $user=User::find($auth->id);

        $dataDevice = $request->only('token', 'device_type', 'imei');

        $user->devices()->updateOrCreate(
            [
                'user_id' => $user->id,
                'imei' => $dataDevice['imei'],
            ],
            array_merge($dataDevice, ['user_id' => $user->id])
        );



        if(!$user->active){
            return $this->messageError(__('auth.account_not_active'), 400);
        }

        return $this->sendData([
            'user' => new UserResource($user),
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ], __('auth.login_successfully'));

    }



    public function logout(Request $request){
        Auth::guard('api')->logout();
        return $this->messageSuccess(__('auth.logout'));
    }
}
