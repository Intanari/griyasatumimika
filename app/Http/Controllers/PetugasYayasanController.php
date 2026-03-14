<?php

namespace App\Http\Controllers;

use App\Models\PetugasYayasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PetugasYayasanController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        return view('dashboard.profil-struktur.petugas.create', compact('user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'nama' => 'required|string|max:255',
            'status' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('petugas-yayasan', 'public');
        }
        $validated['urutan'] = (int) $request->input('urutan', 0);

        PetugasYayasan::create($validated);

        return redirect()->route('dashboard.profil-struktur.index')
            ->with('success', 'Petugas yayasan berhasil ditambahkan.');
    }

    public function show(PetugasYayasan $petugasYayasan)
    {
        $user = Auth::user();
        return view('dashboard.profil-struktur.petugas.show', compact('user', 'petugasYayasan'));
    }

    public function edit(PetugasYayasan $petugasYayasan)
    {
        $user = Auth::user();
        return view('dashboard.profil-struktur.petugas.edit', compact('user', 'petugasYayasan'));
    }

    public function update(Request $request, PetugasYayasan $petugasYayasan)
    {
        $validated = $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'nama' => 'required|string|max:255',
            'status' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $petugasYayasan->nama = $validated['nama'];
        $petugasYayasan->status = $validated['status'] ?? null;
        $petugasYayasan->keterangan = $validated['keterangan'] ?? null;
        $petugasYayasan->urutan = (int) $request->input('urutan', $petugasYayasan->urutan);

        if ($request->hasFile('foto')) {
            if ($petugasYayasan->foto && Storage::disk('public')->exists($petugasYayasan->foto)) {
                Storage::disk('public')->delete($petugasYayasan->foto);
            }
            $petugasYayasan->foto = $request->file('foto')->store('petugas-yayasan', 'public');
        }

        $petugasYayasan->save();

        return redirect()->route('dashboard.profil-struktur.index')
            ->with('success', 'Petugas yayasan berhasil diubah.');
    }

    public function destroy(PetugasYayasan $petugasYayasan)
    {
        if ($petugasYayasan->foto && Storage::disk('public')->exists($petugasYayasan->foto)) {
            Storage::disk('public')->delete($petugasYayasan->foto);
        }
        $nama = $petugasYayasan->nama;
        $petugasYayasan->delete();

        return redirect()->route('dashboard.profil-struktur.index')
            ->with('success', 'Petugas yayasan ' . $nama . ' berhasil dihapus.');
    }
}
