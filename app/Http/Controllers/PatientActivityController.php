<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\PatientActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PatientActivityController extends Controller
{
    public function index(Request $request)
    {
        $user     = Auth::user();
        $patients = Patient::orderBy('nama_lengkap')->get();

        $all = PatientActivity::with('patient')
            ->orderByDesc('created_at')
            ->get();

        $groups = $all->groupBy(function ($a) {
            return $a->batch_uuid ?? 'single-' . $a->id;
        });

        $activityGroups = collect();
        foreach ($groups as $batchId => $items) {
            $first = $items->first();
            $activityGroups->push((object)[
                'id'         => $first->id,
                'tanggal'    => $first->tanggal,
                'waktu'      => $first->waktu_mulai ? \Carbon\Carbon::parse($first->waktu_mulai)->format('H:i') : $first->created_at->format('H:i'),
                'deskripsi'  => $first->deskripsi,
                'image_urls' => $first->image_urls,
                'pasien'     => $items->map(fn ($i) => $i->patient->nama_lengkap ?? '-')->implode(', '),
            ]);
        }

        $perPage = 15;
        $page    = (int) $request->get('page', 1);
        $total   = $activityGroups->count();
        $items   = $activityGroups->slice(($page - 1) * $perPage, $perPage)->values();
        $groups  = new \Illuminate\Pagination\LengthAwarePaginator($items, $total, $perPage, $page, ['path' => $request->url(), 'query' => $request->query()]);

        return view('dashboard.patient-activities.index', compact('user', 'patients', 'groups'));
    }

    /**
     * Simpan aktivitas pasien sederhana: pilih pasien (checkbox), deskripsi, gambar, waktu saat ini otomatis.
     */
    public function storeSimple(Request $request)
    {
        $validated = $request->validate([
            'patient_ids'    => 'required|array|min:1',
            'patient_ids.*'  => 'exists:patients,id',
            'deskripsi'      => 'nullable|string',
            'images'         => 'nullable|array|max:20',
            'images.*'       => 'image|max:5120',
            'images_camera'  => 'nullable|array|max:20',
            'images_camera.*'=> 'image|max:5120',
        ]);

        $now       = now();
        $batchUuid = Str::uuid()->toString();
        $imagePaths = [];

        $galleryFiles = $request->file('images') ?? [];
        $cameraFiles  = $request->file('images_camera') ?? [];
        foreach (array_merge($galleryFiles, $cameraFiles) as $file) {
            $imagePaths[] = $file->store('patient-activities', 'public');
        }

        $imageJson = !empty($imagePaths) ? json_encode($imagePaths) : null;

        foreach ($validated['patient_ids'] as $patientId) {
            PatientActivity::create([
                'patient_id'      => $patientId,
                'tanggal'         => $now->toDateString(),
                'waktu_mulai'     => $now->format('H:i:s'),
                'jenis_aktivitas' => 'lainnya',
                'deskripsi'       => $validated['deskripsi'] ?? null,
                'image'           => $imageJson,
                'batch_uuid'      => $batchUuid,
            ]);
        }

        $count = count($validated['patient_ids']);
        return redirect()->route('dashboard.patient-activities.index')
            ->with('success', $count === 1
                ? 'Aktivitas pasien berhasil disimpan.'
                : "Aktivitas berhasil disimpan untuk {$count} pasien.");
    }

    public function create()
    {
        $user     = Auth::user();
        $patients = Patient::orderBy('nama_lengkap')->get();
        return view('dashboard.patient-activities.create', compact('user', 'patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id'      => 'required|exists:patients,id',
            'tanggal'         => 'required|date',
            'jenis_aktivitas' => 'required|in:terapi,senam,keterampilan,ibadah,rekreasi,lainnya',
            'deskripsi'       => 'nullable|string',
            'hasil_evaluasi'  => 'nullable|string',
            'waktu_mulai'     => 'nullable|date_format:H:i',
            'waktu_selesai'   => 'nullable|date_format:H:i',
            'durasi_menit'    => 'nullable|integer|min:0|max:1440',
            'tempat'          => 'nullable|string|max:255',
        ]);

        PatientActivity::create($validated);

        return redirect()->route('dashboard.patient-activities.index')
            ->with('success', 'Aktivitas pasien berhasil ditambahkan.');
    }

    public function show(PatientActivity $patient_activity)
    {
        $user            = Auth::user();
        $patient_activity->load('patient');
        $patientActivity = $patient_activity;
        $relatedActivities = PatientActivity::where('patient_id', $patient_activity->patient_id)
            ->where('id', '!=', $patient_activity->id)
            ->orderByDesc('tanggal')
            ->limit(5)
            ->get();
        return view('dashboard.patient-activities.show', compact('user', 'patientActivity', 'relatedActivities'));
    }

    public function edit(PatientActivity $patient_activity)
    {
        $user            = Auth::user();
        $patients        = Patient::orderBy('nama_lengkap')->get();
        $patient_activity->load('patient');
        $patientActivity = $patient_activity;
        return view('dashboard.patient-activities.edit', compact('user', 'patientActivity', 'patients'));
    }

    public function update(Request $request, PatientActivity $patient_activity)
    {
        $validated = $request->validate([
            'patient_id'      => 'required|exists:patients,id',
            'tanggal'         => 'required|date',
            'jenis_aktivitas' => 'required|in:terapi,senam,keterampilan,ibadah,rekreasi,lainnya',
            'deskripsi'       => 'nullable|string',
            'hasil_evaluasi'  => 'nullable|string',
            'waktu_mulai'     => 'nullable|date_format:H:i',
            'waktu_selesai'   => 'nullable|date_format:H:i',
            'durasi_menit'    => 'nullable|integer|min:0|max:1440',
            'tempat'          => 'nullable|string|max:255',
        ]);

        $patient_activity->update($validated);

        return redirect()->route('dashboard.patient-activities.index')
            ->with('success', 'Aktivitas pasien berhasil diperbarui.');
    }

    public function destroy(PatientActivity $patient_activity)
    {
        $patient_activity->delete();

        return redirect()->route('dashboard.patient-activities.index')
            ->with('success', 'Aktivitas pasien berhasil dihapus.');
    }

    public function duplicate(PatientActivity $patient_activity)
    {
        $new = $patient_activity->replicate();
        $new->tanggal = now();
        $new->save();

        return redirect()->route('dashboard.patient-activities.edit', $new)
            ->with('success', 'Aktivitas berhasil diduplikasi. Silakan sesuaikan data jika perlu.');
    }
}
