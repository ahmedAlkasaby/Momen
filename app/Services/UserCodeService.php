<?php

namespace App\Services;

use App\Models\UserCode;
use App\TypeUserCodeEnum;
use Carbon\Carbon;


class UserCodeService
{
    public function generate(string $email,TypeUserCodeEnum $type, int $length = 4, int $minutes = 10)
    {
        $code = str_pad(rand(0, pow(10, $length)-1), $length, '0', STR_PAD_LEFT);

        $userCode = UserCode::create([
            'email'       => $email,
            'code'        => $code,
            'type'        => $type,
            'code_expire' => now()->addMinutes($minutes),
        ]);

        return $userCode->code;
    }

     public function validate(string $email, string $code): object
    {
        $record = UserCode::where('email', $email)
            ->where('code', $code)
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

        return (object) [
            'status' => true,
            'message' => __('auth.valid_otp'),
        ];
    }
}