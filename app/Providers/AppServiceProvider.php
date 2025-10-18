<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Observers\OrderObserver;
use App\Observers\ProductObserver;
use App\Observers\SettingObserver;
use App\Services\FirebaseNotificationService;
use App\Services\SettingService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
         $this->app->singleton(FirebaseNotificationService::class, function ($app) {
            $projectId = config('firebase.project_id'); 
            return new FirebaseNotificationService($projectId);
        });
        $this->app->singleton('settings', function ($app) {
            return new SettingService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Product::observe(ProductObserver::class);
        Setting::observe(SettingObserver::class);
        Order::observe(OrderObserver::class);
    }
}
