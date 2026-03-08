@extends('layouts.dashboard')

@section('title', 'Stok Barang')
@section('topbar-title', 'Stok Barang')

@php
    $user = auth()->user();
    $isAdmin = $user->isAdmin();
    $isManager = $user->isManager();
    $isStaff = $user->isPetugasRehabilitasi();
    $canEdit = $isAdmin || $isStaff;
    $canDelete = $isAdmin;
    $canRestock = $isAdmin || $isStaff;
    $canStockOut = $isAdmin || $isStaff;
    $canManager = $isManager;
    $canViewCharts = $isAdmin || $isManager;
@endphp

@section('content')
<div class="stock-dashboard">
    {{-- Card Aksi di Atas (Tambah, Edit, Restock, Export - seperti halaman Data Pasien) --}}
    <div class="card stock-toolbar-card" id="stockToolbarCard">
        <div class="card-title stock-toolbar-title">
            <span>📦 Stok Barang</span>
            <div class="stock-toolbar-buttons">
                <button type="button" class="btn btn-primary stock-toolbar-btn" id="btnAddItemHeader">+ Tambah Barang</button>
                <button type="button" class="btn btn-success stock-toolbar-btn" id="btnRestockHeader">📥 Restock</button>
                <a href="{{ route('dashboard.stock.export.csv') }}" class="btn btn-outline stock-toolbar-btn">Export CSV</a>
                <button type="button" class="btn btn-outline stock-toolbar-btn" onclick="window.print()">Cetak</button>
            </div>
        </div>
    </div>

    {{-- Ringkasan Stok (Summary Cards) --}}
    <div class="stats-grid stock-summary-cards">
        <div class="stat-card purple">
            <div class="stat-header">
                <div>
                    <div class="stat-value">{{ number_format($totalItems) }}</div>
                    <div class="stat-label">Total Jenis Barang</div>
                </div>
                <div class="stat-icon purple">📦</div>
            </div>
            <div class="stat-sub">Seluruh kategori</div>
        </div>
        <div class="stat-card green">
            <div class="stat-header">
                <div>
                    <div class="stat-value">{{ number_format($totalQuantity) }}</div>
                    <div class="stat-label">Total Barang Tersedia</div>
                </div>
                <div class="stat-icon green">✅</div>
            </div>
            <div class="stat-sub">Jumlah unit</div>
        </div>
        <div class="stat-card rose">
            <div class="stat-header">
                <div>
                    <div class="stat-value">{{ $outOfStock }}</div>
                    <div class="stat-label">Barang Habis</div>
                </div>
                <div class="stat-icon rose">⚠️</div>
            </div>
            <div class="stat-sub">Perlu restock</div>
        </div>
        <div class="stat-card orange">
            <div class="stat-header">
                <div>
                    <div class="stat-value">{{ $lowStock }}</div>
                    <div class="stat-label">Hampir Habis</div>
                </div>
                <div class="stat-icon orange">📉</div>
            </div>
            <div class="stat-sub">Di bawah stok minimum</div>
        </div>
        <div class="stat-card teal">
            <div class="stat-header">
                <div>
                    <div class="stat-value stock-value-text">Rp {{ number_format($totalValue, 0, ',', '.') }}</div>
                    <div class="stat-label">Total Nilai Stok</div>
                </div>
                <div class="stat-icon teal">💰</div>
            </div>
            <div class="stat-sub">Estimasi nilai</div>
        </div>
    </div>

    {{-- Notifikasi Stok (compact) --}}
    @if($lowStockItems->isNotEmpty() || $expiredItems->isNotEmpty() || $expiringSoon->isNotEmpty())
    <div class="card stock-alerts-card">
        <div class="card-title">
            <div class="stock-card-title-inner">
                <span class="stock-card-icon stock-card-icon-alert">🔔</span>
                <span>Notifikasi Stok</span>
            </div>
        </div>
        <div class="stock-alerts-list">
            @if($lowStockItems->isNotEmpty())
            <div class="stock-alert-item stock-alert-warning">
                <span class="stock-alert-label">Barang hampir habis ({{ $lowStockItems->count() }})</span>
                <span class="stock-alert-items">
                    @foreach($lowStockItems->take(5) as $it)
                        <span class="alert-badge">{{ $it->name }} ({{ $it->quantity }} {{ $it->unit }})</span>
                    @endforeach
                    @if($lowStockItems->count() > 5)<span class="alert-badge">+{{ $lowStockItems->count() - 5 }} lainnya</span>@endif
                </span>
            </div>
            @endif
            @if($expiredItems->isNotEmpty())
            <div class="stock-alert-item stock-alert-danger">
                <span class="stock-alert-label">Barang kadaluarsa ({{ $expiredItems->count() }})</span>
                <span class="stock-alert-items">
                    @foreach($expiredItems->take(5) as $it)
                        <span class="alert-badge">{{ $it->name }} – {{ $it->expiry_date?->format('d/m/Y') }}</span>
                    @endforeach
                </span>
            </div>
            @endif
            @if($expiringSoon->isNotEmpty())
            <div class="stock-alert-item stock-alert-info">
                <span class="stock-alert-label">Mendekati kadaluarsa (30 hari)</span>
                <span class="stock-alert-items">
                    @foreach($expiringSoon->take(5) as $it)
                        <span class="alert-badge">{{ $it->name }} – {{ $it->expiry_date?->format('d/m/Y') }}</span>
                    @endforeach
                </span>
            </div>
            @endif
        </div>
    </div>
    @endif

    {{-- Satu Card: Daftar Barang (filter + toolbar + tabel) --}}
    <div class="card stock-main-card">
        <div class="card-title">
            <div class="stock-card-title-inner">
                <span class="stock-card-icon stock-card-icon-list">📋</span>
                <span>Daftar Barang</span>
            </div>
        </div>

        <form method="get" action="{{ route('dashboard.stock.index') }}" class="stock-filter-form" id="stockFilterForm">
            <div class="stock-filter-row">
                <input type="text" name="search" class="filter-input" placeholder="Cari nama barang..." value="{{ request('search') }}">
                <select name="category" class="filter-select">
                    <option value="">Semua Kategori</option>
                    @foreach(\App\Models\InventoryItem::categories() as $key => $label)
                        <option value="{{ $key }}" {{ request('category') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <select name="status" class="filter-select">
                    <option value="">Semua Status</option>
                    <option value="aman" {{ request('status') === 'aman' ? 'selected' : '' }}>Aman</option>
                    <option value="low" {{ request('status') === 'low' ? 'selected' : '' }}>Hampir Habis</option>
                    <option value="habis" {{ request('status') === 'habis' ? 'selected' : '' }}>Habis</option>
                </select>
                <input type="text" name="supplier" class="filter-input" placeholder="Supplier" value="{{ request('supplier') }}">
                <button type="submit" class="btn btn-primary btn-sm">Terapkan</button>
                <a href="{{ route('dashboard.stock.index') }}" class="btn btn-outline btn-sm">Reset</a>
            </div>
        </form>

        <div class="table-wrapper stock-table-wrapper">
            <table class="stock-table" id="stockTable">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Stok Min</th>
                        <th>Tanggal Masuk</th>
                        <th>Kadaluarsa</th>
                        <th>Supplier</th>
                        <th>Status</th>
                        @if($canEdit || $canStockOut)
                        <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr class="stock-row {{ $item->expiry_date && $item->expiry_date->isPast() ? 'row-expired' : '' }} {{ $item->stock_status === 'low' ? 'row-low' : '' }} {{ $item->stock_status === 'habis' ? 'row-habis' : '' }}" data-id="{{ $item->id }}" data-item="{{ json_encode($item) }}">
                        <td>
                            <span class="stock-name">{{ $item->name }}</span>
                            @if($item->expiry_date && $item->expiry_date->isPast())
                                <span class="badge badge-expired">Kadaluarsa</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $catIcons = [
                                    'makanan' => '🍚',
                                    'obat' => '💊',
                                    'alat_kesehatan' => '🩺',
                                    'perlengkapan' => '📦',
                                    'kebersihan' => '🧹',
                                    'lainnya' => '📌',
                                ];
                                $icon = $catIcons[$item->category] ?? '📌';
                            @endphp
                            <span class="category-icon" title="{{ $item->category_label }}">{{ $icon }}</span>
                            <span class="category-label">{{ $item->category_label }}</span>
                        </td>
                        <td class="quantity-cell">{{ number_format($item->quantity) }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ $item->min_stock }}</td>
                        <td>{{ $item->date_in?->format('d/m/Y') ?? '–' }}</td>
                        <td class="{{ $item->expiry_date && $item->expiry_date->isPast() ? 'text-danger' : '' }}">{{ $item->expiry_date?->format('d/m/Y') ?? '–' }}</td>
                        <td>{{ $item->supplier ?? '–' }}</td>
                        <td>
                            @if($item->stock_status === 'aman')
                                <span class="badge badge-aman">Aman</span>
                            @elseif($item->stock_status === 'low')
                                <span class="badge badge-low">Hampir Habis</span>
                            @else
                                <span class="badge badge-habis">Habis</span>
                            @endif
                        </td>
                        @if($canEdit || $canStockOut)
                        <td class="action-cell">
                            <div class="stock-action-buttons">
                                <button type="button" class="btn btn-sm btn-outline btn-detail" data-id="{{ $item->id }}" title="Detail">Detail</button>
                                @if($canEdit)
                                <button type="button" class="btn btn-sm btn-outline btn-edit" data-id="{{ $item->id }}" data-item="{{ json_encode($item) }}" title="Edit">Edit</button>
                                @endif
                                @if($canStockOut && $item->quantity > 0)
                                <button type="button" class="btn btn-sm btn-outline btn-out" data-id="{{ $item->id }}" data-name="{{ $item->name }}" title="Barang Keluar">Keluar</button>
                                @endif
                                @if($canDelete)
                                <form action="{{ route('dashboard.stock.destroy', $item) }}" method="post" class="stock-action-form" onsubmit="return confirm('Yakin hapus barang ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">Hapus</button>
                                </form>
                                @endif
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ $canEdit || $canStockOut ? 10 : 9 }}" class="empty-state">Belum ada data barang. @if($canEdit)<button type="button" class="btn btn-primary btn-sm mt-2" id="btnAddItemEmpty">Tambah Barang Pertama</button>@endif</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Rekomendasi Pembelian --}}
    @if($recommendRestock->isNotEmpty() && ($canEdit || $canManager))
    <div class="card stock-recommend-card">
        <div class="card-title">
            <div class="stock-card-title-inner">
                <span class="stock-card-icon stock-card-icon-restock">📥</span>
                <span>Rekomendasi Pembelian / Restock</span>
            </div>
        </div>
        <p class="stock-section-desc">Barang di bawah stok minimum. Klik Restock untuk menambah stok.</p>
        <div class="table-wrapper">
            <table class="stock-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Stok Saat Ini</th>
                        <th>Stok Min</th>
                        <th>Kekurangan</th>
                        @if($canRestock)
                        <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($recommendRestock as $rec)
                    <tr>
                        <td>{{ $rec->name }}</td>
                        <td>{{ $rec->category_label }}</td>
                        <td>{{ $rec->quantity }} {{ $rec->unit }}</td>
                        <td>{{ $rec->min_stock }}</td>
                        <td>{{ max(0, $rec->min_stock - $rec->quantity) }} {{ $rec->unit }}</td>
                        @if($canRestock)
                        <td><button type="button" class="btn btn-success btn-sm btn-restock-item" data-id="{{ $rec->id }}" data-name="{{ $rec->name }}">Restock</button></td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Grafik & Analitik --}}
    @if($canViewCharts)
    <div class="card stock-charts-card">
        <div class="card-title">
            <div class="stock-card-title-inner">
                <span class="stock-card-icon stock-card-icon-chart">📊</span>
                <span>Grafik & Analitik</span>
            </div>
        </div>
        <div class="charts-row">
            <div class="chart-box">
                <p class="chart-title">Status Stok (Aman / Hampir Habis / Habis)</p>
                <canvas id="chartStockPie" height="220"></canvas>
            </div>
            <div class="chart-box">
                <p class="chart-title">Jumlah Barang per Kategori</p>
                <canvas id="chartCategoryBar" height="220"></canvas>
            </div>
        </div>
        <div class="charts-row">
            <div class="chart-box chart-box-wide">
                <p class="chart-title">Trend Pemakaian (Barang Keluar) per Minggu</p>
                <canvas id="chartUsageTrend" height="200"></canvas>
            </div>
        </div>
    </div>
    @endif

