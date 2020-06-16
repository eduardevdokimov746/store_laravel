<?php

namespace App\Repositories;

use App\Models\Comment as Model;

class CommentRepository extends CoreRepository
{
    public function __construct(Model $model)
    {
        $this->setModel($model);
    }

    public function getForProductShow($product_id)
    {
        $select = [
            'id',
            'user_id',
            'type',
            'comment',
            'good_comment',
            'bad_comment',
            'rating',
            'created_at'
        ];

        return $this->startConditions()
            ->select($select)
            ->where('product_id', $product_id)
            ->with(['responseComment', 'likes', 'dislikes', 'user'])
            ->withCount(['responseComment', 'likes', 'dislikes'])
            ->orderByDesc('created_at')
            ->take(3)
            ->get();
    }

    public function getForShow($product_id, $comment_id = null)
    {
        $select = [
            'id',
            'user_id',
            'type',
            'comment',
            'good_comment',
            'bad_comment',
            'rating',
            'created_at'
        ];

        $conditions = $this->startConditions();

        if (!is_null($comment_id)) {
            $conditions = $conditions->where('id', $comment_id);
        }

        return $conditions
            ->select($select)
            ->where('product_id', $product_id)
            ->with(['responseComment', 'likes', 'dislikes', 'user'])
            ->withCount(['responseComment', 'likes', 'dislikes'])
            ->orderByDesc('created_at')
            ->paginate(20);
    }

    public function getForProfile($user_id)
    {
        $select = [
            'id',
            'product_id',
            'comment',
            'created_at'
        ];

        return $this->startConditions()
            ->select($select)
            ->with(['product:id,title,slug,img', 'responseComment:user_id,comment_id,comment,created_at', 'responseComment.user:id,name'])
            ->where('user_id', $user_id)
            ->orderByDesc('created_at')
            ->get();
    }
}
