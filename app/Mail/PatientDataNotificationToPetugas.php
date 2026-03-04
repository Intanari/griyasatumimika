<?php

namespace App\Mail;

use App\Models\Patient;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PatientDataNotificationToPetugas extends Mailable
{
    use Queueable, SerializesModels;

    /** @var 'created'|'updated'|'deleted' */
    public string $action;

    public function __construct(public Patient $patient, string $action)
    {
        $this->action = $action;
    }

    public function envelope(): Envelope
    {
        $subjects = [
            'created' => 'Pasien Baru Ditambahkan',
            'updated' => 'Data Pasien Diperbarui',
            'deleted' => 'Data Pasien Dihapus',
        ];
        $label = $subjects[$this->action] ?? 'Perubahan Data Pasien';
        $appName = config('app.name', 'PeduliJiwa');
        $from = config('mail.from');
        $subj = '👥 Data Pasien – ' . $label . ' – ' . $this->patient->nama_lengkap . ' – ' . $appName;
        return new Envelope(
            from: new Address($from['address'], $from['name']),
            subject: $subj,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.patient.notification-to-petugas',
        );
    }
}
