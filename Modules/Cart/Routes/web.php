<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('cart')->namespace('Frontend')->group(function() {
    Route::get('/','CartController@showCart');
    Route::post('/add/{product}','CartController@addToCart')->name('cart.add');
    Route::patch('/quantity/change','CartController@changeQuantity');
    Route::delete('/delete/{cart}','CartController@deleteFromCart')->name('cart.destroy');
});
