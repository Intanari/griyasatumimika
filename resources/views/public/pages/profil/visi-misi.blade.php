@extends('layouts.app')

@section('title', 'Visi & Misi')

@push('styles')
<style>
    .page-hero { background: transparent !important; }
    .page-hero .section-header-center { max-width: 720px; margin: 0 auto; text-align: center; }
    .page-hero .section-tag {
        font-size: 0.8rem;
        letter-spacing: 0.12em;
        background: rgba(255,255,255,0.12);
        border-radius: 999px;
        padding-inline: 1rem;
        border: 1px solid rgba(255,255,255,0.3);
        color: #e0f2ff;
    }
    .page-hero .section-title {
        font-size: 2rem;
        line-height: 1.3;
        margin-bottom: 0.6rem;
        color: #ffffff;
    }
    .page-hero .section-desc {
        font-size: 0.95rem;
        line-height: 1.75;
        color: rgba(255,255,255,0.9);
    }
    .profile-section { background: transparent !important; }
    .profile-section .section-inner { max-width: 960px; margin: 0 auto; }
    .profile-section .profile-body { margin-left: auto; margin-right: auto; width: 100%; }
    .profile-meta-card h2 { margin-bottom: 1rem; font-size: 1.15rem; }
    .profile-meta-card .profile-meta-content { font-size: 0.95rem; line-height: 1.75; color: var(--text-muted, #6b7280); }
</style>
@endpush

@section('content')
    {{-- Page hero --}}
    <section class="section page-hero" style="padding-top: calc(5.25rem + 72px);">
        <div class="section-inner">
            <div class="section-header-center anim-fade-down">
                <div class="section-tag">Visi & Misi</div>
                <h2 class="section-title">Yayasan PeduliJiwa</h2>
                <p class="section-desc">
                    Membangun Harapan, Memulihkan Jiwa, Memberdayakan Masyarakat.
                </p>
            </div>
        </div>
    </section>

    {{-- Content: dari data dashboard admin (Visi Misi) --}}
    <section class="section profile-section">
        <div class="section-inner">
            <div class="profile-body">
                @forelse($visiMisiItems ?? [] as $index => $item)
                    <article class="profile-meta-card {{ $index % 2 === 0 ? 'anim-fade-right' : 'anim-fade-left' }} {{ $index > 0 ? 'anim-delay-2' : '' }}">
                        <h2>{{ $item->judul }}</h2>
                        <div class="profile-meta-content">{!! nl2br(e($item->keterangan)) !!}</div>
                    </article>
                @empty
                    <article class="profile-meta-card anim-fade-right">
                        <h2>Visi & Misi</h2>
                        <p class="profile-intro-text">Konten visi & misi belum ditambahkan. Silakan kelola dari dashboard admin.</p>
                    </article>
                @endforelse
            </div>
        </div>
    </section>
@endsection

