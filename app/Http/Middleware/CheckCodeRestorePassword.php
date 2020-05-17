<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\MessageBag;

class CheckCodeRestorePassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->filled('email')) {

            $token = \DB::table('password_resets')->where('email', $request->email)->value('token');

            if ($token == $request->token) {
                return $next($request);
            }
        }

        return redirect()->route('password.request');
    }
}
