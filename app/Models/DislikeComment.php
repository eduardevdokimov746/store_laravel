<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DislikeComment extends Model
{
    protected $table = 'dislikes_comments';
    protected $fillable = ['user_id', 'comment_id'];
    public $timestamps = false;
}
