@extends('layouts.dashboard')

@section('title', 'Data Donasi')
@section('topbar-title', 'Data Donasi')

@section('content')
<a href="{{ route('dashboard') }}" class="page-back-link">Back</a>
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
                <div class="stat-value" style="font-size:1.25rem;">Rp {{ number_format($stats['total_pengeluaran_donasi'] ?? 0, 0, ',', '.') }}</div>
                <div class="stat-label">Pengeluaran Donasi</div>
            </div>
            <div class="stat-icon blue">💸</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-title" style="display:flex;justify-content:space-between;align-items:center;">
        <span>📋 Semua Donasi dari User</span>
        <a href="{{ route('donation.form') }}" class="btn-link" target="_blank">+ Form Donasi Publik</a>
    </div>
    <p class="page-table-desc">Tabel berikut berisi donasi dari user melalui form publik. Menampilkan donatur, program, nominal, status, dan tanggal. Gunakan link di atas untuk membuka form donasi publik.</p>
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
                            <td>{{ $index + 1 }}</td>
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
        <p class="page-table-desc" style="margin-top:0.75rem;font-size:0.85rem;color:var(--text-muted);">Menampilkan 10 donasi terbaru. Data lain tidak ditampilkan di sini.</p>
    @endif
</div>

{{-- Tabel Pengelolaan Pengeluaran Donasi (di bawah tabel donasi dari user) ──────────── --}}
<div class="card" id="pengeluaran-donasi">
    <div class="card-title" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.75rem;">
        <span>💸 Pengeluaran Donasi</span>
        <a href="{{ route('dashboard.donasi.pengeluaran.create') }}" class="btn-donasi-pengeluaran">+ Pengelolaan Pengeluaran Donasi</a>
    </div>
    <p class="page-table-desc">Tabel berikut mencatat pengeluaran donasi (untuk apa, jumlah, bukti, tanggal). Klik Pengelolaan Pengeluaran Donasi untuk menambah atau mengelola data pengeluaran.</p>
    @if (session('success'))
        <div class="donasi-alert success">{{ session('success') }}</div>
    @endif
    @if ($pengeluaran->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">📋</div>
            <p>Belum ada data pengeluaran donasi.</p>
            <a href="{{ route('dashboard.donasi.pengeluaran.create') }}" class="btn btn-primary" style="margin-top:0.75rem;">Tambah Pengeluaran Pertama</a>
        </div>
    @else
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Digunakan untuk apa</th>
                        <th>Jumlah</th>
                        <th>Bukti</th>
                        <th>Tanggal & Waktu Pengeluaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengeluaran as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div style="font-weight:600;">{{ $p->keterangan }}</div>
                            </td>
                            <td style="font-weight:700;color:var(--primary);">{{ $p->formatted_jumlah }}</td>
                            <td>
                                @if($p->bukti_path)
                                    <a href="{{ $p->bukti_url }}" target="_blank" rel="noopener" class="pengeluaran-bukti-link" title="Lihat bukti">
                                        <img src="{{ $p->bukti_url }}" alt="Bukti" class="pengeluaran-bukti-thumb">
                                    </a>
                                @else
                                    <span style="color:var(--text-muted);font-size:0.85rem;">–</span>
                                @endif
                            </td>
                            <td style="color:var(--text-muted);font-size:0.9rem;">
                                {{ $p->tanggal_pengeluaran->locale('id')->translatedFormat('d F Y') }}
                                <span style="font-size:0.8rem;">{{ $p->created_at->locale('id')->translatedFormat('H:i') }}</span>
                            </td>
                            <td>
                                <a href="{{ route('dashboard.donasi.pengeluaran.edit', $p) }}" class="btn btn-sm btn-outline" title="Edit">Edit</a>
                                <form action="{{ route('dashboard.donasi.pengeluaran.destroy', $p) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus pengeluaran ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline" style="color:#dc2626;" title="Hapus">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <p class="page-table-desc" style="margin-top:0.75rem;font-size:0.85rem;color:var(--text-muted);">Menampilkan 10 pengeluaran donasi terbaru. Data lain tidak ditampilkan di sini.</p>
    @endif
</div>

@push('styles')
<style>
.btn-donasi-pengeluaran {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff !important;
    font-size: 0.9rem;
    font-weight: 600;
    border-radius: 10px;
    text-decoration: none;
}
.btn-donasi-pengeluaran:hover { filter: brightness(1.08); color: #fff !important; }
.pengeluaran-bukti-link { display: inline-block; }
.pengeluaran-bukti-thumb { max-width: 56px; max-height: 56px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border); vertical-align: middle; }
.pengeluaran-bukti-link:hover .pengeluaran-bukti-thumb { opacity: 0.9; }
.donasi-alert { padding: 0.75rem 1rem; border-radius: 10px; margin-bottom: 1rem; font-size: 0.9rem; }
.donasi-alert.success { background: #dcfce7; color: #166534; border: 1px solid #86efac; }
</style>
@endpush
@endsection
