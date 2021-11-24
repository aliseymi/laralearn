<?php

namespace App\Helpers\Cart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use phpDocumentor\Reflection\Types\Integer;

/**
 * Class Cart
 * @package App\Helpers\Cart
 * @method static bool has(string|Model $key)
 * @method static array get(string|Model $key)
 * @method static Collection all()
 * @method static Cart put(array $value, Model $obj = null)
 * @method static Cart update(string|Model $key, mixed $options)
 * @method static int|mixed count(string|Model $key)
 * @method static bool delete(string|Model $key)
 * @method static Cart instance(string $name)
 * @method static Cart flush()
 * @method static void addDiscount(string|Integer $discount)
 */

class Cart extends Facade
{
    protected static function getFacadeAccessor()
    {
       return 'cart';
    }
}
