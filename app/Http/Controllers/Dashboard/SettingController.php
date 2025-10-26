<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\ImageHandlerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SettingController extends MainController
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setClass('settings');
    }
    public function index()
    {
        $settings = Setting::filter(request())->paginate($this->perPage);

        return view('admin.settings.index', compact('settings'));
    }



    
}
