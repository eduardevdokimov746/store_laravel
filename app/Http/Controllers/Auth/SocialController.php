<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Email;
use Illuminate\Http\Request;
use App\Models\User;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        return \Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $userSocial = \Socialite::driver($provider)->user();

        $user = User::whereHas('email', function ($query) use ($userSocial) {
            $query->where('email', $userSocial->getEmail());
        })->first();

        if ($user === null) {
            $email = Email::make([
                'email' => $userSocial->getEmail(),
                'is_confirm' => 1,
            ]);

            $user = User::create([
                'name' => $userSocial->getName(),
                'password' => null
            ]);

            $user->email()->save($email);
        }

        \Auth::login($user);

        return redirect()->route('index');
    }
}
