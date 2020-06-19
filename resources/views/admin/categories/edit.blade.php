@extends('admin.layouts.app.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Редактирование категории {{ $category['title'] }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-dashboard"></i> Главная</a></li>
            <li><a href="{{ route('admin.categories.index') }}">Список категорий</a></li>
            <li class="active">{{ $category['title'] }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form action="{{ route('admin.categories.update', $category['id']) }}" method="post" data-toggle="validator">
                        @csrf
                        @method('patch')
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="title">Наименование категории</label>
                                <input type="text" name="title" class="form-control" id="title" placeholder="Наименование категории" value="{{ $category['title'] }}" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="title">Алиас</label>
                                <input type="text" name="slug" class="form-control" id="title" placeholder="Путь к категории" value="{{ $category['slug'] }}" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group">
                                <label for="parent_id">Родительская категория</label>
                                @include('admin.includes.categories.select')
                            </div>
                            <div class="form-group">
                                <label for="keywords">Ключевые слова</label>
                                <input type="text" name="keywords" class="form-control" id="keywords" placeholder="Ключевые слова" value="{{ $category['keywords'] }}">
                            </div>
                            <div class="form-group">
                                <label for="description">Описание</label>
                                <input type="text" name="description" class="form-control" id="description" placeholder="Описание" value="{{ $category['description'] }}">
                            </div>
                        </div>
                        <div class="box-footer">
                            <input type="hidden" name="id" value="{{ $category['id'] }}">
                            <button type="submit" name="sub" class="btn btn-success">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection
