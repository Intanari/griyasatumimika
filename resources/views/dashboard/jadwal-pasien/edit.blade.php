@extends('layouts.dashboard')

@section('title', 'Edit Jadwal Pasien')
@section('topbar-title', 'Edit Jadwal Pasien')

@section('content')
<a href="{{ route('dashboard.jadwal-pasien.index') }}" class="page-back-link">Kembali</a>

<div class="card jadwal-form-card">
    <div class="jadwal-form-header">
        <div class="jadwal-form-header-main">
            <div class="jadwal-form-header-left">
                <div class="jadwal-form-icon jadwal-form-icon-edit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </div>
                <div>
                    <h2 class="jadwal-form-title">Edit Jadwal Pasien</h2>
                    <p class="jadwal-form-subtitle">{{ $schedule->patient->nama_lengkap ?? 'Pasien' }} · {{ $schedule->tanggal?->translatedFormat('d F Y') }}</p>
                </div>
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
                <input type="text" name="tempat" value="{{ old('tempat', $schedule->tempat) }}" class="rw-input {{ $errors->has('tempat') ? 'rw-invalid' : '' }}" placeholder="Contoh: Puskesmas, Klinik, Rumah Pasien">
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
                <textarea name="catatan" rows="3" class="rw-input {{ $errors->has('catatan') ? 'rw-invalid' : '' }}" placeholder="Catatan tambahan (opsional)" style="resize:vertical;">{{ old('catatan', $schedule->catatan) }}</textarea>
                @error('catatan')<span class="rw-error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="jadwal-form-actions">
            <button type="submit" class="jadwal-btn-submit">Simpan Perubahan</button>
            <a href="{{ route('dashboard.jadwal-pasien.index') }}" class="jadwal-btn-cancel">Batal</a>
        </div>
    </form>
</div>
@endsection
