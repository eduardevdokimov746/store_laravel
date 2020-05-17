@extends('layouts.app.main')

@section('content')
    <div class='container'>
         @include('includes.categories.sub-categories', [$categoriesTree])
    </div>
@endsection
