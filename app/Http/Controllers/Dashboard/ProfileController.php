<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function changeLang($lang){
        auth()->user()->update([
            'lang' =>$lang
        ]);
        return redirect()->back();
    }

    public function changeTheme($theme){
        // dd($theme);
        auth()->user()->update([
            'theme' =>$theme
        ]);
        return redirect()->back();
    }
}
