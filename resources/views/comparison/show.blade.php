@extends('layouts.app.main')

@section('content')
    <div class='container'>
        <h3 class="w3ls-title">Сравниваем {{ $category_title }}</h3>
        <table class='table-sravneniy table-hover'>
            <thead>
            <tr>
                <th></th>
                @foreach ($products as $product)
                    <th>
                        <div>
                            <a href='{{ route('products.show', $product->slug) }}'>
                                <img src='{{ asset('storage/images/' . $product->img) }}' alt=''>
                            </a>
                            <a class="title"
                               href='{{ route('products.show', $product->slug) }}'>{{ $product->title }}</a>
                            <p>{!! $symbolCurrency !!}&nbsp;{{ $product->price }}</p>
                        </div>
                    </th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach ($comparison as $name_specification => $value_specification)
                <tr>
                    <td class="spec">
                        <b>{{ $name_specification }}</b>
                    </td>
                    @foreach ($value_specification as $product_value)
                        <td><p>{!! $product_value !!}</p></td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>

        <table class='table-sravneniy table-hover hidden'
               style="position: fixed; top: 0; background: white; border-bottom: none; box-shadow: 0 10px 11px -11px rgba(51,51,51,.6);"
               id='test'>
            <thead>
            <tr>
                <th style="width: 200px; padding: 5px;"></th>
                @foreach ($products as $product)
                <th style="width: 200px; padding: 5px;">
                    <div>
                        <a href='{{ route('products.show', $product->slug) }}'>
                            <img src='{{ asset('storage/images/' . $product->img) }}' alt=''>
                        </a>
                        <a class="title"
                           href='{{ route('products.show', $product->slug) }}'>{{ $product->title }}</a>
                        <p>{!! $symbolCurrency !!}&nbsp;{{ $product->price }}</p>
                    </div>
                </th>
                @endforeach
            </tr>
            </thead>
        </table>
    </div>
@endsection
