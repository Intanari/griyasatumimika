<?php

namespace App\Mail;

use App\Models\ExaminationHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ExaminationHistoryNotificationToPetugas extends Mailable
{
    use Queueable, SerializesModels;

    /** @var 'created'|'updated'|'deleted' */
    public string $action;

    public function __construct(public ExaminationHistory $examination, string $action)
    {
        $this->action = $action;
    }

    public function envelope(): Envelope
    {
        $subjects = [
            'created' => 'Riwayat Pemeriksaan Ditambahkan',
            'updated' => 'Riwayat Pemeriksaan Diperbarui',
            'deleted' => 'Riwayat Pemeriksaan Dihapus',
        ];
        $label     = $subjects[$this->action] ?? 'Perubahan Riwayat Pemeriksaan';
        $appName   = config('app.name', 'PeduliJiwa');
        $from      = config('mail.from');
        $pasien    = $this->examination->patient->nama_lengkap ?? '-';

        return new Envelope(
            from: new Address($from['address'], $from['name']),
            subject: '🩺 Riwayat Pemeriksaan – ' . $label . ' – ' . $pasien . ' – ' . $appName,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.riwayat-pemeriksaan.notification-to-petugas',
        );
    }
}
