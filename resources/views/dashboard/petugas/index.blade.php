@extends('layouts.dashboard')

@section('title', 'Data Petugas')
@section('topbar-title', 'Data Petugas')

@section('content')
<a href="{{ route('dashboard') }}" class="page-back-link">Back</a>
{{-- Section spacing wrapper --}}
<div class="petugas-page">

{{-- 1. Card Statistik --}}
<section class="petugas-section petugas-section-stats">
    <div class="petugas-stats-grid">
        <div class="petugas-stat-card petugas-stat-total">
            <div class="petugas-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div class="petugas-stat-body">
                <div class="petugas-stat-value">{{ number_format($stats['total']) }}</div>
                <div class="petugas-stat-label">Total Petugas</div>
            </div>
        </div>
        <div class="petugas-stat-card petugas-stat-aktif">
            <div class="petugas-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div class="petugas-stat-body">
                <div class="petugas-stat-value">{{ number_format($stats['aktif']) }}</div>
                <div class="petugas-stat-label">Petugas Aktif</div>
            </div>
        </div>
        <div class="petugas-stat-card petugas-stat-cuti">
            <div class="petugas-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div class="petugas-stat-body">
                <div class="petugas-stat-value">{{ number_format($stats['cuti']) }}</div>
                <div class="petugas-stat-label">Petugas Cuti</div>
            </div>
        </div>
        <div class="petugas-stat-card petugas-stat-nonaktif">
            <div class="petugas-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
            </div>
            <div class="petugas-stat-body">
                <div class="petugas-stat-value">{{ number_format($stats['nonaktif']) }}</div>
                <div class="petugas-stat-label">Petugas Nonaktif</div>
            </div>
        </div>
    </div>
</section>

