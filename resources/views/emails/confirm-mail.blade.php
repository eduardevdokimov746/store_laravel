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

        #body > p{
            line-height: 22px;
            font-size: 16px;
        }

        #body > a{
            display: block;
            width: 200px;
            background: #0280e1;
            padding: 20px;
            font-size: 1.3em;
            text-decoration: none;
            text-align: center;
            margin: 0 auto;
            border-radius: 5px;
            margin-top: 40px;
            color: white;
        }

        #body > p > a{
            color: #0280e1;
            text-decoration: none;
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
        <h3>Подтвердите адрес электронной почты</h3>
        <p>Для вашего email <b>{{ $email }}</b> был осуществлен запрос на подтверждение адреса электронной почты.
            Для того чтобы подтвердить адрес электронной почты необходимо перейти по <a href='{{ route('confirm.mail', $code) }}'>ссылке</a> или по кнопке "Подтвердить email".</p>
        <a href='{{ route('confirm.mail', $code) }}'>Подтвердить email</a>
    </div>
</div>
</body>
</html>
