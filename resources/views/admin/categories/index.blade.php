@extends('admin.layouts.app.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Список категорий
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-dashboard"></i> Главная</a></li>
            <li class="active">Список категорий</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">

                        <div class="list-group list-group-root well">
                            @include('admin.includes.categories.list')
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