{{-- 2. Toolbar + Search + Filter --}}
<section class="petugas-section">
<div class="card petugas-card petugas-card-toolbar">
    <div class="petugas-toolbar">
        <div class="petugas-toolbar-left">
            <a href="{{ route('dashboard.petugas.create') }}" class="petugas-btn-add">
                <svg class="petugas-btn-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Petugas
            </a>
        </div>
        <div class="petugas-toolbar-center">
            <details class="petugas-export-dropdown-details">
                <summary class="petugas-btn-export-trigger">
                    <svg class="petugas-btn-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Export
                    <svg class="petugas-btn-chevron" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                </summary>
                <div class="petugas-export-dropdown">
                    @php $exportQuery = request()->getQueryString() ? '?' . request()->getQueryString() : ''; @endphp
                    <a href="{{ route('dashboard.petugas.export.pdf') }}{{ $exportQuery }}" class="petugas-export-item" target="_blank" rel="noopener">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        Export PDF
                    </a>
                </div>
            </details>
        </div>
        <div class="petugas-toolbar-right">
            <form method="GET" action="{{ route('dashboard.petugas.index') }}" class="petugas-search-form">
                <input type="hidden" name="status_kerja" value="{{ request('status_kerja') }}">
                <input type="hidden" name="tanggal_bergabung_dari" value="{{ request('tanggal_bergabung_dari') }}">
                <input type="hidden" name="tanggal_bergabung_sampai" value="{{ request('tanggal_bergabung_sampai') }}">
                <div class="petugas-search-wrap">
                    <svg class="petugas-search-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari petugas..." class="petugas-search-input" aria-label="Cari petugas">
                    <button type="submit" class="petugas-search-submit" aria-label="Cari">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Filter: satu baris horizontal compact --}}
    <form method="GET" action="{{ route('dashboard.petugas.index') }}" class="petugas-filter-bar">
        @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
        <div class="petugas-filter-row">
            <div class="petugas-filter-group">
                <label class="petugas-filter-label">Status Kerja</label>
                <select name="status_kerja" class="petugas-filter-select">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status_kerja') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="cuti" {{ request('status_kerja') === 'cuti' ? 'selected' : '' }}>Cuti</option>
                    <option value="nonaktif" {{ request('status_kerja') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="petugas-filter-group">
                <label class="petugas-filter-label">Tanggal Bergabung Dari</label>
                <input type="date" name="tanggal_bergabung_dari" value="{{ request('tanggal_bergabung_dari') }}" class="petugas-filter-input">
            </div>
            <div class="petugas-filter-group">
                <label class="petugas-filter-label">Sampai</label>
                <input type="date" name="tanggal_bergabung_sampai" value="{{ request('tanggal_bergabung_sampai') }}" class="petugas-filter-input">
            </div>
            <div class="petugas-filter-actions">
                <button type="submit" class="btn btn-sm btn-primary">Terapkan</button>
                @if(request()->hasAny(['search','status_kerja','tanggal_bergabung_dari','tanggal_bergabung_sampai']))
                    <a href="{{ route('dashboard.petugas.index') }}" class="btn btn-sm btn-outline">Reset</a>
                @endif
            </div>
        </div>
    </form>
</div>
</section>

{{-- 3. Tabel Data Petugas --}}
<section class="petugas-section">
<div class="card petugas-card petugas-card-table">
    <p class="page-table-desc">Tabel berikut berisi daftar petugas yayasan. Gunakan filter atau pencarian untuk mempersempit hasil, dan gunakan Tombol Tambah Petugas untuk menambah data baru.</p>
    @if ($petugas->isEmpty())
        <div class="petugas-empty">
            <div class="petugas-empty-icon">👥</div>
            <p class="petugas-empty-title">Belum ada data petugas</p>
            <p class="petugas-empty-sub">Mulai dengan menambahkan petugas pendamping pertama.</p>
            <a href="{{ route('dashboard.petugas.create') }}" class="btn btn-primary petugas-empty-btn">+ Tambah Petugas</a>
        </div>
    @else
        <div class="petugas-table-wrap">
            <table class="petugas-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama Petugas</th>
                        <th>Nomor HP</th>
                        <th>Alamat</th>
                        <th>Tanggal Bergabung</th>
                        <th>Status Kerja</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($petugas as $index => $p)
                        <tr>
                            <td class="petugas-cell-no">{{ $petugas->firstItem() + $index }}</td>
                            <td>
                                @if($p->foto_url)
                                    <img src="{{ $p->foto_url }}" alt="{{ $p->name }}" class="petugas-avatar" loading="lazy">
                                @else
                                    <div class="petugas-avatar petugas-avatar-initials" title="{{ $p->name }}">{{ strtoupper(mb_substr($p->name, 0, 1)) }}</div>
                                @endif
                            </td>
                            <td><strong class="petugas-cell-name">{{ $p->name }}</strong></td>
                            <td>{{ $p->no_hp ?? '-' }}</td>
                            <td class="petugas-cell-alamat">{{ Str::limit($p->alamat ?? '-', 35) }}</td>
                            <td>{{ $p->tanggal_bergabung?->translatedFormat('d M Y') ?? '-' }}</td>
                            <td>
                                @if($p->status_kerja === 'aktif')
                                    <span class="badge badge-paid">Aktif</span>
                                @elseif($p->status_kerja === 'cuti')
                                    <span class="badge badge-pending">Cuti</span>
                                @else
                                    <span class="badge badge-cancel">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="petugas-actions">
                                    <a href="{{ route('dashboard.petugas.show', $p) }}" class="petugas-action-btn petugas-action-detail" title="Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        Detail
                                    </a>
                                    <a href="{{ route('dashboard.petugas.edit', $p) }}" class="petugas-action-btn petugas-action-edit" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        Edit
                                    </a>
                                    @if ($p->id !== $user->id)
                                        <form action="{{ route('dashboard.petugas.destroy', $p) }}" method="POST" class="petugas-action-form" onsubmit="return confirm('Yakin ingin menghapus petugas {{ $p->name }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="petugas-action-btn petugas-action-delete" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                                Hapus
                                            </button>
                                        </form>
                                    @else
                                        <span class="petugas-action-btn petugas-action-disabled" title="Akun Anda">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                            Hapus
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($petugas->hasPages())
            <div class="petugas-pagination">{{ $petugas->links('pagination::default') }}</div>
        @endif
    @endif
</div>
</section>
</div>

@push('styles')
<style>
/* Page & section spacing */
.petugas-page { padding-bottom: 2rem; }
.petugas-section { margin-bottom: 1.5rem; }
.petugas-section:last-child { margin-bottom: 0; }
.petugas-section-stats { margin-bottom: 1.75rem; }

/* Stat cards: shadow, spacing, consistent icons */
.petugas-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.25rem;
}
.petugas-stat-card {
    background: var(--card);
    border-radius: 16px;
    padding: 1.25rem 1.5rem;
    border: 1px solid var(--border);
    box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 12px rgba(0,0,0,0.04);
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.petugas-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0,0,0,0.05), 0 10px 24px rgba(0,0,0,0.08);
}
.petugas-stat-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.petugas-stat-total .petugas-stat-icon { background: linear-gradient(135deg, rgba(59,130,246,0.12), rgba(14,165,233,0.08)); color: var(--primary); }
.petugas-stat-aktif .petugas-stat-icon { background: linear-gradient(135deg, rgba(16,185,129,0.12), rgba(52,211,153,0.08)); color: #059669; }
.petugas-stat-cuti .petugas-stat-icon { background: linear-gradient(135deg, rgba(245,158,11,0.12), rgba(251,191,36,0.08)); color: #d97706; }
.petugas-stat-nonaktif .petugas-stat-icon { background: linear-gradient(135deg, rgba(100,116,139,0.12), rgba(148,163,184,0.08)); color: #64748b; }
.petugas-stat-value { font-size: 1.75rem; font-weight: 800; color: var(--text); line-height: 1.2; }
.petugas-stat-label { font-size: 0.8rem; color: var(--text-muted); margin-top: 2px; font-weight: 500; }

/* Card container */
.petugas-card {
    border-radius: 16px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 12px rgba(0,0,0,0.04);
    border: 1px solid var(--border);
}
.petugas-card-toolbar { padding: 1.25rem 1.5rem; }
.petugas-card-table { padding: 0; overflow: hidden; }

/* Toolbar: flex justify-between, 3 zones */
.petugas-toolbar {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 1rem 1.5rem;
    margin-bottom: 1.25rem;
}
.petugas-toolbar-left {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.petugas-toolbar-center {
    display: flex;
    align-items: center;
    justify-content: center;
}
.petugas-toolbar-right {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    min-width: 0;
}

/* Primary button: Tambah Petugas (plus icon, rounded, shadow, hover) */
.petugas-btn-add {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.25rem;
    background: linear-gradient(135deg, var(--primary), var(--accent));
    color: white;
    font-size: 0.9rem;
    font-weight: 600;
    border-radius: 12px;
    border: none;
    text-decoration: none;
    cursor: pointer;
    box-shadow: 0 1px 3px rgba(59,130,246,0.25), 0 2px 8px rgba(59,130,246,0.15);
    transition: transform 0.15s ease, box-shadow 0.2s ease, filter 0.2s ease;
}
.petugas-btn-add:hover {
    filter: brightness(1.05);
    box-shadow: 0 4px 12px rgba(59,130,246,0.25), 0 2px 6px rgba(0,0,0,0.08);
    transform: translateY(-1px);
}
.petugas-btn-icon { flex-shrink: 0; }

/* Export dropdown */
.petugas-export-dropdown-details {
    position: relative;
}
.petugas-btn-export-trigger {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.1rem;
    background: var(--card);
    color: var(--text);
    font-size: 0.9rem;
    font-weight: 600;
    border: 1px solid var(--border);
    border-radius: 12px;
    cursor: pointer;
    list-style: none;
    font-family: inherit;
    box-shadow: 0 1px 2px rgba(0,0,0,0.04);
    transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
}
.petugas-btn-export-trigger::-webkit-details-marker { display: none; }
.petugas-btn-export-trigger:hover {
    background: #f8fafc;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
}
.petugas-export-dropdown-details[open] .petugas-btn-export-trigger {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
}
.petugas-btn-chevron {
    flex-shrink: 0;
    transition: transform 0.2s ease;
}
.petugas-export-dropdown-details[open] .petugas-btn-chevron {
    transform: rotate(180deg);
}
.petugas-export-dropdown {
    position: absolute;
    top: calc(100% + 6px);
    left: 50%;
    transform: translateX(-50%);
    min-width: 180px;
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.12), 0 2px 8px rgba(0,0,0,0.06);
    padding: 0.35rem;
    z-index: 50;
}
.petugas-export-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.55rem 0.75rem;
    color: var(--text);
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    border-radius: 8px;
    transition: background 0.15s ease;
    cursor: pointer;
}
.petugas-export-item:hover {
    background: #f1f5f9;
}
.petugas-export-item svg { flex-shrink: 0; color: var(--text-muted); }

/* Search: right zone, icon inside, rounded, shadow */
.petugas-search-form { width: 100%; max-width: 260px; }
.petugas-search-wrap {
    position: relative;
    display: flex;
    align-items: center;
}
.petugas-search-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    pointer-events: none;
}
.petugas-search-input {
    width: 100%;
    padding: 0.6rem 44px 0.6rem 44px;
    border: 1px solid var(--border);
    border-radius: 12px;
    font-size: 0.875rem;
    background: var(--card);
    transition: border-color 0.2s, box-shadow 0.2s;
}
.petugas-search-input::placeholder { color: var(--text-muted); }
.petugas-search-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
}
.petugas-search-submit {
    position: absolute;
    right: 6px;
    top: 50%;
    transform: translateY(-50%);
    width: 36px;
    height: 36px;
    min-width: 36px;
    min-height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: transparent;
    border: none;
    border-radius: 8px;
    color: var(--text-muted);
    cursor: pointer;
    transition: color 0.2s, background 0.2s;
}
.petugas-search-submit:hover {
    color: var(--primary);
    background: rgba(59,130,246,0.1);
}
.petugas-search-submit:focus {
    outline: 2px solid var(--primary);
    outline-offset: 2px;
}

