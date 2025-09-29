<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\PostController;

use App\Http\Controllers\Website\WebsiteController;
use App\Http\Controllers\Website\CartController;
use App\Http\Controllers\Website\PaypalController;
use App\Http\Controllers\Website\MyFatoorahController;







/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/





Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




Route::group(['middleware'=>['admin']],function(){
    Route::get('/dashboard',[AdminController::class,'index'])->name('dashboard');
    Route::get('/sales',[AdminController::class,'sales'])->name('sales');
    Route::get('/sales/cupboard',[AdminController::class,'cupboard'])->name('cupboard');
    Route::get('create/notification/{sale_id}',[AdminController::class,'create_notification'])->name('create_notification');
    Route::post('store/notification/{sale_id}',[AdminController::class,'store_notification'])->name('store_notification');

    Route::resource('category', CategoryController::class);
    Route::resource('product', ProductController::class);
    Route::resource('news', PostController::class);
});

Route::get('/',[WebsiteController::class,'home'])->name('home');
Route::get('/shop',[WebsiteController::class,'shop'])->name('shop');
Route::get('/shop/category/{slug}',[WebsiteController::class,'category'])->name('Category');
Route::get('/shop/product/{slug}',[WebsiteController::class,'show_product'])->name('Product');

Route::group(['middleware'=>'auth'],function(){
    Route::post('cart/store',[CartController::class,'store'])->name('cart.store');
    Route::get('carts/show',[CartController::class,'show'])->name('cart.edit');
    Route::get('carts/edit/{cart_id}',[CartController::class,'edit'])->name('cart.edit2');
    Route::put('cart/update/{id}', [CartController::class,'update'])->name('cart.update');
    Route::get('cart/delete/{id}', [CartController::class,'delete'])->name('cart.delete');
    Route::get('selling_success', [CartController::class,'selling_success'])->name('selling_success');
    Route::get('paypal/process',[PayPalController::class,'paypal_process'])->name('paypal_process');
    Route::get('paypal/sucess',[PayPalController::class,'paypal_sucess'])->name('paypal_sucess');
    Route::get('paypal/cancel',[PayPalController::class,'paypal_cancel'])->name('paypal_cancel');
    Route::get('myfatoorah/checkout',[MyFatoorahController::class,'checkout'])->name('myfatootah_checkout');
    Route::get('myfatoorah/callback',[MyFatoorahController::class,'callback'])->name('callback');
    Route::get('myfatoorah/error',[MyFatoorahController::class,'error'])->name('error');
    // Route::get('carts/check_out/{user_id}',[CartController::class,'check_out'])->name('carts.check_out');
    // Route::get('carts/sellingCheck_out/{user_id}',[CartController::class,'selling_success'])->name('carts.selling');
});




