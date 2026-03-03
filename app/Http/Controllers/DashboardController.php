<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\OdgjReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $stats = [
            'total_donasi'        => Donation::count(),
            'donasi_sukses'       => Donation::where('status', 'paid')->count(),
            'donasi_pending'      => Donation::where('status', 'pending')->count(),
            'total_terkumpul'     => Donation::where('status', 'paid')->sum('amount'),
            'total_petugas'       => User::where('role', 'petugas_rehabilitasi')->where('is_active', true)->count(),
            'donasi_bulan_ini'    => Donation::where('status', 'paid')
                                        ->whereMonth('paid_at', now()->month)
                                        ->whereYear('paid_at', now()->year)
                                        ->sum('amount'),
        ];

        $donasi_terbaru = Donation::orderByDesc('created_at')->limit(8)->get();

        $donasi_per_program = Donation::where('status', 'paid')
            ->select('program', DB::raw('count(*) as total'), DB::raw('sum(amount) as total_amount'))
            ->groupBy('program')
            ->orderByDesc('total_amount')
            ->get();

        $laporan_odgj = OdgjReport::orderByDesc('created_at')->limit(15)->get();
        $stats['total_laporan_odgj'] = OdgjReport::count();
        $stats['laporan_odgj_baru'] = OdgjReport::where('status', 'baru')->count();

        return view('dashboard', compact('user', 'stats', 'donasi_terbaru', 'donasi_per_program', 'laporan_odgj'));
    }
}
