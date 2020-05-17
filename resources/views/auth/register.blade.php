@extends('layouts.app.main')

@section('content')
    <!-- sign up-page -->
    <div class="login-page">
        <div class="container">
            <h3 class="w3ls-title w3ls-title1">Создать аккаунт</h3>
            <div class="login-body" id='form_signup'>
                <div class='block-notice-form hidden'>
                    <img src='{{ asset('storage/images/notice.gif') }}'>
                    <p></p>
                </div>
                <form action='{{ url('register') }}' method='post'>
                    @csrf
                    <input type="text" class="user" name="name" placeholder="Имя">
                    <p class='notice-form-error hidden' id="notice-error-name"></p><br>
                    <input type="text" class="user" name="email" placeholder="Электронная почта">
                    <p class='notice-form-error hidden' id="notice-error-email"></p><br>
                    <input type="password" name="password" class="lock" placeholder="Пароль">
                    <p class='notice-form'>Пароль должен быть не менее 6 символов, содержать цифры и заглавные буквы</p>
                    <br>
                    <input type="submit" id='subReg' value="Зарегистрироваться">
                    <div class="forgot-grid">
                        <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Запомнить меня</label>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
            <h6>Уже есть аккаунт?<a href="{{ route('login') }}">Войти</a></h6>
            <div class="login-page-bottom social-icons">
                <h5>Авторизация с помощью социальных сетей</h5>
                <ul>
                    <li><a href="{{ url('login/mailru') }}" class="fa icon" title="mail.ru"><i class="fas fa-at"></i></a></li>
                    <li><a href="{{ url('login/vkontakte') }}" class="fa fa-dribbble icon dribbble" title="vk.com"><i class="fab fa-vk"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- //sign up-page -->
@endsection
