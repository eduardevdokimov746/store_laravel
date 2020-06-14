<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponseComment extends Model
{
    protected $fillable = ['user_id', 'comment_id', 'comment'];
    protected $appends = ['datePublication'];

    protected $table = 'response_comments';

    public function parentComment()
    {
        return $this->belongsTo(Comment::class, 'comment_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getDatePublicationAttribute()
    {
        return $this->created_at->isoFormat('D MMMM Y');
    }
}
