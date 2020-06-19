@extends('layouts.app.main')

@section('content')
    <!-- products -->
    <div class="products">
        <div class="container">
            <div class="col-md-12 product-w3ls-right">
                <div class="product-top">
                    <h4>Поиск по запросу "{{ $searchText }}"</h4>
                        {{ \App\Services\Sort::run($sort) }}
                    <div class="clearfix"> </div>
                </div>

                <div class="products-row">
                    @forelse($products as $product)
                        <div class="col-md-3 product-grids" style="width: 280px;">
                            <div class="agile-products">
                                {!! $product->sticker !!}
                                <a href="{{ route('products.show', $product->slug) }}">
                                    <img style="height: 180px; margin: 0 auto;" src="{{ asset($product->imagePath) }}" class="img-responsive" alt="img">
                                </a>
                                <div class="agile-product-text">
                                    <h5 style="overflow: hidden; height: 50px;">
                                        <a href="{{ route('products.show', $product->slug) }}" title='{{ $product->title }}'>{{ $product->small_title }}</a>
                                    </h5>
                                    <h6 style="font-size: 1.5em;">{!!$symbolCurrency !!}&nbsp;{{ $product->price }}&nbsp;
                                        @if($product->old_price != 0)
                                            <del style="font-size: 16px;">{!!$symbolCurrency !!}&nbsp;{{ $product->old_price }}</del>
                                        @endif
                                    </h6>

                                    <button class="w3ls-cart pw3ls-cart addToCart" data-id='{{ $product->id }}'>
                                        <i class="fa fa-cart-plus" aria-hidden="true"></i>Купить
                                    </button>

                                </div>
                            </div>
                        </div>
                    @empty
                        <br>
                        <h3>Товары не найдены</h3>
                    @endforelse



                    <div class="clearfix"> </div>
                </div>
            </div>

            {{ $products->appends(['sort' => $sort])->links() }}
            <div class="clearfix"> </div>
        </div>
    </div>
    <!--//products-->
    <div class="preloader"><img src="{{ asset('storage/images/ring.svg') }}"></div>
@endsection