</div>

{{-- Modal: Tambah Barang --}}
<div class="modal-overlay" id="modalAddItem" aria-hidden="true">
    <div class="modal-box">
        <div class="modal-header">
            <h3>➕ Tambah Barang Baru</h3>
            <button type="button" class="modal-close" data-dismiss="modalAddItem" aria-label="Tutup">&times;</button>
        </div>
        <form action="{{ route('dashboard.stock.store') }}" method="post" class="modal-form">
            @csrf
            <input type="hidden" name="is_restock" value="0">
            <div class="form-grid">
                <div class="form-group full-width">
                    <label>Nama Barang *</label>
                    <input type="text" name="name" required class="form-control" placeholder="Contoh: Beras 5kg">
                </div>
                <div class="form-group">
                    <label>Kategori *</label>
                    <select name="category" required class="form-control">
                        @foreach(\App\Models\InventoryItem::categories() as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Jumlah *</label>
                    <input type="number" name="quantity" required min="0" class="form-control" value="0">
                </div>
                <div class="form-group">
                    <label>Satuan</label>
                    <input type="text" name="unit" class="form-control" value="pcs" placeholder="pcs, kg, dus">
                </div>
                <div class="form-group">
                    <label>Stok Minimum</label>
                    <input type="number" name="min_stock" class="form-control" value="5" min="0">
                </div>
                <div class="form-group">
                    <label>Tanggal Masuk</label>
                    <input type="date" name="date_in" class="form-control" value="{{ date('Y-m-d') }}">
                </div>
                <div class="form-group">
                    <label>Tanggal Kadaluarsa</label>
                    <input type="date" name="expiry_date" class="form-control">
                </div>
                <div class="form-group">
                    <label>Supplier</label>
                    <input type="text" name="supplier" class="form-control" placeholder="Nama supplier">
                </div>
                <div class="form-group">
                    <label>Harga per Unit (Rp)</label>
                    <input type="number" name="unit_price" class="form-control" min="0" step="0.01" placeholder="Opsional">
                </div>
                <div class="form-group full-width">
                    <label>Catatan</label>
                    <textarea name="notes" class="form-control" rows="2"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-dismiss="modalAddItem">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal: Restock --}}
