@extends('layouts.app')

@section('title', 'Transparansi Donasi')

@section('content')
<div class="public-page">
    {{-- Hero judul --}}
    <section class="section" id="transparansi">
        <div class="section-inner">
            <div class="section-head section-head-center anim-fade-down">
                <span class="section-label">Transparansi</span>
                <h2>Transparansi Donasi</h2>
                <p class="section-lead">Ringkasan donasi dan pengeluaran dana donasi Yayasan Griya Satu Mimika. Data diperbarui secara berkala.</p>
            </div>

            {{-- Kartu statistik --}}
            <div class="transparan-cards">
                <div class="about-card anim-fade-up anim-delay-1">
                    <div class="about-card-icon">📊</div>
                    <h4>Total Donasi</h4>
                    <p class="transparan-value">{{ number_format($totalDonasi, 0, ',', '.') }}</p>
                    <p class="transparan-desc">Total transaksi donasi</p>
                </div>
                <div class="about-card anim-fade-up anim-delay-2">
                    <div class="about-card-icon">✅</div>
                    <h4>Berhasil Donasi</h4>
                    <p class="transparan-value">{{ number_format($berhasil, 0, ',', '.') }}</p>
                    <p class="transparan-desc">Transaksi berhasil (paid)</p>
                </div>
                <div class="about-card anim-fade-up anim-delay-3">
                    <div class="about-card-icon">⏳</div>
                    <h4>Pending</h4>
                    <p class="transparan-value">{{ number_format($pending, 0, ',', '.') }}</p>
                    <p class="transparan-desc">Menunggu pembayaran</p>
                </div>
                <div class="about-card anim-fade-up anim-delay-4">
                    <div class="about-card-icon">❌</div>
                    <h4>Gagal</h4>
                    <p class="transparan-value">{{ number_format($gagal, 0, ',', '.') }}</p>
                    <p class="transparan-desc">Transaksi gagal/expired</p>
                </div>
                <div class="about-card anim-fade-up anim-delay-5">
                    <div class="about-card-icon">💰</div>
                    <h4>Dana Terkumpul</h4>
                    <p class="transparan-value">Rp {{ number_format($danaTerkumpul, 0, ',', '.') }}</p>
                    <p class="transparan-desc">Total dana dari donasi berhasil</p>
                </div>
                <div class="about-card anim-fade-up anim-delay-6">
                    <div class="about-card-icon">📤</div>
                    <h4>Pengeluaran Donasi</h4>
                    <p class="transparan-value">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</p>
                    <p class="transparan-desc">Total pengeluaran dari dana donasi</p>
                </div>
                <div class="about-card anim-fade-up anim-delay-7 transparan-card-sisa">
                    <div class="about-card-icon">🏦</div>
                    <h4>Sisa Donasi</h4>
                    <p class="transparan-value">Rp {{ number_format($sisaDonasi, 0, ',', '.') }}</p>
                    <p class="transparan-desc">Dana terkumpul dikurangi pengeluaran</p>
                </div>
            </div>

            {{-- Tombol download PDF --}}
            <div class="transparan-pdf-btns anim-fade-up anim-delay-2">
                <a href="{{ route('transparansi.donasi.pdf.donations') }}" class="btn-cta-primary" download>Download PDF Data Donasi</a>
                <a href="{{ route('transparansi.donasi.pdf.expenses') }}" class="btn-cta-secondary transparan-pdf-btn-with-icon" download>
                    <span class="transparan-pdf-btn-icon">📄</span>
                    Download PDF Pengeluaran
                </a>
            </div>

            {{-- Tabel semua donasi --}}
            <div class="transparan-table-wrap anim-fade-up anim-delay-3">
                <h3 class="transparan-table-title">Tabel Semua Donasi dari User</h3>
                <div class="transparan-table-scroll">
                    <table class="transparan-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Donatur</th>
                                <th>Email</th>
                                <th>Nominal</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($donations as $idx => $d)
                            <tr>
                                <td>{{ $donations->firstItem() + $idx }}</td>
                                <td>{{ $d->donor_name }}</td>
                                <td>{{ $d->donor_email }}</td>
                                <td>{{ $d->formatted_amount }}</td>
                                <td>
                                    @if($d->status === 'paid')
                                        <span class="badge badge-success">Berhasil</span>
                                    @elseif(in_array($d->status, ['pending', 'expired']))
                                        <span class="badge badge-warning">Pending</span>
                                    @else
                                        <span class="badge badge-danger">Gagal</span>
                                    @endif
                                </td>
                                <td>{{ $d->created_at->translatedFormat('d M Y H:i') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data donasi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($donations->hasPages())
                <div class="transparan-pagination">
                    @if($donations->onFirstPage())
                    <span class="transparan-pagination-btn disabled">Sebelumnya</span>
                    @else
                    <a href="{{ $donations->previousPageUrl() }}" class="transparan-pagination-btn">Sebelumnya</a>
                    @endif
                    <span class="transparan-pagination-info">Halaman {{ $donations->currentPage() }} dari {{ $donations->lastPage() }}</span>
                    @if($donations->hasMorePages())
                    <a href="{{ $donations->nextPageUrl() }}" class="transparan-pagination-btn">Selanjutnya</a>
                    @else
                    <span class="transparan-pagination-btn disabled">Selanjutnya</span>
                    @endif
                </div>
                @endif
            </div>

            {{-- Tabel pengeluaran donasi --}}
            <div class="transparan-table-wrap anim-fade-up anim-delay-4">
                <h3 class="transparan-table-title">Tabel Pengeluaran Donasi</h3>
                <div class="transparan-table-scroll">
                    <table class="transparan-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Keterangan</th>
                                <th>Jumlah</th>
                                <th>Gambar</th>
                                <th>Tanggal Pengeluaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expenses as $idx => $e)
                            <tr>
                                <td>{{ $expenses->firstItem() + $idx }}</td>
                                <td>{{ $e->keterangan }}</td>
                                <td>{{ $e->formatted_jumlah }}</td>
                                <td>
                                    @if($e->bukti_url)
                                        <a href="{{ $e->bukti_url }}" target="_blank" rel="noopener" class="transparan-bukti-link" title="Lihat bukti">
                                            <img src="{{ $e->bukti_url }}" alt="Bukti" class="transparan-bukti-thumb">
                                        </a>
                                    @else
                                        <span class="transparan-no-bukti">—</span>
                                    @endif
                                </td>
                                <td>{{ $e->tanggal_pengeluaran?->translatedFormat('d M Y') ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data pengeluaran.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($expenses->hasPages())
                <div class="transparan-pagination">
                    @if($expenses->onFirstPage())
                    <span class="transparan-pagination-btn disabled">Sebelumnya</span>
                    @else
                    <a href="{{ $expenses->previousPageUrl() }}" class="transparan-pagination-btn">Sebelumnya</a>
                    @endif
                    <span class="transparan-pagination-info">Halaman {{ $expenses->currentPage() }} dari {{ $expenses->lastPage() }}</span>
                    @if($expenses->hasMorePages())
                    <a href="{{ $expenses->nextPageUrl() }}" class="transparan-pagination-btn">Selanjutnya</a>
                    @else
                    <span class="transparan-pagination-btn disabled">Selanjutnya</span>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </section>
</div>

<style>
#transparansi .section-label,
#transparansi .section-lead,
#transparansi h2,
#transparansi h3,
#transparansi h4,
#transparansi p {
    color: #ffffff !important;
}
#transparansi .about-card h4,
#transparansi .about-card p {
    color: #ffffff !important;
}
.transparan-cards {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1.25rem;
    margin-bottom: 2.5rem;
}
.transparan-value {
    font-size: 1.25rem;
    font-weight: 700;
    color: #ffffff !important;
    margin: 0.5rem 0 0.25rem;
}
.transparan-desc {
    font-size: 0.8rem;
    color: #ffffff !important;
    margin: 0;
}
.transparan-card-sisa .transparan-value { color: #ffffff !important; }
.transparan-pdf-btns {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    justify-content: center;
    margin-bottom: 2.5rem;
}
.transparan-table-wrap {
    margin-bottom: 2.5rem;
}
.transparan-pagination {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
    margin-top: 1rem;
}
.transparan-pagination-btn {
    padding: 0.5rem 1rem;
    border-radius: var(--radius-sm);
    border: 1px solid rgba(255, 255, 255, 0.4);
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    color: #ffffff;
    font-size: 0.9rem;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.2s, border-color 0.2s;
}
.transparan-pagination-btn:hover:not(.disabled) {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.5);
}
.transparan-pagination-btn.disabled {
    opacity: 0.5;
    cursor: default;
    pointer-events: none;
}
.transparan-pagination-info {
    font-size: 0.9rem;
    color: #ffffff;
}
.transparan-table-title {
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: #ffffff !important;
}
.transparan-table-scroll {
    overflow-x: auto;
    border-radius: var(--radius-md);
    border: 1px solid rgba(255, 255, 255, 0.25);
    background: transparent;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}
.transparan-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.9rem;
}
.transparan-table th,
.transparan-table td {
    padding: 0.75rem 1rem;
    text-align: left;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    color: #ffffff;
}
.transparan-table th {
    background: transparent;
    font-weight: 600;
    color: #ffffff;
}
.transparan-table tbody tr:hover {
    background: rgba(255, 255, 255, 0.08);
}
.transparan-table .text-center { text-align: center; color: #ffffff; }
.transparan-pdf-btn-with-icon { display: inline-flex; align-items: center; gap: 0.5rem; }
.transparan-pdf-btn-icon { font-size: 1.1rem; }
.transparan-bukti-link { display: inline-block; }
.transparan-bukti-thumb { max-width: 48px; max-height: 48px; object-fit: cover; border-radius: 6px; border: 1px solid rgba(255, 255, 255, 0.3); vertical-align: middle; }
.transparan-bukti-link:hover .transparan-bukti-thumb { opacity: 0.9; }
.transparan-no-bukti { color: rgba(255, 255, 255, 0.5); }
.badge {
    display: inline-block;
    padding: 0.25rem 0.6rem;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 600;
    color: #ffffff;
    background: rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.25);
}
.badge-success,
.badge-warning,
.badge-danger {
    background: rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.25);
    color: #ffffff;
}
</style>
@endsection
