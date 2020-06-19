@extends('admin.layouts.app.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Заказ №{{ $order->id }}
            @if($order->status)
                <a href="{{ url('admin/orders/update/' . $order->id . '?action=unconfirmed') }}" class="btn btn-default btn-xs">Вернуть на доработку</a>
            @else
                <a href="{{ url('admin/orders/update/' . $order->id . '?action=confirmed') }}" class="btn btn-success btn-xs">Одобрить</a>
            @endif
            <a href="{{ route('admin.orders.delete', $order->id) }}" class="btn btn-danger btn-xs delete">Удалить</a>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-dashboard"></i> Главная</a></li>
            <li><a href="{{ route('admin.orders.index') }}">Список заказов</a></li>
            <li class="active">Заказ №{{ $order->id }}</li>
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
                                <tbody>
                                <tr>
                                    <td>Номер заказа</td>
                                    <td>{{ $order->id }}</td>
                                </tr>
                                <tr>
                                    <td>Дата заказа</td>
                                    <td>{{ $order->created_at }}</td>
                                </tr>
                                <tr>
                                    <td>Дата изменения</td>
                                    <td>{{ $order->confrimed_at }}</td>
                                </tr>
                                <tr>
                                    <td>Кол-во позиций в заказе</td>
                                    <td>{{ $order->count_product }}</td>
                                </tr>
                                <tr>
                                    <td>Сумма заказа</td>
                                    <td>{{ $order->sum }}&nbsp;{!! Currency::getSymbol(Currency::get($order->currency_id)->code) !!}</td>
                                </tr>
                                <tr>
                                    <td>Имя заказчика</td>
                                    <td>{{ $order->user->name }}</td>
                                </tr>
                                <tr>
                                    <td>Статус</td>
                                    <td>{{ $order->status ? 'Завершен' : 'Новый' }}</td>
                                </tr>
                                <tr>
                                    <td>Комментарий</td>
                                    <td>{{ $order->notice }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <h3>Детали заказа</h3>
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Наименование</th>
                                    <th>Кол-во</th>
                                    <th>Цена</th>
                                    <th>Сумма</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->title }}</td>
                                    <td>{{ $product->qty }}</td>
                                    <td>{{ $product->price }}&nbsp;{!! Currency::getSymbol(Currency::get($order->currency_id)->code) !!}</td>
                                    <td>{{ $product->sum }}&nbsp;{!! Currency::getSymbol(Currency::get($order->currency_id)->code) !!}</td>
                                </tr>
                                <?php endforeach; ?>
                                <tr class="active">
                                    <td colspan="2">
                                        <b>Итого:</b>
                                    </td>

                                    <td><b>{{ $order->count_product }}</b></td>
                                    <td></td>
                                    <td><b>{{ $order->sum }}&nbsp;{!! Currency::getSymbol(Currency::get($order->currency_id)->code) !!}</b></td>
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
