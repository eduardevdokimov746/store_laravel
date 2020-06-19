<?php

namespace App\Repositories;

use App\Models\Product as Model;

class ProductRepository extends CoreRepository
{
    public function __construct(Model $model)
    {
        $this->setModel($model);
    }

    public function getWhereCategory($ids)
    {
        $select = [
            'id',
            'title',
            'slug',
            'price',
            'old_price',
            'img',
            'hit',
            'new'
        ];

        if (is_int($ids)) {
            $in[] = $ids;
        } else {
            $in = $ids->toArray();
        }

        $result = $this->startConditions()
            ->select($select)
            ->whereIn('category_id', $in)
            ->where(function ($query) {
                $query->where('hit', 1)
                    ->orWhere('new', 1)
                    ->orWhere('old_price', '>', 0);
            })->take(8)->get();

        return $result;
    }

    public function getWhereIds($product_ids)
    {
        $select = [
            'id',
            'title',
            'slug',
            'price',
            'old_price',
            'img',
            'hit',
            'new'
        ];

        $result = $this->startConditions()
            ->select($select)
            ->whereIn('id', $product_ids)
            ->get();

        return $result;
    }

    public function getForCart($id)
    {
        $select = [
            'id',
            'title',
            'slug',
            'price',
            'img'
        ];

        return $this->startConditions()
            ->select($select)
            ->where('id', $id)
            ->first();
    }

    public function getForShow($slug)
    {
        $select = [
            'id',
            'category_id',
            'title',
            'slug',
            'price',
            'old_price',
            'img',
        ];

        $selectInfo = [
            'product_id',
            'hrefs_img',
            'big_specifications',
            'rating'
        ];

        return $this->startConditions()
            ->select($select)
            ->where('slug', $slug)
            ->with(['info' => function ($query) use ($selectInfo) {
                $query->select($selectInfo);
            }])
            ->withCount('comments')
            ->first();
    }

    public function getSearch($search, $sort)
    {
        $select = [
            'products.id',
            'products.slug',
            'products.title',
            'products.img',
            'products.price',
            'products.old_price',
            'products.hit',
            'products.new',
            'product_info.product_id',
            'product_info.rating',
        ];

        return $this->startConditions()
            ->select($select)
            ->join('product_info', 'product_id', 'products.id')
            ->where('title', 'like', '%'. $search .'%')
            ->orderByRaw($sort)
            ->paginate(12);
    }

    public function getWhereCategories($category_id, $sort)
    {
        $select = [
            'products.id',
            'products.slug',
            'products.title',
            'products.img',
            'products.price',
            'products.old_price',
            'products.hit',
            'products.new',
            'product_info.product_id',
            'product_info.rating',
        ];

        return $this->startConditions()
            ->select($select)
            ->join('product_info', 'product_id', 'products.id')
            ->where('category_id', $category_id)
            ->orderByRaw($sort)
            ->paginate(12);
    }

    public function getWhereCategoriesWithFilter($category_id, $sort, $product_id_filtered)
    {
        $select = [
            'products.id',
            'products.slug',
            'products.title',
            'products.img',
            'products.price',
            'products.old_price',
            'products.hit',
            'products.new',
            'product_info.product_id',
            'product_info.rating',
        ];



        return $this->startConditions()
            ->select($select)
            ->join('product_info', 'product_id', 'products.id')
            ->where('category_id', $category_id)
            ->whereIn('products.id', $product_id_filtered)
            ->orderByRaw($sort)
            ->paginate(12);
    }

    public function getForComparison($product_ids)
    {
        $select = [
            'products.id',
            'products.slug',
            'products.title',
            'products.img',
            'products.price',
            'product_info.big_specifications'
        ];

        return $this->startConditions()
            ->select($select)
            ->join('product_info', 'products.id', 'product_info.product_id')
            ->whereIn('products.id', $product_ids)
            ->get();
    }

    public function getAllWithPagination($count_product)
    {
        $select = [
            'products.id',
            'products.category_id',
            'products.title',
            'products.price',
            'products.is_published'
        ];

        return $this->startConditions()
            ->select($select)
            ->with('category:id,title')
            ->orderBy('id')
            ->paginate($count_product);
    }
}
