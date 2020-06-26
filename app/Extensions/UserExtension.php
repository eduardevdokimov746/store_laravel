<?php

namespace App\Extensions;

use App\Models\User;
use App\Models\Email;
use Illuminate\Http\Request;

class UserExtension
{

    /**
     * Check iseet user in database with email
     *
     * @param string $email
     * @return bool
     */
    public static function checkExistsWithEmail($email)
    {
        $result = User::whereExists(function ($query) use ($email) {
            $query->from('emails')->where('email', $email);
        })->exists();

        return $result;
    }

    public static function checkExistsEmailExceptUser(User $user, $email)
    {
        $user->email->email = $email;

        if (!$user->email->isDirty('email')) {
            return false;
        }

        $result = User::join('emails', 'emails.user_id', 'users.id')
            ->where('users.id', '!=', $user->id)
            ->where('emails.email', $email)
            ->exists();

        return $result;
    }


    /**
     * @param $data
     * @return User|null
     */
    public static function createForComment($data)
    {
        $email = Email::make(['email' => $data['email'], 'code_confirm' => md5(rand(1111, 9999))]);
        $user = User::create(
            [
                'name' => $data['name'],
                'password' => self::makePassword()
            ]);

        $user->email()->save($email);
        return $user;
    }

    protected static function makePassword()
    {
        return \Hash::make(md5(mt_rand(1111, 9999)));
    }

    public static function update(User $user, Request $request)
    {
        $update_data = self::validate($request);

        if (!empty($update_data['password'])) {
            $update_data['password'] = \Hash::make($update_data['password']);
        }

        $user->email->email = $update_data['email'];
        unset($update_data['email']);
        $user->fill($update_data);

        if ($user->push()) {
            return true;
        }

        return false;
    }

    protected static function validate(Request $request)
    {
        return $request->only(['name', 'email', 'role', 'password']);
    }

    protected static function validateEmailData(Request $request)
    {
        $data['is_confirm'] = 1;
        $data['code_confirm'] = null;
        $data['email'] = $request->get('email');
        return $data;
    }

    public static function create(Request $request)
    {
        $create_data = self::validate($request);

        $create_data['password'] = \Hash::make($create_data['password']);

        unset($create_data['email']);

        $email = Email::make(self::validateEmailData($request));

        if (!$user = User::create($create_data)) {
            return null;
        }

        $user->email()->save($email);

        return $user;
    }
}
