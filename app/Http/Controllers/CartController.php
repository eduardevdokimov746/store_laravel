<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class CartController extends BaseController
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ProductRepository $productRepository)
    {
        $id = $request->input('id');

        if (\Cart::issetProduct($id)) {
            \Cart::increment($id);
        } else {
            $product = $productRepository->getForCart($id);

            if (!$product) {
                return response('error');
            }

            \Cart::add($product);
        }

        return response(\Cart::getAll());
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
        \Cart::delete($id);

        return response(\Cart::getAll());
    }

    public function flush()
    {
        \Cart::flush();

        return response('', 200);
    }

    public function increment(Request $request)
    {
        $id = $request->input('id');

        \Cart::increment($id);

        return response(\Cart::getAll());
    }

    public function decrement(Request $request)
    {
        $id = $request->input('id');

        \Cart::decrement($id);

        return response(\Cart::getAll());
    }
}
