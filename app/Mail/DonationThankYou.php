<?php

namespace App\Mail;

use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DonationThankYou extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Donation $donation) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🙏 Terima Kasih atas Donasi Anda – PeduliJiwa',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.donation.thankyou',
        );
    }
}
