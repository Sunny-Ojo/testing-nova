<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountData extends Mailable
{
    use Queueable, SerializesModels;

    public $announcement;
    public $model;
    public $subject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($model, $subject, $announcement)
    {
        $this->announcement = $announcement;
        $this->subject = $subject;
        $this->model = $model;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.account-data')->with(['announcement', $this->announcement, 'subject' => $this->subject]);
    }
}
