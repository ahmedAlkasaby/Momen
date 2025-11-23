<?php

use App\Http\Controllers\Dashboard\ActivityLogController;
use App\Http\Controllers\Dashboard\AdditionController;
use App\Http\Controllers\Dashboard\AddressController;
use App\Http\Controllers\Dashboard\AjaxController;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\BrandController;
use App\Http\Controllers\Dashboard\CacheController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\dashboard\CityController;
use App\Http\Controllers\Dashboard\ContactController;
use App\Http\Controllers\dashboard\CouponController;
use App\Http\Controllers\dashboard\DeliveryTimeController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Controllers\dashboard\OrderController;
use App\Http\Controllers\dashboard\PageController;
use App\Http\Controllers\Dashboard\PaymentController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\dashboard\RegionController;
use App\Http\Controllers\dashboard\ReviewController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\ServiceController;
use App\Http\Controllers\dashboard\SettingController;
use App\Http\Controllers\Dashboard\SizeController;
use App\Http\Controllers\Dashboard\SliderController;
use App\Http\Controllers\Dashboard\TrashBucketController;
use App\Http\Controllers\Dashboard\UnitController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\WishlistController;
use Illuminate\Support\Facades\Route;








Route::group(['middleware' => 'guest'], function () {
    Route::get('login', [AuthController::class, 'viewLogin'])->name('login.view');
    Route::post('login', [AuthController::class, 'login'])->name('login.login');
});

