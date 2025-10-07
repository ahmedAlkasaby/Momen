<?php

namespace App\Enums;

enum ActionEnum: string
{
    case Created = 'created';
    case Activated = 'activated';
    case Updated = 'updated';
    case Deleted = 'deleted';
    case Restored = 'restored';
    case ForceDeleted = 'force_deleted';


    public function label(): string
    {
        return __('site.' . $this->value);
    }


}
