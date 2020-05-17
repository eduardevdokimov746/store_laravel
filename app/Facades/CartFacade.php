<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\Cart;

class CartFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Cart::class;
    }
}
