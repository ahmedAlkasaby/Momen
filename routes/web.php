<?php

use App\Http\Controllers\Web\HomeController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['setUserLang']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});

