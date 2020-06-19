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
                    <form action="{{ route('admin.products.update', $product->id) }}" method="post" data-toggle="validator" id="add">
                        @csrf
                        @method('PATCH')
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="title">Наименование товара</label>
                                <input type="text" name="title" class="form-control" id="title" placeholder="Наименование товара" value="{{ $product->title }}" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="title">Алиас</label>
                                <input type="text" name="slug" class="form-control" id="title" placeholder="samsung_galaxy_s10" value="{{ $product->slug }}" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                            <div class="form-group">
                                <label for="category_id">Родительская категория</label>
                                <select class="form-control" name="category_id" id="category_id" required>
                                    @foreach(Category::getAllChild() as $category_id => $category)
                                        @if($category_id == $product->$category_id)
                                            <option selected value="{{ $category_id }}">{{ $category['title'] }}</option>
                                        @endif
                                            <option value="{{ $category_id }}">{{ $category['title'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="price">Цена (в долларах)</label>
                                <input type="text" name="price" class="form-control" id="description" placeholder="Цена" pattern="^[0-9.]{1,}$" value="{{ $product->price }}" required data-error="Допускаются цифры и десятичная точка">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="old_price">Старая цена (в долларах)</label>
                                <input type="text" name="old_price" class="form-control" id="description" placeholder="Старая цена" pattern="^[0-9.]{1,}$" value="{{ $product->old_price }}" data-error="Допускаются цифры и десятичная точка">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="content">Короткая характеристика</label>
                                <textarea name="little_specifications" class="form-control" rows="3" cols="80" >{{ $product->info->little_specifications }}</textarea>
                            </div>


                            <div class="form-group has-feedback">
                                <label for="content">Полная характеристика</label>
                                <textarea name="big_specifications" class="editor" cols="80" rows="10">{{ $product->info->big_specifications }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="is_published" {{ $product->is_published ? 'checked' : '' }}> Опубликовано
                                </label>
                            </div>

                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="new" {{ $product->new ? 'checked' : '' }}> Новый
                                </label>
                            </div>

                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="hit" {{ $product->hit ? 'checked' : '' }}> Хит
                                </label>
                            </div>

                        </div>
                        <div class="box-footer">
                            <button type="submit" name="sub" class="btn btn-success">Изменить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection
