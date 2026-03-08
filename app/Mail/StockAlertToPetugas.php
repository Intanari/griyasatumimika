<?php

namespace App\Mail;

use App\Models\InventoryItem;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StockAlertToPetugas extends Mailable
{
    use Queueable, SerializesModels;

    /** @var array<array{item: InventoryItem, status: 'habis'|'hampir_habis'}> */
    public array $alerts;

    public function __construct(array $alerts)
    {
        $this->alerts = $alerts;
    }

    public function envelope(): Envelope
    {
        $countHabis = count(array_filter($this->alerts, fn ($a) => $a['status'] === 'habis'));
        $countLow = count(array_filter($this->alerts, fn ($a) => $a['status'] === 'hampir_habis'));
        $parts = [];
        if ($countHabis > 0) {
            $parts[] = $countHabis . ' barang habis';
        }
        if ($countLow > 0) {
            $parts[] = $countLow . ' barang hampir habis';
        }
        $subject = '📦 Peringatan Stok – ' . implode(', ', $parts) . ' – ' . config('app.name', 'PeduliJiwa');

        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.stock.alert-to-petugas',
        );
    }
}
