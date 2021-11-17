<?php

namespace App\Http\Controllers;

use App\Helpers\Cart\Cart;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PayPing\PayPingException;

class PaymentController extends Controller
{
    public function payment()
    {
        $cart = Cart::instance('laralearn');
        $cartItems = $cart->all();

        if ($cartItems->count()) {
            $price = $cartItems->sum(function ($item) {
                return $item['product']->price * $item['quantity'];
            });

            $orderItems = $cartItems->mapWithKeys(function ($cart) {
                return [$cart['product']->id => ['quantity' => $cart['quantity']]];
            });

            $order = auth()->user()->orders()->create([
                'price' => $price,
                'status' => 'unpaid'
            ]);

            $order->products()->attach($orderItems);

            $res_number = Str::random();
            $token = config('services.payping.token');
            $args = [
                "amount" => 1000,
                "payerName" => auth()->user()->name,
                "returnUrl" => route('payment.callback'),
                "clientRefId" => $res_number
            ];

            $payment = new \PayPing\Payment($token);

            try {
                $payment->pay($args);
            } catch (\Exception $e) {
                throw $e;
            }

            $order->payments()->create([
                'price' => $price,
                'res_number' => $res_number
            ]);

            $cart->flush();
//echo $payment->getPayUrl();

            return redirect($payment->getPayUrl());
        }

        return back();
    }

    public function callback(Request $request)
    {
        $payment = Payment::where('res_number',$request->clientrefid)->firstOrFail();

        $token = config('services.payping.token');

        $payping = new \PayPing\Payment($token);

        try {
            if($payping->verify($request->refid, 1000)){

                $payment->update([
                    'status' => 1
                ]);

                $payment->order()->update([
                    'status' => 'paid'
                ]);

                alert()->success('پرداخت با موفقیت انجام شد');
                return redirect('/products');

            }else{
                alert()->error('پرداخت موفق نبود');
                return redirect('/products');
            }
        }
        catch (PayPingException $e) {
            $errors = collect(json_decode($e->getMessage(), true));
            alert()->error($errors->first());

            return redirect('/products');
        }
    }
}
