<?php

namespace App\Mail;

use App\Models\OdgjReport;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OdgjReportThankYouToWarga extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public OdgjReport $report) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Terima Kasih – Laporan ODGJ Anda Telah Diterima – PeduliJiwa',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.odgj-report.thankyou-to-warga',
        );
    }
}
