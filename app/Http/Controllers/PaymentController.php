<?php

namespace App\Http\Controllers;

use Modules\Cart\Helpers\Cart;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PayPing\PayPingException;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Invoice;
use \Shetabit\Payment\Facade\Payment as ShetabitPayment;

class PaymentController extends Controller
{
    public function payment()
    {
        $cart = Cart::instance('laralearn');
        $cartItems = $cart->all();

        if ($cartItems->count()) {
            $price = $cartItems->sum(function ($item) {
                return $item['discount_percent'] == 0
                    ? $item['product']->price * $item['quantity']
                    : ($item['product']->price - ($item['product']->price * $item['discount_percent'])) * $item['quantity'];
            });


            $orderItems = $cartItems->mapWithKeys(function ($cart) {
                if(! $cart['discount_percent']){
                    return [$cart['product']->id => ['quantity' => $cart['quantity'] , 'total_price' => $cart['product']->price * $cart['quantity']]];
                }else{
                    return [$cart['product']->id => ['quantity' => $cart['quantity'] , 'total_price' => (($cart['product']->price - ($cart['product']->price * $cart['discount_percent'])) * $cart['quantity'])]];
                }
            });

            $order = auth()->user()->orders()->create([
                'price' => $price,
                'status' => 'unpaid'
            ]);

            $order->products()->attach($orderItems);

            // Create new invoice.
            $invoice = (new Invoice)->amount(1000);

            return ShetabitPayment::callbackUrl(route('payment.callback'))->purchase($invoice, function($driver, $transactionId) use($order,$cart,$price,$invoice){
                // Store transactionId in database as we need it to verify payment in the future.
                $res_number = $invoice->getUuid();

                $order->payments()->create([
                    'price' => $price,
                    'res_number' => $res_number
                ]);

                $cart->flush();

            })->pay()->render();
        }

        return back();
    }

    public function callback(Request $request)
    {
        $payment = Payment::where('res_number',$request->clientrefid)->firstOrFail();

        try {
            $receipt = ShetabitPayment::amount(1000)->transactionId($request->clientrefid)->verify();

            $payment->update([
                'status' => 1
            ]);

            $payment->order()->update([
                'status' => 'paid'
            ]);

            alert()->success('???????????? ???? ???????????? ?????????? ????');
            return redirect('/products');

        } catch (InvalidPaymentException $exception) {
            /**
            when payment is not verified, it will throw an exception.
            We can catch the exception to handle invalid payments.
            getMessage method, returns a suitable message that can be used in user interface.
             **/
            alert()->error($exception->getMessage());
            return redirect('/products');
        }
    }
}
