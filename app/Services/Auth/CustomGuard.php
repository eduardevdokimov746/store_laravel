<?php

namespace App\Services\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\StatefulGuard;
use App\Extensions\CustomProvider;
use Illuminate\Contracts\Auth\UserProvider;
use App\Models\User;

class CustomGuard implements StatefulGuard
{
    protected $user = null;
    protected $auth = false;
    protected $provider;
    protected $isRemember = false;

    public function __construct(UserProvider $provider)
    {
        $this->provider = $provider;
        $this->init();
    }

    protected function init()
    {
        if ($user = $this->provider->getUserFromSession()) {
            $this->setUser($user);
        } elseif ($user = $this->getUserByToken()) {
            $this->provider->putSession($user);
            $this->isRemember = true;
            $this->setUser($user);
        }
    }

    protected function getUserByToken()
    {
        if (request()->hasCookie('remember_token')) {
            $token = request()->cookie('remember_token');
            return $this->provider->retrieveByToken(null, $token);
        }
        return null;
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        return $this->auth;
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest()
    {
        return !$this->check();
    }

    /**
     * Get the currently authenticated user.
     *
     * @return Authenticatable|null
     */
    public function user()
    {
        if ($this->check()) {
            return $this->user;
        }
        return null;
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|string|null
     */
    public function id()
    {
        if ($this->check()) {
            return $this->user->id;
        }
        return null;
    }

    /**
     * Validate a user's credentials.
     *
     * @param array $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        $issetCredentials = (isset($credentials['email']) && isset($credentials['password']));

        if ($issetCredentials && ($user = $this->provider->retrieveByCredentials($credentials))) {
            return $this->provider->validateCredentials($user, $credentials);
        }

        return false;
    }

    /**
     * Set the current user.
     *
     * @param Authenticatable $user
     * @return void
     */
    public function setUser(Authenticatable $user)
    {
        $this->auth = true;
        $this->user = $user;
    }

    /**
     * Attempt to authenticate a user using the given credentials.
     *
     * @param array $credentials
     * @param bool $remember
     * @return bool
     */
    public function attempt(array $credentials = [], $remember = false)
    {
        if (!$this->validate($credentials)) {
            return false;
        }

        if (!$user = $this->provider->retrieveByCredentials($credentials)) {
            return false;
        }

        if ($remember) {
            $this->isRemember = true;
            $token = md5($user->password);
            $this->provider->updateRememberToken($user, $token);
        }

        $this->setUser($user);
        $this->provider->putSession($user);

        return true;
    }

    /**
     * Log a user into the application without sessions or cookies.
     *
     * @param array $credentials
     * @return bool
     */
    public function once(array $credentials = [])
    {
        if ($this->validate($credentials)
            && ($user = $this->provider->retrieveByCredentials($credentials))) {
            $this->setUser($user);
            return true;
        }

        return false;
    }

    /**
     * Log a user into the application.
     *
     * @param Authenticatable $user
     * @param bool $remember
     * @return void
     */
    public function login(Authenticatable $user, $remember = false)
    {
        if ($remember) {
            $this->isRemember = true;
            $token = md5($user->password);
            $this->provider->updateRememberToken($user, $token);
        }

        $this->setUser($user);
        $this->provider->putSession($user);
    }

    /**
     * Log the given user ID into the application.
     *
     * @param mixed $id
     * @param bool $remember
     * @return Authenticatable
     */
    public function loginUsingId($id, $remember = false)
    {
        if ($user = $this->provider->retrieveById($id)) {
            $this->login($user, $remember);
            return $this->user;
        }

        return null;
    }

    /**
     * Log the given user ID into the application without sessions or cookies.
     *
     * @param mixed $id
     * @return Authenticatable|bool
     */
    public function onceUsingId($id)
    {
        if ($user = $this->provider->retrieveById($id)) {
            $this->setUser($user);
            return $this->user;
        }

        return false;
    }

    /**
     * Determine if the user was authenticated via "remember me" cookie.
     *
     * @return bool
     */
    public function viaRemember()
    {
        return $this->isRemember;
    }

    protected function setRemember()
    {
        $token = md5($this->user->password);
        $this->provider->updateRememberToken($this->user, $token);
    }

    /**
     * Log the user out of the application.
     *
     * @return void
     */
    public function logout()
    {
        if ($this->check()) {
            $this->provider->deleteSession();
            $this->provider->deleteCookieRememberToken($this->user());
        }
    }
}
