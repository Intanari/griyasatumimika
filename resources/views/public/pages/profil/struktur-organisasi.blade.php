@extends('layouts.app')

@section('title', 'Struktur Organisasi')

@push('styles')
<style>
    :root {
        --primary: #3b82f6;
        --primary-dark: #2563eb;
        --primary-light: #60a5fa;
        --accent: #0ea5e9;
        --radius-lg: 20px;
        --radius-md: 14px;
        --text: #0f172a;
        --text-muted: #64748b;
        --border: #e2e8f0;
    }
    .page-hero, .struktur-main-wrap { background: transparent !important; }
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

    .struktur-main { max-width: 1000px; margin: 0 auto; padding: 3rem 1.5rem 4rem; }
    .org-leadership { margin-bottom: 4rem; opacity: 0; transform: translateY(20px); transition: opacity 2s cubic-bezier(0.25, 0.46, 0.45, 0.94), transform 2s cubic-bezier(0.25, 0.46, 0.45, 0.94); }
    .org-leadership.animate-visible { opacity: 1; transform: translateY(0); }
    .org-leadership-title {
        font-size: clamp(1.35rem, 3vw, 1.6rem);
        font-weight: 800;
        color: #ffffff;
        text-shadow: 0 2px 14px rgba(15, 23, 42, 0.45);
        margin-bottom: 2.25rem;
        letter-spacing: -0.02em;
    }
    .org-tree { display: flex; flex-direction: column; align-items: center; }
    .org-lead-row { display: flex; justify-content: center; gap: 1.5rem; flex-wrap: wrap; }
    .org-lead-row.children, .org-lead-row.grandchildren { margin-top: 0.75rem; gap: 1.5rem; }
    .org-lead-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border-radius: var(--radius-lg);
        border: 1px solid rgba(255, 255, 255, 0.28);
        box-shadow: none;
        padding: 1.75rem 1.5rem 1.5rem;
        text-align: center;
        width: 100%;
        max-width: 280px;
        min-height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        transition: transform 2s cubic-bezier(0.25, 0.46, 0.45, 0.94), border-color 2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .org-lead-card:hover {
        transform: translateY(-6px);
        border-color: rgba(255, 255, 255, 0.45);
    }
    .org-lead-card.ketua { order: -1; max-width: 300px; }
    .org-connector-down {
        width: 2px; height: 32px;
        background: rgba(255, 255, 255, 0.4);
        margin: 0.75rem auto; border-radius: 2px;
    }
    .org-avatar-wrap {
        position: relative;
        display: inline-block;
        margin-bottom: 0.35rem;
    }
    .org-avatar {
        width: 96px; height: 96px; border-radius: var(--radius-md);
        object-fit: cover;
        border: 2px solid rgba(255,255,255,0.35);
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.2);
    }
    .org-avatar-initials {
        width: 96px; height: 96px; border-radius: var(--radius-md);
        display: flex; align-items: center; justify-content: center;
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        color: #ffffff; font-size: 1.65rem; font-weight: 700;
        margin: 0 auto;
        border: 2px solid rgba(255,255,255,0.3);
        letter-spacing: 0.04em;
    }
    .org-badge-check {
        position: absolute; bottom: 4px; right: 4px;
        width: 32px; height: 32px; border-radius: 8px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        color: #ffffff; display: flex; align-items: center; justify-content: center;
        font-size: 0.8rem;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    .org-lead-role {
        display: inline-block;
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #e0f2ff;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.28);
        border-radius: 999px;
        padding: 0.3rem 0.75rem;
        margin-bottom: 0;
        line-height: 1.2;
    }
    .org-lead-name {
        font-size: clamp(0.88rem, 2.2vw, 0.98rem);
        font-weight: 700;
        color: #ffffff;
        line-height: 1.45;
        letter-spacing: 0.01em;
        margin-bottom: 0;
        word-break: break-word;
        hyphens: auto;
        max-width: 100%;
        text-shadow: 0 1px 8px rgba(15, 23, 42, 0.35);
    }
    .org-lead-desc {
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.88);
        line-height: 1.65;
        margin: 0;
        flex: 1;
        text-shadow: 0 1px 6px rgba(15, 23, 42, 0.3);
    }

    .org-petugas-section { margin-top: 4rem; opacity: 0; transform: translateY(20px); transition: opacity 2s cubic-bezier(0.25, 0.46, 0.45, 0.94), transform 2s cubic-bezier(0.25, 0.46, 0.45, 0.94); }
    .org-petugas-section.animate-visible { opacity: 1; transform: translateY(0); }
    .org-petugas-header { display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem; }
    .org-petugas-bar {
        width: 5px; height: 40px; border-radius: 4px;
        background: rgba(255, 255, 255, 0.4);
    }
    .org-petugas-title {
        font-size: clamp(1.35rem, 3vw, 1.6rem);
        font-weight: 800;
        color: #ffffff;
        letter-spacing: -0.02em;
        text-shadow: 0 2px 14px rgba(15, 23, 42, 0.45);
    }
    .org-petugas-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.25rem; }
    .org-petugas-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border-radius: 18px;
        border: 1px solid rgba(255, 255, 255, 0.28);
        padding: 1.35rem 1.25rem;
        box-shadow: none;
        transition: transform 2s cubic-bezier(0.25, 0.46, 0.45, 0.94), border-color 2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        position: relative; overflow: hidden;
        display: flex; flex-direction: row; align-items: flex-start; gap: 1rem;
        min-height: 100px;
    }
    .org-petugas-card:hover {
        transform: translateY(-4px);
        border-color: rgba(255, 255, 255, 0.45);
    }
    .org-petugas-card-foto { flex-shrink: 0; }
    .org-petugas-card-body {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
        padding-top: 0;
    }
    .org-petugas-icon {
        width: 80px; height: 80px; border-radius: var(--radius-md);
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        color: #ffffff; display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; font-weight: 700;
        border: 2px solid rgba(255, 255, 255, 0.3);
        flex-shrink: 0;
    }
    .org-petugas-sub {
        display: inline-block;
        align-self: flex-start;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #e0f2ff;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.28);
        border-radius: 999px;
        padding: 0.25rem 0.6rem;
        line-height: 1.2;
    }
    .org-petugas-name {
        font-size: clamp(0.88rem, 2vw, 0.95rem);
        font-weight: 700;
        color: #ffffff;
        line-height: 1.4;
        margin-bottom: 0;
        word-break: break-word;
        text-shadow: 0 1px 8px rgba(15, 23, 42, 0.35);
    }
    .org-petugas-desc {
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.88);
        line-height: 1.6;
        margin: 0;
        flex: 1;
        text-shadow: 0 1px 6px rgba(15, 23, 42, 0.3);
    }
    .org-petugas-avatar {
        width: 80px; height: 80px; border-radius: var(--radius-md);
        overflow: hidden;
        border: 2px solid rgba(255, 255, 255, 0.3);
        flex-shrink: 0;
    }
    .org-petugas-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .org-petugas-empty { grid-column: 1 / -1; text-align: center; color: rgba(255, 255, 255, 0.9); padding: 2rem; text-shadow: 0 1px 8px rgba(15, 23, 42, 0.35); }

    @media (max-width: 768px) {
        .org-lead-row { flex-direction: column; align-items: center; }
        .org-lead-card, .org-lead-card.ketua { max-width: 100%; }
        .org-petugas-grid { grid-template-columns: 1fr; }
        .org-petugas-card { flex-direction: row; }
    }
