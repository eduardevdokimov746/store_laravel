@extends('layouts.app.main')

@section('content')
    <div class='container'>
        @foreach(\Category::getTree() as $categoriesTree)
            @include('includes.categories.sub-categories', [$categoriesTree])
        @endforeach
    </div>
@endsection
