<?php

use Illuminate\Support\Facades\Route;

Route::get('/',function (){
    return view('admin.index');
});

Route::resource('users',\App\Http\Controllers\Admin\UserController::class);
Route::resource('permissions',\App\Http\Controllers\Admin\PermissionController::class);
Route::resource('roles',\App\Http\Controllers\Admin\RoleController::class);

