@extends('layouts.dashboard')

@section('title', 'Edit Riwayat Pemeriksaan')
@section('topbar-title', 'Edit Riwayat Pemeriksaan')

@section('content')
<div class="card rw-form-card">

    {{-- Card Topbar --}}
    <div class="rw-form-topbar">
        <div class="rw-form-topbar-left">
            <a href="{{ route('dashboard.riwayat-pemeriksaan.index') }}" class="rw-back-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <span class="rw-breadcrumb-sep">›</span>
            <span class="rw-breadcrumb-current">Edit Riwayat Pemeriksaan</span>
        </div>
        <a href="{{ route('dashboard.riwayat-pemeriksaan.show', $examination_history) }}" class="rw-detail-link">
            Lihat Detail
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
    </div>

    {{-- Form Header --}}
    <div class="rw-form-header rw-form-header-edit">
        <div class="rw-form-header-icon rw-header-icon-edit">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        </div>
        <div>
            <h2 class="rw-form-title">Edit Riwayat Pemeriksaan</h2>
            <p class="rw-form-subtitle">
                Pasien:
                <strong>{{ $examination_history->patient->nama_lengkap ?? '–' }}</strong>
                &nbsp;·&nbsp;
                {{ $examination_history->tanggal_pemeriksaan->translatedFormat('d F Y') }}
            </p>
        </div>
    </div>

    <form action="{{ route('dashboard.riwayat-pemeriksaan.update', $examination_history) }}" method="POST" class="rw-form">
        @csrf
        @method('PUT')

        {{-- Section 1: Informasi Dasar --}}
        <div class="rw-section-block">
            <div class="rw-section-head">
                <div class="rw-section-num">1</div>
                <div>
                    <span class="rw-section-title">Informasi Pasien &amp; Waktu</span>
                    <p class="rw-section-desc">Pilih pasien dan waktu pemeriksaan berlangsung</p>
                </div>
            </div>

            <div class="rw-grid-2">
                <div class="rw-form-group rw-col-full">
                    <label class="rw-label">
                        Nama Pasien
                        <span class="rw-required">*</span>
                    </label>
                    <div class="rw-select-wrap">
                        <svg class="rw-select-icon" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <select name="patient_id" class="rw-select {{ $errors->has('patient_id') ? 'rw-invalid' : '' }}" required>
                            @foreach($patients as $p)
                                <option value="{{ $p->id }}" {{ old('patient_id', $examination_history->patient_id) == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('patient_id')<span class="rw-error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="rw-form-group">
                    <label class="rw-label">
                        Tanggal Pemeriksaan
                        <span class="rw-required">*</span>
                    </label>
                    <div class="rw-input-icon-wrap">
                        <svg class="rw-icon-left" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <input type="date" name="tanggal_pemeriksaan"
                            class="rw-input rw-input-padded {{ $errors->has('tanggal_pemeriksaan') ? 'rw-invalid' : '' }}"
                            value="{{ old('tanggal_pemeriksaan', $examination_history->tanggal_pemeriksaan->format('Y-m-d')) }}" required>
                    </div>
                    @error('tanggal_pemeriksaan')<span class="rw-error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="rw-form-group">
                    <label class="rw-label">
                        Tempat Pemeriksaan
                        <span class="rw-required">*</span>
                    </label>
                    <div class="rw-input-icon-wrap">
                        <svg class="rw-icon-left" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <input type="text" name="tempat_pemeriksaan"
                            class="rw-input rw-input-padded {{ $errors->has('tempat_pemeriksaan') ? 'rw-invalid' : '' }}"
                            value="{{ old('tempat_pemeriksaan', $examination_history->tempat_pemeriksaan) }}" required>
                    </div>
                    @error('tempat_pemeriksaan')<span class="rw-error-msg">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        {{-- Section 2: Detail Medis --}}
        <div class="rw-section-block">
            <div class="rw-section-head">
                <div class="rw-section-num rw-section-num-2">2</div>
                <div>
                    <span class="rw-section-title">Detail Medis</span>
                    <p class="rw-section-desc">Catatan medis yang diperoleh dari tenaga kesehatan</p>
                </div>
            </div>

            <div class="rw-grid-full">
                <div class="rw-form-group">
                    <label class="rw-label">
                        <span class="rw-label-icon rw-label-keluhan">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        </span>
                        Keluhan
                        <span class="rw-optional">(opsional)</span>
                    </label>
                    <textarea name="keluhan" rows="3"
                        class="rw-textarea {{ $errors->has('keluhan') ? 'rw-invalid' : '' }}">{{ old('keluhan', $examination_history->keluhan) }}</textarea>
                    @error('keluhan')<span class="rw-error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="rw-form-group">
                    <label class="rw-label">
                        <span class="rw-label-icon rw-label-hasil">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                        </span>
                        Hasil Pemeriksaan
                        <span class="rw-optional">(opsional)</span>
                    </label>
                    <textarea name="hasil_pemeriksaan" rows="3"
                        class="rw-textarea {{ $errors->has('hasil_pemeriksaan') ? 'rw-invalid' : '' }}">{{ old('hasil_pemeriksaan', $examination_history->hasil_pemeriksaan) }}</textarea>
                    @error('hasil_pemeriksaan')<span class="rw-error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="rw-form-group">
                    <label class="rw-label">
                        <span class="rw-label-icon rw-label-tindakan">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                        </span>
                        Tindakan / Obat
                        <span class="rw-optional">(opsional)</span>
                    </label>
                    <textarea name="tindakan_obat" rows="3"
                        class="rw-textarea {{ $errors->has('tindakan_obat') ? 'rw-invalid' : '' }}">{{ old('tindakan_obat', $examination_history->tindakan_obat) }}</textarea>
                    @error('tindakan_obat')<span class="rw-error-msg">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="rw-form-footer">
            <button type="submit" class="rw-submit-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                Simpan Perubahan
            </button>
            <a href="{{ route('dashboard.riwayat-pemeriksaan.show', $examination_history) }}" class="rw-cancel-btn">Batal</a>
        </div>

    </form>
</div>

@push('styles')
<style>
/* ─── Card ─────────────────────────────────────────── */
.rw-form-card { padding: 0; overflow: hidden; }

/* ─── Topbar ────────────────────────────────────────── */
.rw-form-topbar {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1rem 1.75rem; border-bottom: 1px solid var(--border);
    background: #f8fafc;
}
.rw-form-topbar-left { display: flex; align-items: center; gap: 0.5rem; }
.rw-back-btn {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 0.85rem; font-weight: 600; color: #64748b;
    text-decoration: none; padding: 4px 8px; border-radius: 7px;
    transition: all 0.15s;
}
.rw-back-btn:hover { color: #1e293b; background: #e2e8f0; }
.rw-breadcrumb-sep { color: #cbd5e1; font-size: 0.9rem; }
.rw-breadcrumb-current { font-size: 0.85rem; color: #334155; font-weight: 600; }
.rw-detail-link {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 0.82rem; font-weight: 600; color: #2563eb;
    text-decoration: none; padding: 5px 10px; border-radius: 8px;
    border: 1px solid #bfdbfe; background: #eff6ff;
    transition: all 0.15s;
}
.rw-detail-link:hover { background: #dbeafe; }

/* ─── Form Header ───────────────────────────────────── */
.rw-form-header {
    display: flex; align-items: center; gap: 1rem;
    padding: 1.5rem 1.75rem; border-bottom: 1px solid var(--border);
}
.rw-form-header-icon {
    width: 48px; height: 48px; flex-shrink: 0; border-radius: 12px;
    background: linear-gradient(135deg, #eff6ff, #dbeafe);
    display: flex; align-items: center; justify-content: center;
    color: #2563eb; border: 1px solid #bfdbfe;
}
.rw-header-icon-edit {
    background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    color: #16a34a; border-color: #bbf7d0;
}
.rw-form-title { font-size: 1.1rem; font-weight: 700; color: #0f172a; margin: 0 0 3px; }
.rw-form-subtitle { font-size: 0.82rem; color: #64748b; margin: 0; }
.rw-form-subtitle strong { color: #1e293b; }

/* ─── Form ──────────────────────────────────────────── */
.rw-form { max-width: 860px; }

/* ─── Section Block ─────────────────────────────────── */
.rw-section-block { padding: 1.5rem 1.75rem; border-bottom: 1px solid #f1f5f9; }
.rw-section-head { display: flex; align-items: flex-start; gap: 0.875rem; margin-bottom: 1.5rem; }
.rw-section-num {
    width: 28px; height: 28px; flex-shrink: 0; border-radius: 50%;
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    color: #fff; font-size: 0.8rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center; margin-top: 1px;
}
.rw-section-num-2 { background: linear-gradient(135deg, #7c3aed, #a78bfa); }
.rw-section-title { font-size: 0.9rem; font-weight: 700; color: #1e293b; display: block; margin-bottom: 2px; }
.rw-section-desc { font-size: 0.78rem; color: #94a3b8; margin: 0; }

/* ─── Grid ──────────────────────────────────────────── */
.rw-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
.rw-col-full { grid-column: 1 / -1; }
.rw-grid-full { display: flex; flex-direction: column; gap: 1.25rem; }

/* ─── Form Group ────────────────────────────────────── */
.rw-form-group { display: flex; flex-direction: column; gap: 6px; }
.rw-label { display: flex; align-items: center; gap: 6px; font-size: 0.875rem; font-weight: 600; color: #1e293b; }
.rw-required { color: #ef4444; font-weight: 700; }
.rw-optional { font-size: 0.75rem; font-weight: 400; color: #94a3b8; margin-left: 2px; }
.rw-label-icon { width: 20px; height: 20px; border-radius: 6px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
.rw-label-keluhan  { background: #fef3c7; color: #d97706; }
.rw-label-hasil    { background: #eff6ff; color: #2563eb; }
.rw-label-tindakan { background: #fdf2f8; color: #c026d3; }

/* ─── Inputs ────────────────────────────────────────── */
.rw-input-icon-wrap { position: relative; }
.rw-icon-left { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; pointer-events: none; }
.rw-input, .rw-select, .rw-textarea {
    width: 100%; padding: 0.625rem 0.875rem;
    border: 1.5px solid #cbd5e1; border-radius: 10px;
    font-size: 0.9rem; font-family: inherit; background: #fff; color: #1e293b;
    transition: border-color 0.15s, box-shadow 0.15s;
}
.rw-input:focus, .rw-select:focus, .rw-textarea:focus {
    outline: none; border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.12);
}
.rw-input-padded { padding-left: 36px; }
.rw-textarea { resize: vertical; min-height: 96px; line-height: 1.6; }
.rw-invalid { border-color: #ef4444 !important; }
.rw-invalid:focus { box-shadow: 0 0 0 3px rgba(239,68,68,0.12) !important; }
.rw-select-wrap { position: relative; }
.rw-select-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; pointer-events: none; z-index: 1; }
.rw-select { padding-left: 36px; -webkit-appearance: none; cursor: pointer; }
.rw-error-msg { font-size: 0.8rem; color: #dc2626; }

/* ─── Form Footer ───────────────────────────────────── */
.rw-form-footer {
    display: flex; align-items: center; gap: 0.875rem;
    padding: 1.5rem 1.75rem; background: #f8fafc; border-top: 1px solid var(--border);
}
.rw-submit-btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 0.65rem 1.5rem;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff; font-size: 0.925rem; font-weight: 700;
    border: none; border-radius: 10px; cursor: pointer; font-family: inherit;
    box-shadow: 0 2px 10px rgba(37,99,235,0.35);
    transition: all 0.18s ease;
}
.rw-submit-btn:hover {
    background: linear-gradient(135deg, #1d4ed8, #1e40af);
    box-shadow: 0 4px 16px rgba(37,99,235,0.45);
    transform: translateY(-1px);
}
.rw-cancel-btn {
    display: inline-flex; align-items: center;
    padding: 0.65rem 1.25rem;
    background: #fff; color: #64748b;
    font-size: 0.9rem; font-weight: 600;
    border: 1.5px solid #cbd5e1; border-radius: 10px;
    text-decoration: none; transition: all 0.15s;
}
.rw-cancel-btn:hover { background: #f1f5f9; color: #334155; border-color: #94a3b8; }

/* ─── Responsive ────────────────────────────────────── */
@media (max-width: 640px) {
    .rw-form-topbar, .rw-form-header, .rw-section-block, .rw-form-footer { padding: 1rem; }
    .rw-grid-2 { grid-template-columns: 1fr; }
    .rw-col-full { grid-column: 1; }
    .rw-submit-btn, .rw-cancel-btn { flex: 1; justify-content: center; }
}
</style>
@endpush
@endsection
