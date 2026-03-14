@extends('layouts.dashboard')

@section('title', 'Jadwal Petugas')
@section('topbar-title', 'Jadwal Petugas')

@section('content')
<a href="{{ route('dashboard') }}" class="page-back-link">Back</a>
<div class="jp-page jp-page-layout">
    {{-- Breadcrumb --}}
    <nav class="jp-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="jp-breadcrumb-sep">/</span>
        <span class="jp-breadcrumb-current">Jadwal Petugas</span>
    </nav>

    {{-- Ringkasan --}}
    <section class="jp-stats-section">
        <h2 class="jp-section-label">Ringkasan</h2>
        <div class="jp-stats" aria-label="Ringkasan jadwal">
        <div class="jp-stat-card jp-stat-total">
            <div class="jp-stat-icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div class="jp-stat-body">
                <div class="jp-stat-value" aria-label="{{ $stats['bulan_ini'] }} jadwal bulan ini">{{ number_format($stats['bulan_ini']) }}</div>
                <div class="jp-stat-label">Bulan Ini</div>
            </div>
        </div>
        <div class="jp-stat-card jp-stat-hari">
            <div class="jp-stat-icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div class="jp-stat-body">
                <div class="jp-stat-value" aria-label="{{ $stats['hari_ini'] }} jadwal hari ini">{{ number_format($stats['hari_ini']) }}</div>
                <div class="jp-stat-label">Hari Ini</div>
            </div>
        </div>
        <div class="jp-stat-card jp-stat-pagi">
            <div class="jp-stat-icon" aria-hidden="true">🌅</div>
            <div class="jp-stat-body">
                <div class="jp-stat-value" aria-label="{{ $stats['pagi'] }} shift pagi">{{ number_format($stats['pagi']) }}</div>
                <div class="jp-stat-label">Shift Pagi</div>
            </div>
        </div>
        <div class="jp-stat-card jp-stat-siang">
            <div class="jp-stat-icon" aria-hidden="true">☀️</div>
            <div class="jp-stat-body">
                <div class="jp-stat-value" aria-label="{{ $stats['siang'] }} shift siang">{{ number_format($stats['siang']) }}</div>
                <div class="jp-stat-label">Shift Siang</div>
            </div>
        </div>
        <div class="jp-stat-card jp-stat-malam">
            <div class="jp-stat-icon" aria-hidden="true">🌙</div>
            <div class="jp-stat-body">
                <div class="jp-stat-value" aria-label="{{ $stats['malam'] }} shift malam">{{ number_format($stats['malam']) }}</div>
                <div class="jp-stat-label">Shift Malam</div>
            </div>
        </div>
        </div>
    </section>

    {{-- Daftar Jadwal --}}
    <section class="jp-section" aria-labelledby="jp-list-heading">
        <h2 id="jp-list-heading" class="jp-section-label jp-section-label-main">Daftar Jadwal</h2>
        <p class="page-table-desc">Tabel di bawah menampilkan jadwal jaga petugas (shift pagi/siang/malam). Gunakan Tambah Jadwal untuk menambah jadwal, atau Kelola Shift untuk mengatur waktu shift. Export PDF tersedia untuk unduhan.</p>
        <div class="card jp-card">
            <div class="jp-toolbar">
                <div class="jp-toolbar-primary">
                    <a href="{{ route('dashboard.jadwal-petugas.create') }}" class="jp-btn-primary">
                        <svg class="jp-btn-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Tambah Jadwal
                    </a>
                    <a href="{{ route('dashboard.shifts.index') }}" class="jp-btn-secondary">
                        <svg class="jp-btn-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Kelola Shift
                    </a>
                </div>
                <div class="jp-toolbar-actions">
                    @php $q = request()->getQueryString() ? '?' . request()->getQueryString() : ''; @endphp
                    <a href="{{ route('dashboard.jadwal-petugas.export.pdf') }}{{ $q }}" class="jp-btn-export" download>
                        <svg class="jp-btn-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Download PDF
                    </a>
                </div>
            </div>

            {{-- Tampilan & Periode - satu baris terstruktur --}}
            <div class="jp-controls-row">
                <div class="jp-control-group">
                    <span class="jp-control-label">Tampilan</span>
                    <div class="jp-view-toggle">
                        <a href="{{ route('dashboard.jadwal-petugas.index', array_merge(request()->except('view'), ['view' => 'table'])) }}" class="jp-view-btn {{ ($viewMode ?? 'table') === 'table' ? 'jp-view-active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                            Tabel
                        </a>
                        <a href="{{ route('dashboard.jadwal-petugas.index', array_merge(request()->except('view'), ['view' => 'minggu', 'week' => $weekStart->format('Y-m-d')])) }}" class="jp-view-btn {{ ($viewMode ?? 'table') === 'minggu' ? 'jp-view-active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            Kalender
                        </a>
                    </div>
                </div>
                <div class="jp-control-group jp-period-group">
                    <span class="jp-control-label">Periode</span>
                    <div class="jp-quick-filters" role="group" aria-label="Filter periode">
                        <a href="{{ route('dashboard.jadwal-petugas.index', array_merge(request()->except('period'), ['period' => 'hari_ini'])) }}" class="jp-chip {{ request('period') === 'hari_ini' ? 'jp-chip-active' : '' }}" aria-pressed="{{ request('period') === 'hari_ini' ? 'true' : 'false' }}">Hari Ini</a>
                        <a href="{{ route('dashboard.jadwal-petugas.index', array_merge(request()->except('period'), ['period' => 'minggu_ini'])) }}" class="jp-chip {{ request('period') === 'minggu_ini' ? 'jp-chip-active' : '' }}" aria-pressed="{{ request('period') === 'minggu_ini' ? 'true' : 'false' }}">Minggu Ini</a>
                        <a href="{{ route('dashboard.jadwal-petugas.index', array_merge(request()->except('period'), ['period' => 'bulan_ini'])) }}" class="jp-chip {{ request('period') === 'bulan_ini' ? 'jp-chip-active' : '' }}" aria-pressed="{{ request('period') === 'bulan_ini' ? 'true' : 'false' }}">Bulan Ini</a>
                        <a href="{{ route('dashboard.jadwal-petugas.index', request()->except('period')) }}" class="jp-chip {{ !request('period') ? 'jp-chip-active' : '' }}" aria-pressed="{{ !request('period') ? 'true' : 'false' }}">Semua</a>
                    </div>
                </div>
            </div>

            {{-- Filter lanjutan - collapsible agar tidak memadati --}}
            <details class="jp-filter-details" {{ request()->hasAny(['user_id','shift','shift_id','tanggal_dari','tanggal_sampai']) ? 'open' : '' }}>
                <summary class="jp-filter-summary">
                    <svg class="jp-filter-chevron" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                    <span class="jp-filter-summary-icon">🔍</span>
                    <span>Filter lanjutan</span>
                    @if(request()->hasAny(['user_id','shift','shift_id','tanggal_dari','tanggal_sampai']))
                        <span class="jp-filter-active-badge">Aktif</span>
                    @endif
                </summary>
                <form method="GET" action="{{ route('dashboard.jadwal-petugas.index') }}" class="jp-filter-bar jp-filter-form" id="jp-filter-form">
                    @if(request('period'))<input type="hidden" name="period" value="{{ request('period') }}">@endif
                    @if(request('view'))<input type="hidden" name="view" value="{{ request('view') }}">@endif
                    @if(request('week'))<input type="hidden" name="week" value="{{ request('week') }}">@endif
                    <div class="jp-filter-grid">
                    <div class="jp-filter-field">
                        <label class="jp-filter-label" for="filter-user">Petugas</label>
                        <select name="user_id" id="filter-user" class="jp-input" aria-label="Filter berdasarkan petugas">
                            <option value="">Semua petugas</option>
                            @foreach($petugasList as $p)
                                <option value="{{ $p->id }}" {{ request('user_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="jp-filter-field">
                        <label class="jp-filter-label" for="filter-shift">Shift</label>
                        <select name="shift_id" id="filter-shift" class="jp-input" aria-label="Filter berdasarkan shift">
                            <option value="">Semua</option>
                            @foreach($shifts ?? [] as $s)
                                <option value="{{ $s->id }}" {{ request('shift_id') == $s->id ? 'selected' : '' }}>{{ $s->nama }} ({{ \Carbon\Carbon::parse($s->jam_mulai)->format('H:i') }}–{{ \Carbon\Carbon::parse($s->jam_selesai)->format('H:i') }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="jp-filter-field">
                        <label class="jp-filter-label" for="filter-dari">Tanggal dari</label>
                        <input type="date" name="tanggal_dari" id="filter-dari" value="{{ request('tanggal_dari') }}" class="jp-input" aria-label="Filter tanggal dari">
                    </div>
                    <div class="jp-filter-field">
                        <label class="jp-filter-label" for="filter-sampai">Sampai</label>
                        <input type="date" name="tanggal_sampai" id="filter-sampai" value="{{ request('tanggal_sampai') }}" class="jp-input" aria-label="Filter tanggal sampai">
                    </div>
                    <div class="jp-filter-actions">
                        <button type="submit" class="jp-btn-filter" id="jp-btn-filter" aria-busy="false" aria-live="polite">
                            <span class="jp-btn-filter-text">Terapkan</span>
                            <span class="jp-btn-filter-loading" hidden aria-hidden="true">
                                <span class="jp-spinner" aria-hidden="true"></span>
                                Memuat...
                            </span>
                        </button>
                        @if(request()->hasAny(['user_id','shift','shift_id','tanggal_dari','tanggal_sampai']))
                            <a href="{{ route('dashboard.jadwal-petugas.index', request()->only(['period','view','week'])) }}" class="jp-btn-reset">Reset</a>
                        @endif
                    </div>
                </div>
                </form>
            </details>

            @if(($viewMode ?? 'table') === 'minggu')
                {{-- Tampilan kalender bulanan (tanggal 1 sampai akhir bulan) --}}
                <div class="jp-week-nav">
                    <a href="{{ route('dashboard.jadwal-petugas.index', array_merge(request()->except('week'), ['view' => 'minggu', 'week' => ($monthStart->copy()->subMonth()->format('Y-m-d'))])) }}" class="jp-week-arrow" aria-label="Bulan sebelumnya">←</a>
                    <h3 class="jp-week-title">{{ $monthStart->translatedFormat('F Y') }} — 1 s/d {{ $monthEnd->format('d') }}</h3>
                    <a href="{{ route('dashboard.jadwal-petugas.index', array_merge(request()->except('week'), ['view' => 'minggu', 'week' => ($monthStart->copy()->addMonth()->format('Y-m-d'))])) }}" class="jp-week-arrow" aria-label="Bulan berikutnya">→</a>
                </div>
                <div class="jp-week-grid jp-month-grid">
                    @foreach($weekDates as $row)
                        @foreach($row as $date)
                            @php
                                $isCurrentMonth = $date !== null;
                                $dateKey = $isCurrentMonth ? $date->format('Y-m-d') : '';
                                $items = $isCurrentMonth ? $jadwalsByDate->get($dateKey, collect()) : collect();
                                $isToday = $isCurrentMonth && $date->isToday();
                            @endphp
                            <div class="jp-week-day {{ $isToday ? 'jp-week-today' : '' }} {{ !$isCurrentMonth ? 'jp-week-day-out' : '' }}">
                                <div class="jp-week-day-header">
                                    @if($isCurrentMonth)
                                        <span class="jp-week-day-name">{{ $date->translatedFormat('D') }}</span>
                                        <span class="jp-week-day-num">{{ $date->format('d') }}</span>
                                    @else
                                        <span class="jp-week-day-num">—</span>
                                    @endif
                                </div>
                                <div class="jp-week-day-body">
                                    @forelse($items as $j)
                                        @php $weekSlug = in_array(strtolower($j->shift_label ?? ''), ['pagi','siang','malam']) ? strtolower($j->shift_label) : 'default'; @endphp
                                        <a href="{{ route('dashboard.jadwal-petugas.edit', $j) }}" class="jp-week-item jp-week-{{ $weekSlug }} {{ $j->tipe === 'ganti' ? 'jp-week-ganti' : '' }}">
                                            <span class="jp-week-item-name">{{ $j->user->name ?? '–' }}</span>
                                            <span class="jp-week-item-shift">{{ $j->shift_label }}@if($j->tipe === 'ganti') <span class="jp-ganti-tag">Pengganti</span>@endif</span>
                                            <span class="jp-week-item-time">{{ $j->jam_display }}</span>
                                        </a>
                                    @empty
                                        @if($isCurrentMonth)
                                            <span class="jp-week-empty">Tidak ada jadwal</span>
                                        @endif
                                    @endforelse
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            @elseif($jadwals->isEmpty())
                <div class="jp-empty" role="status" aria-live="polite">
                    <div class="jp-empty-icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-dasharray="2 2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <h2 class="jp-empty-title">Belum ada jadwal</h2>
                    <p class="jp-empty-text">Mulai atur jadwal shift petugas untuk memastikan layanan berjalan dengan baik. Klik tombol di bawah untuk menambahkan jadwal pertama.</p>
                    <div class="jp-empty-actions">
                        <a href="{{ route('dashboard.jadwal-petugas.create') }}" class="jp-btn-primary jp-btn-add-sm">+ Tambah Jadwal</a>
                        <a href="{{ route('dashboard.shifts.index') }}" class="jp-empty-secondary">Kelola Shift</a>
                    </div>
                </div>
            @else
                @if(request('user_id') && ($petugasSelected = $petugasList->firstWhere('id', request('user_id'))))
                    <div class="jp-detail-back">
                        <a href="{{ route('dashboard.jadwal-petugas.index', request()->except('user_id', 'page')) }}" class="jp-btn-secondary jp-back-btn">← Kembali ke daftar petugas</a>
                        <span class="jp-detail-label">Jadwal: <strong>{{ $petugasSelected->name }}</strong></span>
                    </div>
                @endif
                <div class="jp-result-info">
                    @if($groupByNama ?? true)
                        Menampilkan <strong>{{ $jadwals->firstItem() }}–{{ $jadwals->lastItem() }}</strong> dari <strong>{{ $jadwals->total() }}</strong> petugas
                    @else
                        Menampilkan <strong>{{ $jadwals->firstItem() }}–{{ $jadwals->lastItem() }}</strong> dari <strong>{{ $jadwals->total() }}</strong> jadwal
                    @endif
                </div>
                <div class="jp-table-wrap" role="region" aria-label="Tabel jadwal petugas">
                    <table class="jp-table" role="table">
                        <thead>
                            <tr>
                                <th>Petugas</th>
                                <th>Shift</th>
                                <th>Jam</th>
                                <th>Hari</th>
                                <th class="jp-th-aksi">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($groupByNama ?? true)
                                @foreach($jadwals as $i => $row)
                                    <tr class="{{ $i % 2 === 0 ? 'jp-row-even' : 'jp-row-odd' }}">
                                        <td data-label="Petugas">
                                            <div class="jp-user-cell">
                                                <div class="jp-user-avatar">{{ strtoupper(substr($row->user->name ?? '?', 0, 1)) }}</div>
                                                <span class="jp-user-name">{{ $row->user->name ?? '–' }}</span>
                                            </div>
                                        </td>
                                        <td data-label="Shift">
                                            @foreach($row->shifts as $sl)
                                                @php $slug = in_array(strtolower($sl), ['pagi','siang','malam']) ? strtolower($sl) : 'default'; @endphp
                                                <span class="jp-badge jp-badge-{{ $slug }}">{{ $sl }}</span>
                                            @endforeach
                                            @if($row->has_ganti ?? false)<span class="jp-badge jp-badge-ganti">Pengganti</span>@endif
                                            @if($row->shifts->isEmpty() && !($row->has_ganti ?? false))<span class="jp-time-muted">–</span>@endif
                                        </td>
                                        <td data-label="Jam"><span class="jp-time">{{ $row->jam }}</span></td>
                                        <td data-label="Hari"><span class="jp-hari">{{ $row->hari ?: '–' }}</span></td>
                                        <td data-label="Aksi">
                                            <a href="{{ route('dashboard.jadwal-petugas.index', array_merge(request()->except('user_id', 'page'), ['user_id' => $row->user->id])) }}" class="jp-action jp-action-edit" title="Kelola jadwal">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                                <span>Kelola</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                @foreach($jadwals as $i => $j)
                                    <tr class="{{ $i % 2 === 0 ? 'jp-row-even' : 'jp-row-odd' }}">
                                        <td data-label="Petugas">
                                            <div class="jp-user-cell">
                                                <div class="jp-user-avatar">{{ strtoupper(substr($j->user->name ?? '?', 0, 1)) }}</div>
                                                <span class="jp-user-name">{{ $j->user->name ?? '–' }}</span>
                                            </div>
                                        </td>
                                        @php $shiftSlug = in_array(strtolower($j->shift_label), ['pagi','siang','malam']) ? strtolower($j->shift_label) : 'default'; @endphp
                                        <td data-label="Shift">
                                            <span class="jp-badge jp-badge-{{ $shiftSlug }}">{{ $j->shift_label }}</span>
                                            @if($j->tipe === 'ganti')<span class="jp-badge jp-badge-ganti">Pengganti</span>@endif
                                        </td>
                                        <td data-label="Jam"><span class="jp-time">{{ $j->jam_display }}</span></td>
                                        <td data-label="Hari"><span class="jp-hari">{{ $j->hari }}</span></td>
                                        <td data-label="Aksi">
                                            <div class="jp-actions">
                                                <a href="{{ route('dashboard.jadwal-petugas.duplicate', $j) }}" class="jp-action jp-action-copy" title="Salin">Salin</a>
                                                <a href="{{ route('dashboard.jadwal-petugas.edit', $j) }}" class="jp-action jp-action-edit" title="Edit">Edit</a>
                                                <form action="{{ route('dashboard.jadwal-petugas.destroy', $j) }}" method="POST" class="jp-action-form" data-confirm="Yakin ingin menghapus jadwal ini?">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="jp-action jp-action-delete" title="Hapus">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                @if($jadwals->hasPages())
                    <div class="jp-pagination">{{ $jadwals->links('pagination::default') }}</div>
                @endif
            @endif
        </div>
    </section>
</div>

@push('styles')
<style>
.jp-page { padding: 0; font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; }
.jp-page-layout { max-width: 1360px; margin: 0 auto; padding: 0 0.5rem; }
.jp-breadcrumb { font-size: 0.875rem; color: #64748b; margin-bottom: 1.5rem; line-height: 1.5; }
.jp-breadcrumb a { color: var(--primary); text-decoration: none; font-weight: 500; }
.jp-breadcrumb a:hover { text-decoration: underline; color: var(--primary-dark); }
.jp-breadcrumb-sep { margin: 0 0.4rem; opacity: 0.6; }
.jp-breadcrumb-current { color: #1e293b; font-weight: 600; }

.jp-section-label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #94a3b8; margin-bottom: 0.75rem; display: block; }
.jp-section-label-main { margin-bottom: 1rem; }
.jp-stats-section { margin-bottom: 2rem; }
.jp-stats { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 1.5rem; }
.jp-stat-card {
    background: var(--card); border-radius: 16px; padding: 1.25rem 1.5rem;
    border: 1px solid var(--border); box-shadow: 0 2px 6px rgba(0,0,0,0.04);
    display: flex; align-items: center; gap: 1.125rem; transition: transform 0.2s, box-shadow 0.2s;
}
.jp-stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
.jp-stat-icon { width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 1.5rem; }
.jp-stat-total .jp-stat-icon { background: linear-gradient(135deg, rgba(59,130,246,0.12), rgba(14,165,233,0.08)); color: var(--primary); }
.jp-stat-hari .jp-stat-icon { background: linear-gradient(135deg, rgba(16,185,129,0.12), rgba(52,211,153,0.08)); color: #059669; }
.jp-stat-pagi .jp-stat-icon { background: linear-gradient(135deg, rgba(245,158,11,0.12), rgba(251,191,36,0.08)); }
.jp-stat-siang .jp-stat-icon { background: linear-gradient(135deg, rgba(34,197,94,0.12), rgba(74,222,128,0.08)); }
.jp-stat-malam .jp-stat-icon { background: linear-gradient(135deg, rgba(99,102,241,0.12), rgba(129,140,248,0.08)); }
.jp-stat-value { font-size: 1.75rem; font-weight: 800; color: #1e293b; line-height: 1.3; letter-spacing: -0.02em; }
.jp-stat-label { font-size: 0.8125rem; color: #64748b; margin-top: 4px; font-weight: 600; }

.jp-section { margin-top: 0; }
.jp-card { padding: 0; overflow: hidden; border-radius: 20px; box-shadow: 0 2px 12px rgba(0,0,0,0.04), 0 8px 32px rgba(59,130,246,0.06); border: 1px solid #e2e8f0; }
.jp-toolbar { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1.5rem; padding: 1.75rem 2rem; border-bottom: 1px solid #e2e8f0; background: #ffffff; }
.jp-toolbar-primary { display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap; }
.jp-toolbar-actions { display: flex; align-items: center; gap: 0.5rem; }
.jp-btn-primary {
    display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, #2563eb, #1d4ed8); color: white; font-size: 1rem; font-weight: 700;
    border-radius: 12px; text-decoration: none; box-shadow: 0 4px 12px rgba(37,99,235,0.35);
    transition: transform 0.15s, box-shadow 0.2s; border: none;
}
.jp-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(37,99,235,0.4); color: white; }
.jp-btn-primary:focus-visible, .jp-btn-secondary:focus-visible { outline: none; box-shadow: 0 0 0 3px rgba(37,99,235,0.4); }
.jp-btn-secondary {
    display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.65rem 1.25rem;
    background: #ffffff; color: #475569; font-size: 0.9375rem; font-weight: 600;
    border: 1.5px solid #e2e8f0; border-radius: 12px; text-decoration: none;
    transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.04);
}
.jp-btn-secondary:hover { background: #f8fafc; border-color: #3b82f6; color: #2563eb; box-shadow: 0 0 0 3px rgba(59,130,246,0.12); }
.jp-btn-icon { flex-shrink: 0; }
.jp-btn-export {
    display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.65rem 1.25rem;
    background: #f8fafc; color: #475569; font-size: 0.9375rem; font-weight: 600;
    border: 1.5px solid #e2e8f0; border-radius: 12px; text-decoration: none;
    transition: all 0.2s; font-family: inherit;
}
.jp-btn-export:hover { border-color: var(--primary); color: #2563eb; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }

/* Tampilan & Periode - layout terstruktur */
.jp-controls-row { display: flex; flex-wrap: wrap; align-items: flex-start; gap: 2rem 2.5rem; padding: 1.75rem 2rem; border-bottom: 1px solid #e2e8f0; background: #fff; }
.jp-control-group { display: flex; flex-direction: column; gap: 0.5rem; }
.jp-control-label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #64748b; }
.jp-period-group { flex: 1; min-width: 280px; }
.jp-quick-filters { display: flex; flex-wrap: wrap; align-items: center; gap: 0.5rem; }
.jp-chip { display: inline-flex; padding: 0.55rem 1.125rem; font-size: 0.875rem; font-weight: 600; border-radius: 10px; text-decoration: none; background: #f1f5f9; color: #475569; border: 1.5px solid #e2e8f0; transition: all 0.2s; }
.jp-chip:hover { background: #e2e8f0; color: #1e293b; border-color: #cbd5e1; }
.jp-chip:focus-visible { outline: none; box-shadow: 0 0 0 2px #2563eb; }
.jp-chip-active { background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff; border-color: #2563eb; box-shadow: 0 2px 8px rgba(37,99,235,0.25); }
.jp-chip-active:hover { background: linear-gradient(135deg, #1d4ed8, #1e40af); color: #fff; border-color: #1d4ed8; }

/* Filter collapsible */
.jp-filter-details { border-bottom: 1px solid #e2e8f0; }
.jp-filter-summary { display: flex; align-items: center; gap: 0.75rem; padding: 1.25rem 2rem; cursor: pointer; font-size: 0.9375rem; font-weight: 600; color: #475569; background: #f8fafc; list-style: none; transition: background 0.2s; }
.jp-filter-summary::-webkit-details-marker { display: none; }
.jp-filter-summary:hover { background: #f1f5f9; color: #1e293b; }
.jp-filter-chevron { flex-shrink: 0; transition: transform 0.2s; opacity: 0.6; }
.jp-filter-details[open] .jp-filter-chevron { transform: rotate(180deg); }
.jp-filter-summary-icon { font-size: 1.1rem; opacity: 0.8; }
.jp-filter-active-badge { font-size: 0.7rem; font-weight: 700; padding: 3px 8px; background: #2563eb; color: #fff; border-radius: 6px; margin-left: auto; }
.jp-filter-bar { padding: 0; background: #fff; }
.jp-filter-grid { display: grid; grid-template-columns: minmax(180px, 1fr) minmax(120px, 140px) minmax(150px, 180px) minmax(150px, 180px) auto; gap: 1.5rem; padding: 1.5rem 2rem 1.75rem; align-items: end; }
.jp-filter-field { display: flex; flex-direction: column; gap: 6px; }
.jp-filter-label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; }
.jp-input { height: 42px; padding: 0 1rem; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 0.9375rem; font-family: inherit; background: #fff; min-width: 120px; }
.jp-input:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.12); }
.jp-filter-actions { display: flex; gap: 0.5rem; align-items: flex-end; }
.jp-btn-filter { position: relative; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.6rem 1.25rem; background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff; font-size: 0.9375rem; font-weight: 600; border: none; border-radius: 10px; cursor: pointer; font-family: inherit; transition: all 0.2s; min-width: 100px; }
.jp-btn-filter:hover { filter: brightness(1.05); box-shadow: 0 2px 8px rgba(37,99,235,0.3); }
.jp-btn-filter:focus-visible { outline: none; box-shadow: 0 0 0 3px rgba(37,99,235,0.4); }
.jp-btn-filter[aria-busy="true"] .jp-btn-filter-text { visibility: hidden; }
.jp-btn-filter[aria-busy="true"] .jp-btn-filter-loading { display: inline-flex !important; align-items: center; gap: 0.5rem; position: absolute; }
.jp-spinner { width: 16px; height: 16px; border: 2px solid rgba(255,255,255,0.3); border-top-color: #fff; border-radius: 50%; animation: jp-spin 0.7s linear infinite; }
@keyframes jp-spin { to { transform: rotate(360deg); } }
.jp-btn-reset { padding: 0.6rem 1.25rem; background: #fff; color: #64748b; font-size: 0.9375rem; font-weight: 600; border: 1.5px solid #e2e8f0; border-radius: 10px; text-decoration: none; transition: all 0.2s; }
.jp-btn-reset:hover { background: #f1f5f9; color: #334155; border-color: #cbd5e1; }

.jp-empty { display: flex; flex-direction: column; align-items: center; padding: 4rem 2rem; text-align: center; }
.jp-empty-icon { width: 96px; height: 96px; border-radius: 24px; background: linear-gradient(135deg, #eff6ff, #dbeafe); display: flex; align-items: center; justify-content: center; color: #60a5fa; margin-bottom: 1.5rem; }
.jp-empty-title { font-size: 1.375rem; font-weight: 800; color: #1e293b; margin-bottom: 0.5rem; }
.jp-empty-text { font-size: 1rem; color: #64748b; max-width: 400px; line-height: 1.65; margin-bottom: 1.5rem; }
.jp-empty-actions { display: flex; flex-direction: column; align-items: center; gap: 0.75rem; }
.jp-empty-secondary { font-size: 0.9375rem; font-weight: 600; color: #2563eb; text-decoration: none; }
.jp-empty-secondary:hover { text-decoration: underline; color: #1d4ed8; }
.jp-btn-add-sm { margin-top: 0 !important; font-size: 1rem !important; padding: 0.75rem 1.5rem !important; }

.jp-result-info { padding: 1rem 1.5rem; font-size: 0.9rem; color: #64748b; border-bottom: 1px solid #e2e8f0; background: #f8fafc; line-height: 1.5; }
.jp-result-info strong { color: #1e293b; font-weight: 700; }
.jp-table-wrap { overflow-x: auto; border-radius: 0 0 16px 16px; border: 1px solid #e2e8f0; border-top: none; }
.jp-table { width: 100%; border-collapse: collapse; font-size: 0.9375rem; min-width: 680px; }
.jp-table thead th { padding: 1rem 1.25rem; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: #64748b; background: #f8fafc; border-bottom: 2px solid #e2e8f0; text-align: left; line-height: 1.4; }
.jp-table thead th:first-child { padding-left: 1.5rem; }
.jp-th-aksi { width: 160px; min-width: 140px; text-align: right !important; padding-right: 1.5rem !important; }
.jp-table tbody td { padding: 1rem 1.25rem; vertical-align: middle; line-height: 1.5; border-bottom: 1px solid #f1f5f9; }
.jp-table tbody tr:last-child td { border-bottom: none; }
.jp-table tbody td:first-child { padding-left: 1.5rem; }
.jp-table tbody td:last-child { padding-right: 1.5rem; }
.jp-row-even td { background: #fff; }
.jp-row-odd td { background: #fafbfc; }
.jp-table tbody tr:hover td { background: #f0f9ff !important; }
.jp-user-cell { display: flex; align-items: center; gap: 0.75rem; }
.jp-user-avatar { width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, var(--primary), var(--accent)); color: #fff; font-size: 0.95rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.jp-user-name { font-weight: 600; color: #1e293b; font-size: 0.9375rem; }
.jp-badge { display: inline-block; padding: 4px 10px; border-radius: 8px; font-size: 0.78rem; font-weight: 600; margin: 2px 4px 2px 0; }
.jp-badge:last-of-type { margin-right: 0; }
.jp-badge-pagi { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
.jp-badge-siang { background: #d1fae5; color: #047857; border: 1px solid #a7f3d0; }
.jp-badge-malam { background: #e0e7ff; color: #3730a3; border: 1px solid #c7d2fe; }
.jp-badge-default { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
.jp-badge-ganti { background: #d1fae5; color: #047857; border: 1px solid #a7f3d0; }
.jp-ganti-tag { font-size: 0.65rem; font-weight: 700; opacity: 0.9; }
.jp-hari { font-size: 0.875rem; color: #475569; }
.jp-time { font-size: 0.875rem; font-weight: 500; color: #334155; font-variant-numeric: tabular-nums; }
.jp-time-muted { color: #94a3b8; font-size: 0.875rem; }
.jp-actions { display: flex; gap: 6px; justify-content: flex-end; align-items: center; flex-wrap: wrap; }
.jp-action, .jp-action-form { display: inline-flex; }
.jp-action { display: inline-flex; align-items: center; gap: 5px; padding: 6px 12px; border-radius: 8px; font-size: 0.8125rem; font-weight: 600; text-decoration: none; border: 1px solid transparent; cursor: pointer; font-family: inherit; transition: all 0.15s; white-space: nowrap; }
.jp-action svg { flex-shrink: 0; opacity: 0.9; width: 14px; height: 14px; }
.jp-action-copy { background: #ecfdf5; color: #047857; border-color: #a7f3d0; }
.jp-action-copy:hover { background: #d1fae5; color: #065f46; }
.jp-action-edit { background: #f1f5f9; color: #475569; border-color: #e2e8f0; }
.jp-action-edit:hover { background: #2563eb; color: #fff; border-color: #2563eb; }
.jp-action-delete { background: #fef2f2; color: #dc2626; border-color: #fecaca; }
.jp-action-delete:hover { background: #ef4444; color: #fff; border-color: #ef4444; }
.jp-action:focus-visible, .jp-btn-export:focus-visible, .jp-week-arrow:focus-visible { outline: none; box-shadow: 0 0 0 2px #2563eb; }
.jp-pagination { padding: 1.25rem 1.5rem; border-top: 1px solid #e2e8f0; display: flex; justify-content: center; background: #fafbfc; }

/* Toggle Tabel / Kalender */
.jp-view-toggle { display: inline-flex; align-items: center; gap: 0.5rem; }
.jp-view-btn { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.55rem 1.125rem; font-size: 0.9375rem; font-weight: 600; border-radius: 10px; text-decoration: none; background: #f1f5f9; color: #64748b; border: 1.5px solid #e2e8f0; transition: all 0.2s; }
.jp-view-btn:hover { background: #e2e8f0; color: #334155; }
.jp-view-btn:focus-visible { outline: none; box-shadow: 0 0 0 2px #2563eb; }
.jp-view-active { background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff; border-color: #2563eb; box-shadow: 0 2px 8px rgba(37,99,235,0.2); }
.jp-view-active:hover { background: linear-gradient(135deg, #1d4ed8, #1e40af); color: #fff; }

/* Week view / Kalender */
.jp-week-nav { display: flex; align-items: center; justify-content: space-between; gap: 1rem; padding: 1.25rem 1.5rem; border-bottom: 1px solid #e2e8f0; background: #f8fafc; flex-wrap: wrap; }
.jp-week-arrow { display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 10px; background: #fff; border: 1.5px solid #e2e8f0; color: #2563eb; font-size: 1.1rem; font-weight: 700; text-decoration: none; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.04); }
.jp-week-arrow:hover { background: #2563eb; color: #fff; border-color: #2563eb; box-shadow: 0 2px 8px rgba(37,99,235,0.25); }
.jp-week-title { font-size: 1.1rem; font-weight: 700; color: #1e293b; margin: 0; letter-spacing: -0.01em; }
.jp-week-grid { display: grid; grid-template-columns: repeat(7, minmax(0, 1fr)); gap: 0; min-height: 380px; border: 1px solid #e2e8f0; border-radius: 0 0 16px 16px; overflow: hidden; }
.jp-week-day { display: flex; flex-direction: column; background: #fff; border-right: 1px solid #e2e8f0; min-width: 0; }
.jp-week-day:last-child { border-right: none; }
.jp-week-day-out { background: #f8fafc; }
.jp-week-day-out .jp-week-day-header { background: #f1f5f9; color: #94a3b8; }
.jp-week-today { background: linear-gradient(180deg, rgba(37,99,235,0.06) 0%, rgba(37,99,235,0.02) 100%); box-shadow: inset 0 0 0 2px rgba(37,99,235,0.25); }
.jp-week-day-header { padding: 0.75rem 0.5rem; border-bottom: 1px solid #e2e8f0; text-align: center; background: #f8fafc; flex-shrink: 0; }
.jp-week-day-name { display: block; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; }
.jp-week-day-num { display: block; font-size: 1.15rem; font-weight: 800; color: #1e293b; margin-top: 2px; }
.jp-week-day-body { padding: 0.5rem; flex: 1; display: flex; flex-direction: column; gap: 0.4rem; min-height: 120px; overflow-y: auto; }
.jp-week-item { display: block; padding: 0.5rem 0.6rem; border-radius: 8px; text-decoration: none; font-size: 0.8125rem; border: 1px solid rgba(0,0,0,0.06); transition: all 0.15s; }
.jp-week-item:hover { box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
.jp-week-item-name { display: block; font-weight: 700; color: #1e293b; font-size: 0.8125rem; margin-bottom: 2px; line-height: 1.3; }
.jp-week-item-shift { font-size: 0.7rem; font-weight: 600; opacity: 0.95; }
.jp-week-item-time { display: block; font-size: 0.7rem; color: #64748b; margin-top: 2px; font-variant-numeric: tabular-nums; }
.jp-week-pagi { background: #fffbeb; color: #b45309; border-color: #fde68a; }
.jp-week-siang { background: #ecfdf5; color: #047857; border-color: #a7f3d0; }
.jp-week-malam { background: #eef2ff; color: #4338ca; border-color: #c7d2fe; }
.jp-week-default { background: #f1f5f9; color: #475569; border-color: #e2e8f0; }
.jp-week-ganti { border-left: 3px solid #10b981; }
.jp-week-empty { font-size: 0.75rem; color: #94a3b8; font-style: italic; padding: 0.5rem; text-align: center; }

@media (max-width: 1024px) {
    .jp-filter-grid { grid-template-columns: 1fr 1fr auto; }
    .jp-toolbar { padding: 1.25rem 1.5rem; }
}

.jp-detail-back { display: flex; align-items: center; flex-wrap: wrap; gap: 0.75rem 1rem; margin-bottom: 1rem; padding: 0.75rem 1.5rem; background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 10px; }
.jp-back-btn { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; font-size: 0.875rem !important; }
.jp-detail-label { color: #64748b; font-size: 0.9rem; }
.jp-detail-label strong { color: #1e293b; }

@media (max-width: 768px) {
    .jp-stats { grid-template-columns: repeat(2, 1fr); gap: 1rem; }
    .jp-stat-value { font-size: 1.5rem; }
    .jp-toolbar { flex-direction: column; align-items: stretch; gap: 1rem; padding: 1.25rem 1.25rem; }
    .jp-toolbar-primary { justify-content: stretch; }
    .jp-btn-primary, .jp-btn-secondary { justify-content: center; flex: 1; }
    .jp-toolbar-actions { justify-content: center; }
    .jp-controls-row { flex-direction: column; gap: 1rem; padding: 1.25rem 1.25rem; }
    .jp-period-group { min-width: 100%; }
    .jp-quick-filters { flex-wrap: wrap; }
    .jp-filter-grid { grid-template-columns: 1fr; padding: 1rem 1.25rem; gap: 1rem; }
    .jp-filter-actions { grid-column: 1; }
    .jp-table-wrap { border-radius: 0 0 12px 12px; }
    .jp-table thead th, .jp-table tbody td { padding: 0.75rem 1rem; font-size: 0.875rem; }
    .jp-table thead th:first-child, .jp-table tbody td:first-child { padding-left: 1rem; }
    .jp-week-grid { grid-template-columns: repeat(7, minmax(0, 1fr)); min-height: 320px; overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .jp-week-day { min-width: 100px; }
    .jp-week-day-header { padding: 0.5rem 0.25rem; }
    .jp-week-day-num { font-size: 1rem; }
    .jp-week-item { padding: 0.4rem 0.5rem; font-size: 0.75rem; }
    .jp-week-item-name { font-size: 0.75rem; }
    .jp-actions { flex-wrap: wrap; justify-content: flex-end; gap: 4px; }
    .jp-action { padding: 5px 10px; font-size: 0.75rem; }
}

@media (max-width: 480px) {
    .jp-stats { grid-template-columns: 1fr; }
}
</style>
@endpush

@push('scripts')
<script>
(function() {
    var form = document.getElementById('jp-filter-form');
    var btn = document.getElementById('jp-btn-filter');
    if (form && btn) {
        form.addEventListener('submit', function() {
            btn.setAttribute('aria-busy', 'true');
            btn.disabled = true;
        });
    }
})();
</script>
@endpush
@endsection
