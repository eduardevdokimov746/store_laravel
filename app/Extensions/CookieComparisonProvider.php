<?php

namespace App\Extensions;

use App\Interfaces\IComparisonProvider;

class CookieComparisonProvider implements IComparisonProvider
{
    protected $storageName = 'comparison';
    protected $expires = 10080;


    public function write($ids)
    {
        $cookie = cookie($this->storageName, $ids, $this->expires, '/');
        \Cookie::queue($cookie);
    }

    /**
     * Get comparison list
     *
     * @return $string
     */
    public function get()
    {
        return request()->cookie($this->storageName);
    }

    /**
     * Remove file storage
     *
     * @return void
     */
    public function remove()
    {
        \Cookie::queue(\Cookie::forget($this->storageName));
    }

    /**
     * Check isset file storage
     *
     * @return bool
     */
    public function has()
    {
        return request()->hasCookie($this->storageName);
    }
}
