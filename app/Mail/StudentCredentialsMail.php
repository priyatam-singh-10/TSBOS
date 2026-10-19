<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentCredentialsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $plainPassword;

    public function __construct($student, $plainPassword)
    {
        $this->student = $student;
        $this->plainPassword = $plainPassword;
    }

    public function build()
    {
        return $this->subject('Your Account Credentials')
            ->view('email.student_credentials');
    }
}
