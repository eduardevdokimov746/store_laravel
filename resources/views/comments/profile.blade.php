@extends('layouts.app.main')

@section('content')
    <div class='container'>
        <h3 class='w3ls-title'>Мои отзывы</h3>
        @if($comments->isEmpty())
        <h3>Список пуст</h3>
        @else
        <div class='col-md-9 list-comments-user-profile' style="">
            <ul>
                @foreach ($comments as $comment)
                <li>
                    <div id='img-left'>
                        <a href='{{ route('products.show', $comment->product->slug) }}'><img
                                src='{{ asset('storage/images/' . $comment->product->img) }}' alt=''></a>
                    </div>
                    <div id='article-right'>
                        <a href='{{ route('products.show', $comment->product->slug) }}'>{{ $comment->product->title }}</a>
                        <p><b>{{ \Auth::user()->name }}</b>&nbsp;<span>{{ $comment->datePublication }}</span></p>

                        <p>{{ $comment->comment }}</p>
                    </div>

                    @if($comment->responseComment->isNotEmpty())
                    <div class='responses'>
                        <div class='head-response'>Ответы</div>
                        @foreach($comment->responseComment as $response)
                        <div class='body-response'>
                            <p>
                                <b>{{ $response->user->name }}</b>&nbsp;<span>{{ $response->datePublication }}</span>
                            </p>
                            <p>{{ $response->comment }}</p>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
@endsection
