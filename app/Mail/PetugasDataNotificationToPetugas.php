<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PetugasDataNotificationToPetugas extends Mailable
{
    use Queueable, SerializesModels;

    public string $action;

    public function __construct(public User $petuga, string $action)
    {
        $this->action = $action;
    }

    public function envelope(): Envelope
    {
        $subjects = [
            'created' => 'Data Petugas Ditambahkan',
            'updated' => 'Data Petugas Diperbarui',
            'deleted' => 'Data Petugas Dihapus',
        ];
        $label   = $subjects[$this->action] ?? 'Perubahan Data Petugas';
        $appName = config('app.name', 'PeduliJiwa');
        $from    = config('mail.from');

        return new Envelope(
            from: new Address($from['address'], $from['name']),
            subject: 'Data Petugas – ' . $label . ' – ' . $this->petuga->name . ' – ' . $appName,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.petugas.notification-to-petugas',
        );
    }
}
