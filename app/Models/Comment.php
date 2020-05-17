<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function responseComment()
    {
        return $this->hasMany(ResponseComment::class, 'comment_id', 'id');
    }

    public function getDatePublicationAttribute()
    {
        return $this->created_at->isoFormat('D MMMM Y');
    }

    public function likes()
    {
        return $this->hasMany(LikeComment::class, 'comment_id', 'id');
    }

    public function dislikes()
    {
        return $this->hasMany(DislikeComment::class, 'comment_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
