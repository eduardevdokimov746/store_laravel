@extends('layouts.app.main')

@section('content')
    <div class="login-page">
        <div class="container">
            <h3 class="w3ls-title w3ls-title1">Восстановление пароля</h3>
            <div class="login-body" id='form_login'>
                <div class='block-notice-form hidden'>
                    <img src='{{ asset('storage/images/notice.gif') }}'>
                    <p></p>
                </div>
                <form id='form-restore-password' action="{{ route('password.email') }}" method="post">
                    @csrf
                    <span>Введите адрес электронной почты для получения кода восстановления.</span>
                    <input type="text" class="user" name="email" placeholder="Электронная почта">
                    <input type="text" name="code" class="lock hidden" placeholder='Введите код'>
                    <input type="submit" value="Получить код">
                </form>
            </div>
        </div>
    </div>
@endsection
