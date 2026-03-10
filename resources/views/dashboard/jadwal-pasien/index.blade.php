@extends('layouts.dashboard')

@section('title', 'Jadwal Pasien')
@section('topbar-title', 'Jadwal Pasien')

@section('content')
<a href="{{ route('dashboard') }}" class="page-back-link">Back</a>
<div class="card jadwal-card">
    {{-- Page Header --}}
    <div class="jadwal-page-header">
        <div class="jadwal-header-left">
            <div class="jadwal-icon-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <h1 class="jadwal-page-title">Jadwal Pasien</h1>
                <p class="jadwal-page-subtitle">Kelola jadwal kontrol, konseling, dan kunjungan pasien rehabilitasi</p>
            </div>
        </div>
        <a href="{{ route('dashboard.jadwal-pasien.create') }}" class="jadwal-btn-add">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Jadwal
        </a>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('dashboard.jadwal-pasien.index') }}" class="jadwal-filter-bar">
        <div class="jadwal-filter-inner">
            <div class="jadwal-filter-field jadwal-filter-search">
                <label class="jadwal-filter-label">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Pasien
                </label>
                <select name="patient_id" class="jadwal-input">
                    <option value="">Semua pasien</option>
                    @foreach($patients as $p)
                        <option value="{{ $p->id }}" {{ request('patient_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>
            <div class="jadwal-filter-field">
                <label class="jadwal-filter-label">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Tanggal Dari
                </label>
                <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" class="jadwal-input">
            </div>
            <div class="jadwal-filter-field">
                <label class="jadwal-filter-label">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Tanggal Sampai
                </label>
                <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" class="jadwal-input">
            </div>
            <div class="jadwal-filter-actions">
                <button type="submit" class="jadwal-btn-search">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Cari
                </button>
                @if(request()->hasAny(['patient_id','tanggal_dari','tanggal_sampai']))
                    <a href="{{ route('dashboard.jadwal-pasien.index') }}" class="jadwal-btn-reset">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        Reset
                    </a>
                @endif
            </div>
        </div>
        @if(request()->hasAny(['patient_id','tanggal_dari','tanggal_sampai']))
            <div class="jadwal-active-filter">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                Filter aktif: {{ $jadwals->total() }} jadwal
            </div>
        @endif
    </form>

    @if($jadwals->isEmpty())
        <div class="jadwal-empty-state">
            <div class="jadwal-empty-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <p class="jadwal-empty-title">Belum ada jadwal pasien</p>
            <p class="jadwal-empty-sub">
                @if(request()->hasAny(['patient_id','tanggal_dari','tanggal_sampai']))
                    Tidak ada jadwal untuk filter yang dipilih.
                @else
                    Mulai dengan menambahkan jadwal pertama.
                @endif
            </p>
            @if(!request()->hasAny(['patient_id','tanggal_dari','tanggal_sampai']))
                <a href="{{ route('dashboard.jadwal-pasien.create') }}" class="jadwal-btn-add jadwal-btn-add-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Tambah Jadwal Pertama
                </a>
            @endif
        </div>
    @else
        <p class="page-table-desc">Tabel di bawah menampilkan jadwal kontrol, konseling, dan kunjungan pasien. Gunakan filter tanggal atau pasien untuk menyaring. Klik Tambah Jadwal untuk membuat jadwal baru.</p>
        <div class="jadwal-result-info">
            Menampilkan <strong>{{ $jadwals->firstItem() }}–{{ $jadwals->lastItem() }}</strong> dari <strong>{{ $jadwals->total() }}</strong> jadwal
        </div>
        <div class="jadwal-table-wrap">
            <table class="jadwal-table">
                <thead>
                    <tr>
                        <th class="jadwal-th-no">No</th>
                        <th>Pasien</th>
                        <th>Pembimbing</th>
                        <th class="jadwal-th-date">Tanggal</th>
                        <th>Jam</th>
                        <th class="jadwal-th-aksi">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jadwals as $i => $j)
                        <tr class="jadwal-row">
                            <td class="jadwal-td-no">{{ $jadwals->firstItem() + $i }}</td>
                            <td>
                                <div class="jadwal-patient-cell">
                                    <div class="jadwal-patient-avatar">{{ strtoupper(mb_substr($j->patient->nama_lengkap ?? '?', 0, 1)) }}</div>
                                    <span class="jadwal-patient-name">{{ $j->patient->nama_lengkap ?? '–' }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="jadwal-pembimbing">{{ $j->pembimbingUser->name ?? '–' }}</span>
                            </td>
                            <td>
                                <div class="jadwal-date-cell">
                                    <svg class="jadwal-date-icon" xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    {{ $j->tanggal?->locale('id')->translatedFormat('d F Y') }}
                                </div>
                            </td>
                            <td>
                                @if($j->jam_mulai)
                                    <span class="jadwal-time">{{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }}{{ $j->jam_selesai ? ' – ' . \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') : '' }}</span>
                                @else
                                    <span class="jadwal-time-muted">–</span>
                                @endif
                            </td>
                            <td>
                                <div class="jadwal-action-group">
                                    <a href="{{ route('dashboard.jadwal-pasien.show', $j) }}" class="jadwal-action-btn jadwal-action-detail" title="Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        Detail
                                    </a>
                                    <a href="{{ route('dashboard.jadwal-pasien.edit', $j) }}" class="jadwal-action-btn jadwal-action-edit" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('dashboard.jadwal-pasien.destroy', $j) }}" method="POST" style="display:inline;" data-confirm="Yakin ingin menghapus jadwal ini?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="jadwal-action-btn jadwal-action-hapus" title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
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
        @if($jadwals->hasPages())
            <div class="jadwal-pagination">{{ $jadwals->links('pagination::default') }}</div>
        @endif
    @endif
</div>

@push('styles')
<style>
.jadwal-card { padding: 0; overflow: hidden; }
.jadwal-page-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1.5rem 1.75rem; border-bottom: 1px solid var(--border);
    flex-wrap: wrap; gap: 1rem;
}
.jadwal-header-left { display: flex; align-items: center; gap: 1rem; }
.jadwal-icon-wrap {
    width: 46px; height: 46px; border-radius: 12px; flex-shrink: 0;
    background: linear-gradient(135deg, #eff6ff, #dbeafe);
    display: flex; align-items: center; justify-content: center;
    color: var(--primary); border: 1px solid #bfdbfe;
}
.jadwal-page-title { font-size: 1.15rem; font-weight: 700; color: var(--text); margin: 0 0 2px; line-height: 1.2; }
.jadwal-page-subtitle { font-size: 0.8rem; color: var(--text-muted); margin: 0; }
.jadwal-btn-add {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 0.55rem 1.25rem;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff; font-size: 0.875rem; font-weight: 600;
    border-radius: 10px; text-decoration: none;
    box-shadow: 0 2px 8px rgba(37,99,235,0.35);
    transition: all 0.18s ease; white-space: nowrap;
}
.jadwal-btn-add:hover {
    background: linear-gradient(135deg, #1d4ed8, #1e40af);
    box-shadow: 0 4px 16px rgba(37,99,235,0.45);
    transform: translateY(-1px); color: #fff;
}
.jadwal-btn-add-sm { margin-top: 1rem; }
.jadwal-filter-bar { padding: 1.25rem 1.75rem; border-bottom: 1px solid var(--border); background: #f8fafc; }
.jadwal-filter-inner { display: flex; gap: 1rem; flex-wrap: wrap; align-items: flex-end; }
.jadwal-filter-field { display: flex; flex-direction: column; gap: 6px; }
.jadwal-filter-search { flex: 1; min-width: 200px; }
.jadwal-filter-label {
    display: flex; align-items: center; gap: 5px;
    font-size: 0.72rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.06em; color: #475569;
}
.jadwal-input {
    height: 40px; padding: 0 0.875rem;
    border: 1.5px solid #cbd5e1; border-radius: 10px;
    font-size: 0.875rem; font-family: inherit; background: #fff;
    min-width: 150px; color: var(--text);
    transition: border-color 0.15s, box-shadow 0.15s;
}
.jadwal-input:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.12); }
.jadwal-filter-actions { display: flex; gap: 0.5rem; align-items: flex-end; }
.jadwal-btn-search {
    display: inline-flex; align-items: center; gap: 6px;
    height: 40px; padding: 0 1.1rem;
    background: #2563eb; color: #fff;
    font-size: 0.875rem; font-weight: 700;
    border: none; border-radius: 10px; cursor: pointer;
    font-family: inherit;
    box-shadow: 0 2px 6px rgba(37,99,235,0.3);
    transition: all 0.18s ease;
}
.jadwal-btn-search:hover { background: #1d4ed8; box-shadow: 0 4px 12px rgba(37,99,235,0.4); transform: translateY(-1px); }
.jadwal-btn-reset {
    display: inline-flex; align-items: center; gap: 5px;
    height: 40px; padding: 0 1rem;
    background: #fff; color: #64748b;
    font-size: 0.875rem; font-weight: 600;
    border: 1.5px solid #cbd5e1; border-radius: 10px;
    text-decoration: none; transition: all 0.15s;
}
.jadwal-btn-reset:hover { border-color: #94a3b8; color: #334155; background: #f1f5f9; }
.jadwal-active-filter {
    display: inline-flex; align-items: center; gap: 5px;
    margin-top: 0.75rem; padding: 5px 12px;
    background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 20px;
    font-size: 0.78rem; font-weight: 600; color: #1d4ed8;
}
.jadwal-empty-state { display: flex; flex-direction: column; align-items: center; padding: 4rem 2rem; text-align: center; }
.jadwal-empty-icon { width: 72px; height: 72px; border-radius: 20px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8; margin-bottom: 1.25rem; }
.jadwal-empty-title { font-size: 1rem; font-weight: 700; color: var(--text); margin-bottom: 0.4rem; }
.jadwal-empty-sub { font-size: 0.875rem; color: var(--text-muted); max-width: 320px; line-height: 1.5; }
.jadwal-result-info { padding: 0.875rem 1.75rem; font-size: 0.8rem; color: #64748b; border-bottom: 1px solid var(--border); background: #fff; }
.jadwal-result-info strong { color: var(--text); }
.jadwal-table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
.jadwal-table { width: 100%; border-collapse: collapse; font-size: 0.875rem; min-width: 520px; }
.jadwal-table thead th {
    padding: 0.875rem 1.25rem;
    font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.07em; color: #64748b;
    background: #f8fafc; border-bottom: 2px solid #e2e8f0;
    white-space: nowrap; text-align: left;
}
.jadwal-th-no { width: 50px; text-align: center !important; }
.jadwal-th-date { width: 120px; }
.jadwal-th-aksi { width: 140px; text-align: right !important; }
.jadwal-table tbody td { padding: 1rem 1.25rem; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
.jadwal-table tbody tr:last-child td { border-bottom: none; }
.jadwal-row { transition: background 0.12s; }
.jadwal-row:hover td { background: #f8fbff; }
.jadwal-td-no { text-align: center; color: #94a3b8; font-size: 0.8rem; font-weight: 600; }
.jadwal-patient-cell { display: flex; align-items: center; gap: 0.7rem; }
.jadwal-patient-avatar {
    width: 34px; height: 34px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(135deg, #2563eb, #0ea5e9);
    color: #fff; font-size: 0.85rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
}
.jadwal-patient-name { font-weight: 600; color: #1e293b; }
.jadwal-date-cell {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 5px 11px;
    background: linear-gradient(135deg, #eff6ff, #dbeafe);
    border: 1px solid #bfdbfe;
    color: #1d4ed8; font-size: 0.8rem; font-weight: 600;
    border-radius: 8px; white-space: nowrap;
}
.jadwal-date-icon { color: #3b82f6; flex-shrink: 0; }
.jadwal-time { font-size: 0.85rem; font-weight: 500; color: #374151; }
.jadwal-time-muted { color: #94a3b8; font-size: 0.85rem; }
.jadwal-place { font-size: 0.855rem; color: #475569; }
.jadwal-pembimbing { font-size: 0.855rem; color: #334155; font-weight: 500; }
.jadwal-badge { display: inline-block; padding: 4px 10px; border-radius: 8px; font-size: 0.75rem; font-weight: 600; }
.jadwal-badge-jenis { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
.jadwal-badge-terjadwal { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
.jadwal-badge-selesai { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
.jadwal-badge-batal { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
.jadwal-action-group { display: flex; gap: 5px; justify-content: flex-end; flex-wrap: nowrap; }
.jadwal-action-btn {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 5px 11px; border-radius: 8px;
    font-size: 0.775rem; font-weight: 700;
    cursor: pointer; border: none; font-family: inherit;
    text-decoration: none; transition: all 0.16s ease;
    white-space: nowrap;
}
.jadwal-action-detail {
    background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe;
}
.jadwal-action-detail:hover { background: #2563eb; color: #fff; border-color: #2563eb; box-shadow: 0 2px 8px rgba(37,99,235,0.3); }
.jadwal-action-edit {
    background: #f8fafc; color: #374151; border: 1px solid #e2e8f0;
}
.jadwal-action-edit:hover { background: #475569; color: #fff; border-color: #475569; box-shadow: 0 2px 8px rgba(71,85,105,0.25); }
.jadwal-action-hapus {
    background: #fff5f5; color: #dc2626; border: 1px solid #fecaca;
}
.jadwal-action-hapus:hover { background: #ef4444; color: #fff; border-color: #ef4444; box-shadow: 0 2px 8px rgba(239,68,68,0.3); }
.jadwal-pagination { padding: 1.25rem 1.75rem; border-top: 1px solid var(--border); display: flex; justify-content: center; }
@media (max-width: 768px) {
    .jadwal-page-header { padding: 1.25rem; }
    .jadwal-filter-bar { padding: 1rem 1.25rem; }
    .jadwal-filter-inner { flex-direction: column; }
    .jadwal-filter-field, .jadwal-filter-search, .jadwal-input { width: 100%; min-width: unset; }
    .jadwal-filter-actions { width: 100%; }
    .jadwal-btn-search, .jadwal-btn-reset { flex: 1; justify-content: center; }
}
</style>
@endpush
@endsection
