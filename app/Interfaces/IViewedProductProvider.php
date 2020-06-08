<?php

namespace App\Interfaces;

interface IViewedProductProvider
{
    /**
     * Get ids in format 1,2,3
     *
     * @return string
     */
    public function get();

    /**
     * Check isset viewed product
     *
     * @return bool
     */
    public function has();

    /**
     * Add id product in storage
     *
     * string $ids
     *
     * @return void
     */
    public function write($ids);

    /**
     * Remove id product from storage
     *
     * @return void
     */
    public function remove();


    /**
     *Check is empty cookie bag
     *
     * @return bool
     */
    public function empty();
}
