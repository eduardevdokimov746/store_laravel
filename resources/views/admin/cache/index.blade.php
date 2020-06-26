@extends('admin.layouts.app.main')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Очистка кэша
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-dashboard"></i> Главная</a></li>
            <li class="active">Очистка кэша</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Название</th>
                                    <th>Описание</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Кэш категорий</td>
                                    <td>Меню категорий на сайте. Кэшируется на 2 недели</td>
                                    <td><a class="delete" href="{{ route('admin.cache.clear', 'categories') }}"><i class="fa fa-fw fa-close text-danger"></i></a></td>
                                </tr>
                                <tr>
                                    <td>Кэш валют</td>
                                    <td>Кэшируется на 2 недели</td>
                                    <td><a class="delete" href="{{ route('admin.cache.clear', 'currencies') }}"><i class="fa fa-fw fa-close text-danger"></i></a></td>
                                </tr>
                                <tr>
                                    <td>Кэш фильтров</td>
                                    <td>Кэшируется на 1 неделю</td>
                                    <td><a class="delete" href="{{ route('admin.cache.clear', 'filters') }}"><i class="fa fa-fw fa-close text-danger"></i></a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->

@endsection
