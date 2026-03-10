@extends('layouts.dashboard')

@section('title', 'Detail Riwayat Pemeriksaan')
@section('topbar-title', 'Detail Riwayat Pemeriksaan')

@section('content')
<div class="card rw-detail-card">

    {{-- Card Header --}}
    <div class="rw-detail-topbar">
        <div class="rw-detail-topbar-left">
            <a href="{{ route('dashboard.riwayat-pemeriksaan.index') }}" class="rw-back-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <span class="rw-breadcrumb-sep">›</span>
            <span class="rw-breadcrumb-current">Detail Riwayat Pemeriksaan</span>
        </div>
        <div class="rw-detail-topbar-right">
            <a href="{{ route('dashboard.riwayat-pemeriksaan.edit', $examination_history) }}" class="rw-topbar-btn rw-topbar-edit">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            <form action="{{ route('dashboard.riwayat-pemeriksaan.destroy', $examination_history) }}" method="POST"
                style="display:inline;" data-confirm="Yakin ingin menghapus riwayat pemeriksaan ini?">
                @csrf
                @method('DELETE')
                <button type="submit" class="rw-topbar-btn rw-topbar-hapus">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    {{-- Patient Banner --}}
    <div class="rw-patient-banner">
        <div class="rw-banner-avatar">
            {{ strtoupper(mb_substr($examination_history->patient->nama_lengkap ?? '?', 0, 1)) }}
        </div>
        <div class="rw-banner-info">
            <p class="rw-banner-label">Nama Pasien</p>
            <h2 class="rw-banner-name">{{ $examination_history->patient->nama_lengkap ?? '–' }}</h2>
            <div class="rw-banner-badges">
                <span class="rw-badge rw-badge-date">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    {{ $examination_history->tanggal_pemeriksaan->translatedFormat('d F Y') }}
                </span>
                <span class="rw-badge rw-badge-place">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    {{ $examination_history->tempat_pemeriksaan }}
                </span>
            </div>
        </div>
    </div>

    {{-- Medical Detail Sections --}}
    <div class="rw-sections">

        <div class="rw-section rw-section-keluhan">
            <div class="rw-section-header">
                <div class="rw-section-icon rw-icon-keluhan">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <div>
                    <span class="rw-section-label">Keluhan Pasien</span>
                    <p class="rw-section-sublabel">Yang disampaikan oleh pasien</p>
                </div>
            </div>
            <div class="rw-section-body">
                {{ $examination_history->keluhan ?: '–' }}
            </div>
        </div>

        <div class="rw-section rw-section-hasil">
            <div class="rw-section-header">
                <div class="rw-section-icon rw-icon-hasil">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                </div>
                <div>
                    <span class="rw-section-label">Hasil Pemeriksaan</span>
                    <p class="rw-section-sublabel">Diagnosis dari tenaga kesehatan</p>
                </div>
            </div>
            <div class="rw-section-body">
                {{ $examination_history->hasil_pemeriksaan ?: '–' }}
            </div>
        </div>

        <div class="rw-section rw-section-tindakan">
            <div class="rw-section-header">
                <div class="rw-section-icon rw-icon-tindakan">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                </div>
                <div>
                    <span class="rw-section-label">Tindakan / Obat</span>
                    <p class="rw-section-sublabel">Penanganan dan obat yang diberikan</p>
                </div>
            </div>
            <div class="rw-section-body">
                {{ $examination_history->tindakan_obat ?: '–' }}
            </div>
        </div>

    </div>

    {{-- Footer timestamp --}}
    <div class="rw-detail-footer">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        Dicatat pada {{ $examination_history->created_at->locale('id')->translatedFormat('d F Y, H:i') }} WIB
        @if($examination_history->updated_at->ne($examination_history->created_at))
            &nbsp;·&nbsp; Terakhir diperbarui {{ $examination_history->updated_at->locale('id')->diffForHumans() }}
        @endif
    </div>

</div>

@push('styles')
<style>
/* ─── Card ─────────────────────────────────────────── */
.rw-detail-card { padding: 0; overflow: hidden; }

