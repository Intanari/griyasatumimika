@extends('layouts.dashboard')

@section('title', 'Data Laporan ODGJ')
@section('topbar-title', 'Data Laporan ODGJ')

@section('content')
<div class="stats-grid">
    <div class="stat-card purple">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ number_format($stats['total_laporan_odgj']) }}</div>
                <div class="stat-label">Total Laporan</div>
            </div>
            <div class="stat-icon purple">🚨</div>
        </div>
    </div>
    <div class="stat-card orange">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ number_format($stats['laporan_odgj_baru']) }}</div>
                <div class="stat-label">Baru</div>
            </div>
            <div class="stat-icon orange">🆕</div>
        </div>
    </div>
    <div class="stat-card blue">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ number_format($stats['laporan_penjemputan'] ?? 0) }}</div>
                <div class="stat-label">Penjemputan</div>
            </div>
            <div class="stat-icon blue">🚑</div>
        </div>
    </div>
    <div class="stat-card teal">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ number_format($stats['laporan_pengantaran'] ?? 0) }}</div>
                <div class="stat-label">Pengantaran</div>
            </div>
            <div class="stat-icon teal">🚗</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-title" style="display:flex;justify-content:space-between;align-items:center;">
        <span>📋 Semua Laporan ODGJ</span>
        <a href="{{ route('odgj-report.form') }}" class="btn-link" target="_blank">+ Buat Laporan Baru</a>
    </div>
    @if ($laporan_odgj->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">📭</div>
            <p>Belum ada laporan ODGJ.</p>
            <a href="{{ route('odgj-report.form') }}" style="margin-top:0.75rem;display:inline-block;font-size:0.9rem;color:var(--primary);font-weight:600;">Buat laporan pertama →</a>
        </div>
    @else
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No. Laporan</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Deskripsi</th>
                        <th>Kontak</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($laporan_odgj as $index => $laporan)
                        <tr>
                            <td>{{ $laporan_odgj->firstItem() + $index }}</td>
                            <td style="font-weight:600;font-family:monospace;font-size:0.82rem;">{{ $laporan->nomor_laporan }}</td>
                            <td>{{ $laporan->kategori_label }}</td>
                            <td>
                                @if($laporan->lokasi)
                                    <div style="font-size:0.85rem;max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $laporan->lokasi }}">{{ $laporan->lokasi }}</div>
                                    @if($laporan->lokasi_lat && $laporan->lokasi_lng)
                                        <a href="https://www.google.com/maps?q={{ $laporan->lokasi_lat }},{{ $laporan->lokasi_lng }}" target="_blank" style="font-size:0.72rem;color:var(--primary);">📍 Maps</a>
                                    @endif
                                @else
                                    <span style="color:var(--text-muted);">-</span>
                                @endif
                            </td>
                            <td>
                                @if($laporan->deskripsi)
                                    <div style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $laporan->deskripsi }}">{{ Str::limit($laporan->deskripsi, 40) }}</div>
                                @else
                                    <span style="color:var(--text-muted);">-</span>
                                @endif
                            </td>
                            <td>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $laporan->kontak) }}" target="_blank" style="color:var(--accent-green);font-weight:600;">{{ $laporan->kontak }}</a>
                            </td>
                            <td>
                                @if ($laporan->status === 'baru')
                                    <span class="badge badge-pending">🆕 Baru</span>
                                @elseif ($laporan->status === 'diproses')
                                    <span class="badge badge-paid">⏳ Diproses</span>
                                @else
                                    <span class="badge badge-cancel">✅ Selesai</span>
                                @endif
                            </td>
                            <td style="color:var(--text-muted);font-size:0.8rem;">{{ $laporan->created_at->locale('id')->translatedFormat('d M Y, H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($laporan_odgj->hasPages())
            <div style="margin-top:1.5rem;display:flex;justify-content:center;">{{ $laporan_odgj->links('pagination::default') }}</div>
        @endif
    @endif
</div>
@endsection
