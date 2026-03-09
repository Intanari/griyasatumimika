<?php

namespace App\Http\Controllers;

use App\Mail\OdgjReportAcceptedToWarga;
use App\Mail\OdgjReportRejectedToWarga;
use App\Mail\OdgjReportResponToWarga;
use App\Models\Donation;
use App\Models\DonationExpense;
use App\Models\ExaminationHistory;
use App\Models\OdgjReport;
use App\Models\PatientActivity;
use App\Models\InventoryItem;
use App\Models\Patient;
use App\Models\StockExpense;
use App\Models\StockSupply;
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

        // ── Aktivitas Pasien stats ─────────────────────────────────────
        $activityStats = [
            'total'     => PatientActivity::count(),
            'bulan_ini' => PatientActivity::whereMonth('tanggal', now()->month)
                             ->whereYear('tanggal', now()->year)->count(),
            'hari_ini'  => PatientActivity::whereDate('tanggal', now())->count(),
        ];

        // ── Stok Barang (ringkasan untuk dashboard, ambil dari data stok barang) ──
        // Menggunakan tabel tambah/pengeluaran stok (StockSupply & StockExpense),
        // lalu hitung sisa per nama barang seperti di halaman Manajemen Stok.
        try {
            $supplies = StockSupply::select('nama', DB::raw('SUM(jumlah) as total_masuk'))
                ->groupBy('nama')
                ->get()
                ->keyBy('nama');
            $expenses = StockExpense::select('nama', DB::raw('SUM(jumlah) as total_keluar'))
                ->groupBy('nama')
                ->get()
                ->keyBy('nama');

            $allNames = $supplies->keys()
                ->merge($expenses->keys())
                ->unique()
                ->values();

            $totalItems = 0;
            $totalQuantity = 0;
            $outOfStock = 0;
            $lowStock = 0;

            foreach ($allNames as $nama) {
                $masuk = (int) ($supplies[$nama]->total_masuk ?? 0);
                $keluar = (int) ($expenses[$nama]->total_keluar ?? 0);
                $sisa = $masuk - $keluar;

                if ($masuk === 0 && $keluar === 0) {
                    continue;
                }

                $totalItems++;
                if ($sisa <= 0) {
                    $outOfStock++;
                } else {
                    $totalQuantity += $sisa;
                    if ($sisa < 3) {
                        $lowStock++;
                    }
                }
            }

            $stockStats = [
                'total_items'    => $totalItems,
                'total_quantity' => $totalQuantity,
                'out_of_stock'   => $outOfStock,
                'low_stock'      => $lowStock,
            ];
        } catch (\Throwable $e) {
            $stockStats = ['total_items' => 0, 'total_quantity' => 0, 'out_of_stock' => 0, 'low_stock' => 0];
        }

        // Grafik stok: masuk (Supply), keluar (Expense), sisa (masuk - keluar)
        try {
            $totalMasuk = (int) StockSupply::sum('jumlah');
            $totalKeluar = (int) StockExpense::sum('jumlah');
            $sisaStok = $totalMasuk - $totalKeluar;
            $stockChart = [
                'masuk'  => $totalMasuk,
                'keluar' => $totalKeluar,
                'sisa'   => max(0, $sisaStok),
            ];
        } catch (\Throwable $e) {
            $stockChart = ['masuk' => 0, 'keluar' => 0, 'sisa' => 0];
        }

        // ── Stok Barang per Item (untuk kotak & grafik di dashboard) ─────
        try {
            $stockItems = InventoryItem::orderByDesc('quantity')
                ->orderBy('name')
                ->limit(8)
                ->get();

            // Kelompokkan stok masuk & keluar berdasarkan nama barang
            $stokMasukPerNama = StockSupply::select('nama', DB::raw('SUM(jumlah) as total'))
                ->groupBy('nama')
                ->pluck('total', 'nama');
            $stokKeluarPerNama = StockExpense::select('nama', DB::raw('SUM(jumlah) as total'))
                ->groupBy('nama')
                ->pluck('total', 'nama');

            $perItemLabels = [];
            $perItemJumlah = [];
            $perItemMasuk = [];
            $perItemKeluar = [];
            $perItemSisa = [];

            foreach ($stockItems as $item) {
                $label = $item->name;
                $masuk = (int) ($stokMasukPerNama[$label] ?? 0);
                $keluar = (int) ($stokKeluarPerNama[$label] ?? 0);
                $sisa = max(0, $masuk - $keluar);

                $perItemLabels[] = $label;
                // Jumlah item = total unit saat ini di tabel inventaris
                $perItemJumlah[] = (int) $item->quantity;
                $perItemMasuk[] = $masuk;
                $perItemKeluar[] = $keluar;
                $perItemSisa[] = $sisa;
            }

            $stockPerItemChart = [
                'labels' => $perItemLabels,
                'jumlah' => $perItemJumlah,
                'masuk'  => $perItemMasuk,
                'keluar' => $perItemKeluar,
                'sisa'   => $perItemSisa,
            ];

            // Peta sisa stok per nama barang (menggunakan data dari tabel stok barang)
            $stockPerItemSisaByName = [];
            foreach ($perItemLabels as $index => $label) {
                $stockPerItemSisaByName[$label] = (int) ($perItemSisa[$index] ?? 0);
            }
        } catch (\Throwable $e) {
            $stockItems = collect();
            $stockPerItemChart = [
                'labels' => [],
                'jumlah' => [],
                'masuk'  => [],
                'keluar' => [],
                'sisa'   => [],
            ];
            $stockPerItemSisaByName = [];
        }

        return view('dashboard.index', compact(
            'user', 'stats',
            'donasi_terbaru', 'donasi_per_program', 'laporan_odgj',
            'patientChartStatus', 'patientChartGender',
            'examStats', 'examChartBulan', 'examChartTempat',
            'activityStats', 'stockStats', 'stockChart',
            'stockItems', 'stockPerItemChart', 'stockPerItemSisaByName'
        ));
    }

    public function donasi()
    {
        $user = Auth::user();
        $stats = $this->getStats();

        $donasi = Donation::orderByDesc('created_at')->take(10)->get();
        $pengeluaran = DonationExpense::orderByDesc('tanggal_pengeluaran')->orderByDesc('created_at')->take(10)->get();

        return view('dashboard.donasi', compact('user', 'stats', 'donasi', 'pengeluaran'));
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

    public function showLaporan(OdgjReport $laporan)
    {
        $user = Auth::user();
        $stats = $this->getStats();
        return view('dashboard.laporan-show', compact('user', 'stats', 'laporan'));
    }

    public function kirimResponLaporan(Request $request, OdgjReport $laporan)
    {
        $validated = $request->validate([
            'pesan_respon' => 'required|string|max:2000',
        ], [
            'pesan_respon.required' => 'Pesan respons wajib diisi.',
        ]);

        if (empty($laporan->email)) {
            return redirect()->route('dashboard.laporan.show', $laporan)->with('error', 'Pelapor tidak mengisi email. Respon tidak dapat dikirim.');
        }

        try {
            Mail::to($laporan->email)->send(new OdgjReportResponToWarga($laporan, $validated['pesan_respon']));
        } catch (\Exception $e) {
            return redirect()->route('dashboard.laporan.show', $laporan)->with('error', 'Gagal mengirim email: ' . $e->getMessage());
        }

        return redirect()->route('dashboard.laporan.show', $laporan)->with('success', 'Respon laporan telah dikirim ke email pelapor.');
    }

    private function getStats(): array
    {
        return [
            'total_donasi'        => Donation::count(),
            'donasi_sukses'       => Donation::where('status', 'paid')->count(),
            'donasi_pending'      => Donation::where('status', 'pending')->count(),
            'total_terkumpul'     => max(0, (int) Donation::where('status', 'paid')->sum('amount') - (int) DonationExpense::sum('jumlah')),
            'total_petugas'       => User::where('role', 'petugas_rehabilitasi')->where('is_active', true)->count(),
            'total_petugas_yayasan' => User::petugasYayasan()->count(),
            'petugas_aktif'       => User::petugasYayasan()->where('status_kerja', User::STATUS_AKTIF)->count(),
            'petugas_cuti'        => User::petugasYayasan()->where('status_kerja', User::STATUS_CUTI)->count(),
            'petugas_nonaktif'    => User::petugasYayasan()->where('status_kerja', User::STATUS_NONAKTIF)->count(),
            'petugas_laki_laki'   => User::petugasYayasan()->where('jenis_kelamin', 'L')->count(),
            'petugas_perempuan'   => User::petugasYayasan()->where('jenis_kelamin', 'P')->count(),
            'donasi_bulan_ini'    => Donation::where('status', 'paid')
                ->whereMonth('paid_at', now()->month)
                ->whereYear('paid_at', now()->year)
                ->sum('amount'),
            'total_pengeluaran_donasi' => DonationExpense::sum('jumlah'),
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
