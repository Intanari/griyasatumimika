@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('topbar-title', 'Dashboard Petugas Rehabilitasi')

@section('content')
<div class="welcome-banner">
    <div>
        <h2>Selamat datang, {{ $user->name }}! 👋</h2>
        <p>Ringkasan data donasi dan laporan ODGJ. Klik menu di sidebar untuk detail lengkap.</p>
    </div>
</div>

@php
    $stockOut = (int) ($stockStats['out_of_stock'] ?? 0);
    $stockLow = (int) ($stockStats['low_stock'] ?? 0);
    $hasStockAlert = $stockOut > 0 || $stockLow > 0;
@endphp
@if($hasStockAlert)
<div class="dashboard-stock-alert-banner">
    <div class="dashboard-stock-alert-icon">📦</div>
    <div class="dashboard-stock-alert-text">
        <strong>Peringatan Stok Barang</strong>
        @if($stockOut > 0 && $stockLow > 0)
            Ada <strong>{{ $stockOut }} barang habis</strong> dan <strong>{{ $stockLow }} barang hampir habis</strong>. Segera lakukan restock.
        @elseif($stockOut > 0)
            Ada <strong>{{ $stockOut }} barang habis</strong>. Segera lakukan restock.
        @else
            Ada <strong>{{ $stockLow }} barang hampir habis</strong>. Perhatikan dan lakukan restock jika perlu.
        @endif
    </div>
    <a href="{{ route('dashboard.stock.index') }}" class="dashboard-stock-alert-btn">Kelola Stok →</a>
</div>
@endif

<div class="stats-grid">
    <div class="stat-card purple">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ number_format($stats['total_donasi']) }}</div>
                <div class="stat-label">Total Donasi</div>
            </div>
            <div class="stat-icon purple">📋</div>
        </div>
        <div class="stat-sub">Seluruh transaksi</div>
    </div>
    <div class="stat-card teal">
        <div class="stat-header">
            <div>
                <div class="stat-value" style="font-size:1.35rem;">Rp {{ number_format($stats['total_terkumpul'], 0, ',', '.') }}</div>
                <div class="stat-label">Dana Terkumpul</div>
            </div>
            <div class="stat-icon teal">💰</div>
        </div>
        <div class="stat-sub">Donasi berhasil</div>
    </div>
    <div class="stat-card rose">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ number_format($stats['total_laporan_odgj'] ?? 0) }}</div>
                <div class="stat-label">Laporan ODGJ</div>
            </div>
            <div class="stat-icon rose">🚨</div>
        </div>
        <div class="stat-sub">{{ $stats['laporan_odgj_baru'] ?? 0 }} laporan baru</div>
    </div>
    <a href="{{ route('dashboard.stock.index') }}" class="stat-card blue stat-card-link">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ number_format($stockStats['total_items'] ?? 0) }}</div>
                <div class="stat-label">Stok Barang</div>
            </div>
            <div class="stat-icon blue">📦</div>
        </div>
        <div class="stat-sub">{{ $stockStats['low_stock'] ?? 0 }} hampir habis · Klik untuk kelola</div>
    </a>
</div>

{{-- Card Stok Barang (ringkasan + link ke Manajemen Stok) --}}
<div class="card dashboard-stock-card">
    <div class="card-title">
        <span>📦 Stok Barang</span>
        <a href="{{ route('dashboard.stock.index') }}" class="btn-link">Kelola Stok →</a>
    </div>
    <div class="dashboard-stock-stats">
        <div class="dashboard-stock-stat">
            <div class="dashboard-stock-stat-value">{{ number_format($stockStats['total_items'] ?? 0) }}</div>
            <div class="dashboard-stock-stat-label">Jenis Barang</div>
        </div>
        <div class="dashboard-stock-stat">
            <div class="dashboard-stock-stat-value">{{ number_format($stockStats['total_quantity'] ?? 0) }}</div>
            <div class="dashboard-stock-stat-label">Total Unit</div>
        </div>
        <div class="dashboard-stock-stat dashboard-stock-stat-warn">
            <div class="dashboard-stock-stat-value">{{ $stockStats['low_stock'] ?? 0 }}</div>
            <div class="dashboard-stock-stat-label">Hampir Habis</div>
        </div>
        <div class="dashboard-stock-stat dashboard-stock-stat-danger">
            <div class="dashboard-stock-stat-value">{{ $stockStats['out_of_stock'] ?? 0 }}</div>
            <div class="dashboard-stock-stat-label">Habis</div>
        </div>
    </div>
    <p class="dashboard-stock-desc">Ringkasan inventaris barang yayasan. Klik <a href="{{ route('dashboard.stock.index') }}">Kelola Stok</a> untuk daftar barang, restock, dan riwayat transaksi.</p>
