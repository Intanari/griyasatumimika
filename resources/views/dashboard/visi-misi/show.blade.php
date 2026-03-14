@extends('layouts.dashboard')

@section('title', 'Detail Visi Misi')
@section('topbar-title', 'Detail Visi Misi')

@section('content')
<a href="{{ route('dashboard.visi-misi.index') }}" class="page-back-link">Kembali ke Visi & Misi</a>

<div class="card admin-account-form-card">
    <div class="admin-account-form-header">
        <div class="admin-account-form-header-icon">🎯</div>
        <div style="flex: 1;">
            <h2 class="admin-account-form-title">{{ $visiMisi->judul }}</h2>
            <p class="admin-account-form-subtitle">Detail konten visi & misi.</p>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('dashboard.visi-misi.edit', $visiMisi) }}" class="btn btn-primary btn-sm">Edit</a>
            <form action="{{ route('dashboard.visi-misi.destroy', $visiMisi) }}" method="POST" onsubmit="return confirm('Yakin hapus visi/misi ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
            </form>
        </div>
    </div>
    <div class="visi-misi-detail-body">
        <div class="visi-misi-detail-content">{!! nl2br(e($visiMisi->keterangan)) !!}</div>
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
.visi-misi-detail-body { padding: 1.5rem 1.75rem; }
.visi-misi-detail-content { font-size: 0.95rem; line-height: 1.75; color: var(--text-muted); }
</style>
@endpush
@endsection
