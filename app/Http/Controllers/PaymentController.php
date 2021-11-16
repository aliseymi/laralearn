<?php

namespace App\Http\Controllers;

use App\Helpers\Cart\Cart;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment()
    {
        $cart = Cart::instance('laralearn');
        $cartItems = $cart->all();

        if($cartItems->count()){
            $price = $cartItems->sum(function ($item){
                return $item['product']->price * $item['quantity'];
            });

            $orderItems = $cartItems->mapWithKeys(function ($cart){
                return [ $cart['product']->id => ['quantity' => $cart['quantity']] ];
            });

            $order = auth()->user()->orders()->create([
                'price' => $price,
                'status' => 'unpaid'
            ]);

            $order->products()->attach($orderItems);

            return 'ok';
        }

        return back();
    }
}
