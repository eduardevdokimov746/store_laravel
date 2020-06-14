<?php

namespace App\Extensions;

use App\Interfaces\IComparisonProvider;

class CookieComparisonProvider implements IComparisonProvider
{
    protected $storage_name = 'comparison';
    protected $expires = 10080;


    public function write($data)
    {
        $cookie = cookie($this->storage_name, $data, $this->expires, '/');
        \Cookie::queue($cookie);
    }

    /**
     * Get comparison list
     *
     * @return $string
     */
    public function get()
    {
        return request()->cookie($this->storage_name);
    }

    /**
     * Remove file storage
     *
     * @return void
     */
    public function remove()
    {
        \Cookie::queue(\Cookie::forget($this->storage_name));
    }

    /**
     * Check isset file storage
     *
     * @return bool
     */
    public function has()
    {
        return request()->hasCookie($this->storage_name);
    }
}
