<?php

namespace App\Enums;

enum StatusOrderItemReturnEnum : string
{
    case REQUEST = 'request';
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case RETURNED = 'returned';


    public function label(): string
    {
        return __('site.' . $this->value);
    }

    public static function except(array $excluded): array
    {
        return array_values(array_filter(
            self::cases(),
            fn(self $case) => !in_array($case, $excluded, true)
        ));
    }

    public static function only(array $only): array
    {
        return array_values(array_filter(
            self::cases(),
            fn(self $case) => in_array($case, $only, true)
        ));
    }


}
