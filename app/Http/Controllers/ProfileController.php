<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ChangePasswordRequest;

class ProfileController extends BaseController
{
    public function show()
    {
        return view('profile.show');
    }

    public function showFormChangePass()
    {
        return view('profile.change-password');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        \Auth::user()->password = \Hash::make($request->input('newPass'));
        \Auth::user()->save();
        return response('', 200);
    }

    public function changeName(Request $request)
    {
        if (!$request->filled('name')) {
            return response('', 422);
        }

        \Auth::user()->name = $request->input('name');
        \Auth::user()->save();
        return response('', 200);
    }
}
