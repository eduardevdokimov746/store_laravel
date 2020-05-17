<?php

namespace App\Extensions;

use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Carbon;

class CustomTokenRepository implements TokenRepositoryInterface
{
    /**
     * The token database table.
     *
     * @var string
     */
    protected $table;

    /**
     * The number of seconds a token should last.
     *
     * @var int
     */
    protected $expires;

    /**
     * Minimum number of seconds before re-redefining the token.
     *
     * @var int
     */
    protected $throttle;

    /**
     * Create a new token repository instance.
     *
     * @param  string  $table
     * @param  int  $expires
     * @param  int  $throttle
     * @return void
     */
    public function __construct()
    {
        $this->init();
    }

    protected function init()
    {
        $config = config('auth.passwords.custom');
        $this->table = $config['table'];
        $this->expires = $config['expire'];
        $this->throttle = $config['throttle'];
    }

    /**
     * Create a new token.
     *
     * @param \Illuminate\Contracts\Auth\CanResetPassword $user
     * @return string
     */
    public function create(CanResetPasswordContract $user)
    {
        $email = $user->getEmailForPasswordReset();

        $this->deleteExisting($user);

        $token = $this->createNewToken();

        \DB::table($this->table)->insert($this->getPayload($email, $token));

        return $token;
    }

    /**
     * Delete all existing reset tokens from the database.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @return int
     */
    protected function deleteExisting(CanResetPasswordContract $user)
    {
        return \DB::table($this->table)->where('email', $user->getEmailForPasswordReset())->delete();
    }

    /**
     * Build the record payload for the table.
     *
     * @param  string  $email
     * @param  string  $token
     * @return array
     */
    protected function getPayload($email, $token)
    {
        return ['email' => $email, 'token' => $token, 'created_at' => new Carbon];
    }

    /**
     * Create a new token for the user.
     *
     * @return string
     */
    public function createNewToken()
    {
        return mt_rand(11111111, 99999999);
    }

    /**
     * Determine if a token record exists and is valid.
     *
     * @param \Illuminate\Contracts\Auth\CanResetPassword $user
     * @param string $token
     * @return bool
     */
    public function exists(CanResetPasswordContract $user, $token)
    {
        $record = (array) \DB::table($this->table)->where(
            'email', $user->getEmailForPasswordReset()
        )->first();

        return $record &&
            ! $this->tokenExpired($record['created_at']) &&
            $token === $record['token'];
    }

    /**
     * Determine if the token has expired.
     *
     * @param  string  $createdAt
     * @return bool
     */
    protected function tokenExpired($createdAt)
    {
        return Carbon::parse($createdAt)->addSeconds($this->expires)->isPast();
    }

    /**
     * Determine if the given user recently created a password reset token.
     *
     * @param \Illuminate\Contracts\Auth\CanResetPassword $user
     * @return bool
     */
    public function recentlyCreatedToken(CanResetPasswordContract $user)
    {
        $record = (array) \DB::table($this->table)->where(
            'email', $user->getEmailForPasswordReset()
        )->first();

        return $record && $this->tokenRecentlyCreated($record['created_at']);
    }

    /**
     * Determine if the token was recently created.
     *
     * @param  string  $createdAt
     * @return bool
     */
    protected function tokenRecentlyCreated($createdAt)
    {
        if ($this->throttle <= 0) {
            return false;
        }

        return Carbon::parse($createdAt)->addSeconds(
            $this->throttle
        )->isFuture();
    }

    /**
     * Delete a token record.
     *
     * @param \Illuminate\Contracts\Auth\CanResetPassword $user
     * @return void
     */
    public function delete(CanResetPasswordContract $user)
    {
        $this->deleteExisting($user);
    }

    /**
     * Delete expired tokens.
     *
     * @return void
     */
    public function deleteExpired()
    {
        $expiredAt = Carbon::now()->subSeconds($this->expires);

        \DB::table($this->table)->where('created_at', '<', $expiredAt)->delete();
    }
}