/* Filter: one compact row */
.petugas-filter-bar {
    padding: 1rem 0 0;
    border-top: 1px solid var(--border);
}
.petugas-filter-row {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-end;
    gap: 0.75rem 1rem;
}
.petugas-filter-group { display: flex; flex-direction: column; gap: 4px; }
.petugas-filter-label { font-size: 0.7rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.04em; }
.petugas-filter-select,
.petugas-filter-input {
    padding: 0.5rem 10px;
    border: 1px solid var(--border);
    border-radius: 10px;
    font-size: 0.85rem;
    min-width: 130px;
    background: var(--card);
}
.petugas-filter-actions { display: flex; gap: 0.5rem; align-items: center; }
.petugas-filter-actions .btn { cursor: pointer; }

/* Table: hover, padding, avatar */
.petugas-table-wrap {
    overflow-x: auto;
    border-radius: 0 0 16px 16px;
}
.petugas-table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
.petugas-table th {
    text-align: left;
    padding: 1rem 1.25rem;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--text-muted);
    background: #f8fafc;
    border-bottom: 1px solid var(--border);
}
.petugas-table td {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #f1f5f9;
    color: var(--text);
    vertical-align: middle;
}
.petugas-table tbody tr {
    transition: background-color 0.15s ease;
}
.petugas-table tbody tr:hover td {
    background: #f0f9ff;
}
.petugas-table tbody tr:last-child td { border-bottom: none; }

