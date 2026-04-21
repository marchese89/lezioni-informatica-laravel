<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class RichiestaEvasaMail extends Mailable
{
    public function build()
    {
        return $this->subject('Richiesta Evasa')
            ->view('emails.richiesta-evasa');
    }
}