<div class="modal-overlay" id="modalRestock" aria-hidden="true">
    <div class="modal-box">
        <div class="modal-header">
            <h3>📥 Restock Barang</h3>
            <button type="button" class="modal-close" data-dismiss="modalRestock" aria-label="Tutup">&times;</button>
        </div>
        <form action="{{ route('dashboard.stock.store') }}" method="post" class="modal-form">
            @csrf
            <input type="hidden" name="is_restock" value="1">
            <div class="form-grid">
                <div class="form-group full-width">
                    <label>Barang</label>
                    <select name="item_id" id="restockItemSelect" class="form-control" required>
                        <option value="">Pilih barang...</option>
                        @foreach($items as $it)
                            <option value="{{ $it->id }}">{{ $it->name }} ({{ $it->quantity }} {{ $it->unit }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Jumlah Tambah *</label>
                    <input type="number" name="quantity" required min="1" class="form-control" value="1">
                </div>
                <div class="form-group">
                    <label>Tanggal Masuk</label>
                    <input type="date" name="date_in" class="form-control" value="{{ date('Y-m-d') }}">
                </div>
                <div class="form-group full-width">
                    <label>Supplier</label>
                    <input type="text" name="supplier" class="form-control">
                </div>
                <div class="form-group full-width">
                    <label>Catatan</label>
                    <textarea name="notes" class="form-control" rows="2" placeholder="Restock">Restock</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-dismiss="modalRestock">Batal</button>
                <button type="submit" class="btn btn-success">Simpan Restock</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal: Barang Keluar --}}
