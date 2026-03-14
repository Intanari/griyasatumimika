<?php

namespace App\Http\Controllers;

use App\Models\ProsesLaporanOdgj;
use App\Models\TahapanRehabilitasi;
use Illuminate\Support\Facades\Auth;

class LayananController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $prosesLaporanOdgj = ProsesLaporanOdgj::orderBy('no_urut')->orderBy('id')->get();
        $tahapanRehabilitasi = TahapanRehabilitasi::orderBy('no_urut')->orderBy('id')->get();

        return view('dashboard.layanan.index', compact('user', 'prosesLaporanOdgj', 'tahapanRehabilitasi'));
    }
}
