@extends('layouts.dashboard')

@section('title', 'Edit Shift')
@section('topbar-title', 'Edit Shift')

@section('content')
<div class="sf-page">
    <nav class="sf-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sf-breadcrumb-sep">/</span>
        <a href="{{ route('dashboard.jadwal-petugas.index') }}">Jadwal Petugas</a>
        <span class="sf-breadcrumb-sep">/</span>
        <a href="{{ route('dashboard.shifts.index') }}">Shift</a>
        <span class="sf-breadcrumb-sep">/</span>
        <span class="sf-breadcrumb-current">Edit</span>
    </nav>

    <div class="sf-card">
        <div class="sf-header">
            <div class="sf-header-main">
                <a href="{{ route('dashboard.shifts.index') }}" class="sf-back">← Kembali ke Shift</a>
                <div class="sf-header-icon sf-header-icon-edit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </div>
                <div>
                    <h2 class="sf-title">Edit Shift</h2>
                    <p class="sf-subtitle">{{ $shift->nama }}</p>
                </div>
            </div>
        </div>

        <form action="{{ route('dashboard.shifts.update', $shift) }}" method="POST" class="sf-form">
            @csrf
            @method('PUT')
            <div class="sf-form-grid">
                <div class="sf-form-group sf-col-full">
                    <label class="sf-label">Nama Shift <span class="sf-required">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $shift->nama) }}" class="sf-input {{ $errors->has('nama') ? 'sf-invalid' : '' }}" required>
                    @error('nama')<span class="sf-error">{{ $message }}</span>@enderror
                </div>
                <div class="sf-form-group">
                    <label class="sf-label">Jam Mulai <span class="sf-required">*</span></label>
                    <input type="time" name="jam_mulai" value="{{ old('jam_mulai', \Carbon\Carbon::parse($shift->jam_mulai)->format('H:i')) }}" class="sf-input {{ $errors->has('jam_mulai') ? 'sf-invalid' : '' }}" required>
                    @error('jam_mulai')<span class="sf-error">{{ $message }}</span>@enderror
                </div>
                <div class="sf-form-group">
                    <label class="sf-label">Jam Selesai <span class="sf-required">*</span></label>
                    <input type="time" name="jam_selesai" value="{{ old('jam_selesai', \Carbon\Carbon::parse($shift->jam_selesai)->format('H:i')) }}" class="sf-input {{ $errors->has('jam_selesai') ? 'sf-invalid' : '' }}" required>
                    @error('jam_selesai')<span class="sf-error">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="sf-form-actions">
                <button type="submit" class="sf-btn-primary">Simpan Perubahan</button>
                <a href="{{ route('dashboard.shifts.index') }}" class="sf-btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.sf-page { max-width: 640px; margin: 0 auto; padding: 0 0.5rem; font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; }
.sf-breadcrumb { font-size: 0.875rem; color: #64748b; margin-bottom: 1.5rem; }
.sf-breadcrumb a { color: var(--primary); text-decoration: none; font-weight: 500; }
.sf-breadcrumb a:hover { text-decoration: underline; }
.sf-breadcrumb-sep { margin: 0 0.35rem; opacity: 0.6; }
.sf-breadcrumb-current { color: #1e293b; font-weight: 600; }
.sf-card { background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.04); border: 1px solid #e2e8f0; }
.sf-header { padding: 1.5rem 2rem; border-bottom: 1px solid #e2e8f0; background: linear-gradient(180deg, #f8fafc 0%, #fff 100%); }
.sf-header-main { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
.sf-back { display: block; font-size: 0.85rem; font-weight: 600; color: #64748b; margin-bottom: 0.5rem; text-decoration: none; }
.sf-back:hover { color: var(--primary); }
.sf-header-icon { width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, rgba(59,130,246,0.12), rgba(14,165,233,0.08)); border: 1px solid rgba(59,130,246,0.2); color: var(--primary); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.sf-header-icon-edit { background: linear-gradient(135deg, rgba(245,158,11,0.12), rgba(251,191,36,0.08)); border-color: rgba(245,158,11,0.3); color: #b45309; }
.sf-title { font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 0; }
.sf-subtitle { font-size: 0.9rem; color: #64748b; margin: 4px 0 0; }
.sf-form { padding: 1.75rem 2rem; }
.sf-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
.sf-col-full { grid-column: 1 / -1; }
.sf-form-group { display: flex; flex-direction: column; gap: 0.4rem; }
.sf-label { font-size: 0.85rem; font-weight: 600; color: #334155; }
.sf-required { color: #dc2626; }
.sf-input { padding: 0.6rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 0.95rem; font-family: inherit; background: #fff; width: 100%; }
.sf-input:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.12); }
.sf-invalid { border-color: #ef4444 !important; }
.sf-error { font-size: 0.8rem; color: #dc2626; }
.sf-form-actions { display: flex; gap: 0.875rem; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #e2e8f0; }
.sf-btn-primary { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.65rem 1.5rem; background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff; font-size: 0.95rem; font-weight: 700; border: none; border-radius: 10px; cursor: pointer; font-family: inherit; }
.sf-btn-primary:hover { filter: brightness(1.05); }
.sf-btn-cancel { display: inline-flex; align-items: center; padding: 0.65rem 1.25rem; background: #fff; color: #64748b; font-size: 0.9rem; font-weight: 600; border: 1.5px solid #e2e8f0; border-radius: 10px; text-decoration: none; }
.sf-btn-cancel:hover { background: #f8fafc; color: #334155; border-color: #cbd5e1; }
@media (max-width: 520px) { .sf-form-grid { grid-template-columns: 1fr; } .sf-col-full { grid-column: 1; } }
</style>
@endpush
@endsection
