@extends('layouts.dashboard')
@section('title', 'Edit Persediaan Stok')
@section('topbar-title', 'Edit Persediaan Stok')
@section('content')
<a href="{{ route('dashboard.stock.index') }}" class="page-back-link">Back</a>
<div class="card">
<div class="card-title">Edit Persediaan Stok Barang</div>
<form action="{{ route('dashboard.stock.persediaan.update', $stock_supply) }}" method="POST" enctype="multipart/form-data" class="stock-form">
@csrf
@method('PUT')
<div class="form-group"><label for="nama">Nama stok barang *</label>
<input type="text" id="nama" name="nama" value="{{ old('nama', $stock_supply->nama) }}" required list="nama-list">
@if(isset($existingNames) && $existingNames->isNotEmpty())
<datalist id="nama-list">@foreach($existingNames as $n)<option value="{{ $n }}">@endforeach</datalist>
@endif
@error('nama')<span class="form-error">{{ $message }}</span>@enderror
</div>
<div class="form-group"><label for="jumlah">Jumlah *</label>
<input type="number" id="jumlah" name="jumlah" value="{{ old('jumlah', $stock_supply->jumlah) }}" required min="1">
@error('jumlah')<span class="form-error">{{ $message }}</span>@enderror
</div>
<div class="form-group"><label for="harga">Harga</label>
<input type="number" id="harga" name="harga" value="{{ old('harga', $stock_supply->harga) }}" min="0">
@error('harga')<span class="form-error">{{ $message }}</span>@enderror
</div>
<div class="form-group"><label for="gambar">Gambar stok barang</label>
@if($stock_supply->gambar)
<div class="stock-image-preview" style="margin-bottom:0.5rem;">
<img src="{{ $stock_supply->gambar_url }}" alt="Gambar" style="max-width:200px;max-height:150px;border-radius:8px;border:1px solid var(--border);">
<p style="font-size:0.8rem;color:var(--text-muted);margin-top:0.25rem;">Gambar saat ini. Upload baru untuk mengganti.</p>
</div>
@endif
<input type="file" id="gambar" name="gambar" accept="image/jpeg,image/jpg,image/png,image/webp">
<span class="form-hint">JPG, PNG atau WebP, maks. 2 MB</span>
@error('gambar')<span class="form-error">{{ $message }}</span>@enderror
</div>
<div class="form-actions"><button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route('dashboard.stock.index') }}" class="btn btn-outline">Batal</a></div>
</form></div>

@push('styles')
<style>
.stock-form { max-width: 480px; }
.stock-form .form-group { margin-bottom: 1.25rem; }
.stock-form .form-group label { display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.4rem; color: var(--text); }
.stock-form .form-group input { width: 100%; padding: 0.6rem 0.875rem; border: 1px solid var(--border); border-radius: 10px; font-size: 0.95rem; }
.stock-form .form-error { display: block; font-size: 0.8rem; color: #dc2626; margin-top: 0.25rem; }
.stock-form .form-hint { display: block; font-size: 0.8rem; color: var(--text-muted); margin-top: 0.25rem; }
.stock-form .form-actions { display: flex; gap: 0.75rem; margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid var(--border); }
</style>
@endpush
@endsection