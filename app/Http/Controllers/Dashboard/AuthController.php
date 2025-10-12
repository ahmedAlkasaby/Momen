<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\LoginRequest;

class AuthController extends Controller
{
    public function viewLogin(){
        return view('admin.login.login');
    }

    public function login(LoginRequest $request){
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials, $request->filled('remember'))) {
            return redirect()->intended(route('dashboard.home.index'));
        }

        return redirect()->back()->withErrors(['email' => __('auth.failed')]);
    }

    public function logout(){
        auth()->logout();
        return redirect()->route('dashboard.login.view');
    }
}
