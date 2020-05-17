<?php

namespace App\Services;

class Sort
{
    public static function getTerm($key)
    {
        switch ($key) {
            case 'min_max_price':
                $sort = 'products.price';
                break;
            case 'max_min_price':
                $sort = 'products.price DESC';
                break;
            case 'pop':
                $sort = 'products.hit DESC';
                break;
            case 'new':
                $sort = 'products.new DESC';
                break;
            case 'rating':
                $sort = 'product_info.rating DESC';
                break;
            default:
                $sort = 'product_info.rating DESC';
                break;
        }
        return $sort;
    }

    public static function run($key)
    {
        $view = self::getHtml($key);
        include resource_path('views\layouts\sort\default.blade.php');
    }

    protected static function getHtml($key)
    {
        $li = file(resource_path('views\sort\default.blade.php'));
        $html = '';

        foreach ($li as $value) {
            if(\Str::contains($value, $key)){
                $active = "class='active'";
            }else{
                $active = '';
            }
            $html .= sprintf($value, $active);
        }
        return $html;
    }
}
