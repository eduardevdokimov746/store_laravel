<?php

namespace App\Http\Controllers\Admin;

use App\Extensions\UserExtension;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('email:user_id,email')->paginate(config('custom.admin.view_count_users'));

        $count_users = User::count();

        return view('admin.users.index', compact('users', 'count_users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddUserRequest $request)
    {
        if (!$user = UserExtension::create($request)) {
            return back()->withInput()->withErrors('Произошла ошибка создания пользователя');
        }

        return redirect()->route('admin.users.edit', $user->id)->with(['success' => 'Пользователь успешно создан']);
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
        $user = User::with(['email:user_id,email', 'orders'])->where('users.id', $id)->first();

        if (is_null($user)) {
            return redirect()->route('admin.users.index');
        }

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return back()->withErrors('Пользователь не существует');
        }

        if (UserExtension::checkExistsEmailExceptUser($user, $request->get('email'))) {
            return back()->withErrors('Другой пользователь уже зарегистрирован с данным ардесом эл. почты');
        }

        if (!UserExtension::update($user, $request)) {
            return back()->withErrors('Произошла ошибка обновления');
        }

        return back()->with(['success' => 'Данные пользователя успешно обновлены']);
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
