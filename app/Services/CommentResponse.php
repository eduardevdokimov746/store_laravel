<?php

namespace App\Services;

use App\Mail\CommentResponse as Mail;
use Illuminate\Http\Request;
use App\Models\ResponseComment;

class CommentResponse
{
    public static function add(Request $request)
    {
        $data = self::getRequest($request);

        $create_data = self::getCreateData($data);

        $model = ResponseComment::create($create_data);

        if ($model->parentComment->is_notifiable) {
            \Mail::to($model->parentComment->user->email->email)->send(new Mail($model));
        }

        return $model;
    }

    protected static function getCreateData($old_data)
    {
        $new_data = [
            'user_id' => \Auth::id()
        ];

        return array_merge($old_data, $new_data);
    }

    protected static function getRequest(Request $request)
    {
        $result = [
            'comment_id' => $request->comment,
            'comment' => $request->get('comment_data'),
        ];

        return $result;
    }

    public static function get($comment_id)
    {
        $select = [
            'user_id',
            'comment_id',
            'comment',
            'response_comments.created_at',
            'name'
        ];

        return ResponseComment::select($select)->join('users', 'user_id', 'users.id')->where('comment_id', $comment_id)->orderByDesc('created_at')->get();
    }
}
