@extends('layouts.dashboard')

@section('title', 'Detail Pasien')
@section('topbar-title', 'Detail Pasien')

@section('content')
<a href="{{ route('dashboard.patients.index') }}" class="page-back-link">Kembali ke Data Pasien</a>
<div class="card">
    <div class="card-title">Detail Data Pasien — {{ $patient->nama_lengkap }}</div>
    <div class="patient-detail-layout">
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
        <div class="patient-detail-form-grid">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <div class="form-group-value">{{ $patient->nama_lengkap }}</div>
            </div>
            <div class="form-group">
                <label>Tempat Lahir</label>
                <div class="form-group-value">{{ $patient->tempat_lahir ?? '-' }}</div>
            </div>
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <div class="form-group-value">{{ $patient->tanggal_lahir?->translatedFormat('d F Y') ?? '-' }}</div>
            </div>
            <div class="form-group">
                <label>Umur</label>
                <div class="form-group-value">{{ $patient->umur ? $patient->umur . ' tahun' : '-' }}</div>
            </div>
            <div class="form-group">
                <label>Jenis Kelamin</label>
                <div class="form-group-value">{{ $patient->jenis_kelamin_label }}</div>
            </div>
            <div class="form-group">
                <label>Tanggal Masuk</label>
                <div class="form-group-value">{{ $patient->tanggal_masuk->translatedFormat('d F Y') }}</div>
            </div>
            @if($patient->tanggal_keluar)
            <div class="form-group">
                <label>Tanggal Keluar</label>
                <div class="form-group-value">{{ $patient->tanggal_keluar->translatedFormat('d F Y') }}</div>
            </div>
            @endif
            <div class="form-group">
                <label>Status</label>
                <div class="form-group-value">
                    @if ($patient->status === 'aktif')
                        <span class="badge badge-paid">Aktif</span>
                    @elseif ($patient->status === 'selesai')
                        <span class="badge badge-cancel">Selesai</span>
                    @else
                        <span class="badge badge-pending">Dirujuk</span>
                    @endif
                </div>
            </div>
            <div class="form-group form-group-deskripsi-full">
                <label>Deskripsi Pasien</label>
                <div class="form-group-value form-group-value-deskripsi">{{ $patient->deskripsi ? nl2br(e($patient->deskripsi)) : '-' }}</div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <a href="{{ route('dashboard.patient-activities.index', ['patient_id' => $patient->id]) }}" class="btn btn-outline" title="Lihat aktivitas pasien ini">📋 Aktivitas</a>
        <a href="{{ route('dashboard.patients.edit', $patient) }}" class="btn btn-primary">Edit</a>
        <form action="{{ route('dashboard.patients.destroy', $patient) }}" method="POST" style="display:inline;" data-confirm="Yakin ingin menghapus pasien {{ $patient->nama_lengkap }}?">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
        <a href="{{ route('dashboard.patients.index') }}" class="btn btn-outline">← Kembali</a>
    </div>
</div>

@push('styles')
<style>
.patient-detail-layout {
    display: flex;
    gap: 2rem;
    align-items: flex-start;
    flex-wrap: wrap;
    margin-bottom: 1.5rem;
}
.patient-detail-foto-wrap {
    flex-shrink: 0;
    width: 160px;
    height: 160px;
    border-radius: 50%;
    overflow: hidden;
    border: 3px solid var(--border);
    box-shadow: 0 8px 32px rgba(59,130,246,0.2);
    background: linear-gradient(135deg, #f8fafc, #e2e8f0);
}
.patient-detail-foto {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.patient-detail-foto-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--primary), var(--accent));
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: white;
    text-align: center;
}
.patient-detail-initial { font-size: 4rem; font-weight: 800; line-height: 1; }
.patient-detail-foto-label { font-size: 0.75rem; opacity: 0.9; margin-top: 0.25rem; }
.patient-detail-form-grid {
    flex: 1;
    min-width: 280px;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1.25rem;
}
.patient-detail-form-grid .form-group label {
    display: block;
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--text-muted);
    margin-bottom: 0.4rem;
}
.form-group-deskripsi-full { grid-column: 1 / -1; }
.form-group-value-deskripsi { white-space: pre-wrap; line-height: 1.5; }
.form-group-value {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--text);
    padding: 0.5rem 0;
}
.form-actions {
    display: flex;
    gap: 0.75rem;
    align-items: center;
    flex-wrap: wrap;
    padding-top: 1.25rem;
    border-top: 1px solid var(--border);
}
.btn-primary { background: linear-gradient(135deg, var(--primary), var(--accent)); color: white !important; padding: 0.5rem 1.25rem; border-radius: 10px; border: none; font-weight: 600; text-decoration: none; display: inline-block; }
.btn-outline { background: transparent; border: 1px solid var(--border); color: var(--text); padding: 0.5rem 1.25rem; border-radius: 10px; font-weight: 500; text-decoration: none; display: inline-block; }
.btn-danger { background: #dc2626; color: white !important; padding: 0.5rem 1.25rem; border-radius: 10px; border: none; font-weight: 600; cursor: pointer; }
@media (max-width: 640px) {
    .patient-detail-layout { flex-direction: column; align-items: center; justify-content: center; }
    .patient-detail-foto-wrap { width: 140px; height: 140px; }
    .patient-detail-form-grid { width: 100%; grid-template-columns: 1fr; }
    .form-actions { justify-content: center; }
}
</style>
@endpush
@endsection
