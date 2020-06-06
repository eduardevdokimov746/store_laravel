<?php

namespace App\Extensions;

use App\Interfaces\IWishlistProvider;
use App\Models\Wishlist;
use App\Models\WishlistProduct;

class WishlistProvider implements IWishlistProvider
{
    public function getAll($user_id)
    {
        $result = Wishlist::with('products')->where('user_id', $user_id)->get();

        if ($result->isEmpty()) {
            return null;
        }

        return $result;
    }

    public function setProduct($list_id, $product_id)
    {
        WishlistProduct::create(['wishlist_id' => $list_id, 'product_id' => $product_id]);
    }

    public function unsetProducts($list_id, $product_ids)
    {
        WishlistProduct::where('wishlist_id', $list_id)->whereIn('product_id', $product_ids)->delete();
    }

    public function create($data)
    {
        return Wishlist::create($data);
    }

    public function delete($list_id)
    {
        Wishlist::where('id', $list_id)->delete();
    }

    public function changeTitleList($list_id, $title)
    {
        if (Wishlist::where('id', $list_id)->update(['title' => $title])) {
            return true;
        }
        return false;
    }

    public function changeDefaultList($user_id, $list_id)
    {
        if (Wishlist::where('user_id', $user_id)->where('type_def', 1)->update(['type_def' => 0])) {
            Wishlist::where('id', $list_id)->update(['type_def' => 1]);
            return true;
        }
        return false;
    }
}
