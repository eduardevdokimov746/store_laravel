<?php

namespace App\Extensions;

use App\Interfaces\IViewedProductProvider;

class CookieViewedProvider implements IViewedProductProvider
{
    protected $storageName = 'viewed_products';
    protected $expires = 10080;

    /**
     * Get ids in format 1,2,3
     *
     * @return string
     */
    public function get()
    {
        return request()->cookie($this->storageName);
    }

    /**
     * Check isset viewed product
     *
     * @return bool
     */
    public function has()
    {
        return request()->hasCookie($this->storageName);
    }

    /**
     * Add id product in storage
     *
     * string $ids
     *
     * @return void
     */
    public function write($ids)
    {
        $cookie = cookie($this->storageName, $ids, $this->expires, '/');
        \Cookie::queue($cookie);
    }

    /**
     * Remove id product from storage
     *
     * @return void
     */
    public function remove()
    {
        \Cookie::queue(\Cookie::forget($this->storageName));
    }
}
