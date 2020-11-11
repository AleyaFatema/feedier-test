<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyAnswersToAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $responses;

    /**
     * Create a new message instance.
     * NotifyAnswersToAdmin constructor.
     * @param $responses
     */
    public function __construct($responses)
    {
        $this->responses = $responses;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.answers_in_last_two_days')
            ->subject('Answers from past 48 hours');
    }
}
