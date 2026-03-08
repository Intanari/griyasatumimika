@extends('layouts.dashboard')

@section('title', 'Edit Jadwal Rehabilitasi')
@section('topbar-title', 'Edit Jadwal Rehabilitasi')

@section('content')
<div class="card jadwal-form-card">
    <div class="jadwal-form-header">
        <a href="{{ route('dashboard.jadwal-rehabilitasi.index') }}" class="jadwal-back-link">← Kembali</a>
        <div class="jadwal-form-header-main">
            <div class="jadwal-form-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </div>
            <div>
                <h2 class="jadwal-form-title">Edit Jadwal Rehabilitasi</h2>
                <p class="jadwal-form-subtitle">Perbarui jadwal kegiatan rehabilitasi. Petugas akan menerima notifikasi email.</p>
            </div>
        </div>
    </div>

    <form action="{{ route('dashboard.jadwal-rehabilitasi.update', $jadwal) }}" method="POST" class="jadwal-form">
        @csrf
        @method('PUT')
        <div class="rw-form-grid">
            <div class="rw-form-group rw-col-full">
                <label class="rw-label">Nama Kegiatan <span class="rw-required">*</span></label>
                <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan', $jadwal->nama_kegiatan) }}" class="rw-input {{ $errors->has('nama_kegiatan') ? 'rw-invalid' : '' }}" required>
                @error('nama_kegiatan')<span class="rw-error">{{ $message }}</span>@enderror
            </div>

            <div class="rw-form-group">
                <label class="rw-label">Hari <span class="rw-required">*</span></label>
                <select name="hari" class="rw-input {{ $errors->has('hari') ? 'rw-invalid' : '' }}" required>
                    @foreach(\App\Models\RehabilitationSchedule::HARI_LIST as $val => $label)
                        <option value="{{ $val }}" {{ old('hari', $jadwal->hari) == $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('hari')<span class="rw-error">{{ $message }}</span>@enderror
            </div>

            <div class="rw-form-group">
                <label class="rw-label">Jam Mulai <span class="rw-required">*</span></label>
                <input type="time" name="jam_mulai" value="{{ old('jam_mulai', \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i')) }}" class="rw-input {{ $errors->has('jam_mulai') ? 'rw-invalid' : '' }}" required>
                @error('jam_mulai')<span class="rw-error">{{ $message }}</span>@enderror
            </div>

            <div class="rw-form-group">
                <label class="rw-label">Jam Selesai</label>
                <input type="time" name="jam_selesai" value="{{ old('jam_selesai', $jadwal->jam_selesai ? \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') : '') }}" class="rw-input {{ $errors->has('jam_selesai') ? 'rw-invalid' : '' }}">
                @error('jam_selesai')<span class="rw-error">{{ $message }}</span>@enderror
            </div>

            <div class="rw-form-group rw-col-full">
                <label class="rw-label">Tempat</label>
                <input type="text" name="tempat" value="{{ old('tempat', $jadwal->tempat) }}" class="rw-input {{ $errors->has('tempat') ? 'rw-invalid' : '' }}">
                @error('tempat')<span class="rw-error">{{ $message }}</span>@enderror
            </div>

            <div class="rw-form-group rw-col-full">
                <label class="rw-label">Pembimbing</label>
                <select name="pembimbing_id" class="rw-input {{ $errors->has('pembimbing_id') ? 'rw-invalid' : '' }}">
                    <option value="">-- Pilih Pembimbing --</option>
                    @foreach($petugas as $p)
                        <option value="{{ $p->id }}" {{ old('pembimbing_id', $jadwal->pembimbing_id) == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                    @endforeach
                </select>
                @error('pembimbing_id')<span class="rw-error">{{ $message }}</span>@enderror
            </div>

            <div class="rw-form-group rw-col-full">
                <label class="rw-label">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="rw-input {{ $errors->has('deskripsi') ? 'rw-invalid' : '' }}" style="resize:vertical;">{{ old('deskripsi', $jadwal->deskripsi) }}</textarea>
                @error('deskripsi')<span class="rw-error">{{ $message }}</span>@enderror
            </div>

            <div class="rw-form-group">
                <label class="rw-label">Status</label>
                <label class="rw-checkbox-wrap">
                    <input type="hidden" name="is_aktif" value="0">
                    <input type="checkbox" name="is_aktif" value="1" {{ old('is_aktif', $jadwal->is_aktif) ? 'checked' : '' }}>
                    <span>Aktif</span>
                </label>
                @error('is_aktif')<span class="rw-error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="jadwal-form-actions">
            <button type="submit" class="jadwal-btn-submit">Simpan Perubahan</button>
            <a href="{{ route('dashboard.jadwal-rehabilitasi.index') }}" class="jadwal-btn-cancel">Batal</a>
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
.jadwal-form-icon { width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, #eff6ff, #dbeafe); display: flex; align-items: center; justify-content: center; color: var(--primary); }
.jadwal-form-title { font-size: 1.1rem; font-weight: 700; color: #0f172a; margin: 0 0 2px; }
.jadwal-form-subtitle { font-size: 0.82rem; color: #64748b; margin: 0; }
.jadwal-form { max-width: 860px; padding: 1.5rem 1.75rem; }
.jadwal-form .rw-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
.jadwal-form .rw-col-full { grid-column: 1 / -1; }
.jadwal-form .rw-form-group { display: flex; flex-direction: column; gap: 0.35rem; }
.jadwal-form .rw-label { font-size: 0.85rem; font-weight: 600; color: var(--text); }
.jadwal-form .rw-required { color: #dc2626; }
.jadwal-form .rw-input { padding: 0.55rem 0.875rem; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.9rem; width: 100%; background: #fff; }
.jadwal-form .rw-invalid { border-color: #ef4444 !important; }
.jadwal-form .rw-error { font-size: 0.8rem; color: #dc2626; }
.rw-checkbox-wrap { display: flex; align-items: center; gap: 0.5rem; cursor: pointer; }
.jadwal-form-actions { display: flex; gap: 0.875rem; padding: 1.5rem 1.75rem; border-top: 1px solid var(--border); background: #f8fafc; }
.jadwal-btn-submit { padding: 0.65rem 1.5rem; background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff; font-size: 0.925rem; font-weight: 700; border: none; border-radius: 10px; cursor: pointer; }
.jadwal-btn-cancel { padding: 0.65rem 1.25rem; background: #fff; color: #64748b; font-size: 0.9rem; font-weight: 600; border: 1.5px solid #cbd5e1; border-radius: 10px; text-decoration: none; }
.jadwal-btn-cancel:hover { background: #f1f5f9; color: #334155; }
@media (max-width: 640px) { .jadwal-form .rw-form-grid { grid-template-columns: 1fr; } }
</style>
@endpush
@endsection
