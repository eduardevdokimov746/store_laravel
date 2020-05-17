<?php

namespace App\Extensions;

use Illuminate\Database\Eloquent\Model;

class CartExtension
{
    public static function createProduct(Model $product)
    {
        $product['count'] = 1;
        $product['price'] = round(\Currency::getCurrent()->value * $product['price'], 2);
        $product['sum'] = $product['price'];
        return $product;
    }

    public static function recalcItem($item, $newCurrencyValue, $isBase)
    {
        if ($isBase) {
            $item['price'] = $item['price'] * $newCurrencyValue;
            $item['sum'] = $item['sum'] * $newCurrencyValue;
        } else {
            $item['price'] = ($item['price'] / \Currency::getCurrent()->value) * $newCurrencyValue;
            $item['sum'] = ($item['sum'] / \Currency::getCurrent()->value) * $newCurrencyValue;
        }
        return $item;
    }
}
