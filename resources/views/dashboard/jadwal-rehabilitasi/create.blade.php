@extends('layouts.dashboard')

@section('title', 'Tambah Jadwal Rehabilitasi')
@section('topbar-title', 'Tambah Jadwal Rehabilitasi')

@section('content')
<a href="{{ route('dashboard.jadwal-rehabilitasi.index') }}" class="page-back-link">Kembali ke Jadwal Rehabilitasi</a>
<div class="card jadwal-form-card">
    <div class="jadwal-form-header">
        <div class="jadwal-form-header-main">
            <div class="jadwal-form-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/><line x1="8" y1="7" x2="12" y2="7"/><line x1="8" y1="11" x2="12" y2="11"/></svg>
            </div>
            <div>
                <h2 class="jadwal-form-title">Tambah Jadwal Rehabilitasi</h2>
                <p class="jadwal-form-subtitle">Buat jadwal kegiatan rehabilitasi rutin mingguan. Petugas akan menerima notifikasi email.</p>
            </div>
        </div>
    </div>

    <form action="{{ route('dashboard.jadwal-rehabilitasi.store') }}" method="POST" class="jadwal-form">
        @csrf
        <div class="rw-form-grid">
            <div class="rw-form-group rw-col-full">
                <label class="rw-label">Nama Kegiatan <span class="rw-required">*</span></label>
                <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}" class="rw-input {{ $errors->has('nama_kegiatan') ? 'rw-invalid' : '' }}" placeholder="Contoh: Terapi Kelompok, Konseling Individu" required>
                @error('nama_kegiatan')<span class="rw-error">{{ $message }}</span>@enderror
            </div>
            <div class="rw-form-group">
                <label class="rw-label">Hari <span class="rw-required">*</span></label>
                <select name="hari" class="rw-input" required>
                    @foreach(\App\Models\RehabilitationSchedule::HARI_LIST as $val => $label)
                        <option value="{{ $val }}" {{ old('hari') == $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('hari')<span class="rw-error">{{ $message }}</span>@enderror
            </div>
            <div class="rw-form-group">
                <label class="rw-label">Jam Mulai <span class="rw-required">*</span></label>
                <input type="time" name="jam_mulai" value="{{ old('jam_mulai', '09:00') }}" class="rw-input" required>
                @error('jam_mulai')<span class="rw-error">{{ $message }}</span>@enderror
            </div>
            <div class="rw-form-group">
                <label class="rw-label">Jam Selesai</label>
                <input type="time" name="jam_selesai" value="{{ old('jam_selesai') }}" class="rw-input">
                @error('jam_selesai')<span class="rw-error">{{ $message }}</span>@enderror
            </div>
            <div class="rw-form-group rw-col-full">
                <label class="rw-label">Tempat</label>
                <input type="text" name="tempat" value="{{ old('tempat') }}" class="rw-input" placeholder="Contoh: Ruang Terapi, Aula">
                @error('tempat')<span class="rw-error">{{ $message }}</span>@enderror
            </div>
            <div class="rw-form-group rw-col-full">
                <label class="rw-label">Pembimbing</label>
                <select name="pembimbing_id" class="rw-input">
                    <option value="">-- Pilih Pembimbing --</option>
                    @foreach($petugas as $p)
                        <option value="{{ $p->id }}" {{ old('pembimbing_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                    @endforeach
                </select>
                @error('pembimbing_id')<span class="rw-error">{{ $message }}</span>@enderror
            </div>
            <div class="rw-form-group rw-col-full">
                <label class="rw-label">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="rw-input">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')<span class="rw-error">{{ $message }}</span>@enderror
            </div>
            <div class="rw-form-group">
                <label class="rw-checkbox-wrap">
                    <input type="hidden" name="is_aktif" value="0">
                    <input type="checkbox" name="is_aktif" value="1" {{ old('is_aktif', true) ? 'checked' : '' }}>
                    <span>Aktif</span>
                </label>
            </div>
        </div>
        <div class="jadwal-form-actions">
            <button type="submit" class="jadwal-btn-submit">Simpan Jadwal</button>
            <a href="{{ route('dashboard.jadwal-rehabilitasi.index') }}" class="jadwal-btn-cancel">Batal</a>
        </div>
    </form>
</div>

@push('styles')
<style>
.jadwal-form-card{ padding: 0; overflow: hidden; }
.jadwal-form-header{ padding: 1.25rem 1.75rem; border-bottom: 1px solid var(--border); background: #f8fafc; }
.jadwal-form-header-main{ display: flex; align-items: center; gap: 1rem; }
.jadwal-form-icon{ width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, #eff6ff, #dbeafe); border: 1px solid #bfdbfe; display: flex; align-items: center; justify-content: center; color: var(--primary); }
.jadwal-form-title{ font-size: 1.1rem; font-weight: 700; color: #0f172a; margin: 0 0 2px; }
.jadwal-form-subtitle{ font-size: 0.82rem; color: #64748b; margin: 0; }
.jadwal-form{ max-width: 860px; padding: 1.5rem 1.75rem; }
.jadwal-form .rw-form-grid{ display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
.jadwal-form .rw-col-full{ grid-column: 1 / -1; }
.jadwal-form .rw-label{ font-size: 0.85rem; font-weight: 600; color: var(--text); }
.jadwal-form .rw-required{ color: #dc2626; }
.jadwal-form .rw-input{ padding: 0.55rem 0.875rem; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.9rem; width: 100%; background: #fff; }
.jadwal-form .rw-invalid{ border-color: #ef4444 !important; }
.jadwal-form .rw-error{ font-size: 0.8rem; color: #dc2626; }
.rw-checkbox-wrap{ display: flex; align-items: center; gap: 0.5rem; cursor: pointer; }
.jadwal-form-actions{ display: flex; gap: 0.875rem; padding: 1.5rem 1.75rem; border-top: 1px solid var(--border); background: #f8fafc; }
.jadwal-form-actions .jadwal-btn-submit{ padding: 0.65rem 1.5rem; background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff; font-size: 0.925rem; font-weight: 700; border: none; border-radius: 10px; cursor: pointer; box-shadow: 0 2px 10px rgba(37,99,235,0.35); transition: all 0.18s; }
.jadwal-form-actions .jadwal-btn-submit:hover{ background: linear-gradient(135deg, #1d4ed8, #1e40af); box-shadow: 0 4px 16px rgba(37,99,235,0.45); transform: translateY(-1px); }
.jadwal-btn-cancel{ padding: 0.65rem 1.25rem; background: #fff; color: #64748b; font-size: 0.9rem; font-weight: 600; border: 1.5px solid #cbd5e1; border-radius: 10px; text-decoration: none; transition: all 0.15s; }
.jadwal-btn-cancel:hover{ background: #f1f5f9; color: #334155; border-color: #94a3b8; }
.jadwal-form .rw-input:focus{ outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.12); }
@media (max-width: 640px){ .jadwal-form .rw-form-grid{ grid-template-columns: 1fr; } }
</style>
@endpush
@endsection
