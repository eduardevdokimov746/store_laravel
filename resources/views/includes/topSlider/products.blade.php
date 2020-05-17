<div role="tabpanel" class="tab-pane fade in {{ ($key == 0)? 'active' : '' }}" id="{{ $dataCarusel[$key] }}"
     aria-labelledby="{{ $dataCarusel[$key] }}-tab">
    <div class="tabcontent-grids">
        @if($key != 0)
            <script>
                $(document).ready(function () {
                    $('#owl-demo{{ ($key != 0) ? $key : '' }}').owlCarousel({
                        autoPlay: 3000, //Set AutoPlay to 3 seconds
                        items: 4,
                        itemsDesktop: [640, 5],
                        itemsDesktopSmall: [414, 4],
                        navigation: true
                    });
                });
            </script>
        @endif

        <div id="owl-demo{{ ($key != 0) ? $key : ''}}" class="owl-carousel">
            @foreach ($products as $product)
                <div class="item">
                    <div class="glry-w3agile-grids agileits" style="height: 250px;">
                        {!! $product->sticker !!}
                        <a href="{{ route('products.show', $product->slug) }}">
                            <img width="100%" src="{{ asset('storage/images/' . $product['img']) }}" alt="img">
                        </a>
                        <div class="view-caption agileits-w3layouts">
                            <h4>
                                <a href="{{ route('products.show', $product->slug) }}"
                                   title="{{ $product->title }}">
                                    {{ $product->small_title }}
                                </a>
                            </h4>
                            <p></p>
                            <h5>{!! $symbolCurrency !!}&nbsp;{{ $product->price }}</h5>
                            <button class="w3ls-cart addToCart" data-id='{{ $product->id }}'>
                                <i class="fa fa-cart-plus" aria-hidden="true"></i>Купить
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
