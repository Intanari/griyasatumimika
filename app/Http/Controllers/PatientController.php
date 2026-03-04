<?php

namespace App\Http\Controllers;

use App\Mail\PatientDataNotificationToPetugas;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Patient::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('tempat_lahir', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        $patients = $query->orderByDesc('tanggal_masuk')->paginate(15)->withQueryString();

        if ($request->filled('search') || $request->filled('status') || $request->filled('jenis_kelamin')) {
            $request->session()->flash('info', 'Menampilkan hasil pencarian/filter.');
        }

        return view('dashboard.patients.index', compact('user', 'patients'));
    }

    public function create()
    {
        $user = Auth::user();
        return view('dashboard.patients.create', compact('user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap'   => 'required|string|max:255',
            'tempat_lahir'   => 'nullable|string|max:100',
            'tanggal_lahir'  => 'nullable|date',
            'jenis_kelamin'  => 'nullable|in:L,P',
            'tanggal_masuk'  => 'required|date',
            'status'         => 'required|in:aktif,selesai,dirujuk',
            'foto'           => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('patients', 'public');
        }

        $patient = Patient::create($validated);
        $this->sendPatientNotificationToPetugas($patient, 'created');

        return redirect()->route('dashboard.patients.index')
            ->with('success', "Pasien {$validated['nama_lengkap']} berhasil ditambahkan.");
    }

    public function show(Patient $patient)
    {
        $user = Auth::user();
        return view('dashboard.patients.show', compact('user', 'patient'));
    }

    public function edit(Patient $patient)
    {
        $user = Auth::user();
        return view('dashboard.patients.edit', compact('user', 'patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'nama_lengkap'   => 'required|string|max:255',
            'tempat_lahir'   => 'nullable|string|max:100',
            'tanggal_lahir'  => 'nullable|date',
            'jenis_kelamin'  => 'nullable|in:L,P',
            'tanggal_masuk'  => 'required|date',
            'status'         => 'required|in:aktif,selesai,dirujuk',
            'foto'           => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($patient->foto) {
                Storage::disk('public')->delete($patient->foto);
            }
            $validated['foto'] = $request->file('foto')->store('patients', 'public');
        }

        $patient->update($validated);
        $this->sendPatientNotificationToPetugas($patient, 'updated');

        return redirect()->route('dashboard.patients.index')
            ->with('success', "Data pasien {$validated['nama_lengkap']} berhasil diperbarui.");
    }

    public function destroy(Patient $patient)
    {
        $nama = $patient->nama_lengkap;
        if ($patient->foto) {
            Storage::disk('public')->delete($patient->foto);
        }
        $this->sendPatientNotificationToPetugas($patient, 'deleted');
        $patient->delete();

        return redirect()->route('dashboard.patients.index')
            ->with('success', "Pasien {$nama} berhasil dihapus.");
    }

    private function sendPatientNotificationToPetugas(Patient $patient, string $action): void
    {
        try {
            $petugas = User::where('role', 'petugas_rehabilitasi')
                ->where('is_active', true)
                ->whereNotNull('email')
                ->where('email', '!=', '')
                ->pluck('email')
                ->toArray();

            if (!empty($petugas)) {
                Mail::to($petugas)->send(new PatientDataNotificationToPetugas($patient, $action));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal mengirim notifikasi data pasien ke petugas: ' . $e->getMessage());
        }
    }
}
