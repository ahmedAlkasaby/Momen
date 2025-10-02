<?php

namespace App\Services;

use App\Models\UserCode;
use App\Enums\TypeUserCodeEnum;
use Carbon\Carbon;


class UserCodeService
{
    public function generate(string $email,TypeUserCodeEnum $type, int $length = 4, int $minutes = 10)
    {
        $code = str_pad(rand(0, pow(10, $length)-1), $length, '0', STR_PAD_LEFT);
        $data=[
            'email'       => $email,
            'code'        => $code,
            'type'        => $type,
            'code_expire' => now()->addMinutes($minutes),
        ];
        if($type===TypeUserCodeEnum::ResetPassword){
            $user=UserCode::where('email',$email)->first();
            if($user){
                $data['user_id']=$user->id;
            }
        }

        $userCode = UserCode::create($data);

        return $userCode->code;
    }

    public function validate(string $email, string $code, TypeUserCodeEnum $type = TypeUserCodeEnum::VerfiyEmail): object
    {
        $record = UserCode::where('email', $email)
            ->where('code', $code)
            ->where('type', $type)
            ->latest()
            ->first();

        if (! $record) {
            return (object) [
                'status' => false,
                'message' => __('auth.invalid_otp'),
            ];
        }

        if (Carbon::now()->greaterThan($record->code_expire)) {
            return (object) [
                'status' => false,
                'message' => __('auth.expired_otp'),
            ];
        }

        $record->update(['code_expire' => Carbon::now()]);

        return (object) [
            'status' => true,
            'message' => __('auth.valid_otp'),
        ];
    }
}