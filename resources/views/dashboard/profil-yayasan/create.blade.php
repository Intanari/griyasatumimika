@extends('layouts.dashboard')

@section('title', 'Tambah Profil Yayasan')
@section('topbar-title', 'Tambah Profil Yayasan')

@section('content')
<a href="{{ route('dashboard.profil-yayasan.index') }}" class="page-back-link">Kembali ke Profil Yayasan</a>

<div class="card admin-account-form-card">
    <div class="admin-account-form-header">
        <div class="admin-account-form-header-icon">📄</div>
        <div>
            <h2 class="admin-account-form-title">Tambah Profil Yayasan</h2>
            <p class="admin-account-form-subtitle">Isi judul dan keterangan yang akan ditampilkan di halaman publik Profil Yayasan.</p>
        </div>
    </div>

    <form action="{{ route('dashboard.profil-yayasan.store') }}" method="POST" class="admin-account-form">
        @csrf

        <div class="admin-account-section">
            <h3 class="admin-account-section-title"><span class="admin-account-section-icon">📌</span> Judul</h3>
            <div class="form-group">
                <label for="judul">Judul <span class="required">*</span></label>
                <input type="text" id="judul" name="judul" value="{{ old('judul') }}" required maxlength="255" placeholder="Contoh: Profil dan Identitas">
                @error('judul')<span class="form-error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="admin-account-section">
            <h3 class="admin-account-section-title"><span class="admin-account-section-icon">📝</span> Keterangan</h3>
            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea id="keterangan" name="keterangan" rows="6" placeholder="Isi deskripsi atau isi profil...">{{ old('keterangan') }}</textarea>
                @error('keterangan')<span class="form-error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('dashboard.profil-yayasan.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>

@push('styles')
<style>
.admin-account-form-card { max-width: 640px; overflow: hidden; }
.admin-account-form-header {
    display: flex; align-items: center; gap: 1rem;
    padding: 1.25rem 1.75rem;
    border-bottom: 1px solid var(--border);
    background: #f8fafc;
}
.admin-account-form-header-icon { font-size: 1.5rem; }
.admin-account-form-title { font-size: 1.1rem; font-weight: 700; color: var(--text); margin: 0 0 2px; }
.admin-account-form-subtitle { font-size: 0.82rem; color: var(--text-muted); margin: 0.25rem 0 0 0; }
.admin-account-form { padding: 1.5rem 1.75rem; }
.admin-account-section { margin-bottom: 2rem; }
.admin-account-section-title { font-size: 0.95rem; font-weight: 600; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem; }
.admin-account-section-icon { font-size: 1rem; }
.form-group { margin-bottom: 1rem; }
.form-group label { display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.35rem; color: var(--text); }
.form-group input, .form-group textarea {
    width: 100%; padding: 0.6rem 0.85rem;
    border: 1px solid var(--border); border-radius: 8px;
    font-size: 0.9rem; color: var(--text);
    background: var(--card);
}
.form-group textarea { resize: vertical; min-height: 120px; }
.required { color: var(--danger); }
.form-error { display: block; font-size: 0.8rem; color: var(--danger); margin-top: 0.25rem; }
.form-actions { display: flex; gap: 0.75rem; margin-top: 1.5rem; }
</style>
@endpush
@endsection