<div class="modal-overlay" id="modalStockOut" aria-hidden="true">
    <div class="modal-box">
        <div class="modal-header">
            <h3>📤 Barang Keluar (Pemakaian)</h3>
            <button type="button" class="modal-close" data-dismiss="modalStockOut" aria-label="Tutup">&times;</button>
        </div>
        <form action="{{ route('dashboard.stock.out') }}" method="post" class="modal-form">
            @csrf
            <input type="hidden" name="item_id" id="outItemId" value="">
            <div class="form-group full-width">
                <label>Barang</label>
                <input type="text" id="outItemName" class="form-control" readonly>
            </div>
            <div class="form-group full-width">
                <label>Jumlah Keluar *</label>
                <input type="number" name="quantity" required min="1" class="form-control" id="outQuantity">
            </div>
            <div class="form-group full-width">
                <label>Catatan</label>
                <textarea name="notes" class="form-control" rows="2" placeholder="Pemakaian"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-dismiss="modalStockOut">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal: Edit Barang --}}
<div class="modal-overlay" id="modalEditItem" aria-hidden="true">
    <div class="modal-box">
        <div class="modal-header">
            <h3>✏️ Edit Barang</h3>
            <button type="button" class="modal-close" data-dismiss="modalEditItem" aria-label="Tutup">&times;</button>
        </div>
        <form method="post" action="" class="modal-form" id="formEditItem">
            @csrf
            @method('PUT')
            <div class="form-grid">
                <div class="form-group full-width">
                    <label>Nama Barang *</label>
                    <input type="text" name="name" required class="form-control" id="editName">
                </div>
                <div class="form-group">
                    <label>Kategori *</label>
                    <select name="category" required class="form-control" id="editCategory">
                        @foreach(\App\Models\InventoryItem::categories() as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Satuan</label>
                    <input type="text" name="unit" class="form-control" id="editUnit">
                </div>
                <div class="form-group">
                    <label>Stok Minimum</label>
                    <input type="number" name="min_stock" class="form-control" id="editMinStock" min="0">
                </div>
                <div class="form-group">
                    <label>Tanggal Masuk</label>
                    <input type="date" name="date_in" class="form-control" id="editDateIn">
                </div>
                <div class="form-group">
                    <label>Tanggal Kadaluarsa</label>
                    <input type="date" name="expiry_date" class="form-control" id="editExpiryDate">
                </div>
                <div class="form-group full-width">
                    <label>Supplier</label>
                    <input type="text" name="supplier" class="form-control" id="editSupplier">
                </div>
                <div class="form-group">
                    <label>Harga per Unit (Rp)</label>
                    <input type="number" name="unit_price" class="form-control" id="editUnitPrice" min="0" step="0.01">
                </div>
                <div class="form-group full-width">
                    <label>Catatan</label>
                    <textarea name="notes" class="form-control" id="editNotes" rows="2"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-dismiss="modalEditItem">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal: Detail Barang --}}
