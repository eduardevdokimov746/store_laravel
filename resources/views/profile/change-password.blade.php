@extends('layouts.app.main')

@section('content')
    <div class='container'>
        <h3 class='w3ls-title'>Смена пароля</h3>
        <form data-toggle="validator" role="form" id='block-change-pass'>
            <table class='form-user-data'>
                <tr id='notice' class="hidden">
                    <td colspan="2">
                        <div id='notice-msg-user-profice'>
                            <p></p>
                        </div>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><span>Старый пароль</span></td>
                    <td>
                        <div class="form-group">
                            <input type="password" name='oldPass' required="" class="form-control">
                        </div>
                    </td>

                </tr>
                <tr>
                    <td><span>Новый пароль</span></td>
                    <td>
                        <div class="form-group">
                            <input type="password" name='newPass' required="" class="form-control" id="exampleFormControlInput1">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><span>Новый пароль еще раз</span></td>
                    <td>
                        <div class="form-group">
                            <input type="password" name='newPass2' required="" class="form-control" data-match="#exampleFormControlInput1">
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