</style>
@endpush

@section('content')
<section class="section page-hero struktur-main-wrap">
    <div class="section-inner">
        <div class="section-header-center anim-fade-down">
            <div class="section-tag">Struktur Organisasi</div>
            <h2 class="section-title">Struktur Organisasi</h2>
            <p class="section-desc">
                Mengenal tim profesional di balik pelayanan kasih Griya Satu Mimika untuk pemulihan mental yang bermartabat.
            </p>
        </div>
    </div>
</section>

@php
    $k = $kepengurusan ?? collect();
    $pembina = $k->firstWhere('role', 'pembina');
    $ketuaYayasan = $k->firstWhere('role', 'ketua_yayasan');
    $ketuaPengawas = $k->firstWhere('role', 'ketua_pengawas');
    $sekretaris = $k->firstWhere('role', 'sekretaris');
    $bendahara = $k->firstWhere('role', 'bendahara');
    $pengawas = $k->firstWhere('role', 'pengawas');
    $petugasList = $petugas ?? collect();
@endphp
<main class="struktur-main struktur-main-wrap">
    <section class="org-leadership" aria-labelledby="kepengurusan-yayasan">
        <h2 id="kepengurusan-yayasan" class="org-leadership-title">Kepengurusan Yayasan</h2>
        <div class="org-tree">
            {{-- Pembina --}}
            <div class="org-lead-card ketua">
                <div class="org-avatar-wrap">
                    @if($pembina && $pembina->foto_url)
                        <img src="{{ $pembina->foto_url }}" alt="{{ $pembina->nama ?? 'Pembina' }}" class="org-avatar">
                    @else
                        <div class="org-avatar-initials">{{ $pembina ? $pembina->avatar_initials : 'PB' }}</div>
                    @endif
                </div>
                <div class="org-lead-role">{{ strtoupper(optional($pembina)->status ?? 'PEMBINA') }}</div>
                <div class="org-lead-name">{{ optional($pembina)->nama ?? 'Pembina' }}</div>
                <p class="org-lead-desc">{{ optional($pembina)->keterangan ?? '' }}</p>
            </div>
            <div class="org-connector-down" aria-hidden="true"></div>

            {{-- Ketua Yayasan & Ketua Pengawas --}}
            <div class="org-lead-row children">
                <div class="org-lead-card">
                    @if($ketuaYayasan && $ketuaYayasan->foto_url)
                        <div class="org-avatar-wrap"><img src="{{ $ketuaYayasan->foto_url }}" alt="{{ $ketuaYayasan->nama }}" class="org-avatar"></div>
                    @else
                        <div class="org-avatar-initials">{{ $ketuaYayasan ? $ketuaYayasan->avatar_initials : 'KY' }}</div>
                    @endif
                    <div class="org-lead-role">{{ strtoupper(optional($ketuaYayasan)->status ?? 'KETUA YAYASAN') }}</div>
                    <div class="org-lead-name">{{ optional($ketuaYayasan)->nama ?? 'Ketua Yayasan' }}</div>
                    <p class="org-lead-desc">{{ optional($ketuaYayasan)->keterangan ?? '' }}</p>
                </div>
                <div class="org-lead-card">
                    @if($ketuaPengawas && $ketuaPengawas->foto_url)
                        <div class="org-avatar-wrap"><img src="{{ $ketuaPengawas->foto_url }}" alt="{{ $ketuaPengawas->nama }}" class="org-avatar"></div>
                    @else
                        <div class="org-avatar-initials">{{ $ketuaPengawas ? $ketuaPengawas->avatar_initials : 'KP' }}</div>
                    @endif
                    <div class="org-lead-role">{{ strtoupper(optional($ketuaPengawas)->status ?? 'KETUA PENGAWAS') }}</div>
                    <div class="org-lead-name">{{ optional($ketuaPengawas)->nama ?? 'Ketua Pengawas' }}</div>
                    <p class="org-lead-desc">{{ optional($ketuaPengawas)->keterangan ?? '' }}</p>
                </div>
            </div>
            <div class="org-connector-down" aria-hidden="true"></div>

            {{-- Sekretaris, Bendahara, Pengawas --}}
            <div class="org-lead-row grandchildren">
                <div class="org-lead-card">
                    @if($sekretaris && $sekretaris->foto_url)
                        <div class="org-avatar-wrap"><img src="{{ $sekretaris->foto_url }}" alt="{{ $sekretaris->nama }}" class="org-avatar"></div>
                    @else
                        <div class="org-avatar-initials">{{ $sekretaris ? $sekretaris->avatar_initials : 'SK' }}</div>
                    @endif
                    <div class="org-lead-role">{{ strtoupper(optional($sekretaris)->status ?? 'SEKRETARIS') }}</div>
                    <div class="org-lead-name">{{ optional($sekretaris)->nama ?? 'Sekretaris' }}</div>
                    <p class="org-lead-desc">{{ optional($sekretaris)->keterangan ?? '' }}</p>
                </div>
                <div class="org-lead-card">
                    @if($bendahara && $bendahara->foto_url)
                        <div class="org-avatar-wrap"><img src="{{ $bendahara->foto_url }}" alt="{{ $bendahara->nama }}" class="org-avatar"></div>
                    @else
                        <div class="org-avatar-initials">{{ $bendahara ? $bendahara->avatar_initials : 'BD' }}</div>
                    @endif
                    <div class="org-lead-role">{{ strtoupper(optional($bendahara)->status ?? 'BENDAHARA') }}</div>
                    <div class="org-lead-name">{{ optional($bendahara)->nama ?? 'Bendahara' }}</div>
                    <p class="org-lead-desc">{{ optional($bendahara)->keterangan ?? '' }}</p>
                </div>
                <div class="org-lead-card">
                    @if($pengawas && $pengawas->foto_url)
                        <div class="org-avatar-wrap"><img src="{{ $pengawas->foto_url }}" alt="{{ $pengawas->nama }}" class="org-avatar"></div>
                    @else
                        <div class="org-avatar-initials">{{ $pengawas ? $pengawas->avatar_initials : 'PW' }}</div>
                    @endif
                    <div class="org-lead-role">{{ strtoupper(optional($pengawas)->status ?? 'PENGAWAS') }}</div>
                    <div class="org-lead-name">{{ optional($pengawas)->nama ?? 'Pengawas' }}</div>
                    <p class="org-lead-desc">{{ optional($pengawas)->keterangan ?? '' }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="org-petugas-section" aria-labelledby="petugas-yayasan">
        <div class="org-petugas-header">
            <div class="org-petugas-bar"></div>
            <h2 id="petugas-yayasan" class="org-petugas-title">Petugas Yayasan</h2>
        </div>
        <div class="org-petugas-grid">
            @forelse($petugasList as $p)
                <div class="org-petugas-card">
                    <div class="org-petugas-card-foto">
                        @if($p->foto_url)
                            <div class="org-petugas-avatar"><img src="{{ $p->foto_url }}" alt="{{ $p->nama }}"></div>
                        @else
                            <div class="org-petugas-icon">{{ $p->avatar_initials }}</div>
                        @endif
                    </div>
                    <div class="org-petugas-card-body">
                        @if($p->status)
                            <div class="org-petugas-sub">{{ $p->status }}</div>
                        @endif
                        <div class="org-petugas-name">{{ $p->nama }}</div>
                        @if($p->keterangan)
                            <p class="org-petugas-desc">{{ $p->keterangan }}</p>
                        @else
                            <p class="org-petugas-desc">&nbsp;</p>
                        @endif
                    </div>
                </div>
            @empty
                <p class="org-petugas-empty">Belum ada data petugas yayasan.</p>
            @endforelse
        </div>
    </section>
</main>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var animateEls = document.querySelectorAll('.org-leadership, .org-petugas-section');
    var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReducedMotion) {
        animateEls.forEach(function (el) { el.classList.add('animate-visible'); });
    } else {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) entry.target.classList.add('animate-visible');
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -20px 0px' });
        animateEls.forEach(function (el) { observer.observe(el); });
    }
});
</script>
@endpush
@endsection
