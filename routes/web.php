<?php

use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\ProductController;
use Illuminate\Support\Facades\Route;



Route::group(['middleware' => ['setUserLang']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::resource('products',ProductController::class)->only(['index','show']);
});

