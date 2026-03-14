@extends('layouts.dashboard')

@section('title', 'Jadwal Rehabilitasi')
@section('topbar-title', 'Jadwal Rehabilitasi')

@section('content')
<a href="{{ route('dashboard') }}" class="page-back-link">Back</a>
<div class="jr-page">
    {{-- Breadcrumb --}}
    <nav class="jr-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="jr-breadcrumb-sep">/</span>
        <span class="jr-breadcrumb-current">Jadwal Rehabilitasi</span>
    </nav>

    {{-- Ringkasan --}}
    <section class="jr-stats-section">
        <h2 class="jr-section-label">Ringkasan</h2>
        <div class="jr-stats">
            <div class="jr-stat-card jr-stat-total">
                <div class="jr-stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/><line x1="8" y1="7" x2="12" y2="7"/><line x1="8" y1="11" x2="12" y2="11"/></svg>
                </div>
                <div class="jr-stat-body">
                    <div class="jr-stat-value">{{ number_format($stats['total']) }}</div>
                    <div class="jr-stat-label">Total Jadwal</div>
                </div>
            </div>
            <div class="jr-stat-card jr-stat-aktif">
                <div class="jr-stat-icon">✓</div>
                <div class="jr-stat-body">
                    <div class="jr-stat-value">{{ number_format($stats['aktif']) }}</div>
                    <div class="jr-stat-label">Aktif</div>
                </div>
            </div>
            <div class="jr-stat-card jr-stat-nonaktif">
                <div class="jr-stat-icon">○</div>
                <div class="jr-stat-body">
                    <div class="jr-stat-value">{{ number_format($stats['nonaktif']) }}</div>
                    <div class="jr-stat-label">Nonaktif</div>
                </div>
            </div>
            <div class="jr-stat-card jr-stat-hari">
                <div class="jr-stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <div class="jr-stat-body">
                    <div class="jr-stat-value">{{ number_format($stats['hari_terisi']) }}/7</div>
                    <div class="jr-stat-label">Hari Terisi</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Daftar Jadwal --}}
    <section class="jr-section">
        <p class="page-table-desc">Tabel/kalender di bawah menampilkan jadwal rehabilitasi. Gunakan Tambah Jadwal untuk membuat jadwal baru. Anda dapat beralih antara tampilan Tabel dan Kalender Mingguan.</p>
        <div class="card jr-card">
            <div class="jr-toolbar">
                <div class="jr-toolbar-primary">
                    <a href="{{ route('dashboard.jadwal-rehabilitasi.create') }}" class="jr-btn-primary">
                        <svg class="jr-btn-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Tambah Jadwal
                    </a>
                </div>
                <div class="jr-toolbar-actions">
                    <div class="jr-view-toggle">
                        <a href="{{ route('dashboard.jadwal-rehabilitasi.index', array_merge(request()->except('view'), ['view' => 'table'])) }}" class="jr-view-btn {{ $viewMode === 'table' ? 'jr-view-active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                            Tabel
                        </a>
                        <a href="{{ route('dashboard.jadwal-rehabilitasi.index', array_merge(request()->except('view'), ['view' => 'kalender'])) }}" class="jr-view-btn {{ $viewMode === 'kalender' ? 'jr-view-active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            Kalender Mingguan
                        </a>
                    </div>
                    @php $q = request()->getQueryString() ? '?' . request()->getQueryString() : ''; @endphp
                    <a href="{{ route('dashboard.jadwal-rehabilitasi.export.pdf') }}{{ $q }}" class="jr-btn-export" download>
                        <svg class="jr-btn-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Export PDF
                    </a>
                </div>
            </div>

            {{-- Filter --}}
            <form method="GET" action="{{ route('dashboard.jadwal-rehabilitasi.index') }}" class="jr-filter-bar">
                @if(request('view'))<input type="hidden" name="view" value="{{ request('view') }}">@endif
                <div class="jr-filter-inner">
                    <div class="jr-filter-field">
                        <label class="jr-filter-label">Hari</label>
                        <select name="hari" class="jr-input">
                            <option value="">Semua hari</option>
                            @foreach(\App\Models\RehabilitationSchedule::HARI_LIST as $val => $label)
                                <option value="{{ $val }}" {{ request('hari') == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="jr-filter-field">
                        <label class="jr-filter-label">Status</label>
                        <select name="is_aktif" class="jr-input">
                            <option value="">Semua</option>
                            <option value="1" {{ request('is_aktif') === '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ request('is_aktif') === '0' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                    <div class="jr-filter-actions">
                        <button type="submit" class="jr-btn-search">Cari</button>
                        @if(request()->hasAny(['hari','is_aktif']))
                            <a href="{{ route('dashboard.jadwal-rehabilitasi.index', request()->only('view')) }}" class="jr-btn-reset">Reset</a>
                        @endif
                    </div>
                </div>
                @if(request()->hasAny(['hari','is_aktif']))
                    <div class="jr-active-filter">Filter aktif: {{ $jadwals->total() }} jadwal</div>
                @endif
            </form>

            @if($viewMode === 'kalender')
                {{-- Tampilan Kalender Mingguan --}}
                <div class="jr-calendar-wrap">
                    <div class="jr-calendar-grid">
                        @foreach(\App\Models\RehabilitationSchedule::HARI_LIST as $key => $label)
                            @php $items = $jadwalsForCalendar->get($key, collect()); @endphp
                            <div class="jr-cal-day">
                                <div class="jr-cal-day-header">{{ $label }}</div>
                                <div class="jr-cal-day-body">
                                    @forelse($items as $j)
                                        <div class="jr-cal-item">
                                            <span class="jr-cal-item-name">{{ $j->nama_kegiatan }}</span>
                                            <span class="jr-cal-item-time">{{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }}{{ $j->jam_selesai ? '–' . \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') : '' }}</span>
                                            @if($j->tempat)<span class="jr-cal-item-place">{{ $j->tempat }}</span>@endif
                                            @if($j->pembimbingUser)<span class="jr-cal-item-pembimbing">{{ $j->pembimbingUser->name }}</span>@endif
                                            <div class="jr-cal-item-actions">
                                                <a href="{{ route('dashboard.jadwal-rehabilitasi.edit', $j) }}" class="jr-cal-action">Edit</a>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="jr-cal-empty">—</div>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                {{-- Tampilan Tabel --}}
                @if($jadwals->isEmpty())
                    <div class="jr-empty-state">
                        <div class="jr-empty-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/><line x1="8" y1="7" x2="12" y2="7"/><line x1="8" y1="11" x2="12" y2="11"/></svg>
                        </div>
                        <p class="jr-empty-title">Belum ada jadwal rehabilitasi</p>
                        <p class="jr-empty-sub">
                            @if(request()->hasAny(['hari','is_aktif']))
                                Tidak ada jadwal untuk filter yang dipilih.
                            @else
                                Tambahkan jadwal kegiatan rehabilitasi rutin. Setiap aksi mengirim notifikasi ke email petugas.
                            @endif
                        </p>
                        @if(!request()->hasAny(['hari','is_aktif']))
                            <a href="{{ route('dashboard.jadwal-rehabilitasi.create') }}" class="jr-btn-primary jr-btn-primary-sm">Tambah Jadwal Pertama</a>
                        @endif
                    </div>
                @else
                    <div class="jr-result-info">Menampilkan <strong>{{ $jadwals->firstItem() }}–{{ $jadwals->lastItem() }}</strong> dari <strong>{{ $jadwals->total() }}</strong> jadwal</div>
                    <div class="jr-table-wrap">
                        <table class="jr-table">
                            <thead>
                                <tr>
                                    <th class="jr-th-no">No</th>
                                    <th>Kegiatan</th>
                                    <th>Hari</th>
                                    <th>Jam</th>
                                    <th>Tempat</th>
                                    <th>Pembimbing</th>
                                    <th>Status</th>
                                    <th class="jr-th-aksi">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jadwals as $i => $j)
                                    <tr class="jr-row">
                                        <td class="jr-td-no" data-label="No">{{ $jadwals->firstItem() + $i }}</td>
                                        <td data-label="Kegiatan"><span class="jr-kegiatan-name">{{ $j->nama_kegiatan }}</span></td>
                                        <td data-label="Hari"><span class="jr-badge jr-badge-hari">{{ $j->hari_label }}</span></td>
                                        <td data-label="Jam"><span class="jr-time">{{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }}{{ $j->jam_selesai ? ' – ' . \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') : '' }}</span></td>
                                        <td data-label="Tempat"><span class="jr-place">{{ $j->tempat ?? '–' }}</span></td>
                                        <td data-label="Pembimbing"><span class="jr-pembimbing">{{ $j->pembimbingUser->name ?? '–' }}</span></td>
                                        <td data-label="Status"><span class="jr-badge {{ $j->is_aktif ? 'jr-badge-aktif' : 'jr-badge-nonaktif' }}">{{ $j->is_aktif ? 'Aktif' : 'Nonaktif' }}</span></td>
                                        <td data-label="Aksi">
                                            <div class="jr-action-group">
                                                <a href="{{ route('dashboard.jadwal-rehabilitasi.edit', $j) }}" class="jr-action-btn jr-action-edit">Edit</a>
                                                <form action="{{ route('dashboard.jadwal-rehabilitasi.destroy', $j) }}" method="POST" style="display:inline;" data-confirm="Yakin ingin menghapus jadwal ini? Semua petugas akan menerima notifikasi email.">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="jr-action-btn jr-action-hapus">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($jadwals->hasPages())
                        <div class="jr-pagination">{{ $jadwals->links('pagination::default') }}</div>
                    @endif
                @endif
            @endif
        </div>
    </section>
</div>

@push('styles')
<style>
.jr-page { max-width: 1400px; }
.jr-breadcrumb { font-size: 0.85rem; color: #64748b; margin-bottom: 1.5rem; }
.jr-breadcrumb a { color: #64748b; text-decoration: none; }
.jr-breadcrumb a:hover { color: #2563eb; }
.jr-breadcrumb-sep { margin: 0 0.5rem; opacity: 0.6; }
.jr-breadcrumb-current { color: #0f172a; font-weight: 600; }
.jr-section-label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #64748b; margin-bottom: 0.75rem; }
.jr-stats-section { margin-bottom: 2rem; }
.jr-stats { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 1rem; }
.jr-stat-card { display: flex; align-items: center; gap: 1rem; padding: 1.25rem; background: #fff; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); transition: all 0.2s; }
.jr-stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px -8px rgba(59,130,246,0.2); }
.jr-stat-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0; }
.jr-stat-total .jr-stat-icon { background: linear-gradient(135deg, #eff6ff, #dbeafe); color: #2563eb; }
.jr-stat-aktif .jr-stat-icon { background: linear-gradient(135deg, #ecfdf5, #d1fae5); color: #059669; }
.jr-stat-nonaktif .jr-stat-icon { background: linear-gradient(135deg, #f8fafc, #f1f5f9); color: #64748b; }
.jr-stat-hari .jr-stat-icon { background: linear-gradient(135deg, #fef3c7, #fde68a); color: #d97706; }
.jr-stat-value { font-size: 1.5rem; font-weight: 800; color: #0f172a; line-height: 1.2; }
.jr-stat-label { font-size: 0.8rem; color: #64748b; margin-top: 2px; }
.jr-section { margin-bottom: 2rem; }
.jr-card { padding: 0; overflow: hidden; border-radius: 20px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
.jr-toolbar { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; padding: 1.25rem 1.75rem; border-bottom: 1px solid #e2e8f0; background: #f8fafc; }
.jr-toolbar-primary { display: flex; gap: 0.75rem; }
.jr-toolbar-actions { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
.jr-btn-primary { display: inline-flex; align-items: center; gap: 8px; padding: 0.6rem 1.25rem; background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff; font-size: 0.9rem; font-weight: 600; border-radius: 12px; text-decoration: none; box-shadow: 0 2px 10px rgba(37,99,235,0.35); transition: all 0.18s; }
.jr-btn-primary:hover { background: linear-gradient(135deg, #1d4ed8, #1e40af); box-shadow: 0 4px 16px rgba(37,99,235,0.45); transform: translateY(-1px); color: #fff; }
.jr-btn-primary-sm { margin-top: 1rem; }
.jr-view-toggle { display: flex; gap: 4px; background: #fff; padding: 4px; border-radius: 12px; border: 1px solid #e2e8f0; }
.jr-view-btn { display: inline-flex; align-items: center; gap: 6px; padding: 0.5rem 1rem; font-size: 0.85rem; font-weight: 600; color: #64748b; text-decoration: none; border-radius: 10px; transition: all 0.15s; }
.jr-view-btn:hover { color: #2563eb; background: #eff6ff; }
.jr-view-active { background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff !important; }
.jr-view-active:hover { color: #fff !important; background: linear-gradient(135deg, #1d4ed8, #1e40af) !important; }
.jr-btn-export { display: inline-flex; align-items: center; gap: 6px; padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 600; color: #475569; background: #fff; border: 1.5px solid #cbd5e1; border-radius: 10px; text-decoration: none; transition: all 0.15s; }
.jr-btn-export:hover { border-color: #2563eb; color: #2563eb; background: #eff6ff; }
.jr-btn-icon { flex-shrink: 0; }
.jr-filter-bar { padding: 1.25rem 1.75rem; border-bottom: 1px solid #e2e8f0; background: #fff; }
.jr-filter-inner { display: flex; gap: 1rem; flex-wrap: wrap; align-items: flex-end; }
.jr-filter-field { display: flex; flex-direction: column; gap: 6px; }
.jr-filter-label { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: #475569; }
.jr-input { height: 40px; padding: 0 0.875rem; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.875rem; min-width: 150px; }
.jr-filter-actions { display: flex; gap: 0.5rem; }
.jr-btn-search { height: 40px; padding: 0 1.1rem; background: #2563eb; color: #fff; font-size: 0.875rem; font-weight: 700; border: none; border-radius: 10px; cursor: pointer; }
.jr-btn-search:hover { background: #1d4ed8; }
.jr-btn-reset { height: 40px; padding: 0 1rem; display: inline-flex; align-items: center; background: #fff; color: #64748b; font-size: 0.875rem; font-weight: 600; border: 1.5px solid #cbd5e1; border-radius: 10px; text-decoration: none; }
.jr-btn-reset:hover { border-color: #94a3b8; color: #334155; background: #f1f5f9; }
.jr-active-filter { margin-top: 0.75rem; padding: 5px 12px; display: inline-flex; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 20px; font-size: 0.78rem; font-weight: 600; color: #1d4ed8; }
.jr-calendar-wrap { padding: 1.5rem; overflow-x: auto; }
.jr-calendar-grid { display: grid; grid-template-columns: repeat(7, minmax(140px, 1fr)); gap: 1rem; min-width: 900px; }
.jr-cal-day { border: 1px solid #e2e8f0; border-radius: 14px; overflow: hidden; background: #fff; }
.jr-cal-day-header { background: linear-gradient(135deg, #2563eb, #0ea5e9); color: #fff; padding: 0.75rem 1rem; font-size: 0.9rem; font-weight: 700; text-align: center; }
.jr-cal-day-body { padding: 1rem; min-height: 120px; }
.jr-cal-item { padding: 0.75rem; margin-bottom: 0.75rem; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; }
.jr-cal-item:last-child { margin-bottom: 0; }
.jr-cal-item-name { display: block; font-weight: 700; font-size: 0.9rem; color: #0f172a; margin-bottom: 4px; }
.jr-cal-item-time { font-size: 0.8rem; font-weight: 600; color: #2563eb; }
.jr-cal-item-place, .jr-cal-item-pembimbing { display: block; font-size: 0.75rem; color: #64748b; margin-top: 2px; }
.jr-cal-item-actions { margin-top: 8px; }
.jr-cal-action { font-size: 0.75rem; font-weight: 600; color: #2563eb; text-decoration: none; }
.jr-cal-action:hover { text-decoration: underline; }
.jr-cal-empty { font-size: 0.85rem; color: #94a3b8; font-style: italic; text-align: center; padding: 2rem 0; }
.jr-empty-state { display: flex; flex-direction: column; align-items: center; padding: 4rem 2rem; text-align: center; }
.jr-empty-icon { width: 88px; height: 88px; border-radius: 20px; background: linear-gradient(135deg, #f1f5f9, #e2e8f0); display: flex; align-items: center; justify-content: center; color: #94a3b8; margin-bottom: 1.5rem; }
.jr-empty-title { font-size: 1.1rem; font-weight: 700; color: #0f172a; margin-bottom: 0.5rem; }
.jr-empty-sub { font-size: 0.9rem; color: #64748b; max-width: 360px; line-height: 1.5; }
.jr-result-info { padding: 1rem 1.75rem; font-size: 0.85rem; color: #64748b; border-bottom: 1px solid #e2e8f0; background: #fff; }
.jr-result-info strong { color: #0f172a; }
.jr-table-wrap { overflow-x: auto; }
.jr-table { width: 100%; border-collapse: collapse; font-size: 0.875rem; min-width: 800px; }
.jr-table thead th { padding: 1rem 1.25rem; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: #64748b; background: #f8fafc; border-bottom: 2px solid #e2e8f0; text-align: left; }
.jr-th-no { width: 50px; text-align: center !important; }
.jr-th-aksi { width: 140px; text-align: right !important; }
.jr-table tbody td { padding: 1rem 1.25rem; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
.jr-row:hover td { background: #f8fbff; }
.jr-td-no { text-align: center; color: #94a3b8; font-size: 0.85rem; font-weight: 600; }
.jr-kegiatan-name { font-weight: 600; color: #1e293b; }
.jr-time { font-size: 0.9rem; font-weight: 500; color: #374151; }
.jr-place, .jr-pembimbing { font-size: 0.875rem; color: #475569; }
.jr-badge { display: inline-block; padding: 5px 12px; border-radius: 10px; font-size: 0.78rem; font-weight: 600; }
.jr-badge-hari { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
.jr-badge-aktif { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
.jr-badge-nonaktif { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
.jr-action-group { display: flex; gap: 6px; justify-content: flex-end; flex-wrap: nowrap; }
.jr-action-btn { display: inline-flex; align-items: center; padding: 6px 12px; border-radius: 8px; font-size: 0.8rem; font-weight: 600; cursor: pointer; border: none; text-decoration: none; transition: all 0.15s; }
.jr-action-edit { background: #f8fafc; color: #374151; border: 1px solid #e2e8f0; }
.jr-action-edit:hover { background: #475569; color: #fff; border-color: #475569; }
.jr-action-hapus { background: #fff5f5; color: #dc2626; border: 1px solid #fecaca; }
.jr-action-hapus:hover { background: #ef4444; color: #fff; border-color: #ef4444; }
.jr-pagination { padding: 1.25rem 1.75rem; border-top: 1px solid #e2e8f0; display: flex; justify-content: center; }
@media (max-width: 768px) { .jr-stats { grid-template-columns: repeat(2, 1fr); } .jr-toolbar { flex-direction: column; align-items: stretch; } .jr-toolbar-actions { flex-wrap: wrap; } .jr-calendar-grid { grid-template-columns: repeat(2, 1fr); min-width: 0; } }
@media (max-width: 480px) { .jr-stats { grid-template-columns: 1fr; } .jr-calendar-grid { grid-template-columns: 1fr; } }
</style>
@endpush
@endsection
