<!DOCTYPE html>
<html>
<head>
    <title></title>

    <style type="text/css">
        *{
            margin: 0;
            padding: 0;
        }

        #mail{
            width: 100%;
            max-width: 600px;
            font-family: sans-serif;
            margin: 0 auto;
            margin-top: 5%;
            border: 1px solid silver;
            border-radius: 5px;
        }

        #header{
            width: 100%;
            border-bottom: 1px solid silver;
        }

        .header-logo{
            padding: 0 10px;
            display: inline-block;
        }

        #header > span{
            font-size: 18px;
            display: inline-block;
            margin-right: 10px;
            margin-top: 40px;
            float: right;
        }

        .header-logo h1{
            font-size: 2em;
            font-weight: 900;
        }

        .header-logo a{
            display: inline-block;
            color: #000;
            text-decoration: none;
        }

        .header-logo a span{
            font-family: sans-serif;
            font-size: 2em;
            color: #F44336;
            vertical-align: sub;
            margin-right: 3px;
        }

        #body{
            padding: 20px;
        }

        #body h3{
            margin: 10px 0;
            font-size: 20px;
        }

        table{
            border: 1px solid #ddd;
            border-collapse: collapse;
            width: 100%;
        }

        table td, th{
            padding: 8px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
<div id='mail'>
    <div id='header'>
        <div class="header-logo">
            <h1><a href="{{ route('index') }}"><span>S</span>mart</a></h1>
        </div>
        <span>Мы заботимся о вас и ваших покупках</span>
    </div>
    <div id='body'>
        <h3>Оформлен заказ</h3>
        <table>
            <thead>
            <tr style="background: #f9f9f9;">
                <th>Наименование</th>
                <th>Кол-во</th>
                <th>Цена</th>
                <th>Сумма</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->title }}</td>
                <td>{{ $product->count }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->sum }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3">Итого:</td>
                <td>{{ $count_products }}</td>
            </tr>
            <tr>
                <td colspan="3">На сумму:</td>
                <td>{{ $sum_cart }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
