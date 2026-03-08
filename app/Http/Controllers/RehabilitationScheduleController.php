<?php

namespace App\Http\Controllers;

use App\Mail\RehabilitationScheduleNotificationToPetugas;
use App\Models\RehabilitationSchedule;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RehabilitationScheduleController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $viewMode = $request->get('view', 'table');

        $baseQuery = RehabilitationSchedule::with('pembimbingUser');
        if ($request->filled('hari')) {
            $baseQuery->where('hari', $request->hari);
        }
        if ($request->filled('is_aktif')) {
            $baseQuery->where('is_aktif', $request->boolean('is_aktif'));
        }

        $hariOrder = "CASE hari WHEN 'senin' THEN 1 WHEN 'selasa' THEN 2 WHEN 'rabu' THEN 3 WHEN 'kamis' THEN 4 WHEN 'jumat' THEN 5 WHEN 'sabtu' THEN 6 WHEN 'minggu' THEN 7 ELSE 9 END";

        $jadwals = (clone $baseQuery)
            ->orderByRaw($hariOrder)
            ->orderBy('jam_mulai')
            ->paginate(15)
            ->withQueryString();

        $jadwalsForCalendar = (clone $baseQuery)
            ->where('is_aktif', true)
            ->orderByRaw($hariOrder)
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        $stats = [
            'total' => RehabilitationSchedule::count(),
            'aktif' => RehabilitationSchedule::where('is_aktif', true)->count(),
            'nonaktif' => RehabilitationSchedule::where('is_aktif', false)->count(),
            'hari_terisi' => RehabilitationSchedule::where('is_aktif', true)->distinct('hari')->count('hari'),
        ];

        return view('dashboard.jadwal-rehabilitasi.index', compact(
            'user', 'jadwals', 'jadwalsForCalendar', 'stats', 'viewMode'
        ));
    }

    public function exportPdf(Request $request)
    {
        $query = RehabilitationSchedule::with('pembimbingUser')->where('is_aktif', true);

        if ($request->filled('hari')) {
            $query->where('hari', $request->hari);
        }

        $hariOrder = "CASE hari WHEN 'senin' THEN 1 WHEN 'selasa' THEN 2 WHEN 'rabu' THEN 3 WHEN 'kamis' THEN 4 WHEN 'jumat' THEN 5 WHEN 'sabtu' THEN 6 WHEN 'minggu' THEN 7 ELSE 9 END";

        $jadwals = $query
            ->orderByRaw($hariOrder)
            ->orderBy('jam_mulai')
            ->get();

        $byHari = [];
        foreach (RehabilitationSchedule::HARI_LIST as $key => $label) {
            $byHari[$key] = $jadwals->where('hari', $key)->values();
        }

        $filename = 'jadwal-rehabilitasi-mingguan-' . now()->format('Y-m-d') . '.pdf';

        $pdf = Pdf::loadView('dashboard.jadwal-rehabilitasi.export-pdf', compact('jadwals', 'byHari'))
            ->setPaper('a4', 'landscape');

        return $pdf->download($filename);
    }

    public function create()
    {
        $user = Auth::user();
        $petugas = User::where('role', User::ROLE_PETUGAS)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('dashboard.jadwal-rehabilitasi.create', compact('user', 'petugas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'hari' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i',
            'tempat' => 'nullable|string|max:255',
            'pembimbing_id' => 'nullable|exists:users,id',
            'deskripsi' => 'nullable|string',
            'is_aktif' => 'nullable|boolean',
        ]);

        if (!empty($validated['jam_selesai']) && $validated['jam_selesai'] <= $validated['jam_mulai']) {
            return redirect()->back()->withInput()->withErrors(['jam_selesai' => 'Jam selesai harus setelah jam mulai.']);
        }

        $validated['is_aktif'] = $request->boolean('is_aktif', true);

        $schedule = RehabilitationSchedule::create($validated);
        $schedule->load('pembimbingUser');
        $this->sendScheduleNotificationToPetugas($schedule, 'created');

        return redirect()->route('dashboard.jadwal-rehabilitasi.index')
            ->with('success', 'Jadwal rehabilitasi berhasil dibuat. Notifikasi telah dikirim ke email petugas.');
    }

    public function edit(RehabilitationSchedule $jadwal_rehabilitasi)
    {
        $user = Auth::user();
        $jadwal = $jadwal_rehabilitasi;
        $petugas = User::where('role', User::ROLE_PETUGAS)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('dashboard.jadwal-rehabilitasi.edit', compact('user', 'jadwal', 'petugas'));
    }

    public function update(Request $request, RehabilitationSchedule $jadwal_rehabilitasi)
    {
        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'hari' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i',
            'tempat' => 'nullable|string|max:255',
            'pembimbing_id' => 'nullable|exists:users,id',
            'deskripsi' => 'nullable|string',
            'is_aktif' => 'nullable|boolean',
        ]);

        if (!empty($validated['jam_selesai']) && $validated['jam_selesai'] <= $validated['jam_mulai']) {
            return redirect()->back()->withInput()->withErrors(['jam_selesai' => 'Jam selesai harus setelah jam mulai.']);
        }

        $validated['is_aktif'] = $request->boolean('is_aktif', true);

        $jadwal_rehabilitasi->update($validated);
        $jadwal_rehabilitasi->load('pembimbingUser');
        $this->sendScheduleNotificationToPetugas($jadwal_rehabilitasi, 'updated');

        return redirect()->route('dashboard.jadwal-rehabilitasi.index')
            ->with('success', 'Jadwal rehabilitasi berhasil diperbarui. Notifikasi telah dikirim ke email petugas.');
    }

    public function destroy(RehabilitationSchedule $jadwal_rehabilitasi)
    {
        $jadwal_rehabilitasi->load('pembimbingUser');
        $this->sendScheduleNotificationToPetugas($jadwal_rehabilitasi, 'deleted');
        $jadwal_rehabilitasi->delete();

        return redirect()->route('dashboard.jadwal-rehabilitasi.index')
            ->with('success', 'Jadwal rehabilitasi berhasil dihapus. Notifikasi telah dikirim ke email petugas.');
    }

    private function sendScheduleNotificationToPetugas(RehabilitationSchedule $schedule, string $action): void
    {
        try {
            $petugas = User::where('role', User::ROLE_PETUGAS)
                ->where('is_active', true)
                ->whereNotNull('email')
                ->where('email', '!=', '')
                ->pluck('email')
                ->toArray();

            if (!empty($petugas)) {
                Mail::to($petugas)->send(new RehabilitationScheduleNotificationToPetugas($schedule, $action));
            }
        } catch (\Exception $e) {
            Log::error('Gagal mengirim notifikasi jadwal rehabilitasi ke petugas: ' . $e->getMessage());
        }
    }
}
