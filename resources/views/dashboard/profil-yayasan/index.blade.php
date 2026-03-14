@extends('layouts.dashboard')

@section('title', 'Profil Yayasan')
@section('topbar-title', 'Profil Yayasan')

@section('content')
<a href="{{ route('dashboard') }}" class="page-back-link">Kembali</a>

<div class="card admin-account-card">
    <div class="admin-account-header">
        <div class="admin-account-header-text">
            <h2 class="admin-account-title">Profil Yayasan</h2>
            <p class="admin-account-desc">
                Kelola konten profil yayasan yang ditampilkan di halaman publik. Tambah judul dan keterangan untuk setiap bagian profil.
            </p>
        </div>
        <a href="{{ route('dashboard.profil-yayasan.create') }}" class="btn btn-primary btn-sm admin-account-btn-add">+ Tambah Profil Yayasan</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="margin: 1rem 1.75rem; padding: 0.75rem 1rem; background: var(--success-soft); color: var(--success); border-radius: 8px;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger" style="margin: 1rem 1.75rem; padding: 0.75rem 1rem; background: var(--danger-soft); color: var(--danger); border-radius: 8px;">
            {{ session('error') }}
        </div>
    @endif

    @if ($items->isEmpty())
        <div class="admin-account-empty">
            <div class="admin-account-empty-icon">📄</div>
            <p class="admin-account-empty-text">Belum ada profil yayasan.</p>
            <a href="{{ route('dashboard.profil-yayasan.create') }}" class="btn btn-primary">+ Tambah Profil Yayasan</a>
        </div>
    @else
        <div class="profil-yayasan-cards">
            @foreach ($items as $item)
                <div class="profil-yayasan-card">
                    <h3 class="profil-yayasan-card-title">{{ $item->judul }}</h3>
                    <div class="profil-yayasan-card-body">{!! nl2br(e(Str::limit($item->keterangan ?? '', 120))) !!}</div>
                    <div class="profil-yayasan-card-actions">
                        <a href="{{ route('dashboard.profil-yayasan.show', $item) }}" class="btn btn-sm btn-outline">Detail</a>
                        <a href="{{ route('dashboard.profil-yayasan.edit', $item) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('dashboard.profil-yayasan.destroy', $item) }}" method="POST" class="profil-yayasan-form-delete" data-confirm="Yakin hapus profil « {{ $item->judul }} »?">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@push('styles')
<style>
.profil-yayasan-cards { display: grid; grid-template-columns: 1fr; gap: 1.25rem; padding: 1rem 1.75rem 1.75rem; }
@media (min-width: 640px) { .profil-yayasan-cards { grid-template-columns: repeat(2, 1fr); } }
@media (min-width: 1024px) { .profil-yayasan-cards { grid-template-columns: repeat(3, 1fr); } }
.profil-yayasan-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 1.25rem 1.5rem;
    box-shadow: var(--shadow);
    transition: box-shadow 0.2s, border-color 0.2s;
}
.profil-yayasan-card:hover { box-shadow: var(--shadow-lg); border-color: var(--primary-light); }
.profil-yayasan-card-title { font-size: 1.05rem; font-weight: 700; color: var(--primary-dark); margin: 0 0 0.75rem; }
.profil-yayasan-card-body { font-size: 0.9rem; line-height: 1.6; color: var(--text-muted); margin-bottom: 1rem; }
.profil-yayasan-card-actions { display: flex; flex-wrap: wrap; gap: 0.5rem; align-items: center; }
.profil-yayasan-card-actions form { display: inline; }
.profil-yayasan-form-delete button { cursor: pointer; }
</style>
@endpush
@push('scripts')
<script>
document.querySelectorAll('.profil-yayasan-form-delete').forEach(function(form) {
    form.addEventListener('submit', function(e) {
        if (!confirm(form.getAttribute('data-confirm') || 'Yakin ingin menghapus?')) e.preventDefault();
    });
});
</script>
@endpush
@endsection
