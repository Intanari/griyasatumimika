@extends('layouts.app')

@section('title', 'Layanan Rehabilitasi - Griya Satu Mimika')

@push('styles')
<style>
    .layanan-hero {
        padding: calc(5.25rem + 80px) 1.5rem 4rem;
        background: transparent;
        color: white;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .layanan-hero .section-inner { position: relative; z-index: 1; }
    .layanan-hero .section-header-center { max-width: 720px; margin: 0 auto; }
    .layanan-hero .section-tag {
        font-size: 0.8rem;
        letter-spacing: 0.12em;
        background: rgba(255,255,255,0.12);
        border-radius: 999px;
        padding-inline: 1rem;
        border: 1px solid rgba(255,255,255,0.3);
        color: #e0f2ff;
    }
    .layanan-hero .section-title {
        font-size: 2rem;
        line-height: 1.3;
        margin-bottom: 0.6rem;
        color: #ffffff;
    }
    .layanan-hero .section-desc {
        font-size: 0.95rem;
        line-height: 1.75;
        color: rgba(255,255,255,0.9);
    }

    .layanan-section {
        padding: 4rem 1.5rem 5rem;
        background: transparent;
    }
    .layanan-inner { max-width: 960px; margin: 0 auto; }

    .layanan-block {
        margin-bottom: 4rem;
    }
    .layanan-block:last-child { margin-bottom: 0; }
    .layanan-block-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.65rem;
    }
    .layanan-block-title .icon {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    .layanan-block-desc {
        font-size: 0.95rem;
        color: rgba(255,255,255,0.85);
        line-height: 1.75;
        margin-bottom: 2rem;
        padding-left: 3.25rem;
    }
    @media (max-width: 640px) {
        .layanan-block-desc { padding-left: 0; }
    }

    /* Proses Laporan ODGJ - Flow Cards */
    .laporan-flow {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
    }
    @media (max-width: 900px) {
        .laporan-flow { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 500px) {
        .laporan-flow { grid-template-columns: 1fr; }
    }
    .laporan-flow-card {
        background: transparent;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid rgba(255,255,255,0.25);
        box-shadow: none;
        transition: transform 2s cubic-bezier(0.25, 0.46, 0.45, 0.94), border-color 2s cubic-bezier(0.25, 0.46, 0.45, 0.94), box-shadow 2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .laporan-flow-card:hover {
        transform: translateY(-4px);
        border-color: rgba(147,197,253,0.6);
        box-shadow: 0 12px 36px rgba(37,99,235,0.15);
    }
    .laporan-flow-num {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: white;
        font-size: 1rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        box-shadow: 0 4px 14px rgba(37,99,235,0.35);
    }
    .laporan-flow-title {
        font-size: 1rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 0.5rem;
    }
    .laporan-flow-desc {
        font-size: 0.85rem;
        color: rgba(255,255,255,0.85);
        line-height: 1.6;
    }

    /* Tahapan Rehabilitasi - Timeline */
    .rehab-timeline {
        position: relative;
    }
    .rehab-timeline::before {
        content: '';
        position: absolute;
        left: 24px;
        top: 24px;
        bottom: 24px;
        width: 3px;
        background: linear-gradient(180deg, #93c5fd, #22d3ee, #a5b4fc);
        border-radius: 4px;
    }
    @media (max-width: 640px) {
        .rehab-timeline::before { left: 18px; }
    }
    .rehab-step {
        position: relative;
        padding-left: 4rem;
        padding-bottom: 2rem;
    }
    .rehab-step:last-child { padding-bottom: 0; }
    @media (max-width: 640px) {
        .rehab-step { padding-left: 3rem; }
    }
    .rehab-step-card {
        background: transparent;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: 16px;
        padding: 1.5rem 1.75rem;
        border: 1px solid rgba(255,255,255,0.25);
        box-shadow: none;
        transition: all 2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .rehab-step-card:hover {
        border-color: rgba(147,197,253,0.6);
        box-shadow: 0 8px 32px rgba(37,99,235,0.12);
    }
    .rehab-step-dot {
        position: absolute;
        left: 0;
        top: 1.5rem;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: white;
        font-size: 1.1rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 20px rgba(37,99,235,0.4);
        border: 3px solid rgba(255,255,255,0.4);
        z-index: 1;
    }
    @media (max-width: 640px) {
        .rehab-step-dot { width: 40px; height: 40px; font-size: 0.95rem; left: -2px; }
    }
    .rehab-step-tag {
        display: inline-block;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        padding: 0.3rem 0.75rem;
        background: rgba(37,99,235,0.25);
        color: #e0f2ff;
        border-radius: 999px;
        margin-bottom: 0.5rem;
    }
    .rehab-step-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 0.6rem;
    }
    .rehab-step-desc {
        font-size: 0.9rem;
        color: rgba(255,255,255,0.85);
        line-height: 1.7;
    }

    /* CTA */
    .layanan-cta {
        margin-top: 3rem;
        text-align: center;
        padding: 2.5rem 2rem;
        background: transparent;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: 20px;
        border: 1px solid rgba(255,255,255,0.25);
        box-shadow: none;
    }
    .layanan-cta h3 {
        font-size: 1.25rem;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 0.5rem;
    }
    .layanan-cta p {
        font-size: 0.95rem;
        color: rgba(255,255,255,0.9);
        margin-bottom: 1.5rem;
    }
    .btn-laporan {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem 2rem;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: white;
        font-size: 1rem;
        font-weight: 700;
        border-radius: 14px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        box-shadow: 0 4px 20px rgba(37,99,235,0.4);
        transition: all 2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .btn-laporan:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 28px rgba(37,99,235,0.5);
    }
</style>
@endpush

@section('content')
{{-- Hero --}}
<section class="section layanan-hero" style="padding-top: calc(5.25rem + 72px);">
    <div class="section-inner">
        <div class="section-header-center anim-fade-down">
            <div class="section-tag">Layanan Rehabilitasi</div>
            <h2 class="section-title">Proses dan Tahapan Laporan ODGJ</h2>
            <p class="section-desc">Setiap laporan ODGJ ditangani secara terstruktur—dari pengajuan hingga reintegrasi sosial. Kami mendampingi Anda dan penerima manfaat di setiap tahap.</p>
        </div>
    </div>
</section>

{{-- Content --}}
<section class="layanan-section">
    <div class="layanan-inner">

        {{-- Proses Laporan ODGJ (data dari dashboard admin) --}}
        <div class="layanan-block anim-fade-down">
            <h2 class="layanan-block-title"><span class="icon">📋</span>Proses Laporan ODGJ</h2>
            <p class="layanan-block-desc">
                Saat Anda mengirim laporan ODGJ melalui form kami, proses berikut akan dijalankan secara sistematis untuk memastikan respons cepat dan penanganan yang tepat.
            </p>
            @if(isset($prosesLaporanOdgj) && $prosesLaporanOdgj->isNotEmpty())
            <div class="laporan-flow">
                @foreach($prosesLaporanOdgj as $index => $item)
                <div class="laporan-flow-card anim-fade-up anim-delay-{{ min($index + 1, 4) }}">
                    <div class="laporan-flow-num">{{ $item->no_urut }}</div>
                    <div class="laporan-flow-title">{{ $item->judul }}</div>
                    <p class="laporan-flow-desc">{{ $item->keterangan }}</p>
                </div>
                @endforeach
            </div>
            @else
            <p class="layanan-block-desc" style="padding-left: 0;">Konten proses laporan ODGJ dikelola dari dashboard admin.</p>
            @endif
        </div>

        {{-- Tahapan Rehabilitasi (data dari dashboard admin) --}}
        <div class="layanan-block anim-fade-up">
            <h2 class="layanan-block-title"><span class="icon">🔄</span>Tahapan Rehabilitasi</h2>
            <p class="layanan-block-desc">
                Setelah penerima manfaat masuk ke dalam sistem kami, tahapan berikut dijalankan dengan pendekatan manusiawi dan terintegrasi.
            </p>
            @if(isset($tahapanRehabilitasi) && $tahapanRehabilitasi->isNotEmpty())
            <div class="rehab-timeline">
                @foreach($tahapanRehabilitasi as $item)
                <div class="rehab-step">
                    <div class="rehab-step-dot">{{ $item->no_urut }}</div>
                    <div class="rehab-step-card">
                        @if($item->status)
                            <span class="rehab-step-tag">{{ $item->status }}</span>
                        @endif
                        <h3 class="rehab-step-title">{{ $item->judul }}</h3>
                        <p class="rehab-step-desc">{!! nl2br(e($item->keterangan)) !!}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="layanan-block-desc" style="padding-left: 0;">Konten tahapan rehabilitasi dikelola dari dashboard admin.</p>
            @endif
        </div>

        {{-- CTA Laporan ODGJ --}}
        <div class="layanan-cta anim-scale">
            <h3>Ada ODGJ yang Perlu Pertolongan?</h3>
            <p>Kirim laporan Anda sekarang. Tim kami akan merespons secepat mungkin.</p>
            <a href="{{ route('odgj-report.form') }}" class="btn-laporan">📋 Buat Laporan ODGJ</a>
        </div>

    </div>
</section>
@endsection

