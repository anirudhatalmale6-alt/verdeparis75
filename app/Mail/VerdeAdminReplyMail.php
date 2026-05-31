<?php

namespace App\Mail;

use App\Models\VerdeMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerdeAdminReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public VerdeMessage $verdeMessage,
        public string $replySubject,
        public string $replyBody
    ) {}

    public function build()
    {
        return $this->subject($this->replySubject)
            ->replyTo(config('mail.from.address'), config('mail.from.name'))
            ->view('emails.verde-admin-reply');
    }
}
