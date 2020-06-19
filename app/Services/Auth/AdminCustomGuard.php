<?php

namespace App\Services\Auth;

class AdminCustomGuard extends CustomGuard
{
    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        return $this->auth && $this->user->isAdmin;
    }
}