/* ─── Topbar ────────────────────────────────────────── */
.rw-detail-topbar {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1.1rem 1.75rem; border-bottom: 1px solid var(--border);
    background: #f8fafc; flex-wrap: wrap; gap: 0.75rem;
}
.rw-detail-topbar-left { display: flex; align-items: center; gap: 0.5rem; }
.rw-back-btn {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 0.85rem; font-weight: 600; color: #64748b;
    text-decoration: none; padding: 4px 8px; border-radius: 7px;
    transition: all 0.15s;
}
.rw-back-btn:hover { color: #1e293b; background: #e2e8f0; }
.rw-breadcrumb-sep { color: #cbd5e1; font-size: 0.9rem; }
.rw-breadcrumb-current { font-size: 0.85rem; color: #334155; font-weight: 600; }
.rw-detail-topbar-right { display: flex; gap: 0.5rem; flex-wrap: wrap; }
.rw-topbar-btn {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 7px 14px; border-radius: 9px;
    font-size: 0.82rem; font-weight: 700;
    border: none; cursor: pointer; font-family: inherit;
    text-decoration: none; transition: all 0.16s ease;
}
.rw-topbar-edit { background: #eff6ff; color: #1d4ed8; border: 1.5px solid #bfdbfe; }
.rw-topbar-edit:hover { background: #2563eb; color: #fff; border-color: #2563eb; box-shadow: 0 2px 8px rgba(37,99,235,0.3); }
.rw-topbar-hapus { background: #fff5f5; color: #dc2626; border: 1.5px solid #fecaca; }
.rw-topbar-hapus:hover { background: #ef4444; color: #fff; border-color: #ef4444; box-shadow: 0 2px 8px rgba(239,68,68,0.3); }

/* ─── Patient Banner ────────────────────────────────── */
.rw-patient-banner {
    display: flex; align-items: center; gap: 1.25rem;
    padding: 1.75rem 1.75rem 1.5rem;
    border-bottom: 1px solid var(--border);
}
.rw-banner-avatar {
    width: 62px; height: 62px; flex-shrink: 0; border-radius: 50%;
    background: linear-gradient(135deg, #2563eb, #0ea5e9);
    color: #fff; font-size: 1.6rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 4px 16px rgba(37,99,235,0.3);
}
.rw-banner-label { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: #94a3b8; margin-bottom: 3px; }
.rw-banner-name { font-size: 1.25rem; font-weight: 700; color: #0f172a; margin-bottom: 0.6rem; }
.rw-banner-badges { display: flex; flex-wrap: wrap; gap: 0.5rem; }
.rw-badge {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 0.8rem; font-weight: 600; padding: 5px 12px; border-radius: 8px;
}
.rw-badge-date { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
.rw-badge-place { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }

/* ─── Medical Sections ──────────────────────────────── */
.rw-sections { display: flex; flex-direction: column; gap: 1rem; padding: 1.5rem 1.75rem; }
.rw-section {
    border-radius: 14px; overflow: hidden;
    border: 1.5px solid #e2e8f0;
}
.rw-section-header {
    display: flex; align-items: center; gap: 0.875rem;
    padding: 1rem 1.25rem; border-bottom: 1px solid #f1f5f9;
    background: #f8fafc;
}
.rw-section-icon {
    width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
}
.rw-icon-keluhan { background: #fef3c7; color: #d97706; }
.rw-icon-hasil { background: #eff6ff; color: #2563eb; }
.rw-icon-tindakan { background: #fdf2f8; color: #c026d3; }
.rw-section-label { font-size: 0.875rem; font-weight: 700; color: #1e293b; display: block; }
.rw-section-sublabel { font-size: 0.75rem; color: #94a3b8; margin: 0; }
.rw-section-body {
    padding: 1.1rem 1.25rem;
    font-size: 0.925rem; color: #374151; line-height: 1.7;
    white-space: pre-wrap; background: #fff;
}

/* ─── Footer ────────────────────────────────────────── */
.rw-detail-footer {
    display: flex; align-items: center; gap: 6px;
    padding: 1rem 1.75rem;
    font-size: 0.8rem; color: #94a3b8;
    border-top: 1px solid var(--border); background: #f8fafc;
}

/* ─── Responsive ────────────────────────────────────── */
@media (max-width: 640px) {
    .rw-detail-topbar { padding: 1rem; }
    .rw-patient-banner { padding: 1.25rem; flex-direction: column; align-items: flex-start; }
    .rw-sections { padding: 1rem; }
    .rw-detail-topbar-right { width: 100%; }
    .rw-topbar-btn { flex: 1; justify-content: center; }
}
</style>
@endpush
@endsection
