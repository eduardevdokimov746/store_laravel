@extends('layouts.app.main')

@section('content')
    <div class='container'>
        <div class='header_block_comments'>
            <h3 class="w3ls-title" style="display: inline-block; float: left;">Отзывы покупателей о товаре
                "{{ $product->title }}"&nbsp;<p style="display: inline;">{{ $comments->count() }}</p></h3>

            <div class='bth_comment' id='add-comment' title='Добавить отзыв'>
                Добавить отзыв
            </div>
        </div>

        @include('includes.comments.show-comments', [$product, $comments])

        @include('includes.products.show-form_comment', [$product])

        {{ $comments->links() }}
    </div>
@endsection
