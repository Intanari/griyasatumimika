<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShiftController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $shifts = Shift::orderBy('jam_mulai')->get();

        return view('dashboard.shifts.index', compact('user', 'shifts'));
    }

    public function create()
    {
        $user = Auth::user();

        return view('dashboard.shifts.create', compact('user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'        => 'required|string|max:100',
            'jam_mulai'   => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i',
        ], [
            'nama.required' => 'Nama shift wajib diisi.',
        ]);

        if ($validated['jam_selesai'] <= $validated['jam_mulai']) {
            return redirect()->back()->withInput()->withErrors([
                'jam_selesai' => 'Jam selesai harus setelah jam mulai.',
            ]);
        }

        Shift::create($validated);

        return redirect()->route('dashboard.shifts.index')
            ->with('success', 'Shift berhasil ditambahkan.');
    }

    public function edit(Shift $shift)
    {
        $user = Auth::user();

        return view('dashboard.shifts.edit', compact('user', 'shift'));
    }

    public function update(Request $request, Shift $shift)
    {
        $validated = $request->validate([
            'nama'        => 'required|string|max:100',
            'jam_mulai'   => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i',
        ]);

        if ($validated['jam_selesai'] <= $validated['jam_mulai']) {
            return redirect()->back()->withInput()->withErrors([
                'jam_selesai' => 'Jam selesai harus setelah jam mulai.',
            ]);
        }

        $shift->update($validated);

        return redirect()->route('dashboard.shifts.index')
            ->with('success', 'Shift berhasil diperbarui.');
    }

    public function destroy(Shift $shift)
    {
        if ($shift->jadwalPetugas()->exists()) {
            return redirect()->route('dashboard.shifts.index')
                ->with('error', 'Shift tidak dapat dihapus karena masih digunakan di jadwal petugas.');
        }

        $shift->delete();

        return redirect()->route('dashboard.shifts.index')
            ->with('success', 'Shift berhasil dihapus.');
    }
}
