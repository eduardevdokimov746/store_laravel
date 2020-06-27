<?php

namespace App\Http\Controllers\Admin;

use App\Events\MessageChat;
use App\Events\UserConnected;
use App\Http\Controllers\Controller;
use App\Services\Chat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Chat as ModelChat;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth')->except(['connectedUser', 'message']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chats = app(Chat::class)->getForAdminWithNew(\Auth::id());

        return view('admin.chats.index', compact('chats'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $chat = app(Chat::class)->get($id);

        if (is_null($chat)) {
            return abort(404);
        }

        $chat['messages']->transform(function ($item) {
            $item['send_time'] = Carbon::make($item['created_at'])->format('H:i');
            return $item;
        });

        return view('admin.chats.show', compact('chat'));
    }

    public function connectedUser(Request $request)
    {
        $hash = app(Chat::class)->createChat($request->query('name'), $request->query('message'));

        event(new UserConnected($hash, $request->query('name'), $request->query('message')));

        $result['hash'] = $hash;
        $result['user_name'] = $request->query('name');
        $result['message'] = $request->query('message');

        return response($hash, 200);
    }

    public function message(Request $request)
    {
        app(Chat::class)->addMessage($request);

        $user_name = $request->get('user_name');
        $message = $request->get('message');
        $time = Carbon::now('Europe/Moscow')->format('H:i');

        event(new MessageChat($request->get('hash'), $user_name, $message, $time, $request->get('user')));
    }

    public function connectedAdmin()
    {
        $hash = \request()->get('hash');

        $chat = app(Chat::class);

        if ($chat->getTypeChat($hash) == 1) {
            $chat->connectToAdmin(\Auth::id(), $hash);
        }
    }
}
