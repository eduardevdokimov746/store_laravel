<?php

namespace App\Http\Controllers;

use App\Extensions\UserExtension;
use App\Mail\ConfirmMail;
use App\Mail\CreateOrder;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\Order;
use App\Models\Order as ModelOrder;

class OrderController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth')->only('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = ModelOrder::where('user_id', \Auth::id())->with('products')->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (\Cart::isEmpty()) {
            return redirect()->route('index');
        }

        return view('orders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (\Auth::guest()) {
            //Если не пользователь авторизован
            if(UserExtension::checkExistsWithEmail($request->get('email'))){
                //Если аккаунт существует
                return JsonResponse::create('mail_exists', 200);
            }

            $user = UserExtension::createForComment($request->only(['name', 'email']));

            if ($user instanceof Authenticatable) {
                \Mail::to($user->email->email)->send(new ConfirmMail($user));
                \Auth::login($user);
            } else {
                return abort(422);
            }
        }

        $order = new Order(\Auth::id(), \Cart::getCount(), \Cart::getSum(), \Currency::getCurrentId());

        if ($order_model = $order->add($request)) {
            $order->addProducts($order_model, \Cart::getProducts());
            \Mail::to(\Auth::user()->email->email)->send(new CreateOrder(\Cart::getProducts(), \Cart::getSum(), \Cart::getCount()));
            \Cart::flush();
            return JsonResponse::create('', 200);
        }

        return abort(422);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
