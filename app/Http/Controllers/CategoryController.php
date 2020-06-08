<?php

namespace App\Http\Controllers;

use App\Extensions\ProductData;
use App\Repositories\ProductRepository;
use App\Services\Breadcrumbs;
use App\Services\Sort;
use Illuminate\Http\Request;
use App\Services\Filter;

class CategoryController extends BaseController
{
    public function index()
    {
        return view('categories.index');
    }

    public function show($slug)
    {
        $categoriesTree = \Category::getCurrentWithChild($slug);

        if (is_null($categoriesTree)) {
            return abort(404);
        }

        return view('categories.show', compact('categoriesTree'));
    }

    public function products(ProductRepository $productRepository, $slug)
    {
        $sort = request()->input('sort');
        $sortTerm = Sort::getTerm($sort);

        $category_id = \Category::getId($slug);
        
        $categoryTitle = \Category::get($category_id)['title'];

        $filter = new Filter(request(), $category_id);

        $products = $filter->getProducts($productRepository, $sortTerm);

        $products->transform(function ($item, $key) {
            return ProductData::changeForList($item);
        });

        $breadcrumbs = new Breadcrumbs($category_id, $categoryTitle);

        if (request()->wantsJson()) {
            $view = \View::make('categories.content', compact('products', 'categoryTitle', 'sort', 'breadcrumbs', 'category_id', 'filter'))->render();
            return \Response::json($view, 200);
        }

        return view('categories.products', compact('products', 'categoryTitle', 'sort', 'breadcrumbs', 'category_id', 'filter'));
    }
}
