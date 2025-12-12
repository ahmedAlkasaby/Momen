<?php

namespace App\Http\Controllers\Web;

use App\Facades\SettingFacade as AppSettings;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class MainController extends Controller
{
    protected $class;
    protected $perPage;
    protected $result;

    public function __construct()
    {
        $this->setSettingsInView();
        $this->setUserLang();
        $this->perPage = 10;
    }


    protected function setClass($class)
    {
        $this->class = $class;
        View::share('class', $class); 
    }
    protected function setUserLang()
    {
        $user_language = app()->getLocale();
        $user_dir = $user_language == 'ar' ? 'rtl' : 'ltr';
        View::share('user_language', $user_language); 
        View::share('user_dir', $user_dir);
    }

    protected function setSettingsInView()
    {
        $settings = AppSettings::all();

        View::share('settings', $settings);
    }
   

}
