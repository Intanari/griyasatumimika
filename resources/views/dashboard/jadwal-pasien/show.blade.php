@extends('layouts.dashboard')

@section('title', 'Detail Jadwal Pasien')
@section('topbar-title', 'Detail Jadwal Pasien')

@section('content')
<a href="{{ route('dashboard.jadwal-pasien.index') }}" class="page-back-link">Kembali</a>

<div class="card jadwal-form-card">
    <div class="jadwal-form-header">
        <div class="jadwal-form-header-main">
            <div class="jadwal-form-header-left">
                <div class="jadwal-form-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <div>
                    <h2 class="jadwal-form-title">Detail Jadwal Pasien</h2>
                    <p class="jadwal-form-subtitle">{{ $schedule->patient->nama_lengkap ?? 'Pasien' }} · {{ $schedule->tanggal?->translatedFormat('d F Y') }}</p>
                </div>
            </div>
            <a href="{{ route('dashboard.jadwal-pasien.edit', $schedule) }}" class="btn btn-primary jadwal-btn-submit">Edit Jadwal</a>
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
            <dd class="jadwal-show-catatan">{{ nl2br(e($schedule->catatan)) }}</dd>
            @endif
        </dl>
    </div>
</div>
@endsection
