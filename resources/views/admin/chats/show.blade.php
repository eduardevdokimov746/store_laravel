@extends('admin.layouts.app.main')

@section('content')

    <div class="container" style="width: 50%; height: 600px;">
        <div class="box" id="block-chat-user" style="height: 90%; margin-top: 30px;">
            <div class="box-header ui-sortable-handle" style="cursor: move;">
                <i class="fa fa-comments-o"></i>

                <h3 class="box-title">Чат с {{ $chat['user_name'] }}</h3>

                <div class="box-tools pull-right" data-toggle="tooltip" title="" data-original-title="Status">
                    <div class="btn-group" data-toggle="btn-toggle">
                        <button type="button" class="btn btn-default btn-sm" id="connect"><i class="fa fa-square text-green"></i>
                        </button>
                        <button type="button" class="btn btn-default btn-sm active" id="disconnect"><i class="fa fa-square text-red"></i></button>
                    </div>
                </div>
            </div>

            <div class="box-body chat" data-hash="{{ $chat['hash'] }}" style="height: 90%;">
                <ul style="float: left; width: 100%; padding: 20px; height: 100%; overflow: auto;">
                    @foreach ($chat['messages'] as $message)
                    <li>
                        <div class="{{ $message['is_admin'] ? 'my-msg' : 'your-msg' }}">
                            {{ $message['message'] }}
                        </div>
                        <span class="{{ $message['is_admin'] ? 'my-msg' : 'your-msg' }}-date">{{ $message['send_time'] }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="box-footer">
                <div class="input-group">
                    <input class="form-control" id="field-msg" placeholder="Ввести сообщение..." disabled>
                    <div class="input-group-btn">
                        <button type="button" id="send-new-msg-admin-panel" class="btn btn-success" disabled><i class="fa fa-plus"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
