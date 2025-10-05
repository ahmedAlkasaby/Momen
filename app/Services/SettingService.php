<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    protected string $cacheKey = 'app_settings';

    /**
     * Get single setting value.
     */
    public function get(string $key, $default = null)
    {
        $settings = $this->load();
        return $settings[$key] ?? $default;
    }

    /**
     * Get all settings (cached).
     */
    public function all(): array
    {
        return $this->load();
    }

    /**
     * Clear and reload settings cache.
     */
    public function refresh(): array
    {
        Cache::forget($this->cacheKey);
        return $this->load();
    }

    /**
     * Load all settings from cache or DB.
     */
    protected function load(): array
    {
        return Cache::rememberForever($this->cacheKey, function () {
            return Setting::query()
                ->pluck('value', 'key') // 👈 key => value
                ->toArray();
        });
    }
}
