@extends('layouts.app.main')

@section('content')
    <div class='container'>
        <h3 class='w3ls-title'>Просмотренные товары</h3>

        <div class="products-row " style="margin-bottom: 30px;">
            @if(ViewedProduct::isEmpty())
                <br>
                <h3>Список пуст</h3>
            @else
                @foreach(ViewedProduct::get() as $product)
                    <div class="col-md-3 product-grids" style="width: 280px;">
                        <div class="agile-products">
                            {!! $product->sticker !!}
                            <a href="{{ route('products.show', $product->slug) }}"><img
                                    style="height: 180px; margin: 0 auto;"
                                    src="{{ asset('storage/images/' . $product->img) }}" class="img-responsive"
                                    alt="img"></a>
                            <div class="agile-product-text">
                                <h5 style="overflow: hidden; height: 50px;"><a
                                        href="{{ route('products.show', $product->slug) }}"
                                        title='{{ $product->title }}'>{{ $product->small_title }}</a></h5>
                                <h6 style="font-size: 1.5em;">{!! $symbolCurrency !!}&nbsp;{{ $product->price }}&nbsp;
                                    @if($product->old_price > 0)
                                        <del style="font-size: 16px;">{!! $symbolCurrency !!}
                                            &nbsp;{{ $product->old_price }}</del>
                                    @endif
                                </h6>
                                <button class="w3ls-cart pw3ls-cart addToCart" data-id='{{ $product->id }}'><i
                                        class="fa fa-cart-plus" aria-hidden="true"></i>Купить
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
            <div class="clearfix"></div>
        </div>
    </div>
@endsection
