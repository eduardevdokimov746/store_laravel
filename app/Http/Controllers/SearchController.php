<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Extensions\ProductData;
use App\Services\Sort;

class SearchController extends BaseController
{
    public function handle(Request $request)
    {
        $result = Product::selectRaw('title AS value, slug AS data')->where('title', 'like', '%'. $request->text .'%')->get();

        return JsonResponse::create(['suggestions' => $result], 200);
    }

    public function index(ProductRepository $productRepository, $searchText)
    {
        $sort = request()->input('sort');
        $sortTerm = Sort::getTerm($sort);

        $products = $productRepository->getSearch($searchText, $sortTerm);

        $products->transform(function ($item, $key) {
            return ProductData::changeForList($item);
        });

        if (request()->wantsJson()) {
            $view = \View::make('search.content', compact('products', 'searchText', 'sort'))->render();
            return \Response::json($view, 200);
        }

        return view('search.index', compact('products', 'searchText', 'sort'));
    }
}
