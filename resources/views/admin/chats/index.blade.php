@extends('admin.layouts.app.main')

@section('content')

    <div class="col-xs-12" style="margin-top: 20px;">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Чаты с тех. поддержкой пользователей</h3>

                <div class="box-tools">
                    <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding {{ $chats->isEmpty() ? 'hidden' : '' }}">
                <table class="table table-hover" id="table-chats-admin-panel">
                    <thead>
                    <tr id="head-table">
                        <th>Пользователь</th>
                        <th>Дата</th>
                        <th>Статус</th>
                        <th>Сообщение</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($chats as $hash => $chat)
                        <tr style="cursor: pointer" data-hash="{{ $hash }}" href="#">
                            <td>{{ $chat['user_name'] }}</td>
                            <td>{{ $chat['created_at'] }}</td>
                            <td>
                                <span class="label label-success">{{ $chat['status'] ? 'Новое' : 'Старое' }}</span>
                            </td>
                            <td>{{ $chat['first_message'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>

@endsection
