<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $data) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Nuevo mensaje de contacto: ' . ($this->data['subject'] ?? ''));
    }

    public function content(): Content
    {
        return new Content(view: 'mail.contact', with: ['data' => $this->data]);
    }
}
