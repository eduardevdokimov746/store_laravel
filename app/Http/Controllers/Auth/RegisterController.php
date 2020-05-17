<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Email;
use App\Mail\ConfirmMail;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register(Request $request)
    {
        $this->validator($request->all());

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user, $request->input('remember'));

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new Response('', 201)
            : redirect($this->redirectPath());
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validator(array $data)
    {
        $rules = [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'unique:emails,email'],
            'password' => ['required', 'min:3', 'alpha_dash', 'regex:#[A-ZА-Я]+#u']
        ];

        $messages = [
            'required' => 'Не заполненно поле :attribute',
            'string' => 'Поле :attribute должно быть строкой',
            'min' => 'Длина :attribute должна быть более :min символов',
            'max' => 'Длина :attribute должна быть менее :max символов',
            'email' => 'Введен не корректный адрес электронной почты',
            'unique' => 'Пользователь с электронной почтой :input уже зарегистрирован.<br><a href="'.route('login').'">Забыли пароль?</a>',
            'regex' => 'Поле должно содержать хотя бы одну заглавную букву'
        ];

        $attribute = [
            'name' => 'имя',
            'email' => 'эл. почта',
            'password' => 'пароль'
        ];

        $validator = \Validator::make($data, $rules, $messages, $attribute);

        if ($validator->fails()) {
            if (isset($validator->failed()['email']['Unique'])) {
                $validator->messages()->add('email_unique', true);
            }
            throw new ValidationException($validator, '',Response::HTTP_TOO_MANY_REQUESTS);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \Illuminate\Foundation\Auth\User
     */
    protected function create(array $data)
    {
        $email = Email::make([
            'email' => $data['email'],
            'code_confirm' => md5(rand(1111, 9999))
        ]);

        $user = User::create([
            'name' => $data['name'],
            'password' => \Hash::make($data['password'])
        ]);

        $email = $user->email()->save($email);

        $user = $user->setRelation('email', $email);

        return $user;
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        \Mail::to($user->email->email)->send(new ConfirmMail($user));
    }
}
