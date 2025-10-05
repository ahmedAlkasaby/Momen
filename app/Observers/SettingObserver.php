<?php

namespace App\Observers;

use App\Models\Setting;
use App\Facades\SettingFacade as AppSettings;

class SettingObserver
{
    public function saved(Setting $setting): void
    {
        AppSettings::refresh();
    }

    public function deleted(Setting $setting): void
    {
        AppSettings::refresh();
    }
}
