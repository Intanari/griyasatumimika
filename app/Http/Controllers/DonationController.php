<?php

namespace App\Http\Controllers;

use App\Mail\DonationThankYou;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\CoreApi;
use Midtrans\Notification;

class DonationController extends Controller
{
    public function __construct()
    {
        Config::$serverKey    = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production', false);
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
    }

    private array $programs = [
        'rawat-inap'       => 'Biaya Rawat Inap & Obat ODGJ',
        'pelatihan-vokasi' => 'Pelatihan Vokasi Pasca-Rehabilitasi',
        'rumah-singgah'    => 'Rumah Singgah ODGJ Terlantar',
        'umum'             => 'Donasi Umum PeduliJiwa',
    ];

    public function showForm(Request $request)
    {
        $program      = $request->query('program', 'umum');
        $programLabel = $this->programs[$program] ?? 'Donasi Umum PeduliJiwa';

        return view('donation.form', [
            'program'      => $program,
            'programLabel' => $programLabel,
            'programs'     => $this->programs,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'program'     => 'required|string|max:100',
            'donor_name'  => 'required|string|max:100',
            'donor_email' => 'required|email|max:150',
            'donor_phone' => 'required|string|max:20',
            'amount'      => 'required|integer|min:10000',
            'message'     => 'nullable|string|max:500',
        ], [
            'donor_name.required'  => 'Nama lengkap wajib diisi.',
            'donor_email.required' => 'Alamat email wajib diisi.',
            'donor_email.email'    => 'Format email tidak valid.',
            'donor_phone.required' => 'Nomor telepon wajib diisi.',
            'amount.required'      => 'Jumlah donasi wajib diisi.',
            'amount.min'           => 'Jumlah donasi minimal Rp 10.000.',
        ]);

        $donation = Donation::create([
            'program'     => $validated['program'],
            'donor_name'  => $validated['donor_name'],
            'donor_email' => $validated['donor_email'],
            'donor_phone' => $validated['donor_phone'],
            'amount'      => (int) $validated['amount'],
            'message'     => $validated['message'] ?? null,
            'order_id'    => 'PJ-' . strtoupper(Str::random(8)) . '-' . time(),
            'status'      => 'pending',
        ]);

        try {
            $params = [
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
                    'name'     => $this->programs[$donation->program] ?? 'Donasi PeduliJiwa',
                ]],
                'qris' => ['acquirer' => 'gopay'],
            ];

            $response = CoreApi::charge($params);

            $donation->update([
                'transaction_id' => $response->transaction_id ?? null,
                'qr_code_url'    => $response->actions[0]->url ?? null,
                'qr_string'      => $response->qr_string ?? null,
            ]);
        } catch (\Exception $e) {
            $donation->update([
                'transaction_id' => 'DEMO-' . $donation->order_id,
            ]);
        }

        return redirect()->route('donation.payment', $donation->id);
    }

    public function showPayment(Donation $donation)
    {
        if ($donation->status === 'paid') {
            return redirect()->route('donation.success', $donation->id);
        }

        return view('donation.payment', compact('donation'));
    }

    public function checkStatus(Donation $donation)
    {
        if (!config('services.midtrans.server_key')) {
            return response()->json(['status' => $donation->status]);
        }

        try {
            $status = \Midtrans\Transaction::status($donation->order_id);

            if (in_array($status->transaction_status, ['settlement', 'capture'])) {
                $alreadyPaid = $donation->status === 'paid';
                $donation->update([
                    'status'  => 'paid',
                    'paid_at' => now(),
                ]);

                // Send thank-you email only once
                if (!$alreadyPaid) {
                    $this->sendThankYouEmail($donation->fresh());
                }
            } elseif (in_array($status->transaction_status, ['cancel', 'deny', 'expire'])) {
                $donation->update(['status' => 'failed']);
            }
        } catch (\Exception $e) {
            // Silently ignore errors from Midtrans status check
        }

        return response()->json(['status' => $donation->status]);
    }

    public function callback(Request $request)
    {
        try {
            $notification  = new Notification();
            $orderId       = $notification->order_id;
            $txStatus      = $notification->transaction_status;
            $fraudStatus   = $notification->fraud_status;

            $donation = Donation::where('order_id', $orderId)->first();
            if (!$donation) {
                return response()->json(['message' => 'Not found'], 404);
            }

            if (in_array($txStatus, ['settlement', 'capture'])
                && ($fraudStatus === 'accept' || $fraudStatus === null))
            {
                $alreadyPaid = $donation->status === 'paid';
                $donation->update([
                    'status'  => 'paid',
                    'paid_at' => now(),
                ]);

                if (!$alreadyPaid) {
                    $this->sendThankYouEmail($donation->fresh());
                }
            } elseif (in_array($txStatus, ['cancel', 'deny', 'expire'])) {
                $donation->update(['status' => 'failed']);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'OK']);
    }

    public function success(Donation $donation)
    {
        return view('donation.success', compact('donation'));
    }

    private function sendThankYouEmail(Donation $donation): void
    {
        try {
            Mail::to($donation->donor_email, $donation->donor_name)
                ->send(new DonationThankYou($donation));
        } catch (\Exception $e) {
            // Log silently — don't break the payment flow
            \Illuminate\Support\Facades\Log::error('Failed to send donation thank-you email: ' . $e->getMessage());
        }
    }
}
