<?php

namespace App\Repositories;

use App\Models\Order as Model;

class OrderRepository extends CoreRepository
{
    public function __construct(Model $model)
    {
        $this->setModel($model);
    }

    public function getAllWithPagination($count_product)
    {
        $select = [
            'orders.id',
            'orders.user_id',
            'orders.currency_id',
            'orders.status',
            'orders.sum',
            'orders.created_at',
            'orders.confirmed_at',
        ];

        return $this->startConditions()
            ->select($select)
            ->with('user:id,name')
            ->orderByDesc('created_at')
            ->paginate($count_product);
    }

    public function getForShow($id)
    {
        return $this->startConditions()
            ->with(['user:id,name', 'products'])
            ->first();
    }
}
