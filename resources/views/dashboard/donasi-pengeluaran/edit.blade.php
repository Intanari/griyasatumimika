@extends('layouts.dashboard')

@section('title', 'Edit Pengeluaran Donasi')
@section('topbar-title', 'Edit Pengeluaran Donasi')

@section('content')
<nav class="donasi-pengeluaran-breadcrumb" aria-label="Breadcrumb">
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <span class="donasi-pengeluaran-sep">/</span>
    <a href="{{ route('dashboard.donasi') }}">Data Donasi</a>
    <span class="donasi-pengeluaran-sep">/</span>
    <span class="donasi-pengeluaran-current">Edit Pengeluaran</span>
</nav>

<div class="card">
    <div class="card-title">Edit Pengeluaran Donasi</div>
    <form action="{{ route('dashboard.donasi.pengeluaran.update', $pengeluaran) }}" method="POST" enctype="multipart/form-data" class="donasi-pengeluaran-form">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="keterangan">Digunakan untuk apa <span class="required">*</span></label>
            <input type="text" id="keterangan" name="keterangan" value="{{ old('keterangan', $pengeluaran->keterangan) }}" required maxlength="500" placeholder="Contoh: Pembelian obat rawat inap">
            @error('keterangan')<span class="form-error">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="jumlah">Jumlah (Rp) <span class="required">*</span></label>
            <input type="number" id="jumlah" name="jumlah" value="{{ old('jumlah', $pengeluaran->jumlah) }}" required min="1" placeholder="Nominal pengeluaran">
            @error('jumlah')<span class="form-error">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="tanggal_pengeluaran">Tanggal pengeluaran <span class="required">*</span></label>
            <input type="date" id="tanggal_pengeluaran" name="tanggal_pengeluaran" value="{{ old('tanggal_pengeluaran', $pengeluaran->tanggal_pengeluaran?->format('Y-m-d')) }}" required>
            @error('tanggal_pengeluaran')<span class="form-error">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="bukti">Bukti gambar (foto/kwitansi)</label>
            @if($pengeluaran->bukti_path)
                <div class="donasi-pengeluaran-preview" style="margin-bottom:0.5rem;">
                    <img src="{{ $pengeluaran->bukti_url }}" alt="Bukti" style="max-width:200px;max-height:150px;border-radius:8px;border:1px solid var(--border);">
                    <p style="font-size:0.8rem;color:var(--text-muted);margin-top:0.25rem;">Bukti saat ini. Kosongkan untuk tidak mengubah.</p>
                </div>
            @endif
            <input type="file" id="bukti" name="bukti" accept="image/jpeg,image/jpg,image/png,image/webp">
            <span class="form-hint">JPG, PNG atau WebP, maks. 2 MB. Kosongkan untuk tetap pakai bukti lama.</span>
            @error('bukti')<span class="form-error">{{ $message }}</span>@enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('dashboard.donasi') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>

@push('styles')
<style>
.donasi-pengeluaran-breadcrumb { font-size: 0.875rem; color: var(--text-muted); margin-bottom: 1rem; }
.donasi-pengeluaran-breadcrumb a { color: var(--primary); text-decoration: none; font-weight: 500; }
.donasi-pengeluaran-breadcrumb a:hover { text-decoration: underline; }
.donasi-pengeluaran-sep { margin: 0 0.35rem; opacity: 0.6; }
.donasi-pengeluaran-current { color: var(--text); font-weight: 600; }
.donasi-pengeluaran-form { max-width: 480px; }
.donasi-pengeluaran-form .form-group { margin-bottom: 1.25rem; }
.donasi-pengeluaran-form .form-group label { display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.4rem; color: var(--text); }
.donasi-pengeluaran-form .form-group input[type="text"],
.donasi-pengeluaran-form .form-group input[type="number"],
.donasi-pengeluaran-form .form-group input[type="date"],
.donasi-pengeluaran-form .form-group input[type="file"] { width: 100%; padding: 0.6rem 0.875rem; border: 1px solid var(--border); border-radius: 10px; font-size: 0.95rem; }
.donasi-pengeluaran-form .form-error { display: block; font-size: 0.8rem; color: #dc2626; margin-top: 0.25rem; }
.donasi-pengeluaran-form .form-hint { display: block; font-size: 0.8rem; color: var(--text-muted); margin-top: 0.25rem; }
.donasi-pengeluaran-form .form-actions { display: flex; gap: 0.75rem; margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid var(--border); }
.donasi-pengeluaran-form .required { color: #dc2626; }
</style>
@endpush
@endsection
