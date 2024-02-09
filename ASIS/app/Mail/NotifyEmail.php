<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class NotifyEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

     protected $data = [];
    public $subject;
    public $content;
    public $closing;
    public $image;
    public $files;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject,$content,$closing,$image,$files)
    {
        //

        $this->subject = $subject;
        $this->content = $content;
        $this->closing = $closing;
        $this->image = $image;
        $this->files = $files;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $email = $this->markdown('e-hris-blade.emails.notify_email',[
            'url' => route('myEntranceExamResult'),
        ])->subject($this->subject);

        return $email;

    }
}
