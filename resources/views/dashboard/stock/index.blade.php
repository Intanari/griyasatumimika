@extends('layouts.dashboard')

@section('title', 'Stok Barang')
@section('topbar-title', 'Stok Barang')

@section('content')
<a href="{{ route('dashboard') }}" class="page-back-link">Back</a>

<div class="stock-page">
    {{-- Toolbar: judul + aksi --}}
    <div class="card stock-toolbar-card">
        <div class="stock-toolbar-inner">
            <div class="stock-toolbar-head">
                <h2 class="stock-toolbar-title">Stok Barang</h2>
                <p class="stock-toolbar-desc">Kelola persediaan dan pengeluaran stok barang.</p>
            </div>
            <div class="stock-toolbar-actions">
                <a href="{{ route('dashboard.stock.tambah') }}" class="stock-btn stock-btn-primary">
                    <span class="stock-btn-icon">📥</span>
                    <span class="stock-btn-text">Tambah Stok Barang</span>
                </a>
                <a href="{{ route('dashboard.stock.pengeluaran.create') }}" class="stock-btn stock-btn-secondary">
                    <span class="stock-btn-icon">📤</span>
                    <span class="stock-btn-text">Pengeluaran Stok Barang</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Card sisa stok (otomatis per nama) --}}
    @if($cardSisa->isNotEmpty())
    <div class="card stock-sisa-card">
        <div class="card-title">📊 Sisa Stok per Barang</div>
        <p class="page-table-desc">Nilai sisa = total persediaan dikurangi total pengeluaran untuk setiap nama stok barang.</p>
        <div class="stock-sisa-grid">
            @foreach($cardSisa as $item)
            <div class="stock-sisa-item {{ $item['sisa'] < 0 ? 'negative' : '' }}">
                <div class="stock-sisa-nama">{{ $item['nama'] }}</div>
                <div class="stock-sisa-nilai">{{ number_format($item['sisa']) }}</div>
            </div>
                    @endforeach
        </div>
    </div>
    @endif

    {{-- Tabel Persediaan Stok Barang --}}
    <div class="card stock-main-card">
        <div class="card-title">📋 Tabel Persediaan Stok Barang</div>
        <p class="page-table-desc">Daftar semua catatan penambahan stok barang (nama, jumlah, waktu). Gunakan tombol Stok Barang di atas untuk menambah.</p>
        <div class="table-wrapper stock-table-wrapper">
            <table class="stock-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jumlah</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($supplies as $s)
                    <tr>
                        <td>{{ $s->nama }}</td>
                        <td>{{ number_format($s->jumlah) }}</td>
                        <td>{{ $s->created_at->format('d/m/Y H:i') }}</td>
                        <td class="action-cell">
                            <div class="stock-row-actions">
                                <a href="{{ route('dashboard.stock.persediaan.show', $s) }}" class="stock-row-btn stock-row-btn-view" title="Detail">Detail</a>
                                <a href="{{ route('dashboard.stock.persediaan.edit', $s) }}" class="stock-row-btn stock-row-btn-edit" title="Edit">Edit</a>
                                <form action="{{ route('dashboard.stock.persediaan.destroy', $s) }}" method="post" class="stock-row-form" onsubmit="return confirm('Yakin hapus data persediaan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="stock-row-btn stock-row-btn-delete" title="Hapus">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="empty-state">Belum ada data persediaan. Klik tombol <strong>Stok Barang</strong> untuk menambah.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Tabel Pengeluaran Stok Barang --}}
    <div class="card stock-main-card">
        <div class="card-title">📤 Tabel Pengeluaran Stok Barang</div>
        <p class="page-table-desc">Daftar semua catatan pengeluaran stok barang (nama, jumlah, waktu). Gunakan tombol Pengeluaran Stok Barang di atas untuk menambah.</p>
        <div class="table-wrapper stock-table-wrapper">
            <table class="stock-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jumlah</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses as $e)
                    <tr>
                        <td>{{ $e->nama }}</td>
                        <td>{{ number_format($e->jumlah) }}</td>
                        <td>{{ $e->created_at->format('d/m/Y H:i') }}</td>
                        <td class="action-cell">
                            <div class="stock-row-actions">
                                <a href="{{ route('dashboard.stock.pengeluaran.show', $e) }}" class="stock-row-btn stock-row-btn-view" title="Detail">Detail</a>
                                <a href="{{ route('dashboard.stock.pengeluaran.edit', $e) }}" class="stock-row-btn stock-row-btn-edit" title="Edit">Edit</a>
                                <form action="{{ route('dashboard.stock.pengeluaran.destroy', $e) }}" method="post" class="stock-row-form" onsubmit="return confirm('Yakin hapus data pengeluaran ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="stock-row-btn stock-row-btn-delete" title="Hapus">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="empty-state">Belum ada data pengeluaran. Klik tombol <strong>Pengeluaran Stok Barang</strong> untuk menambah.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if(session('success'))
    <script> document.addEventListener('DOMContentLoaded', function(){ alert('{{ session('success') }}'); }); </script>
