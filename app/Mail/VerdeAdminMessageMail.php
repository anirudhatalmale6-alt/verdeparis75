<?php

namespace App\Mail;

use App\Models\VerdeMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerdeAdminMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public VerdeMessage $verdeMessage) {}

    public function build()
    {
        return $this->subject('[VERDE] Nouveau message - ' . ($this->verdeMessage->subject ?: 'Contact site'))
            ->view('emails.verde-admin-message');
    }
}
