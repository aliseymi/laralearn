@extends('layouts.app')


@section('script')
    <script>
        function changeQuantity(event,id,cartName = 'default'){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            });

            $.ajax({
                url: '/cart/quantity/change',
                type: 'POST',
                data: JSON.stringify({
                    id: id,
                    quantity: event.target.value,
                    cart: cartName,
                    _method: 'patch'
                }),
                success: function (res){
                    location.reload();
                }
            });
        }
    </script>
@endsection

@section('content')
    <div class="container px-3 my-5 clearfix">
        <!-- Shopping cart table -->
        <div class="card">
            <div class="card-header">
                <h2>سبد خرید</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered m-0">
                        <thead>
                        <tr>
                            <!-- Set columns width -->
                            <th class="text-center py-3 px-4" style="min-width: 400px;">نام محصول</th>
                            <th class="text-right py-3 px-4" style="width: 150px;">قیمت واحد</th>
                            <th class="text-center py-3 px-4" style="width: 120px;">تعداد</th>
                            <th class="text-right py-3 px-4" style="width: 150px;">قیمت نهایی</th>
                            <th class="text-center align-middle py-3 px-0" style="width: 40px;"><a href="#" class="shop-tooltip float-none text-light" title="" data-original-title="Clear cart"><i class="ino ion-md-trash"></i></a></th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach(Cart::instance('laralearn')->all() as $cart)

                            @php
                                $product = $cart['product'];
                            @endphp
                            <tr>
                                <td class="p-4">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <a href="#" class="d-block text-dark">{{ $product->title }}</a>
                                            @if($product->attributes)
                                                <small>
                                                    @foreach($product->attributes->take(3) as $attr)
                                                       <span class="text-muted">{{ $attr->name }}: </span> {{ $attr->pivot->value->value }} &nbsp;
                                                    @endforeach
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                @if(!$cart['discount_percent'])
                                    <td class="text-right font-weight-semibold align-middle p-4">{{ $product->price }} تومان</td>
                                @else
                                    <td class="text-right font-weight-semibold align-middle p-4">
                                        <del class="text-danger text-sm">{{ $product->price }} تومان</del>
                                        <span class="d-block">{{ $product->price - ($product->price * $cart['discount_percent']) }} تومان</span>
                                    </td>
                                @endif
                                <td class="align-middle p-4">
                                    <select name="" onchange="changeQuantity(event,'{{ $cart['id'] }}','laralearn')" class="form-control text-center">
                                        @foreach(range(1,$product->inventory) as $item)
                                            <option value="{{ $item }}" {{ $item == $cart['quantity'] ? 'selected' : '' }}>{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="text-right font-weight-semibold align-middle p-4">تومان {{ $product->price * $cart['quantity'] }}</td>

                                @if(!$cart['discount_percent'])
                                    <td class="text-right font-weight-semibold align-middle p-4">{{ $product->price }} تومان</td>
                                @else
                                    <td class="text-right font-weight-semibold align-middle p-4">
                                        <del class="text-danger text-sm">{{ $product->price * $cart['quantity'] }} تومان</del>
                                        <span class="d-block">{{ ($product->price - ($product->price * $cart['discount_percent'])) * $cart['quantity'] }} تومان</span>
                                    </td>
                                @endif

                                <td class="text-center align-middle px-0">
                                    <form action="{{ route('cart.destroy',$cart['id']) }}" method="POST" id="delete-cart-{{ $product->id }}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <a href="#" onclick="event.preventDefault();document.getElementById('delete-cart-{{ $product->id }}').submit()" class="shop-tooltip close float-none text-danger" title="" data-original-title="Remove">×</a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                    @php
                        $totalPrice = Cart::all()->sum(function ($cart){
                            return $cart['discount_percent'] == 0
                                    ? $cart['product']->price * $cart['quantity']
                                    : ($cart['product']->price - ($cart['product']->price * $cart['discount_percent'])) * $cart['quantity'];
                        });
                    @endphp

                </div>
                <!-- / Shopping cart table -->
                <div class="d-flex flex-wrap justify-content-between align-items-center pb-4">

                    <form action="{{ route('cart.discount.check') }}" method="POST" class="mt-3">
                        @csrf
                        <input type="hidden" name="cart" value="laralearn">
                        <input type="text" class="form-control" placeholder="کد تخفیف دارید؟" name="discount">
                        <button class="btn btn-success mt-2" type="submit">اعمال تخفیف</button>

                        @if($errors->has('discount'))
                            <div class="text-danger text-sm mt-2">{{ $errors->first('discount') }}</div>
                        @endif
                    </form>

                    <div class="mt-4"></div>
                    <div class="d-flex">
{{--                        <div class="text-right mt-4 mr-5">--}}
{{--                            <label class="text-muted font-weight-normal m-0">Discount</label>--}}
{{--                            <div class="text-large"><strong>$20</strong></div>--}}
{{--                        </div>--}}
                        <div class="text-right mt-4">
                            <label class="text-muted font-weight-normal m-0">قیمت کل</label>
                            <div class="text-large"><strong>{{ $totalPrice }} تومان</strong></div>
                        </div>
                    </div>
                </div>

                <div class="float-left">
                    <form action="{{ route('cart.payment') }}" method="POST" id="cart-payment">
                        @csrf
                    </form>
                    <button onclick="document.getElementById('cart-payment').submit()" type="button" class="btn btn-lg btn-primary mt-2">پرداخت</button>
                </div>

            </div>
        </div>
    </div>
@endsection
