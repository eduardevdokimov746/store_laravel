@extends('layouts.app.main')

@section('content')
    <div class='container'>
        <h3 class='w3ls-title '>Корзина</h3>
            <h3 class="{{ Cart::isEmpty() ? '' : 'hidden' }}">Корзина пуста</h3>
        @if(Cart::isNotEmpty())
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>Фото</th>
                <th>Название</th>
                <th>Цена</th>
                <th>Количество</th>
                <th>Сумма</th>
                <th><i class="fas fa-trash"></i></th>
            </tr>
            </thead>
            <tbody>
            @foreach(Cart::getAll()['cart'] as $item)

            <tr data-id='{{ $item['id'] }}'>
                <td>
                    <img src='{{ asset('storage/images/' . $item['img']) }}' alt='img' style='width: 60px;'>
                </td>
                <td style="width: 50%;" ><a href='{{ route('products.show', $item['slug']) }}'>{{ $item['title'] }}</a></td>
                <td>{!! $symbolCurrency !!}&nbsp;{{ $item['price'] }}
                </td>
                <td>
                    <div>
                        <button class='btn_box_number delCountProduct'>&#8212;</button>
                        <input type='text' class='box_number' readonly maxlength='3' value='<?= $item['count'] ?>'>
                        <button class='btn_box_number addCountProduct'>+</button>
                    </div>
                </td>
                <td class='summProduct'>{!! $symbolCurrency !!}&nbsp;{{ $item['sum'] }}</td>
                <td>
                    <span style='cursor: pointer;' class='glyphicon glyphicon-remove text-danger del-item delProductCart' aria-hidden='true'></span>
                </td>
            </tr>

            @endforeach


            <tr class='result_line_catr' style="background: #b2ff96;">
                <th scope="row" colspan="2" >Итоговая сумма</th>
                <td></td>
                <td></td>
                <td class='final_price' colspan="2" style='background: #0280e1;'>
                    <span>{!! $symbolCurrency !!}&nbsp;{{ Cart::getSum() }}</span>
                </td>
            </tr>
            </tbody>
        </table>

        <div style="float: right; margin-bottom: 30px;">
            <button type="button" class="btn btn-danger clearCart">Очистить корзину</button>
            <a href='{{ route('orders.create') }}' type="button" class="btn btn-primary {{ Cart::isEmpty() ? 'hidden' : '' }} btn_addOrder">Оформить заказ</a>
        </div>
        @endif
    </div>

@endsection
