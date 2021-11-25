<?php

namespace Modules\Cart\Http\Controllers\Frontend;

use Modules\Cart\Helpers\Cart;
use App\Models\Product;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CartController extends Controller
{

    public function showCart()
    {
        return view('cart::cart');
    }

    public function addToCart(Product $product)
    {
        $cart = Cart::instance('laralearn');

        if ($cart->has($product)) {
            if ($cart->count($product) < $product->inventory) {
                $cart->update($product, 1);
            }
        } else {
            $cart->put([
                'quantity' => 1,
            ], $product);
        }

        return redirect('/cart');
    }

    public function changeQuantity(Request $request)
    {
        $data = $request->validate([
            'id' => 'required',
            'quantity' => 'required',
            'cart' => 'required'
        ]);

        $cart = Cart::instance($data['cart']);

        $product = $cart->get($data['id'])['product'];

        if ($data['quantity'] > $product->inventory || $data['quantity'] < 0) {
            return \response(['status' => 'forbidden'], 403);
        }

        if ($cart->has($data['id'])) {

            $cart->update($data['id'], [
                'quantity' => $data['quantity']
            ]);

            return \response([
                'status' => 'success'
            ]);
        }

        return \response(['status' => 'error'], 404);
    }

    public function deleteFromCart($id)
    {
        $cart = Cart::instance('laralearn');
        $cart->delete($id);

        return back();
    }
}
