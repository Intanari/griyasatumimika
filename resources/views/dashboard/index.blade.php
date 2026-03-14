@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('topbar-title', 'Dashboard Petugas Rehabilitasi')

@section('content')
<div class="welcome-banner">
    <div>
        <h2>Dashboard Yayasan PeduliJiwa</h2>
        <p>
            Selamat datang, {{ $user->name }}. Dashboard ini merangkum donasi, laporan ODGJ,
            data pasien, petugas, dan stok barang sebagai pusat kendali layanan rehabilitasi
            terpadu Yayasan PeduliJiwa.
        </p>
        <div class="welcome-banner-meta">
            <span class="welcome-banner-tag">Profil Yayasan</span>
            <span>Yayasan PeduliJiwa Indonesia • Rehabilitasi ODGJ</span>
        </div>
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
    <a href="{{ route('dashboard.donasi') }}" class="stat-card purple stat-card-link">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ number_format($stats['total_donasi']) }}</div>
                <div class="stat-label">Total Donasi</div>
            </div>
            <div class="stat-icon purple">📋</div>
        </div>
        <div class="stat-sub">Jumlah orang yang mendonasi · Klik ke halaman donasi</div>
    </a>
    <a href="{{ route('dashboard.laporan') }}" class="stat-card rose stat-card-link">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ number_format($stats['total_laporan_odgj'] ?? 0) }}</div>
                <div class="stat-label">Laporan ODGJ</div>
            </div>
            <div class="stat-icon rose">🚨</div>
        </div>
        <div class="stat-sub">Jumlah orang pelapor · Klik ke halaman laporan ODGJ</div>
    </a>
    <a href="{{ route('dashboard.stock.index') }}" class="stat-card blue stat-card-link">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ number_format($stockStats['total_items'] ?? 0) }}</div>
                <div class="stat-label">Stok Barang</div>
            </div>
            <div class="stat-icon blue">📦</div>
        </div>
        <div class="stat-sub">Jumlah jenis barang · Klik ke halaman stok</div>
    </a>
</div>

{{-- Kotak Stok: Sisa Stok per Barang (berdasarkan data persediaan stok barang) --}}
@if(($stockItems ?? collect())->isNotEmpty())
@php $maxSisa = (int) ($maxSisaStock ?? 1); @endphp
<div class="card dashboard-stock-items-card">
    <div class="card-title dashboard-stock-sisa-title">
        <div class="dashboard-stock-sisa-title-inner">
            <span class="dashboard-stock-sisa-icon" aria-hidden="true">📊</span>
            <span>Sisa Stok per Barang</span>
        </div>
        <a href="{{ route('dashboard.stock.index') }}" class="btn-link">Kelola Stok →</a>
    </div>
    <p class="dashboard-stock-sisa-desc">Nilai sisa = total persediaan dikurangi total pengeluaran untuk setiap nama stok barang.</p>
    <div class="dashboard-stock-sisa-scroll-wrap">
        <button type="button" class="dashboard-stock-sisa-nav dashboard-stock-sisa-nav-prev" aria-label="Sebelumnya" title="Sebelumnya">‹</button>
        <div class="dashboard-stock-sisa-scroll">
            <div class="dashboard-stock-items-grid">
                @foreach($stockItems as $item)
                    <div class="dashboard-stock-item-box">
                        <div class="dashboard-stock-item-header">
                            <div class="dashboard-stock-item-name" title="{{ $item->name }}">{{ $item->name }}</div>
                            <span class="dashboard-stock-item-badge dashboard-stock-item-badge-{{ $item->stock_status }}">
                                @if($item->stock_status === 'habis')
                                    Habis
                                @elseif($item->stock_status === 'low')
                                    Hampir habis
                                @else
                                    Aman
                                @endif
                            </span>
                        </div>
                        <div class="dashboard-stock-item-sisa-big">{{ number_format($item->sisa) }}</div>
                        <div class="dashboard-stock-item-meta">
                            <span class="dashboard-stock-item-qty">{{ number_format($item->sisa) }} {{ $item->unit }}</span>
                            <span class="dashboard-stock-item-category">{{ $item->category_label }}</span>
                        </div>
                        <div class="dashboard-stock-item-sisa-chart">
                            <div class="dashboard-stock-item-sisa-label">Sisa stok</div>
                            <div class="dashboard-stock-item-sisa-bar-wrap">
                                <div class="dashboard-stock-item-sisa-bar" style="width: {{ $maxSisa > 0 ? min(100, round(($item->sisa / $maxSisa) * 100)) : 0 }}%;"></div>
                            </div>
                        </div>
                        @if($item->min_stock > 0)
                            <div class="dashboard-stock-item-progress-label" style="margin-top:0.35rem;font-size:0.72rem;color:var(--text-muted);">
                                Min. stok: {{ number_format($item->min_stock) }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        <button type="button" class="dashboard-stock-sisa-nav dashboard-stock-sisa-nav-next" aria-label="Selanjutnya" title="Selanjutnya">›</button>
    </div>
</div>
@endif

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
        <div class="exam-stat exam-stat-lalu">
            <div class="exam-stat-val">{{ number_format($activityStats['hari_ini'] ?? 0) }}</div>
            <div class="exam-stat-lbl">Hari Ini</div>
        </div>
        <div class="exam-stat exam-stat-minggu">
            <div class="exam-stat-val">{{ number_format($activityStats['minggu_ini'] ?? 0) }}</div>
            <div class="exam-stat-lbl">Minggu Ini</div>
        </div>
        <div class="exam-stat exam-stat-bulan">
            <div class="exam-stat-val">{{ number_format($activityStats['bulan_ini'] ?? 0) }}</div>
            <div class="exam-stat-lbl">Bulan Ini</div>
        </div>
        <div class="exam-stat exam-stat-total">
            <div class="exam-stat-val">{{ number_format($activityStats['total'] ?? 0) }}</div>
            <div class="exam-stat-lbl">Total Semua Aktivitas</div>
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
                                <td data-label="Donatur">
                                    <div style="font-weight:600;">{{ $donasi->donor_name }}</div>
                                    <div style="font-size:0.78rem;color:var(--text-muted);">{{ $donasi->program }}</div>
                                </td>
                                <td data-label="Nominal" style="font-weight:700;color:var(--primary);">{{ $donasi->formatted_amount }}</td>
                                <td data-label="Status">
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
                                <td data-label="No. Laporan" style="font-weight:600;font-family:monospace;font-size:0.82rem;">{{ $laporan->nomor_laporan }}</td>
                                <td data-label="Kategori">{{ $laporan->kategori_label }}</td>
                                <td data-label="Status">
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

/* Stat card yang bisa diklik (link ke Donasi, Laporan ODGJ, Stok) */
.stat-card-link {
    text-decoration: none;
    color: inherit;
    display: block;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
}
.stat-card-link:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 40px -10px rgba(0,0,0,0.15);
}
.stat-card-link.purple:hover { box-shadow: 0 10px 40px -10px rgba(147,51,234,0.25); }
.stat-card-link.rose:hover   { box-shadow: 0 10px 40px -10px rgba(244,63,94,0.25); }
.stat-card-link.blue:hover  { box-shadow: 0 10px 40px -10px rgba(59,130,246,0.2); }

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

