<?php

namespace App\Services;

use App\Interfaces\IComparisonProvider;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Services\Category;
use App\Extensions\ProductData;
use App\Extensions\ComparisonExtension;

class Comparison
{
    protected $provider;
    protected $data;
    const MAX_COUNT_PRODUCT = 5;

    public function __construct(IComparisonProvider $provider)
    {
        $this->provider = $provider;
        $this->init();
    }

    protected function init()
    {
        $this->data = collect(json_decode($this->provider->get()))->mapWithKeys(function ($item, $key) {
            return [$key => collect($item)];
        });
    }

    public function has($product_id)
    {
        return $this->data->search(function ($item, $key) use ($product_id) {
            return $item->search($product_id) !== false;
        });
    }

    public function add(Product $product)
    {
        $category_id = $this->getCategoryId($product->category_id);

        if ($this->hasProduct($category_id, $product->id)) {
            return true;
        }

        if ($this->getCountProductInCategory($category_id) == self::MAX_COUNT_PRODUCT) {
            return false;
        }

        $this->set($category_id, $product->id);

        $this->write();

        return true;
    }

    protected function set($category_id, $product_id)
    {
        if ($this->hasCategory($category_id)) {
            $this->data->get($category_id)->push($product_id);
        } else {
            $this->data[$category_id] = collect()->push($product_id);
        }
    }

    public function hasCategory($category_id)
    {
        return $this->data->has($category_id);
    }

    public function getCountProductInCategory($category_id)
    {
        if ($this->hasCategory($category_id)) {
            return $this->data->get($category_id)->count();
        }

        return 0;
    }

    public function hasProduct($category_id, $product_id)
    {
        return $this->data->has($category_id) && $this->data->get($category_id)->has($product_id);
    }

    public function getCountProduct()
    {
        $count = 0;

        $this->data->each(function ($item, $key) use (&$count) {
            $count += $item->count();
        });

        return $count;
    }

    public function delete($product_id)
    {
        if ($this->has($product_id)) {
            $category_id = $this->search($product_id);
            $product_key = $this->getProductKey($category_id, $product_id);
            $this->data->get($category_id)->forget($product_key);

            if ($this->isEmptyCategory($category_id)) {
                $this->data->forget($category_id);
            }

            $this->write();
            return true;
        }

        return false;
    }

    protected function getProductKey($category_id, $product_id)
    {
        return $this->data->get($category_id)->search($product_id);
    }

    public function search($product_id)
    {
        if (!$this->has($product_id)) {
            return null;
        }

        $result = $this->data->filter(function ($item, $key) use ($product_id) {
            return $item->search($product_id) !== false;
        })->keys()->first();

        return $result;
    }
    public function isEmptyCategory($category_id)
    {
        if ($this->hasCategory($category_id)) {
            return $this->data->get($category_id)->isEmpty();
        }

        return true;
    }

    public function isNotEmptyCategory($category_id)
    {
        return !$this->isEmptyCategory($category_id);
    }

    public function isEmpty()
    {
        return $this->data->isEmpty();
    }

    public function isNotEmpty()
    {
        return !$this->isEmpty();
    }

    protected function write()
    {
        $this->provider->write($this->data);
    }

    public function getAll()
    {
        return $this->data;
    }

    public function getProducts($category_id)
    {
        return $this->data->get($category_id);
    }

    public function get(ProductRepository $productRepository)
    {
        if ($this->isEmpty()) {
            return null;
        }

        $product_comparison = $this->data->mapWithKeys(function ($item, $key) use ($productRepository) {
            $products = $productRepository->getWhereIds($item->toArray())->map(function ($item) {
                return ProductData::changeForList($item);
            });

            return [$key => $products];
        });

        $product_comparison->mapWithKeys(function ($item, $key) {
            $item['category_title'] = \Category::get($key)['title'];
            $item['category_slug'] = \Category::get($key)['slug'];
            return [$key => $item];
        });

        return $product_comparison;
    }

    public function getCategoryId($category_id)
    {
        if (\Category::isNotebook($category_id)) {
            return 6;
        }

        return $category_id;
    }

    public function getComparison($products)
    {
        return ComparisonExtension::create($products);
    }
}