@endif
@if(session('error'))
    <script> document.addEventListener('DOMContentLoaded', function(){ alert('{{ session('error') }}'); }); </script>
@endif

<style>
/* Toolbar card: rapi & terstruktur */
.stock-page .stock-toolbar-card { padding: 0; overflow: hidden; }
.stock-page .stock-toolbar-inner { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1.25rem; padding: 1.25rem 1.5rem; }
.stock-toolbar-head { flex: 1; min-width: 200px; }
.stock-toolbar-title { margin: 0; font-size: 1.25rem; font-weight: 700; color: var(--text); letter-spacing: -0.02em; }
.stock-toolbar-desc { margin: 0.25rem 0 0; font-size: 0.875rem; color: var(--text-muted); }
.stock-toolbar-actions { display: flex; gap: 0.75rem; flex-wrap: wrap; align-items: center; }
.stock-btn { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.625rem 1.25rem; font-size: 0.875rem; font-weight: 600; text-decoration: none; border-radius: 10px; border: 1px solid transparent; transition: all 0.2s ease; white-space: nowrap; }
.stock-btn-icon { font-size: 1rem; line-height: 1; }
.stock-btn-primary { background: linear-gradient(135deg, var(--primary), var(--accent)); color: #fff; box-shadow: 0 2px 6px rgba(59, 130, 246, 0.25); }
.stock-btn-primary:hover { filter: brightness(1.08); box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); transform: translateY(-1px); }
.stock-btn-secondary { background: var(--card); color: var(--text); border-color: var(--border); }
.stock-btn-secondary:hover { background: #f8fafc; border-color: var(--primary); color: var(--primary); box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
@media (max-width: 640px) { .stock-page .stock-toolbar-inner { flex-direction: column; align-items: stretch; } .stock-toolbar-actions { justify-content: stretch; } .stock-btn { justify-content: center; } }

/* Card sisa & tabel */
.stock-sisa-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 0.75rem; }
.stock-sisa-item { background: var(--table-row-hover, #f8fafc); border: 1px solid var(--border); border-radius: 10px; padding: 0.75rem 1rem; }
.stock-sisa-item.negative { background: #fef2f2; border-color: #fecaca; }
.stock-sisa-nama { font-weight: 600; color: var(--text); margin-bottom: 0.25rem; }
.stock-sisa-nilai { font-size: 1.25rem; font-weight: 700; color: var(--primary); }
.stock-sisa-item.negative .stock-sisa-nilai { color: var(--accent-rose, #dc2626); }
.stock-table-wrapper { overflow-x: auto; }
.stock-table { width: 100%; border-collapse: collapse; min-width: 480px; }
.stock-table th, .stock-table td { padding: 0.65rem 0.85rem; text-align: left; border-bottom: 1px solid var(--border); }
.stock-table th { background: var(--table-header-bg, #f8fafc); font-weight: 600; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.03em; color: var(--text-muted); }
.stock-main-card { margin-top: 1.25rem; }
.stock-sisa-card { margin-top: 1rem; }

/* Tombol aksi di baris tabel: rapi & konsisten */
.stock-row-actions { display: flex; flex-wrap: wrap; gap: 0.4rem; align-items: center; }
.stock-row-form { display: inline; margin: 0; }
.stock-row-btn { display: inline-block; padding: 0.35rem 0.65rem; font-size: 0.75rem; font-weight: 600; text-decoration: none; border-radius: 6px; border: 1px solid transparent; transition: all 0.15s ease; cursor: pointer; }
.stock-row-btn-view { background: #f0f9ff; color: #0369a1; border-color: #bae6fd; }
.stock-row-btn-view:hover { background: #e0f2fe; color: #0284c7; }
.stock-row-btn-edit { background: #fefce8; color: #a16207; border-color: #fef08a; }
.stock-row-btn-edit:hover { background: #fef9c3; color: #ca8a04; }
.stock-row-btn-delete { background: #fef2f2; color: #b91c1c; border-color: #fecaca; }
.stock-row-btn-delete:hover { background: #fee2e2; color: #dc2626; }
</style>
@endsection
