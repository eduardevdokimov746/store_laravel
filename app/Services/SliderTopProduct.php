<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Extensions\ProductData;

class SliderTopProduct
{
    protected $productRepository;
    protected $categoryRepository;

    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function get($categories_id)
    {
        foreach ($categories_id as $id) {
            if ($this->categoryRepository->getChild($id)->isNotEmpty()) {
                $categoryChildIds = $this->categoryRepository->getIdChild($id);
                $products = $this->productRepository->getWhereCategory($categoryChildIds->pluck('id'));
            } else {
                $products = $this->productRepository->getWhereCategory($id);
            }

            $result[] = $products->map(function ($item, $key) {
                return ProductData::changeForList($item);
            });
        }

        return $result;
    }
}
