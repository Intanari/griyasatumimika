<?php

namespace App\Http\Controllers;

use App\Models\ProfilYayasan;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ProfilYayasanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        try {
            $items = ProfilYayasan::orderBy('created_at', 'desc')->get();
        } catch (QueryException $e) {
            // Tabel belum ada (migrasi belum dijalankan di server)
            $items = new Collection;
        }

        return view('dashboard.profil-yayasan.index', compact('user', 'items'));
    }

    public function create()
    {
        $user = Auth::user();

        return view('dashboard.profil-yayasan.create', compact('user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'      => ['required', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
        ]);

        try {
            ProfilYayasan::create($validated);
        } catch (QueryException $e) {
            return redirect()
                ->route('dashboard.profil-yayasan.index')
                ->with('error', 'Gagal menyimpan. Pastikan migrasi sudah dijalankan: php artisan migrate');
        }

        return redirect()
            ->route('dashboard.profil-yayasan.index')
            ->with('success', 'Profil yayasan berhasil ditambahkan.');
    }

    public function show(ProfilYayasan $profilYayasan)
    {
        $user = Auth::user();

        return view('dashboard.profil-yayasan.show', compact('user', 'profilYayasan'));
    }

    public function edit(ProfilYayasan $profilYayasan)
    {
        $user = Auth::user();

        return view('dashboard.profil-yayasan.edit', compact('user', 'profilYayasan'));
    }

    public function update(Request $request, ProfilYayasan $profilYayasan)
    {
        $validated = $request->validate([
            'judul'      => ['required', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $profilYayasan->update($validated);

        return redirect()
            ->route('dashboard.profil-yayasan.index')
            ->with('success', 'Profil yayasan berhasil diubah.');
    }

    public function destroy(ProfilYayasan $profilYayasan)
    {
        $profilYayasan->delete();

        return redirect()
            ->route('dashboard.profil-yayasan.index')
            ->with('success', 'Profil yayasan berhasil dihapus.');
    }
}
