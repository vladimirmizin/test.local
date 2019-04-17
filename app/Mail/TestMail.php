<?php

namespace App\Mail;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;


    private $parentComment;
    private $subComment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Comment $parentComment,$subComment)
    {

        $this->parentComment = $parentComment;
        $this->subComment = $subComment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('mail', [
            'parentComment' => $this-> parentComment,
            'subComment' => $this->subComment
        ]);
    }
}
