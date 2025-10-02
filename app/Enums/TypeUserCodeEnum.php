<?php

namespace App\Enums;

enum TypeUserCodeEnum : string
{
    case VerfiyEmail = 'verify_email';
    case ResetPassword = 'reset_password';

    public static function all(): array
    {
        return [
            self::VerfiyEmail->value,
            self::ResetPassword->value,
        ];
    }

      public function label(): string
    {
        return __('auth.' . $this->value);
    }
}
