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
})();
</script>
@endpush
@endsection
