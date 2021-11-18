<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('isActive')) {
    function isActive($routeName, $activeClassName = 'active')
    {
        if (is_array($routeName)) {
            return in_array(Route::currentRouteName(), $routeName) ? $activeClassName : '';
        }
        return Route::currentRouteName() == $routeName ? $activeClassName : '';
    }
}

if (!function_exists('isUrl')) {
    function isUrl($url, $activeClassName = 'active')
    {
        return request()->fullUrlIs($url) ? $activeClassName : '';
    }
}
