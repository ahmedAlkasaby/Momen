<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use App\Facades\SettingFacade as AppSettings;
use App\Models\Setting;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    
    public function boot(): void
    {
        view()->composer('web.layouts.main.navbar', function ($view) {
            $categories = Category::activeParents()->with('activeChildren')->get();
            $view->with('categories', $categories);
        });

        view()->composer('web.layouts.cart_count_navbar', function ($view) {

        $cart_count = 0;
        
        if (auth()->check()) {
            $cart_count = auth()->user()->cart?->cartItems()->count() ?? 0;
        }

        $view->with('cart_count', $cart_count);
       });
       
    }
}
