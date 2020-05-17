<?php

namespace App\Http\Controllers;

use App\Services\Currency;
use Cart;
use Cookie;
use Illuminate\Http\Request;

class CurrencyController extends BaseController
{
    public function change(Request $request)
    {
        if (empty($request->currency)) {
            return abort();
        }

        $currency = $request->currency;

        if (session()->has('cart')) {
            $currencyObj = \Currency::getObject($currency);
            \Cart::recalculate($currencyObj->value);
        }

        $cookieCurrency = cookie('currency', $currency, time() + 60 * 60 * 24 * 2, '/');

        return back()->withCookie($cookieCurrency);
    }
}
