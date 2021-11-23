<?php

use Illuminate\Support\Facades\Route;

Route::resource('discount','DiscountController')->except(['show']);
