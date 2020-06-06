<?php

namespace App\Services;

use App\Models\Wishlist as Model;
use App\Interfaces\IWishlistProvider;
use App\Models\Product;

class Wishlist
{
    protected $default_name = 'Мой список желаний';
    protected $provider;
    protected $user_id;
    protected $data;

    public function __construct(IWishlistProvider $provider, $user_id)
    {
        $this->provider = $provider;
        $this->user_id = $user_id;
        $this->sync();
    }

    protected function sync()
    {
        $this->data = $this->provider->getAll($this->user_id);
    }

    public function getLists()
    {
        return $this->data;
    }

    public function getList($list_id)
    {
        if ($this->has($list_id)) {
            return $this->data->firstWhere('id', $list_id);
        }

        return null;
    }

    public function getProducts($list_id)
    {
        if ($this->isNotEmpty($list_id)) {
            return $this->getList($list_id)->products->pluck('product_id');
        }

        return null;
    }

    public function getCountList($list_id)
    {
        if ($this->has($list_id) && $this->isNotEmpty($list_id)) {
            return $this->getList($list_id)->products->count();
        }
        return 0;
    }

    public function test()
    {
        dd($this->data);
    }

    public function setProductsData($list_id, $products)
    {
        if ($this->has($list_id)) {
            $this->getList($list_id)['products'] = $products;
        }
    }

    public function getSumList($list_id)
    {
        if ($this->has($list_id) && isset($this->getList($list_id)['products'])) {
            return $this->getList($list_id)['products']->pluck('price')->sum();
        }

        return 0;
    }

    public function isEmpty($list_id)
    {
        if ($this->has($list_id) && $this->getList($list_id)->products->isNotEmpty()) {
            return false;
        }
        return true;
    }

    public function isNotEmpty($id)
    {
        return !$this->isEmpty($id);
    }

    protected function isNotEmptyData()
    {
        return !is_null($this->data);
    }

    public function has($id)
    {
        if ($this->isNotEmptyData() && $this->data->pluck('id')->search($id) === false) {
            return false;
        }

        return true;
    }

    public function hasProductList($list_id, $product_id)
    {
        if ($this->isNotEmpty($list_id)) {
            if (!is_null($this->getList($list_id)->firstWhere('product_id', $product_id))) {
                return true;
            }
        }

        return false;
    }

    public function hasProduct($product_id)
    {
        if ($this->isNotEmptyData()) {
            foreach ($this->data as $list) {
                if ($list->products->pluck('product_id')->search($product_id) !== false) {
                    return true;
                }
            }
        }

        return false;
    }

    public function isDefault($list_id)
    {
        if ($this->has($list_id)) {
            return $this->getList($list_id)->type_def == 1;
        }

        return false;
    }

    public function issetDefault()
    {
        if ($this->isNotEmptyData()) {
            return !is_null($this->data->firstWhere('type_def', 1));
        }

        return false;
    }

    public function isset()
    {
        return $this->isNotEmptyData();
    }

    protected function validateCredentials($data)
    {
        $result['user_id'] = $this->user_id;
        $result['title'] = $data['title'] ?? $this->default_name;

        if ($this->issetDefault()) {
            $result['type_def'] = 0;
        } else {
            $result['type_def'] = 1;
        }

        return $result;
    }

    public function create($data = [])
    {
        $data = $this->validateCredentials($data);
        $model = $this->provider->create($data);
        $this->sync();
        return $model;
    }

    protected function getDefault()
    {
        return $this->data->firstWhere('type_def', 1);
    }

    protected function getDefaultId()
    {
        if (!is_null($result = $this->getDefault())) {
            return $result->id;
        }

        return null;
    }

    public function getCountProduct()
    {
        $result = 0;
        if ($this->isNotEmptyData()) {
            foreach ($this->data as $item) {
                $result += $item->products->count();
            }
        }
        return $result;
    }

    public function addProduct($product_id)
    {
        if ($this->hasProduct($product_id)) {
            return;
        }

        if (!$this->issetDefault()) {
            $this->create();
        }

        $list_id = $this->getDefaultId();



        $this->provider->setProduct($list_id, $product_id);
        $this->sync();
    }

    public function renameList($list_id, $title)
    {
        if ($this->provider->changeTitleList($list_id, $title)) {
            $this->sync();
            return true;
        }
        return false;
    }

    public function changeDefaultList($list_id)
    {
        if ($this->provider->changeDefaultList($this->user_id, $list_id)) {
            $this->sync();
            return true;
        }

        return false;
    }

    public function delete($id)
    {
        if ($this->has($id)) {
            $this->provider->delete($id);
            $this->sync();
            return true;
        }

        return false;
    }

    public function deleteProducts($list_id, $product_ids)
    {
        $this->provider->unsetProducts($list_id, $product_ids);
        $this->sync();
    }
}
