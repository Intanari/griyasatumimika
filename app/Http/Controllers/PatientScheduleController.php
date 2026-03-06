<?php

namespace App\Http\Controllers;

use App\Mail\PatientScheduleNotificationToPetugas;
use App\Models\Patient;
use App\Models\PatientSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PatientScheduleController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = PatientSchedule::with('patient');

        if ($request->filled('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        $jadwals = $query->orderBy('tanggal')->orderBy('jam_mulai')->paginate(15)->withQueryString();
        $patients = Patient::orderBy('nama_lengkap')->get();

        return view('dashboard.jadwal-pasien.index', compact('user', 'jadwals', 'patients'));
    }

    public function create()
    {
        $user = Auth::user();
        $patients = Patient::orderBy('nama_lengkap')->get();
        return view('dashboard.jadwal-pasien.create', compact('user', 'patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id'    => 'required|exists:patients,id',
            'tanggal'       => 'required|date',
            'jam_mulai'     => 'nullable|date_format:H:i',
            'jam_selesai'   => 'nullable|date_format:H:i',
            'tempat'        => 'nullable|string|max:255',
            'jenis'         => 'required|string|max:50',
            'status'        => 'required|string|max:30',
            'catatan'       => 'nullable|string',
        ]);

        if (!empty($validated['jam_mulai']) && !empty($validated['jam_selesai']) && $validated['jam_selesai'] < $validated['jam_mulai']) {
            return redirect()->back()->withInput()->withErrors(['jam_selesai' => 'Jam selesai harus setelah jam mulai.']);
        }

        $data = array_merge($validated, [
            'jenis_kegiatan' => $validated['jenis'],
            'lokasi'         => $validated['tempat'] ?? '',
            'pembimbing'     => '',
        ]);

        $schedule = PatientSchedule::create($data);
        $schedule->load('patient');
        $this->sendScheduleNotificationToPetugas($schedule, 'created');

        return redirect()->route('dashboard.jadwal-pasien.index')
            ->with('success', 'Jadwal pasien berhasil dibuat.');
    }

    public function edit(PatientSchedule $jadwal_pasien)
    {
        $user = Auth::user();
        $patients = Patient::orderBy('nama_lengkap')->get();
        $schedule = $jadwal_pasien;
        return view('dashboard.jadwal-pasien.edit', compact('user', 'schedule', 'patients'));
    }

    public function update(Request $request, PatientSchedule $jadwal_pasien)
    {
        $validated = $request->validate([
            'patient_id'    => 'required|exists:patients,id',
            'tanggal'       => 'required|date',
            'jam_mulai'     => 'nullable|date_format:H:i',
            'jam_selesai'   => 'nullable|date_format:H:i',
            'tempat'        => 'nullable|string|max:255',
            'jenis'         => 'required|string|max:50',
            'status'        => 'required|string|max:30',
            'catatan'       => 'nullable|string',
        ]);

        if (!empty($validated['jam_mulai']) && !empty($validated['jam_selesai']) && $validated['jam_selesai'] < $validated['jam_mulai']) {
            return redirect()->back()->withInput()->withErrors(['jam_selesai' => 'Jam selesai harus setelah jam mulai.']);
        }

        $data = array_merge($validated, [
            'jenis_kegiatan' => $validated['jenis'],
            'lokasi'         => $validated['tempat'] ?? '',
            'pembimbing'     => '',
        ]);

        $jadwal_pasien->update($data);
        $jadwal_pasien->load('patient');
        $this->sendScheduleNotificationToPetugas($jadwal_pasien, 'updated');

        return redirect()->route('dashboard.jadwal-pasien.index')
            ->with('success', 'Jadwal pasien berhasil diperbarui.');
    }

    public function destroy(PatientSchedule $jadwal_pasien)
    {
        $jadwal_pasien->load('patient');
        $this->sendScheduleNotificationToPetugas($jadwal_pasien, 'deleted');
        $jadwal_pasien->delete();

        return redirect()->route('dashboard.jadwal-pasien.index')
            ->with('success', 'Jadwal pasien berhasil dihapus.');
    }

    private function sendScheduleNotificationToPetugas(PatientSchedule $schedule, string $action): void
    {
        try {
            $petugas = User::where('role', 'petugas_rehabilitasi')
                ->where('is_active', true)
                ->whereNotNull('email')
                ->where('email', '!=', '')
                ->pluck('email')
                ->toArray();

            if (!empty($petugas)) {
                Mail::to($petugas)->send(new PatientScheduleNotificationToPetugas($schedule, $action));
            }
        } catch (\Exception $e) {
            Log::error('Gagal mengirim notifikasi jadwal pasien ke petugas: ' . $e->getMessage());
        }
    }
}

