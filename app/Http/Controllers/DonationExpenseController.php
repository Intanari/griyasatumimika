<?php

namespace App\Http\Controllers;

use App\Models\DonationExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DonationExpenseController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        return view('dashboard.donasi-pengeluaran.create', compact('user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'keterangan' => 'required|string|max:500',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pengeluaran' => 'required|date',
            'bukti' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ], [
            'keterangan.required' => 'Keterangan (digunakan untuk apa) wajib diisi.',
            'jumlah.required' => 'Jumlah pengeluaran wajib diisi.',
            'tanggal_pengeluaran.required' => 'Tanggal pengeluaran wajib diisi.',
        ]);

        $validated['jumlah'] = (int) $validated['jumlah'];
        if ($request->hasFile('bukti')) {
            $validated['bukti_path'] = $request->file('bukti')->store('donation-expenses', 'public');
        } else {
            $validated['bukti_path'] = null;
        }
        unset($validated['bukti']);

        DonationExpense::create([
            'keterangan' => $validated['keterangan'],
            'jumlah' => $validated['jumlah'],
            'bukti_path' => $validated['bukti_path'],
            'tanggal_pengeluaran' => $validated['tanggal_pengeluaran'],
        ]);

        return redirect()->route('dashboard.donasi')->with('success', 'Pengeluaran donasi berhasil ditambah.');
    }

    public function edit(DonationExpense $donation_expense)
    {
        $user = Auth::user();
        $pengeluaran = $donation_expense;
        return view('dashboard.donasi-pengeluaran.edit', compact('user', 'pengeluaran'));
    }

    public function update(Request $request, DonationExpense $donation_expense)
    {
        $validated = $request->validate([
            'keterangan' => 'required|string|max:500',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pengeluaran' => 'required|date',
            'bukti' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ], [
            'keterangan.required' => 'Keterangan (digunakan untuk apa) wajib diisi.',
            'jumlah.required' => 'Jumlah pengeluaran wajib diisi.',
            'tanggal_pengeluaran.required' => 'Tanggal pengeluaran wajib diisi.',
        ]);

        $donation_expense->keterangan = $validated['keterangan'];
        $donation_expense->jumlah = (int) $validated['jumlah'];
        $donation_expense->tanggal_pengeluaran = $validated['tanggal_pengeluaran'];

        if ($request->hasFile('bukti')) {
            if ($donation_expense->bukti_path) {
                Storage::disk('public')->delete($donation_expense->bukti_path);
            }
            $donation_expense->bukti_path = $request->file('bukti')->store('donation-expenses', 'public');
        }
        $donation_expense->save();

        return redirect()->route('dashboard.donasi')->with('success', 'Pengeluaran donasi berhasil diperbarui.');
    }

    public function destroy(DonationExpense $donation_expense)
    {
        if ($donation_expense->bukti_path) {
            Storage::disk('public')->delete($donation_expense->bukti_path);
        }
        $donation_expense->delete();
        return redirect()->route('dashboard.donasi')->with('success', 'Pengeluaran donasi berhasil dihapus.');
    }
}
