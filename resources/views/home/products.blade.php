@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @foreach($products->chunk(4) as $row)
                    <div class="row">
                        @foreach($row as $product)
                            <div class="col-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $product->title }}</h6>
                                        <p class="card-text">{{ $product->description }}</p>
                                        <a href="/products/{{ $product->id }}" class="btn btn-primary">جزئیات محصول</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
