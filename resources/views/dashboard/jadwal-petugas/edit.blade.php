@extends('layouts.dashboard')

@section('title', 'Edit Jadwal Petugas')
@section('topbar-title', 'Edit Jadwal Petugas')

@section('content')
<nav class="jp-breadcrumb" aria-label="Breadcrumb">
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <span class="jp-breadcrumb-sep">/</span>
    <a href="{{ route('dashboard.jadwal-petugas.index') }}">Jadwal Petugas</a>
    <span class="jp-breadcrumb-sep">/</span>
    <span class="jp-breadcrumb-current">Edit Jadwal</span>
</nav>

<div class="card jadwal-form-card">
    <div class="jadwal-form-header">
        <a href="{{ route('dashboard.jadwal-petugas.index') }}" class="jadwal-back-link">← Kembali ke Daftar</a>
        <div class="jadwal-form-header-main">
            <div class="jadwal-form-icon jadwal-form-icon-edit">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </div>
            <div>
                <h2 class="jadwal-form-title">Edit Jadwal Petugas</h2>
                <p class="jadwal-form-subtitle">{{ $jadwal->user->name ?? 'Petugas' }} · {{ $jadwal->tanggal?->translatedFormat('d M Y') }}</p>
            </div>
        </div>
    </div>

    <form action="{{ route('dashboard.jadwal-petugas.update', $jadwal) }}" method="POST" class="jadwal-form">
        @csrf
        @method('PUT')
        <div class="rw-form-grid">
            <div class="rw-form-group rw-col-full">
                <label class="rw-label">Petugas <span class="rw-required">*</span></label>
                <select name="user_id" class="rw-input {{ $errors->has('user_id') ? 'rw-invalid' : '' }}" required>
                    @foreach($petugasList as $p)
                        <option value="{{ $p->id }}" {{ old('user_id', $jadwal->user_id) == $p->id ? 'selected' : '' }}>{{ $p->name }}{{ $p->jabatan ? ' (' . $p->jabatan . ')' : '' }}</option>
                    @endforeach
                </select>
                @error('user_id')<span class="rw-error">{{ $message }}</span>@enderror
            </div>

            <div class="rw-form-group">
                <label class="rw-label">Tanggal <span class="rw-required">*</span></label>
                <input type="date" name="tanggal" value="{{ old('tanggal', $jadwal->tanggal?->format('Y-m-d')) }}" class="rw-input {{ $errors->has('tanggal') ? 'rw-invalid' : '' }}" required>
                @error('tanggal')<span class="rw-error">{{ $message }}</span>@enderror
            </div>

            <div class="rw-form-group">
                <label class="rw-label">Shift <span class="rw-required">*</span></label>
                <select name="shift_id" class="rw-input {{ $errors->has('shift_id') ? 'rw-invalid' : '' }}" required>
                    @foreach($shifts as $s)
                        <option value="{{ $s->id }}" {{ old('shift_id', $selectedShiftId ?? $jadwal->shift_id ?? '') == $s->id ? 'selected' : '' }}>{{ $s->nama }} ({{ \Carbon\Carbon::parse($s->jam_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($s->jam_selesai)->format('H:i') }})</option>
                    @endforeach
                </select>
                @error('shift_id')<span class="rw-error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="jadwal-form-actions">
            <button type="submit" class="jadwal-btn-submit">Simpan Perubahan</button>
            <a href="{{ route('dashboard.jadwal-petugas.index') }}" class="jadwal-btn-cancel">Batal</a>
        </div>
    </form>
</div>

@push('styles')
<style>
.jadwal-form-card { padding: 0; overflow: hidden; }
.jadwal-form-header { padding: 1.25rem 1.75rem; border-bottom: 1px solid var(--border); background: #f8fafc; }
.jadwal-back-link { display: inline-block; font-size: 0.85rem; font-weight: 600; color: #64748b; margin-bottom: 0.75rem; text-decoration: none; }
.jadwal-back-link:hover { color: var(--primary); }
.jadwal-form-header-main { display: flex; align-items: center; gap: 1rem; }
.jadwal-form-icon { width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, #eff6ff, #dbeafe); border: 1px solid #bfdbfe; display: flex; align-items: center; justify-content: center; color: var(--primary); }
.jadwal-form-icon-edit { background: linear-gradient(135deg, #f0fdf4, #dcfce7); border-color: #bbf7d0; color: #16a34a; }
.jp-breadcrumb { font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1rem; }
.jp-breadcrumb a { color: var(--primary); text-decoration: none; }
.jp-breadcrumb a:hover { text-decoration: underline; }
.jp-breadcrumb-sep { margin: 0 0.35rem; opacity: 0.6; }
.jp-breadcrumb-current { color: var(--text); font-weight: 600; }
.jadwal-form-title { font-size: 1.1rem; font-weight: 700; color: #0f172a; margin: 0 0 2px; }
.jadwal-form-subtitle { font-size: 0.82rem; color: #64748b; margin: 0; }
.jadwal-form { max-width: 860px; padding: 1.5rem 1.75rem; }
.jadwal-form .rw-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
.jadwal-form .rw-col-full { grid-column: 1 / -1; }
.jadwal-form .rw-form-group { display: flex; flex-direction: column; gap: 0.35rem; }
.jadwal-form .rw-label { font-size: 0.85rem; font-weight: 600; color: var(--text); }
.jadwal-form .rw-required { color: #dc2626; }
.jadwal-form .rw-input { padding: 0.55rem 0.875rem; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.9rem; font-family: inherit; background: #fff; width: 100%; }
.jadwal-form .rw-input:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.12); }
.jadwal-form .rw-invalid { border-color: #ef4444 !important; }
.jadwal-form .rw-error { font-size: 0.8rem; color: #dc2626; }
.jadwal-form-actions { display: flex; gap: 0.875rem; padding: 1.5rem 1.75rem; border-top: 1px solid var(--border); background: #f8fafc; }
.jadwal-btn-submit { display: inline-flex; align-items: center; gap: 6px; padding: 0.65rem 1.5rem; background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff; font-size: 0.925rem; font-weight: 700; border: none; border-radius: 10px; cursor: pointer; font-family: inherit; }
.jadwal-btn-submit:hover { background: linear-gradient(135deg, #1d4ed8, #1e40af); transform: translateY(-1px); }
.jadwal-btn-cancel { display: inline-flex; align-items: center; padding: 0.65rem 1.25rem; background: #fff; color: #64748b; font-size: 0.9rem; font-weight: 600; border: 1.5px solid #cbd5e1; border-radius: 10px; text-decoration: none; }
.jadwal-btn-cancel:hover { background: #f1f5f9; color: #334155; border-color: #94a3b8; }
@media (max-width: 640px) { .jadwal-form .rw-form-grid { grid-template-columns: 1fr; } .jadwal-form .rw-col-full { grid-column: 1; } }
</style>
@endpush
@endsection
