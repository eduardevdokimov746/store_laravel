<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OrderRepository $orderRepository)
    {
        $orders = $orderRepository->getAllWithPagination(config('custom.admin.view_count_orders'));

        $count_orders = Order::count();

        return view('admin.orders.index', compact('orders', 'count_orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderRepository $orderRepository, $id)
    {
        $order = $orderRepository->getForShow($id);

        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!$request->has('action')) {
            return back();
        }

        if ($request->get('action') == 'confirmed') {
            Order::find($id)->update(['status' => 1, 'confirmed_at' => Carbon::now()]);
            return back()->with(['success' => 'Заказ успешно подтвержден!']);
        } else {
            Order::find($id)->update(['status' => 0, 'confirmed_at' => null]);
            return back()->with(['success' => 'Заказ вернут на доработку!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($order = Order::find($id)) {
            $order->delete();
            return redirect()->route('admin.orders.index')->with(['success' => 'Заказ успешно удален!']);
        }
    }
}
