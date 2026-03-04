<?php

namespace App\Http\Controllers;

use App\Mail\ExaminationHistoryNotificationToPetugas;
use App\Models\ExaminationHistory;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ExaminationHistoryController extends Controller
{
    public function index(Request $request)
    {
        $user  = Auth::user();
        $query = ExaminationHistory::with('patient');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_pemeriksaan', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_pemeriksaan', '<=', $request->tanggal_sampai);
        }

        $histories = $query->orderByDesc('tanggal_pemeriksaan')->paginate(15)->withQueryString();

        return view('dashboard.riwayat-pemeriksaan.index', compact('user', 'histories'));
    }

    public function create()
    {
        $user     = Auth::user();
        $patients = Patient::orderBy('nama_lengkap')->get();
        return view('dashboard.riwayat-pemeriksaan.create', compact('user', 'patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id'          => 'required|exists:patients,id',
            'tanggal_pemeriksaan' => 'required|date',
            'tempat_pemeriksaan'  => 'required|string|max:255',
            'keluhan'             => 'nullable|string',
            'hasil_pemeriksaan'   => 'nullable|string',
            'tindakan_obat'       => 'nullable|string',
        ]);

        $examination = ExaminationHistory::create($validated);
        $examination->load('patient');

        $this->sendNotificationToPetugas($examination, 'created');

        return redirect()->route('dashboard.riwayat-pemeriksaan.index')
            ->with('success', 'Riwayat pemeriksaan berhasil ditambahkan.');
    }

    public function show(ExaminationHistory $riwayat_pemeriksaan)
    {
        $user = Auth::user();
        $riwayat_pemeriksaan->load('patient');
        $examination_history = $riwayat_pemeriksaan;
        return view('dashboard.riwayat-pemeriksaan.show', compact('user', 'examination_history'));
    }

    public function edit(ExaminationHistory $riwayat_pemeriksaan)
    {
        $user     = Auth::user();
        $patients = Patient::orderBy('nama_lengkap')->get();
        $riwayat_pemeriksaan->load('patient');
        $examination_history = $riwayat_pemeriksaan;
        return view('dashboard.riwayat-pemeriksaan.edit', compact('user', 'examination_history', 'patients'));
    }

    public function update(Request $request, ExaminationHistory $riwayat_pemeriksaan)
    {
        $validated = $request->validate([
            'patient_id'          => 'required|exists:patients,id',
            'tanggal_pemeriksaan' => 'required|date',
            'tempat_pemeriksaan'  => 'required|string|max:255',
            'keluhan'             => 'nullable|string',
            'hasil_pemeriksaan'   => 'nullable|string',
            'tindakan_obat'       => 'nullable|string',
        ]);

        $riwayat_pemeriksaan->update($validated);
        $riwayat_pemeriksaan->load('patient');

        $this->sendNotificationToPetugas($riwayat_pemeriksaan, 'updated');

        return redirect()->route('dashboard.riwayat-pemeriksaan.index')
            ->with('success', 'Riwayat pemeriksaan berhasil diperbarui.');
    }

    public function destroy(ExaminationHistory $riwayat_pemeriksaan)
    {
        $riwayat_pemeriksaan->load('patient');
        $this->sendNotificationToPetugas($riwayat_pemeriksaan, 'deleted');
        $riwayat_pemeriksaan->delete();

        return redirect()->route('dashboard.riwayat-pemeriksaan.index')
            ->with('success', 'Riwayat pemeriksaan berhasil dihapus.');
    }

    private function sendNotificationToPetugas(ExaminationHistory $examination, string $action): void
    {
        try {
            $petugas = User::where('role', 'petugas_rehabilitasi')
                ->where('is_active', true)
                ->whereNotNull('email')
                ->where('email', '!=', '')
                ->pluck('email')
                ->toArray();

            if (!empty($petugas)) {
                Mail::to($petugas)->send(new ExaminationHistoryNotificationToPetugas($examination, $action));
            }
        } catch (\Exception $e) {
            Log::error('Gagal mengirim notifikasi riwayat pemeriksaan ke petugas: ' . $e->getMessage());
        }
    }
}
