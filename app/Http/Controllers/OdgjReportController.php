<?php

namespace App\Http\Controllers;

use App\Mail\OdgjReportNotification;
use App\Mail\OdgjReportThankYouToWarga;
use App\Models\OdgjReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OdgjReportController extends Controller
{
    public function showForm()
    {
        return view('public.odgj-report.form');
    }

    public function success(OdgjReport $report)
    {
        return view('public.odgj-report.success', compact('report'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori'   => 'required|in:penjemputan,pengantaran',
            'lokasi'     => 'required|string|max:500',
            'lokasi_lat' => 'nullable|numeric|between:-90,90',
            'lokasi_lng' => 'nullable|numeric|between:-180,180',
            'deskripsi'  => 'required|string|max:2000',
            'gambar'     => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'email'      => 'required|email|max:255',
            'kontak'     => 'required|string|max:50',
        ], [
            'kategori.required' => 'Pilih kategori laporan (Penjemputan atau Pengantaran).',
            'kategori.in'       => 'Kategori tidak valid.',
            'lokasi.required'   => 'Alamat / lokasi wajib diisi.',
            'deskripsi.required'=> 'Deskripsi kejadian wajib diisi.',
            'gambar.required'   => 'Upload foto wajib.',
            'gambar.image'      => 'File harus berupa gambar.',
            'gambar.max'        => 'Ukuran gambar maksimal 5 MB.',
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'kontak.required'   => 'Nomor HP / WhatsApp wajib diisi.',
        ]);

        $nomorLaporan = 'ODGJ-' . strtoupper(Str::random(6)) . '-' . now()->format('Ymd');

        $gambarPath = $request->file('gambar')->store('odgj-reports', 'public');

        $report = OdgjReport::create([
            'kategori'       => $validated['kategori'],
            'lokasi'         => $validated['lokasi'],
            'lokasi_lat'     => $validated['lokasi_lat'] ?? null,
            'lokasi_lng'     => $validated['lokasi_lng'] ?? null,
            'deskripsi'      => $validated['deskripsi'],
            'gambar'         => $gambarPath,
            'email'          => $validated['email'],
            'kontak'         => $validated['kontak'],
            'nomor_laporan'  => $nomorLaporan,
        ]);

        $this->sendNotificationToPetugas($report);
        $this->sendThankYouToWarga($report);

        return redirect()->route('odgj-report.success', $report);
    }

    private function sendNotificationToPetugas(OdgjReport $report): void
    {
        try {
            $petugas = User::where('role', 'petugas_rehabilitasi')
                ->where('is_active', true)
                ->pluck('email')
                ->toArray();

            if (!empty($petugas)) {
                Mail::to($petugas)->send(new OdgjReportNotification($report));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal mengirim notifikasi laporan ODGJ: ' . $e->getMessage());
        }
    }

    private function sendThankYouToWarga(OdgjReport $report): void
    {
        if (empty($report->email)) {
            return;
        }
        try {
            Mail::to($report->email)->send(new OdgjReportThankYouToWarga($report));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal mengirim email terima kasih ke warga: ' . $e->getMessage());
        }
    }
}
