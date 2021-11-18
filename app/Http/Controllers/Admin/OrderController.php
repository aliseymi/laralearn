<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:show-orders')->only(['index']);
        $this->middleware('can:edit-order')->only(['edit','update']);
        $this->middleware('can:delete-order')->only(['destroy']);
        $this->middleware('can:show-order-details')->only(['show']);
        $this->middleware('can:show-order-payments')->only(['payments']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::query()->whereStatus(\request('type'));;

        if($search = \request('search')){
            $orders->where('id',$search)->orWhere('tracking_serial',$search);
        }

        $orders = $orders->latest()->paginate(12);
        return view('admin.orders.all',compact('orders'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $products = $order->products()->paginate(20);

        return view('admin.orders.details',compact('products','order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('admin.orders.edit',compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required',Rule::in(['unpaid','paid','posted','received','preparation','canceled'])],
            'tracking_serial' => 'required'
        ]);

        $order->update($data);

        alert()->success('ویرایش سفارش با موفقیت انجام شد');

        return redirect(route('admin.orders.index',['type' => $order->status]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();

        alert()->success('سفارش مورد نظر با موفقیت حذف شد');

        return back();
    }

    public function payments(Order $order)
    {
        $payments = $order->payments();

        if($search = \request('search')){
            $payments->where('id',$search)->orWhere('res_number',$search);
        }

        $payments = $payments->paginate(20);

        return view('admin.orders.payments',compact('payments','order'));
    }
}
