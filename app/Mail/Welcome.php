<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Welcome extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user             =   $user;
        $this->first_name       =   $user->first_name;
        $this->last_name        =   $user->last_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data['user']   =   $this->user;
        return $this->markdown('emails.welcome', $data)->subject('Welcome '.$this->first_name.' '.$this->last_name.'!');
    }
}
