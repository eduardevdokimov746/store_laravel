<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/app.js') }}"></script>
    <link rel="shortcut icon" href="{{ asset('storage/images/favicon1.png') }}" type='image/png'/>
    <title>{{ config('app.name') }}</title>
    <script type="application/x-javascript">
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css" media="all"/>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" media="all"/>
    <link href="{{ asset('css/menu.css') }}" rel="stylesheet" type="text/css" media="all"/> <!-- menu style -->
    <link href="{{ asset('css/ken-burns.css') }}" rel="stylesheet" type="text/css" media="all"/> <!-- banner slider -->
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet" type="text/css" media="all"/>
    <link href="{{ asset('css/owl.carousel.css') }}" rel="stylesheet" type="text/css" media="all">
    <!-- carousel slider -->
    <!-- //Custom Theme files -->
    <!-- font-awesome icons -->
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">
    <meta name="interkassa-verification" content="4bd253b110a8358ba2ed0fdb818f2ca7"/>
    <!--flex slider-->
    <link rel="stylesheet" href="{{ asset('css/flexslider.css') }}" type="text/css" media="screen"/>
    <!-- web-fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic'
          rel='stylesheet' type='text/css'>
    <!-- web-fonts -->
    <script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
</head>
<body>
<!-- header -->
<div id="app">
<div class="header">
    <div class="w3ls-header"><!--header-one-->
        <div class="w3ls-header-left">
            <p><a>Мы заботимся о вас и ваших покупках</a></p>
        </div>
        <div class="w3ls-header-right">
            <ul>
                <li class="dropdown head-dpdn">
                    <!-- У не авторизованного пользователя "Мой аккаунт", авторизованного - Имя Фамилия -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        @auth
                            {{ Auth::user()->name }}
                        @else
                            Мой аккаунт
                        @endif
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                    @auth
                        <!--Список у авторизованного пользователя -->
                            <li><a href="{{ route('profile.show') }}">Личные данные</a></li>
                            <li><a href="{{ route('wishlists.index') }}">Список желаний</a></li>
                            <li><a href="{{ route('comparison.index') }}">Список сравнений</a></li>
                            <li><a href="{{ route('cart.index') }}">Корзина</a></li>
                            <li><a href="{{ route('orders.index') }}">Мои заказы</a></li>
                            <li><a href="{{ route('comments.profile') }}">Мои отзывы</a></li>
                            <li><a href="{{ route('viewedproduct.index') }}">Просмотренные товары</a></li>
                            <li><a href="{{ route('logout') }}">Выход</a></li>
                    @else
                        <!--Если не авторизованный пользователь -->
                            <li><a href="{{ route('login') }}">Вход</a></li>
                            <li><a href="{{ route('register') }}">Регистрация</a></li>
                        @endif
                    </ul>
                </li>

                {!! Currency::run() !!}

                <li class="dropdown head-dpdn">
                    <a href="#" class="dropdown-toggle"><i class="fa fa-question-circle"
                                                           aria-hidden="true"></i>Помощь</a>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="header-two"><!-- header-two -->
        <div class="container">
            <div class="header-logo">
                <h1><a href="{{ route('index') }}"><span>S</span>mart</a></h1>
                <h6>Your stores. Your place.</h6>
            </div>
            <div class="header-search">
                <form onsubmit="return false;">
                    <input type="search" id='autocomplete' style="font-size: 1.1em; color: black" name="Search"
                           placeholder="Поиск по товарам..." autocomplete="off">
                    <button type="button" id='sub_search' style="height: 100%" class="btn btn-default"
                            aria-label="Left Align">
                        <i class="fa fa-search" aria-hidden="true"> </i>
                    </button>
                </form>
            </div>
            <div class="header-cart">
                <div class="cart" id='comparison' title='Список сравнений'>
                    <button class="w3view-cart" type="submit" name="submit" value="">
                        <i class="fas fa-balance-scale" style="font-size: 25px; color: white;"></i>
                    </button>

                    @if(Comparison::isNotEmpty())
                        <span>{{ Comparison::getCountProduct() }}</span>
                    @endif

                </div>
                <div class="cart" id='wishlist' title='Список желаний'>
                    <button class="w3view-cart" type="submit" name="submit" value="">
                        <i class="far fa-heart" style="font-size: 25px; color: white;"></i>
                    </button>
                    @if(auth() && Wishlist::getCountProduct() > 0)
                        <span>{{ Wishlist::getCountProduct() }}</span>
                    @endif
                </div>
                <div class="cart" title='Корзина'>
                    <button class="w3view-cart" data-toggle="modal" data-target=".bs-example-modal-lg" type="submit"
                            name="submit" value=""><i class="fa fa-cart-arrow-down" aria-hidden="true"></i></button>

                    <span id='countProductCart' class="">{{Cart::getCount()}}</span>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div><!-- //header-two -->
    <div class="header-three"><!-- header-three -->
        <div class="container">
            <div class="menu">
                @include('layouts.categories.category-client')
            </div>
            <div class="move-text">
                <div class="marquee"><a href="#"> Новые коллекции доступны здесь...... <span>Получи дополнительную скидку 10% на все | без дополнительных налогов </span>
                        <span> Попробуйте бесплатную доставку на 15 дней без ограничений</span></a></div>
            </div>
        </div>
    </div>
