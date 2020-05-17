<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\ConfirmMail;

class ConfirmEmailController extends Controller
{
    public function handler($code)
    {
        $updates = [
            'is_confirm' => 1,
            'code_confirm' => null
        ];

        if (\Auth::user()->email->code_confirm == $code) {
            \Auth::user()->email->fill($updates);
            \Auth::user()->email->save();
            return redirect()->route('profile.show')->with(['confirmed' => true]);
        }

        return redirect()->route('index');
    }

    public function sendDublicateMail()
    {
        \Mail::to(\Auth::user()->email->email)->send(new ConfirmMail(\Auth::user()));
    }
}
