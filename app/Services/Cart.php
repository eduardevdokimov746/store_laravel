<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Extensions\CartExtension;
use Illuminate\Support\Collection;

class Cart
{
    protected $items;
    protected $sum;
    protected $countItems;

    public function __construct()
    {
        $this->run();
    }

    protected function run()
    {
        $this->items = session()->has('cart') ? collect(session('cart')) : collect();
        $this->sum = session()->has('cart_sum') ? session('cart_sum') : 0;
        $this->countItems = session()->has('cart_count') ? session('cart_count') : 0;
    }

    public function getAll()
    {
        $result = [
            'cart' => $this->items->toArray(),
            'cart_sum' => $this->sum,
            'cart_count' => $this->countItems
        ];

        return $result;
    }

    public function getProducts()
    {
        return $this->items;
    }

    public function getSum()
    {
        return $this->sum;
    }

    public function recalculate($newCurrencyValue)
    {
        if ($this->isEmpty()) {
            return null;
        }

        $newCartItems = collect();

        if (\Currency::isBase()) {
            //перевод из базовой в не базовую
            foreach ($this->items as $product) {
                $newCartItems->push(CartExtension::recalcItem($product, $newCurrencyValue, 1));
            }
            $cartSum = $this->sum * $newCurrencyValue;
        } else {
            //перевод из не базовой в базовую или из не базовой в небазовую
            foreach ($this->items as $product) {
                $newCartItems->push(CartExtension::recalcItem($product, $newCurrencyValue, 0));
            }
            $cartSum = ($this->sum / \Currency::getCurrent()->value) * $newCurrencyValue;
        }

        $this->items = $newCartItems;
        $this->sum = $cartSum;
        $this->writeSession();
    }

    public function isEmpty()
    {
        return $this->items->isEmpty();
    }

    public function isNotEmpty()
    {
        return !$this->isEmpty();
    }

    public function getCount()
    {
        if ($this->countItems == 0) {
            $result = '';
        } else {
            $result = $this->countItems;
        }
        return $result;
    }

    public function writeSession()
    {
        $this->items = $this->items->reverse()->map(function ($item, $key) {
            $item->price = round($item->price, 2);
            $item->sum = round($item->sum, 2);
            return $item;
        });

        $this->sum = round($this->sum);

        session()->put('cart', $this->items);
        session()->put('cart_sum', $this->sum);
        session()->put('cart_count', $this->countItems);
    }

    public function add(Model $product)
    {
        $product = CartExtension::createProduct($product);
        $this->items->push($product);
        $this->sum += $product['price'];
        $this->countItems++;
        $this->writeSession();
    }

    public function delete($id)
    {
        $product = $this->search($id);

        if (is_null($product)) {
            return false;
        }

        $key = $this->getKey($id);
        $this->items->forget($key);
        $this->sum -= $product->sum;
        $this->countItems -= $product->count;

        $this->writeSession();
    }

    public function increment($id)
    {
        $product = $this->search($id);
        $product->count += 1;
        $product->sum += $product['price'];
        $keyProduct = $this->getKey($id);
        $this->items[$keyProduct] = $product;
        $this->countItems++;
        $this->sum += $product['price'];
        $this->writeSession();
    }

    public function decrement($id)
    {
        $product = $this->search($id);
        $product->count -= 1;
        $product->sum -= $product['price'];
        $keyProduct = $this->getKey($id);
        $this->items[$keyProduct] = $product;
        $this->countItems--;
        $this->sum -= $product['price'];
        $this->writeSession();
    }

    public function issetProduct($id)
    {
        if (is_null($this->items)) {
            return false;
        }

        if ($this->items->pluck('id')->search($id) !== false) {
            return true;
        }

        return false;
    }

    protected function search($id)
    {
        return $this->items->filter(function ($item, $key) use ($id) {
            return $item->id == $id;
        })->first();
    }

    public function flush()
    {
        session()->forget('cart');
        session()->forget('cart_sum');
        session()->forget('cart_count');
    }

    public function getKey($id)
    {
        return $this->items->filter(function ($item, $key) use ($id) {
            return $item->id == $id;
        })->keys()->first();
    }
}
