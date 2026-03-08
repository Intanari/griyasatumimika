<?php

namespace App\Mail;

use App\Models\OdgjReport;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OdgjReportResponToWarga extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public OdgjReport $report,
        public string $pesanRespon
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Respon Laporan ODGJ No. ' . $this->report->nomor_laporan . ' – PeduliJiwa',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.odgj-report.respon-to-warga',
        );
    }
}
