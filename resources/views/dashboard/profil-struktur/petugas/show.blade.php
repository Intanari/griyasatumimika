@extends('layouts.dashboard')

@section('title', 'Detail Petugas Yayasan')
@section('topbar-title', 'Detail Petugas Yayasan')

@section('content')
<a href="{{ route('dashboard.profil-struktur.index') }}" class="page-back-link">Kembali ke Profil Struktur</a>

<div class="card admin-account-form-card">
    <div class="admin-account-form-header">
        <div class="admin-account-form-header-icon">👤</div>
        <div>
            <h2 class="admin-account-form-title">Detail Petugas Yayasan</h2>
            <p class="admin-account-form-subtitle">{{ $petugasYayasan->nama }}</p>
        </div>
        <a href="{{ route('dashboard.petugas-yayasan.edit', $petugasYayasan) }}" class="btn btn-primary btn-sm">Edit</a>
    </div>

    <div class="admin-account-form petugas-show-body">
        <div class="petugas-show-avatar">
            @if($petugasYayasan->foto_url)
                <img src="{{ $petugasYayasan->foto_url }}" alt="">
            @else
                <span class="petugas-show-initials">{{ $petugasYayasan->avatar_initials }}</span>
            @endif
        </div>
        <dl class="petugas-show-dl">
            <dt>Nama</dt>
            <dd>{{ $petugasYayasan->nama }}</dd>
            @if($petugasYayasan->status)
                <dt>Status / Jabatan</dt>
                <dd>{{ $petugasYayasan->status }}</dd>
            @endif
            @if($petugasYayasan->keterangan)
                <dt>Keterangan</dt>
                <dd>{!! nl2br(e($petugasYayasan->keterangan)) !!}</dd>
            @endif
        </dl>
        <div class="form-actions">
            <a href="{{ route('dashboard.petugas-yayasan.edit', $petugasYayasan) }}" class="btn btn-primary">Edit</a>
            <form action="{{ route('dashboard.petugas-yayasan.destroy', $petugasYayasan) }}" method="POST" class="petugas-show-delete-form" data-confirm="Yakin hapus petugas « {{ $petugasYayasan->nama }} »?">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Hapus</button>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
.admin-account-form-card { max-width: 560px; overflow: hidden; }
.admin-account-form-header {
    display: flex; align-items: center; gap: 1rem;
    padding: 1.25rem 1.75rem;
    border-bottom: 1px solid var(--border);
    background: #f8fafc;
}
.admin-account-form-header-icon { font-size: 1.5rem; }
.admin-account-form-title { font-size: 1.1rem; font-weight: 700; color: var(--text); margin: 0 0 2px; }
.admin-account-form-subtitle { font-size: 0.82rem; color: var(--text-muted); margin: 0.25rem 0 0 0; }
.petugas-show-body { padding: 1.5rem 1.75rem; text-align: center; }
.petugas-show-avatar {
    width: 120px; height: 120px; border-radius: 50%;
    margin: 0 auto 1.25rem;
    background: var(--neutral-soft);
    overflow: hidden;
    display: flex; align-items: center; justify-content: center;
}
.petugas-show-avatar img { width: 100%; height: 100%; object-fit: cover; }
.petugas-show-initials { font-size: 2rem; font-weight: 700; color: var(--primary); }
.petugas-show-dl { text-align: left; max-width: 400px; margin: 0 auto 1.5rem; }
.petugas-show-dl dt { font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); margin-top: 1rem; margin-bottom: 0.25rem; }
.petugas-show-dl dt:first-of-type { margin-top: 0; }
.petugas-show-dl dd { font-size: 1rem; color: var(--text); margin: 0; line-height: 1.5; }
.form-actions { display: flex; gap: 0.75rem; justify-content: center; flex-wrap: wrap; }
.petugas-show-delete-form { display: inline; }
</style>
@endpush
@push('scripts')
<script>
document.querySelector('.petugas-show-delete-form')?.addEventListener('submit', function(e) {
    if (!confirm(this.getAttribute('data-confirm') || 'Yakin?')) e.preventDefault();
});
</script>
@endpush
@endsection
