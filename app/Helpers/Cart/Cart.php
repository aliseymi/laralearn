<?php

namespace App\Helpers\Cart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * Class Cart
 * @package App\Helpers\Cart
 * @method static bool has(string|Model $key)
 * @method static array get(string|Model $key)
 * @method static Collection all()
 * @method static Cart put(array $value, Model $obj = null)
 */

class Cart extends Facade
{
    protected static function getFacadeAccessor()
    {
       return 'cart';
    }
}
