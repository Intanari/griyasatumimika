<?php

namespace App\Http\Controllers;

use App\Models\ProsesLaporanOdgj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProsesLaporanOdgjController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        return view('dashboard.layanan.proses-laporan-odgj.create', compact('user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_urut'    => ['required', 'integer', 'min:1'],
            'judul'      => ['required', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
        ]);

        ProsesLaporanOdgj::create($validated);

        return redirect()
            ->route('dashboard.layanan.index')
            ->with('success', 'Proses laporan ODGJ berhasil ditambahkan.');
    }

    public function show(ProsesLaporanOdgj $prosesLaporanOdgj)
    {
        $user = Auth::user();
        return view('dashboard.layanan.proses-laporan-odgj.show', compact('user', 'prosesLaporanOdgj'));
    }

    public function edit(ProsesLaporanOdgj $prosesLaporanOdgj)
    {
        $user = Auth::user();
        return view('dashboard.layanan.proses-laporan-odgj.edit', compact('user', 'prosesLaporanOdgj'));
    }

    public function update(Request $request, ProsesLaporanOdgj $prosesLaporanOdgj)
    {
        $validated = $request->validate([
            'no_urut'    => ['required', 'integer', 'min:1'],
            'judul'      => ['required', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $prosesLaporanOdgj->update($validated);

        return redirect()
            ->route('dashboard.layanan.index')
            ->with('success', 'Proses laporan ODGJ berhasil diubah.');
    }

    public function destroy(ProsesLaporanOdgj $prosesLaporanOdgj)
    {
        $prosesLaporanOdgj->delete();
        return redirect()
            ->route('dashboard.layanan.index')
            ->with('success', 'Proses laporan ODGJ berhasil dihapus.');
    }
}
