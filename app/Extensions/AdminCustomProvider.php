<?php

namespace App\Extensions;

use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\User;
use App\Models\Email;
use App\Extensions\CustomProvider;

class AdminCustomProvider extends CustomProvider
{
    /**
     * Retrieve a user by their unique identifier.
     *
     * @param mixed $identifier
     * @return Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        $email = Email::select('user_id')
            ->where('email', $identifier)
            ->join('users', 'users.id', 'emails.user_id')
            ->where('role', 'admin')
            ->first();

        if (is_null($email)) {
            return null;
        }

        $user = User::find($email->user_id);

        return $user;
    }


}
