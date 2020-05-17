<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponseComment extends Model
{
    protected $table = 'response_comments';

    public function parentComment()
    {
        return $this->belongsTo(Comment::class, 'comment_id', 'id');
    }
}
