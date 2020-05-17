<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Mail\RestorePassword;
use App\Services\CustomBroker;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Validate the email for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $rules = [
            'email' => 'required|email|exists:emails,email|bail'
        ];

        $messages = [
            'required' => 'Поле должно быть заплненно',
            'email' => 'Введите верно адрес эл. почты',
            'exists' => 'Данный адрес эл. почты не зарегистрирован'
        ];

        \Validator::validate($request->only('email'), $rules, $messages);
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        if ($request->wantsJson()) {
            throw ValidationException::withMessages([
                'email' => 'Данный адрес эл. почты не зарегистрирован',
            ]);
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Данный адрес эл. почты не зарегистрирован']);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return app(CustomBroker::class);
    }
}
