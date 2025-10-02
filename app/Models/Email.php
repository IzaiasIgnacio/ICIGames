<?php
namespace App\Models;

use Illuminate\Mail\Mailable;

class Email extends Mailable {

    // use Queueable, SerializesModels;
    private $emails;

    public function __construct($emails)
    {
        $this->subject('Alerta Keyshops');
        $this->emails = $emails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email', ['emails' => $this->emails]);
    }
	
}