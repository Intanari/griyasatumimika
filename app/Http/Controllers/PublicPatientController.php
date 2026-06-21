<?php

namespace App\Http\Controllers;

use App\Models\Patient;

class PublicPatientController extends Controller
{
    /**
     * Tampilkan daftar semua pasien untuk halaman publik.
     */
    public function index()
    {
        $patients = Patient::orderBy('nama_lengkap')->get();

        return view('public.pasien.index', compact('patients'));
    }

    /**
     * Tampilkan profil pasien untuk halaman publik.
     */
    public function show(Patient $patient)
    {
        return view('public.pasien.show', compact('patient'));
    }
}
