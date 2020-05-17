<?php

namespace App\Models;

use App\Mail\RestorePassword;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function email()
    {
        return $this->hasOne(Email::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }

    public function setRememberToken($value)
    {
        $this->attributes[$this->getRememberTokenName()] = $value;
        $this->save();
    }

    public function getRememberToken()
    {
        return $this->{$this->getRememberTokenName()};
    }

    public function getRememberTokenName()
    {
        if (property_exists($this, 'rememberTokenName')) {
            return $this->rememberTokenName;
        } else {
            return 'remember_token';
        }
    }

    public function getEmailForPasswordReset()
    {
        return $this->email->email;
    }

    public function sendPasswordResetNotification($token)
    {
        \Mail::to($this->email->email)->send(new RestorePassword($this->name, $this->email->email, $token));
    }

    public function getRestorePassTokenAttribute()
    {
        return \DB::table('password_resets')->where('email', $this->email->email)->value('token');
    }
}
