@extends('layouts.dashboard')

@section('title', 'Tambah Pasien')
@section('topbar-title', 'Tambah Pasien')

@section('content')
<a href="{{ route('dashboard.patients.index') }}" class="page-back-link">Kembali ke Data Pasien</a>
<div class="card">
    <div class="card-title">Form Tambah Pasien</div>
    <form action="{{ route('dashboard.patients.store') }}" method="POST" class="patient-form" enctype="multipart/form-data">
        @csrf
        <div class="patient-form-top">
            <div class="form-group form-group-foto">
                <label>Foto identitas pasien (wajah)</label>
                <div class="foto-upload-zone" id="fotoPreviewWrap" role="button" tabindex="0" aria-label="Pilih foto">
                    <div class="foto-placeholder" id="fotoPlaceholder">
                        <span class="foto-placeholder-icon">👤</span>
                        <span class="foto-placeholder-text">Pilih foto wajah pasien</span>
                        <span class="foto-placeholder-hint">JPG, PNG atau WebP • Maks. 2 MB</span>
                    </div>
                    <img id="fotoPreview" class="foto-preview-img" src="" alt="" style="display:none;">
                </div>
                <input type="file" id="foto" name="foto" accept="image/jpeg,image/jpg,image/png,image/webp" class="foto-input">
                @error('foto')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-grid-wrap">
        <div class="form-grid">
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap <span class="required">*</span></label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required maxlength="255" placeholder="Contoh: Yohanes Daeli">
                @error('nama_lengkap')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="tempat_lahir">Tempat Lahir</label>
                <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" maxlength="100" placeholder="Contoh: Mimika, Jayapura">
                @error('tempat_lahir')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                @error('tanggal_lahir')<span class="form-error">{{ $message }}</span>@enderror
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
                <label for="tanggal_masuk">Tanggal Masuk <span class="required">*</span></label>
                <input type="date" id="tanggal_masuk" name="tanggal_masuk" value="{{ old('tanggal_masuk', now()->format('Y-m-d')) }}" required>
                @error('tanggal_masuk')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="status">Status <span class="required">*</span></label>
                <select id="status" name="status" required>
                    <option value="aktif" {{ old('status', 'aktif') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="selesai" {{ old('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dirujuk" {{ old('status') === 'dirujuk' ? 'selected' : '' }}>Dirujuk</option>
                </select>
                @error('status')<span class="form-error">{{ $message }}</span>@enderror
            </div>
        </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
            <a href="{{ route('dashboard.patients.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>

@push('styles')
<style>
.patient-form { max-width: 900px; }
.patient-form-top { display: flex; gap: 2rem; align-items: flex-start; flex-wrap: wrap; margin-bottom: 1.5rem; }
.form-group-foto { flex-shrink: 0; }
.form-grid-wrap { flex: 1; min-width: 280px; }
.form-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.25rem; margin-bottom: 0; }
.form-group label { display: block; font-size: 0.85rem; font-weight: 600; color: var(--text); margin-bottom: 0.4rem; }
.form-group .required { color: #dc2626; }
.form-group input, .form-group select {
    width: 100%; padding: 0.5rem 0.875rem; border: 1px solid var(--border); border-radius: 10px;
    font-size: 0.9rem; font-family: inherit;
}
.form-group input:focus, .form-group select:focus { outline: none; border-color: var(--primary); }
.form-error { display: block; font-size: 0.8rem; color: #dc2626; margin-top: 0.25rem; }
.form-actions {
    display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;
    margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid var(--border);
}
.btn-primary { background: linear-gradient(135deg, var(--primary), var(--accent)); color: white; padding: 0.5rem 1.25rem; cursor: pointer; border: none; font-size: 0.95rem; border-radius: 10px; font-weight: 600; }
.btn-submit { padding: 0.65rem 1.5rem; min-height: 44px; }
.btn-outline { background: transparent; border: 1px solid var(--border); color: var(--text); padding: 0.5rem 1.25rem; text-decoration: none; border-radius: 10px; font-size: 0.95rem; font-weight: 600; display: inline-block; }
.form-group-foto label { margin-bottom: 0.5rem; display: block; }
.foto-upload-zone {
    width: 160px; height: 160px; border-radius: 50%;
    border: 3px dashed var(--border); background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    display: flex; align-items: center; justify-content: center;
    overflow: hidden; position: relative; cursor: pointer;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.foto-upload-zone:hover { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(59,130,246,0.15); }
.foto-upload-zone:focus { outline: 2px solid var(--primary); outline-offset: 2px; }
.foto-placeholder { text-align: center; padding: 0.75rem; pointer-events: none; }
.foto-placeholder-icon { font-size: 2.5rem; display: block; margin-bottom: 0.35rem; opacity: 0.7; }
.foto-placeholder-text { font-size: 0.8rem; font-weight: 600; color: var(--text); display: block; }
.foto-placeholder-hint { font-size: 0.7rem; color: var(--text-muted); display: block; margin-top: 0.2rem; }
.foto-preview-img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; pointer-events: none; }
.foto-input { display: none; }
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
