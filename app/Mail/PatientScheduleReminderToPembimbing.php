<?php

namespace App\Mail;

use App\Models\PatientSchedule;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PatientScheduleReminderToPembimbing extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public PatientSchedule $schedule)
    {
    }

    public function envelope(): Envelope
    {
        $appName = config('app.name', 'PeduliJiwa');
        $from    = config('mail.from');
        $pasien  = $this->schedule->patient->nama_lengkap ?? '-';

        return new Envelope(
            from: new Address($from['address'], $from['name']),
            subject: '⏰ Pengingat Jadwal Pasien – ' . $pasien . ' – ' . $appName,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.jadwal-pasien.reminder-to-pembimbing',
        );
    }
}

