<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Đây là nơi bạn có thể đăng ký các route web cho ứng dụng của mình.
| Các route này được load bởi RouteServiceProvider trong nhóm "web".
*/

/// Login/Logout
Route::middleware('CheckUser')->group(function () {
    Route::get('login', 'LoginController@index')->name('login.index');
    Route::post('login', 'LoginController@store')->name('login.store');
    Route::get('login/create', 'LoginController@create')->name('login.create');
    Route::get('login/{login}', 'LoginController@show')->name('login.show');
});

Route::post('logout', 'LogoutController@store')->name('logout.store');
Route::get('logout', 'LogoutController@index')->name('logout.index');


/// FRONTEND
Route::group(['namespace' => 'FrontEnd'], function () {
    // Trang chủ và thêm vào giỏ hàng
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/create', 'HomeController@create')->name('home.create');

    Route::post('add-cart', 'HomeController@store')->name('home.store');

    // Các resource routes khác
    Route::resource('category-product', 'CategoryController');
    Route::resource('product-detail', 'DetailController');
    Route::resource('cart', 'CartController');
    Route::resource('cart-address', 'AddressCartController');
    Route::resource('cart-address-vnpay', 'VnpayController');
    Route::resource('wishlist', 'WishlistController');
    Route::resource('history', 'HistoryController');
});


/// BACKEND
Route::group(['namespace' => 'BackEnd', 'middleware' => 'CheckLogin'], function () {
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
    Route::resource('coupon', 'CouponController');
    Route::resource('order', 'OrderController');
    Route::resource('contacts', 'ContactController');
    Route::resource('list', 'SubCategoryController');

    // Chỉ sử dụng phương thức store
    Route::post('sorting', 'SortingController@store')->name('sorting.store');
    Route::post('status', 'StatusController@store')->name('status.store');
});