<div class="modal-overlay" id="modalDetailItem" aria-hidden="true">
    <div class="modal-box modal-box-wide">
        <div class="modal-header">
            <h3>📦 Detail Barang</h3>
            <button type="button" class="modal-close" data-dismiss="modalDetailItem" aria-label="Tutup">&times;</button>
        </div>
        <div id="detailContent" class="modal-body">
            <p class="text-muted">Memuat...</p>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* ── Card toolbar di atas (sama seperti Data Pasien / Data Petugas) ───── */
.stock-toolbar-card {
    margin-bottom: 1.5rem;
    border-left: 4px solid var(--primary);
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
}
.stock-toolbar-title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 0 !important;
    padding-bottom: 0 !important;
    border-bottom: none !important;
}
.stock-toolbar-title > span {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--text);
}
.stock-toolbar-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    align-items: center;
}
.stock-toolbar-btn {
    padding: 0.5rem 1rem !important;
    font-size: 0.875rem !important;
}

/* Tombol aksi per baris (Detail, Edit, Keluar, Hapus) */
.stock-action-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 0.35rem;
    align-items: center;
}
.stock-action-form { display: inline; }
.stock-action-form .btn { margin: 0; }
@media (max-width: 768px) {
    .stock-toolbar-title { flex-direction: column; align-items: stretch; }
    .stock-toolbar-buttons { justify-content: flex-start; }
}

/* ── Summary cards ──────────────────────────────────────────────────── */
.stock-summary-cards { margin-bottom: 1.75rem; }
.stock-value-text { font-size: 1.1rem !important; }

