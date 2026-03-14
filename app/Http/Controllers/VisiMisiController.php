<?php

namespace App\Http\Controllers;

use App\Models\VisiMisi;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class VisiMisiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        try {
            $items = VisiMisi::orderBy('created_at', 'desc')->get();
        } catch (QueryException $e) {
            $items = new Collection;
        }

        return view('dashboard.visi-misi.index', compact('user', 'items'));
    }

    public function create()
    {
        $user = Auth::user();

        return view('dashboard.visi-misi.create', compact('user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'      => ['required', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
        ]);

        try {
            VisiMisi::create($validated);
        } catch (QueryException $e) {
            return redirect()
                ->route('dashboard.visi-misi.index')
                ->with('error', 'Gagal menyimpan. Pastikan migrasi sudah dijalankan: php artisan migrate');
        }

        return redirect()
            ->route('dashboard.visi-misi.index')
            ->with('success', 'Visi Misi berhasil ditambahkan.');
    }

    public function show(VisiMisi $visiMisi)
    {
        $user = Auth::user();

        return view('dashboard.visi-misi.show', compact('user', 'visiMisi'));
    }

    public function edit(VisiMisi $visiMisi)
    {
        $user = Auth::user();

        return view('dashboard.visi-misi.edit', compact('user', 'visiMisi'));
    }

    public function update(Request $request, VisiMisi $visiMisi)
    {
        $validated = $request->validate([
            'judul'      => ['required', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $visiMisi->update($validated);

        return redirect()
            ->route('dashboard.visi-misi.index')
            ->with('success', 'Visi Misi berhasil diubah.');
    }

    public function destroy(VisiMisi $visiMisi)
    {
        $visiMisi->delete();

        return redirect()
            ->route('dashboard.visi-misi.index')
            ->with('success', 'Visi Misi berhasil dihapus.');
    }
}