</div>

<div class="card patient-dashboard-card">
    <div class="card-title">
        <span>👥 Data Pasien</span>
        <a href="{{ route('dashboard.patients.index') }}" class="btn-link">Lihat Semua →</a>
    </div>
    <div class="patient-stats-grid">
        <div class="patient-stat-item patient-stat-total">
            <div class="patient-stat-icon">👥</div>
            <div class="patient-stat-value">{{ number_format($stats['total_pasien'] ?? 0) }}</div>
            <div class="patient-stat-label">Total Pasien</div>
        </div>
        <div class="patient-stat-item patient-stat-male">
            <div class="patient-stat-icon">♂</div>
            <div class="patient-stat-value">{{ number_format($stats['pasien_laki_laki'] ?? 0) }}</div>
            <div class="patient-stat-label">Laki-laki</div>
        </div>
        <div class="patient-stat-item patient-stat-female">
            <div class="patient-stat-icon">♀</div>
            <div class="patient-stat-value">{{ number_format($stats['pasien_perempuan'] ?? 0) }}</div>
            <div class="patient-stat-label">Perempuan</div>
        </div>
        <div class="patient-stat-item patient-stat-aktif">
            <div class="patient-stat-icon">⏳</div>
            <div class="patient-stat-value">{{ number_format($stats['pasien_aktif'] ?? 0) }}</div>
            <div class="patient-stat-label">Sedang Rehabilitasi</div>
        </div>
        <div class="patient-stat-item patient-stat-selesai">
            <div class="patient-stat-icon">✓</div>
            <div class="patient-stat-value">{{ number_format($stats['pasien_selesai'] ?? 0) }}</div>
            <div class="patient-stat-label">Selesai / Sehat</div>
        </div>
        <div class="patient-stat-item patient-stat-dirujuk">
            <div class="patient-stat-icon">↗</div>
            <div class="patient-stat-value">{{ number_format($stats['pasien_dirujuk'] ?? 0) }}</div>
            <div class="patient-stat-label">Dirujuk</div>
        </div>
    </div>
    <p class="patient-stats-sub">Ringkasan jumlah pasien rehabilitasi. Grafik di bawah menampilkan distribusi status dan jenis kelamin.</p>
    <div class="patient-charts-row">
        <div class="patient-chart-wrap">
            <p class="patient-chart-title">Status Rehabilitasi</p>
            <canvas id="chartPasienStatus" height="220"></canvas>
        </div>
        <div class="patient-chart-wrap">
            <p class="patient-chart-title">Jenis Kelamin</p>
            <canvas id="chartPasienGender" height="220"></canvas>
        </div>
    </div>
</div>

