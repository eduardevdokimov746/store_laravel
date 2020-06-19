@extends('admin.layouts.app.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Новый товар
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-dashboard"></i> Главная</a></li>
            <li><a href="{{ route('admin.products.index') }}">Список товаров</a></li>
            <li class="active">Новый товар</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form action="{{ route('admin.products.store') }}" method="post" data-toggle="validator" id="add">
                        @csrf
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="title">Наименование товара</label>
                                <input type="text" name="title" class="form-control" id="title" placeholder="Наименование товара" value="{{ old('title') }}" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="title">Алиас</label>
                                <input type="text" name="slug" class="form-control" id="title" placeholder="samsung_galaxy_s10" value="{{ old('slug') }}" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                            <div class="form-group">
                                <label for="category_id">Родительская категория</label>
                                <select class="form-control" name="category_id" id="category_id" required>
                                    @foreach(Category::getAllChild() as $category_id => $category)
                                        <option value="{{ $category_id }}">{{ $category['title'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="price">Цена (в долларах)</label>
                                <input type="text" name="price" class="form-control" id="description" placeholder="Цена" pattern="^[0-9.]{1,}$" value="{{ old('price') }}" required data-error="Допускаются цифры и десятичная точка">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="old_price">Старая цена (в долларах)</label>
                                <input type="text" name="old_price" class="form-control" id="description" placeholder="Старая цена" pattern="^[0-9.]{1,}$" value="{{ old('old_price') }}" data-error="Допускаются цифры и десятичная точка">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="content">Короткая характеристика</label>
                                <textarea name="little_specifications" class="form-control" rows="3" cols="80" >{{ old('little_specifications') }}</textarea>
                            </div>


                            <div class="form-group has-feedback">
                                <label for="content">Полная характеристика</label>
                                <textarea name="big_specifications" class="editor" cols="80" rows="10">{{ old('big_specifications') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="is_published" checked> Опубликовано
                                </label>
                            </div>

                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="new"> Новый
                                </label>
                            </div>

                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="hit"> Хит
                                </label>
                            </div>

                            <div class="form-group">
                                <div class="col-md-4">
                                    <div class="box box-danger box-solid file-upload">
                                        <div class="box-header">
                                            <h3 class="box-title">Базовое изображение</h3>
                                        </div>
                                        <div class="box-body">
                                            <div id="single" class="btn btn-success" data-url="images/single" data-name="single">Выбрать файл</div>
                                            <p><small>Рекомендуемые размеры: 125х200</small></p>
                                            <div class="single"></div>
                                        </div>
                                        <div class="overlay">
                                            <i class="fa fa-refresh fa-spin"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="box box-primary box-solid file-upload">
                                        <div class="box-header">
                                            <h3 class="box-title">Картинки галереи</h3>
                                        </div>
                                        <div class="box-body">
                                            <div id="multi" class="btn btn-success" data-url="images/multi" data-name="multi">Выбрать файл</div>
                                            <p><small>Рекомендуемые размеры: 700х1000</small></p>
                                            <div class="multi"></div>
                                        </div>
                                        <div class="overlay">
                                            <i class="fa fa-refresh fa-spin"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="box-footer">
                            <button type="submit" name="sub" class="btn btn-success">Добавить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection
