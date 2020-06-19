<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class IndexController extends BaseController
{
    public function __construct()
    {
        $this->middleware('admin.auth');
    }

    public function index()
    {
        $count_users = User::count();
        $count_categories = Category::count();
        $count_products = Product::count();
        $count_new_orders = Order::where('confirmed_at', null)->count();

        return view('admin.index.index', compact('count_users', 'count_categories', 'count_new_orders', 'count_products'));
    }
}
