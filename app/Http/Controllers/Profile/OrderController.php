<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment as ShetabitPayment;

class OrderController extends Controller
{
    public function showOrders()
    {
        $orders = auth()->user()->orders()->latest('created_at')->paginate(12);
        return view('profile.orders-list',compact('orders'));
    }

    public function showDetails(Order $order)
    {
        $this->authorize('view',$order);

        return view('profile.order-details',compact('order'));
    }

    public function payment(Order $order)
    {
        // Create new invoice.
        $invoice = (new Invoice)->amount(1000);

        return ShetabitPayment::callbackUrl(route('payment.callback'))->purchase($invoice, function($driver, $transactionId) use($order,$invoice){
            // Store transactionId in database as we need it to verify payment in the future.
            $res_number = $invoice->getUuid();

            $order->payments()->create([
                'price' => $order->price,
                'res_number' => $res_number
            ]);

        })->pay()->render();
    }
}
