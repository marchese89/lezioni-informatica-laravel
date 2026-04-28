<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class OrderCompletedMail extends Mailable
{
    public function __construct(
        public $user,
        public $pdf,
        public $data,
        public $total
    ) {}

    public function build()
    {
        return $this->subject('Ordine Effettuato')
            ->view('emails.order-success')
            ->with([
                'user' => $this->user,
                'data' => $this->data,
                'total' => $this->total,
            ])
            ->attachData(
                $this->pdf,
                'fattura.pdf',
                ['mime' => 'application/pdf']
            );
    }
}
