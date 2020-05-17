@extends('layouts.app.main')

@section('content')
    <div class='container'>

        <h3 class='w3ls-title'>Восстановление пароля</h3>
        <form data-toggle="validator" action="{{ route('password.update') }}" role="form" method="post">
            @csrf
            <table class='form-user-data' id='form-change-password'>
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">
                <tr>
                    <td><span>Новый пароль</span></td>
                    <td>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" id="exampleFormControlInput1" required="">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><span>Новый пароль еще раз</span></td>
                    <td>
                        <div class="form-group">
                            <input type="password" data-match="#exampleFormControlInput1" class="form-control" name="password_confirmation" required="">
                        </div>
                    </td>
                </tr>

                <tr style="height: 20px">
                    <td></td>
                    <td><p class='notice-form'>Пароль должен быть не менее 6 символов, содержать цифры и заглавные буквы</p></td>
                    <td></td>
                </tr>
                <tr style="height: 100px">
                    <td></td>
                    <td style="text-align: right;">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                        </div>
                    </td>
                    <td></td>
                </tr>
            </table>
        </form>
    </div>
@endsection
