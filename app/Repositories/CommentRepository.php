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
}
