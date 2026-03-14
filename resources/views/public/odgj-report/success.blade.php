@extends('layouts.app')

@section('title', 'Laporan ODGJ Berhasil Dikirim')

@push('styles')
<style>
    .section-odgj-success { background: transparent !important; }
    .page-hero { background: transparent !important; }
    .page-hero .section-header-center { max-width: 720px; margin: 0 auto; text-align: center; }
    .page-hero .section-tag {
        display: inline-block;
        font-size: 0.8rem;
        letter-spacing: 0.12em;
        background: rgba(255,255,255,0.12);
        border-radius: 999px;
        padding-inline: 1rem;
        padding-block: 0.35rem;
        border: 1px solid rgba(255,255,255,0.3);
        color: #e0f2ff;
        margin-bottom: 0.75rem;
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
    .odgj-success-inner { max-width: 520px; margin: 0 auto; padding: 0 1.5rem 4rem; text-align: center; }
    .success-icon-wrap { display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem; }
    .success-circle {
        width: 90px;
        height: 90px;
        background: rgba(16,185,129,0.5);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        box-shadow: 0 8px 32px rgba(16,185,129,0.3);
        animation: odgjPopIn 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    @keyframes odgjPopIn {
        0% { transform: scale(0); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
    .success-title { font-size: 1.75rem; font-weight: 700; color: #ffffff; margin-bottom: 0.6rem; line-height: 1.2; }
    .success-subtitle { font-size: 0.95rem; color: rgba(255,255,255,0.9); line-height: 1.65; margin-bottom: 2rem; }
    .success-subtitle strong { color: #ffffff; }
    .nomor-laporan-card {
        background: rgba(255,255,255,0.12);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-radius: 16px;
        border: 1px solid rgba(255,255,255,0.25);
        padding: 1.25rem 1.5rem;
        margin-bottom: 2rem;
        text-align: center;
    }
    .nomor-laporan-label { font-size: 0.75rem; color: rgba(255,255,255,0.85); margin-bottom: 4px; }
    .nomor-laporan-val { font-size: 1.1rem; font-weight: 700; font-family: monospace; color: #10b981; letter-spacing: 0.05em; }
    .info-note {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 16px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 2rem;
        text-align: center;
    }
    .info-note-icon { font-size: 2rem; margin-bottom: 0.5rem; }
    .info-note-text { font-size: 0.9rem; color: rgba(255,255,255,0.95); line-height: 1.65; }
    .info-note-text strong { color: #ffffff; }
    .donation-actions { display: flex; flex-direction: column; gap: 12px; }
    .btn-home {
        display: block;
        padding: 0.9rem;
        background: linear-gradient(135deg, #2563eb, #38bdf8);
        border-radius: 14px;
        color: white;
        font-size: 0.95rem;
        font-weight: 700;
        text-decoration: none;
        text-align: center;
        transition: all 0.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        box-shadow: 0 4px 16px rgba(37,99,235,0.35);
    }
    .btn-home:hover { transform: translateY(-2px); color: white; box-shadow: 0 6px 20px rgba(37,99,235,0.45); }
    .btn-form {
        display: block;
        padding: 0.9rem;
        border: 2px solid rgba(255,255,255,0.5);
        border-radius: 12px;
        color: #ffffff;
        font-size: 0.95rem;
        font-weight: 600;
        text-align: center;
        background: rgba(255,255,255,0.1);
        text-decoration: none;
        font-family: inherit;
        transition: all 0.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .btn-form:hover { border-color: #ffffff; background: rgba(255,255,255,0.2); color: #ffffff; }
    .share-label { font-size: 0.85rem; color: rgba(255,255,255,0.9); margin-bottom: 0.75rem; font-weight: 600; }
    .share-buttons { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; margin-bottom: 2rem; }
    .btn-share {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 0.6rem 1rem;
        border-radius: 12px;
        font-size: 0.9rem;
        font-weight: 600;
        color: white;
        text-decoration: none;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        font-family: inherit;
    }
    .btn-share-wa { background: #25D366; box-shadow: 0 4px 12px rgba(37,211,102,0.4); }
    .btn-share-wa:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(37,211,102,0.5); color: white; }
    .btn-share-ig { background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); box-shadow: 0 4px 12px rgba(220,39,67,0.4); }
    .btn-share-ig:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(220,39,67,0.5); color: white; }
    .btn-share-fb { background: #1877F2; box-shadow: 0 4px 12px rgba(24,119,242,0.4); }
    .btn-share-fb:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(24,119,242,0.5); color: white; }
    @media (max-width: 600px) {
        .odgj-success-inner { padding: 0 1rem 3rem; }
        .success-title { font-size: 1.4rem; }
        .success-subtitle { font-size: 0.88rem; }
    }
</style>
@endpush

@section('content')
    <section class="page-hero" style="padding-top: calc(5.25rem + 72px);">
        <div class="section-inner">
            <div class="section-header-center anim-fade-up">
                <div class="section-tag">Laporan ODGJ</div>
                <h2 class="section-title">Terima Kasih</h2>
                <p class="section-desc">
                    @if($report->email)
                        Terima kasih <strong>{{ $report->email }}</strong> telah mengirimkan laporan ODGJ dan peduli kepada sahabat jiwa.
                    @else
                        Terima kasih telah mengirimkan laporan ODGJ dan peduli kepada sahabat jiwa. Laporan Anda telah berhasil kami terima dan akan segera ditindaklanjuti.
                    @endif
                </p>
            </div>
        </div>
    </section>

    <section class="section section-odgj-success">
        <div class="odgj-success-inner">
            <div class="success-icon-wrap"><div class="success-circle">✅</div></div>
            <h2 class="success-title">
                Laporan ODGJ berhasil dikirim.
            </h2>
            <p class="success-subtitle">
               Petugas akan segera menindaklanjuti laporan Anda dan menghubungi kontak yang Anda berikan.
                @if($report->nomor_laporan)
                    Simpan nomor laporan di bawah untuk keperluan pengecekan.
                @endif
            </p>

            @if($report->nomor_laporan)
            <div class="nomor-laporan-card anim-fade-up anim-delay-1">
                <div class="nomor-laporan-label">Nomor Laporan</div>
                <div class="nomor-laporan-val">{{ $report->nomor_laporan }}</div>
            </div>
            @endif

       

            <div class="info-note anim-fade-up anim-delay-2">
                <div class="info-note-text">
                <div class="share-buttons anim-fade-up anim-delay-1">
                <div class="share-label" style="width:100%;">Bagikan sebagai Story</div>
                <a href="#" class="btn-share btn-share-wa" id="shareWa" target="_blank" rel="noopener">
                    WhatsApp
                </a>
                <a href="#" class="btn-share btn-share-ig" id="shareIg">
                    Instagram
                </a>
                <a href="#" class="btn-share btn-share-fb" id="shareFb" target="_blank" rel="noopener">
                    Facebook
                </a>
            </div>
                </div>
            </div>

            <div class="donation-actions">
                <a href="{{ route('welcome') }}" class="btn-home">🏠 Kembali ke Beranda</a>
                <a href="{{ route('odgj-report.form') }}" class="btn-form">📋 Buat Laporan Baru</a>
            </div>
        </div>
    </section>

    @php
        $shareUrl = route('odgj-report.success', $report);
        $shareText = 'Laporan ODGJ berhasil dikirim!' . ($report->nomor_laporan ? ' No. Laporan: ' . $report->nomor_laporan : '') . ' - Griya Satu Mimika. Peduli sahabat jiwa. ' . $shareUrl;
    @endphp

    @push('scripts')
    <script>
    (function() {
        var shareUrl = @json($shareUrl);
        var shareText = @json($shareText);

        // WhatsApp - share sebagai chat/status
        document.getElementById('shareWa').href = 'https://wa.me/?text=' + encodeURIComponent(shareText);

        // Facebook
        document.getElementById('shareFb').href = 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(shareUrl);

        // Instagram - Web Share API (mobile) atau fallback copy
        document.getElementById('shareIg').addEventListener('click', function(e) {
            e.preventDefault();
            if (navigator.share) {
                navigator.share({
                    title: 'Laporan ODGJ Berhasil',
                    text: shareText,
                    url: shareUrl
                }).catch(function() {});
            } else {
                navigator.clipboard.writeText(shareText).then(function() {
                    alert('Teks berhasil disalin! Buka Instagram dan bagikan ke Story.');
                }).catch(function() {
                    prompt('Salin teks berikut untuk dibagikan:', shareText);
                });
            }
        });
    })();
    </script>
    @endpush
@endsection
