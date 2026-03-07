@extends('layouts.dashboard')

@section('title', 'Detail Pasien')
@section('topbar-title', 'Detail Pasien')

@section('content')
<div class="card patient-detail-card">
    <div class="patient-detail-header">
        <div class="patient-detail-foto-wrap">
            @if($patient->foto_url)
                <img src="{{ asset('storage/' . $patient->foto) }}" alt="Foto {{ $patient->nama_lengkap }}" class="patient-detail-foto" loading="lazy">
            @else
                <div class="patient-detail-foto-placeholder">
                    <span class="patient-detail-initial">{{ strtoupper(mb_substr($patient->nama_lengkap, 0, 1)) }}</span>
                    <span class="patient-detail-foto-label">Identitas</span>
                </div>
            @endif
        </div>
        <div class="patient-detail-header-info">
            <h2 class="patient-detail-name">{{ $patient->nama_lengkap }}</h2>
            <div class="patient-detail-actions">
                <a href="{{ route('dashboard.patient-activities.index', ['patient_id' => $patient->id]) }}" class="btn btn-outline" title="Lihat aktivitas pasien ini">📋 Aktivitas</a>
                <a href="{{ route('dashboard.patients.edit', $patient) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('dashboard.patients.destroy', $patient) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus pasien {{ $patient->nama_lengkap }}?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
                <a href="{{ route('dashboard.patients.index') }}" class="btn btn-outline">← Kembali</a>
            </div>
        </div>
    </div>
    <div class="card-title" style="margin-top:1.5rem;padding-top:1rem;border-top:1px solid var(--border);">Data Lengkap</div>
    <div class="patient-detail-grid">
        <div class="info-item"><span class="info-key">Nama Lengkap</span><span class="info-val">{{ $patient->nama_lengkap }}</span></div>
        <div class="info-item"><span class="info-key">Tempat Lahir</span><span class="info-val">{{ $patient->tempat_lahir ?? '-' }}</span></div>
        <div class="info-item"><span class="info-key">Tanggal Lahir</span><span class="info-val">{{ $patient->tanggal_lahir?->translatedFormat('d F Y') ?? '-' }}</span></div>
        <div class="info-item"><span class="info-key">Umur</span><span class="info-val">{{ $patient->umur ? $patient->umur . ' tahun' : '-' }}</span></div>
        <div class="info-item"><span class="info-key">Jenis Kelamin</span><span class="info-val">{{ $patient->jenis_kelamin_label }}</span></div>
        <div class="info-item"><span class="info-key">Tanggal Masuk</span><span class="info-val">{{ $patient->tanggal_masuk->translatedFormat('d F Y') }}</span></div>
        <div class="info-item"><span class="info-key">Status</span><span class="info-val">
            @if ($patient->status === 'aktif')
                <span class="badge badge-paid">Aktif</span>
            @elseif ($patient->status === 'selesai')
                <span class="badge badge-cancel">Selesai</span>
            @else
                <span class="badge badge-pending">Dirujuk</span>
            @endif
        </span></div>
    </div>
</div>

@push('styles')
<style>
.patient-detail-header {
    display: flex; align-items: center; gap: 2rem; flex-wrap: wrap;
}
.patient-detail-foto-wrap {
    flex-shrink: 0;
    width: 160px; height: 160px; border-radius: 50%;
    overflow: hidden; border: 4px solid var(--border);
    box-shadow: 0 8px 32px rgba(59,130,246,0.2);
    background: linear-gradient(135deg, #f8fafc, #e2e8f0);
}
.patient-detail-foto {
    width: 100%; height: 100%; object-fit: cover;
}
.patient-detail-foto-placeholder {
    width: 100%; height: 100%;
    background: linear-gradient(135deg, var(--primary), var(--accent));
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    color: white; text-align: center;
}
.patient-detail-initial { font-size: 4rem; font-weight: 800; line-height: 1; }
.patient-detail-foto-label { font-size: 0.75rem; opacity: 0.9; margin-top: 0.25rem; }
.patient-detail-header-info { flex: 1; min-width: 200px; }
.patient-detail-name { font-size: 1.5rem; font-weight: 700; color: var(--text); margin-bottom: 0.25rem; }
.patient-detail-kode { font-size: 0.9rem; font-family: monospace; color: var(--text-muted); margin-bottom: 1rem; }
.patient-detail-actions { display: flex; gap: 0.5rem; flex-wrap: wrap; }
.patient-detail-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 0.5rem; }
.btn-primary { background: linear-gradient(135deg, var(--primary), var(--accent)); color: white; padding: 0.5rem 1rem; }
.btn-outline { background: transparent; border: 1px solid var(--border); color: var(--text); padding: 0.5rem 1rem; }
</style>
@endpush
@endsection
