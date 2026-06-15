<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Services\DonationPaymentSyncService;
use App\Services\DonationQrisCardService;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class DonationController extends Controller
{
    public function __construct(
        private MidtransService $midtrans,
        private DonationPaymentSyncService $paymentSync,
    ) {}

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

        return view('public.donation.form', [
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
            'amount'      => 'required|integer|min:1000',
            'message'     => 'nullable|string|max:500',
        ], [
            'donor_name.required'  => 'Nama lengkap wajib diisi.',
            'donor_email.required' => 'Alamat email wajib diisi.',
            'donor_email.email'    => 'Format email tidak valid.',
            'donor_phone.required' => 'Nomor telepon wajib diisi.',
            'amount.required'      => 'Jumlah donasi wajib diisi.',
            'amount.min'           => 'Jumlah donasi minimal Rp 1.000.',
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

        $this->initializePayment($donation);

        return redirect()->route('donation.payment', $donation->id);
    }

    public function showPayment(Donation $donation)
    {
        if ($donation->status === 'paid') {
            return redirect()->route('donation.success', $donation->id);
        }

        if (! $donation->transaction_id && ! $donation->qr_string) {
            $this->initializePayment($donation);
            $donation = $donation->fresh();
        }

        return view('public.donation.payment', [
            'donation'   => $donation,
            'qrImageUrl' => $this->qrImageUrl($donation),
        ]);
    }

    public function checkStatus(Request $request, Donation $donation)
    {
        $gatewayStatus = null;

        if ($request->boolean('sync')
            && $donation->order_id
            && ! str_starts_with((string) $donation->transaction_id, 'DEMO-')) {
            $result = $this->paymentSync->syncDonation($donation);
            $gatewayStatus = $result['gateway_status'];
        }

        $donation = $donation->fresh();

        return response()
            ->json([
                'status'          => $donation->status,
                'gateway_status'  => $gatewayStatus ?? $donation->status,
                'payment_gateway' => $donation->payment_gateway,
                'transaction_id'  => $donation->transaction_id,
                'total_amount'    => $donation->payable_amount,
                'expired_at'      => $donation->expired_at?->toIso8601String(),
            ])
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate');
    }

    public function callback(Request $request)
    {
        try {
            $notification = $this->midtrans->parseNotification();

            $result = $this->paymentSync->processCallback(
                (string) $notification->order_id,
                (string) $notification->transaction_status,
                $notification->fraud_status ?? null,
            );

            if (! $result['handled']) {
                return response()->json(['message' => $result['message'] ?? 'Gagal'], $result['status'] ?? 422);
            }
        } catch (\Exception $e) {
            Log::error('Midtrans callback gagal: ' . $e->getMessage());

            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'OK']);
    }

    public function success(Donation $donation)
    {
        return view('public.donation.success', compact('donation'));
    }

    public function downloadQr(Donation $donation, DonationQrisCardService $qrisCard): Response
    {
        $url = $this->qrImageUrl($donation);

        if (! $url) {
            abort(404, 'QR Code belum tersedia.');
        }

        $response = Http::timeout(20)->get($url);

        if (! $response->successful()) {
            abort(502, 'Gagal mengambil gambar QR Code.');
        }

        $programLabel = $this->programs[$donation->program] ?? 'Donasi Griya Satu Mimika';

        try {
            $png = $qrisCard->generate($donation, $response->body(), $programLabel);
        } catch (\Exception $e) {
            Log::error('Gagal membuat kartu QRIS: ' . $e->getMessage(), [
                'donation_id' => $donation->id,
            ]);

            abort(502, 'Gagal membuat gambar pembayaran QRIS.');
        }

        $filename = $qrisCard->buildFilename($donation);

        return response($png, 200, [
            'Content-Type'        => 'image/png',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    private function qrImageUrl(Donation $donation): ?string
    {
        if ($donation->qr_code_url) {
            return $donation->qr_code_url;
        }

        if ($donation->qr_string) {
            return $this->midtrans->buildQrImageUrl($donation->qr_string);
        }

        return null;
    }

    private function initializePayment(Donation $donation): void
    {
        if (! $this->midtrans->isConfigured()) {
            Log::warning('Midtrans belum dikonfigurasi, donasi tanpa QR', [
                'donation_id' => $donation->id,
                'order_id'    => $donation->order_id,
            ]);

            return;
        }

        try {
            $programLabel = $this->programs[$donation->program] ?? 'Donasi Griya Satu Mimika';
            $response = $this->midtrans->chargeQris($donation, $programLabel);

            $donation->update($this->midtrans->mapChargeResponse($response, $donation));
        } catch (\Exception $e) {
            Log::error('Midtrans charge QRIS gagal: ' . $e->getMessage(), [
                'donation_id' => $donation->id,
                'order_id'    => $donation->order_id,
            ]);
        }
    }
}
