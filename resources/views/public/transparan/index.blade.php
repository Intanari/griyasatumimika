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
                <div class="transparan-table-head">
                    <h3 class="transparan-table-title">Tabel Semua Donasi dari User</h3>
                    @if($status || $search)
                        <p class="transparan-filter-meta">
                            Menampilkan {{ number_format($donations->total(), 0, ',', '.') }} hasil
                            @if($search)
                                untuk pencarian &ldquo;{{ $search }}&rdquo;
                            @endif
                        </p>
                    @endif
                </div>
                <form method="GET" action="{{ route('transparansi.donasi') }}" class="transparan-filter-form">
                    <div class="transparan-filter-field">
                        <label for="donation-search" class="transparan-filter-label">Cari donatur</label>
                        <div class="transparan-filter-input-shell">
                            <input
                                type="search"
                                id="donation-search"
                                name="search"
                                value="{{ $search }}"
                                placeholder="Nama atau email donatur..."
                                class="transparan-filter-input"
                                autocomplete="off"
                            >
                        </div>
                    </div>
                    @php
                        $statusOptions = [
                            '' => 'Semua status',
                            'paid' => 'Berhasil',
                            'pending' => 'Pending',
                            'expired' => 'Kedaluwarsa',
                            'failed' => 'Gagal',
                        ];
                        $currentStatusLabel = $statusOptions[$status] ?? 'Semua status';
                    @endphp
                    <div class="transparan-filter-field">
                        <label id="donation-status-label" class="transparan-filter-label">Status</label>
                        <div class="transparan-custom-select" data-custom-select>
                            <input type="hidden" name="status" id="donation-status" value="{{ $status }}">
                            <button
                                type="button"
                                class="transparan-select-trigger"
                                aria-labelledby="donation-status-label"
                                aria-haspopup="listbox"
                                aria-expanded="false"
                            >
                                <span class="transparan-select-value">{{ $currentStatusLabel }}</span>
                                <span class="transparan-select-chevron" aria-hidden="true"></span>
                            </button>
                            <div class="transparan-select-menu" hidden>
                                <div class="transparan-select-menu-blur" aria-hidden="true"></div>
                                <ul class="transparan-select-menu-list" role="listbox">
                                    @foreach($statusOptions as $value => $label)
                                        <li
                                            role="option"
                                            data-value="{{ $value }}"
                                            class="transparan-select-option {{ ($status === $value || ($value === '' && ($status === '' || $status === 'all'))) ? 'is-selected' : '' }}"
                                            aria-selected="{{ ($status === $value || ($value === '' && ($status === '' || $status === 'all'))) ? 'true' : 'false' }}"
                                        >{{ $label }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="transparan-filter-actions">
                        <button type="submit" class="transparan-filter-btn transparan-filter-btn-primary">Terapkan</button>
                        @if($status || $search)
                            <a href="{{ route('transparansi.donasi') }}" class="transparan-filter-btn transparan-filter-btn-reset">Reset</a>
                        @endif
                    </div>
                </form>
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
                                    @elseif($d->status === 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($d->status === 'expired')
                                        <span class="badge badge-muted">Kedaluwarsa</span>
                                    @else
                                        <span class="badge badge-danger">Gagal</span>
                                    @endif
                                </td>
                                <td>{{ $d->created_at->translatedFormat('d M Y H:i') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    @if($status || $search)
                                        Tidak ada donasi yang cocok dengan filter.
                                    @else
                                        Belum ada data donasi.
                                    @endif
                                </td>
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
.transparan-table-head {
    margin-bottom: 1rem;
}
.transparan-table-title {
    font-size: 1.25rem;
    font-weight: 700;
    margin: 0 0 0.35rem;
    color: #ffffff !important;
}
.transparan-filter-meta {
    margin: 0;
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.85) !important;
}
.transparan-filter-form {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem 1rem;
    align-items: flex-end;
    margin-bottom: 1rem;
    padding: 1rem;
    border-radius: var(--radius-md);
    border: 1px solid rgba(255, 255, 255, 0.25);
    background: rgba(255, 255, 255, 0.06);
    position: relative;
    z-index: 5;
}
.transparan-filter-form:has(.transparan-custom-select.is-open) {
    z-index: 100;
}
.transparan-filter-field {
    display: flex;
    flex-direction: column;
    gap: 0.35rem;
    flex: 1 1 180px;
    min-width: 0;
}
.transparan-filter-label {
    font-size: 0.78rem;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.9);
}
.transparan-filter-input-shell {
    position: relative;
    width: 100%;
    border-radius: var(--radius-sm);
    border: 1px solid rgba(255, 255, 255, 0.4);
    background: transparent;
    backdrop-filter: blur(100px);
    -webkit-backdrop-filter: blur(100px);
    overflow: hidden;
    transition: border-color 0.2s;
}
.transparan-filter-input-shell::before {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: inherit;
    background: transparent;
    backdrop-filter: blur(100px);
    -webkit-backdrop-filter: blur(100px);
    z-index: 0;
    pointer-events: none;
}
.transparan-filter-input-shell:focus-within {
    border-color: rgba(255, 255, 255, 0.55);
    backdrop-filter: blur(100px);
    -webkit-backdrop-filter: blur(100px);
}
.transparan-filter-input {
    position: relative;
    z-index: 1;
    width: 100%;
    padding: 0.6rem 0.85rem;
    border: none;
    border-radius: var(--radius-sm);
    background: transparent;
    color: #ffffff;
    font-size: 0.9rem;
    box-shadow: none;
    font-family: inherit;
}
.transparan-filter-input:focus {
    outline: none;
    background: transparent;
}
.transparan-filter-input::placeholder {
    color: rgba(255, 255, 255, 0.55);
}
.transparan-filter-input:-webkit-autofill,
.transparan-filter-input:-webkit-autofill:hover,
.transparan-filter-input:-webkit-autofill:focus {
    -webkit-text-fill-color: #ffffff;
    -webkit-box-shadow: 0 0 0 1000px transparent inset;
    transition: background-color 9999s ease-out 0s;
}
.transparan-custom-select {
    position: relative;
    width: 100%;
    z-index: 1;
}
.transparan-custom-select.is-open {
    z-index: 110;
}
.transparan-select-trigger {
    position: relative;
    z-index: 2;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.5rem;
    padding: 0.6rem 0.85rem;
    border-radius: var(--radius-sm);
    border: 1px solid rgba(255, 255, 255, 0.4);
    background: transparent;
    backdrop-filter: blur(100px);
    -webkit-backdrop-filter: blur(100px);
    color: #ffffff;
    font-size: 0.9rem;
    font-family: inherit;
    cursor: pointer;
    text-align: left;
    transition: border-color 0.2s;
    overflow: hidden;
}
.transparan-select-trigger::before {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: inherit;
    background: transparent;
    backdrop-filter: blur(100px);
    -webkit-backdrop-filter: blur(100px);
    z-index: -1;
    pointer-events: none;
}
.transparan-select-trigger:hover,
.transparan-custom-select.is-open .transparan-select-trigger {
    border-color: rgba(255, 255, 255, 0.55);
    background: transparent;
    backdrop-filter: blur(100px);
    -webkit-backdrop-filter: blur(100px);
}
.transparan-select-trigger:focus {
    outline: none;
    border-color: rgba(255, 255, 255, 0.55);
}
.transparan-select-chevron {
    width: 0.45rem;
    height: 0.45rem;
    border-right: 2px solid rgba(255, 255, 255, 0.85);
    border-bottom: 2px solid rgba(255, 255, 255, 0.85);
    transform: rotate(45deg) translateY(-2px);
    transition: transform 0.2s;
    flex-shrink: 0;
}
.transparan-custom-select.is-open .transparan-select-chevron {
    transform: rotate(225deg) translateY(1px);
}
.transparan-select-menu {
    position: absolute;
    top: calc(100% + 2px);
    left: 0;
    right: 0;
    z-index: 120;
    margin: 0;
    padding: 0;
    border-radius: var(--radius-sm);
    border: 1px solid rgba(255, 255, 255, 0.4);
    background: transparent;
    box-shadow: 0 12px 32px rgba(15, 23, 42, 0.2);
    overflow: hidden;
    isolation: isolate;
}
.transparan-select-menu[hidden] {
    display: none;
}
.transparan-select-menu-blur {
    position: absolute;
    inset: -40px;
    background: transparent;
    backdrop-filter: blur(100px);
    -webkit-backdrop-filter: blur(100px);
    pointer-events: none;
    z-index: 0;
}
.transparan-select-menu-list {
    position: relative;
    z-index: 1;
    margin: 0;
    padding: 0.35rem;
    list-style: none;
    background: transparent;
    backdrop-filter: blur(100px);
    -webkit-backdrop-filter: blur(100px);
}
@supports not ((backdrop-filter: blur(1px)) or (-webkit-backdrop-filter: blur(1px))) {
    .transparan-filter-input-shell {
        background: rgba(37, 99, 235, 0.88);
    }
    .transparan-select-trigger {
        background: rgba(37, 99, 235, 0.88);
    }
    .transparan-select-menu-list {
        background: rgba(37, 99, 235, 0.88);
    }
}
.transparan-select-option {
    position: relative;
    z-index: 2;
    padding: 0.55rem 0.75rem;
    border-radius: calc(var(--radius-sm) - 2px);
    color: #ffffff;
    font-size: 0.88rem;
    cursor: pointer;
    transition: background 0.15s;
    background: transparent;
    backdrop-filter: blur(80px);
    -webkit-backdrop-filter: blur(80px);
}
.transparan-select-option:hover,
.transparan-select-option.is-selected {
    background: rgba(37, 99, 235, 0.45);
    backdrop-filter: blur(100px);
    -webkit-backdrop-filter: blur(100px);
}
.transparan-filter-actions {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}
.transparan-filter-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.6rem 1rem;
    border-radius: var(--radius-sm);
    font-size: 0.88rem;
    font-weight: 600;
    text-decoration: none;
    border: 1px solid rgba(255, 255, 255, 0.3);
    cursor: pointer;
    transition: background 0.2s, border-color 0.2s;
}
.transparan-filter-btn-primary {
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1.5px solid rgba(255,255,255,0.65);
    color: #ffffff;
}
.transparan-filter-btn-primary:hover {
    background: rgba(255,255,255,0.16);
    border-color: rgba(255,255,255,0.9);
}
.transparan-filter-btn-reset {
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1.5px solid rgba(255,255,255,0.65);
    color: #ffffff;
}
.transparan-filter-btn-reset:hover {
    background: rgba(255,255,255,0.16);
    border-color: rgba(255,255,255,0.9);
}
.transparan-table-scroll {
    position: relative;
    z-index: 1;
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
.badge-danger,
.badge-muted {
    background: rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.25);
    color: #ffffff;
}
</style>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('[data-custom-select]').forEach((root) => {
        const trigger = root.querySelector('.transparan-select-trigger');
        const menu = root.querySelector('.transparan-select-menu');
        const hiddenInput = root.querySelector('input[type="hidden"]');
        const valueEl = root.querySelector('.transparan-select-value');
        const options = root.querySelectorAll('.transparan-select-option');

        function closeMenu() {
            root.classList.remove('is-open');
            trigger.setAttribute('aria-expanded', 'false');
            menu.hidden = true;
        }

        function openMenu() {
            root.classList.add('is-open');
            trigger.setAttribute('aria-expanded', 'true');
            menu.hidden = false;
        }

        function selectOption(option) {
            const value = option.dataset.value ?? '';
            hiddenInput.value = value;
            valueEl.textContent = option.textContent.trim();

            options.forEach((item) => {
                const selected = item === option;
                item.classList.toggle('is-selected', selected);
                item.setAttribute('aria-selected', selected ? 'true' : 'false');
            });

            closeMenu();
        }

        trigger.addEventListener('click', () => {
            if (menu.hidden) {
                openMenu();
            } else {
                closeMenu();
            }
        });

        options.forEach((option) => {
            option.addEventListener('click', () => selectOption(option));
        });

        document.addEventListener('click', (event) => {
            if (!root.contains(event.target)) {
                closeMenu();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeMenu();
            }
        });

    });
</script>
@endpush
