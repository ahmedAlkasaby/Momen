<?php

namespace App\Helpers;

use App\Enums\StatusOrderItemReturnEnum;

class StatusOrderItemReturnHelper
{
    public static function transitions(): array
    {
        return [
            StatusOrderItemReturnEnum::REQUEST->value => StatusOrderItemReturnEnum::cases(),

            StatusOrderItemReturnEnum::PENDING->value => StatusOrderItemReturnEnum::except([
                StatusOrderItemReturnEnum::REQUEST
            ]),

            StatusOrderItemReturnEnum::APPROVED->value => StatusOrderItemReturnEnum::except([
                StatusOrderItemReturnEnum::REQUEST,
                StatusOrderItemReturnEnum::PENDING
            ]),
            StatusOrderItemReturnEnum::REJECTED->value => StatusOrderItemReturnEnum::only([
                StatusOrderItemReturnEnum::REJECTED,
            ]),
            StatusOrderItemReturnEnum::RETURNED->value => StatusOrderItemReturnEnum::only([
                StatusOrderItemReturnEnum::RETURNED,
            ]),

        ];
    }


    public static function getAvailableTransitions(StatusOrderItemReturnEnum $status): array
    {
        return self::transitions()[$status->value] ?? [];
    }

    public static function canTransition(StatusOrderItemReturnEnum $from, StatusOrderItemReturnEnum $to): bool
    {
        return in_array($to, self::getAvailableTransitions($from));
    }

    public static function allStatuses(): array
    {
        return StatusOrderItemReturnEnum::cases();
    }

    public static function isFinal(StatusOrderItemReturnEnum $status): bool
    {
        return empty(self::getAvailableTransitions($status));
    }
}
