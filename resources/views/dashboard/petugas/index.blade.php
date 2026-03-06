@extends('layouts.dashboard')

@section('title', 'Data Petugas')
@section('topbar-title', 'Data Petugas')

@section('content')
<div class="petugas-page">

    {{-- Stat cards --}}
    <section class="petugas-section petugas-section-stats">
        <div class="petugas-stats-grid">
            <div class="petugas-stat-card petugas-stat-total">
                <div class="petugas-stat-icon">👮</div>
                <div class="petugas-stat-body">
                    <div class="petugas-stat-value">{{ number_format($stats['total']) }}</div>
                    <div class="petugas-stat-label">Total Petugas</div>
                </div>
            </div>
            <div class="petugas-stat-card petugas-stat-aktif">
                <div class="petugas-stat-icon">✅</div>
                <div class="petugas-stat-body">
                    <div class="petugas-stat-value">{{ number_format($stats['aktif']) }}</div>
                    <div class="petugas-stat-label">Aktif</div>
                </div>
            </div>
            <div class="petugas-stat-card petugas-stat-cuti">
                <div class="petugas-stat-icon">🛌</div>
                <div class="petugas-stat-body">
                    <div class="petugas-stat-value">{{ number_format($stats['cuti']) }}</div>
                    <div class="petugas-stat-label">Cuti</div>
                </div>
            </div>
            <div class="petugas-stat-card petugas-stat-nonaktif">
                <div class="petugas-stat-icon">🚫</div>
                <div class="petugas-stat-body">
                    <div class="petugas-stat-value">{{ number_format($stats['nonaktif']) }}</div>
                    <div class="petugas-stat-label">Nonaktif</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Toolbar + filter + search --}}
    <section class="petugas-section">
        <div class="card petugas-card-toolbar">
            <div class="petugas-toolbar">
                <div class="petugas-toolbar-left">
                    <div>
                        <div class="petugas-toolbar-title">Data Petugas</div>
                        <div class="petugas-toolbar-subtitle">
                            Kelola akun admin dan petugas rehabilitasi.
                        </div>
                    </div>
                </div>
                <div class="petugas-toolbar-right">
                    <form method="GET" action="{{ route('dashboard.petugas.index') }}" class="petugas-filter-form">
                        <div class="petugas-filter-group">
                            <div class="petugas-search-wrap">
                                <span class="petugas-search-icon">🔍</span>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, jabatan, no HP">
                            </div>
                            <select name="status_kerja">
                                <option value="">Semua status</option>
                                <option value="aktif" {{ request('status_kerja') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="cuti" {{ request('status_kerja') === 'cuti' ? 'selected' : '' }}>Cuti</option>
                                <option value="nonaktif" {{ request('status_kerja') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            <button type="submit" class="btn btn-primary petugas-btn-filter">Terapkan</button>
                            @if(request()->hasAny(['search','status_kerja']))
                                <a href="{{ route('dashboard.petugas.index') }}" class="btn btn-outline petugas-btn-reset">Reset</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- Tabel --}}
    <section class="petugas-section">
        <div class="card petugas-card-table">
            @if($petugas->isEmpty())
                <div class="petugas-empty">
                    <div class="petugas-empty-icon">📭</div>
                    <p class="petugas-empty-title">Belum ada data petugas</p>
                    <p class="petugas-empty-sub">
                        Belum ada petugas yang terdaftar atau filter pencarian terlalu spesifik.
                    </p>
                </div>
            @else
                <div class="petugas-table-wrapper">
                    <table class="petugas-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Jabatan</th>
                            <th>Status Kerja</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($petugas as $i => $p)
                            <tr>
                                <td>{{ $petugas->firstItem() + $i }}</td>
                                <td>
                                    <div class="petugas-name">{{ $p->name }}</div>
                                </td>
                                <td>
                                    <div class="petugas-email">{{ $p->email }}</div>
                                </td>
                                <td>{{ $p->no_hp ?? '–' }}</td>
                                <td>{{ $p->jabatan ?? '–' }}</td>
                                <td>
                                    @php $st = $p->status_kerja ?? 'aktif'; @endphp
                                    @if($st === 'aktif')
                                        <span class="petugas-badge petugas-badge-aktif">Aktif</span>
                                    @elseif($st === 'cuti')
                                        <span class="petugas-badge petugas-badge-cuti">Cuti</span>
                                    @else
                                        <span class="petugas-badge petugas-badge-nonaktif">Nonaktif</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                @if($petugas->hasPages())
                    <div class="petugas-pagination">
                        {{ $petugas->links('pagination::default') }}
                    </div>
                @endif
            @endif
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
.petugas-page { display:flex; flex-direction:column; gap:1.5rem; }
.petugas-section { width:100%; }
.petugas-card-toolbar { padding:1.25rem 1.5rem; }
.petugas-card-table { padding:0; overflow:hidden; }

.petugas-stats-grid {
    display:grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap:1.25rem;
}
.petugas-stat-card {
    background: var(--card);
    border-radius: 16px;
    padding: 1.25rem 1.4rem;
    border: 1px solid var(--border);
    box-shadow: 0 1px 4px rgba(15,23,42,0.04);
    display:flex;
    align-items:center;
    gap:0.9rem;
}
.petugas-stat-icon {
    width:42px;height:42px;
    border-radius:14px;
    display:flex;align-items:center;justify-content:center;
    background:linear-gradient(135deg, rgba(59,130,246,0.1), rgba(14,165,233,0.06));
    font-size:1.3rem;
}
.petugas-stat-total .petugas-stat-icon { background:linear-gradient(135deg, rgba(59,130,246,0.12), rgba(14,165,233,0.08)); }
.petugas-stat-aktif .petugas-stat-icon { background:linear-gradient(135deg, rgba(16,185,129,0.12), rgba(22,163,74,0.08)); }
.petugas-stat-cuti .petugas-stat-icon { background:linear-gradient(135deg, rgba(245,158,11,0.12), rgba(251,191,36,0.08)); }
.petugas-stat-nonaktif .petugas-stat-icon { background:linear-gradient(135deg, rgba(239,68,68,0.12), rgba(248,113,113,0.08)); }
.petugas-stat-value { font-size:1.5rem;font-weight:800;color:var(--text);line-height:1.2; }
.petugas-stat-label { font-size:0.8rem;color:var(--text-muted);margin-top:2px;font-weight:500; }

.petugas-toolbar {
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:1rem;
    flex-wrap:wrap;
}
.petugas-toolbar-title { font-size:1rem;font-weight:700;color:var(--text); }
.petugas-toolbar-subtitle { font-size:0.85rem;color:var(--text-muted);margin-top:2px; }

.petugas-filter-form { display:flex;align-items:center;justify-content:flex-end;width:100%; }
.petugas-filter-group {
    display:flex;
    flex-wrap:wrap;
    gap:0.5rem;
    align-items:center;
    justify-content:flex-end;
}
.petugas-search-wrap {
    position:relative;
    min-width:220px;
}
.petugas-search-wrap input {
    width:100%;
    padding:0.45rem 0.9rem 0.45rem 2rem;
    border-radius:999px;
    border:1px solid var(--border);
    font-size:0.85rem;
}
.petugas-search-icon {
    position:absolute;left:0.65rem;top:50%;transform:translateY(-50%);
    font-size:0.9rem;color:var(--text-muted);
}
.petugas-filter-group select {
    padding:0.45rem 0.8rem;
    border-radius:999px;
    border:1px solid var(--border);
    font-size:0.85rem;
    background:#fff;
}
.petugas-btn-filter,
.petugas-btn-reset {
    padding:0.45rem 0.9rem;
    font-size:0.8rem;
    border-radius:999px;
}

.petugas-table-wrapper { overflow-x:auto; }
.petugas-table {
    width:100%;
    border-collapse:collapse;
    font-size:0.875rem;
}
.petugas-table thead tr {
    background:#f9fafb;
}
.petugas-table th,
.petugas-table td {
    padding:0.7rem 0.9rem;
    border-bottom:1px solid #e5e7eb;
    text-align:left;
}
.petugas-table th {
    font-size:0.72rem;
    text-transform:uppercase;
    letter-spacing:0.06em;
    color:var(--text-muted);
}
.petugas-table tbody tr:hover td {
    background:#f9fafb;
}
.petugas-name { font-weight:600;color:#111827; }
.petugas-email { font-size:0.8rem;color:var(--text-muted); }

.petugas-badge {
    display:inline-flex;
    align-items:center;
    padding:0.18rem 0.65rem;
    border-radius:999px;
    font-size:0.75rem;
    font-weight:600;
}
.petugas-badge-aktif { background:#dcfce7;color:#166534; }
.petugas-badge-cuti { background:#fef9c3;color:#854d0e; }
.petugas-badge-nonaktif { background:#fee2e2;color:#b91c1c; }

.petugas-empty {
    padding:2.5rem 1.5rem;
    text-align:center;
}
.petugas-empty-icon { font-size:2rem;margin-bottom:0.5rem; }
.petugas-empty-title { font-size:1rem;font-weight:600;color:#111827;margin-bottom:0.25rem; }
.petugas-empty-sub { font-size:0.9rem;color:var(--text-muted); }

.petugas-pagination {
    padding:1rem 1.25rem;
    display:flex;
    justify-content:center;
}

@media (max-width: 1024px) {
    .petugas-stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}
@media (max-width: 640px) {
    .petugas-stats-grid { grid-template-columns: minmax(0, 1fr); }
    .petugas-card-toolbar { padding:1rem 1rem; }
    .petugas-filter-group { justify-content:flex-start; }
}
</style>
@endpush

