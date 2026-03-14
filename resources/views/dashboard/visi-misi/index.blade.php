@extends('layouts.dashboard')

@section('title', 'Visi & Misi')
@section('topbar-title', 'Visi & Misi')

@section('content')
<a href="{{ route('dashboard') }}" class="page-back-link">Kembali</a>

<div class="card admin-account-card">
    <div class="admin-account-header">
        <div class="admin-account-header-text">
            <h2 class="admin-account-title">Visi & Misi</h2>
            <p class="admin-account-desc">Kelola konten visi dan misi yang ditampilkan di halaman publik.</p>
        </div>
        <a href="{{ route('dashboard.visi-misi.create') }}" class="btn btn-primary btn-sm admin-account-btn-add">+ Tambah Visi Misi</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="margin: 1rem 1.75rem; padding: 0.75rem 1rem; background: var(--success-soft); color: var(--success); border-radius: 8px;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger" style="margin: 1rem 1.75rem; padding: 0.75rem 1rem; background: var(--danger-soft); color: var(--danger); border-radius: 8px;">{{ session('error') }}</div>
    @endif

    @if ($items->isEmpty())
        <div class="admin-account-empty">
            <div class="admin-account-empty-icon">🎯</div>
            <p class="admin-account-empty-text">Belum ada visi & misi.</p>
            <a href="{{ route('dashboard.visi-misi.create') }}" class="btn btn-primary">+ Tambah Visi Misi</a>
        </div>
    @else
        <div class="visi-misi-cards">
            @foreach ($items as $item)
                <div class="visi-misi-card">
                    <h3 class="visi-misi-card-title">{{ $item->judul }}</h3>
                    <div class="visi-misi-card-body">{!! nl2br(e(Str::limit($item->keterangan ?? '', 120))) !!}</div>
                    <div class="visi-misi-card-actions">
                        <a href="{{ route('dashboard.visi-misi.show', $item) }}" class="btn btn-sm btn-outline">Detail</a>
                        <a href="{{ route('dashboard.visi-misi.edit', $item) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('dashboard.visi-misi.destroy', $item) }}" method="POST" class="visi-misi-form-delete" data-confirm="Yakin hapus?">
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
.visi-misi-cards { display: grid; grid-template-columns: 1fr; gap: 1.25rem; padding: 1rem 1.75rem 1.75rem; }
@media (min-width: 640px) { .visi-misi-cards { grid-template-columns: repeat(2, 1fr); } }
@media (min-width: 1024px) { .visi-misi-cards { grid-template-columns: repeat(3, 1fr); } }
.visi-misi-card { background: var(--card); border: 1px solid var(--border); border-radius: 12px; padding: 1.25rem 1.5rem; box-shadow: var(--shadow); }
.visi-misi-card:hover { box-shadow: var(--shadow-lg); border-color: var(--primary-light); }
.visi-misi-card-title { font-size: 1.05rem; font-weight: 700; color: var(--primary-dark); margin: 0 0 0.75rem; }
.visi-misi-card-body { font-size: 0.9rem; line-height: 1.6; color: var(--text-muted); margin-bottom: 1rem; }
.visi-misi-card-actions { display: flex; flex-wrap: wrap; gap: 0.5rem; align-items: center; }
.visi-misi-card-actions form { display: inline; }
.visi-misi-form-delete button { cursor: pointer; }
</style>
@endpush
@push('scripts')
<script>
document.querySelectorAll('.visi-misi-form-delete').forEach(function(f) {
    f.addEventListener('submit', function(e) {
        if (!confirm(this.getAttribute('data-confirm') || 'Yakin?')) e.preventDefault();
    });
});
</script>
@endpush
@endsection
