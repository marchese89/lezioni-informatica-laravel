<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Storage;

class OrderCompletedMail extends Mailable
{
    public function __construct(
        public User $user,
        public string $pdf_path,
        public string $data,
        public float $total
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
            ->attach(
                Storage::disk('private')->path($this->pdf_path),
                [
                    'as' => 'fattura.pdf',
                    'mime' => 'application/pdf',
                ]
            );
    }
}