{{-- Kotak Data Petugas (format sama dengan Data Pasien) ───────────────── --}}
<div class="card patient-dashboard-card">
    <div class="card-title">
        <span>👤 Data Petugas</span>
        <a href="{{ route('dashboard.petugas.index') }}" class="btn-link">Lihat Semua →</a>
    </div>
    <div class="patient-stats-grid">
        <div class="patient-stat-item patient-stat-total">
            <div class="patient-stat-icon">👤</div>
            <div class="patient-stat-value">{{ number_format($stats['total_petugas_yayasan'] ?? 0) }}</div>
            <div class="patient-stat-label">Total Petugas</div>
        </div>
        <div class="patient-stat-item patient-stat-male">
            <div class="patient-stat-icon">♂</div>
            <div class="patient-stat-value">{{ number_format($stats['petugas_laki_laki'] ?? 0) }}</div>
            <div class="patient-stat-label">Laki-laki</div>
        </div>
        <div class="patient-stat-item patient-stat-female">
            <div class="patient-stat-icon">♀</div>
            <div class="patient-stat-value">{{ number_format($stats['petugas_perempuan'] ?? 0) }}</div>
            <div class="patient-stat-label">Perempuan</div>
        </div>
        <div class="patient-stat-item patient-stat-aktif">
            <div class="patient-stat-icon">✓</div>
            <div class="patient-stat-value">{{ number_format($stats['petugas_aktif'] ?? 0) }}</div>
            <div class="patient-stat-label">Aktif</div>
        </div>
        <div class="patient-stat-item patient-stat-selesai">
            <div class="patient-stat-icon">📅</div>
            <div class="patient-stat-value">{{ number_format($stats['petugas_cuti'] ?? 0) }}</div>
            <div class="patient-stat-label">Cuti</div>
        </div>
        <div class="patient-stat-item patient-stat-dirujuk">
            <div class="patient-stat-icon">○</div>
            <div class="patient-stat-value">{{ number_format($stats['petugas_nonaktif'] ?? 0) }}</div>
            <div class="patient-stat-label">Nonaktif</div>
        </div>
    </div>
    <p class="patient-stats-sub">Ringkasan jumlah petugas yayasan. Grafik di bawah menampilkan distribusi status kerja dan jenis kelamin.</p>
    <div class="patient-charts-row">
        <div class="patient-chart-wrap">
            <p class="patient-chart-title">Status Kerja</p>
            <canvas id="chartPetugasStatus" height="220"></canvas>
        </div>
        <div class="patient-chart-wrap">
            <p class="patient-chart-title">Jenis Kelamin</p>
            <canvas id="chartPetugasGender" height="220"></canvas>
        </div>
    </div>
</div>

{{-- ── Riwayat Pemeriksaan Card ─────────────────────────────────── --}}
<div class="card exam-dashboard-card">
    <div class="card-title">
        <div style="display:flex;align-items:center;gap:0.6rem;">
            <div class="exam-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 3H5a2 2 0 0 0-2 2v4"/><path d="M9 3h6"/><path d="M15 3h4a2 2 0 0 1 2 2v4"/><path d="M3 9v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V9"/><path d="M12 12v6"/><path d="M9 15h6"/></svg>
            </div>
            <span>Riwayat Pemeriksaan</span>
        </div>
        <a href="{{ route('dashboard.riwayat-pemeriksaan.index') }}" class="btn-link">Lihat Semua →</a>
    </div>

    {{-- Stats row --}}
    <div class="exam-stats-row">
        <div class="exam-stat exam-stat-total">
            <div class="exam-stat-val">{{ number_format($examStats['total'] ?? 0) }}</div>
            <div class="exam-stat-lbl">Total Pemeriksaan</div>
        </div>
        <div class="exam-stat exam-stat-bulan">
            <div class="exam-stat-val">{{ number_format($examStats['bulan_ini'] ?? 0) }}</div>
            <div class="exam-stat-lbl">Bulan Ini</div>
            @php $delta = ($examStats['bulan_ini'] ?? 0) - ($examStats['bulan_lalu'] ?? 0); @endphp
            @if($examStats['bulan_lalu'] > 0)
            <div class="exam-stat-delta {{ $delta >= 0 ? 'delta-up' : 'delta-down' }}">
                {{ $delta >= 0 ? '▲' : '▼' }} {{ abs($delta) }} vs bulan lalu
            </div>
            @endif
        </div>
        <div class="exam-stat exam-stat-lalu">
            <div class="exam-stat-val">{{ number_format($examStats['bulan_lalu'] ?? 0) }}</div>
            <div class="exam-stat-lbl">Bulan Lalu</div>
        </div>
        @if(count($examChartTempat['labels'] ?? []) > 0)
        <div class="exam-stat exam-stat-tempat">
            <div class="exam-stat-val" style="font-size:1rem;line-height:1.3;">{{ $examChartTempat['labels'][0] ?? '–' }}</div>
            <div class="exam-stat-lbl">Tempat Terbanyak</div>
        </div>
        @endif
    </div>

    {{-- Charts --}}
    <div class="exam-charts-row">
        <div class="exam-chart-box">
            <p class="exam-chart-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
                Pemeriksaan per Bulan (6 Bulan Terakhir)
            </p>
            <div class="exam-chart-canvas-wrap">
                <canvas id="chartExamBulan"></canvas>
            </div>
        </div>
        <div class="exam-chart-box">
            <p class="exam-chart-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                Top Tempat Pemeriksaan
            </p>
            <div class="exam-chart-canvas-wrap">
                <canvas id="chartExamTempat"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- ── Aktivitas Pasien Card ──────────────────────────────────── --}}
