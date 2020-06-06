<?php

namespace App\Extensions;

use App\Models\Product;

class ProductData
{
    public static function changeForList(Product $product)
    {
        $small_title = self::title($product->title);
        $price = self::price($product->price);
        $old_price = self::price($product->old_price);
        $sticker = self::sticker($product);

        $product->small_title = $small_title;
        $product->price = $price;
        $product->old_price = $old_price;
        $product->sticker = $sticker;

        return $product;
    }


    public static function changeForShow(Product $product)
    {
        $price = self::price($product->price);
        $old_price = self::price($product->old_price);

        $result = [
            'price' => $price,
            'old_price' => $old_price,
        ];

        $product->fill($result);

        $product = self::imagesToArray($product);

        return $product;
    }

    public static function imagesToArray(Product $product)
    {
        $imgs = $product->info->hrefs_img;

        if (strpos($imgs, ',')) {
            $imgsCollect = collect(explode(',', $imgs));
        } else {
            $imgsCollect = collect($imgs);
        }

        $product->info->imgsCollection = $imgsCollect
            ->take(3)
            ->map(function ($item, $key) {
                return 'storage/images/' . $item;
            });

        return $product;
    }

    public static function title($title)
    {
        if (strlen($title) > 30) {
            $result = mb_substr($title, 0, 30) . '...';
        }else{
            $result = $title;
        }

        return $result;
    }

    public static function price($price)
    {
        if ($price > 0) {
            $price *= \Currency::getCurrent()->value;
            return round($price, 2);
        }

        return 0;
    }

    public static function sticker(Product $product)
    {
        if($product->old_price > 0){
            $result = "<div class='new-tag'><h6>{$product->discount}%</h6></div>";
        }elseif($product['hit'] > 0){
            $result = "<div class='new-tag'><h6>Топ</h6></div>";
        }elseif($product['new'] > 0){
            $result = "<div class='new-tag'><h6>Новый</h6></div>";
        }else{
            $result = '';
        }
        return $result;
    }
}
