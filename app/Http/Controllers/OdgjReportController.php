<?php

namespace App\Http\Controllers;

use App\Mail\OdgjReportNotification;
use App\Models\OdgjReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OdgjReportController extends Controller
{
    public function showForm()
    {
        return view('odgj-report.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori'   => 'required|in:penjemputan,pengantaran',
            'lokasi'     => 'nullable|string|max:500',
            'lokasi_lat' => 'nullable|numeric|between:-90,90',
            'lokasi_lng' => 'nullable|numeric|between:-180,180',
            'deskripsi'  => 'nullable|string|max:2000',
            'gambar'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'kontak'     => 'required|string|max:50',
        ], [
            'kategori.required' => 'Pilih kategori laporan (Penjemputan atau Pengantaran).',
            'kategori.in'       => 'Kategori tidak valid.',
            'kontak.required'    => 'Nomor kontak wajib diisi.',
            'gambar.image'      => 'File harus berupa gambar.',
            'gambar.max'        => 'Ukuran gambar maksimal 5 MB.',
        ]);

        $nomorLaporan = 'ODGJ-' . strtoupper(Str::random(6)) . '-' . now()->format('Ymd');

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('odgj-reports', 'public');
        }

        $report = OdgjReport::create([
            'kategori'       => $validated['kategori'],
            'lokasi'         => $validated['lokasi'] ?? null,
            'lokasi_lat'     => $validated['lokasi_lat'] ?? null,
            'lokasi_lng'     => $validated['lokasi_lng'] ?? null,
            'deskripsi'      => $validated['deskripsi'] ?? null,
            'gambar'         => $gambarPath,
            'kontak'         => $validated['kontak'],
            'nomor_laporan'  => $nomorLaporan,
        ]);

        $this->sendNotificationToPetugas($report);

        return redirect()
            ->route('odgj-report.form')
            ->with('success', "Laporan ODGJ berhasil dikirim. Nomor laporan: {$nomorLaporan}. Petugas akan segera menghubungi Anda.");
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
}
