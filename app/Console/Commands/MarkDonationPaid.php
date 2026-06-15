<?php

namespace App\Console\Commands;

use App\Models\Donation;
use App\Services\DonationPaymentSyncService;
use Illuminate\Console\Command;

class MarkDonationPaid extends Command
{
    protected $signature = 'donations:mark-paid
                            {reference : order_id, transaction_id, atau UUID donasi}
                            {--amount= : Cocokkan donasi pending berdasarkan nominal (mis. 1002)}';

    protected $description = 'Tandai donasi lunas secara manual dari terminal server';

    public function handle(DonationPaymentSyncService $sync): int
    {
        if ($amount = $this->option('amount')) {
            $donation = $sync->markPaidByAmount((int) $amount);

            if (! $donation) {
                $this->error("Tidak ada donasi pending dengan nominal Rp " . number_format((int) $amount, 0, ',', '.'));

                return self::FAILURE;
            }

            $this->info("Donasi {$donation->order_id} ditandai lunas (Rp " . number_format($donation->payable_amount, 0, ',', '.') . ').');

            return self::SUCCESS;
        }

        $reference = $this->argument('reference');

        $donation = Donation::query()
            ->where('id', $reference)
            ->orWhere('order_id', $reference)
            ->orWhere('transaction_id', $reference)
            ->first();

        if (! $donation) {
            $this->error('Donasi tidak ditemukan.');

            return self::FAILURE;
        }

        if ($donation->status === 'paid') {
            $this->warn("Donasi {$donation->order_id} sudah lunas sebelumnya.");

            return self::SUCCESS;
        }

        $sync->markAsPaid($donation);
        $this->info("Donasi {$donation->order_id} ditandai lunas.");

        return self::SUCCESS;
    }
}
