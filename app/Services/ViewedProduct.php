<?php

namespace App\Services;

use App\Interfaces\IViewedProductProvider;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Extensions\ProductData;

class ViewedProduct
{
    protected $provider;

    public function __construct(IViewedProductProvider $provider)
    {
        $this->provider = $provider;
    }

    public function get()
    {
        if ($this->provider->has()) {
            $products = Product::whereRaw("id IN ({$this->provider->get()})")->get();

            $products = $products->map(function ($item, $key) {
                return ProductData::change($item);
            });

            return $products;
        } else {
            return array();
        }
    }

    public function add($id)
    {
        if ($this->provider->has()) {
            $cookie = $this->provider->get();

            if (strpos($cookie, ',')) {
                $collect = collect(explode(',', $cookie));
            } else {
                $collect = collect($cookie);
            }

            if ($collect->search($id) !== false) return;

            if ($collect->count() == 8) {
                $collect->shift();
            }


            $collect = $collect->push((string)$id);


            $result = $collect->implode(',');

        } else {
            $result = $id;

        }

        $this->provider->write($result);
    }
}
