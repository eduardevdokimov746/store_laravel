<?php

namespace App\Interfaces;

interface IComparisonProvider
{
    /**
     * Write product ids in storage
     *
     * string $ids
     *
     * @return void
     */
    public function write($ids);

    /**
     * Get comparison list
     *
     * @return $string
     */
    public function get();

    /**
     * Remove file storage
     *
     * @return void
     */
    public function remove();

    /**
     * Check isset file storage
     *
     * @return bool
     */
    public function has();
}
