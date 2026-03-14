@extends('layouts.dashboard')

@section('title', 'Kelola Shift')
@section('topbar-title', 'Kelola Shift')

@section('content')
<div class="sf-page">
    <nav class="sf-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sf-breadcrumb-sep">/</span>
        <a href="{{ route('dashboard.jadwal-petugas.index') }}">Jadwal Petugas</a>
        <span class="sf-breadcrumb-sep">/</span>
        <span class="sf-breadcrumb-current">Kelola Shift</span>
    </nav>

    <div class="sf-card">
        <div class="sf-header">
            <div class="sf-header-main">
                <a href="{{ route('dashboard.jadwal-petugas.index') }}" class="sf-back">← Kembali ke Jadwal Petugas</a>
                <div class="sf-header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div>
                    <h2 class="sf-title">Kelola Shift</h2>
                    <p class="sf-subtitle">Atur waktu shift (jam mulai – jam selesai)</p>
                </div>
            </div>
            <a href="{{ route('dashboard.shifts.create') }}" class="sf-btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Shift
            </a>
        </div>

        <p class="page-table-desc">Tabel berikut berisi daftar shift (nama dan jam mulai–selesai). Shift digunakan untuk penjadwalan petugas. Klik Tambah Shift untuk menambah shift baru.</p>
        <div class="sf-body">
            @if($shifts->isEmpty())
                <div class="sf-empty">
                    <div class="sf-empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <h3 class="sf-empty-title">Belum ada shift</h3>
                    <p class="sf-empty-text">Buat shift baru untuk mengatur jam kerja petugas.</p>
                    <a href="{{ route('dashboard.shifts.create') }}" class="sf-btn-primary sf-btn-empty">+ Tambah Shift</a>
                </div>
            @else
                <div class="sf-table-wrap">
                    <table class="sf-table">
                        <thead>
                            <tr>
                                <th class="sf-th-no">No</th>
                                <th>Nama</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th class="sf-th-aksi">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shifts as $i => $s)
                                <tr>
                                    <td class="sf-td-no" data-label="No">{{ $i + 1 }}</td>
                                    <td data-label="Nama"><span class="sf-nama">{{ $s->nama }}</span></td>
                                    <td data-label="Jam Mulai"><span class="sf-time">{{ \Carbon\Carbon::parse($s->jam_mulai)->format('H:i') }}</span></td>
                                    <td data-label="Jam Selesai"><span class="sf-time">{{ \Carbon\Carbon::parse($s->jam_selesai)->format('H:i') }}</span></td>
                                    <td data-label="Aksi">
                                        <div class="sf-actions">
                                            <a href="{{ route('dashboard.shifts.edit', $s) }}" class="sf-action sf-action-edit" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                                Edit
                                            </a>
                                            <form action="{{ route('dashboard.shifts.destroy', $s) }}" method="POST" class="sf-action-form" data-confirm="Yakin ingin menghapus shift ini?">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="sf-action sf-action-delete" title="Hapus">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
