@extends('layouts.dashboard')

@section('title', 'Detail Jadwal Pasien')
@section('topbar-title', 'Detail Jadwal Pasien')

@section('content')
<div class="card jadwal-form-card">
    <div class="jadwal-form-header">
        <a href="{{ route('dashboard.jadwal-pasien.index') }}" class="jadwal-back-link">← Kembali ke Daftar</a>
        <div class="jadwal-form-header-main" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;">
            <div style="display:flex;align-items:center;gap:1rem;">
                <div class="jadwal-form-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <div>
                    <h2 class="jadwal-form-title">Detail Jadwal Pasien</h2>
                    <p class="jadwal-form-subtitle">{{ $schedule->patient->nama_lengkap ?? 'Pasien' }} · {{ $schedule->tanggal?->translatedFormat('d F Y') }}</p>
                </div>
            </div>
            <a href="{{ route('dashboard.jadwal-pasien.edit', $schedule) }}" class="jadwal-btn-submit" style="text-decoration:none;">
                Edit Jadwal
            </a>
        </div>
    </div>

    <div class="jadwal-show-body">
        <dl class="jadwal-show-dl">
            <dt>Pasien</dt>
            <dd>{{ $schedule->patient->nama_lengkap ?? '–' }}</dd>

            <dt>Pembimbing</dt>
            <dd>{{ $schedule->pembimbingUser->name ?? $schedule->pembimbing ?? '–' }}</dd>

            <dt>Tanggal</dt>
            <dd>{{ $schedule->tanggal?->locale('id')->translatedFormat('l, d F Y') ?? '–' }}</dd>

            <dt>Jam</dt>
            <dd>
                @if($schedule->jam_mulai)
                    {{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }}{{ $schedule->jam_selesai ? ' – ' . \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i') : '' }}
                @else
                    –
                @endif
            </dd>

            <dt>Tempat</dt>
            <dd>{{ $schedule->tempat ?? $schedule->lokasi ?? '–' }}</dd>

            <dt>Jenis</dt>
            <dd>{{ $schedule->jenis ?? $schedule->jenis_kegiatan ?? '–' }}</dd>

            <dt>Status</dt>
            <dd><span class="jadwal-badge jadwal-badge-{{ $schedule->status ?? 'terjadwal' }}">{{ ucfirst($schedule->status ?? 'Terjadwal') }}</span></dd>

            @if($schedule->catatan)
            <dt>Catatan</dt>
            <dd>{{ nl2br(e($schedule->catatan)) }}</dd>
            @endif
        </dl>
    </div>
</div>

@push('styles')
<style>
.jadwal-show-body { padding: 1.5rem 1.75rem; }
.jadwal-show-dl { margin: 0; display: grid; grid-template-columns: 140px 1fr; gap: 0.75rem 1.5rem; align-items: baseline; max-width: 560px; }
.jadwal-show-dl dt { font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.04em; }
.jadwal-show-dl dd { margin: 0; font-size: 0.95rem; color: var(--text); }
.jadwal-show-dl .jadwal-badge { display: inline-block; padding: 4px 10px; border-radius: 8px; font-size: 0.75rem; font-weight: 600; }
.jadwal-badge-terjadwal { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
.jadwal-badge-selesai { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
.jadwal-badge-batal { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
@media (max-width: 520px) { .jadwal-show-dl { grid-template-columns: 1fr; } }
</style>
@endpush
@endsection
