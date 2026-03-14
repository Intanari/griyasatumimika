@extends('layouts.dashboard')

@section('title', 'Layanan')
@section('topbar-title', 'Layanan')

@section('content')
<a href="{{ route('dashboard') }}" class="page-back-link">Kembali</a>

{{-- Proses Laporan ODGJ --}}
<div class="card admin-account-card layanan-section-card">
    <div class="admin-account-header">
        <div class="admin-account-header-text">
            <h2 class="admin-account-title">📋 Proses Laporan ODGJ</h2>
            <p class="admin-account-desc">Kelola langkah-langkah proses laporan ODGJ yang ditampilkan di halaman publik Layanan.</p>
        </div>
        <a href="{{ route('dashboard.layanan.proses-laporan-odgj.create') }}" class="btn btn-primary btn-sm admin-account-btn-add">+ Tambah Proses Laporan ODGJ</a>
    </div>

    @if ($prosesLaporanOdgj->isEmpty())
        <div class="admin-account-empty">
            <div class="admin-account-empty-icon">📋</div>
            <p class="admin-account-empty-text">Belum ada proses laporan ODGJ.</p>
            <a href="{{ route('dashboard.layanan.proses-laporan-odgj.create') }}" class="btn btn-primary">+ Tambah Proses Laporan ODGJ</a>
        </div>
    @else
        <div class="layanan-cards">
            @foreach ($prosesLaporanOdgj as $item)
                <div class="layanan-card">
                    <div class="layanan-card-num">{{ $item->no_urut }}</div>
                    <h3 class="layanan-card-title">{{ $item->judul }}</h3>
                    <div class="layanan-card-body">{{ Str::limit($item->keterangan ?? '', 120) }}</div>
                    <div class="layanan-card-actions">
                        <a href="{{ route('dashboard.layanan.proses-laporan-odgj.show', $item) }}" class="btn btn-sm btn-outline">Detail</a>
                        <a href="{{ route('dashboard.layanan.proses-laporan-odgj.edit', $item) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('dashboard.layanan.proses-laporan-odgj.destroy', $item) }}" method="POST" class="layanan-form-delete" data-confirm="Yakin hapus proses ini?">
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

{{-- Tahapan Rehabilitasi --}}
<div class="card admin-account-card layanan-section-card">
    <div class="admin-account-header">
        <div class="admin-account-header-text">
            <h2 class="admin-account-title">🔄 Tahapan Rehabilitasi</h2>
            <p class="admin-account-desc">Kelola tahapan rehabilitasi yang ditampilkan di halaman publik Layanan.</p>
        </div>
        <a href="{{ route('dashboard.layanan.tahapan-rehabilitasi.create') }}" class="btn btn-primary btn-sm admin-account-btn-add">+ Tambah Tahapan Rehabilitasi</a>
    </div>

    @if ($tahapanRehabilitasi->isEmpty())
        <div class="admin-account-empty">
            <div class="admin-account-empty-icon">🔄</div>
            <p class="admin-account-empty-text">Belum ada tahapan rehabilitasi.</p>
            <a href="{{ route('dashboard.layanan.tahapan-rehabilitasi.create') }}" class="btn btn-primary">+ Tambah Tahapan Rehabilitasi</a>
        </div>
    @else
        <div class="layanan-boxes">
            @foreach ($tahapanRehabilitasi as $item)
                <div class="layanan-box">
                    <div class="layanan-box-header">
                        <span class="layanan-box-num">{{ $item->no_urut }}</span>
                        @if($item->status)
                            <span class="layanan-box-status">{{ $item->status }}</span>
                        @endif
                    </div>
                    <h3 class="layanan-box-title">{{ $item->judul }}</h3>
                    <div class="layanan-box-body">{{ Str::limit($item->keterangan ?? '', 150) }}</div>
                    <div class="layanan-box-actions">
                        <a href="{{ route('dashboard.layanan.tahapan-rehabilitasi.show', $item) }}" class="btn btn-sm btn-outline">Detail</a>
                        <a href="{{ route('dashboard.layanan.tahapan-rehabilitasi.edit', $item) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('dashboard.layanan.tahapan-rehabilitasi.destroy', $item) }}" method="POST" class="layanan-form-delete" data-confirm="Yakin hapus tahapan ini?">
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
.layanan-section-card { margin-bottom: 1.5rem; }
.layanan-section-card:last-child { margin-bottom: 0; }
.layanan-cards { display: grid; grid-template-columns: 1fr; gap: 1.25rem; padding: 1rem 1.75rem 1.75rem; }
@media (min-width: 640px) { .layanan-cards { grid-template-columns: repeat(2, 1fr); } }
@media (min-width: 1024px) { .layanan-cards { grid-template-columns: repeat(4, 1fr); } }
.layanan-card { background: var(--card); border: 1px solid var(--border); border-radius: 12px; padding: 1.25rem 1.5rem; box-shadow: var(--shadow); }
.layanan-card:hover { box-shadow: var(--shadow-lg); border-color: var(--primary-light); }
.layanan-card-num { width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, var(--primary), var(--accent)); color: white; font-size: 0.95rem; font-weight: 800; display: flex; align-items: center; justify-content: center; margin-bottom: 0.75rem; }
.layanan-card-title { font-size: 1rem; font-weight: 700; color: var(--primary-dark); margin: 0 0 0.5rem; }
.layanan-card-body { font-size: 0.85rem; line-height: 1.55; color: var(--text-muted); margin-bottom: 1rem; }
.layanan-card-actions { display: flex; flex-wrap: wrap; gap: 0.5rem; align-items: center; }
.layanan-card-actions form { display: inline; }
.layanan-boxes { display: grid; grid-template-columns: 1fr; gap: 1rem; padding: 1rem 1.75rem 1.75rem; }
.layanan-box { background: var(--card); border: 1px solid var(--border); border-radius: 12px; padding: 1.25rem 1.5rem; box-shadow: var(--shadow); }
.layanan-box:hover { border-color: var(--primary-light); }
.layanan-box-header { display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem; }
.layanan-box-num { width: 32px; height: 32px; border-radius: 8px; background: linear-gradient(135deg, var(--primary), var(--accent)); color: white; font-size: 0.9rem; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; }
.layanan-box-status { font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; padding: 0.2rem 0.6rem; background: rgba(37,99,235,0.15); color: var(--primary); border-radius: 999px; }
.layanan-box-title { font-size: 1rem; font-weight: 700; color: var(--text); margin: 0 0 0.5rem; }
.layanan-box-body { font-size: 0.85rem; line-height: 1.55; color: var(--text-muted); margin-bottom: 1rem; }
.layanan-box-actions { display: flex; flex-wrap: wrap; gap: 0.5rem; align-items: center; }
.layanan-box-actions form { display: inline; }
.layanan-form-delete button { cursor: pointer; }
</style>
@endpush
@push('scripts')
<script>
document.querySelectorAll('.layanan-form-delete').forEach(function(f) {
    f.addEventListener('submit', function(e) {
        if (!confirm(this.getAttribute('data-confirm') || 'Yakin?')) e.preventDefault();
    });
});
</script>
@endpush
@endsection
