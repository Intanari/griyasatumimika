@extends('layouts.app')

@section('title', 'Galeri Kegiatan')

@push('styles')
<style>
    .gallery-section {
        background: linear-gradient(135deg, #eff6ff 0%, #e0f2fe 35%, #f9fafb 100%);
        position: relative;
        overflow: hidden;
    }
    .gallery-section::before {
        content: '';
        position: absolute;
        inset: -40%;
        background:
            radial-gradient(circle at top left, rgba(59,130,246,0.14), transparent 60%),
            radial-gradient(circle at bottom right, rgba(14,165,233,0.12), transparent 55%);
        opacity: 0.9;
        pointer-events: none;
    }
    .gallery-section .section-inner {
        position: relative;
        z-index: 1;
    }
    .gallery-section .section-header-center {
        max-width: 720px;
        margin: 0 auto 1.75rem;
        animation: fadeInUp 2s cubic-bezier(0.25, 0.46, 0.45, 0.94) both;
    }
    .gallery-section .section-tag {
        font-size: 0.8rem;
        letter-spacing: 0.12em;
        background: rgba(59,130,246,0.08);
        border-radius: 999px;
        padding-inline: 1rem;
        border: 1px solid rgba(59,130,246,0.2);
        backdrop-filter: blur(6px);
    }
    .gallery-section .section-title {
        font-size: 2rem;
        line-height: 1.3;
        margin-bottom: 0.6rem;
        background: linear-gradient(135deg, #0f172a, #1e3a8a);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .gallery-section .section-desc {
        font-size: 0.95rem;
        line-height: 1.75;
        color: #64748b;
    }

    .gallery-section .gallery-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    body.gallery-lightbox-open .navbar {
        visibility: hidden;
        opacity: 0;
        pointer-events: none;
        transition: visibility 0.2s ease, opacity 0.2s ease;
    }

    .gallery-lightbox {
        position: fixed;
        inset: 0;
        background: rgba(7, 19, 48, 0.5);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        display: none;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 60;
        padding: 2rem 1rem 1rem;
        box-sizing: border-box;
        overflow: auto;
    }
    .gallery-lightbox.open {
        display: flex;
    }
    .gallery-lightbox-inner {
        position: relative;
        max-width: 920px;
        width: 100%;
        flex: 0 1 auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 0;
        margin-bottom: 1rem;
    }
    .gallery-lightbox-header {
        display: none;
    }
    .gallery-lightbox-image-wrap {
        position: relative;
        flex: 1 1 auto;
        min-height: 0;
        max-height: calc(100vh - 10rem);
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 1rem;
        overflow: hidden;
    }
    .gallery-lightbox-image {
        max-width: 100%;
        max-height: calc(100vh - 10rem);
        width: auto;
        height: auto;
        object-fit: contain;
        display: block;
        border-radius: 1rem;
    }
    .gallery-lightbox-close,
    .gallery-lightbox-prev,
    .gallery-lightbox-next {
        position: absolute;
        border: none;
        background: rgba(15, 23, 42, 0.9);
        color: #e5e7eb;
        border-radius: 999px;
        padding: 0.5rem 0.85rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        backdrop-filter: blur(8px);
        transition: background 0.2s ease, transform 0.2s ease;
    }
    .gallery-lightbox-close:hover,
    .gallery-lightbox-prev:hover,
    .gallery-lightbox-next:hover {
        background: rgba(15, 23, 42, 0.98);
        transform: translateY(-1px);
    }
    .gallery-lightbox-close {
        position: relative;
        top: 0;
        right: 0;
        font-size: 1.25rem;
        padding: 0.5rem 1rem;
    }
    .gallery-lightbox-prev,
    .gallery-lightbox-next {
        top: 50%;
        transform: translateY(-50%);
    }
    .gallery-lightbox-prev {
        left: 0.5rem;
    }
    .gallery-lightbox-next {
        right: 0.5rem;
    }
    .gallery-lightbox-caption {
        flex-shrink: 0;
        width: 100%;
        text-align: center;
        color: #e5e7eb;
        padding: 1rem 0.75rem 1.25rem;
    }
    .gallery-lightbox-caption-name {
        font-weight: 600;
        font-size: 1.05rem;
        margin-bottom: 0.35rem;
        color: #f1f5f9;
    }
    .gallery-lightbox-caption-desc {
        font-size: 0.9rem;
        opacity: 0.95;
        line-height: 1.5;
        max-height: 4.5em;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        color: #cbd5e1;
    }
    .gallery-empty {
        grid-column: 1 / -1;
        text-align: center;
        color: #64748b;
        padding: 2rem 1rem;
    }
    @media (max-width: 900px) {
        .gallery-section .gallery-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
    @media (max-width: 600px) {
        .gallery-section .gallery-grid {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
    }
    @media (max-width: 640px) {
        .gallery-lightbox {
            padding: 3rem 0.75rem 0 0.75rem;
        }
        .gallery-lightbox-image-wrap {
            max-height: calc(100vh - 12rem);
        }
        .gallery-lightbox-image {
            max-height: calc(100vh - 12rem);
        }
        .gallery-lightbox-prev {
            left: 0.25rem;
        }
        .gallery-lightbox-next {
            right: 0.25rem;
        }
        .gallery-lightbox-caption {
            padding: 0.85rem 0.5rem 1rem;
        }
        .gallery-lightbox-caption-name {
            font-size: 1rem;
        }
        .gallery-lightbox-caption-desc {
            font-size: 0.85rem;
            -webkit-line-clamp: 2;
        }
    }
</style>
@endpush

@php
    $activities = $activities ?? collect();
    $galleryItems = [];
    $seenUrls = [];
    if ($activities->isNotEmpty()) {
        foreach ($activities as $a) {
            $name = $a->patient ? $a->patient->nama_lengkap : '–';
            $desc = $a->deskripsi ?: '';
            $urls = $a->image_urls ?? [];
            foreach ($urls as $url) {
                if (isset($seenUrls[$url])) {
                    continue;
                }
                $seenUrls[$url] = true;
                $galleryItems[] = ['url' => $url, 'name' => $name, 'description' => $desc];
            }
        }
    }
@endphp

@section('content')
<section class="section gallery-section" style="padding-top: calc(5.25rem + 72px);">
    <div class="section-inner">
        <div class="section-header-center anim-fade-up">
            <div class="section-tag">Galeri Kegiatan Pasien</div>
            <h2 class="section-title">Setiap Langkah, Setiap Senyum</h2>
            <p class="section-desc">Setiap foto bercerita, setiap momen menginspirasi—ikuti perjalanan pasien kami di sini.</p>
        </div>
        <div class="gallery-grid">
            @forelse($galleryItems as $i => $item)
            <div class="gallery-item anim-fade-up anim-delay-1">
                <a href="{{ $item['url'] }}" class="gallery-thumb-link" data-patient-name="{{ e($item['name']) }}" data-description="{{ e($item['description']) }}">
                    <div class="gallery-thumb" style="background-image:url('{{ $item['url'] }}');"></div>
                </a>
            </div>
            @empty
            <p class="gallery-empty">Belum ada foto aktivitas pasien. Galeri akan terisi dari data aktivitas pasien.</p>
            @endforelse
        </div>
        <div class="gallery-lightbox" id="galleryLightbox" aria-hidden="true" role="dialog" aria-label="Pratinjau galeri">
            <div class="gallery-lightbox-inner">
                <div class="gallery-lightbox-header">
                    <button type="button" class="gallery-lightbox-close" aria-label="Tutup pratinjau">&times;</button>
                </div>
                <div class="gallery-lightbox-image-wrap">
                    <button type="button" class="gallery-lightbox-prev" aria-label="Lihat foto sebelumnya">&#10094;</button>
                    <img src="" alt="Foto galeri" class="gallery-lightbox-image">
                    <button type="button" class="gallery-lightbox-next" aria-label="Lihat foto berikutnya">&#10095;</button>
                </div>
                <div class="gallery-lightbox-caption">
                    <div class="gallery-lightbox-caption-name"></div>
                    <div class="gallery-lightbox-caption-desc"></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

