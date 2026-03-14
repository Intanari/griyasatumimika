@extends('layouts.dashboard')

@section('title', 'Data Laporan ODGJ')
@section('topbar-title', 'Data Laporan ODGJ')

@section('content')
<a href="{{ route('dashboard') }}" class="page-back-link">Back</a>
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
    <div class="stat-card green">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ number_format($stats['laporan_diterima'] ?? 0) }}</div>
                <div class="stat-label">Diterima</div>
            </div>
            <div class="stat-icon green">✅</div>
        </div>
    </div>
    <div class="stat-card red">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ number_format($stats['laporan_ditolak'] ?? 0) }}</div>
                <div class="stat-label">Ditolak</div>
            </div>
            <div class="stat-icon red">❌</div>
        </div>
    </div>
    <div class="stat-card orange">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ number_format($stats['laporan_pending'] ?? $stats['laporan_odgj_baru']) }}</div>
                <div class="stat-label">Pending</div>
            </div>
            <div class="stat-icon orange">⏳</div>
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
    <p class="page-table-desc">Tabel berikut menampilkan semua laporan ODGJ dari masyarakat (penjemputan/pengantaran). Klik Detail untuk melihat lengkap dan kirim respons ke pelapor. Gunakan tombol di atas untuk membuat laporan baru dari form publik.</p>
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
                        <th>Email</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($laporan_odgj as $index => $laporan)
                        <tr>
                            <td data-label="#">{{ $laporan_odgj->firstItem() + $index }}</td>
                            <td data-label="Email">
                                @if($laporan->email)
                                    <a href="mailto:{{ $laporan->email }}" style="font-size:0.82rem;">{{ Str::limit($laporan->email, 25) }}</a>
                                @else
                                    <span style="color:var(--text-muted);">-</span>
                                @endif
                            </td>
                            <td data-label="Deskripsi">
                                @if($laporan->deskripsi)
                                    <div style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $laporan->deskripsi }}">{{ Str::limit($laporan->deskripsi, 40) }}</div>
                                @else
                                    <span style="color:var(--text-muted);">-</span>
                                @endif
                            </td>
                            <td data-label="Status">
                                @if ($laporan->status === 'baru')
                                    <span class="badge badge-pending">🆕 Baru</span>
                                @elseif ($laporan->status === 'diproses')
                                    <span class="badge badge-paid">✅ Diterima</span>
                                @elseif ($laporan->status === 'ditolak')
                                    <span class="badge badge-cancel">❌ Ditolak</span>
                                @else
                                    <span class="badge badge-cancel">✅ Selesai</span>
                                @endif
                            </td>
                            <td data-label="Tanggal" style="color:var(--text-muted);font-size:0.8rem;">{{ $laporan->created_at->locale('id')->translatedFormat('d M Y, H:i') }}</td>
                            <td data-label="Aksi">
                                <div style="display:flex;gap:6px;flex-wrap:wrap;align-items:center;">
                                    <a href="{{ route('dashboard.laporan.show', $laporan) }}" class="btn btn-sm btn-outline" title="Lihat detail laporan">Detail</a>
                                    @if ($laporan->status === 'baru')
                                        <form action="{{ route('dashboard.laporan.terima', $laporan) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Terima laporan dan kirim email ke pelapor">✓ Terima</button>
                                        </form>
                                        <form action="{{ route('dashboard.laporan.tolak', $laporan) }}" method="POST" style="display:inline;" data-confirm="Yakin ingin menolak laporan ini? Email konfirmasi akan dikirim ke pelapor.">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" title="Tolak laporan dan kirim email ke pelapor">✗ Tolak</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
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
