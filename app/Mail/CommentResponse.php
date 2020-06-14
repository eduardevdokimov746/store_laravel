<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ResponseComment;

class CommentResponse extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $comment;

    /**
     * Create a new message instance.
     *
     * @param ResponseComment $comment
     *
     * @return void
     */
    public function __construct($comment)
    {
        $this->comment = $comment;
        $this->onQueue('emails');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('На Ваш комментарий ответили!')->view('emails.comment-response', ['comment_response' => $this->comment]);
    }
}
