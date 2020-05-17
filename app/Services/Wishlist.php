<?php

namespace App\Services;

use App\Models\Wishlist as Model;


class Wishlist
{
    public static function has($id)
    {
        if (\Auth::check()) {
            $result = Model::where('user_id', \Auth::id())
                ->join('wishlists_products', 'wishlists.id', 'wishlist_id')
                ->where('product_id', $id)
                ->exists();
        } else {
            $result = false;
        }

        return $result;
    }
}