/* Grafik stok barang (CSS bar chart) */
.dashboard-stock-chart {
    margin-top: 1.25rem;
    padding-top: 1.25rem;
    border-top: 1px solid var(--border);
}
.dashboard-stock-chart-title {
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-bottom: 0.75rem;
}
.dashboard-stock-chart-bars { display: flex; flex-direction: column; gap: 0.65rem; }
.dashboard-stock-chart-row {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.85rem;
}
.dashboard-stock-chart-label { width: 90px; flex-shrink: 0; font-weight: 600; color: var(--text); }
.dashboard-stock-chart-bar-wrap {
    flex: 1;
    min-width: 0;
    height: 24px;
    background: #f1f5f9;
    border-radius: 8px;
    overflow: hidden;
}
.dashboard-stock-chart-bar {
    height: 100%;
    border-radius: 8px;
    min-width: 4px;
    transition: width 0.3s ease;
}
.dashboard-stock-chart-bar-masuk { background: linear-gradient(90deg, #22c55e, #16a34a); }
.dashboard-stock-chart-bar-keluar { background: linear-gradient(90deg, #f59e0b, #d97706); }
.dashboard-stock-chart-bar-sisa { background: linear-gradient(90deg, #3b82f6, #2563eb); }
.dashboard-stock-chart-value { font-weight: 700; color: var(--text); min-width: 4rem; text-align: right; }

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
/* Kotak Sisa Stok per Barang */
.dashboard-stock-items-card { margin-bottom: 1.5rem; }
.dashboard-stock-sisa-title-inner {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.dashboard-stock-sisa-icon { font-size: 1.25rem; }
.dashboard-stock-sisa-desc {
    font-size: 0.875rem;
    color: var(--text-muted);
    margin: -0.5rem 0 1rem 0;
    line-height: 1.45;
}
.dashboard-stock-sisa-scroll-wrap {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    position: relative;
}
.dashboard-stock-sisa-scroll {
    flex: 1;
    min-width: 0;
    overflow-x: auto;
    overflow-y: hidden;
    scroll-behavior: smooth;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: thin;
}
.dashboard-stock-sisa-scroll::-webkit-scrollbar { height: 6px; }
.dashboard-stock-sisa-scroll::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 3px; }
.dashboard-stock-sisa-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
.dashboard-stock-sisa-nav {
    flex-shrink: 0;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: 1px solid var(--border);
    background: var(--card);
    color: var(--text-muted);
    font-size: 1.25rem;
    line-height: 1;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s, color 0.2s, border-color 0.2s;
}
.dashboard-stock-sisa-nav:hover {
    background: #f1f5f9;
    color: var(--text);
    border-color: #cbd5e1;
}
.dashboard-stock-items-grid {
    display: flex;
    gap: 1rem;
    padding-bottom: 0.5rem;
    margin-bottom: 0;
    width: max-content;
    min-width: 100%;
}
.dashboard-stock-item-box {
    flex: 0 0 200px;
    min-width: 180px;
}
.dashboard-stock-item-sisa-big {
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--primary);
    letter-spacing: -0.02em;
    line-height: 1.2;
    margin: 0.25rem 0 0.1rem 0;
}
.dashboard-stock-item-box {
    background: #f8fafc;
    border-radius: 14px;
    border: 1px solid var(--border);
    padding: 1rem 1rem 0.9rem;
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
}
.dashboard-stock-item-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 0.5rem;
}
.dashboard-stock-item-name {
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--text);
    line-height: 1.3;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.dashboard-stock-item-badge {
    font-size: 0.7rem;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 999px;
    text-transform: uppercase;
    letter-spacing: 0.06em;
}
.dashboard-stock-item-badge-aman {
    background: #dcfce7;
    color: #166534;
}
.dashboard-stock-item-badge-low {
    background: #fef3c7;
    color: #92400e;
}
.dashboard-stock-item-badge-habis {
    background: #fee2e2;
    color: #b91c1c;
}
.dashboard-stock-item-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.5rem;
    font-size: 0.8rem;
    color: var(--text-muted);
}
.dashboard-stock-item-qty {
    font-weight: 700;
    color: var(--text);
}
.dashboard-stock-item-category {
    font-size: 0.78rem;
    padding: 3px 8px;
    border-radius: 999px;
    background: #e0f2fe;
    color: #0369a1;
}
.dashboard-stock-item-progress-wrap {
    margin-top: 0.35rem;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}
.dashboard-stock-item-progress-bar {
    width: 100%;
    height: 6px;
    border-radius: 999px;
    background: #e5e7eb;
    overflow: hidden;
}
.dashboard-stock-item-progress-fill {
    height: 100%;
    border-radius: 999px;
    background: linear-gradient(90deg, #22c55e, #16a34a);
}
.dashboard-stock-item-progress-label {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 0.72rem;
    color: var(--text-muted);
}
/* Grafik sisa stok per card */
.dashboard-stock-item-sisa-chart {
    margin-top: 0.6rem;
    padding-top: 0.5rem;
    border-top: 1px solid var(--border);
}
.dashboard-stock-item-sisa-label {
    font-size: 0.7rem;
    font-weight: 600;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.03em;
    margin-bottom: 0.35rem;
}
.dashboard-stock-item-sisa-bar-wrap {
    height: 10px;
    background: #e2e8f0;
    border-radius: 999px;
    overflow: hidden;
    margin-bottom: 0.25rem;
}
.dashboard-stock-item-sisa-bar {
    height: 100%;
    border-radius: 999px;
    background: linear-gradient(90deg, #3b82f6, #2563eb);
    min-width: 4px;
    transition: width 0.3s ease;
}
.dashboard-stock-item-sisa-value {
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--text);
}
.dashboard-stock-items-chart-wrap {
    border-top: 1px solid var(--border);
    padding-top: 1.25rem;
}
.dashboard-stock-items-chart-title {
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.75rem;
}
.dashboard-stock-items-chart {
    position: relative;
    height: 260px;
}
@media (max-width: 640px) {
    .dashboard-stock-item-box {
        flex: 0 0 160px;
        min-width: 140px;
    }
    .dashboard-stock-sisa-nav { width: 32px; height: 32px; font-size: 1.1rem; }
}
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
.exam-stat-minggu { border-top: 3px solid #f59e0b; }
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
        stock: {
            jumlah: '#3b82f6',
            masuk: '#22c55e',
            keluar: '#f97316',
            sisa: '#0ea5e9',
        },
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

    // Navigasi scroll Sisa Stok per Barang
    var stockScrollEl = document.querySelector('.dashboard-stock-sisa-scroll');
    var stockPrevBtn = document.querySelector('.dashboard-stock-sisa-nav-prev');
    var stockNextBtn = document.querySelector('.dashboard-stock-sisa-nav-next');
    if (stockScrollEl && stockPrevBtn && stockNextBtn) {
        var scrollStep = 220;
        stockPrevBtn.addEventListener('click', function() {
            stockScrollEl.scrollBy({ left: -scrollStep, behavior: 'smooth' });
        });
        stockNextBtn.addEventListener('click', function() {
            stockScrollEl.scrollBy({ left: scrollStep, behavior: 'smooth' });
        });
    }

})();
</script>
@endpush
@endsection
