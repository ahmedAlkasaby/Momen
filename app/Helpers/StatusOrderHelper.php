<?php

namespace App\Helpers;

use App\Enums\StatusOrderEnum;

class StatusOrderHelper
{
    public static function transitions(): array
    {
        return [
            StatusOrderEnum::Request->value => StatusOrderEnum::except([
                StatusOrderEnum::ReturnedPartial,
                StatusOrderEnum::Returned,
            ]),

            StatusOrderEnum::Pending->value => StatusOrderEnum::except([
                StatusOrderEnum::Request,
                StatusOrderEnum::ReturnedPartial,
                StatusOrderEnum::Returned,
            ]),

            StatusOrderEnum::Approved->value => StatusOrderEnum::except([
                StatusOrderEnum::Request,
                StatusOrderEnum::ReturnedPartial,
                StatusOrderEnum::Returned,
            ]),

            StatusOrderEnum::Preparing->value => StatusOrderEnum::except([
                StatusOrderEnum::Request,
                StatusOrderEnum::Pending,
                StatusOrderEnum::Approved
            ]),

            StatusOrderEnum::PreparingFinished->value => StatusOrderEnum::except([
                StatusOrderEnum::Request,
                StatusOrderEnum::Pending,
                StatusOrderEnum::Approved,
                StatusOrderEnum::Preparing,
                StatusOrderEnum::ReturnedPartial,
                StatusOrderEnum::Returned,
            ]),

            StatusOrderEnum::DeliveryGo->value => StatusOrderEnum::only([
                StatusOrderEnum::DeliveryGo,
                StatusOrderEnum::Delivered,
                StatusOrderEnum::Canceled,
                StatusOrderEnum::Rejected
            ]),

            StatusOrderEnum::Delivered->value => [StatusOrderEnum::Delivered],

            StatusOrderEnum::Canceled->value => StatusOrderEnum::only([
                StatusOrderEnum::Canceled,
            ]),

            StatusOrderEnum::Returned->value => StatusOrderEnum::only([
                StatusOrderEnum::Returned,
            ]),
            StatusOrderEnum::ReturnedPartial->value => StatusOrderEnum::only([
                StatusOrderEnum::ReturnedPartial,
            ]),

            StatusOrderEnum::Rejected->value => StatusOrderEnum::only([
                StatusOrderEnum::Rejected
            ]),
        ];
    }


    public static function getAvailableTransitions(StatusOrderEnum|string $status) : array  
    {
        if (is_string($status)) {
            $status = StatusOrderEnum::from($status);
        }
        return self::transitions()[$status->value] ?? [];
    }

    public static function canTransition(StatusOrderEnum $from, StatusOrderEnum $to): bool
    {
        return in_array($to, self::getAvailableTransitions($from));
    }

    public static function allStatuses(): array
    {
        return StatusOrderEnum::cases();
    }

    public static function isFinal(StatusOrderEnum $status): bool
    {
        return empty(self::getAvailableTransitions($status));
    }
}
