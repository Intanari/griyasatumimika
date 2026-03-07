<?php

namespace App\Mail;

use App\Models\JadwalPetugas;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JadwalPetugasNotification extends Mailable
{
    use Queueable, SerializesModels;

    /** @var 'created'|'updated'|'deleted' */
    public string $action;

    public function __construct(public JadwalPetugas $jadwal, string $action)
    {
        $this->jadwal->load(['user', 'shiftModel']);
        $this->action = $action;
    }

    public function envelope(): Envelope
    {
        $subjects = [
            'created' => 'Jadwal Petugas Ditambahkan',
            'updated' => 'Jadwal Petugas Diperbarui',
            'deleted' => 'Jadwal Petugas Dihapus',
        ];
        $label = $subjects[$this->action] ?? 'Perubahan Jadwal Petugas';
        $appName = config('app.name', 'PeduliJiwa');
        $from = config('mail.from');
        $nama = $this->jadwal->user->name ?? '-';

        return new Envelope(
            from: new Address($from['address'], $from['name']),
            subject: '📅 Jadwal Petugas – ' . $label . ' – ' . $nama . ' – ' . $appName,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.jadwal-petugas.notification',
        );
    }
}
