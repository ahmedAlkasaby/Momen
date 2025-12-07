<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function personalInfo()
    {
        $user=auth()->user();
        return view('web.profile.layouts.main',compact('user'));
    }
}
