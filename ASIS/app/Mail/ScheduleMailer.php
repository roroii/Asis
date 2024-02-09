<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ScheduleMailer extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $content;
    public $closing;
    public $transactionId;
    public $image;
    public $files;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject,$content,$closing, $encrypted_transactionId)
    {
        $this->subject = $subject;
        $this->content = $content;
        $this->closing = $closing;
        $this->transactionId = $encrypted_transactionId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->markdown('e-hris-blade.emails.notify_email',[
            'url' => route('transactionListDetails', ['transactionId' => $this->transactionId]),
        ])->subject($this->subject);

        return $email;

//        return $this->view('e-hris-blade.emails.notify_email')->subject('Subject of the email');
    }
}
