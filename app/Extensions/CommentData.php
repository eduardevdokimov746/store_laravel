<?php

namespace App\Extensions;

use App\Models\Comment;
use App\Models\LikeComment;
use App\Models\DislikeComment;

class CommentData
{
    public static function changeForShow(Comment $comment)
    {
        $result = self::checkPressDislike($comment);
        $result = self::checkPressLike($result);

        return $result;
    }

    public static function checkPressLike(Comment $comment)
    {
        if ($comment->likes->isNotEmpty() && \Auth::check()) {
            $issetUser = $comment->likes->pluck('user_id')->search(\Auth::id());
            $comment->likes->isPress = ($issetUser !== false) ? true : false;
        } else {
            $comment->likes->isPress = false;
        }

        return $comment;
    }

    public static function checkPressDislike(Comment $comment)
    {
        if ($comment->dislikes->isNotEmpty() && \Auth::check()) {
            $issetUser = $comment->dislikes->pluck('user_id')->search(\Auth::id());
            $comment->dislikes->isPress = ($issetUser !== false) ? true : false;
        } else {
            $comment->dislikes->isPress = false;
        }

        return $comment;
    }
}
