<?php

namespace App\Http\Controllers;

use App\Mail\JadwalPetugasNotification;
use App\Models\JadwalLibur;
use App\Models\JadwalPetugas;
use App\Models\Shift;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class JadwalPetugasController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today();

        $pagiId = Shift::where('nama', 'Pagi')->value('id');
        $siangId = Shift::where('nama', 'Siang')->value('id');
        $malamId = Shift::where('nama', 'Malam')->value('id');

        $excludeLibur = function ($q) {
            $q->whereNotExists(function ($sq) {
                $sq->select(\DB::raw(1))->from('jadwal_libur')
                    ->whereColumn('jadwal_libur.user_id', 'jadwal_petugas.user_id')
                    ->whereColumn('jadwal_libur.tanggal', 'jadwal_petugas.tanggal');
            });
        };
        $stats = [
            'bulan_ini' => JadwalPetugas::whereMonth('tanggal', $today->month)->whereYear('tanggal', $today->year)->where($excludeLibur)->count(),
            'hari_ini'  => JadwalPetugas::whereDate('tanggal', $today)->where($excludeLibur)->count(),
            'pagi'      => JadwalPetugas::whereDate('tanggal', '>=', $today)
                ->where($excludeLibur)
                ->where(function ($q) use ($pagiId) {
                    $q->where('shift_id', $pagiId)->orWhere('shift', JadwalPetugas::SHIFT_PAGI);
                })->count(),
            'siang'     => JadwalPetugas::whereDate('tanggal', '>=', $today)
                ->where($excludeLibur)
                ->where(function ($q) use ($siangId) {
                    $q->where('shift_id', $siangId)->orWhere('shift', JadwalPetugas::SHIFT_SIANG);
                })->count(),
            'malam'     => JadwalPetugas::whereDate('tanggal', '>=', $today)
                ->where($excludeLibur)
                ->where(function ($q) use ($malamId) {
                    $q->where('shift_id', $malamId)->orWhere('shift', JadwalPetugas::SHIFT_MALAM);
                })->count(),
        ];

        $query = JadwalPetugas::with(['user', 'shiftModel']);

        // Quick period filter
        if ($request->filled('period')) {
            switch ($request->period) {
                case 'hari_ini':
                    $query->whereDate('tanggal', $today);
                    break;
                case 'minggu_ini':
                    $query->whereBetween('tanggal', [$today->copy()->startOfWeek(), $today->copy()->endOfWeek()]);
                    break;
                case 'bulan_ini':
                    $query->whereMonth('tanggal', $today->month)->whereYear('tanggal', $today->year);
                    break;
            }
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }
        if ($request->filled('shift_id')) {
            $query->where('shift_id', $request->shift_id);
        } elseif ($request->filled('shift')) {
            $query->where('shift', $request->shift);
        }

        // Default: tampilkan jadwal ke depan kalau tidak ada filter
        if (!$request->hasAny(['period', 'user_id', 'tanggal_dari', 'tanggal_sampai', 'shift', 'shift_id'])) {
            $query->whereDate('tanggal', '>=', $today);
        }

        // Exclude jadwal yang kena libur khusus
        $query->whereNotExists(function ($q) {
            $q->select(\DB::raw(1))
                ->from('jadwal_libur')
                ->whereColumn('jadwal_libur.user_id', 'jadwal_petugas.user_id')
                ->whereColumn('jadwal_libur.tanggal', 'jadwal_petugas.tanggal');
        });

        $petugasList = User::petugasYayasan()->where('status_kerja', User::STATUS_AKTIF)->orderBy('name')->get();
        $shifts = Shift::orderBy('jam_mulai')->get();

        $groupByNama = !$request->filled('user_id');

        if ($groupByNama) {
            $jadwalsRaw = $query->orderBy('user_id')->orderBy('tanggal')->orderBy('jam_mulai')->get();
            $grouped = $jadwalsRaw->groupBy('user_id');
        } else {
            $jadwals = $query
                ->orderBy('tanggal', 'asc')
                ->orderByRaw('CASE WHEN jam_mulai IS NULL THEN 1 ELSE 0 END ASC')
                ->orderBy('jam_mulai', 'asc')
                ->paginate(15)
                ->withQueryString();
        }

        // Tampilan kalender: satu bulan penuh (tanggal 1 sampai akhir bulan)
        $viewMode = $request->get('view', 'table');
        $monthStart = $today->copy()->startOfMonth();
        if ($request->filled('week')) {
            $monthStart = Carbon::parse($request->week)->startOfMonth();
        }
        $monthEnd = $monthStart->copy()->endOfMonth();
        $lastDay = (int) $monthEnd->format('d');

        // Grid bulan: Senin = kolom pertama, isi dari tanggal 1 sampai akhir bulan
        $startPadding = ($monthStart->dayOfWeek + 6) % 7; // 0=Senin, 6=Minggu
        $weekDates = [];
        $cells = array_merge(
            array_fill(0, $startPadding, null),
            array_map(fn ($d) => $monthStart->copy()->addDays($d - 1), range(1, $lastDay))
        );
        foreach (array_chunk($cells, 7) as $row) {
            $weekDates[] = array_pad($row, 7, null);
        }

        $jadwalsWeekQuery = JadwalPetugas::with(['user', 'shiftModel'])
            ->whereNotExists(function ($q) {
                $q->select(\DB::raw(1))
                    ->from('jadwal_libur')
                    ->whereColumn('jadwal_libur.user_id', 'jadwal_petugas.user_id')
                    ->whereColumn('jadwal_libur.tanggal', 'jadwal_petugas.tanggal');
            })
            ->whereBetween('tanggal', [$monthStart->toDateString(), $monthEnd->toDateString()]);

        // Terapkan filter yang sama dengan tabel agar kalender konsisten
        if ($request->filled('user_id')) {
            $jadwalsWeekQuery->where('user_id', $request->user_id);
        }
        if ($request->filled('shift_id')) {
            $jadwalsWeekQuery->where('shift_id', $request->shift_id);
        } elseif ($request->filled('shift')) {
            $jadwalsWeekQuery->where('shift', $request->shift);
        }
        if ($request->filled('tanggal_dari')) {
            $jadwalsWeekQuery->whereDate('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $jadwalsWeekQuery->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        $jadwalsWeek = $jadwalsWeekQuery
            ->orderBy('tanggal')
            ->orderByRaw('CASE WHEN jam_mulai IS NULL THEN 1 ELSE 0 END ASC')
            ->orderBy('jam_mulai')
            ->get();

        $jadwalsByDate = $jadwalsWeek->groupBy(fn ($j) => $j->tanggal->format('Y-m-d'));

        if ($groupByNama) {
            $perPage = 15;
            $currentPage = max(1, (int) $request->get('page', 1));
            $items = $grouped->map(function ($jList) {
                $first = $jList->first();
                $shifts = $jList->pluck('shift_label')->unique()->filter()->values();
                $jam = $jList->pluck('jam_display')->unique()->filter()->values()->first() ?? '-';
                $hari = $jList->map(fn ($j) => $j->hari)->unique()->filter()->sort()->values()->implode(', ');
                $hasGanti = $jList->contains('tipe', JadwalPetugas::TIPE_GANTI);
                return (object) [
                    'user' => $first->user,
                    'shifts' => $shifts,
                    'jam' => $jam,
                    'hari' => $hari,
                    'jadwals' => $jList,
                    'has_ganti' => $hasGanti,
                ];
            })->values();
            $jadwals = new \Illuminate\Pagination\LengthAwarePaginator(
                $items->forPage($currentPage, $perPage),
                $items->count(),
                $perPage,
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );
            $groupByNama = true;
        } else {
            $groupByNama = false;
        }

        $weekStart = $monthStart->copy(); // untuk link kalender (tetap pakai bulan)
        return view('dashboard.jadwal-petugas.index', compact('user', 'jadwals', 'petugasList', 'shifts', 'stats', 'viewMode', 'weekStart', 'weekDates', 'jadwalsByDate', 'groupByNama', 'monthStart', 'monthEnd'));
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $petugasList = User::petugasYayasan()->where('status_kerja', User::STATUS_AKTIF)->orderBy('name')->get();
        $shifts = Shift::orderBy('jam_mulai')->get();
        $copyFrom = null;
        if ($request->filled('copy_from')) {
            $copyFrom = JadwalPetugas::with(['user', 'shiftModel'])->find($request->copy_from);
        }

        return view('dashboard.jadwal-petugas.create', compact('user', 'petugasList', 'shifts', 'copyFrom'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'        => 'required|exists:users,id',
            'tanggal_dari'   => 'required|date',
            'tanggal_sampai' => 'required|date|after_or_equal:tanggal_dari',
            'ulang_setiap'   => 'nullable|in:minggu,2minggu,bulan',
            'shifts_by_day'  => 'required|array',
            'shifts_by_day.0' => 'nullable|array',
            'shifts_by_day.1' => 'nullable|array',
            'shifts_by_day.2' => 'nullable|array',
            'shifts_by_day.3' => 'nullable|array',
            'shifts_by_day.4' => 'nullable|array',
            'shifts_by_day.5' => 'nullable|array',
            'shifts_by_day.6' => 'nullable|array',
            'shifts_by_day.*.*' => 'exists:shifts,id',
        ], [
            'user_id.required'     => 'Petugas wajib dipilih.',
            'tanggal_dari.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_sampai.required' => 'Tanggal berakhir wajib diisi.',
            'shifts_by_day.required' => 'Pilih minimal satu shift pada satu atau lebih hari.',
        ]);

        $hasAnyShift = false;
        foreach ([0, 1, 2, 3, 4, 5, 6] as $d) {
            if (!empty($validated['shifts_by_day'][$d] ?? [])) {
                $hasAnyShift = true;
                break;
            }
        }
        if (!$hasAnyShift) {
            return redirect()->back()->withInput()->withErrors([
                'shifts_by_day' => 'Pilih minimal satu shift pada satu atau lebih hari. Hari kosong = Libur.',
            ]);
        }

        $tanggalDari = Carbon::parse($validated['tanggal_dari']);
        $tanggalSampai = Carbon::parse($validated['tanggal_sampai']);
        $ulangSetiap = $validated['ulang_setiap'] ?? 'minggu';
        $shiftsById = Shift::all()->keyBy('id');
        $created = 0;
        $skipped = 0;

        $datesToProcess = $this->getDatesForRepeatPattern($tanggalDari, $tanggalSampai, $ulangSetiap);

        foreach ([0, 1, 2, 3, 4, 5, 6] as $dayOfWeek) {
            $shiftIds = array_map('intval', $validated['shifts_by_day'][$dayOfWeek] ?? []);
            if (empty($shiftIds)) {
                continue;
            }

            foreach ($datesToProcess as $date) {
                if ((int) $date->dayOfWeek !== $dayOfWeek) {
                    continue;
                }

                foreach ($shiftIds as $shiftId) {
                    $shift = $shiftsById->get($shiftId);
                    if (!$shift) {
                        continue;
                    }

                    $bentrok = JadwalPetugas::where('user_id', $validated['user_id'])
                        ->whereDate('tanggal', $date)
                        ->where('shift_id', $shiftId)
                        ->exists();

                    if ($bentrok) {
                        $skipped++;
                        continue;
                    }

                    JadwalPetugas::create([
                        'user_id'     => $validated['user_id'],
                        'shift_id'    => $shiftId,
                        'tipe'        => JadwalPetugas::TIPE_RUTIN,
                        'tanggal'     => $date->toDateString(),
                        'jam_mulai'   => $shift->jam_mulai,
                        'jam_selesai' => $shift->jam_selesai,
                    ]);
                    $created++;
                }
            }
        }

        $labelUlang = match ($ulangSetiap) {
            '2minggu' => ' (ulang setiap 2 minggu)',
            'bulan'   => ' (ulang setiap bulan)',
            default   => ' (ulang setiap minggu)',
        };

        $message = $created > 0
            ? "Berhasil membuat {$created} jadwal{$labelUlang}." . ($skipped > 0 ? " {$skipped} jadwal dilewati (bentrok)." : '')
            : 'Tidak ada jadwal yang dibuat. Pilih minimal satu shift pada satu atau lebih hari.';

        return redirect()->route('dashboard.jadwal-petugas.index')
            ->with('success', $message);
    }

    /**
     * Daftar tanggal sesuai pola pengulangan (seperti alarm).
     */
    private function getDatesForRepeatPattern(Carbon $dari, Carbon $sampai, string $ulangSetiap): \Illuminate\Support\Collection
    {
        $dates = collect();

        if ($ulangSetiap === 'minggu') {
            for ($date = $dari->copy(); $date->lte($sampai); $date->addDay()) {
                $dates->push($date->copy());
            }
            return $dates;
        }

        if ($ulangSetiap === '2minggu') {
            $mingguPertama = $dari->copy()->startOfWeek(Carbon::MONDAY);
            for ($date = $dari->copy(); $date->lte($sampai); $date->addDay()) {
                $weekStart = $date->copy()->startOfWeek(Carbon::MONDAY);
                $diffWeeks = (int) floor($mingguPertama->diffInDays($weekStart) / 7);
                if ($diffWeeks % 2 === 0) {
                    $dates->push($date->copy());
                }
            }
            return $dates;
        }

        if ($ulangSetiap === 'bulan') {
            // Setiap bulan: tanggal pertama tiap hari dalam seminggu per bulan
            $currentMonth = $dari->copy()->startOfMonth();
            $lastMonth = $sampai->copy()->endOfMonth();
            while ($currentMonth->lte($lastMonth)) {
                for ($dow = 0; $dow <= 6; $dow++) {
                    $first = $currentMonth->copy();
                    while ($first->dayOfWeek !== $dow && $first->month === $currentMonth->month) {
                        $first->addDay();
                    }
                    if ($first->month === $currentMonth->month && $first->gte($dari) && $first->lte($sampai)) {
                        $dates->push($first->copy());
                    }
                }
                $currentMonth->addMonth()->startOfMonth();
            }
            return $dates->sort()->values();
        }

        return $dates;
    }

    /**
     * Simpan libur khusus: petugas libur di tanggal tertentu (mis. libur Natal 25 Des).
     * Jadwal rutin petugas di tanggal tersebut akan disembunyikan di tabel & kalender.
     */
    public function storeLibur(Request $request)
    {
        $validated = $request->validate([
            'user_id'   => 'required|exists:users,id',
            'tanggal'   => 'required|date',
            'keterangan'=> 'nullable|string|max:255',
        ], [
            'user_id.required' => 'Petugas wajib dipilih.',
            'tanggal.required' => 'Tanggal wajib diisi.',
        ]);

        JadwalLibur::updateOrCreate(
            ['user_id' => $validated['user_id'], 'tanggal' => $validated['tanggal']],
            ['keterangan' => $validated['keterangan'] ?? null]
        );

        return redirect()->route('dashboard.jadwal-petugas.index')
            ->with('success', 'Libur khusus berhasil ditambahkan.');
    }

    /**
     * Simpan jadwal pengganti: petugas masuk di tanggal tertentu menggantikan orang lain.
     * Contoh: hari Minggu (rutin libur) tapi masuk ganti jadwal.
     */
    public function storeGanti(Request $request)
    {
        $validated = $request->validate([
            'user_id'  => 'required|exists:users,id',
            'tanggal'  => 'required|date',
            'shift_id' => 'required|exists:shifts,id',
        ], [
            'user_id.required'  => 'Petugas wajib dipilih.',
            'tanggal.required'  => 'Tanggal wajib diisi.',
            'shift_id.required' => 'Shift wajib dipilih.',
        ]);

        $shift = Shift::findOrFail($validated['shift_id']);

        JadwalPetugas::create([
            'user_id'     => $validated['user_id'],
            'shift_id'    => $validated['shift_id'],
            'tipe'        => JadwalPetugas::TIPE_GANTI,
            'tanggal'     => $validated['tanggal'],
            'jam_mulai'   => $shift->jam_mulai,
            'jam_selesai' => $shift->jam_selesai,
        ]);

        return redirect()->route('dashboard.jadwal-petugas.index')
            ->with('success', 'Jadwal pengganti berhasil ditambahkan.');
    }

    public function edit(JadwalPetugas $jadwal_petuga)
    {
        $user = Auth::user();
        $jadwal = $jadwal_petuga->load('shiftModel');
        $selectedShiftId = $jadwal->shift_id;
        if (!$selectedShiftId && $jadwal->shift) {
            $selectedShiftId = Shift::where('nama', ucfirst($jadwal->shift))->value('id');
        }
        $petugasList = User::petugasYayasan()->where('status_kerja', User::STATUS_AKTIF)->orderBy('name')->get();
        $shifts = Shift::orderBy('jam_mulai')->get();

        return view('dashboard.jadwal-petugas.edit', compact('user', 'jadwal', 'petugasList', 'shifts', 'selectedShiftId'));
    }

    public function update(Request $request, JadwalPetugas $jadwal_petuga)
    {
        $validated = $request->validate([
            'user_id'   => 'required|exists:users,id',
            'tanggal'   => 'required|date',
            'shift_id'  => 'required|exists:shifts,id',
        ], [
            'user_id.required'  => 'Petugas wajib dipilih.',
            'tanggal.required'   => 'Tanggal wajib diisi.',
            'shift_id.required'  => 'Shift wajib dipilih.',
        ]);

        $shift = Shift::findOrFail($validated['shift_id']);

        $bentrok = JadwalPetugas::where('user_id', $validated['user_id'])
            ->whereDate('tanggal', $validated['tanggal'])
            ->where('shift_id', $validated['shift_id'])
            ->where('id', '!=', $jadwal_petuga->id)
            ->exists();
        if ($bentrok) {
            return redirect()->back()->withInput()->withErrors([
                'user_id' => 'Petugas ini sudah memiliki jadwal di tanggal dan shift yang sama.',
            ]);
        }

        $jadwal_petuga->update([
            'user_id'     => $validated['user_id'],
            'tanggal'     => $validated['tanggal'],
            'shift_id'    => $validated['shift_id'],
            'jam_mulai'   => $shift->jam_mulai,
            'jam_selesai' => $shift->jam_selesai,
        ]);
        $jadwal_petuga->load('user');
        $this->sendJadwalNotification($jadwal_petuga, 'updated');

        return redirect()->route('dashboard.jadwal-petugas.index')
            ->with('success', 'Jadwal petugas berhasil diperbarui.');
    }

    public function destroy(JadwalPetugas $jadwal_petuga)
    {
        $jadwal_petuga->load('user');
        $this->sendJadwalNotification($jadwal_petuga, 'deleted');
        $jadwal_petuga->delete();

        return redirect()->route('dashboard.jadwal-petugas.index')
            ->with('success', 'Jadwal petugas berhasil dihapus.');
    }

    /**
     * Kirim email notifikasi ke petugas yang jadwalnya terkena aksi (created/updated/deleted).
     */
    private function sendJadwalNotification(JadwalPetugas $jadwal, string $action): void
    {
        try {
            $petugas = $jadwal->user;
            if (!$petugas || empty($petugas->email)) {
                Log::info('Notifikasi jadwal tidak dikirim: petugas tidak punya email.', ['jadwal_id' => $jadwal->id]);
                return;
            }
            Mail::to($petugas->email)->send(new JadwalPetugasNotification($jadwal, $action));
        } catch (\Exception $e) {
            Log::error('Gagal mengirim notifikasi jadwal petugas: ' . $e->getMessage());
        }
    }

    public function duplicate(JadwalPetugas $jadwal_petuga)
    {
        return redirect()->route('dashboard.jadwal-petugas.create', ['copy_from' => $jadwal_petuga->id]);
    }

    public function bulkCreate()
    {
        $user = Auth::user();
        $petugasList = User::petugasYayasan()->where('status_kerja', User::STATUS_AKTIF)->orderBy('name')->get();

        return view('dashboard.jadwal-petugas.bulk-create', compact('user', 'petugasList'));
    }

    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'user_id'       => 'required|exists:users,id',
            'tanggal_dari'  => 'required|date',
            'tanggal_sampai'=> 'required|date|after_or_equal:tanggal_dari',
            'shift'         => 'required|in:pagi,siang,malam',
            'hari'          => 'required|array|min:1',
            'hari.*'        => 'in:0,1,2,3,4,5,6',
            'jam_mulai'     => 'nullable|date_format:H:i',
            'jam_selesai'   => 'nullable|date_format:H:i',
            'lokasi'        => 'nullable|string|max:255',
            'keterangan'    => 'nullable|string',
        ], [
            'user_id.required'       => 'Petugas wajib dipilih.',
            'tanggal_dari.required'  => 'Tanggal dari wajib diisi.',
            'tanggal_sampai.required'=> 'Tanggal sampai wajib diisi.',
            'hari.required'          => 'Pilih minimal satu hari dalam minggu.',
        ]);

        if (!empty($validated['jam_mulai']) && !empty($validated['jam_selesai']) && $validated['jam_selesai'] < $validated['jam_mulai']) {
            return redirect()->back()->withInput()->withErrors(['jam_selesai' => 'Jam selesai harus setelah jam mulai.']);
        }

        $tanggalDari = Carbon::parse($validated['tanggal_dari']);
        $tanggalSampai = Carbon::parse($validated['tanggal_sampai']);
        $hariDipilih = array_map('intval', $validated['hari']); // 0=Minggu, 1=Senin, ..., 6=Sabtu (Carbon dayOfWeek)

        $created = 0;
        $skipped = 0;

        for ($date = $tanggalDari->copy(); $date->lte($tanggalSampai); $date->addDay()) {
            if (!in_array($date->dayOfWeek, $hariDipilih)) {
                continue;
            }

            $bentrok = JadwalPetugas::where('user_id', $validated['user_id'])
                ->whereDate('tanggal', $date)
                ->where('shift', $validated['shift'])
                ->exists();

            if ($bentrok) {
                $skipped++;
                continue;
            }

            JadwalPetugas::create([
                'user_id'     => $validated['user_id'],
                'tanggal'     => $date->toDateString(),
                'shift'       => $validated['shift'],
                'jam_mulai'   => $validated['jam_mulai'] ?? null,
                'jam_selesai' => $validated['jam_selesai'] ?? null,
                'lokasi'      => $validated['lokasi'] ?? null,
                'keterangan'  => $validated['keterangan'] ?? null,
            ]);
            $created++;
        }

        $message = $created > 0
            ? "Berhasil membuat {$created} jadwal." . ($skipped > 0 ? " {$skipped} jadwal dilewati (bentrok)." : '')
            : 'Tidak ada jadwal yang dibuat. Semua tanggal bentrok atau tidak ada hari yang cocok.';

        return redirect()->route('dashboard.jadwal-petugas.index')->with('success', $message);
    }

    public function exportPdf(Request $request)
    {
        $query = JadwalPetugas::with(['user', 'shiftModel']);
        $this->applyExportFilters($query, $request);
        $jadwals = $query->orderBy('tanggal')->orderBy('jam_mulai')->get();

        $today = Carbon::today();
        $monthStart = $request->filled('tanggal_dari')
            ? Carbon::parse($request->tanggal_dari)->startOfMonth()
            : ($jadwals->isNotEmpty() ? Carbon::parse($jadwals->min('tanggal'))->startOfMonth() : $today->copy()->startOfMonth());
        $monthEnd = $monthStart->copy()->endOfMonth();

        $monthStart = Carbon::parse($monthStart)->startOfMonth();
        $monthEnd = Carbon::parse($monthEnd)->endOfMonth();

        $jadwalsFiltered = $jadwals->filter(fn ($j) => Carbon::parse($j->tanggal)->between($monthStart, $monthEnd));
        $jadwalsByDate = $jadwalsFiltered->groupBy(fn ($j) => Carbon::parse($j->tanggal)->format('Y-m-d'));

        $lastDay = (int) $monthEnd->format('d');
        $startPadding = ($monthStart->dayOfWeek + 6) % 7;
        $cells = array_merge(
            array_fill(0, $startPadding, null),
            array_map(fn ($d) => $monthStart->copy()->addDays($d - 1), range(1, $lastDay))
        );
        $weeks = [];
        foreach (array_chunk($cells, 7) as $row) {
            $weeks[] = array_pad($row, 7, null);
        }

        $filename = 'jadwal-petugas-' . $monthStart->format('Y-m') . '.pdf';

        $pdf = Pdf::loadView('dashboard.jadwal-petugas.export-pdf', compact('jadwals', 'jadwalsByDate', 'weeks', 'monthStart', 'monthEnd'))
            ->setPaper('a4', 'landscape');

        return $pdf->download($filename);
    }

    private function applyExportFilters($query, Request $request): void
    {
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }
        if ($request->filled('shift_id')) {
            $query->where('shift_id', $request->shift_id);
        } elseif ($request->filled('shift')) {
            $query->where('shift', $request->shift);
        }
        if ($request->filled('period')) {
            $today = Carbon::today();
            switch ($request->period) {
                case 'hari_ini':
                    $query->whereDate('tanggal', $today);
                    break;
                case 'minggu_ini':
                    $query->whereBetween('tanggal', [$today->copy()->startOfWeek(), $today->copy()->endOfWeek()]);
                    break;
                case 'bulan_ini':
                    $query->whereMonth('tanggal', $today->month)->whereYear('tanggal', $today->year);
                    break;
            }
        }
    }
}
