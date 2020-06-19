@extends('admin.layouts.app.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Список товаров
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-dashboard"></i> Главная</a></li>
            <li class="active">Список товаров</li>
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
                                    <th>ID</th>
                                    <th>Категория</th>
                                    <th>Наименование</th>
                                    <th>Цена</th>
                                    <th>Статус</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->category->title }}</td>
                                        <td>
                                            <a href="{{ route('admin.products.edit', $product->id) }}">{{ $product->title }}</a>
                                        </td>
                                        <td>{{ $product->price }} $</td>
                                        <td>{{ $product->is_published ? 'On' : 'Off' }}</td>
                                        <td><a class="delete"
                                               href="{{ route('admin.products.destroy', $product->id) }}"><i
                                                    class="fa fa-fw fa-close text-danger"></i></a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                            <p>({{ $products->count() }} товаров из {{ $count_products }})</p>

                            {{ $products->links() }}

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection
