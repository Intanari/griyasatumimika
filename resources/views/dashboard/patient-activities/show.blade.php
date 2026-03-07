@extends('layouts.dashboard')

@section('title', 'Detail Aktivitas Pasien')
@section('topbar-title', 'Detail Aktivitas Pasien')

@section('content')
<div class="card rw-detail-card">

    <div class="rw-detail-topbar">
        <div class="rw-detail-topbar-left">
            <a href="{{ route('dashboard.patient-activities.index') }}" class="rw-back-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <span class="rw-breadcrumb-sep">›</span>
            <span class="rw-breadcrumb-current">Detail Aktivitas Pasien</span>
        </div>
        <div class="rw-detail-topbar-right">
            <a href="{{ route('dashboard.patient-activities.duplicate', $patientActivity) }}" class="rw-topbar-btn rw-topbar-copy">Duplikat</a>
            <a href="{{ route('dashboard.patient-activities.edit', $patientActivity) }}" class="rw-topbar-btn rw-topbar-edit">Edit</a>
            <form action="{{ route('dashboard.patient-activities.destroy', $patientActivity) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus aktivitas ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="rw-topbar-btn rw-topbar-hapus">Hapus</button>
            </form>
        </div>
    </div>

    <div class="rw-patient-banner">
        <div class="rw-banner-avatar">
            {{ strtoupper(mb_substr($patientActivity->patient->nama_lengkap ?? '?', 0, 1)) }}
        </div>
        <div class="rw-banner-info">
            <p class="rw-banner-label">Nama Pasien</p>
            <h2 class="rw-banner-name">
                <a href="{{ route('dashboard.patients.show', $patientActivity->patient) }}" class="rw-banner-name-link">{{ $patientActivity->patient->nama_lengkap ?? '–' }}</a>
                <a href="{{ route('dashboard.patient-activities.index', ['patient_id' => $patientActivity->patient_id]) }}" class="rw-banner-badge-link">Lihat semua aktivitas →</a>
            </h2>
            <div class="rw-banner-badges">
                <span class="rw-badge rw-badge-date">{{ $patientActivity->tanggal->translatedFormat('d F Y') }}</span>
                <span class="rw-badge rw-badge-jenis rw-badge-{{ $patientActivity->jenis_aktivitas }}">{{ $patientActivity->jenis_aktivitas_label }}</span>
                @if($patientActivity->tempat)
                    <span class="rw-badge rw-badge-place">{{ $patientActivity->tempat }}</span>
                @endif
            </div>
        </div>
    </div>

    <div class="rw-sections">
        @if($patientActivity->waktu_mulai || $patientActivity->waktu_selesai || $patientActivity->durasi_menit)
        <div class="rw-section">
            <div class="rw-section-header">
                <div class="rw-section-icon rw-icon-time">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div>
                    <span class="rw-section-label">Waktu &amp; Durasi</span>
                </div>
            </div>
            <div class="rw-section-body">
                @if($patientActivity->waktu_mulai)
                    Waktu: {{ \Carbon\Carbon::parse($patientActivity->waktu_mulai)->format('H:i') }}
                    @if($patientActivity->waktu_selesai)
                        – {{ \Carbon\Carbon::parse($patientActivity->waktu_selesai)->format('H:i') }}
                    @endif
                    @if($patientActivity->durasi_menit) · @endif
                @endif
                @if($patientActivity->durasi_menit)
                    Durasi: {{ $patientActivity->durasi_menit }} menit
                @endif
            </div>
        </div>
        @endif

        <div class="rw-section">
            <div class="rw-section-header">
                <div class="rw-section-icon rw-icon-desc">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                </div>
                <div>
                    <span class="rw-section-label">Deskripsi Aktivitas</span>
                </div>
            </div>
            <div class="rw-section-body">
                {{ $patientActivity->deskripsi ?: '–' }}
            </div>
        </div>

        @if($patientActivity->hasil_evaluasi)
        <div class="rw-section">
            <div class="rw-section-header">
                <div class="rw-section-icon rw-icon-eval">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <div>
                    <span class="rw-section-label">Hasil Evaluasi / Capaian</span>
                </div>
            </div>
            <div class="rw-section-body">
                {{ $patientActivity->hasil_evaluasi }}
            </div>
        </div>
        @endif
    </div>

    {{-- Related Activities --}}
    @if(isset($relatedActivities) && $relatedActivities->isNotEmpty())
    <div class="rw-related-wrap">
        <h3 class="rw-related-title">Aktivitas lain dari pasien ini</h3>
        <div class="rw-related-list">
            @foreach($relatedActivities as $rel)
            <a href="{{ route('dashboard.patient-activities.show', $rel) }}" class="rw-related-item">
                <span class="rw-related-date">{{ $rel->tanggal->translatedFormat('d M Y') }}</span>
                <span class="rw-badge rw-badge-jenis rw-badge-{{ $rel->jenis_aktivitas }}">{{ $rel->jenis_aktivitas_label }}</span>
                <span class="rw-related-desc">{{ $rel->deskripsi ? Str::limit($rel->deskripsi, 50) : '–' }}</span>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <div class="rw-detail-footer">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        Dicatat pada {{ $patientActivity->created_at->locale('id')->translatedFormat('d F Y, H:i') }} WIB
        @if($patientActivity->updated_at->ne($patientActivity->created_at))
            · Terakhir diperbarui {{ $patientActivity->updated_at->locale('id')->diffForHumans() }}
        @endif
    </div>
</div>

@push('styles')
<style>
.rw-detail-card { padding: 0; overflow: hidden; }
.rw-detail-topbar { display: flex; align-items: center; justify-content: space-between; padding: 1.1rem 1.75rem; border-bottom: 1px solid var(--border); background: #f8fafc; flex-wrap: wrap; gap: 0.75rem; }
.rw-detail-topbar-left { display: flex; align-items: center; gap: 0.5rem; }
.rw-back-btn { display: inline-flex; align-items: center; gap: 4px; font-size: 0.85rem; font-weight: 600; color: #64748b; text-decoration: none; padding: 4px 8px; border-radius: 7px; transition: all 0.15s; }
.rw-back-btn:hover { color: #1e293b; background: #e2e8f0; }
.rw-breadcrumb-sep { color: #cbd5e1; }
.rw-breadcrumb-current { font-size: 0.85rem; color: #334155; font-weight: 600; }
.rw-detail-topbar-right { display: flex; gap: 0.5rem; }
.rw-topbar-btn { display: inline-flex; padding: 7px 14px; border-radius: 9px; font-size: 0.82rem; font-weight: 700; border: none; cursor: pointer; font-family: inherit; text-decoration: none; transition: all 0.16s; }
.rw-topbar-edit { background: #eff6ff; color: #1d4ed8; border: 1.5px solid #bfdbfe; }
.rw-topbar-edit:hover { background: #2563eb; color: #fff; }
.rw-topbar-hapus { background: #fff5f5; color: #dc2626; border: 1.5px solid #fecaca; }
.rw-topbar-hapus:hover { background: #ef4444; color: #fff; }
.rw-topbar-copy { background: #f0fdf4; color: #15803d; border: 1.5px solid #bbf7d0; }
.rw-topbar-copy:hover { background: #22c55e; color: #fff; }
.rw-banner-name { display: flex; flex-direction: column; gap: 0.25rem; }
.rw-banner-name-link { color: inherit; text-decoration: none; }
.rw-banner-name-link:hover { color: #2563eb; }
.rw-banner-badge-link { font-size: 0.75rem; font-weight: 600; color: #2563eb; text-decoration: none; }
.rw-banner-badge-link:hover { text-decoration: underline; }
.rw-icon-eval { background: #dcfce7; color: #15803d; }
.rw-related-wrap { padding: 1.5rem 1.75rem; border-top: 1px solid var(--border); background: #f8fafc; }
.rw-related-title { font-size: 0.9rem; font-weight: 700; color: var(--text); margin-bottom: 1rem; }
.rw-related-list { display: flex; flex-direction: column; gap: 0.5rem; }
.rw-related-item { display: flex; align-items: center; gap: 1rem; padding: 0.875rem 1rem; background: #fff; border-radius: 12px; border: 1px solid var(--border); text-decoration: none; color: inherit; transition: all 0.15s; }
.rw-related-item:hover { border-color: #2563eb; box-shadow: 0 2px 8px rgba(37,99,235,0.12); }
.rw-related-date { font-size: 0.8rem; font-weight: 600; color: #64748b; min-width: 90px; }
.rw-related-desc { font-size: 0.85rem; color: #475569; flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.rw-patient-banner { display: flex; align-items: center; gap: 1.25rem; padding: 1.75rem 1.75rem 1.5rem; border-bottom: 1px solid var(--border); }
.rw-banner-avatar { width: 62px; height: 62px; flex-shrink: 0; border-radius: 50%; background: linear-gradient(135deg, #2563eb, #0ea5e9); color: #fff; font-size: 1.6rem; font-weight: 700; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 16px rgba(37,99,235,0.3); }
.rw-banner-label { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: #94a3b8; margin-bottom: 3px; }
.rw-banner-name { font-size: 1.25rem; font-weight: 700; color: #0f172a; margin-bottom: 0.6rem; }
.rw-banner-badges { display: flex; flex-wrap: wrap; gap: 0.5rem; }
.rw-badge { display: inline-flex; align-items: center; font-size: 0.8rem; font-weight: 600; padding: 5px 12px; border-radius: 8px; }
.rw-badge-date { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
.rw-badge-place { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
.rw-badge-jenis { padding: 4px 10px; }
.rw-badge-terapi { background: #dbeafe; color: #1d4ed8; }
.rw-badge-senam { background: #dcfce7; color: #15803d; }
.rw-badge-keterampilan { background: #fef3c7; color: #b45309; }
.rw-badge-ibadah { background: #f3e8ff; color: #7c3aed; }
.rw-badge-rekreasi { background: #e0f2fe; color: #0369a1; }
.rw-badge-lainnya { background: #f1f5f9; color: #475569; }
.rw-sections { display: flex; flex-direction: column; gap: 1rem; padding: 1.5rem 1.75rem; }
.rw-section { border-radius: 14px; overflow: hidden; border: 1.5px solid #e2e8f0; }
.rw-section-header { display: flex; align-items: center; gap: 0.875rem; padding: 1rem 1.25rem; border-bottom: 1px solid #f1f5f9; background: #f8fafc; }
.rw-section-icon { width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
.rw-icon-time { background: #eff6ff; color: #2563eb; }
.rw-icon-desc { background: #fef3c7; color: #d97706; }
.rw-section-label { font-size: 0.875rem; font-weight: 700; color: #1e293b; }
.rw-section-body { padding: 1.1rem 1.25rem; font-size: 0.925rem; color: #374151; line-height: 1.7; white-space: pre-wrap; background: #fff; }
.rw-detail-footer { display: flex; align-items: center; gap: 6px; padding: 1rem 1.75rem; font-size: 0.8rem; color: #94a3b8; border-top: 1px solid var(--border); background: #f8fafc; }
</style>
@endpush
@endsection
