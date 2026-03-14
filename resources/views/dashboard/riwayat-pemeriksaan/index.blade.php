@extends('layouts.dashboard')

@section('title', 'Riwayat Pemeriksaan')
@section('topbar-title', 'Riwayat Pemeriksaan')

@section('content')
<a href="{{ route('dashboard') }}" class="page-back-link">Back</a>
<div class="card rw-card">

    {{-- Page Header --}}
    <div class="rw-page-header">
        <div class="rw-page-header-left">
            <div class="rw-page-icon-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 3H5a2 2 0 0 0-2 2v4"/><path d="M9 3h6"/><path d="M15 3h4a2 2 0 0 1 2 2v4"/><path d="M3 9v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V9"/><path d="M12 12v6"/><path d="M9 15h6"/></svg>
            </div>
            <div>
                <h1 class="rw-page-title">Riwayat Pemeriksaan</h1>
                <p class="rw-page-subtitle">Kelola catatan hasil pemeriksaan pasien rehabilitasi</p>
            </div>
        </div>
        <a href="{{ route('dashboard.riwayat-pemeriksaan.create') }}" class="rw-btn-add">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Riwayat
        </a>
    </div>

    {{-- Filter & Search --}}
    <form method="GET" action="{{ route('dashboard.riwayat-pemeriksaan.index') }}" class="rw-filter-bar">
        <div class="rw-filter-inner">
            <div class="rw-filter-field rw-filter-search">
                <label class="rw-filter-label">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Cari Pasien
                </label>
                <div class="rw-input-wrap rw-input-icon">
                    <svg class="rw-input-icon-el" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Ketik nama pasien..." class="rw-input rw-input-has-icon">
                </div>
            </div>

            <div class="rw-filter-field">
                <label class="rw-filter-label">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Tanggal Dari
                </label>
                <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" class="rw-input">
            </div>

            <div class="rw-filter-field">
                <label class="rw-filter-label">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Tanggal Sampai
                </label>
                <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" class="rw-input">
            </div>

            <div class="rw-filter-actions">
                <button type="submit" class="rw-btn-search">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Cari
                </button>
                @if(request()->hasAny(['search','tanggal_dari','tanggal_sampai']))
                    <a href="{{ route('dashboard.riwayat-pemeriksaan.index') }}" class="rw-btn-reset">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        Reset
                    </a>
                @endif
            </div>
        </div>

        @if(request()->hasAny(['search','tanggal_dari','tanggal_sampai']))
        <div class="rw-active-filter">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
            Filter aktif: menampilkan {{ $histories->total() }} hasil
        </div>
        @endif
    </form>

    @if ($histories->isEmpty())
        <div class="rw-empty-state">
            <div class="rw-empty-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 3H5a2 2 0 0 0-2 2v4"/><path d="M9 3h6"/><path d="M15 3h4a2 2 0 0 1 2 2v4"/><path d="M3 9v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V9"/><path d="M12 12v6"/><path d="M9 15h6"/></svg>
            </div>
            <p class="rw-empty-title">Belum ada riwayat pemeriksaan</p>
            <p class="rw-empty-sub">
                @if(request()->hasAny(['search','tanggal_dari','tanggal_sampai']))
                    Tidak ditemukan hasil untuk filter yang dipilih.
                @else
                    Mulai dengan menambahkan riwayat pemeriksaan pertama.
                @endif
            </p>
            @if(!request()->hasAny(['search','tanggal_dari','tanggal_sampai']))
            <a href="{{ route('dashboard.riwayat-pemeriksaan.create') }}" class="rw-btn-add rw-btn-add-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Riwayat Pertama
            </a>
            @endif
        </div>
    @else
        <p class="page-table-desc">Tabel berikut berisi riwayat pemeriksaan pasien (keluhan, hasil pemeriksaan, tindakan/obat). Gunakan filter untuk mencari berdasarkan nama pasien atau rentang tanggal. Klik Tambah Riwayat untuk menambah catatan baru.</p>
        {{-- Result count --}}
        <div class="rw-result-info">
            Menampilkan <strong>{{ $histories->firstItem() }}–{{ $histories->lastItem() }}</strong> dari <strong>{{ $histories->total() }}</strong> riwayat pemeriksaan
        </div>

        <div class="rw-table-wrap">
            <table class="rw-table">
                <thead>
                    <tr>
                        <th class="rw-th-no">No</th>
                        <th>Nama Pasien</th>
                        <th class="rw-th-date">Tanggal Pemeriksaan</th>
                        <th>Tempat Pemeriksaan</th>
                        <th class="rw-th-aksi">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($histories as $i => $h)
                    <tr class="rw-row">
                        <td class="rw-td-no" data-label="No">{{ $histories->firstItem() + $i }}</td>

                        <td data-label="Nama Pasien">
                            <div class="rw-patient-cell">
                                <div class="rw-patient-avatar">{{ strtoupper(mb_substr($h->patient->nama_lengkap ?? '?', 0, 1)) }}</div>
                                <span class="rw-patient-name">{{ $h->patient->nama_lengkap ?? '–' }}</span>
                            </div>
                        </td>

                        <td data-label="Tanggal Pemeriksaan">
                            <div class="rw-date-cell">
                                <svg class="rw-date-icon" xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                <span>{{ $h->tanggal_pemeriksaan->translatedFormat('d M Y') }}</span>
                            </div>
                        </td>

                        <td data-label="Tempat Pemeriksaan">
                            <div class="rw-place-cell">
                                <svg class="rw-place-icon" xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                <span>{{ $h->tempat_pemeriksaan }}</span>
                            </div>
                        </td>

                        <td data-label="Aksi">
                            <div class="rw-action-group">
                                <a href="{{ route('dashboard.riwayat-pemeriksaan.show', $h) }}"
                                    class="rw-action-btn rw-action-detail" title="Lihat Detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    Detail
                                </a>
                                <a href="{{ route('dashboard.riwayat-pemeriksaan.edit', $h) }}"
                                    class="rw-action-btn rw-action-edit" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    Edit
                                </a>
                                <form action="{{ route('dashboard.riwayat-pemeriksaan.destroy', $h) }}"
                                    method="POST" style="display:inline;"
                                    data-confirm="Yakin ingin menghapus riwayat pemeriksaan {{ addslashes($h->patient->nama_lengkap ?? '') }}?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rw-action-btn rw-action-hapus" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($histories->hasPages())
            <div class="rw-pagination">
                {{ $histories->links('pagination::default') }}
            </div>
        @endif
    @endif
