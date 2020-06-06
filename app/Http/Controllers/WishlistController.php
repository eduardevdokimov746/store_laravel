<?php

namespace App\Http\Controllers;

use App\Extensions\ProductData;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductRepository $productRepository)
    {
        if (\Wishlist::isset()) {
            \Wishlist::getLists()->each(function ($item, $key) use ($productRepository) {
                if (\Wishlist::isNotEmpty($item->id)) {

                    $products = $productRepository->getWhereIds(\Wishlist::getProducts($item->id));

                    $products = $products->map(function ($product) {
                        return ProductData::changeForList($product);
                    });

                    \Wishlist::setProductsData($item->id, $products);
                }
            });
        }

        return view('wishlists.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $list = \Wishlist::create($request->only(['title']));

        if ($request->wantsJson()) {
            return JsonResponse::create($list, 200);
        }

        return response($list, 200);
    }

    public function addProduct(Request $request)
    {
        if (!$request->filled('id')) {
            return abort(404);
        }

        \Wishlist::addProduct($request->id);

        if ($request->wantsJson()) {
            return JsonResponse::create('', 200);
        }

        return response('', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if (\Wishlist::delete($id) === false) {
            return abort(500);
        }

        if ($request->wantsJson()) {
            return JsonResponse::create('', 200);
        }

        return response('', 200);
    }

    public function deleteProducts(Request $request)
    {
        if (!$request->filled(['list_id', 'product_ids'])) {
            return abort(422);
        }


        \Wishlist::deleteProducts($request->get('list_id'), explode(',', $request->get('product_ids')));

        if ($request->wantsJson()) {
            return JsonResponse::create('', 200);
        }

        return response('', 200);
    }

    public function default(Request $request, $id)
    {
        if (\Wishlist::changeDefaultList($id) === false) {
            return abort(500);
        }

        if ($request->wantsJson()) {
            return JsonResponse::create('', 200);
        }

        return response('', 200);
    }

    public function name(Request $request, $id)
    {
        if (\Wishlist::renameList($id, $request->get('title')) === false) {
            return abort(500);
        }

        if ($request->wantsJson()) {
            return JsonResponse::create($request->get('title'), 200);
        }

        return response($request->get('title'), 200);
    }
}
