<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\ReplyTo;
use Illuminate\Queue\SerializesModels;

class ContactMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $data) {}

    public function envelope(): Envelope
    {
        $subject = $this->data['subjek'] ?? 'Pesan dari halaman Kontak';

        return new Envelope(
            subject: 'Kontak Website – ' . $subject,
            replyTo: [new ReplyTo($this->data['email'], $this->data['nama'])],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact.message',
        );
    }
}
