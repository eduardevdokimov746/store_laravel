<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Корзина</h4>
            </div>
            <div class="modal-body" style="position: relative;">
                <!-- Loader -->
                <!--<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div> -->
                <!-- Loader -->

                <h3 class='{{ Cart::isEmpty() ? '' : 'hidden' }}'>Корзина пуста</h3>

                <table class="table table-striped table-sm {{ Cart::isEmpty() ? 'hidden' : '' }}">
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
                    @foreach(Cart::getProducts() as $product)

                    <tr data-id='{{ $product->id }}'>
                        <td>
                            <img src='{{ asset($product->imagePath) }}' alt='img' style='width: 60px;'>
                        </td>
                        <td style="width: 50%;">
                            <a href='{{ route('products.show', $product->slug) }}'>{{ $product->title }}</a>
                        </td>
                        <td>{!! $symbolCurrency !!}&nbsp;{{ $product->price }}</td>
                        <td>
                            <div>
                                <button class='btn_box_number delCountProduct'>&#8212;</button>
                                <input type='text' class='box_number' readonly maxlength='3' value='{{ $product['count'] }}'>
                                <button class='btn_box_number addCountProduct'>+</button>
                            </div>
                        </td>
                        <td class='summProduct'>{!! $symbolCurrency !!}&nbsp;{{ $product['sum'] }}</td>
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Продолжить покупки</button>
                <button type="button" class="btn btn-danger clearCart {{ Cart::isEmpty() ? 'hidden' : '' }}">Очистить корзину</button>
                <a href='' type="button" class="btn btn-primary {{ Cart::isEmpty() ? 'hidden' : '' }} btn_addOrder">Оформить заказ</a>
            </div>
        </div>

    </div>
</div>