<div class="card exam-dashboard-card">
    <div class="card-title">
        <div style="display:flex;align-items:center;gap:0.6rem;">
            <div class="exam-card-icon" style="background:linear-gradient(135deg,#dcfce7,#bbf7d0);color:#15803d;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/><path d="M8 12h8"/><path d="M8 16h8"/><path d="M12 8v8"/></svg>
            </div>
            <span>Aktivitas Pasien</span>
        </div>
        <a href="{{ route('dashboard.patient-activities.index') }}" class="btn-link">Lihat Semua →</a>
    </div>
    <div class="exam-stats-row">
        <div class="exam-stat exam-stat-total">
            <div class="exam-stat-val">{{ number_format($activityStats['total'] ?? 0) }}</div>
            <div class="exam-stat-lbl">Total Aktivitas</div>
        </div>
        <div class="exam-stat exam-stat-bulan">
            <div class="exam-stat-val">{{ number_format($activityStats['bulan_ini'] ?? 0) }}</div>
            <div class="exam-stat-lbl">Bulan Ini</div>
        </div>
        <div class="exam-stat exam-stat-lalu">
            <div class="exam-stat-val">{{ number_format($activityStats['hari_ini'] ?? 0) }}</div>
            <div class="exam-stat-lbl">Hari Ini</div>
        </div>
    </div>
</div>

