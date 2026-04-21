<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class NuovaRichiestaStudenteMail extends Mailable
{
    public function build()
    {
        return $this->subject('Nuova Richiesta Studente')
            ->view('emails.nuova-richiesta-studente');
    }
}
