@extends('admin.layouts.app.main')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Новый пользователь
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-dashboard"></i> Главная</a></li>
            <li><a href="{{ route('admin.users.index') }}"> Список пользователей</a></li>
            <li class="active">Новый пользователь</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form method="post" action="{{ route('admin.users.store') }}" role="form" data-toggle="validator" id="form-add-user-from-admin-panel">
                        @csrf
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="name">Имя и фамилия</label>
                                <input class="form-control" name="name" pattern="\s*\S+\s\S+" id="name" type="text" value="{{ old('name') }}" required>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="password">Пароль</label>
                                <input class="form-control" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]+$" name="password" id="password" type="password" data-minlength="6" data-error="Пароль должен быть не менее 6 символов, содержать цифры и заглавные буквы" required>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="email">Электронная почта</label>
                                <input class="form-control"  name="email" id="email" type="email" value="{{ old('email') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Роль</label>
                                <select class="form-control" name="role">
                                    <option value="user">Пользователь</option>
                                    <option value="admin">Администратор</option>
                                </select>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Добавить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->

@endsection
