<?php

namespace App\Http\Controllers;

use App\Mail\OdgjReportAcceptedToWarga;
use App\Mail\OdgjReportRejectedToWarga;
use App\Models\Donation;
use App\Models\ExaminationHistory;
use App\Models\OdgjReport;
use App\Models\Patient;
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

        $patientChartStatus = [
            'labels' => ['Aktif', 'Selesai', 'Dirujuk'],
            'data'   => [
                Patient::where('status', 'aktif')->count(),
                Patient::where('status', 'selesai')->count(),
                Patient::where('status', 'dirujuk')->count(),
            ],
        ];
        $patientChartGender = [
            'labels' => ['Laki-laki', 'Perempuan'],
            'data'   => [
                Patient::where('jenis_kelamin', 'L')->count(),
                Patient::where('jenis_kelamin', 'P')->count(),
            ],
        ];

        // ── Riwayat Pemeriksaan charts ────────────────────────────────────
        $examStats = [
            'total'      => ExaminationHistory::count(),
            'bulan_ini'  => ExaminationHistory::whereMonth('tanggal_pemeriksaan', now()->month)
                                ->whereYear('tanggal_pemeriksaan', now()->year)->count(),
            'bulan_lalu' => ExaminationHistory::whereMonth('tanggal_pemeriksaan', now()->subMonth()->month)
                                ->whereYear('tanggal_pemeriksaan', now()->subMonth()->year)->count(),
        ];

        // Bar chart – pemeriksaan per bulan (6 bulan terakhir)
        $bulanRange = collect(range(5, 0))->map(fn ($i) => now()->subMonths($i));
        $driver = DB::connection()->getDriverName();
        $dateFormatExpr = $driver === 'mysql' || $driver === 'mariadb'
            ? "DATE_FORMAT(tanggal_pemeriksaan, '%Y-%m')"
            : "STRFTIME('%Y-%m', tanggal_pemeriksaan)";
        $examPerBulan = ExaminationHistory::select(
                DB::raw("{$dateFormatExpr} as bulan"),
                DB::raw('COUNT(*) as total')
            )
            ->where('tanggal_pemeriksaan', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        $examChartBulan = [
            'labels' => $bulanRange->map(fn ($d) => $d->locale('id')->translatedFormat('M Y'))->values()->toArray(),
            'data'   => $bulanRange->map(fn ($d) => (int) ($examPerBulan[$d->format('Y-m')] ?? 0))->values()->toArray(),
        ];

        // Horizontal bar – top 5 tempat pemeriksaan
        $topTempat = ExaminationHistory::select('tempat_pemeriksaan', DB::raw('COUNT(*) as total'))
            ->groupBy('tempat_pemeriksaan')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $examChartTempat = [
            'labels' => $topTempat->pluck('tempat_pemeriksaan')->map(fn ($t) => \Str::limit($t, 25))->values()->toArray(),
            'data'   => $topTempat->pluck('total')->values()->toArray(),
        ];

        return view('dashboard.index', compact(
            'user', 'stats',
            'donasi_terbaru', 'donasi_per_program', 'laporan_odgj',
            'patientChartStatus', 'patientChartGender',
            'examStats', 'examChartBulan', 'examChartTempat'
        ));
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
            'total_pasien'        => Patient::count(),
            'pasien_laki_laki'    => Patient::where('jenis_kelamin', 'L')->count(),
            'pasien_perempuan'    => Patient::where('jenis_kelamin', 'P')->count(),
            'pasien_aktif'        => Patient::where('status', 'aktif')->count(),
            'pasien_selesai'      => Patient::where('status', 'selesai')->count(),
            'pasien_dirujuk'      => Patient::where('status', 'dirujuk')->count(),
        ];
    }

}
