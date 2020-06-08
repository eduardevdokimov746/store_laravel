@extends('layouts.app.main')

@push('scripts')
    <script src="js/custom.js"></script>
@endpush

@section('content')
    <!-- banner -->
    <div class="banner">
        <div id="kb" class="carousel kb_elastic animate_text kb_wrapper" data-ride="carousel" data-interval="6000" data-pause="hover">
            <!-- Wrapper-for-Slides -->
            <div class="carousel-inner" role="listbox">
                <div class="item active"><!-- First-Slide -->
                    <img src="{{ asset('images/5.jpg') }}" alt="" class="img-responsive" />
                    <div class="carousel-caption kb_caption kb_caption_right">
                        <h3 data-animation="animated flipInX">Постоянные <span>50%</span> скидки</h3>
                        <h4 data-animation="animated flipInX">Горячее предложение только сегодня</h4>
                    </div>
                </div>
                <div class="item"> <!-- Second-Slide -->
                    <img src="{{ asset('images/8.jpg') }}" alt="" class="img-responsive" />
                    <div class="carousel-caption kb_caption kb_caption_right">
                        <h3 data-animation="animated fadeInDown">Наши последние модные предложения</h3>
                        <h4 data-animation="animated fadeInUp">Актуальный стиль</h4>
                    </div>
                </div>
                <div class="item"><!-- Third-Slide -->
                    <img src="{{ asset('images/3.jpg') }}" alt="" class="img-responsive"/>
                    <div class="carousel-caption kb_caption kb_caption_center">
                        <h3 data-animation="animated fadeInLeft">Конец сезонной распродажи</h3>
                        <h4 data-animation="animated flipInX">Успей купить</h4>
                    </div>
                </div>
            </div>
            <!-- Left-Button -->
            <a class="left carousel-control kb_control_left" href="#kb" role="button" data-slide="prev">
                <span class="fa fa-angle-left kb_icons" aria-hidden="true"></span>
                <span class="sr-only">Предыдущий</span>
            </a>
            <!-- Right-Button -->
            <a class="right carousel-control kb_control_right" href="#kb" role="button" data-slide="next">
                <span class="fa fa-angle-right kb_icons" aria-hidden="true"></span>
                <span class="sr-only">Следующий</span>
            </a>
        </div>
    </div>
    <!-- //banner -->
    <!-- welcome -->

    @include('includes.topSlider.slider_top_product', [$productSlider, $htmlButtonSlider, $dataCarusel])

    <!-- //welcome -->
    <!-- add-products -->
    <div class="add-products">
        <div class="container">
            <div class="add-products-row">
                <div class="w3ls-add-grids">
                    <a href="{{ url('categories/smartphones/products?sort=pop') }}">
                        <h4>ТОП-10 ТЕНДЕНЦИЙ ДЛЯ ВАС <span>20%</span> СКИДКА</h4>
                        <h6>Купить <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></h6>
                    </a>
                </div>
                <div class="w3ls-add-grids w3ls-add-grids-mdl">
                    <a href="{{ route('categories.products', 'office_chair') }}">
                        <h4>НОВЫЕ КРЕСЛА С <span>40%</span> СКИДКОЙ</h4>
                        <h6>Купить <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></h6>
                    </a>
                </div>
                <div class="w3ls-add-grids w3ls-add-grids-mdl1">
                    <a href="{{ route('categories.products', 'apple') }}">
                        <h4>ПОСЛЕДНИЕ ПОСТУПЛЕНИЯ <span> ТОРОПИСЬ !</span></h4>
                        <h6>Купить <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></h6>
                    </a>
                </div>
                <div class="clerfix"> </div>
            </div>
        </div>
    </div>
    <!-- //add-products -->
    <!-- deals -->
    <div class="deals">
        <div class="container">
            <h3 class="w3ls-title">Основные категории</h3>
            <div class="deals-row">
                <div class="col-md-3 focus-grid">
                    <a href="{{ route('categories.show','link') }}" class="wthree-btn">
                        <div class="focus-image"><i class="fa fa-mobile"></i></div>
                        <h4 class="clrchg">Связь</h4>
                    </a>
                </div>
                <div class="col-md-3 focus-grid">
                    <a href="{{ route('categories.show','notebooks_&_compucters') }}" class="wthree-btn wthree1">
                        <div class="focus-image"><i class="fa fa-laptop"></i></div>
                        <h4 class="clrchg">Ноутбуки и компьютеры</h4>
                    </a>
                </div>
                <div class="col-md-3 focus-grid">
                    <a href="{{ route('categories.show','household_products') }}" class="wthree-btn wthree3">
                        <div class="focus-image"><i class="fa fa-home"></i></div>
                        <h4 class="clrchg">Товары для дома</h4>
                    </a>
                </div>
                <div class="col-md-3 focus-grid">
                    <a href="{{ route('categories.show','white_goods') }}" class="wthree-btn wthree5">
                        <div class="focus-image"><i class="fas fa-blender" style="font-size: 40px;"></i></div>
                        <h4 class="clrchg">Бытовая техника</h4>
                    </a>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>
    <!-- //deals -->
    <!-- footer-top -->
    <div class="w3agile-ftr-top">
        <div class="container">
            <div class="ftr-toprow">
                <div class="col-md-4 ftr-top-grids">
                    <div class="ftr-top-left">
                        <i class="fa fa-truck" aria-hidden="true"></i>
                    </div>
                    <div class="ftr-top-right">
                        <h4>БЕСПЛАТНАЯ ДОСТАВКА</h4>
                        <p>Закажите любой товар и вы приятно удивитесь, что за доставку платить не нужно</p>
                    </div>
                    <div class="clearfix"> </div>
                </div>
                <div class="col-md-4 ftr-top-grids">
                    <div class="ftr-top-left">
                        <i class="fa fa-user" aria-hidden="true"></i>
                    </div>
                    <div class="ftr-top-right">
                        <h4>ЗАБОТА О ПОКУПАТЕЛЯХ</h4>
                        <p>Мы позаботимся, чтоб покупка в нашем интернет-магазине прошла для Вас легко и быстро</p>
                    </div>
                    <div class="clearfix"> </div>
                </div>
                <div class="col-md-4 ftr-top-grids">
                    <div class="ftr-top-left">
                        <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                    </div>
                    <div class="ftr-top-right">
                        <h4>ВЫСОКОЕ КАЧЕСТВО</h4>
                        <p>Магазин дает гарантию за высокое качество за предлагаемую продукцию</p>
                    </div>
                    <div class="clearfix"> </div>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>
    <!-- //footer-top -->
@endsection