/* Avatar: circular, initials when no photo */
.petugas-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    display: inline-block;
    flex-shrink: 0;
}
.petugas-avatar-initials {
    background: linear-gradient(135deg, var(--primary), var(--accent));
    color: white;
    font-size: 0.95rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
}

/* Action buttons: Detail=blue, Edit=yellow, Hapus=red + icons */
.petugas-actions { display: flex; flex-wrap: wrap; gap: 0.5rem; align-items: center; }
.petugas-action-form { display: inline; margin: 0; }
.petugas-action-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 0.4rem 0.75rem;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: opacity 0.2s, transform 0.15s;
    font-family: inherit;
    pointer-events: auto;
}
.petugas-action-btn[href] { cursor: pointer; }
.petugas-action-btn:hover { opacity: 0.9; transform: translateY(-1px); }
.petugas-action-detail {
    background: #dbeafe;
    color: #1d4ed8;
}
.petugas-action-detail:hover { background: #bfdbfe; color: #1e40af; }
.petugas-action-edit {
    background: #fef3c7;
    color: #b45309;
}
.petugas-action-edit:hover { background: #fde68a; color: #92400e; }
.petugas-action-delete {
    background: #fee2e2;
    color: #dc2626;
}
.petugas-action-delete:hover { background: #fecaca; color: #b91c1c; }
.petugas-action-disabled {
    background: #f1f5f9;
    color: #94a3b8;
    cursor: not-allowed;
    opacity: 0.8;
}
.petugas-action-disabled:hover { transform: none; opacity: 0.8; }

.petugas-pagination { margin-top: 1.5rem; padding: 0 1.25rem 1.25rem; display: flex; justify-content: center; }

/* Empty state */
.petugas-empty { text-align: center; padding: 3rem 1.5rem; color: var(--text-muted); }
.petugas-empty-icon { font-size: 3rem; margin-bottom: 1rem; opacity: 0.6; }
.petugas-empty-title { font-size: 1.1rem; font-weight: 600; color: var(--text); }
.petugas-empty-sub { font-size: 0.9rem; margin-top: 0.25rem; }
.petugas-empty-btn { margin-top: 1rem; display: inline-block; }

/* Chart section */

/* Responsive: Tablet */
@media (max-width: 1024px) {
    .petugas-stats-grid { grid-template-columns: repeat(2, 1fr); gap: 1rem; }
    .petugas-toolbar { gap: 1rem; }
    .petugas-search-form { max-width: 220px; }
    .petugas-filter-row { gap: 0.5rem; }
    .petugas-filter-select, .petugas-filter-input { min-width: 120px; }
    .petugas-table th, .petugas-table td { padding: 0.875rem 1rem; }
}

/* Responsive: Mobile */
@media (max-width: 768px) {
    .petugas-section-stats { margin-bottom: 1.25rem; }
    .petugas-stats-grid { grid-template-columns: 1fr; gap: 0.75rem; }
    .petugas-stat-card { padding: 1rem 1.25rem; }
    .petugas-card-toolbar { padding: 1rem; }
    .petugas-toolbar {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    .petugas-toolbar-left { justify-content: stretch; }
    .petugas-toolbar-left .petugas-btn-add { justify-content: center; }
    .petugas-toolbar-center { justify-content: stretch; }
    .petugas-export-dropdown-details { width: 100%; }
    .petugas-btn-export-trigger { width: 100%; justify-content: center; }
    .petugas-export-dropdown { left: 0; right: 0; transform: none; min-width: 0; }
    .petugas-toolbar-right { justify-content: stretch; }
    .petugas-search-form { max-width: none; width: 100%; }
    .petugas-filter-bar { padding-top: 0.75rem; }
    .petugas-filter-row { flex-direction: column; align-items: stretch; gap: 0.75rem; }
    .petugas-filter-group { min-width: 0; }
    .petugas-filter-select, .petugas-filter-input { min-width: 0; width: 100%; }
    .petugas-filter-actions { flex-wrap: wrap; }
    .petugas-table-wrap { border-radius: 0 0 12px 12px; }
    .petugas-table th, .petugas-table td { padding: 0.75rem 0.875rem; font-size: 0.8125rem; }
    .petugas-actions { flex-wrap: wrap; }
    .petugas-action-btn { padding: 0.35rem 0.6rem; font-size: 0.75rem; }
}
</style>
@endpush

@endsection
