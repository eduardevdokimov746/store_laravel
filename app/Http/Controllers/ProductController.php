<?php

namespace App\Http\Controllers;

use App\Extensions\CommentData;
use App\Models\Comment;
use App\Models\LikeComment;
use App\Models\Product;
use App\Repositories\CommentRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use App\Services\Comparison;
use App\Extensions\ProductData;
use App\Services\Breadcrumbs;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug, ProductRepository $productRepository, CommentRepository $commentRepository)
    {
        $product = $productRepository->getForShow($slug);

        if (is_null($product)) {
            return abort(404);
        }

        $product = ProductData::changeForShow($product);

        $issetInWishlist = \Wishlist::hasProduct($product->id);
        $issetComparison = \Comparison::has($product->id);

        \ViewedProduct::add($product->id);

        $breadcrumbs = new Breadcrumbs($product->category_id, $product->title);

        $comments = $commentRepository->getForProductShow($product->id);

        $comments = $comments->map(function ($item, $key) {
            return CommentData::changeForShow($item);
        });

        return view('products.show', compact('product', 'comments', 'issetInWishlist', 'issetComparison', 'breadcrumbs'));
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
    public function destroy($id)
    {
        //
    }
}
