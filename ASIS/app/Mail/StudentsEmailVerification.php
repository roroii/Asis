<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentsEmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $content;
    public $closing;
    public $transactionId;
    public $image;
    public $files;
    public $closing_2;
    public $username;
    public $password;
    public $students_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject,$content,$closing, $closing_2, $students_id, $username, $password)
    {
        $this->subject = $subject;
        $this->content = $content;
        $this->closing = $closing;
        $this->closing_2 = $closing_2;
        $this->students_id = $students_id;
        $this->username = $username;
        $this->password = $password;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->markdown('auth.find_account.notify_email',[
            'url' => route('verifyMyEmailAddress', ['students_id' => $this->students_id, 'username' => $this->username, 'password' => $this->password]),
        ])->subject($this->subject);

        return $email;
    }
}
