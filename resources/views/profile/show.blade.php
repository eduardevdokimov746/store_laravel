@extends('layouts.app.main')

@section('content')
    <div class='container'>
        <h3 class='w3ls-title'>Личные данные</h3>



        <form data-toggle="validator" role="form" id='form-change-name-user'>
            <table class='form-user-data'>

                @if(session()->has('confirmed'))
                    <div class='alert alert-success'>
                        <i class='fa fa-check-circle'></i>&nbsp;Электронная почта успешно подтверждена!
                        <button type='button' class='close' data-dismiss='alert'>×</button>
                    </div>
                @endif

                @if(!Auth::user()->email->is_confirm)
                <tr>
                    <td colspan="2">
                        <div id='notice-msg-user-profice'>
                            <p>Отправленно письмо на эл. почту <b></b> с ссылкой подтверждения.</p>
                            <p>Чтобы отправить повторно письмо нажмите кнопку "Отправить"</p>
                            <button id='send_code_confirm_email'>Отправить</button>
                        </div>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                @endif
                <tr>
                    <td><span>Имя</span></td>
                    <td>
                        <div class="form-group">
                            <input type="text" name='name' class="form-control" id="exampleFormControlInput1" value="{{ Auth::user()->name }}" required>
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('change-password') }}">Изменить пароль</a>
                    </td>
                </tr>
                <tr>
                    <td><span>Электронная почта</span></td>
                    <td>
                        <div class="form-group">
                            <input type="email" name='email' class="form-control" id="exampleFormControlInput1" readonly="" value="{{ Auth::user()->email->email }}">
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('logout') }}">Выход</a>
                    </td>
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
