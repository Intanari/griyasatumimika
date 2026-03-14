<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PublicPatientController extends Controller
{
    /**
     * Redirect ke pasien pertama atau halaman kosong.
     */
    public function index()
    {
        $first = Patient::orderBy('nama_lengkap')->first();
        if ($first) {
            return redirect()->route('public.pasien.show', $first);
        }
        return redirect()->route('welcome')->with('info', 'Belum ada data pasien.');
    }

    /**
     * Tampilkan profil pasien untuk halaman publik.
     */
    public function show(Patient $patient)
    {
        return view('public.pasien.show', compact('patient'));
    }
}
