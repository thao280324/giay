<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::resource('login', 'LoginController', ['only' => ['index', 'store', 'show', 'create']])->middleware('CheckUser');
Route::resource('logout', 'LogoutController', ['only' => ['index', 'store']]);

// Frontend routes
Route::group(['namespace' => 'FrontEnd'], function () {
    Route::resource('/', 'HomeController')->names([
        'index' => 'home',
        'create' => 'home.create',
    ]);
    Route::post('add-cart', 'HomeController@store')->name('home.store');
    Route::resource('category-product', 'CategoryController');
    Route::resource('product-detail', 'DetailController');
    Route::resource('cart', 'CartController');
    Route::resource('cart-address', 'AddressCartController');
    Route::resource('cart-address-vnpay', 'VnpayController');
    Route::resource('wishlist', 'WishlistController');
    Route::resource('history', 'HistoryController');
});

// Backend routes
Route::group(['namespace' => 'BackEnd'], function () {

    Route::middleware('CheckLogin')->group(function () {

        Route::resource('dashboard', 'HomeController');
        Route::prefix('dashboard')->group(function () {
            Route::post('table', 'HomeController@store_table')->name('store.table');
            Route::post('total', 'HomeController@store_total')->name('store.total');
        });

        Route::resource('account', 'AccountController');
        Route::resource('remove', 'RemoveController');
        Route::resource('product', 'ProductController');
        Route::resource('product-gallery', 'GalleryController');
        Route::resource('slider', 'SliderController');
        Route::resource('category', 'CategoryController');
        Route::resource('coupon', 'CouponController'); // <-- Đã đầy đủ các route CRUD
        Route::resource('order', 'OrderController');
        Route::resource('contacts', 'ContactController');

        Route::resource('sorting', 'SortingController')->only('store');
        Route::resource('list', 'SubCategoryController');
        Route::resource('status', 'StatusController')->only('store');
    });
});
