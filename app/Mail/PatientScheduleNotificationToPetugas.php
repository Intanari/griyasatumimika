<?php

namespace App\Mail;

use App\Models\PatientSchedule;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PatientScheduleNotificationToPetugas extends Mailable
{
    use Queueable, SerializesModels;

    /** @var 'created'|'updated'|'deleted' */
    public string $action;

    public function __construct(public PatientSchedule $schedule, string $action)
    {
        $this->action = $action;
    }

    public function envelope(): Envelope
    {
        $subjects = [
            'created' => 'Jadwal Pasien Ditambahkan',
            'updated' => 'Jadwal Pasien Diperbarui',
            'deleted' => 'Jadwal Pasien Dihapus',
        ];
        $label   = $subjects[$this->action] ?? 'Perubahan Jadwal Pasien';
        $appName = config('app.name', 'PeduliJiwa');
        $from    = config('mail.from');
        $pasien  = $this->schedule->patient->nama_lengkap ?? '-';

        return new Envelope(
            from: new Address($from['address'], $from['name']),
            subject: '📅 Jadwal Pasien – ' . $label . ' – ' . $pasien . ' – ' . $appName,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.jadwal-pasien.notification-to-petugas',
        );
    }
}
