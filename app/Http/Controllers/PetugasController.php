<?php

namespace App\Http\Controllers;

use App\Mail\PetugasDataNotificationToPetugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PetugasController extends Controller
{
    public function index(Request $request)
    {
        $this->ensureAdminOrManager();
        $user = Auth::user();

        $baseQuery = $this->baseQueryForCurrentUser();

        $stats = [
            'total'    => (clone $baseQuery)->count(),
            'aktif'    => (clone $baseQuery)->where('status_kerja', User::STATUS_AKTIF)->count(),
            'cuti'     => (clone $baseQuery)->where('status_kerja', User::STATUS_CUTI)->count(),
            'nonaktif' => (clone $baseQuery)->where('status_kerja', User::STATUS_NONAKTIF)->count(),
        ];

        $query = $this->baseQueryForCurrentUser();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('no_hp', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status_kerja')) {
            $query->where('status_kerja', $request->status_kerja);
        }

        if ($request->filled('tanggal_bergabung_dari')) {
            $query->whereDate('tanggal_bergabung', '>=', $request->tanggal_bergabung_dari);
        }
        if ($request->filled('tanggal_bergabung_sampai')) {
            $query->whereDate('tanggal_bergabung', '<=', $request->tanggal_bergabung_sampai);
        }

        $petugas = $query->orderBy('name')->paginate(15)->withQueryString();

        if ($request->filled('search') || $request->filled('status_kerja') || $request->filled('tanggal_bergabung_dari') || $request->filled('tanggal_bergabung_sampai')) {
            $request->session()->flash('info', 'Menampilkan hasil pencarian/filter.');
        }

        $chartData = [
            'aktif'    => $stats['aktif'],
            'cuti'     => $stats['cuti'],
            'nonaktif' => $stats['nonaktif'],
        ];

        return view('dashboard.petugas.index', compact('user', 'petugas', 'stats', 'chartData'));
    }

    public function create()
    {
        $this->ensureAdminOrManager();
        $user = Auth::user();
        return view('dashboard.petugas.create', compact('user'));
    }

    public function store(Request $request)
    {
        $this->ensureAdminOrManager();
        $validated = $this->validatePetugas($request, null);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = $validated['role'] ?? User::ROLE_PETUGAS;
        $validated['is_active'] = ($validated['status_kerja'] ?? User::STATUS_AKTIF) !== User::STATUS_NONAKTIF;

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('petugas', 'public');
        }

        $newPetuga = User::create($validated);
        $this->sendPetugasNotificationToPetugas($newPetuga, 'created', $newPetuga->email);

        return redirect()->route('dashboard.petugas.index')
            ->with('success', 'Petugas ' . $validated['name'] . ' berhasil ditambahkan.');
    }

    public function show(User $petuga)
    {
        $this->ensureAdminOrManager();
        $this->ensurePetugasYayasan($petuga);
        $user = Auth::user();
        return view('dashboard.petugas.show', compact('user', 'petuga'));
    }

    public function edit(User $petuga)
    {
        $this->ensureAdminOrManager();
        $this->ensurePetugasYayasan($petuga);
        $user = Auth::user();
        return view('dashboard.petugas.edit', compact('user', 'petuga'));
    }

    public function update(Request $request, User $petuga)
    {
        $this->ensureAdminOrManager();
        $this->ensurePetugasYayasan($petuga);

        $validated = $this->validatePetugas($request, $petuga);

        $petuga->name = $validated['name'];
        $petuga->email = $validated['email'];
        $petuga->username = $validated['username'] ?? null;
        $petuga->jenis_kelamin = $validated['jenis_kelamin'] ?? null;
        $petuga->tempat_lahir = $validated['tempat_lahir'] ?? null;
        $petuga->tanggal_lahir = $validated['tanggal_lahir'] ?? null;
        $petuga->alamat = $validated['alamat'] ?? null;
        $petuga->no_hp = $validated['no_hp'] ?? null;
        $petuga->tanggal_bergabung = $validated['tanggal_bergabung'] ?? null;
        $petuga->status_kerja = $validated['status_kerja'] ?? User::STATUS_AKTIF;
        $petuga->shift_jaga = $validated['shift_jaga'] ?? null;
        $petuga->role = $validated['role'] ?? $petuga->role;
        $petuga->is_active = ($petuga->status_kerja !== User::STATUS_NONAKTIF);

        if (!empty($validated['password'])) {
            $petuga->password = Hash::make($validated['password']);
        }

        if ($request->hasFile('foto')) {
            if ($petuga->foto) {
                Storage::disk('public')->delete($petuga->foto);
            }
            $petuga->foto = $request->file('foto')->store('petugas', 'public');
        }

        $petuga->save();
        $this->sendPetugasNotificationToPetugas($petuga, 'updated', $petuga->email);

        return redirect()->route('dashboard.petugas.index')
            ->with('success', 'Data petugas ' . $petuga->name . ' berhasil diperbarui.');
    }

    public function destroy(User $petuga)
    {
        $this->ensureAdminOrManager();
        $this->ensurePetugasYayasan($petuga);

        if ($petuga->id === Auth::id()) {
            return redirect()->route('dashboard.petugas.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        if ($petuga->foto) {
            Storage::disk('public')->delete($petuga->foto);
        }
        $name = $petuga->name;
        $this->sendPetugasNotificationToPetugas($petuga, 'deleted');
        $petuga->delete();

        return redirect()->route('dashboard.petugas.index')
            ->with('success', 'Petugas ' . $name . ' berhasil dihapus.');
    }

    private function sendPetugasNotificationToPetugas(User $petuga, string $action, ?string $excludeEmail = null): void
    {
        try {
            $query = User::petugasYayasan()
                ->whereNotNull('email')
                ->where('email', '!=', '');
            if ($excludeEmail !== null) {
                $query->where('email', '!=', $excludeEmail);
            }
            $emails = $query->pluck('email')->toArray();
            if (!empty($emails)) {
                Mail::to($emails)->send(new PetugasDataNotificationToPetugas($petuga, $action));
            }
        } catch (\Exception $e) {
            Log::error('Gagal mengirim notifikasi data petugas ke email petugas: ' . $e->getMessage());
        }
    }

    public function exportExcel(Request $request): StreamedResponse
    {
        $this->ensureAdminOrManager();
        $query = $this->baseQueryForCurrentUser();
        $this->applyFilters($query, $request);
        $items = $query->orderBy('name')->get();

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="data-petugas-' . date('Y-m-d') . '.csv"',
        ];

        return new StreamedResponse(function () use ($items) {
            $out = fopen('php://output', 'w');
            fputcsv($out, [
                'No', 'Nama', 'Email', 'Username', 'No. HP', 'Alamat', 'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir',
                'Tanggal Bergabung', 'Status Kerja', 'Shift Jaga', 'Role',
            ]);
            foreach ($items as $i => $p) {
                fputcsv($out, [
                    $i + 1,
                    $p->name,
                    $p->email,
                    $p->username ?? '',
                    $p->no_hp ?? '',
                    $p->alamat ?? '',
                    $p->jenis_kelamin_label,
                    $p->tempat_lahir ?? '',
                    $p->tanggal_lahir?->format('Y-m-d') ?? '',
                    $p->tanggal_bergabung?->format('Y-m-d') ?? '',
                    $p->status_kerja_label,
                    $p->shift_jaga_label,
                    $p->role_label,
                ]);
            }
            fclose($out);
        }, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $this->ensureAdminOrManager();
        $query = $this->baseQueryForCurrentUser();
        $this->applyFilters($query, $request);
        $petugas = $query->orderBy('name')->get();

        return view('dashboard.petugas.export-pdf', compact('petugas'));
    }

    private function applyFilters($query, Request $request): void
    {
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('no_hp', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%");
            });
        }
        if ($request->filled('status_kerja')) {
            $query->where('status_kerja', $request->status_kerja);
        }
        if ($request->filled('tanggal_bergabung_dari')) {
            $query->whereDate('tanggal_bergabung', '>=', $request->tanggal_bergabung_dari);
        }
        if ($request->filled('tanggal_bergabung_sampai')) {
            $query->whereDate('tanggal_bergabung', '<=', $request->tanggal_bergabung_sampai);
        }
    }

    private function validatePetugas(Request $request, ?User $petuga): array
    {
        $rules = [
            'name'               => 'required|string|max:255',
            'email'              => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($petuga?->id)],
            'username'           => ['nullable', 'string', 'max:100', Rule::unique('users', 'username')->ignore($petuga?->id)],
            'jenis_kelamin'      => 'nullable|in:L,P',
            'tempat_lahir'       => 'nullable|string|max:100',
            'tanggal_lahir'      => 'nullable|date',
            'alamat'             => 'nullable|string|max:500',
            'no_hp'              => 'nullable|string|max:20',
            'tanggal_bergabung'  => 'nullable|date',
            'status_kerja'       => 'required|in:aktif,cuti,nonaktif',
            'shift_jaga'         => 'nullable|in:pagi,siang,malam',
            'role'               => 'required|in:admin,manajer,petugas_rehabilitasi',
            'foto'               => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ];

        if ($petuga) {
            $rules['password'] = 'nullable|string|min:8|confirmed';
        } else {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $messages = [
            'name.required'        => 'Nama lengkap wajib diisi.',
            'email.required'       => 'Email wajib diisi.',
            'email.unique'         => 'Email sudah terdaftar.',
            'password.required'    => 'Kata sandi wajib diisi.',
            'password.min'         => 'Kata sandi minimal 8 karakter.',
            'password.confirmed'   => 'Konfirmasi kata sandi tidak cocok.',
            'status_kerja.required' => 'Status kerja wajib dipilih.',
            'role.required'        => 'Role wajib dipilih.',
        ];

        return $request->validate($rules, $messages);
    }

    private function ensurePetugasYayasan(User $petuga): void
    {
        $current = Auth::user();

        // Super admin boleh mengelola semua petugas yayasan
        if ($this->isSuperAdmin($current)) {
            if (! in_array($petuga->role, [User::ROLE_ADMIN, User::ROLE_MANAGER, User::ROLE_PETUGAS])) {
                abort(404);
            }
            return;
        }

        // Petugas admin / manajer hanya boleh mengelola petugas user
        if ($petuga->role !== User::ROLE_PETUGAS) {
            abort(404);
        }
    }

    private function baseQueryForCurrentUser()
    {
        $user = Auth::user();

        // Super admin: semua petugas yayasan
        if ($this->isSuperAdmin($user)) {
            return User::petugasYayasan();
        }

        // Petugas admin / manajer: hanya petugas user
        return User::where('role', User::ROLE_PETUGAS);
    }

    private function isSuperAdmin(?User $user): bool
    {
        return $user && $user->isAdmin() && $user->email === 'admin@gmail.com';
    }

    private function ensureAdminOrManager(): void
    {
        $user = Auth::user();
        if (! $user || (! $user->isAdmin() && ! $user->isManager())) {
            abort(403);
        }
    }
}
