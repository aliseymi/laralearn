<?php

namespace App\Http\Controllers;

use App\Helpers\Cart\Cart;
use App\Models\Product;
use http\Env\Response;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function showCart()
    {
        return view('home.cart');
    }

    public function addToCart(Product $product)
    {
        if(Cart::has($product)){
            if(Cart::count($product) < $product->inventory){
                Cart::update($product,1);
            }
        }else{
            Cart::put([
                'quantity' => 1,
            ],$product);
        }

        return redirect('/cart');
    }

    public function changeQuantity(Request $request)
    {
        $data = $request->validate([
            'id' => 'required',
            'quantity' => 'required',
//            'cart' => 'required'
        ]);

        $product = Cart::get($data['id'])['product'];

        if($data['quantity'] > $product->inventory || $data['quantity'] < 0){
            return \response(['status' => 'forbidden'],403);
        }

        if(Cart::has($data['id'])){

            Cart::update($data['id'],[
                'quantity' => $data['quantity']
            ]);

            return \response([
                'status' => 'success'
            ]);
        }

        return \response(['status' => 'error'],404);
    }
}