/* ── Card section titles (satu gaya untuk semua card) ────────────────── */
.stock-dashboard .card-title {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-bottom: 1.25rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border);
}
.stock-card-title-inner {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    font-size: 1rem;
    font-weight: 700;
    color: var(--text);
}
.stock-card-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}
.stock-card-icon-alert { background: #fef3c7; color: #b45309; }
.stock-card-icon-list { background: #dbeafe; color: #1d4ed8; }
.stock-card-icon-restock { background: #d1fae5; color: #047857; }
.stock-card-icon-chart { background: #e0e7ff; color: #4f46e5; }
.stock-card-icon-history { background: #fce7f3; color: #be185d; }

/* ── Alerts ─────────────────────────────────────────────────────────── */
.stock-alerts-card { margin-bottom: 1.75rem; }
.stock-alerts-list { display: flex; flex-direction: column; gap: 0.75rem; }
.stock-alert-item {
    padding: 0.875rem 1rem;
    border-radius: 12px;
    font-size: 0.875rem;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 0.5rem 0.75rem;
}
.stock-alert-warning { background: #fffbeb; border: 1px solid #fcd34d; color: #92400e; }
.stock-alert-danger { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }
.stock-alert-info { background: #eff6ff; border: 1px solid #93c5fd; color: #1d4ed8; }
.stock-alert-label { font-weight: 600; flex-shrink: 0; }
.stock-alert-items { display: flex; flex-wrap: wrap; gap: 0.35rem; }
.stock-dashboard .alert-badge {
    display: inline-block;
    padding: 4px 10px;
    background: rgba(0,0,0,0.08);
    border-radius: 8px;
    font-size: 0.8rem;
}

/* ── Main card: Daftar Barang (filter + tabel) ───────────────────────── */
.stock-main-card { margin-bottom: 1.75rem; }
.stock-main-card-title { margin-bottom: 1rem; }
.stock-filter-form { margin-bottom: 1.25rem; }
.stock-filter-row {
    display: flex;
    flex-wrap: wrap;
    gap: 0.6rem;
    align-items: center;
}
.stock-dashboard .filter-input,
.stock-dashboard .filter-select {
    padding: 0.5rem 0.75rem;
    border-radius: 10px;
    border: 1px solid var(--border);
    font-size: 0.875rem;
    min-width: 130px;
}
.stock-dashboard .action-buttons { display: flex; flex-wrap: wrap; gap: 0.5rem; }
.stock-table-wrapper { border-radius: 12px; overflow: hidden; border: 1px solid var(--border); }

/* ── Tabel ──────────────────────────────────────────────────────────── */
.stock-dashboard .stock-table { font-size: 0.85rem; }
.stock-dashboard .stock-table .stock-name { font-weight: 600; }
.stock-dashboard .stock-table .quantity-cell { font-weight: 700; color: var(--text); }
.stock-dashboard .badge-aman { background: #d1fae5; color: #047857; }
.stock-dashboard .badge-low { background: #fef3c7; color: #b45309; }
.stock-dashboard .badge-habis { background: #fee2e2; color: #dc2626; }
.stock-dashboard .badge-expired { background: #fecaca; color: #b91c1c; font-size: 0.7rem; }
.stock-dashboard .badge-in { background: #d1fae5; color: #047857; }
.stock-dashboard .badge-out { background: #dbeafe; color: #1d4ed8; }
.stock-dashboard .row-expired { background: #fef2f2 !important; }
.stock-dashboard .row-low td { background: #fffbeb !important; }
.stock-dashboard .row-habis td { background: #fef2f2 !important; }
.stock-dashboard .stock-table tbody tr:hover td { background: #fafbff !important; }
.stock-dashboard .row-expired:hover td,
.stock-dashboard .row-low:hover td,
.stock-dashboard .row-habis:hover td { filter: brightness(0.98); }
.stock-dashboard .category-icon { margin-right: 4px; }
.stock-dashboard .category-label { font-size: 0.82rem; }
.stock-dashboard .action-cell { white-space: nowrap; }
.stock-dashboard .action-cell .btn { margin: 0; }

/* ── Rekomendasi & Riwayat ──────────────────────────────────────────── */
.stock-section-desc { font-size: 0.875rem; color: var(--text-muted); margin: -0.5rem 0 1rem 0; }
.stock-recommend-card { margin-bottom: 1.75rem; }
.stock-history-card { margin-bottom: 1.75rem; }

/* ── Grafik ─────────────────────────────────────────────────────────── */
.stock-charts-card { margin-bottom: 1.75rem; }
.stock-dashboard .charts-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
    margin-bottom: 1.25rem;
}
.stock-dashboard .charts-row:last-of-type { margin-bottom: 0; }
.stock-dashboard .chart-box {
    background: #f8fafc;
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 1rem 1.25rem;
}
.stock-dashboard .chart-box-wide { grid-column: 1 / -1; }
.stock-dashboard .chart-title {
    font-size: 0.8rem;
    font-weight: 700;
    color: #475569;
    margin-bottom: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

/* ── Modal ──────────────────────────────────────────────────────────── */
.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.4);
    z-index: 1000;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    overflow-y: auto;
}
.modal-overlay.open { display: flex; }
.modal-box {
    background: var(--card);
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    max-width: 560px;
    width: 100%;
    max-height: 90vh;
    overflow-y: auto;
}
.modal-box-wide { max-width: 640px; }
.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--border);
}
.modal-header h3 { font-size: 1.1rem; font-weight: 700; margin: 0; }
.modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    line-height: 1;
    cursor: pointer;
    color: var(--text-muted);
    padding: 0 4px;
}
.modal-close:hover { color: var(--text); }
.modal-form, .modal-body { padding: 1.25rem 1.5rem; }
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.form-group { display: flex; flex-direction: column; gap: 4px; }
.form-group label { font-size: 0.8rem; font-weight: 600; color: var(--text-muted); }
.form-group .form-control {
    padding: 0.5rem 0.75rem;
    border: 1px solid var(--border);
    border-radius: 10px;
    font-size: 0.9rem;
}
.form-group.full-width { grid-column: 1 / -1; }
.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
    padding-top: 1rem;
    margin-top: 1rem;
    border-top: 1px solid var(--border);
}

/* ── Responsive ─────────────────────────────────────────────────────── */
@media (max-width: 768px) {
    .stock-page-header { flex-direction: column; text-align: center; padding: 1.25rem; }
    .stock-header-title { font-size: 1.15rem; }
    .stock-summary-cards { grid-template-columns: repeat(2, 1fr); gap: 0.75rem; }
    .stock-value-text { font-size: 0.95rem !important; }
    .stock-filter-row { flex-direction: column; align-items: stretch; }
    .stock-dashboard .filter-input,
    .stock-dashboard .filter-select { min-width: 100%; }
    .stock-main-card-title { flex-direction: column; align-items: stretch; }
    .stock-dashboard .action-buttons { width: 100%; justify-content: flex-start; }
    .stock-dashboard .charts-row { grid-template-columns: 1fr; }
    .form-grid { grid-template-columns: 1fr; }
}
@media (max-width: 480px) {
    .stock-summary-cards { grid-template-columns: 1fr; }
}
@media print {
    .sidebar, .topbar, .stock-toolbar-card, .stock-filter-form,
    .stock-main-card .action-buttons, .btn, .modal-overlay,
    .stock-alerts-card, nav { display: none !important; }
    .main-content { margin-left: 0 !important; }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
(function() {
    var showStockUrl = '{{ route("dashboard.stock.show", ["stock" => 0]) }}'.replace(/\/0$/, '/');

    function openModal(id) {
        document.getElementById(id).classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function closeModal(id) {
        document.getElementById(id).classList.remove('open');
        document.body.style.overflow = '';
    }
    document.querySelectorAll('[data-dismiss]').forEach(function(btn) {
        btn.addEventListener('click', function() { closeModal(this.getAttribute('data-dismiss')); });
    });
    document.querySelectorAll('.modal-overlay').forEach(function(overlay) {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) closeModal(this.id);
        });
    });

    function openAddModal() { openModal('modalAddItem'); }
    function openRestockModal() { openModal('modalRestock'); }
    document.getElementById('btnAddItem') && document.getElementById('btnAddItem').addEventListener('click', openAddModal);
    document.getElementById('btnAddItemHeader') && document.getElementById('btnAddItemHeader').addEventListener('click', openAddModal);
    document.getElementById('btnAddItemEmpty') && document.getElementById('btnAddItemEmpty').addEventListener('click', openAddModal);
    document.getElementById('btnRestock') && document.getElementById('btnRestock').addEventListener('click', openRestockModal);
    document.getElementById('btnRestockHeader') && document.getElementById('btnRestockHeader').addEventListener('click', openRestockModal);

    document.querySelectorAll('.btn-restock-item').forEach(function(btn) {
        btn.addEventListener('click', function() {
            openModal('modalRestock');
            var id = this.getAttribute('data-id');
            var select = document.getElementById('restockItemSelect');
            if (select) { select.value = id; }
        });
    });

    document.querySelectorAll('.btn-out').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('outItemId').value = this.getAttribute('data-id');
            document.getElementById('outItemName').value = this.getAttribute('data-name');
            document.getElementById('outQuantity').value = '1';
            openModal('modalStockOut');
        });
    });

    document.querySelectorAll('.btn-edit').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var item = JSON.parse(this.getAttribute('data-item'));
            document.getElementById('formEditItem').action = baseUrl + '/dashboard/stock/' + item.id;
            document.getElementById('editName').value = item.name;
            document.getElementById('editCategory').value = item.category;
            document.getElementById('editUnit').value = item.unit || 'pcs';
            document.getElementById('editMinStock').value = item.min_stock ?? 5;
            document.getElementById('editDateIn').value = item.date_in || '';
            document.getElementById('editExpiryDate').value = item.expiry_date || '';
            document.getElementById('editSupplier').value = item.supplier || '';
            document.getElementById('editUnitPrice').value = item.unit_price || '';
            document.getElementById('editNotes').value = item.notes || '';
            openModal('modalEditItem');
        });
    });

    document.querySelectorAll('.btn-detail').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            var content = document.getElementById('detailContent');
            content.innerHTML = '<p class="text-muted">Memuat...</p>';
            openModal('modalDetailItem');
            var url = showStockUrl + id;
            fetch(url, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            }).then(function(r) { return r.json(); }).then(function(data) {
                var item = data.item;
                var tx = data.transactions || [];
                var rows = tx.map(function(t) {
                    return '<tr><td>' + (t.created_at || '') + '</td><td>' + (t.type === 'in' ? 'Masuk' : 'Keluar') + '</td><td>' + t.quantity + '</td><td>' + (t.staff_name || '-') + '</td><td>' + (t.notes || '-') + '</td></tr>';
                }).join('');
                content.innerHTML =
                    '<div class="info-item"><span class="info-key">Nama</span><span class="info-val">' + (item.name || '-') + '</span></div>' +
                    '<div class="info-item"><span class="info-key">Kategori</span><span class="info-val">' + (item.category_label || item.category || '-') + '</span></div>' +
                    '<div class="info-item"><span class="info-key">Jumlah</span><span class="info-val">' + (item.quantity ?? '-') + ' ' + (item.unit || '') + '</span></div>' +
                    '<div class="info-item"><span class="info-key">Stok Min</span><span class="info-val">' + (item.min_stock ?? '-') + '</span></div>' +
                    '<div class="info-item"><span class="info-key">Tanggal Masuk</span><span class="info-val">' + (item.date_in || '-') + '</span></div>' +
                    '<div class="info-item"><span class="info-key">Kadaluarsa</span><span class="info-val">' + (item.expiry_date || '-') + '</span></div>' +
                    '<div class="info-item"><span class="info-key">Supplier</span><span class="info-val">' + (item.supplier || '-') + '</span></div>' +
                    '<p class="chart-title" style="margin-top:1rem;">Riwayat Transaksi</p>' +
                    '<div class="table-wrapper"><table class="stock-table"><thead><tr><th>Tanggal</th><th>Jenis</th><th>Jumlah</th><th>Staff</th><th>Catatan</th></tr></thead><tbody>' + (rows || '<tr><td colspan="5">Tidak ada riwayat</td></tr>') + '</tbody></table></div>';
            }).catch(function() {
                content.innerHTML = '<p class="alert-error">Gagal memuat data.</p>';
            });
        });
    });


    @if($canViewCharts && count($chartStockPie['data']) > 0)
    if (typeof Chart !== 'undefined') {
        new Chart(document.getElementById('chartStockPie'), {
            type: 'doughnut',
            data: {
                labels: @json($chartStockPie['labels']),
                datasets: [{
                    data: @json($chartStockPie['data']),
                    backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
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

        new Chart(document.getElementById('chartCategoryBar'), {
            type: 'bar',
            data: {
                labels: @json($chartCategoryLabels),
                datasets: [{
                    label: 'Jumlah Jenis Barang',
                    data: @json($chartCategoryData),
                    backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ec4899', '#06b6d4'],
                    borderRadius: 8,
                    borderSkipped: false,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 11 } } },
                    y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 } },
                },
            },
        });

        new Chart(document.getElementById('chartUsageTrend'), {
            type: 'line',
            data: {
                labels: @json($chartUsageLabels),
                datasets: [{
                    label: 'Barang Keluar',
                    data: @json($usageOut),
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59,130,246,0.1)',
                    fill: true,
                    tension: 0.3,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false } },
                    y: { beginAtZero: true },
                },
            },
        });
    }
    @endif

    // Pop-up notifikasi barang hampir habis (sekali saat load)
    @if($lowStockItems->isNotEmpty())
    if (sessionStorage.getItem('stockAlertShown') !== '1') {
        setTimeout(function() {
            var toast = document.getElementById('toast-inbox');
            if (toast) {
                var el = document.createElement('div');
                el.className = 'toast-email toast-email-info';
                el.innerHTML = '<div class="toast-email-header"><span class="toast-email-icon">⚠</span><strong>Stok Hampir Habis</strong><button type="button" class="toast-email-close" aria-label="Tutup">×</button></div><div class="toast-email-body">Ada {{ $lowStockItems->count() }} barang di bawah stok minimum. Cek notifikasi di dashboard.</div>';
                el.querySelector('.toast-email-close').onclick = function() { el.remove(); };
                toast.appendChild(el);
                sessionStorage.setItem('stockAlertShown', '1');
            }
        }, 800);
    }
    @endif
})();
</script>
@endpush
