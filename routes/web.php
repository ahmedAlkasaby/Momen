<?php

use App\Http\Controllers\Web\Auth\AuthController;
use App\Http\Controllers\Web\Auth\PasswordController;
use App\Http\Controllers\Web\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('web.layouts.main.main');
    // auth()->logout();
});
//auth
Route::post('/login', 'App\Http\Controllers\Web\Auth\AuthController@login')->name('web.auth.login');
Route::post('/register', [AuthController::class, 'check_register']);
Route::post('/register/verify', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('web.auth.logout');
Route::post('/resend-otp', [AuthController::class, 'resendOtp']);
Route::post('/forget-password', [PasswordController::class, 'ForgetPassword']);
Route::post('/confirm-otp', [PasswordController::class, 'confirmOtp']);
Route::post('/reset-password', [PasswordController::class, 'ResetPassword']);
//end auth
Route::get('/profile', [ProfileController::class, 'personalInfo'])->name('profile.index');
