<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LikeComment extends Model
{
    protected $table = 'likes_comments';
    protected $fillable = ['user_id', 'comment_id'];
    public $timestamps = false;
}
