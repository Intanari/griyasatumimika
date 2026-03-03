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
@endsection
