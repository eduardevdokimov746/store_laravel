@extends('layouts.app.main')

@section('content')

    <div class='container'>
        <h3 class="w3ls-title">Списки сравнений</h3>

        @if(Comparison::isNotEmpty())

            @foreach ($comparison_product as $category_id => $collection_product)
                <div class='list-content'>

                    <h3>{{ $collection_product->pull('category_title') }}</h3>

                    <div class="products-row comparison-list" data-id='{{ $category_id }}'>
                            @foreach ($collection_product as $key => $product)
                                @if(!is_string($key))
                                <div class="col-md-3 product-grids" style="width: 280px;" data-id="{{ $product->id }}">
                                    <div class="agile-products">
                                        <div class='head-item'>
                                            <i class="fas fa-times-circle btn-del-comparison-product"
                                               style="font-size: 1.6em;"></i>
                                        </div>

                                        <a href="{{ route('products.show', $product->slug) }}">
                                            <img style="height: 180px; margin: 0 auto;"
                                                 src="{{ asset($product->imagePath) }}" class="img-responsive"
                                                 alt="img">
                                        </a>
                                        <div class="agile-product-text">
                                            <h5 style="overflow: hidden; height: 50px;">
                                                <a href="{{ route('products.index', $product->slug) }}"
                                                   title='{{ $product->title }}'>{{ $product->small_title }}</a>
                                            </h5>
                                            <h6 style="font-size: 1.5em;">{!!$symbolCurrency !!}
                                                &nbsp;{{ $product->price }}
                                                &nbsp;
                                                @if($product->old_price != 0)
                                                    <del style="font-size: 16px;">{!!$symbolCurrency !!}
                                                        &nbsp;{{ $product->old_price }}</del>
                                                @endif
                                            </h6>

                                            <button class="w3ls-cart pw3ls-cart addToCart" data-id='{{ $product->id }}'>
                                                <i class="fa fa-cart-plus" aria-hidden="true"></i>Купить
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="clearfix" style="margin-bottom: 20px;"></div>
                    @if(Comparison::getCountProductInCategory($category_id) > 1)
                        <a href='{{ route('comparison.show', $collection_product->pull('category_slug')) }}'
                           class='comparison-products'>Сравнить эти товары</a>
                    @endif
                </div>
            @endforeach

        @else
            <h3>У вас пока нет товаров для сравнения</h3>
        @endif

    </div>
@endsection
