@extends('layouts.dashboard')

@section('title', 'Edit Jadwal Pasien')
@section('topbar-title', 'Edit Jadwal Pasien')

@section('content')
<div class="card jadwal-form-card">
    <div class="jadwal-form-header">
        <a href="{{ route('dashboard.jadwal-pasien.index') }}" class="jadwal-back-link">← Kembali</a>
        <div class="jadwal-form-header-main">
            <div class="jadwal-form-icon jadwal-form-icon-edit">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </div>
            <div>
                <h2 class="jadwal-form-title">Edit Jadwal Pasien</h2>
                <p class="jadwal-form-subtitle">{{ $schedule->patient->nama_lengkap ?? 'Pasien' }} · {{ $schedule->tanggal?->translatedFormat('d M Y') }}</p>
            </div>
        </div>
    </div>

    <form action="{{ route('dashboard.jadwal-pasien.update', $schedule) }}" method="POST" class="jadwal-form">
        @csrf
        @method('PUT')
        <div class="rw-form-grid">
            <div class="rw-form-group rw-col-full">
                <label class="rw-label">Pasien <span class="rw-required">*</span></label>
                <select name="patient_id" class="rw-input {{ $errors->has('patient_id') ? 'rw-invalid' : '' }}" required>
                    @foreach($patients as $p)
                        <option value="{{ $p->id }}" {{ old('patient_id', $schedule->patient_id) == $p->id ? 'selected' : '' }}>{{ $p->nama_lengkap }}</option>
                    @endforeach
                </select>
                @error('patient_id')<span class="rw-error">{{ $message }}</span>@enderror
            </div>

            <div class="rw-form-group rw-col-full">
                <label class="rw-label">Pembimbing</label>
                <select name="pembimbing_id" class="rw-input {{ $errors->has('pembimbing_id') ? 'rw-invalid' : '' }}">
                    <option value="">-- Pilih Pembimbing --</option>
                    @foreach($petugas as $p)
                        <option value="{{ $p->id }}" {{ old('pembimbing_id', $schedule->pembimbing_id) == $p->id ? 'selected' : '' }}>
                            {{ $p->name }}
                        </option>
                    @endforeach
                </select>
                @error('pembimbing_id')<span class="rw-error">{{ $message }}</span>@enderror
            </div>

            <div class="rw-form-group">
                <label class="rw-label">Tanggal <span class="rw-required">*</span></label>
                <input type="date" name="tanggal" value="{{ old('tanggal', $schedule->tanggal?->format('Y-m-d')) }}" class="rw-input {{ $errors->has('tanggal') ? 'rw-invalid' : '' }}" required>
                @error('tanggal')<span class="rw-error">{{ $message }}</span>@enderror
            </div>

            <div class="rw-form-group">
                <label class="rw-label">Jam Mulai</label>
                <input type="time" name="jam_mulai" value="{{ old('jam_mulai', $schedule->jam_mulai ? \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') : '') }}" class="rw-input {{ $errors->has('jam_mulai') ? 'rw-invalid' : '' }}">
                @error('jam_mulai')<span class="rw-error">{{ $message }}</span>@enderror
            </div>

            <div class="rw-form-group">
                <label class="rw-label">Jam Selesai</label>
                <input type="time" name="jam_selesai" value="{{ old('jam_selesai', $schedule->jam_selesai ? \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i') : '') }}" class="rw-input {{ $errors->has('jam_selesai') ? 'rw-invalid' : '' }}">
                @error('jam_selesai')<span class="rw-error">{{ $message }}</span>@enderror
            </div>

            <div class="rw-form-group">
                <label class="rw-label">Waktu Pengingat</label>
                @php $reminderOld = old('reminder_before_minutes', $schedule->reminder_before_minutes); @endphp
                <select name="reminder_before_minutes" class="rw-input {{ $errors->has('reminder_before_minutes') ? 'rw-invalid' : '' }}">
                    <option value="">Tanpa pengingat</option>
                    <option value="2" {{ $reminderOld == 2 ? 'selected' : '' }}>2 menit sebelum</option>
                    <option value="5" {{ $reminderOld == 5 ? 'selected' : '' }}>5 menit sebelum</option>
                    <option value="15" {{ $reminderOld == 15 ? 'selected' : '' }}>15 menit sebelum</option>
                    <option value="30" {{ $reminderOld == 30 ? 'selected' : '' }}>30 menit sebelum</option>
                    <option value="60" {{ $reminderOld == 60 ? 'selected' : '' }}>1 jam sebelum</option>
                    <option value="300" {{ $reminderOld == 300 ? 'selected' : '' }}>5 jam sebelum</option>
                    <option value="600" {{ $reminderOld == 600 ? 'selected' : '' }}>10 jam sebelum</option>
                    <option value="1440" {{ $reminderOld == 1440 ? 'selected' : '' }}>1 hari sebelum</option>
                    <option value="2880" {{ $reminderOld == 2880 ? 'selected' : '' }}>2 hari sebelum</option>
                    <option value="4320" {{ $reminderOld == 4320 ? 'selected' : '' }}>3 hari sebelum</option>
                </select>
                @error('reminder_before_minutes')<span class="rw-error">{{ $message }}</span>@enderror
            </div>

            <div class="rw-form-group rw-col-full">
                <label class="rw-label">Tempat</label>
                <input type="text" name="tempat" value="{{ old('tempat', $schedule->tempat) }}" class="rw-input {{ $errors->has('tempat') ? 'rw-invalid' : '' }}">
                @error('tempat')<span class="rw-error">{{ $message }}</span>@enderror
            </div>

            <div class="rw-form-group">
                <label class="rw-label">Jenis Jadwal <span class="rw-required">*</span></label>
                @php
                    $jenisEdit = old('jenis', $schedule->jenis);
                    $jenisLabel = match($jenisEdit) {
                        'kontrol' => 'Kontrol Rutin',
                        'konseling' => 'Konseling',
                        'home_visit' => 'Kunjungan Rumah',
                        'lainnya' => 'Kegiatan Lainnya',
                        default => $jenisEdit,
                    };
                @endphp
                <input type="text" name="jenis" id="jenis-jadwal" value="{{ $jenisLabel }}"
                    class="rw-input {{ $errors->has('jenis') ? 'rw-invalid' : '' }}"
                    list="jenis-jadwal-list"
                    placeholder="Pilih atau ketik jenis jadwal..."
                    required autocomplete="off">
                <datalist id="jenis-jadwal-list">
                    <option value="Kontrol Rutin">
                    <option value="Konseling">
                    <option value="Kunjungan Rumah">
                    <option value="Ibadah Gereja">
                    <option value="Kegiatan Lainnya">
                </datalist>
                @error('jenis')<span class="rw-error">{{ $message }}</span>@enderror
            </div>

            <div class="rw-form-group">
                <label class="rw-label">Status <span class="rw-required">*</span></label>
                @php $status = old('status', $schedule->status); @endphp
                <select name="status" class="rw-input {{ $errors->has('status') ? 'rw-invalid' : '' }}" required>
                    <option value="terjadwal" {{ $status === 'terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                    <option value="selesai" {{ $status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="batal" {{ $status === 'batal' ? 'selected' : '' }}>Batal</option>
                </select>
                @error('status')<span class="rw-error">{{ $message }}</span>@enderror
            </div>

            <div class="rw-form-group rw-col-full">
                <label class="rw-label">Catatan</label>
                <textarea name="catatan" rows="3" class="rw-input {{ $errors->has('catatan') ? 'rw-invalid' : '' }}" style="resize:vertical;">{{ old('catatan', $schedule->catatan) }}</textarea>
                @error('catatan')<span class="rw-error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="jadwal-form-actions">
            <button type="submit" class="jadwal-btn-submit">Simpan Perubahan</button>
            <a href="{{ route('dashboard.jadwal-pasien.index') }}" class="jadwal-btn-cancel">Batal</a>
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
.jadwal-btn-submit { display: inline-flex; align-items: center; gap: 6px; padding: 0.65rem 1.5rem; background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff; font-size: 0.925rem; font-weight: 700; border: none; border-radius: 10px; cursor: pointer; font-family: inherit; box-shadow: 0 2px 10px rgba(37,99,235,0.35); transition: all 0.18s ease; }
.jadwal-btn-submit:hover { background: linear-gradient(135deg, #1d4ed8, #1e40af); box-shadow: 0 4px 16px rgba(37,99,235,0.45); transform: translateY(-1px); }
.jadwal-btn-cancel { display: inline-flex; align-items: center; padding: 0.65rem 1.25rem; background: #fff; color: #64748b; font-size: 0.9rem; font-weight: 600; border: 1.5px solid #cbd5e1; border-radius: 10px; text-decoration: none; transition: all 0.15s; }
.jadwal-btn-cancel:hover { background: #f1f5f9; color: #334155; border-color: #94a3b8; }
@media (max-width: 640px) { .jadwal-form .rw-form-grid { grid-template-columns: 1fr; } .jadwal-form .rw-col-full { grid-column: 1; } .jadwal-form, .jadwal-form-actions { padding: 1rem; } }
</style>
@endpush
@endsection
