<?php
use store\Register;
?>
@extends('admin.layouts.app.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Список заказов
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-dashboard"></i> Главная</a></li>
            <li class="active">Список заказов</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Покупатель</th>
                                    <th>Статус</th>
                                    <th>Сумма</th>
                                    <th>Дата создания</th>
                                    <th>Дата изменения</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)

                                    <tr class="{{ !is_null($order->confirmed_at) ? 'success' : '' }}">
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->status ? 'Завершен' : 'Новый' }}</td>
                                        <td>{{ $order->sum }}&nbsp;{!! $symbolCurrency !!}</td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>{{ $order->confirmed_at }}</td>
                                        <td>
                                            <a href="{{ route('admin.orders.edit', $order->id) }}">
                                                <i class="fa fa-fw fa-eye"></i>
                                            </a> <a class="delete"
                                                    href="{{ route('admin.orders.delete', $order->id) }}">
                                                <i class="fa fa-fw fa-close text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                            <p>({{ $orders->count() }} заказа(ов) из {{ $count_orders }})</p>

                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection
