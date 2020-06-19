<?php

namespace App\Http\Controllers\Admin;

use App\Extensions\ProductExtension;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddProductRequest;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use App\Services\Product as ServiceProduct;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductRepository $productRepository)
    {
        $products = $productRepository->getAllWithPagination(config('custom.admin.view_count_products'));

        $count_products = Product::count();

        return view('admin.products.index', compact('products', 'count_products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddProductRequest $request)
    {
        $product = ProductExtension::add($request);

        if (is_null($product)) {
            return back()->withErrors('Произошла ошибка добавления товара')->withInput();
        }

        return redirect()->route('admin.products.edit', $product->id)->with(['success' => 'Товар успешно добавлен']);
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
        $product = Product::with('info')->where('id', $id)->first();

        if (is_null($product)) {
            return abort(404);
        }

        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddProductRequest $request, $id)
    {
        $product = Product::find($id);

        if (is_null($product)) {
            return back()->withErrors('Товар не найден');
        }

        if (!ProductExtension::update($request, $product)) {
            return back()->withErrors('Произошла ошибка обновления товара')->withInput();
        }

        return back()->with(['success' => 'Товар успешно обновлен']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$product = Product::find($id)) {
            return back()->withErrors('Товар не найден');
        }

        if (!ProductExtension::delete($product)) {
            return back()->withErrors('Произошла ошибка удаления');
        }

        return redirect()->route('admin.products.index')->with(['success' => 'Товар успешно удален']);
    }
}
