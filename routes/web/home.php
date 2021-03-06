<?php

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
//    return \Illuminate\Support\Facades\URL::temporarySignedRoute('download.file',now()->addSeconds(30),['user' => auth()->user()->id,'path' => 'files/WLE4hk.png']);

    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/auth/google',[\App\Http\Controllers\Auth\GoogleAuthController::class,'redirect'])->name('auth.google');
Route::get('/auth/google/callback',[\App\Http\Controllers\Auth\GoogleAuthController::class,'callback']);

Route::get('/auth/github',[\App\Http\Controllers\Auth\GithubAuthController::class,'redirect'])->name('auth.github');
Route::get('/auth/github/callback',[\App\Http\Controllers\Auth\GithubAuthController::class,'callback']);

Route::middleware('auth')->group(function (){
    Route::prefix('profile')->group(function (){
        Route::get('/',[\App\Http\Controllers\Profile\indexController::class,'index'])->name('profile');
        Route::get('twofactor',[\App\Http\Controllers\Profile\twoFactorAuthController::class,'manageTwoFactor'])->name('profile.2fa.manage');
        Route::post('twofactor',[\App\Http\Controllers\Profile\twoFactorAuthController::class,'postTwoFactor']);
        Route::get('twofactor/phone',[\App\Http\Controllers\Profile\tokenAuthController::class,'getPhoneVerify'])->name('profile.2fa.phone');
        Route::post('twofactor/phone',[\App\Http\Controllers\Profile\tokenAuthController::class,'postPhoneVerify']);
        Route::get('orders',[\App\Http\Controllers\Profile\OrderController::class,'showOrders'])->name('profile.orders');
        Route::get('orders/{order}',[\App\Http\Controllers\Profile\OrderController::class,'showDetails'])->name('profile.order.details');
        Route::get('orders/{order}/payment',[\App\Http\Controllers\Profile\OrderController::class,'payment'])->name('profile.order.payment');
    });
    Route::post('comments',[\App\Http\Controllers\HomeController::class,'comment'])->name('send.comment');
    Route::post('payment',[\App\Http\Controllers\PaymentController::class,'payment'])->name('cart.payment');
    Route::get('payment/callback',[\App\Http\Controllers\PaymentController::class,'callback'])->name('payment.callback');
});

Route::get('auth/token',[\App\Http\Controllers\Auth\AuthTokenController::class,'getToken'])->name('2fa.token');
Route::post('auth/token',[\App\Http\Controllers\Auth\AuthTokenController::class,'postToken']);

Route::get('products',[\App\Http\Controllers\ProductController::class,'index']);
Route::get('products/{product}',[\App\Http\Controllers\ProductController::class,'single']);


Route::get('download/{user}/file',function ($file){
    return \Illuminate\Support\Facades\Storage::download(request('path'));
})->name('download.file')->middleware('signed');

