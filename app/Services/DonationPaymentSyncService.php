<?php

namespace App\Services;

use App\Mail\DonationThankYou;
use App\Models\Donation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class DonationPaymentSyncService
{
    public function __construct(
        private MidtransService $midtrans,
    ) {}

    /**
     * @return array{updated: bool, gateway_status: string|null, data: object|null}
     */
    public function syncDonation(Donation $donation): array
    {
        if ($donation->status === 'paid' || ! $donation->order_id) {
            return ['updated' => false, 'gateway_status' => $donation->status, 'data' => null];
        }

        if (str_starts_with((string) $donation->transaction_id, 'DEMO-')) {
            return ['updated' => false, 'gateway_status' => $donation->status, 'data' => null];
        }

        if (! $this->midtrans->isConfigured()) {
            return ['updated' => false, 'gateway_status' => null, 'data' => null];
        }

        try {
            $status = $this->midtrans->getStatus($donation->order_id);
            $txStatus = (string) ($status->transaction_status ?? 'pending');
            $fraudStatus = $status->fraud_status ?? null;
            $normalized = $this->midtrans->normalizeStatus($txStatus, $fraudStatus);

            if ($normalized === 'paid') {
                return [
                    'updated'        => $this->markAsPaid($donation),
                    'gateway_status' => $txStatus,
                    'data'           => $status,
                ];
            }

            if ($normalized === 'expired') {
                $donation->update(['status' => 'expired']);

                return ['updated' => true, 'gateway_status' => $txStatus, 'data' => $status];
            }

            if ($normalized === 'failed') {
                $donation->update(['status' => 'failed']);

                return ['updated' => true, 'gateway_status' => $txStatus, 'data' => $status];
            }

            return ['updated' => false, 'gateway_status' => $txStatus, 'data' => $status];
        } catch (\Exception $e) {
            Log::warning('Midtrans sync gagal: ' . $e->getMessage(), [
                'donation_id' => $donation->id,
                'order_id'    => $donation->order_id,
            ]);

            return ['updated' => false, 'gateway_status' => null, 'data' => null];
        }
    }

    /**
     * @return array{handled: bool, message?: string, status?: int}
     */
    public function processCallback(string $orderId, string $transactionStatus, ?string $fraudStatus): array
    {
        $donation = Donation::query()
            ->where('order_id', $orderId)
            ->where('payment_gateway', 'midtrans')
            ->first();

        if (! $donation) {
            return [
                'handled' => false,
                'message' => 'Donasi tidak ditemukan untuk order: ' . $orderId,
                'status'  => 404,
            ];
        }

        if ($donation->status === 'paid') {
            return ['handled' => true];
        }

        $normalized = $this->midtrans->normalizeStatus($transactionStatus, $fraudStatus);

        if ($normalized === 'paid') {
            $this->markAsPaid($donation);

            return ['handled' => true];
        }

        if ($normalized === 'expired') {
            $donation->update(['status' => 'expired']);

            return ['handled' => true];
        }

        if ($normalized === 'failed') {
            $donation->update(['status' => 'failed']);

            return ['handled' => true];
        }

        return ['handled' => true];
    }

    public function syncAllPending(): int
    {
        $updated = 0;

        Donation::query()
            ->where('status', 'pending')
            ->where('payment_gateway', 'midtrans')
            ->whereNotNull('order_id')
            ->where(function ($query) {
                $query->whereNull('transaction_id')
                    ->orWhere('transaction_id', 'not like', 'DEMO-%');
            })
            ->orderBy('created_at')
            ->each(function (Donation $donation) use (&$updated) {
                $result = $this->syncDonation($donation);
                if ($result['updated']) {
                    $updated++;
                }
            });

        return $updated;
    }

    public function markAsPaid(Donation $donation): bool
    {
        if ($donation->status === 'paid') {
            return false;
        }

        $donation->update([
            'status'  => 'paid',
            'paid_at' => now(),
        ]);

        $this->sendThankYouEmail($donation->fresh());

        return true;
    }

    public function markPaidByAmount(int $amount): ?Donation
    {
        $donation = Donation::query()
            ->where('status', 'pending')
            ->where(function ($query) use ($amount) {
                $query->where('total_amount', $amount)
                    ->orWhere('amount', $amount);
            })
            ->orderByDesc('created_at')
            ->first();

        if (! $donation) {
            return null;
        }

        $this->markAsPaid($donation);

        return $donation->fresh();
    }

    private function sendThankYouEmail(Donation $donation): void
    {
        try {
            Mail::to($donation->donor_email, $donation->donor_name)
                ->send(new DonationThankYou($donation));
        } catch (\Exception $e) {
            Log::error('Failed to send donation thank-you email: ' . $e->getMessage());
        }
    }
}
