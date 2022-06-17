<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mail_content;

    public $team_owner;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message, $team_owner)
    {
        $this->mail_content = $message;
        $this->team_owner = $team_owner;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return	$this->from(config('mail.from'))
                     ->subject('Acme player status update')
                     ->view('emails.player_status');
    }
}
