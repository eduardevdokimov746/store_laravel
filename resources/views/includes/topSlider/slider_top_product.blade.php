<!-- Слайдер топ товаров -->
<div class="welcome">
    <div class="container">
        <div class="welcome-info">
            <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
                <!-- Переключатели слайдера товаров -->

                <ul id="myTab" class=" nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#home" id="home-tab" role="tab" data-toggle="tab">
                            <i class="fa fa-laptop" aria-hidden="true"></i>
                            <h5>{{ $htmlButtonSlider[0]['title'] }}</h5>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#carl" role="tab" id="carl-tab" data-toggle="tab">
                            <i class="fa fa-mobile" aria-hidden="true"></i>
                            <h5>{{ $htmlButtonSlider[1]['title'] }}</h5>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#james" role="tab" id="james-tab" data-toggle="tab">
                            <i class="fas fa-snowflake" aria-hidden="true" style="font-size: 55px;"></i>
                            <h5>{{ $htmlButtonSlider[2]['title'] }}</h5>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#decor" role="tab" id="decor-tab" data-toggle="tab">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <h5>{{ $htmlButtonSlider[3]['title'] }}</h5>
                        </a>
                    </li>
                </ul>
                <div class="clearfix"></div>

                <h3 class="w3ls-title">Рекомендуемые товары</h3>
                <div id="myTabContent" class="tab-content">
                    @foreach($productSlider as $key => $products)
                        @include('includes.topSlider.products', [$key, $products, $dataCarusel])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Слайдер топ товаров -->
