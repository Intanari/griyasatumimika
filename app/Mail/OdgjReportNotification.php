<?php

namespace App\Mail;

use App\Models\OdgjReport;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OdgjReportNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public OdgjReport $report) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🚨 Laporan ODGJ Baru Masuk – ' . $this->report->kategori_label . ' – PeduliJiwa',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.odgj-report.notification',
        );
    }
}
