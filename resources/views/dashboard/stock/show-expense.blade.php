@extends('layouts.dashboard')

@section('title', 'Detail Pengeluaran Stok')
@section('topbar-title', 'Detail Pengeluaran Stok')

@section('content')
<a href="{{ route('dashboard.stock.index') }}" class="page-back-link">Back</a>

<div class="card">
    <div class="card-title">Detail Pengeluaran Stok Barang</div>
    <dl class="stock-show-dl">
        <dt>Nama stok barang</dt>
        <dd>{{ $stock_expense->nama }}</dd>
        <dt>Jumlah</dt>
        <dd>{{ number_format($stock_expense->jumlah) }}</dd>
        <dt>Waktu</dt>
        <dd>{{ $stock_expense->created_at->format('d/m/Y H:i') }}</dd>
        @if($stock_expense->gambar)
        <dt>Gambar</dt>
        <dd><img src="{{ $stock_expense->gambar_url }}" alt="Gambar stok" style="max-width:200px;max-height:150px;border-radius:8px;border:1px solid var(--border);"></dd>
        @endif
    </dl>
    <div class="form-actions" style="margin-top:1.25rem;padding-top:1rem;border-top:1px solid var(--border);">
        <a href="{{ route('dashboard.stock.pengeluaran.edit', $stock_expense) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('dashboard.stock.index') }}" class="btn btn-outline">Kembali ke Daftar</a>
    </div>
</div>

<style>
.stock-show-dl { margin: 0; display: grid; grid-template-columns: 160px 1fr; gap: 0.75rem 1.5rem; align-items: baseline; max-width: 560px; }
.stock-show-dl dt { font-size: 0.8rem; font-weight: 600; color: var(--text-muted); }
.stock-show-dl dd { margin: 0; font-size: 0.95rem; color: var(--text); }
</style>
@endsection
