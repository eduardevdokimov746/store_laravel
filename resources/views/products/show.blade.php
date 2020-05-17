@extends('layouts.app.main')

@section('content')
    <!-- breadcrumbs -->
    <div class="container">
        <ol class="breadcrumb breadcrumb1">
            {!! $breadcrumbs->getHtml() !!}
        </ol>
        <div class="clearfix"></div>
    </div>
    <!-- //breadcrumbs -->
    <!-- products -->
    <div class="products">
        <div class="container" data-id='{{ $product->id }}'>
            <div class="single-page">
                <div class="single-page-row" id="detail-21">
                    <div class="col-md-6 single-top-left">
                        <div class="flexslider">
                            @include('includes.products.show-imagezoom', [$product])
                        </div>
                    </div>
                    <div class="col-md-6 single-top-right">
                        <h3 class="item_name">{{ $product->title }}</h3>


                        <div class="single-rating">
                            <ul>
                                @for($x = 1; $x < 6; $x++)
                                    @if($x <= $product->info->rating)
                                        <li><i class='fa fa-star' style='color: #0280e1;' aria-hidden='true'></i></li>
                                    @else
                                        <li><i class='fa fa-star-o' style='color: #0280e1;' aria-hidden='true'></i></li>
                                    @endif
                                @endfor
                                <li class="rating">{{ $product->comments_count }}&nbsp;оценок</li>
                            </ul>
                        </div>

                        <div class="single-price">
                            <ul>
                                <li>{!! $symbolCurrency !!}&nbsp;{{ $product->price }}</li>
                                @if($product->old_price > 0)
                                    <li>
                                        <del style="font-size: 1.5em">{!! $symbolCurrency !!}
                                            &nbsp;{{ $product->old_price }}</del>
                                    </li>
                                    <li><span class="w3off">{{ $product->discount }}%&nbsp;СКИДКА</span></li>
                                @endif
                            </ul>
                        </div>
                        <p class="single-price-text">{{ $product->little_specifications }}</p>

                        <button data-id='{{ $product->id }}' class="addToCart w3ls-cart"><i class="fa fa-cart-plus"
                                                                                            aria-hidden="true"></i>Купить
                        </button>
                        @if($issetInWishlist)
                            <button class="w3ls-cart w3ls-cart-like" id='add-wish-list'>
                                <i class="fas fa-heart"></i>&nbsp;В списке желаний
                            </button>
                        @else
                            <button class="w3ls-cart w3ls-cart-like" id='add-wish-list'>
                                <i class="fa fa-heart-o" aria-hidden="true"></i>&nbsp;В список желаний
                            </button>
                        @endif
                        @if($issetComparison)
                            <button class="w3ls-cart w3ls-cart-like" data-type='press' id='add-comparison-list'><i
                                    class="fas fa-balance-scale"></i>&nbsp;Сравнивается
                            </button>
                        @else
                            <button class="w3ls-cart w3ls-cart-like" id='add-comparison-list'><i
                                    class="fas fa-balance-scale"></i>&nbsp;К сравнению
                            </button>
                        @endif
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <br><br><br><br>

            <div class="row">
                <div class='col-md-7'>
                    <h3 class="w3ls-title">Характеристики</h3>
                    {!! $product->info->big_specifications !!}
                </div>


                <div class='col-md-5'>

                    @include('includes.products.show-comments', [$product, $comments])

                    @include('includes.products.show-form_comment', [$product])

                </div>
            </div>


            <!-- recommendations -->
            <?php if(!empty($viewedProducts)): ?>
            <div class="recommend">
                <h3 class="w3ls-title">Просмотренные ранее</h3>
                <script>
                    $(document).ready(function () {
                        $("#owl-demo5").owlCarousel({

                            autoPlay: 3000, //Set AutoPlay to 3 seconds

                            items: 4,
                            itemsDesktop: [640, 5],
                            itemsDesktopSmall: [414, 4],
                            navigation: true

                        });

                    });
                </script>
                <div id="owl-demo5" class="owl-carousel">
                    @foreach (WievedProduct::get() as $viewedProduct)
                    <div class="item">
                        <div class="glry-w3agile-grids agileits" style="height: 250px;">
                            {{ $viewedProduct['sticker'] }}
                            <a href="{{ route('products.show', $viewedProduct->slug) }}"><img
                                    src="{{ asset($viewedProduct->imagePath) }}" alt="img"></a>
                            <div class="view-caption agileits-w3layouts">
                                <h4>
                                    <a title='{{ $viewedProduct->title }}'
                                       href="{{ route('products.show', $viewedProduct->slug) }}"></a>
                                </h4>

                                <h5>{!! $symbolCurrency !!}&nbsp;$viewedProduct['price'] ?></h5>
                                <button class="w3ls-cart addToCart" data-id='{{ $viewedProduct->id }}'><i
                                        class="fa fa-cart-plus" aria-hidden="true"></i>Купить
                                </button>

                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        <?php endif; ?>
        <!-- //recommendations -->

        </div>
    </div>
@endsection
