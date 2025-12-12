<?php

use App\Http\Controllers\Api\V2\CartItemController;
use App\Http\Controllers\Web\Auth\AuthController;
use App\Http\Controllers\Web\Auth\PasswordController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\WishListController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['setUserLang']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::resource('products', ProductController::class)->only(['index', 'show']);
    Route::get('/profile', [ProfileController::class, 'personalInfo'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/security', [ProfileController::class, 'security'])->name('profile.security');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update.password');
    Route::get('favorites', [WishListController::class,'index'])->name('wishlist.index');
    Route::post('favorites',[WishListController::class,'toggle'])->name('wishlist.toggle');
    
    //auth
    Route::post('/login', 'App\Http\Controllers\Web\Auth\AuthController@login')->name('web.auth.login');
    Route::post('/register', [AuthController::class, 'check_register']);
    Route::post('/register/verify', [AuthController::class, 'register']);
    Route::get('/logout', [AuthController::class, 'logout'])->name('web.auth.logout');
    Route::post('/resend-otp', [AuthController::class, 'resendOtp']);
    Route::post('/forget-password', [PasswordController::class, 'ForgetPassword']);
    Route::post('/confirm-otp', [PasswordController::class, 'confirmOtp']);
    Route::post('/reset-password', [PasswordController::class, 'ResetPassword']);
    //end auth

    Route::group(['middleware' => ['auth']], function () {
        Route::post('carts',[CartItemController::class,'store'])->name('carts.store');
    });
});