</div>

<div id='c'>
    @section('content')
        <h1>Пустая страница</h1>
    @show
</div>
<!-- //header -->

<!-- footer -->
<div class="footer">
    <div class="container">
        <div class="footer-info w3-agileits-info">
            <div class="col-md-4 address-left agileinfo">
                <div class="footer-logo header-logo">
                    <h2><a href=""><span>S</span>mart</a></h2>
                    <h6>Your stores. Your place.</h6>
                </div>
                <ul>
                    <li><i class="fa fa-map-marker"></i> 123 San Sebastian, New York City USA.</li>
                    <li><i class="fa fa-mobile"></i> 333 222 3333</li>
                    <li><i class="fa fa-phone"></i> +222 11 4444</li>
                    <li><i class="fa fa-envelope-o"></i> <a href="mailto:example@mail.com"> mail@example.com</a></li>
                </ul>
            </div>
            <div class="col-md-8 address-right">
                <div class="col-md-4 footer-grids">
                    <h3>Компания</h3>
                    <ul>
                        <li><a href="#">О нас</a></li>
                        <li><a href="#">Главные ценности</a></li>
                        <li><a href="#">политика конфиденциальности</a></li>
                    </ul>
                </div>
                <div class="col-md-4 footer-grids">
                    <h3>Службы</h3>
                    <ul>
                        <li><a href="#">Свяжитесь с нами</a></li>
                        <li><a href="#">Возвраты</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Карта сайта</a></li>
                        <li><a href="#">Статус заказа</a></li>
                    </ul>
                </div>
                <div class="col-md-4 footer-grids">
                    <h3>Способы оплаты</h3>
                    <ul>
                        <li><i class="fa fa-laptop" aria-hidden="true"></i> Интернет банкинг</li>
                        <li><i class="fa fa-money" aria-hidden="true"></i> Наложенный платеж</li>
                        <li><i class="fa fa-gift" aria-hidden="true"></i> Ваучер</li>
                        <li><i class="fa fa-credit-card" aria-hidden="true"></i> Кредитная карта</li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<!-- Окно корзины -->
@include('layouts.cart.cart')
<!-- Окно корзины -->

<!-- Chat-modal -->
@include('layouts.chat.chat-modal')
<!-- Chat-modal -->

<!-- //footer -->
<div class="copy-right">
    <div class="container">
        <p>© 2019 Smart bazaar . All rights reserved | Design by <a href="http://w3layouts.com"> W3layouts.</a></p>
    </div>
</div>
@include('includes.scripts')
</div>
</body>
</html>
