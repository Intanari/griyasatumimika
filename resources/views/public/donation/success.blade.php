@extends('layouts.app')

@section('title', 'Donasi Berhasil')

@push('styles')
<style>
    .section-donation-success { background: transparent !important; }
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
    .donation-page-inner { max-width: 520px; margin: 0 auto; padding: 0 1.5rem 4rem; text-align: center; }
    .donation-steps-bar { display: flex; align-items: center; justify-content: center; margin-bottom: 2.5rem; flex-wrap: wrap; }
    .donation-step { display: flex; flex-direction: column; align-items: center; gap: 4px; }
    .donation-step-circle { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.82rem; font-weight: 700; backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
    .donation-step.done .donation-step-circle { background: rgba(16,185,129,0.6); color: white; border: 1px solid rgba(255,255,255,0.3); }
    .donation-step-label { font-size: 0.7rem; font-weight: 600; color: #10b981; }
    .donation-step-line { height: 2px; width: 60px; background: #10b981; margin-bottom: 18px; }
    .success-icon-wrap { display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem; }
    .success-circle { width: 90px; height: 90px; background: rgba(16,185,129,0.5); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.3); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; box-shadow: 0 8px 32px rgba(16,185,129,0.3); animation: donationPopIn 2s cubic-bezier(0.25, 0.46, 0.45, 0.94); }
    @keyframes donationPopIn { 0% { transform: scale(0); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
    .success-title { font-size: 1.75rem; font-weight: 700; color: #ffffff; margin-bottom: 0.6rem; line-height: 1.2; }
    .success-subtitle { font-size: 0.95rem; color: rgba(255,255,255,0.9); line-height: 1.65; margin-bottom: 2rem; }
    .success-subtitle strong { color: #ffffff; }
    .receipt-card { background: rgba(255,255,255,0.12); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border-radius: 24px; box-shadow: 0 16px 48px rgba(15,23,42,0.12); border: 1px solid rgba(255,255,255,0.25); overflow: hidden; margin-bottom: 2rem; text-align: left; }
    .receipt-header { background: rgba(16,185,129,0.3); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); padding: 1.25rem 1.75rem; display: flex; align-items: center; gap: 12px; border-bottom: 1px solid rgba(255,255,255,0.2); }
    .receipt-header-icon { font-size: 1.5rem; }
    .receipt-header-text { color: white; }
    .receipt-header-title { font-size: 0.82rem; opacity: 0.9; margin-bottom: 2px; }
    .receipt-header-amount { font-size: 1.5rem; font-weight: 700; }
    .receipt-body { padding: 1.5rem 1.75rem; }
    .info-row { display: flex; justify-content: space-between; align-items: flex-start; padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,0.15); font-size: 0.875rem; }
    .info-row:last-child { border-bottom: none; }
    .info-key { color: rgba(255,255,255,0.85); flex-shrink: 0; }
    .info-val { font-weight: 600; color: #ffffff; text-align: right; max-width: 65%; }
    .info-val.green { color: #10b981; }
    .order-id-chip { background: rgba(255,255,255,0.1); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.2); border-radius: 8px; padding: 8px 12px; margin-top: 1rem; display: flex; align-items: center; justify-content: space-between; }
    .order-id-label { font-size: 0.72rem; color: rgba(255,255,255,0.8); margin-bottom: 2px; }
    .order-id-val { font-size: 0.82rem; font-weight: 600; font-family: monospace; color: #ffffff; }
    .message-card { background: rgba(255,251,235,0.15); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(253,230,138,0.5); border-radius: 16px; padding: 1.25rem 1.5rem; margin-bottom: 2rem; text-align: left; }
    .message-label { font-size: 0.75rem; font-weight: 600; color: #fcd34d; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.05em; }
    .message-text { font-size: 0.9rem; color: rgba(255,255,255,0.95); line-height: 1.6; font-style: italic; }
    .donation-actions { display: flex; flex-direction: column; gap: 12px; }
    .btn-home { display: block; padding: 0.9rem; background: linear-gradient(135deg, #2563eb, #38bdf8); border-radius: 14px; color: white; font-size: 0.95rem; font-weight: 700; text-decoration: none; text-align: center; transition: all 2s cubic-bezier(0.25, 0.46, 0.45, 0.94); box-shadow: 0 4px 16px rgba(37,99,235,0.35); }
    .btn-home:hover { transform: translateY(-2px); color: white; }
    .btn-share { display: block; padding: 0.9rem; border: 2px solid rgba(255,255,255,0.5); border-radius: 12px; color: #ffffff; font-size: 0.95rem; font-weight: 600; text-align: center; background: rgba(255,255,255,0.1); cursor: pointer; font-family: inherit; transition: all 2s cubic-bezier(0.25, 0.46, 0.45, 0.94); }
    .btn-share:hover { border-color: #ffffff; background: rgba(255,255,255,0.2); color: #ffffff; }
    .impact-note { background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 16px; padding: 1.5rem; margin-top: 2rem; text-align: center; }
    .impact-note-icon { font-size: 2rem; margin-bottom: 0.5rem; }
    .impact-note-text { font-size: 0.88rem; color: rgba(255,255,255,0.95); line-height: 1.65; }
    .impact-note-text strong { color: #ffffff; }

    .modal-overlay {
        position: fixed; inset: 0; z-index: 10000;
        background: rgba(15, 23, 42, 0.5);
        backdrop-filter: blur(4px);
        display: flex; align-items: center; justify-content: center;
        padding: 1rem;
        opacity: 0; visibility: hidden;
        transition: opacity 2s cubic-bezier(0.25, 0.46, 0.45, 0.94), visibility 2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        overflow-y: auto; -webkit-overflow-scrolling: touch;
    }
    .modal-overlay.open { opacity: 1; visibility: visible; }
    .modal-box {
        background: white;
        border-radius: 16px;
        padding: 1.5rem 1.75rem;
        border: 1px solid #e2e8f0;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.2);
        max-width: 420px;
        width: 100%;
        min-width: 0;
        max-height: calc(100vh - 2rem);
        margin: auto;
        transform: scale(0.95);
        transition: transform 2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .modal-overlay.open .modal-box { transform: scale(1); }
    .modal-title { font-size: 1rem; font-weight: 700; color: #0f172a; margin-bottom: 0.75rem; line-height: 1.3; word-break: break-word; }
    .modal-message { font-size: 0.9rem; color: #64748b; line-height: 1.5; margin-bottom: 1.25rem; word-break: break-word; max-height: 50vh; overflow-y: auto; }
    .modal-actions { display: flex; justify-content: flex-end; }
    .modal-actions .btn {
        min-width: 100px; padding: 0.6rem 1.25rem; font-size: 0.875rem; font-weight: 600;
        border-radius: 10px; border: none;
        background: linear-gradient(135deg, #2563eb, #38bdf8);
        color: white; font-family: inherit; cursor: pointer;
        min-height: 44px; transition: all 2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3);
    }
    .modal-actions .btn:hover { filter: brightness(1.06); }
    @media (max-width: 600px) {
        .donation-page-inner { padding: 0 1rem 3rem; }
        .success-title { font-size: 1.4rem; }
        .success-subtitle { font-size: 0.88rem; }
        .receipt-header, .receipt-body { padding: 1rem 1.25rem; }
        .info-row { flex-direction: column; align-items: flex-start; gap: 4px; }
        .info-val { text-align: left; max-width: none; }
        .donation-actions { gap: 0.75rem; }
        .modal-overlay { padding: 0.75rem 2rem; align-items: flex-start; }
        .modal-box { max-width: 100%; padding: 1.25rem 1.5rem; max-height: calc(100vh - 4rem); }
        .modal-title { font-size: 0.95rem; }
        .modal-message { font-size: 0.875rem; max-height: 45vh; }
        .modal-actions .btn { width: 100%; min-height: 48px; }
    }
    @media (max-width: 380px) {
        .modal-box { padding: 1.25rem; border-radius: 14px; }
        .modal-title { font-size: 0.9rem; }
        .modal-message { font-size: 0.85rem; max-height: 40vh; }
    }
</style>
@endpush

@section('content')
    <section class="page-hero">
        <div class="section-inner">
            <div class="section-header-center anim-fade-up">
                <p class="page-breadcrumb">
                </p>
                <div class="section-tag">Donasi</div>
                <h2 class="section-title">Donasi Berhasil</h2>
                <p class="section-desc">Terima kasih telah berdonasi untuk Griya Satu Mimika.</p>
            </div>
        </div>
    </section>

    <section class="section section-donation-success">
        <div class="donation-page-inner">
            <div class="donation-steps-bar">
                <div class="donation-step done"><div class="donation-step-circle">✓</div><div class="donation-step-label">Isi Data</div></div>
                <div class="donation-step-line"></div>
                <div class="donation-step done"><div class="donation-step-circle">✓</div><div class="donation-step-label">Bayar QRIS</div></div>
                <div class="donation-step-line"></div>
                <div class="donation-step done"><div class="donation-step-circle">✓</div><div class="donation-step-label">Selesai</div></div>
            </div>
            <div class="success-icon-wrap"><div class="success-circle">✅</div></div>
            <h2 class="success-title">Terima Kasih, {{ $donation->donor_name }}! 🙏</h2>
            <p class="success-subtitle">Donasi sebesar <strong>{{ $donation->formatted_amount }}</strong> kamu telah berhasil kami terima.<br>Email konfirmasi sudah dikirim ke <strong>{{ $donation->donor_email }}</strong>.</p>

            @php
                $programs = ['rawat-inap' => 'Biaya Rawat Inap & Obat ODGJ', 'pelatihan-vokasi' => 'Pelatihan Vokasi Pasca-Rehabilitasi', 'rumah-singgah' => 'Rumah Singgah ODGJ Terlantar', 'umum' => 'Donasi Umum Griya Satu Mimika'];
            @endphp

            <div class="receipt-card anim-fade-up anim-delay-2">
                <div class="receipt-header">
                    <div class="receipt-header-icon">🧾</div>
                    <div class="receipt-header-text">
                        <div class="receipt-header-title">Bukti Donasi</div>
                        <div class="receipt-header-amount">{{ $donation->formatted_amount }}</div>
                    </div>
                </div>
                <div class="receipt-body">
                    <div class="info-row"><span class="info-key">Program</span><span class="info-val">{{ $programs[$donation->program] ?? $donation->program }}</span></div>
                    <div class="info-row"><span class="info-key">Nama Donatur</span><span class="info-val">{{ $donation->donor_name }}</span></div>
                    <div class="info-row"><span class="info-key">Email</span><span class="info-val">{{ $donation->donor_email }}</span></div>
                    <div class="info-row"><span class="info-key">No. Telepon</span><span class="info-val">{{ $donation->donor_phone }}</span></div>
                    <div class="info-row"><span class="info-key">Metode Bayar</span><span class="info-val">QRIS</span></div>
                    <div class="info-row"><span class="info-key">Tanggal</span><span class="info-val">{{ ($donation->paid_at ?? $donation->created_at)->format('d M Y, H:i') }} WIB</span></div>
                    <div class="info-row"><span class="info-key">Status</span><span class="info-val green">✅ Lunas</span></div>
                    <div class="order-id-chip">
                        <div><div class="order-id-label">Nomor Transaksi</div><div class="order-id-val">{{ $donation->order_id }}</div></div>
                    </div>
                </div>
            </div>

            @if($donation->message)
            <div class="message-card">
                <div class="message-label">💬 Pesan & Doa kamu</div>
                <div class="message-text">"{{ $donation->message }}"</div>
            </div>
            @endif

            <div class="donation-actions">
                <a href="{{ route('welcome') }}" class="btn-home">🏠 Kembali ke Beranda</a>
                <button class="btn-share" onclick="shareReceipt()">🔗 Bagikan ke Teman</button>
            </div>
            <div class="impact-note">
                <div class="impact-note-icon">💜</div>
                <div class="impact-note-text">Donasimu akan kami salurkan langsung kepada program <strong>{{ $programs[$donation->program] ?? $donation->program }}</strong>. Terima kasih telah menjadi bagian dari perubahan!</div>
            </div>
        </div>
    </section>

    <div id="alertModal" class="modal-overlay" aria-hidden="true" role="dialog">
        <div class="modal-box">
            <h3 id="alertModalTitle" class="modal-title">Info</h3>
            <p id="alertModalMessage" class="modal-message"></p>
            <div class="modal-actions">
                <button type="button" id="alertModalOk" class="btn">OK</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function showAlertModal(message, title) {
        var el = document.getElementById('alertModal');
        var titleEl = document.getElementById('alertModalTitle');
        var msgEl = document.getElementById('alertModalMessage');
        if (titleEl) titleEl.textContent = title || 'Info';
        if (msgEl) msgEl.textContent = message || '';
        if (el) { el.classList.add('open'); el.setAttribute('aria-hidden', 'false'); }
    }
    function closeAlertModal() {
        var el = document.getElementById('alertModal');
        if (el) { el.classList.remove('open'); el.setAttribute('aria-hidden', 'true'); }
    }
    document.getElementById('alertModalOk').addEventListener('click', closeAlertModal);
    document.getElementById('alertModal').addEventListener('click', function(e) { if (e.target === this) closeAlertModal(); });

    function shareReceipt() {
        const text = `Saya baru saja berdonasi {{ $donation->formatted_amount }} untuk program "{{ $programs[$donation->program] ?? $donation->program }}" melalui Griya Satu Mimika. Yuk ikut berbagi! 💜`;
        if (navigator.share) { navigator.share({ title: 'Donasi Griya Satu Mimika', text: text, url: window.location.origin }); }
        else { navigator.clipboard.writeText(text).then(() => showAlertModal('Pesan sudah disalin!', 'Berhasil')); }
    }
</script>
@endpush
