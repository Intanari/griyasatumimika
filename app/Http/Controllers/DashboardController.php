<?php

namespace App\Http\Controllers;

use App\Mail\OdgjReportAcceptedToWarga;
use App\Mail\OdgjReportRejectedToWarga;
use App\Models\Donation;
use App\Models\OdgjReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $stats = $this->getStats();

        $donasi_terbaru = Donation::orderByDesc('created_at')->limit(8)->get();
        $donasi_per_program = Donation::where('status', 'paid')
            ->select('program', DB::raw('count(*) as total'), DB::raw('sum(amount) as total_amount'))
            ->groupBy('program')
            ->orderByDesc('total_amount')
            ->get();
        $laporan_odgj = OdgjReport::orderByDesc('created_at')->limit(8)->get();

        return view('dashboard.index', compact('user', 'stats', 'donasi_terbaru', 'donasi_per_program', 'laporan_odgj'));
    }

    public function donasi()
    {
        $user = Auth::user();
        $stats = $this->getStats();

        $donasi = Donation::orderByDesc('created_at')->paginate(20);
        $donasi_per_program = Donation::where('status', 'paid')
            ->select('program', DB::raw('count(*) as total'), DB::raw('sum(amount) as total_amount'))
            ->groupBy('program')
            ->orderByDesc('total_amount')
            ->get();

        return view('dashboard.donasi', compact('user', 'stats', 'donasi', 'donasi_per_program'));
    }

    public function laporan()
    {
        $user = Auth::user();
        $stats = $this->getStats();

        $laporan_odgj = OdgjReport::orderByDesc('created_at')->paginate(20);

        return view('dashboard.laporan', compact('user', 'stats', 'laporan_odgj'));
    }

    public function terimaLaporan(OdgjReport $laporan)
    {
        $laporan->update(['status' => 'diproses']);

        if (!empty($laporan->email)) {
            try {
                Mail::to($laporan->email)->send(new OdgjReportAcceptedToWarga($laporan));
            } catch (\Exception $e) {
                return redirect()->route('dashboard.laporan')->with('error', 'Status diperbarui, tetapi email gagal dikirim: ' . $e->getMessage());
            }
        }

        return redirect()->route('dashboard.laporan')->with('success', 'Laporan diterima. ' . ($laporan->email ? 'Email konfirmasi telah dikirim ke pelapor.' : 'Catatan: Pelapor tidak mengisi email, sehingga tidak ada email yang dikirim.'));
    }

    public function tolakLaporan(OdgjReport $laporan)
    {
        $laporan->update(['status' => 'ditolak']);

        if (!empty($laporan->email)) {
            try {
                Mail::to($laporan->email)->send(new OdgjReportRejectedToWarga($laporan));
            } catch (\Exception $e) {
                return redirect()->route('dashboard.laporan')->with('error', 'Status diperbarui, tetapi email gagal dikirim: ' . $e->getMessage());
            }
        }

        return redirect()->route('dashboard.laporan')->with('success', 'Laporan ditolak. ' . ($laporan->email ? 'Email konfirmasi telah dikirim ke pelapor.' : 'Catatan: Pelapor tidak mengisi email, sehingga tidak ada email yang dikirim.'));
    }

    private function getStats(): array
    {
        return [
            'total_donasi'        => Donation::count(),
            'donasi_sukses'       => Donation::where('status', 'paid')->count(),
            'donasi_pending'      => Donation::where('status', 'pending')->count(),
            'total_terkumpul'     => Donation::where('status', 'paid')->sum('amount'),
            'total_petugas'       => User::where('role', 'petugas_rehabilitasi')->where('is_active', true)->count(),
            'donasi_bulan_ini'    => Donation::where('status', 'paid')
                ->whereMonth('paid_at', now()->month)
                ->whereYear('paid_at', now()->year)
                ->sum('amount'),
            'total_laporan_odgj'  => OdgjReport::count(),
            'laporan_odgj_baru'   => OdgjReport::where('status', 'baru')->count(),
            'laporan_penjemputan' => OdgjReport::where('kategori', 'penjemputan')->count(),
            'laporan_pengantaran' => OdgjReport::where('kategori', 'pengantaran')->count(),
        ];
    }
}
