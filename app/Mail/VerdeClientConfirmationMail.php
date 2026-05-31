<?php

namespace App\Mail;

use App\Models\VerdeMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerdeClientConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public VerdeMessage $verdeMessage) {}

    public function build()
    {
        return $this->subject('Votre demande a bien ete recue - VERDE PARIS 75')
            ->view('emails.verde-client-confirmation');
    }
}
