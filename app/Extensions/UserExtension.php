<?php

namespace App\Extensions;

use App\Models\User;
use App\Models\Email;

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
}
