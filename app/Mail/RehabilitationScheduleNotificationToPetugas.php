<?php

namespace App\Mail;

use App\Models\RehabilitationSchedule;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RehabilitationScheduleNotificationToPetugas extends Mailable
{
    use Queueable, SerializesModels;

    /** @var 'created'|'updated'|'deleted' */
    public string $action;

    public function __construct(public RehabilitationSchedule $schedule, string $action)
    {
        $this->action = $action;
    }

    public function envelope(): Envelope
    {
        $subjects = [
            'created' => 'Jadwal Rehabilitasi Ditambahkan',
            'updated' => 'Jadwal Rehabilitasi Diperbarui',
            'deleted' => 'Jadwal Rehabilitasi Dihapus',
        ];
        $label = $subjects[$this->action] ?? 'Perubahan Jadwal Rehabilitasi';
        $appName = config('app.name', 'PeduliJiwa');
        $from = config('mail.from');
        $kegiatan = $this->schedule->nama_kegiatan ?? '-';

        return new Envelope(
            from: new Address($from['address'], $from['name']),
            subject: '🔄 Jadwal Rehabilitasi – ' . $label . ' – ' . $kegiatan . ' – ' . $appName,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.jadwal-rehabilitasi.notification-to-petugas',
        );
    }
}