.sf-page { max-width: 960px; margin: 0 auto; padding: 0 0.5rem; font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; }
.sf-breadcrumb { font-size: 0.875rem; color: #64748b; margin-bottom: 1.5rem; line-height: 1.5; }
.sf-breadcrumb a { color: var(--primary); text-decoration: none; font-weight: 500; }
.sf-breadcrumb a:hover { text-decoration: underline; }
.sf-breadcrumb-sep { margin: 0 0.35rem; opacity: 0.6; }
.sf-breadcrumb-current { color: #1e293b; font-weight: 600; }

.sf-card {
    background: #fff; border-radius: 20px; overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04), 0 8px 32px rgba(59,130,246,0.06);
    border: 1px solid #e2e8f0;
}
.sf-header {
    display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-start; gap: 1.25rem;
    padding: 1.5rem 2rem; border-bottom: 1px solid #e2e8f0; background: linear-gradient(180deg, #f8fafc 0%, #fff 100%);
}
.sf-header-main { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
.sf-back { display: block; font-size: 0.85rem; font-weight: 600; color: #64748b; margin-bottom: 0.5rem; text-decoration: none; }
.sf-back:hover { color: var(--primary); }
.sf-header-icon {
    width: 52px; height: 52px; border-radius: 14px; flex-shrink: 0;
    background: linear-gradient(135deg, rgba(59,130,246,0.12), rgba(14,165,233,0.08));
    border: 1px solid rgba(59,130,246,0.2); color: var(--primary);
    display: flex; align-items: center; justify-content: center;
}
.sf-title { font-size: 1.25rem; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.02em; }
.sf-subtitle { font-size: 0.9rem; color: #64748b; margin: 4px 0 0; }
.sf-btn-primary {
    display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.7rem 1.5rem;
    background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff; font-size: 0.95rem; font-weight: 700;
    border-radius: 12px; text-decoration: none; box-shadow: 0 4px 12px rgba(37,99,235,0.3);
    transition: transform 0.15s, box-shadow 0.2s; border: none; cursor: pointer; font-family: inherit;
}
.sf-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(37,99,235,0.4); color: #fff; }

.sf-body { padding: 0; }
.sf-empty {
    display: flex; flex-direction: column; align-items: center; text-align: center;
    padding: 3rem 2rem;
}
.sf-empty-icon { width: 88px; height: 88px; border-radius: 20px; background: linear-gradient(135deg, #eff6ff, #dbeafe); display: flex; align-items: center; justify-content: center; color: #60a5fa; margin-bottom: 1.25rem; }
.sf-empty-title { font-size: 1.2rem; font-weight: 700; color: #1e293b; margin: 0 0 0.5rem; }
.sf-empty-text { font-size: 0.95rem; color: #64748b; margin-bottom: 1.5rem; line-height: 1.5; }
.sf-btn-empty { margin-top: 0; }

.sf-table-wrap { overflow-x: auto; }
.sf-table { width: 100%; border-collapse: collapse; font-size: 0.95rem; }
.sf-table thead th {
    padding: 1rem 1.5rem; text-align: left; font-size: 0.7rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.08em; color: #64748b;
    background: #f8fafc; border-bottom: 2px solid #e2e8f0;
}
.sf-th-no { width: 56px; text-align: center !important; }
.sf-th-aksi { text-align: right !important; width: 140px; }
.sf-table tbody td { padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
.sf-table tbody tr:hover td { background: #fafbff; }
.sf-table tbody tr:last-child td { border-bottom: none; }
.sf-td-no { text-align: center; color: #94a3b8; font-weight: 600; font-size: 0.9rem; }
.sf-nama { font-weight: 600; color: #1e293b; }
.sf-time { font-size: 0.9rem; color: #475569; font-variant-numeric: tabular-nums; }
.sf-actions { display: flex; gap: 0.5rem; justify-content: flex-end; align-items: center; flex-wrap: wrap; }
.sf-action, .sf-action-form { display: inline-flex; }
.sf-action {
    display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 10px;
    font-size: 0.85rem; font-weight: 600; text-decoration: none; border: 1px solid transparent;
    cursor: pointer; font-family: inherit; transition: all 0.15s; background: #f8fafc; color: #475569; border-color: #e2e8f0;
}
.sf-action:hover { background: #2563eb; color: #fff; border-color: #2563eb; }
.sf-action-delete { background: #fef2f2 !important; color: #dc2626 !important; border-color: #fecaca !important; }
.sf-action-delete:hover { background: #ef4444 !important; color: #fff !important; border-color: #ef4444 !important; }
.sf-action svg { flex-shrink: 0; }

@media (max-width: 640px) {
    .sf-header { flex-direction: column; padding: 1.25rem 1.5rem; }
    .sf-table thead th, .sf-table tbody td { padding: 0.875rem 1rem; font-size: 0.875rem; }
}
</style>
@endpush
@endsection
