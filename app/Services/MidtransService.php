<?php

namespace App\Services;

use App\Models\Donation;
use Midtrans\Config;
use Midtrans\CoreApi;
use Midtrans\Notification;
use Midtrans\Transaction;

class MidtransService
{
    public function __construct()
    {
        $this->configure();
    }

    public function isConfigured(): bool
    {
        return (bool) config('services.midtrans.server_key');
    }

    public function configure(): void
    {
        Config::$serverKey = (string) config('services.midtrans.server_key');
        Config::$isProduction = (bool) config('services.midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function chargeQris(Donation $donation, string $programLabel): object
    {
        return CoreApi::charge([
            'payment_type' => 'qris',
            'transaction_details' => [
                'order_id'     => $donation->order_id,
                'gross_amount' => $donation->amount,
            ],
            'customer_details' => [
                'first_name' => $donation->donor_name,
                'email'      => $donation->donor_email,
                'phone'      => $donation->donor_phone,
            ],
            'item_details' => [[
                'id'       => $donation->program,
                'price'    => $donation->amount,
                'quantity' => 1,
                'name'     => $programLabel,
            ]],
            'qris' => ['acquirer' => 'gopay'],
        ]);
    }

    public function getStatus(string $orderId): object
    {
        return Transaction::status($orderId);
    }

    public function parseNotification(): Notification
    {
        return new Notification();
    }

    public function normalizeStatus(string $transactionStatus, ?string $fraudStatus = null): string
    {
        if (in_array($transactionStatus, ['settlement', 'capture'], true)
            && ($fraudStatus === 'accept' || $fraudStatus === null)) {
            return 'paid';
        }

        if ($transactionStatus === 'expire') {
            return 'expired';
        }

        if (in_array($transactionStatus, ['cancel', 'deny', 'failure'], true)) {
            return 'failed';
        }

        return 'pending';
    }

    /** @return array<string, mixed> */
    public function mapChargeResponse(object $response, Donation $donation): array
    {
        $qrCodeUrl = null;

        if (! empty($response->actions)) {
            foreach ($response->actions as $action) {
                if (($action->name ?? '') === 'generate-qr-code') {
                    $qrCodeUrl = $action->url ?? null;
                    break;
                }
            }

            $qrCodeUrl ??= $response->actions[0]->url ?? null;
        }

        $expiredMinutes = (int) config('services.midtrans.expired_minutes', 15);

        return [
            'payment_gateway' => 'midtrans',
            'transaction_id'  => $response->transaction_id ?? null,
            'total_amount'    => (int) ($response->gross_amount ?? $donation->amount),
            'qr_string'       => $response->qr_string ?? null,
            'qr_code_url'     => $qrCodeUrl,
            'expired_at'      => now()->addMinutes($expiredMinutes),
        ];
    }

    public function buildQrImageUrl(string $qrString): string
    {
        $query = http_build_query([
            'size'  => '500x500',
            'style' => '2',
            'color' => '2563eb',
            'data'  => $qrString,
        ]);

        return 'https://larabert-qrgen.hf.space/v1/create-qr-code?' . $query;
    }
}
