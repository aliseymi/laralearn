@extends('profile.layout')

@section('main')
    <table class="table text-center">
        <tbody>
        <tr>
            <th>آیدی محصول</th>
            <th>نام محصول</th>
            <th>تعداد سفارش</th>
            <th>هزینه نهایی</th>
        </tr>

         @foreach($order->products as $product)
             <tr>
                 <td>{{ $product->id }}</td>
                 <td>{{ $product->title }}</td>
                 <td>{{ $product->pivot->quantity }}</td>
                 <td>{{ $product->pivot->total_price }}</td>
             </tr>
         @endforeach
        </tbody>
    </table>
@endsection
