<?php

namespace Modules\Discount\Http\Controllers\Frontend;

use Modules\Cart\Helpers\Cart;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Discount\Entities\Discount;

class DiscountController extends Controller
{
    public function check(Request $request)
    {
        $validated = $request->validate([
            'discount' => 'required|exists:discounts,code',
            'cart' => 'required'
        ],[
            'discount.required' => 'در صورت داشتن کد تخفیف آن را وارد کنید'
        ]);

        if(! auth()->check()){
            return back()->withErrors([
                'discount' => 'برای اعمال تخفیف لطفا وارد سایت شوید'
            ]);
        }

        $discount = Discount::whereCode($validated['discount'])->first();

        if(! $discount->users->contains('id',auth()->user()->id)){
            return back()->withErrors([
                'discount' => 'شما قادر به استفاده از این کد تخفیف نمی باشید'
            ]);
        }

        if($discount->expired_at < now()){
            return back()->withErrors([
                'discount' => 'مهلت استفاده از این کد تخفیف به پایان رسیده است'
            ]);
        }

        $cart = Cart::instance($validated['cart']);
        $cart->addDiscount($discount->code);

        return back();
    }

    public function destroy(Request $request)
    {
        $cart = Cart::instance($request->cart);

        $cart->addDiscount(null);

        return back();
    }
}
