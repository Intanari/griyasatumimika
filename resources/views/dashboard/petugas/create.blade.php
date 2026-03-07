@extends('layouts.dashboard')

@section('title', 'Tambah Petugas')
@section('topbar-title', 'Tambah Petugas')

@section('content')
<div class="card petugas-form-card">
    <div class="petugas-form-header">
        <h2 class="petugas-form-title">Form Tambah Petugas Pendamping</h2>
        <p class="petugas-form-subtitle">Lengkapi data identitas, pekerjaan, dan akun sistem.</p>
    </div>

    <form action="{{ route('dashboard.petugas.store') }}" method="POST" class="petugas-form" enctype="multipart/form-data">
        @csrf

        {{-- DATA IDENTITAS --}}
        <div class="petugas-form-section">
            <h3 class="petugas-section-title">
                <span class="petugas-section-icon">👤</span>
                Data Identitas
            </h3>
            <div class="petugas-form-grid">
                <div class="form-group form-group-foto">
                    <label>Foto Profil</label>
                    <div class="petugas-foto-zone" id="fotoPreviewWrap" role="button" tabindex="0">
                        <div class="petugas-foto-placeholder" id="fotoPlaceholder">
                            <span class="petugas-foto-icon">📷</span>
                            <span>Pilih foto</span>
                        </div>
                        <img id="fotoPreview" class="petugas-foto-preview" src="" alt="" style="display:none;">
                    </div>
                    <input type="file" id="foto" name="foto" accept="image/jpeg,image/jpg,image/png,image/webp" class="petugas-foto-input">
                    @error('foto')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="petugas-form-fields">
                    <div class="form-group">
                        <label for="name">Nama Lengkap <span class="required">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required maxlength="255" placeholder="Nama lengkap">
                        @error('name')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin">
                            <option value="">-- Pilih --</option>
                            <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" maxlength="100" placeholder="Kota/kabupaten">
                        @error('tempat_lahir')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                        @error('tanggal_lahir')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group form-group-full">
                        <label for="alamat">Alamat</label>
                        <textarea id="alamat" name="alamat" rows="2" maxlength="500" placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
                        @error('alamat')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="no_hp">Nomor HP</label>
                        <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" maxlength="20" placeholder="08xxxxxxxxxx">
                        @error('no_hp')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email <span class="required">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="email@contoh.com">
                        @error('email')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- DATA PEKERJAAN --}}
        <div class="petugas-form-section">
            <h3 class="petugas-section-title">
                <span class="petugas-section-icon">💼</span>
                Data Pekerjaan
            </h3>
            <div class="petugas-form-grid petugas-form-grid-single">
                <div class="form-group">
                    <label for="tanggal_bergabung">Tanggal Bergabung</label>
                    <input type="date" id="tanggal_bergabung" name="tanggal_bergabung" value="{{ old('tanggal_bergabung') }}">
                    @error('tanggal_bergabung')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="status_kerja">Status Kerja <span class="required">*</span></label>
                    <select id="status_kerja" name="status_kerja" required>
                        <option value="aktif" {{ old('status_kerja', 'aktif') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="cuti" {{ old('status_kerja') === 'cuti' ? 'selected' : '' }}>Cuti</option>
                        <option value="nonaktif" {{ old('status_kerja') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('status_kerja')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="shift_jaga">Shift Jaga</label>
                    <select id="shift_jaga" name="shift_jaga">
                        <option value="">-- Pilih --</option>
                        <option value="pagi" {{ old('shift_jaga') === 'pagi' ? 'selected' : '' }}>Pagi</option>
                        <option value="siang" {{ old('shift_jaga') === 'siang' ? 'selected' : '' }}>Siang</option>
                        <option value="malam" {{ old('shift_jaga') === 'malam' ? 'selected' : '' }}>Malam</option>
                    </select>
                    @error('shift_jaga')<span class="form-error">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        {{-- DATA AKUN SISTEM --}}
        <div class="petugas-form-section">
            <h3 class="petugas-section-title">
                <span class="petugas-section-icon">🔐</span>
                Data Akun Sistem
            </h3>
            <div class="petugas-form-grid petugas-form-grid-single">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" maxlength="100" placeholder="Untuk login (opsional, bisa pakai email)">
                    @error('username')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="password">Password <span class="required">*</span></label>
                    <input type="password" id="password" name="password" required minlength="8" placeholder="Min. 8 karakter">
                    @error('password')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password <span class="required">*</span></label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8" placeholder="Ulangi password">
                </div>
                <div class="form-group">
                    <label for="role">Role <span class="required">*</span></label>
                    <select id="role" name="role" required>
                        <option value="petugas_rehabilitasi" {{ old('role', 'petugas_rehabilitasi') === 'petugas_rehabilitasi' ? 'selected' : '' }}>Petugas</option>
                        <option value="manajer" {{ old('role') === 'manajer' ? 'selected' : '' }}>Manajer</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')<span class="form-error">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <div class="petugas-form-actions">
            <button type="submit" class="btn btn-primary btn-submit">Simpan Petugas</button>
            <a href="{{ route('dashboard.petugas.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>

@push('styles')
<style>
.petugas-form-card { max-width: 900px; }
.petugas-form-header { margin-bottom: 1.5rem; }
.petugas-form-title { font-size: 1.25rem; font-weight: 700; color: var(--text); margin-bottom: 0.25rem; }
.petugas-form-subtitle { font-size: 0.875rem; color: var(--text-muted); }
.petugas-form-section { margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border); }
.petugas-form-section:last-of-type { border-bottom: none; }
.petugas-section-title { font-size: 0.95rem; font-weight: 700; color: var(--text); margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem; }
.petugas-section-icon { font-size: 1.1rem; }
.petugas-form-grid { display: flex; gap: 1.5rem; flex-wrap: wrap; align-items: flex-start; }
.petugas-form-grid-single { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; }
.form-group-foto { flex-shrink: 0; }
.petugas-form-fields { flex: 1; min-width: 280px; display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; align-content: start; }
.form-group-full { grid-column: 1 / -1; }
.petugas-foto-zone {
    width: 120px; height: 120px; border-radius: 50%;
    border: 3px dashed var(--border); background: #f8fafc;
    display: flex; align-items: center; justify-content: center;
    overflow: hidden; cursor: pointer; transition: border-color 0.2s;
}
.petugas-foto-zone:hover { border-color: var(--primary); }
.petugas-foto-placeholder { text-align: center; font-size: 0.8rem; color: var(--text-muted); }
.petugas-foto-icon { display: block; font-size: 2rem; margin-bottom: 4px; }
.petugas-foto-preview { width: 100%; height: 100%; object-fit: cover; }
.petugas-foto-input { display: none; }
.petugas-form .form-group label { display: block; font-size: 0.8rem; font-weight: 600; color: var(--text); margin-bottom: 0.35rem; }
.petugas-form .form-group .required { color: #dc2626; }
.petugas-form .form-group input,
.petugas-form .form-group select,
.petugas-form .form-group textarea {
    width: 100%; padding: 0.5rem 0.75rem; border: 1px solid var(--border); border-radius: 10px;
    font-size: 0.9rem; font-family: inherit;
}
.petugas-form .form-group input:focus,
.petugas-form .form-group select:focus,
.petugas-form .form-group textarea:focus { outline: none; border-color: var(--primary); }
.petugas-form .form-error { display: block; font-size: 0.75rem; color: #dc2626; margin-top: 0.2rem; }
.petugas-form-actions { display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap; margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid var(--border); }
.btn-submit { padding: 0.65rem 1.5rem; }
</style>
@endpush
@push('scripts')
<script>
(function() {
    var wrap = document.getElementById('fotoPreviewWrap');
    var fileInput = document.getElementById('foto');
    var placeholder = document.getElementById('fotoPlaceholder');
    var img = document.getElementById('fotoPreview');
    if (!wrap || !fileInput) return;
    wrap.addEventListener('click', function(e) { e.preventDefault(); fileInput.click(); });
    wrap.addEventListener('keydown', function(e) { if (e.key === 'Enter') { e.preventDefault(); fileInput.click(); } });
    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            var r = new FileReader();
            r.onload = function() { img.src = r.result; img.style.display = 'block'; placeholder.style.display = 'none'; };
            r.readAsDataURL(this.files[0]);
        }
    });
})();
</script>
@endpush
@endsection
