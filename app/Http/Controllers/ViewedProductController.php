<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewedProductController extends Controller
{
    public function index()
    {
        return view('viewed-product.index');
    }
}
