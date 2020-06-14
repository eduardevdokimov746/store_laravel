<?php

namespace App\Http\Controllers;

use App\Extensions\ProductData;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Comparison;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ComparisonController extends BaseController
{
    public function index(ProductRepository $productRepository)
    {
        $comparison_product = Comparison::get($productRepository);

        return view('comparison.index', compact('comparison_product'));
    }

    public function store($product_id)
    {
        $product = Product::find($product_id);

        if (is_null($product)) {
            return abort(422);
        }

        if (!\Comparison::add($product)) {
            return JsonResponse::create('max_lenght', 200);
        }

        return JsonResponse::create('', 200);
    }

    public function delete($id)
    {
        if (\Comparison::delete($id)) {
            $result['removeList'] = \Comparison::isEmptyCategory(\request()->get('category_id'));
            $result['checkOne'] = \Comparison::getCountProductInCategory(\request()->get('category_id')) == 1 ? true : false;
            return JsonResponse::create($result, 200);
        }

        return abort(422);
    }

    public function show(ProductRepository $productRepository, $slug)
    {
        $category_id = \Comparison::getCategoryId(\Category::getId($slug));
        $category_title = \Category::get($category_id)['title'];

        if ($category_id === false) {
            return abort(404);
        }

        $product_ids = \Comparison::getProducts($category_id);

        $products = $productRepository->getForComparison($product_ids);

        if ($products->isEmpty()) {
            return abort(404);
        }

        $products->transform(function ($item, $key) {
            $item->price = ProductData::price($item->price);
            return $item;
        });

        $comparison = \Comparison::getComparison($products);

        return view('comparison.show', compact('products', 'comparison', 'category_title'));
    }
}
