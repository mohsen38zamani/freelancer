<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TwoStepVerificationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $user_profileid;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_profileid)
    {
        $this->user_profileid = $user_profileid;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.TwoStepVerificationMail');
    }
}
