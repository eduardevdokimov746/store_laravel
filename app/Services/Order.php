<?php

namespace App\Services;

use App\Models\Order as ModelOrder;
use App\Models\OrderProduct;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class Order
{
    protected $user_id;
    protected $orders = [];
    protected $count_product;
    protected $order_sum;

    public function __construct($user_id, $count_product, $order_sum, $currency_id)
    {
        $this->user_id = $user_id;
        $this->count_product = $count_product;
        $this->order_sum = $order_sum;
        $this->currency_id = $currency_id;
        $this->init();
    }

    protected function init()
    {
        $this->orders = ModelOrder::where('user_id', $this->user_id)->get();
    }

    public function add(Request $request)
    {
        if ($credentials = $this->validate($request)) {
            return ModelOrder::create($credentials);
        }

        return null;
    }

    public function addProducts(ModelOrder $model, Collection $products)
    {
        $products_data = $this->createDataProducts($products);

        $model->products()->saveMany($products_data);
    }

    protected function createDataProducts(Collection $products)
    {
        return $products->map(function ($item, $key) {
            $data['product_id'] = $item->id;
            $data['qty'] = $item->count;
            $data['title'] = $item->title;
            $data['price'] = $item->price;
            $data['sum'] = $item->sum;
            $model = OrderProduct::make($data);
            return $model;
        });
    }

    protected function validate(Request $request)
    {
        $request_data = $request->only(['addr', 'notice']);

        $create_data = [
            'user_id' => $this->user_id,
            'currency_id' => $this->currency_id,
            'sum' => $this->order_sum,
            'count_product' => $this->count_product
        ];

        return array_merge($create_data, $request_data);
    }
}