</div>

@push('styles')
<style>
/* ─── Card ─────────────────────────────────────────── */
.rw-card { padding: 0; overflow: hidden; }

/* ─── Page Header ───────────────────────────────────── */
.rw-page-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1.5rem 1.75rem; border-bottom: 1px solid var(--border);
    flex-wrap: wrap; gap: 1rem;
}
.rw-page-header-left { display: flex; align-items: center; gap: 1rem; }
.rw-page-icon-wrap {
    width: 46px; height: 46px; border-radius: 12px; flex-shrink: 0;
    background: linear-gradient(135deg, #eff6ff, #dbeafe);
    display: flex; align-items: center; justify-content: center;
    color: var(--primary); border: 1px solid #bfdbfe;
}
.rw-page-title { font-size: 1.15rem; font-weight: 700; color: var(--text); margin: 0 0 2px; line-height: 1.2; }
.rw-page-subtitle { font-size: 0.8rem; color: var(--text-muted); margin: 0; }

/* ─── Add Button ────────────────────────────────────── */
.rw-btn-add {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 0.55rem 1.25rem;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff; font-size: 0.875rem; font-weight: 600;
    border-radius: 10px; text-decoration: none;
    box-shadow: 0 2px 8px rgba(37,99,235,0.35);
    transition: all 0.18s ease;
    white-space: nowrap;
}
.rw-btn-add:hover {
    background: linear-gradient(135deg, #1d4ed8, #1e40af);
    box-shadow: 0 4px 16px rgba(37,99,235,0.45);
    transform: translateY(-1px); color: #fff;
}
.rw-btn-add-sm { margin-top: 1rem; }

/* ─── Filter Bar ────────────────────────────────────── */
.rw-filter-bar { padding: 1.25rem 1.75rem; border-bottom: 1px solid var(--border); background: #f8fafc; }
.rw-filter-inner { display: flex; gap: 1rem; flex-wrap: wrap; align-items: flex-end; }
.rw-filter-field { display: flex; flex-direction: column; gap: 6px; }
.rw-filter-search { flex: 1; min-width: 220px; }
.rw-filter-label {
    display: flex; align-items: center; gap: 5px;
    font-size: 0.72rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.06em; color: #475569;
}
.rw-input-wrap { position: relative; }
.rw-input-icon-el { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: #94a3b8; pointer-events: none; }
.rw-input {
    height: 40px; padding: 0 0.875rem;
    border: 1.5px solid #cbd5e1; border-radius: 10px;
    font-size: 0.875rem; font-family: inherit; background: #fff;
    min-width: 150px; color: var(--text);
    transition: border-color 0.15s, box-shadow 0.15s;
    -webkit-appearance: none;
}
.rw-input-has-icon { padding-left: 34px; }
.rw-input:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.12); }
.rw-filter-actions { display: flex; gap: 0.5rem; align-items: flex-end; }
.rw-btn-search {
    display: inline-flex; align-items: center; gap: 6px;
    height: 40px; padding: 0 1.1rem;
    background: #2563eb; color: #fff;
    font-size: 0.875rem; font-weight: 700;
    border: none; border-radius: 10px; cursor: pointer;
    font-family: inherit;
    box-shadow: 0 2px 6px rgba(37,99,235,0.3);
    transition: all 0.18s ease;
}
.rw-btn-search:hover { background: #1d4ed8; box-shadow: 0 4px 12px rgba(37,99,235,0.4); transform: translateY(-1px); }
.rw-btn-reset {
    display: inline-flex; align-items: center; gap: 5px;
    height: 40px; padding: 0 1rem;
    background: #fff; color: #64748b;
    font-size: 0.875rem; font-weight: 600;
    border: 1.5px solid #cbd5e1; border-radius: 10px;
    text-decoration: none; transition: all 0.15s;
}
.rw-btn-reset:hover { border-color: #94a3b8; color: #334155; background: #f1f5f9; }
.rw-active-filter {
    display: inline-flex; align-items: center; gap: 5px;
    margin-top: 0.75rem; padding: 5px 12px;
    background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 20px;
    font-size: 0.78rem; font-weight: 600; color: #1d4ed8;
}

/* ─── Empty State ───────────────────────────────────── */
.rw-empty-state { display: flex; flex-direction: column; align-items: center; padding: 4rem 2rem; text-align: center; }
.rw-empty-icon { width: 72px; height: 72px; border-radius: 20px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8; margin-bottom: 1.25rem; }
.rw-empty-title { font-size: 1rem; font-weight: 700; color: var(--text); margin-bottom: 0.4rem; }
.rw-empty-sub { font-size: 0.875rem; color: var(--text-muted); max-width: 320px; line-height: 1.5; }

/* ─── Result info ───────────────────────────────────── */
.rw-result-info { padding: 0.875rem 1.75rem; font-size: 0.8rem; color: #64748b; border-bottom: 1px solid var(--border); background: #fff; }
.rw-result-info strong { color: var(--text); }

/* ─── Table ─────────────────────────────────────────── */
.rw-table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
.rw-table { width: 100%; border-collapse: collapse; font-size: 0.875rem; min-width: 520px; }
.rw-table thead th {
    padding: 0.875rem 1.25rem;
    font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.07em; color: #64748b;
    background: #f8fafc; border-bottom: 2px solid #e2e8f0;
    white-space: nowrap; text-align: left;
}
.rw-th-no   { width: 50px; text-align: center !important; }
.rw-th-date { width: 145px; }
.rw-th-aksi { width: 200px; text-align: right !important; }
.rw-table tbody td { padding: 1rem 1.25rem; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
.rw-table tbody tr:last-child td { border-bottom: none; }

/* row hover */
.rw-row { transition: background 0.12s; }
.rw-row:hover td { background: #f8fbff; }

/* No column */
.rw-td-no { text-align: center; color: #94a3b8; font-size: 0.8rem; font-weight: 600; }

/* Patient cell */
.rw-patient-cell { display: flex; align-items: center; gap: 0.7rem; }
.rw-patient-avatar {
    width: 34px; height: 34px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(135deg, #2563eb, #0ea5e9);
    color: #fff; font-size: 0.85rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
}
.rw-patient-name { font-weight: 600; color: #1e293b; }

/* Date cell */
.rw-date-cell {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 5px 11px;
    background: linear-gradient(135deg, #eff6ff, #dbeafe);
    border: 1px solid #bfdbfe;
    color: #1d4ed8; font-size: 0.8rem; font-weight: 600;
    border-radius: 8px; white-space: nowrap;
}
.rw-date-icon { color: #3b82f6; flex-shrink: 0; }

/* Place cell */
.rw-place-cell {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 0.855rem; color: #374151;
}
.rw-place-icon { color: #10b981; flex-shrink: 0; }

/* Clipped text */
.rw-clip {
    display: block; max-width: 180px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    color: #475569; font-size: 0.85rem; cursor: default;
}

/* ─── Action Buttons ────────────────────────────────── */
.rw-action-group { display: flex; gap: 5px; justify-content: flex-end; flex-wrap: nowrap; }
.rw-action-btn {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 5px 11px; border-radius: 8px;
    font-size: 0.775rem; font-weight: 700;
    cursor: pointer; border: none; font-family: inherit;
    text-decoration: none; transition: all 0.16s ease;
    white-space: nowrap;
}
.rw-action-detail {
    background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe;
}
.rw-action-detail:hover { background: #2563eb; color: #fff; border-color: #2563eb; box-shadow: 0 2px 8px rgba(37,99,235,0.3); }
.rw-action-edit {
    background: #f8fafc; color: #374151; border: 1px solid #e2e8f0;
}
.rw-action-edit:hover { background: #475569; color: #fff; border-color: #475569; box-shadow: 0 2px 8px rgba(71,85,105,0.25); }
.rw-action-hapus {
    background: #fff5f5; color: #dc2626; border: 1px solid #fecaca;
}
.rw-action-hapus:hover { background: #ef4444; color: #fff; border-color: #ef4444; box-shadow: 0 2px 8px rgba(239,68,68,0.3); }

/* ─── Pagination ────────────────────────────────────── */
.rw-pagination { padding: 1.25rem 1.75rem; border-top: 1px solid var(--border); display: flex; justify-content: center; }
.rw-pagination nav { width: 100%; }

/* ─── Responsive ────────────────────────────────────── */
@media (max-width: 768px) {
    .rw-page-header { padding: 1.25rem; }
    .rw-filter-bar { padding: 1rem 1.25rem; }
    .rw-filter-inner { flex-direction: column; }
    .rw-filter-field, .rw-filter-search, .rw-input { width: 100%; min-width: unset; }
    .rw-filter-actions { width: 100%; }
    .rw-btn-search, .rw-btn-reset { flex: 1; justify-content: center; }
    .rw-result-info { padding: 0.75rem 1.25rem; }
    .rw-pagination { padding: 1rem 1.25rem; }
}
</style>
@endpush
@endsection
