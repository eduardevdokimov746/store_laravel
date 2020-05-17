<?php

namespace App\Extensions;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use App\Models\User;
use App\Models\Email;

class CustomProvider implements UserProvider
{
    protected $sessionName = 'authenticate-user';

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param mixed $identifier
     * @return Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        $email = Email::select('user_id')->where('email', $identifier)->first();

        if (is_null($email)) {
            return null;
        }

        $user = User::find($email->user_id);

        return $user;
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param mixed $identifier
     * @param string $token
     * @return Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        return User::with('email')
            //->where('id', $identifier)
            ->where('remember_token', $token)
            ->first();
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param Authenticatable $user
     * @param string $token
     * @return void
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        $user->setRememberToken($token);
        $this->setCookieRememberToken($token);
    }

    public function setCookieRememberToken($token)
    {
        \Cookie::queue('remember_token', $token, 10080 * 2, '/');
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param array $credentials
     * @return Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        if (isset($credentials['email'])) {
            return $this->retrieveById($credentials['email']);
        }

        return null;
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param Authenticatable $user
     * @param array $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        if (isset($credentials['password'])) {
            return \Hash::check($credentials['password'], $user->password);
        }

        return false;
    }

    /**
     * Get data user from session
     *
     * @return Authenticatable|null
     */
    public function getUserFromSession()
    {
        if ($this->hasSession()) {
            $user = session()->get($this->sessionName);
            return $user;
        }
        return null;
    }

    /**
     * Check isset session file
     *
     * @return bool
     */
    protected function hasSession()
    {
        return session()->has($this->sessionName);
    }

    public function putSession($user)
    {
        if ($this->hasSession()) {
            $this->deleteSession();
        }
        session()->put($this->sessionName, $user);
    }

    public function deleteSession()
    {
        session()->forget($this->sessionName);
    }

    public function deleteCookieRememberToken($user)
    {
        $user->setRememberToken(null);
        $deleteCookie = \Cookie::forget('remember_token');
        \Cookie::queue($deleteCookie);
    }
}
