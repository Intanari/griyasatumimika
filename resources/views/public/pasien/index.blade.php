@extends('layouts.app')

@section('title', 'Semua Pasien')

@section('content')
<div class="public-page">
    <section class="section section-about" id="pasien-list">
        <div class="section-inner">
            <div class="section-head section-head-center anim-fade-down">
                <span class="section-label">Profil Pasien</span>
                <h2>Semua Pasien</h2>
                <p class="pasien-list-intro">Kenali pasien rehabilitasi yang sedang atau pernah mendapat pendampingan di Yayasan Griya Satu Mimika.</p>
            </div>

            @if($patients->isEmpty())
                <div class="pasien-list-empty anim-fade-up">
                    <span class="pasien-list-empty-icon" aria-hidden="true">👥</span>
                    <p>Belum ada data pasien yang ditampilkan.</p>
                </div>
            @else
                <div class="pasien-list-grid anim-fade-up anim-delay-1">
                    @foreach($patients as $patient)
                        <a href="{{ route('public.pasien.show', $patient) }}" class="pasien-list-card">
                            <div class="pasien-list-photo-wrap">
                                @if($patient->foto_url)
                                    <img src="{{ $patient->foto_url }}" alt="{{ $patient->nama_lengkap }}" class="pasien-list-photo" loading="lazy">
                                @else
                                    <div class="pasien-list-photo-placeholder">
                                        <span aria-hidden="true">👤</span>
                                    </div>
                                @endif
                            </div>
                            <div class="pasien-list-body">
                                <h3 class="pasien-list-name">{{ $patient->nama_lengkap }}</h3>
                                <div class="pasien-list-meta">
                                    <span>{{ $patient->umur !== null ? $patient->umur . ' tahun' : '—' }}</span>
                                    <span class="pasien-list-meta-sep">·</span>
                                    <span>{{ $patient->jenis_kelamin_label }}</span>
                                </div>
                                <span class="pasien-status pasien-status-{{ $patient->status ?? 'aktif' }}">{{ $patient->status_label }}</span>
                                @if(!empty(trim($patient->deskripsi ?? '')))
                                    <p class="pasien-list-excerpt">{{ \Illuminate\Support\Str::limit(strip_tags($patient->deskripsi), 120) }}</p>
                                @endif
                                <span class="pasien-list-link">Lihat profil →</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</div>
<style>
.pasien-list-intro {
    max-width: 640px;
    margin: 0.75rem auto 0;
    color: rgba(255,255,255,0.82);
    line-height: 1.65;
    font-size: 0.98rem;
}
.pasien-list-empty {
    max-width: 480px;
    margin: 2rem auto 0;
    padding: 2.5rem 1.5rem;
    text-align: center;
    background: rgba(255,255,255,0.08);
    border-radius: var(--radius-lg, 20px);
    border: 1px solid rgba(255,255,255,0.12);
    color: rgba(255,255,255,0.88);
}
.pasien-list-empty-icon { font-size: 2.5rem; display: block; margin-bottom: 0.75rem; }
.pasien-list-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
}
.pasien-list-card {
    display: flex;
    flex-direction: column;
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-radius: var(--radius-lg, 20px);
    border: 1px solid rgba(255,255,255,0.12);
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
}
.pasien-list-card:hover {
    transform: translateY(-4px);
    border-color: rgba(255,255,255,0.22);
    box-shadow: 0 16px 40px rgba(0,0,0,0.2);
}
.pasien-list-photo-wrap { aspect-ratio: 4 / 3; overflow: hidden; background: rgba(255,255,255,0.06); }
.pasien-list-photo {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.pasien-list-photo-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3.5rem;
    opacity: 0.75;
}
.pasien-list-body { padding: 1.25rem 1.35rem 1.5rem; display: flex; flex-direction: column; gap: 0.5rem; flex: 1; }
.pasien-list-name {
    font-size: 1.15rem;
    font-weight: 700;
    color: #fff;
    margin: 0;
    line-height: 1.35;
}
.pasien-list-meta {
    font-size: 0.88rem;
    color: rgba(255,255,255,0.72);
}
.pasien-list-meta-sep { margin: 0 0.35rem; opacity: 0.6; }
.pasien-status {
    align-self: flex-start;
    display: inline-block;
    padding: 0.3rem 0.75rem;
    border-radius: 9999px;
    font-weight: 600;
    font-size: 0.8rem;
}
.pasien-status-aktif { background: rgba(34, 197, 94, 0.3); color: #86efac; }
.pasien-status-selesai { background: rgba(59, 130, 246, 0.3); color: #93c5fd; }
.pasien-status-dirujuk { background: rgba(251, 191, 36, 0.3); color: #fde047; }
.pasien-list-excerpt {
    margin: 0.25rem 0 0;
    font-size: 0.88rem;
    line-height: 1.55;
    color: rgba(255,255,255,0.78);
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.pasien-list-link {
    margin-top: auto;
    padding-top: 0.5rem;
    font-size: 0.85rem;
    font-weight: 600;
    color: #93c5fd;
}
@media (max-width: 640px) {
    .pasien-list-grid { grid-template-columns: 1fr; gap: 1.25rem; }
}
</style>
@endsection
