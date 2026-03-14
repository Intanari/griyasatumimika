@extends('layouts.app')

@section('title', 'Profil Pasien - ' . $patient->nama_lengkap)

@section('content')
<div class="public-page">
    <section class="section section-about" id="pasien">
        <div class="section-inner">
            <div class="section-head section-head-center anim-fade-down">
                <span class="section-label">Profil Pasien</span>
                <h2>{{ $patient->nama_lengkap }}</h2>
            </div>

            <div class="pasien-profile anim-fade-up anim-delay-1">
                <div class="pasien-profile-card">
                    <div class="pasien-photo-wrap">
                        @if($patient->foto_url)
                            <img src="{{ $patient->foto_url }}" alt="{{ $patient->nama_lengkap }}" class="pasien-photo">
                        @else
                            <div class="pasien-photo-placeholder">
                                <span class="pasien-photo-icon">👤</span>
                            </div>
                        @endif
                    </div>
                    <div class="pasien-details">
                        <div class="pasien-detail-row">
                            <span class="pasien-detail-label">Nama Lengkap</span>
                            <span class="pasien-detail-value">{{ $patient->nama_lengkap }}</span>
                        </div>
                        <div class="pasien-detail-row">
                            <span class="pasien-detail-label">Tempat, Tanggal Lahir</span>
                            <span class="pasien-detail-value">
                                {{ $patient->tempat_lahir ?? '-' }},
                                {{ $patient->tanggal_lahir ? $patient->tanggal_lahir->translatedFormat('d F Y') : '-' }}
                            </span>
                        </div>
                        <div class="pasien-detail-row">
                            <span class="pasien-detail-label">Jenis Kelamin</span>
                            <span class="pasien-detail-value">{{ $patient->jenis_kelamin_label }}</span>
                        </div>
                        <div class="pasien-detail-row">
                            <span class="pasien-detail-label">Tanggal Masuk</span>
                            <span class="pasien-detail-value">
                                {{ $patient->tanggal_masuk ? $patient->tanggal_masuk->translatedFormat('d F Y') : '-' }}
                            </span>
                        </div>
                        <div class="pasien-detail-row">
                            <span class="pasien-detail-label">Status</span>
                            <span class="pasien-detail-value pasien-status pasien-status-{{ $patient->status ?? 'aktif' }}">{{ $patient->status_label }}</span>
                        </div>
                        @if(($patient->status ?? '') === 'selesai' && $patient->tanggal_keluar)
                            <div class="pasien-detail-row">
                                <span class="pasien-detail-label">Tanggal Keluar</span>
                                <span class="pasien-detail-value">{{ $patient->tanggal_keluar->translatedFormat('d F Y') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                @if(!empty(trim($patient->deskripsi ?? '')))
                    <div class="pasien-cerita anim-fade-up anim-delay-2">
                        <h3 class="pasien-cerita-title">Cerita Pasien</h3>
                        <div class="pasien-cerita-body">{!! nl2br(e($patient->deskripsi)) !!}</div>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
<style>
.pasien-profile { max-width: 720px; margin: 0 auto; }
.pasien-profile-card {
    display: flex;
    flex-wrap: wrap;
    gap: 2rem;
    align-items: flex-start;
    padding: 2rem;
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-radius: var(--radius-lg, 20px);
    border: 1px solid rgba(255,255,255,0.12);
    margin-bottom: 2rem;
}
.pasien-photo-wrap { flex-shrink: 0; }
.pasien-photo {
    width: 180px;
    height: 180px;
    object-fit: cover;
    border-radius: 12px;
    border: 2px solid rgba(255,255,255,0.2);
}
.pasien-photo-placeholder {
    width: 180px;
    height: 180px;
    border-radius: 12px;
    background: rgba(255,255,255,0.1);
    border: 2px solid rgba(255,255,255,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
}
.pasien-photo-icon { font-size: 4rem; opacity: 0.8; }
.pasien-details {
    flex: 1;
    min-width: 240px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem 2rem;
}
.pasien-detail-row {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}
.pasien-detail-label {
    font-size: 0.85rem;
    font-weight: 600;
    color: rgba(255,255,255,0.7);
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.pasien-detail-value { font-size: 1.05rem; color: #fff; }
.pasien-status {
    display: inline-block;
    padding: 0.35rem 0.85rem;
    border-radius: 9999px;
    font-weight: 600;
    font-size: 0.9rem;
}
.pasien-status-aktif { background: rgba(34, 197, 94, 0.3); color: #86efac; }
.pasien-status-selesai { background: rgba(59, 130, 246, 0.3); color: #93c5fd; }
.pasien-status-dirujuk { background: rgba(251, 191, 36, 0.3); color: #fde047; }
.pasien-cerita {
    padding: 2rem;
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-radius: var(--radius-lg, 20px);
    border: 1px solid rgba(255,255,255,0.12);
}
.pasien-cerita-title {
    font-size: 1.25rem;
    margin-bottom: 1rem;
    color: #fff;
}
.pasien-cerita-body {
    color: rgba(255,255,255,0.92);
    line-height: 1.7;
    white-space: pre-wrap;
}
@media (max-width: 640px) {
    .pasien-profile-card { flex-direction: column; align-items: center; text-align: center; }
    .pasien-details { width: 100%; grid-template-columns: 1fr; }
}
</style>
@endsection
