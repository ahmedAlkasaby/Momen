<?php

namespace App\Services;

use App\Models\UserCode;


class UserCodeService
{
    public function generate(string $email, int $length = 4, int $minutes = 10)
    {
        $code = str_pad(rand(0, pow(10, $length)-1), $length, '0', STR_PAD_LEFT);

        $userCode = UserCode::create([
            'email'       => $email,
            'code'        => $code,
            'code_expire' => now()->addMinutes($minutes),
        ]);

        return $userCode->code;
    }
}