<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class CacheController extends Controller
{
    public function index(Request $request)
    {
        Artisan::call('optimize:clear');
        Artisan::call('optimize');
        Artisan::call('view:cache');
    
        $redirectUrl = $request->get('redirect', route('dashboard.home.index'));
    
        return redirect($redirectUrl)
            ->with('success', __('site.optimize_cache_successfully'));
    }

}
