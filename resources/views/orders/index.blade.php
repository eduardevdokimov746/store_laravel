@extends('layouts.app.main')

@section('content')
    <div class='container'>
        <h3 class='w3ls-title'>Мои заказы</h3>
        @if($orders->isNotEmpty())
            @foreach ($orders as $order)
                <div class="products-row wishlist" data-id='{{ $order->id }}'>

            <div class='container-head-list'>


                <div class='head-list'>
                    <h3>Заказ №{{ $order->id }}</h3>
                    <h3>Статус: {{ $order->status ? 'Одобрен' : 'Проходит проверку' }}</h3>
                </div>

                <table class='table table-striped table-sm'>
                    <thead>
                    <tr style="background: #f9f9f9;">
                        <th>Наименование</th>
                        <th>Кол-во</th>
                        <th>Цена</th>
                        <th>Сумма</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->products as $product)
                    <tr>
                        <td>{{ $product->title }}</td>
                        <td>{{ $product->qty }}</td>
                        <td>{{ $product->price }}&nbsp;{!! Currency::getSymbol(Currency::get($order->currency_id)->code) !!}</td>
                        <td>{{ $product->sum }}&nbsp;{!! Currency::getSymbol(Currency::get($order->currency_id)->code) !!}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="3">Итого:</td>
                        <td>{{ $order->count_product }}</td>
                    </tr>
                    <tr>
                        <td colspan="3">На сумму:</td>
                        <td>{{ $order->sum }}&nbsp;{!! Currency::getSymbol(Currency::get($order->currency_id)->code) !!}</td>
                    </tr>
                    </tbody>
                </table>

            </div>
            <div class="clearfix"></div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <h3>У вас пока нет заказов</h3>
        <?php endif; ?>
    </div>
@endsection
