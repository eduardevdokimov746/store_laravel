<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RestorePassword extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $name;
    protected $email;
    protected $code;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email,  $code)
    {
        $this->name = $name;
        $this->email = $email;
        $this->code = $code;
        $this->onQueue('emails');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $with = [
            'name' => $this->name,
            'email' => $this->email,
            'code' => $this->code
        ];
        return $this->subject('Восстановление пароля')->view('emails.restore-password', $with);
    }
}
