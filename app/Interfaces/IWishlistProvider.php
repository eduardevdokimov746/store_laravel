<?php

namespace App\Interfaces;

interface IWishlistProvider
{
    public function getAll($user_id);

    public function setProduct($list_id, $product_id);

    public function unsetProducts($list_id, $product_ids);

    public function create($data);

    public function delete($list_id);

    public function changeTitleList($list_id, $title);

    public function changeDefaultList($user_id, $list_id);
}