<div class="grid-2">
    <div class="card">
        <div class="card-title">
            <span>❤️ Data Donasi</span>
            <a href="{{ route('dashboard.donasi') }}" class="btn-link">Lihat Semua →</a>
        </div>
        @if ($donasi_terbaru->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <p>Belum ada data donasi.</p>
            </div>
        @else
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Donatur</th>
                            <th>Nominal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($donasi_terbaru->take(5) as $donasi)
                            <tr>
                                <td>
                                    <div style="font-weight:600;">{{ $donasi->donor_name }}</div>
                                    <div style="font-size:0.78rem;color:var(--text-muted);">{{ $donasi->program }}</div>
                                </td>
                                <td style="font-weight:700;color:var(--primary);">{{ $donasi->formatted_amount }}</td>
                                <td>
                                    @if ($donasi->status === 'paid')<span class="badge badge-paid">✅</span>
                                    @elseif ($donasi->status === 'pending')<span class="badge badge-pending">⏳</span>
                                    @else<span class="badge badge-failed">❌</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div class="card">
        <div class="card-title">
            <span>🚨 Laporan ODGJ</span>
            <a href="{{ route('dashboard.laporan') }}" class="btn-link">Lihat Semua →</a>
        </div>
        @if ($laporan_odgj->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <p>Belum ada laporan ODGJ.</p>
            </div>
        @else
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>No. Laporan</th>
                            <th>Kategori</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laporan_odgj->take(5) as $laporan)
                            <tr>
                                <td style="font-weight:600;font-family:monospace;font-size:0.82rem;">{{ $laporan->nomor_laporan }}</td>
                                <td>{{ $laporan->kategori_label }}</td>
                                <td>
                                    @if ($laporan->status === 'baru')<span class="badge badge-pending">🆕 Baru</span>
                                    @elseif ($laporan->status === 'diproses')<span class="badge badge-paid">⏳</span>
                                    @else<span class="badge badge-cancel">✅</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-title">👤 Informasi Akun Saya</div>
    <div class="info-item"><span class="info-key">Nama</span><span class="info-val">{{ $user->name }}</span></div>
    <div class="info-item"><span class="info-key">Email</span><span class="info-val">{{ $user->email }}</span></div>
    <div class="info-item"><span class="info-key">Jabatan</span><span class="info-val">{{ $user->jabatan ?? '-' }}</span></div>
    <div class="info-item"><span class="info-key">No. HP</span><span class="info-val">{{ $user->no_hp ?? '-' }}</span></div>
</div>

@push('styles')
<style>
/* Banner peringatan stok di dashboard (tampil otomatis ketika ada barang habis/hampir habis) */
.dashboard-stock-alert-banner {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding: 1rem 1.25rem;
    background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
    border: 1px solid #f59e0b;
    border-radius: 16px;
    flex-wrap: wrap;
}
.dashboard-stock-alert-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: rgba(245, 158, 11, 0.25);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    flex-shrink: 0;
}
.dashboard-stock-alert-text {
    flex: 1;
    min-width: 0;
    font-size: 0.9rem;
    color: #92400e;
    line-height: 1.4;
}
.dashboard-stock-alert-text strong { color: #b45309; }
.dashboard-stock-alert-btn {
    display: inline-block;
    padding: 0.5rem 1rem;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: #fff !important;
    font-weight: 600;
    font-size: 0.875rem;
    border-radius: 10px;
    text-decoration: none;
    flex-shrink: 0;
    transition: filter 0.2s;
}
.dashboard-stock-alert-btn:hover { filter: brightness(1.1); color: #fff !important; }
@media (max-width: 640px) {
    .dashboard-stock-alert-banner { flex-direction: column; align-items: stretch; text-align: center; }
    .dashboard-stock-alert-icon { margin: 0 auto; }
}

/* Stat card yang bisa diklik (link ke Manajemen Stok) */
.stat-card-link {
    text-decoration: none;
    color: inherit;
    display: block;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
}
.stat-card-link:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 40px -10px rgba(59,130,246,0.2);
}

/* Card Stok Barang di dashboard */
.dashboard-stock-card { margin-bottom: 1.5rem; }
.dashboard-stock-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-bottom: 1rem;
}
.dashboard-stock-stat {
    background: #f8fafc;
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 1rem;
    text-align: center;
    transition: transform 0.2s, box-shadow 0.2s;
}
.dashboard-stock-stat:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.06);
}
.dashboard-stock-stat-value {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--text);
    letter-spacing: -0.02em;
    line-height: 1.2;
}
.dashboard-stock-stat-label {
    font-size: 0.78rem;
    color: var(--text-muted);
    font-weight: 600;
    margin-top: 0.25rem;
}
.dashboard-stock-stat-warn .dashboard-stock-stat-value { color: #b45309; }
.dashboard-stock-stat-warn { border-top: 3px solid #f59e0b; }
.dashboard-stock-stat-danger .dashboard-stock-stat-value { color: #dc2626; }
.dashboard-stock-stat-danger { border-top: 3px solid #ef4444; }
.dashboard-stock-desc {
    font-size: 0.875rem;
    color: var(--text-muted);
    margin: 0;
    padding-top: 0.75rem;
    border-top: 1px solid var(--border);
}
.dashboard-stock-desc a {
    color: var(--primary);
    font-weight: 600;
    text-decoration: none;
}
.dashboard-stock-desc a:hover { text-decoration: underline; }
@media (max-width: 640px) {
    .dashboard-stock-stats { grid-template-columns: repeat(2, 1fr); }
}

.patient-dashboard-card .card-title { margin-bottom: 1.25rem; }
.patient-stats-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 1rem;
    margin-bottom: 1.25rem;
}
.patient-stat-item {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 1.25rem 1rem;
    text-align: center;
    transition: transform 0.2s, box-shadow 0.2s;
}
.patient-stat-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.06);
}
.patient-stat-icon {
    width: 44px; height: 44px;
    margin: 0 auto 0.75rem;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.35rem;
}
.patient-stat-total .patient-stat-icon { background: linear-gradient(135deg, rgba(59,130,246,0.2), rgba(14,165,233,0.15)); }
.patient-stat-male .patient-stat-icon { background: linear-gradient(135deg, rgba(59,130,246,0.2), rgba(99,102,241,0.15)); }
.patient-stat-female .patient-stat-icon { background: linear-gradient(135deg, rgba(236,72,153,0.2), rgba(244,63,94,0.15)); }
.patient-stat-aktif .patient-stat-icon { background: linear-gradient(135deg, rgba(245,158,11,0.2), rgba(251,191,36,0.15)); }
.patient-stat-selesai .patient-stat-icon { background: linear-gradient(135deg, rgba(16,185,129,0.2), rgba(52,211,153,0.15)); }
.patient-stat-dirujuk .patient-stat-icon { background: linear-gradient(135deg, rgba(14,165,233,0.2), rgba(6,182,212,0.15)); }
.patient-stat-value { font-size: 1.5rem; font-weight: 800; color: var(--text); letter-spacing: -0.02em; line-height: 1.2; }
.patient-stat-label { font-size: 0.8rem; color: var(--text-muted); font-weight: 500; margin-top: 0.25rem; }
.patient-stats-sub { font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1.5rem; padding-top: 0.5rem; border-top: 1px solid var(--border); }
.patient-charts-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
.patient-chart-wrap { min-height: 260px; }
.patient-chart-title { font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-bottom: 0.75rem; }
@media (max-width: 1024px) { .patient-stats-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 640px) {
    .patient-stats-grid { grid-template-columns: repeat(2, 1fr); gap: 0.75rem; }
    .patient-stat-item { padding: 1rem 0.75rem; }
    .patient-stat-value { font-size: 1.25rem; }
    .patient-charts-row { grid-template-columns: 1fr; }
}

/* ── Riwayat Pemeriksaan Card ───────────────────────────── */
.exam-dashboard-card .card-title { margin-bottom: 1.25rem; }
.exam-card-icon {
    width: 34px; height: 34px; border-radius: 10px;
    background: linear-gradient(135deg, #eff6ff, #dbeafe);
    border: 1px solid #bfdbfe; color: #2563eb;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
/* Stats row */
.exam-stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}
.exam-stat {
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 14px;
    padding: 1.1rem 1rem;
    text-align: center;
    transition: transform 0.18s, box-shadow 0.18s;
}
.exam-stat:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.06); }
.exam-stat-total { border-top: 3px solid #3b82f6; }
.exam-stat-bulan  { border-top: 3px solid #10b981; }
.exam-stat-lalu   { border-top: 3px solid #94a3b8; }
.exam-stat-tempat { border-top: 3px solid #f59e0b; }
.exam-stat-val  { font-size: 1.6rem; font-weight: 800; color: #0f172a; letter-spacing: -0.02em; line-height: 1.2; margin-bottom: 4px; }
.exam-stat-lbl  { font-size: 0.78rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; }
.exam-stat-delta { font-size: 0.73rem; font-weight: 700; margin-top: 5px; padding: 2px 8px; border-radius: 20px; display: inline-block; }
.delta-up   { background: #dcfce7; color: #15803d; }
.delta-down { background: #fee2e2; color: #dc2626; }
/* Charts */
.exam-charts-row {
    display: grid;
    grid-template-columns: 1.6fr 1fr;
    gap: 1.25rem;
}
.exam-chart-box {
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 14px;
    padding: 1.1rem 1.25rem;
}
.exam-chart-title {
    display: flex; align-items: center; gap: 6px;
    font-size: 0.8rem; font-weight: 700; color: #475569;
    text-transform: uppercase; letter-spacing: 0.05em;
    margin-bottom: 1rem;
}
.exam-chart-canvas-wrap { position: relative; height: 220px; }
/* Responsive */
@media (max-width: 1024px) {
    .exam-stats-row { grid-template-columns: repeat(2, 1fr); }
    .exam-charts-row { grid-template-columns: 1fr; }
}
@media (max-width: 640px) {
    .exam-stats-row { grid-template-columns: repeat(2, 1fr); gap: 0.75rem; }
    .exam-stat { padding: 0.875rem 0.75rem; }
    .exam-stat-val { font-size: 1.3rem; }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
(function() {
    var colors = {
        primary: ['#3b82f6', '#0ea5e9', '#06b6d4'],
        status: ['#f59e0b', '#10b981', '#6366f1'],
        gender: ['#3b82f6', '#ec4899'],
    };
    if (typeof Chart === 'undefined') return;

    new Chart(document.getElementById('chartPasienStatus'), {
        type: 'doughnut',
        data: {
            labels: @json($patientChartStatus['labels'] ?? []),
            datasets: [{
                data: @json($patientChartStatus['data'] ?? []),
                backgroundColor: colors.status,
                borderWidth: 2,
                borderColor: '#fff',
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { position: 'bottom' } },
        },
    });

    new Chart(document.getElementById('chartPasienGender'), {
        type: 'doughnut',
        data: {
            labels: @json($patientChartGender['labels'] ?? []),
            datasets: [{
                data: @json($patientChartGender['data'] ?? []),
                backgroundColor: colors.gender,
                borderWidth: 2,
                borderColor: '#fff',
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { position: 'bottom' } },
        },
    });

    // ── Data Petugas: Status Kerja & Jenis Kelamin ─────────────────────
    var petugasChartStatusEl = document.getElementById('chartPetugasStatus');
    var petugasChartGenderEl = document.getElementById('chartPetugasGender');
    if (petugasChartStatusEl) {
        new Chart(petugasChartStatusEl, {
            type: 'doughnut',
            data: {
                labels: ['Aktif', 'Cuti', 'Nonaktif'],
                datasets: [{
                    data: [
                        {{ (int) ($stats['petugas_aktif'] ?? 0) }},
                        {{ (int) ($stats['petugas_cuti'] ?? 0) }},
                        {{ (int) ($stats['petugas_nonaktif'] ?? 0) }},
                    ],
                    backgroundColor: colors.status,
                    borderWidth: 2,
                    borderColor: '#fff',
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { position: 'bottom' } },
            },
        });
    }
    if (petugasChartGenderEl) {
        new Chart(petugasChartGenderEl, {
            type: 'doughnut',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: [
                        {{ (int) ($stats['petugas_laki_laki'] ?? 0) }},
                        {{ (int) ($stats['petugas_perempuan'] ?? 0) }},
                    ],
                    backgroundColor: colors.gender,
                    borderWidth: 2,
                    borderColor: '#fff',
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { position: 'bottom' } },
            },
        });
    }

    // ── Riwayat Pemeriksaan: Bar per Bulan ───────────────────────────
    var examBulanLabels = @json($examChartBulan['labels'] ?? []);
    var examBulanData   = @json($examChartBulan['data'] ?? []);

    new Chart(document.getElementById('chartExamBulan'), {
        type: 'bar',
        data: {
            labels: examBulanLabels,
            datasets: [{
                label: 'Pemeriksaan',
                data: examBulanData,
                backgroundColor: 'rgba(59,130,246,0.85)',
                borderRadius: 8,
                borderSkipped: false,
                hoverBackgroundColor: 'rgba(37,99,235,0.95)',
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(ctx) { return ' ' + ctx.parsed.y + ' pemeriksaan'; }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11 }, color: '#64748b' },
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0,
                        font: { size: 11 },
                        color: '#94a3b8',
                    },
                    grid: { color: 'rgba(0,0,0,0.04)' },
                },
            },
        },
    });

    // ── Riwayat Pemeriksaan: Horizontal Bar Tempat ───────────────────
    var examTempatLabels = @json($examChartTempat['labels'] ?? []);
    var examTempatData   = @json($examChartTempat['data'] ?? []);

    if (examTempatLabels.length > 0) {
        new Chart(document.getElementById('chartExamTempat'), {
            type: 'bar',
            data: {
                labels: examTempatLabels,
                datasets: [{
                    label: 'Jumlah',
                    data: examTempatData,
                    backgroundColor: [
                        'rgba(16,185,129,0.85)',
                        'rgba(59,130,246,0.75)',
                        'rgba(245,158,11,0.75)',
                        'rgba(139,92,246,0.75)',
                        'rgba(236,72,153,0.75)',
                    ],
                    borderRadius: 6,
                    borderSkipped: false,
                }],
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) { return ' ' + ctx.parsed.x + ' kali'; }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, precision: 0, font: { size: 11 }, color: '#94a3b8' },
                        grid: { color: 'rgba(0,0,0,0.04)' },
                    },
                    y: {
                        grid: { display: false },
                        ticks: { font: { size: 11 }, color: '#374151' },
                    },
                },
            },
        });
    } else {
        var noDataCtx = document.getElementById('chartExamTempat');
        if (noDataCtx) {
            noDataCtx.parentElement.innerHTML = '<div style="display:flex;align-items:center;justify-content:center;height:220px;color:#94a3b8;font-size:0.875rem;">Belum ada data</div>';
        }
    }
})();
</script>
@endpush
@endsection
