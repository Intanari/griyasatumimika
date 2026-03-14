<?php

namespace App\Http\Controllers;

use App\Models\TahapanRehabilitasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TahapanRehabilitasiController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        return view('dashboard.layanan.tahapan-rehabilitasi.create', compact('user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_urut'    => ['required', 'integer', 'min:1'],
            'status'     => ['nullable', 'string', 'max:100'],
            'judul'      => ['required', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
        ]);

        TahapanRehabilitasi::create($validated);

        return redirect()
            ->route('dashboard.layanan.index')
            ->with('success', 'Tahapan rehabilitasi berhasil ditambahkan.');
    }

    public function show(TahapanRehabilitasi $tahapanRehabilitasi)
    {
        $user = Auth::user();
        return view('dashboard.layanan.tahapan-rehabilitasi.show', compact('user', 'tahapanRehabilitasi'));
    }

    public function edit(TahapanRehabilitasi $tahapanRehabilitasi)
    {
        $user = Auth::user();
        return view('dashboard.layanan.tahapan-rehabilitasi.edit', compact('user', 'tahapanRehabilitasi'));
    }

    public function update(Request $request, TahapanRehabilitasi $tahapanRehabilitasi)
    {
        $validated = $request->validate([
            'no_urut'    => ['required', 'integer', 'min:1'],
            'status'     => ['nullable', 'string', 'max:100'],
            'judul'      => ['required', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $tahapanRehabilitasi->update($validated);

        return redirect()
            ->route('dashboard.layanan.index')
            ->with('success', 'Tahapan rehabilitasi berhasil diubah.');
    }

    public function destroy(TahapanRehabilitasi $tahapanRehabilitasi)
    {
        $tahapanRehabilitasi->delete();
        return redirect()
            ->route('dashboard.layanan.index')
            ->with('success', 'Tahapan rehabilitasi berhasil dihapus.');
    }
}