Route::group(['middleware' => ['auth', 'admin', 'check.permission']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home.index');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::group(['prefix' => 'profile'], function () {
        Route::get('index', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('update', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('change_password', [ProfileController::class, 'changePassword'])->name('profile.security');
        Route::post('update_password', [ProfileController::class, 'updatePassword'])->name('profile.update.password');
        Route::get('change_lang/{lang}', [ProfileController::class, 'changeLang'])->name('profile.change.lang');
        Route::get('change_theme/{theme}', [ProfileController::class, 'changeTheme'])->name('profile.change.theme');
        Route::get('delete_account', [ProfileController::class, 'deleteAccount'])->name('profile.delete.account');
    });
    // Resource routes for roles
    Route::resource('roles', RoleController::class);
    // Resource routes for users
    Route::resource('users', UserController::class);



    // Resource routes for sizes
    Route::resource('sizes', SizeController::class);
    Route::get('sizes/restore/{size}', [SizeController::class, 'restore'])->name('sizes.restore');
    Route::delete('sizes/force_delete/{size}', [SizeController::class, 'forceDelete'])->name('sizes.force_delete');

    // Resource routes for brands
    Route::resource('brands', BrandController::class);
    Route::get('brands/restore/{brand}', [BrandController::class, 'restore'])->name('brands.restore');
    Route::delete('brands/force_delete/{brand}', [BrandController::class, 'forceDelete'])->name('brands.force_delete');

    // Resource routes for units
    // Route::resource('units', UnitController::class);
    // Route::get('units/restore/{unit}', [UnitController::class, 'restore'])->name('units.restore');
    // Route::delete('units/force_delete/{unit}', [UnitController::class, 'forceDelete'])->name('units.force_delete');

    //Resource routes for categories
    Route::resource('categories', CategoryController::class);
    Route::get('categories/restore/{category}', [CategoryController::class, 'restore'])->name('categories.restore');
    Route::delete('categories/force_delete/{category}', [CategoryController::class, 'forceDelete'])->name('categories.force_delete');

    //Resource routes for cities
    Route::resource('cities', CityController::class);
    Route::get('cities/restore/{city}', [CityController::class, 'restore'])->name('cities.restore');
    Route::delete('cities/force_delete/{city}', [CityController::class, 'forceDelete'])->name('cities.force_delete');

    //Resource routes for regions
    Route::resource('regions', RegionController::class);
    Route::get('regions/restore/{region}', [RegionController::class, 'restore'])->name('regions.restore');
    Route::delete('regions/force_delete/{region}', [RegionController::class, 'forceDelete'])->name('regions.force_delete');

    //Resource routes for settings
    Route::resource('settings', SettingController::class)->only('index');

    //contacts
    Route::resource('contacts', ContactController::class);
    Route::post("messages/send/{contact}", [ContactController::class, "sendMessage"])->name("contacts.sendMessage");

    //Resource Route for delivery_times
    Route::resource('delivery_times', DeliveryTimeController::class);

    //Resourse route for pages
    Route::resource('pages', PageController::class);

    //Resourse route for payments
    Route::resource('payments', PaymentController::class);

    //Resourse route for addresses
    Route::resource('addresses', AddressController::class);



    //Resource route for Orders
    Route::resource("orders", OrderController::class)->only('index', 'show');

    //Resource route for Order Item Returns
   Route::resource('orderItemReturns', OrderItemReturnController::class)->only('index', 'show');

    //Resource route for Coupons
    Route::resource('coupons', CouponController::class);

    // Pesdource Route for Products
    Route::resource('products', ProductController::class);
    Route::get('getCategoryByService/{id}', [ProductController::class, 'getCategoryByService']);

    //Resource route for reviews
    Route::resource('reviews', ReviewController::class);

    //Resource route for activity_logs
    // Route::get('activity_logs', [ActivityLogController::class, 'index'])->name('activity_logs.index');

    // Route::get('trash_buckets', [TrashBucketController::class, 'index'])->name('trash_buckets.index');
    // Route::get('trash_buckets/restore/{id}', [TrashBucketController::class, 'restore']);


    //Resource route for notifications
    Route::resource('notifications', NotificationController::class)->only(['index', 'create', 'store', 'show']);
    Route::get('notifications/mark_as_read/{id}', [NotificationController::class, 'markAsRead']);



    // Cache management
    // Route::get('cache/clear', [CacheController::class, 'index'])->name('cache');

    //toggle
    Route::prefix('active')->group(function () {
        Route::get('users/{user}', [AjaxController::class, 'userActive'])->name('users.active');
        Route::get('services/{service}', [AjaxController::class, 'serviceActive'])->name('services.active');
        Route::get('sizes/{size}', [AjaxController::class, 'sizeActive'])->name('sizes.active');
        Route::get('brands/{brand}', [AjaxController::class, 'brandActive'])->name('brands.active');
        Route::get('units/{unit}', [AjaxController::class, 'unitActive'])->name('units.active');
        Route::get('additions/{addition}', [AjaxController::class, 'additionActive'])->name('additions.active');
        Route::get('categories/{category}', [AjaxController::class, 'categoryActive'])->name('categories.active');
        Route::get('cities/{city}', [AjaxController::class, 'cityActive'])->name('cities.active');
        Route::get('regions/{region}', [AjaxController::class, 'regionActive'])->name('regions.active');
        Route::get('delivery_times/{delivery_time}', [AjaxController::class, 'deliveryTimeActive'])->name('delivery_times.active');
        Route::get('pages/{page}', [AjaxController::class, 'pageActive'])->name('pages.active');
        Route::get('payments/{payment}', [AjaxController::class, 'paymentActive'])->name('payments.active');
        Route::get('sliders/{slider}', [AjaxController::class, 'sliderActive'])->name('sliders.active');
        Route::get('coupons/{coupon}', [AjaxController::class, 'couponActive'])->name('coupons.active');
        Route::get('reviews/{review}', [AjaxController::class, 'reviewActive'])->name('reviews.active');
        Route::get('contacts/{contact}', [AjaxController::class, 'seen'])->name('contacts.seen');
        Route::get('products/{product}', [AjaxController::class, 'productActive'])->name('products.active');
    });

    Route::prefix('products')->group(function () {
        Route::get('returned/{product}', [AjaxController::class, 'returned'])->name('products.is_returned');
        Route::get('special/{product}', [AjaxController::class, 'special'])->name('products.is_special');
    });
    Route::get('orders/cancel/{order}', [AjaxController::class, 'cancel'])->name('orders.cancel');
    Route::post('orders/change_status/{order}', [AjaxController::class, 'changeStatus'])->name('orders.change_status');
    Route::get('coupons/finish/{coupon}', [AjaxController::class, 'finish'])->name('coupons.finish');
    
    Route::delete('sessions/{id}', [AjaxController::class, 'destroySession']);
    Route::post('settings/update-single', [AjaxController::class, 'updateSetting'])->name('settings.update-single');
});
