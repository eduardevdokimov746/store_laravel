@extends('layouts.app.main')

@section('content')
    <!-- login-page -->
    <div class="login-page">
        <div class="container">
            <h3 class="w3ls-title w3ls-title1">Вход в свой аккаунт</h3>
            <div class="login-body" id='form_login'>
                <div class='block-notice-form hidden'>
                    <img src='{{ asset('storage/images/notice.gif') }}'>
                    <p></p>
                </div>
                <form id='form-login-user' action="{{ url('login') }}" method="post">
                    @csrf
                    <input type="text" class="user" name="email" value="{{ Auth::viaRemember() ? Auth::user()->email->email : '' }}" placeholder="Электронная почта">
                    <input type="password" name="password" class="lock" value="{{ Auth::viaRemember() ? Auth::user()->password : '' }}" placeholder='Пароль'>
                    <input type="submit" id="subLogin" value="Войти">
                    <div class="forgot-grid">
                        <label class="checkbox"><input type="checkbox" name="checkbox" {{ Auth::viaRemember() ? 'checked' : '' }}><i></i>Запомнить меня</label>
                        <div class="forgot">
                            <a href="{{ route('password.request') }}">Забыли пароль?</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
            <h6>Еще нет аккаунта?<a href="{{ route('register') }}">Зарегистрироваться</a></h6>
            <div class="login-page-bottom social-icons">
                <h5>Авторизация с помощью социальных сетей</h5>
                <ul>
                    <!--fa-google-plus icon googleplus -->
                    <li><a href="{{ url('login/mailru') }}" class="fa icon" title="mail.ru"><i class="fas fa-at"></i></a></li>
                    <li><a href="{{ url('login/vkontakte') }}" class="fa fa-dribbble icon dribbble" title="vk.com"><i class="fab fa-vk"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- //login-page -->
@endsection
