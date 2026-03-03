@extends('layouts.dashboard')

@section('title', 'Data Donasi')
@section('topbar-title', 'Data Donasi')

@section('content')
<div class="stats-grid">
    <div class="stat-card purple">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ number_format($stats['total_donasi']) }}</div>
                <div class="stat-label">Total Donasi</div>
            </div>
            <div class="stat-icon purple">📋</div>
        </div>
    </div>
    <div class="stat-card green">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ number_format($stats['donasi_sukses']) }}</div>
                <div class="stat-label">Berhasil</div>
            </div>
            <div class="stat-icon green">✅</div>
        </div>
    </div>
    <div class="stat-card orange">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ number_format($stats['donasi_pending']) }}</div>
                <div class="stat-label">Pending</div>
            </div>
            <div class="stat-icon orange">⏳</div>
        </div>
    </div>
    <div class="stat-card teal">
        <div class="stat-header">
            <div>
                <div class="stat-value" style="font-size:1.25rem;">Rp {{ number_format($stats['total_terkumpul'], 0, ',', '.') }}</div>
                <div class="stat-label">Dana Terkumpul</div>
            </div>
            <div class="stat-icon teal">💰</div>
        </div>
    </div>
    <div class="stat-card blue">
        <div class="stat-header">
            <div>
                <div class="stat-value" style="font-size:1.25rem;">Rp {{ number_format($stats['donasi_bulan_ini'], 0, ',', '.') }}</div>
                <div class="stat-label">Bulan Ini</div>
            </div>
            <div class="stat-icon blue">📅</div>
        </div>
    </div>
</div>

<div class="grid-2">
    <div class="card">
        <div class="card-title">📊 Rekap Per Program</div>
        @if ($donasi_per_program->isEmpty())
            <div class="empty-state"><div class="empty-icon">📭</div><p>Belum ada data.</p></div>
        @else
            @php $progLabels = ['rawat-inap' => 'Rawat Inap & Obat', 'pelatihan-vokasi' => 'Pelatihan Vokasi', 'rumah-singgah' => 'Rumah Singgah', 'umum' => 'Donasi Umum']; @endphp
            @foreach ($donasi_per_program as $item)
                <div class="program-item">
                    <div>
                        <div class="program-name">{{ $progLabels[$item->program] ?? $item->program }}</div>
                        <div class="program-count">{{ $item->total }} donatur</div>
                    </div>
                    <div class="program-amount">Rp {{ number_format($item->total_amount, 0, ',', '.') }}</div>
                </div>
            @endforeach
        @endif
    </div>
</div>

<div class="card">
    <div class="card-title" style="display:flex;justify-content:space-between;align-items:center;">
        <span>📋 Semua Donasi dari User</span>
        <a href="{{ route('donation.form') }}" class="btn-link" target="_blank">+ Form Donasi Publik</a>
    </div>
    @if ($donasi->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">📭</div>
            <p>Belum ada data donasi dari user.</p>
        </div>
    @else
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Donatur</th>
                        <th>Program</th>
                        <th>Nominal</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $programLabels = ['rawat-inap' => 'Rawat Inap & Obat', 'pelatihan-vokasi' => 'Pelatihan Vokasi', 'rumah-singgah' => 'Rumah Singgah', 'umum' => 'Donasi Umum']; @endphp
                    @foreach ($donasi as $index => $d)
                        <tr>
                            <td>{{ $donasi->firstItem() + $index }}</td>
                            <td>
                                <div style="font-weight:600;">{{ $d->donor_name }}</div>
                                <div style="font-size:0.78rem;color:var(--text-muted);">{{ $d->donor_email }}</div>
                            </td>
                            <td>{{ $programLabels[$d->program] ?? $d->program }}</td>
                            <td style="font-weight:700;color:var(--primary);">{{ $d->formatted_amount }}</td>
                            <td>
                                @if ($d->status === 'paid')<span class="badge badge-paid">✅ Berhasil</span>
                                @elseif ($d->status === 'pending')<span class="badge badge-pending">⏳ Pending</span>
                                @elseif ($d->status === 'failed')<span class="badge badge-failed">❌ Gagal</span>
                                @else<span class="badge badge-cancel">🚫 {{ ucfirst($d->status) }}</span>
                                @endif
                            </td>
                            <td style="color:var(--text-muted);font-size:0.8rem;">{{ $d->created_at->locale('id')->translatedFormat('d M Y, H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($donasi->hasPages())
            <div style="margin-top:1.5rem;display:flex;justify-content:center;">{{ $donasi->links('pagination::default') }}</div>
        @endif
    @endif
</div>
@endsection
