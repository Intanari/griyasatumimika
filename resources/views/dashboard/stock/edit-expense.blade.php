@extends('layouts.dashboard')

@section('title', 'Edit Pengeluaran Stok')
@section('topbar-title', 'Edit Pengeluaran Stok')

@section('content')
<a href="{{ route('dashboard.stock.index') }}" class="page-back-link">Back</a>

<div class="card">
    <div class="card-title">Edit Pengeluaran Stok Barang</div>
    <form action="{{ route('dashboard.stock.pengeluaran.update', $stock_expense) }}" method="POST" enctype="multipart/form-data" class="stock-form">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nama">Nama stok barang <span class="required">*</span></label>
            <select id="nama" name="nama" class="stock-select" required>
                <option value="">— Pilih barang dari data tambah stok —</option>
                @foreach($supplyNames as $n)
                <option value="{{ $n }}" {{ old('nama', $stock_expense->nama) === $n ? 'selected' : '' }}>{{ $n }}</option>
                @endforeach
            </select>
            @if($supplyNames->isEmpty())
            <span class="form-hint">Belum ada data stok barang. Tambah stok barang dulu agar bisa memilih.</span>
            @endif
            @error('nama')<span class="form-error">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="jumlah">Jumlah <span class="required">*</span></label>
            <input type="number" id="jumlah" name="jumlah" value="{{ old('jumlah', $stock_expense->jumlah) }}" required min="1">
            @error('jumlah')<span class="form-error">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="gambar">Gambar stok barang</label>
            @if($stock_expense->gambar)
            <div class="stock-image-preview" style="margin-bottom:0.5rem;">
                <img src="{{ $stock_expense->gambar_url }}" alt="Gambar" style="max-width:200px;max-height:150px;border-radius:8px;border:1px solid var(--border);">
                <p style="font-size:0.8rem;color:var(--text-muted);margin-top:0.25rem;">Gambar saat ini. Upload baru untuk mengganti.</p>
            </div>
            @endif
            <input type="file" id="gambar" name="gambar" accept="image/jpeg,image/jpg,image/png,image/webp">
            <span class="form-hint">JPG, PNG atau WebP, maks. 2 MB</span>
            @error('gambar')<span class="form-error">{{ $message }}</span>@enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('dashboard.stock.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>

@push('styles')
<style>
.stock-form { max-width: 480px; }
.stock-form .form-group { margin-bottom: 1.25rem; }
.stock-form .form-group label { display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.4rem; color: var(--text); }
.stock-form .form-group input,
.stock-form .form-group .stock-select { width: 100%; padding: 0.6rem 0.875rem; border: 1px solid var(--border); border-radius: 10px; font-size: 0.95rem; }
.stock-form .form-group .stock-select { background: #fff; cursor: pointer; }
.stock-form .form-error { display: block; font-size: 0.8rem; color: #dc2626; margin-top: 0.25rem; }
.stock-form .form-hint { display: block; font-size: 0.8rem; color: var(--text-muted); margin-top: 0.25rem; }
.stock-form .form-actions { display: flex; gap: 0.75rem; margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid var(--border); }
.stock-form .required { color: #dc2626; }
</style>
@endpush
@endsection
