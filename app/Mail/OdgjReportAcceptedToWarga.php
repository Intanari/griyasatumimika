<?php

namespace App\Mail;

use App\Models\OdgjReport;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OdgjReportAcceptedToWarga extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public OdgjReport $report) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Laporan ODGJ Diterima – Petugas Akan Segera Menindaklanjuti – PeduliJiwa',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.odgj-report.accepted-to-warga',
        );
    }
}
