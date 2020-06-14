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
            font-size: 16px;
        }

        #body h3{
            margin: 10px 0;
            font-size: 20px;
        }

        #body > p{
            line-height: 22px;
            font-size: 16px;
        }

        #body > p > a{
            color: #0280e1;
            text-decoration: none;
        }

        #img-left{
            float: left;
        }

        #img-left a img{
            width: 120px;
            float: left;
            margin: 20% 0;
        }

        #article-right{
            margin-left: 170px;
        }

        #article-right a{
            font-size: 16px;
            color: #337ab7;
            text-decoration: none;
        }

        .block-content{
            margin-top: 10px;
            margin-bottom: 10px;
            padding: 0 10px;
        }

        .title-content{
            color: black;
            margin: 10px 0;
        }

        .title-content span{
            float: right;
        }

        #btn{
            display: inline-block;
            width: 257px;
            background: #0280e1;
            padding: 10px;
            font-size: 1.3em;
            text-decoration: none;
            text-align: center;
            margin: 0 auto;
            border-radius: 5px;
            margin-top: 40px;
            color: white;
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
        <h3>На Ваш отзыв ответили</h3>
        <p>Здравствуйте, {{ $comment_response->parentComment->user->name }}. На Ваш отзыв:</p>
        <div class='block-content'>
            <div id='img-left'>
                <a href="{{ route('products.show', $comment_response->parentComment->product->slug) }}"><img src="{{ asset('storage/images/' . $comment_response->parentComment->product->img) }}" alt=''></a>
            </div>
            <div id='article-right'>
                <a href="{{ route('products.show', $comment_response->parentComment->product->slug) }}">{{ $comment_response->parentComment->product->title }}</a>
                <p class="title-content"><b>{{ $comment_response->user->name }}</b>&nbsp;<span>{{ $comment_response->parentComment->date_publication }}</span></p>

                <p>{{ $comment_response->parentComment->comment }}</p>
            </div>
        </div>
        <p>ответил:</p>
        <div class='block-content'>
            <div>
                <p class="title-content"><b>{{ $comment_response->user->name }}</b>&nbsp;<span>{{ $comment_response->date_publication }}</span></p>

                <p>{{ $comment_response->comment }}</p>
            </div>
        </div>

        <a href='{{ route('profile.show') }}' id='btn' style="background: #f44336">Личный кабинет</a>
        <a href='{{ url('comments/' . $comment_response->parentComment->product->slug . '?id=' . $comment_response->parentComment->id) }}' id='btn'>Смотреть все ответы</a>

    </div>

</div>
</body>
</html>
