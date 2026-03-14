@extends('layouts.dashboard')

@section('title', 'Detail Profil Yayasan')
@section('topbar-title', 'Detail Profil Yayasan')

@section('content')
<a href="{{ route('dashboard.profil-yayasan.index') }}" class="page-back-link">Kembali ke Profil Yayasan</a>

<div class="card admin-account-form-card">
    <div class="admin-account-form-header">
        <div class="admin-account-form-header-icon">📄</div>
        <div style="flex: 1;">
            <h2 class="admin-account-form-title">{{ $profilYayasan->judul }}</h2>
            <p class="admin-account-form-subtitle">Detail konten profil yayasan.</p>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('dashboard.profil-yayasan.edit', $profilYayasan) }}" class="btn btn-primary btn-sm">Edit</a>
            <form action="{{ route('dashboard.profil-yayasan.destroy', $profilYayasan) }}" method="POST" onsubmit="return confirm('Yakin hapus profil ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
            </form>
        </div>
    </div>
    <div class="profil-yayasan-detail-body">
        <div class="profil-yayasan-detail-content">{!! nl2br(e($profilYayasan->keterangan)) !!}</div>
    </div>
</div>

@push('styles')
<style>
.admin-account-form-card { max-width: 720px; overflow: hidden; }
.admin-account-form-header {
    display: flex; align-items: center; gap: 1rem;
    padding: 1.25rem 1.75rem;
    border-bottom: 1px solid var(--border);
    background: #f8fafc;
}
.admin-account-form-header-icon { font-size: 1.5rem; }
.admin-account-form-title { font-size: 1.1rem; font-weight: 700; color: var(--text); margin: 0 0 2px; }
.admin-account-form-subtitle { font-size: 0.82rem; color: var(--text-muted); margin: 0.25rem 0 0 0; }
.profil-yayasan-detail-body { padding: 1.5rem 1.75rem; }
.profil-yayasan-detail-content { font-size: 0.95rem; line-height: 1.75; color: var(--text-muted); }
</style>
@endpush
@endsection
