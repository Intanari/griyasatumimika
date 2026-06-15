@extends('layouts.app')

@section('title', 'Pembayaran QRIS')

@push('styles')
<style>
    .section-donation-payment { background: transparent !important; }
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
    .donation-page-inner { max-width: 520px; margin: 0 auto; padding: 0 1.5rem 4rem; }
    .donation-steps-bar { display: flex; align-items: center; justify-content: center; margin-bottom: 2.5rem; flex-wrap: wrap; }
    .donation-step { display: flex; flex-direction: column; align-items: center; gap: 4px; }
    .donation-step-circle { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.82rem; font-weight: 700; backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
    .donation-step.done .donation-step-circle { background: rgba(16,185,129,0.6); color: white; border: 1px solid rgba(255,255,255,0.3); }
    .donation-step.active .donation-step-circle { background: rgba(37,99,235,0.5); backdrop-filter: blur(12px); color: white; border: 1px solid rgba(255,255,255,0.3); }
    .donation-step.pending .donation-step-circle { background: rgba(255,255,255,0.12); color: rgba(255,255,255,0.7); border: 1px solid rgba(255,255,255,0.25); }
    .donation-step-label { font-size: 0.7rem; font-weight: 600; color: rgba(255,255,255,0.8); }
    .donation-step.done .donation-step-label, .donation-step.active .donation-step-label { color: #ffffff; }
    .donation-step-line { height: 2px; width: 60px; background: rgba(255,255,255,0.3); margin-bottom: 18px; }
    .donation-step-line.done { background: #10b981; }
    .payment-card { background: rgba(255,255,255,0.12); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border-radius: 24px; box-shadow: 0 16px 48px rgba(15,23,42,0.12); border: 1px solid rgba(255,255,255,0.25); overflow: hidden; }
    .card-header { background: rgba(37,99,235,0.25); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); padding: 1.5rem 2rem; text-align: center; color: white; border-bottom: 1px solid rgba(255,255,255,0.2); }
    .card-header-title { font-size: 0.82rem; font-weight: 600; opacity: 0.9; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 4px; }
    .card-header-amount { font-size: 2rem; font-weight: 700; line-height: 1.1; }
    .card-header-name { font-size: 0.875rem; opacity: 0.9; margin-top: 4px; }
    .card-body { padding: 2rem; background: transparent; }
    .qris-label { display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 0.88rem; font-weight: 600; color: #e0f2ff; margin-bottom: 1.25rem; }
    .qris-badge { background: linear-gradient(135deg, #e4253b, #cc1e32); color: white; font-size: 0.7rem; font-weight: 700; padding: 2px 8px; border-radius: 4px; }
    .qr-container { display: flex; flex-direction: column; align-items: center; gap: 1rem; margin-bottom: 1.5rem; }
    .btn-download-qris {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        padding: 0.55rem 1.1rem;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.35);
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        color: #ffffff;
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.2s, border-color 0.2s;
    }
    .btn-download-qris:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.5);
        color: #ffffff;
    }
    .qr-frame { background: rgba(255,255,255,0.2); backdrop-filter: blur(8px); border: 3px solid rgba(37,99,235,0.8); border-radius: 20px; padding: 1rem; position: relative; }
    .qr-frame img, .qr-frame canvas { width: 200px; height: 200px; display: block; border-radius: 8px; background: #ffffff; }
    .qr-demo-placeholder { width: 200px; height: 200px; background: rgba(255,255,255,0.15); backdrop-filter: blur(8px); border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px; text-align: center; padding: 1rem; border: 1px solid rgba(255,255,255,0.2); }
    .qr-demo-placeholder .qr-icon { font-size: 3rem; }
    .qr-demo-placeholder .qr-text { font-size: 0.78rem; color: rgba(255,255,255,0.85); line-height: 1.4; }
    .qr-corner { position: absolute; width: 14px; height: 14px; border-color: #2563eb; border-style: solid; }
    .qr-corner-tl { top: 6px; left: 6px; border-width: 3px 0 0 3px; border-radius: 2px 0 0 0; }
    .qr-corner-tr { top: 6px; right: 6px; border-width: 3px 3px 0 0; border-radius: 0 2px 0 0; }
    .qr-corner-bl { bottom: 6px; left: 6px; border-width: 0 0 3px 3px; border-radius: 0 0 0 2px; }
    .qr-corner-br { bottom: 6px; right: 6px; border-width: 0 3px 3px 0; border-radius: 0 0 2px 0; }
    .how-to { background: rgba(255,255,255,0.1); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.2); border-radius: 12px; padding: 1rem 1.25rem; margin-bottom: 1.5rem; }
    .how-to-title { font-size: 0.82rem; font-weight: 700; color: #e0f2ff; margin-bottom: 0.6rem; }
    .how-to-steps { display: flex; flex-direction: column; gap: 6px; }
    .how-to-step { display: flex; align-items: flex-start; gap: 8px; font-size: 0.82rem; color: rgba(255,255,255,0.9); }
    .step-dot { width: 18px; height: 18px; background: linear-gradient(135deg, #2563eb, #38bdf8); border-radius: 50%; color: white; font-size: 0.65rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px; }
    .timer-wrap { text-align: center; margin-bottom: 1.5rem; }
    .timer-label { font-size: 0.8rem; color: rgba(255,255,255,0.85); margin-bottom: 4px; }
    .timer-display { font-size: 1.5rem; font-weight: 700; color: #ffffff; font-variant-numeric: tabular-nums; }
    .timer-display.warning { color: #f59e0b; }
    .timer-display.danger { color: #ef4444; }
    .apps-row { display: flex; justify-content: center; gap: 12px; margin-bottom: 1.5rem; flex-wrap: wrap; }
    .app-chip { display: flex; align-items: center; gap: 5px; background: rgba(255,255,255,0.1); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.2); border-radius: 100px; padding: 4px 12px; font-size: 0.75rem; font-weight: 600; color: #e0f2ff; }
    .status-check { text-align: center; padding: 1rem 0 0; }
    .status-pending { display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 0.875rem; color: #f59e0b; font-weight: 600; }
    .status-dot { width: 10px; height: 10px; background: #f59e0b; border-radius: 50%; animation: donationPulse 2s ease-in-out infinite; }
    @keyframes donationPulse { 0%, 100% { transform: scale(1); opacity: 1; } 50% { transform: scale(1.3); opacity: 0.6; } }
    .info-table { border-top: 1px solid rgba(255,255,255,0.2); padding-top: 1.25rem; margin-top: 1.25rem; }
    .info-row { display: flex; justify-content: space-between; align-items: center; padding: 5px 0; font-size: 0.85rem; }
    .info-key { color: rgba(255,255,255,0.8); }
    .info-val { font-weight: 600; color: #ffffff; }
    .info-val.amount-val { font-size: 1rem; color: #93c5fd; }
    .order-id-wrap { display: flex; align-items: center; justify-content: space-between; background: rgba(255,255,255,0.1); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.2); border-radius: 8px; padding: 8px 12px; margin-top: 1rem; }
    .order-id-label { font-size: 0.75rem; color: rgba(255,255,255,0.8); }
    .order-id-val { font-size: 0.82rem; font-weight: 600; color: #ffffff; font-family: monospace; }
    .copy-btn { font-size: 0.75rem; color: #e0f2ff; background: none; border: none; cursor: pointer; font-weight: 600; }
    @media (max-width: 600px) {
        .donation-page-inner { padding: 0 1rem 3rem; }
        .card-header { padding: 1.25rem 1.5rem; }
        .card-header-amount { font-size: 1.5rem; }
        .card-body { padding: 1.5rem; }
        .qr-frame img, .qr-demo-placeholder { width: 180px; height: 180px; }
        .donation-steps-bar { margin-bottom: 1.5rem; gap: 0.5rem; }
        .donation-step-line { width: 40px; }
        .how-to-steps .how-to-step { font-size: 0.8rem; }
    }
    @media (max-width: 400px) {
        .qr-frame img, .qr-demo-placeholder { width: 160px; height: 160px; }
        .card-header-amount { font-size: 1.25rem; }
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
                <h2 class="section-title">Bayar Donasi</h2>
                <p class="section-desc">Scan QRIS untuk menyelesaikan pembayaran donasi kamu.</p>
            </div>
        </div>
    </section>

    <section class="section section-donation-payment">
        <div class="donation-page-inner">
            <div class="donation-steps-bar">
                <div class="donation-step done"><div class="donation-step-circle">✓</div><div class="donation-step-label">Isi Data</div></div>
                <div class="donation-step-line done"></div>
                <div class="donation-step active"><div class="donation-step-circle">2</div><div class="donation-step-label">Bayar QRIS</div></div>
                <div class="donation-step-line"></div>
                <div class="donation-step pending"><div class="donation-step-circle">3</div><div class="donation-step-label">Selesai</div></div>
            </div>
            <div class="payment-card anim-scale">
                <div class="card-header">
                    <div class="card-header-title">Total Donasi</div>
                    <div class="card-header-amount">{{ $donation->formatted_amount }}</div>
                    <div class="card-header-name">dari {{ $donation->donor_name }}</div>
                </div>
                <div class="card-body">
                    <div class="qris-label">Scan QR Code untuk Membayar <span class="qris-badge">QRIS</span></div>
                    <div class="qr-container">
                        <div class="qr-frame">
                            <div class="qr-corner qr-corner-tl"></div>
                            <div class="qr-corner qr-corner-tr"></div>
                            <div class="qr-corner qr-corner-bl"></div>
                            <div class="qr-corner qr-corner-br"></div>
                            @if($qrImageUrl)
                                <img src="{{ $qrImageUrl }}" alt="QRIS Code" id="qrisImage">
                            @else
                                <div class="qr-demo-placeholder">
                                    <div class="qr-icon">📱</div>
                                    <div class="qr-text"><strong style="color:#ffffff">QR Code QRIS</strong><br>sedang diproses, muat ulang halaman jika belum muncul</div>
                                </div>
                            @endif
                        </div>
                        @if($qrImageUrl)
                            <a href="{{ route('donation.qr.download', $donation) }}" class="btn-download-qris" download>
                                <span aria-hidden="true">⬇️</span> Download QRIS
                            </a>
                        @endif
                    </div>
                    @if($donation->total_amount && $donation->total_amount !== $donation->amount)
                        <div class="how-to" style="margin-bottom:1rem;">
                            <div class="how-to-title">⚠️ Nominal pembayaran</div>
                            <div class="how-to-step" style="font-size:0.82rem;color:rgba(255,255,255,0.9);">
                                Bayar tepat <strong>{{ $donation->formatted_amount }}</strong> agar transaksi terdeteksi otomatis.
                            </div>
                        </div>
                    @endif
                    <div class="timer-wrap">
                        <div class="timer-label">Batas waktu pembayaran</div>
                        <div class="timer-display" id="timer">15:00</div>
                    </div>
                    <div class="apps-row">
                        <div class="app-chip">🟢 GoPay</div>
                        <div class="app-chip">🔵 OVO</div>
                        <div class="app-chip">🔴 Dana</div>
                        <div class="app-chip">🟡 ShopeePay</div>
                        <div class="app-chip">🏦 M-Banking</div>
                    </div>
                    <div class="how-to">
                        <div class="how-to-title">📌 Cara Bayar dengan QRIS:</div>
                        <div class="how-to-steps">
                            <div class="how-to-step"><div class="step-dot">1</div><span>Buka aplikasi dompet digital atau m-banking kamu</span></div>
                            <div class="how-to-step"><div class="step-dot">2</div><span>Pilih menu <strong>Scan QR</strong> atau <strong>QRIS</strong></span></div>
                            <div class="how-to-step"><div class="step-dot">3</div><span>Arahkan kamera ke kode QR di atas</span></div>
                            <div class="how-to-step"><div class="step-dot">4</div><span>Konfirmasi jumlah <strong>{{ $donation->formatted_amount }}</strong> dan selesaikan pembayaran</span></div>
                            <div class="how-to-step"><div class="step-dot">5</div><span>Halaman ini akan otomatis diperbarui setelah pembayaran berhasil</span></div>
                        </div>
                    </div>
                    <div class="status-check">

                    </div>
                    <div class="info-table">
                        @php
                            $programs = ['rawat-inap' => 'Biaya Rawat Inap & Obat ODGJ', 'pelatihan-vokasi' => 'Pelatihan Vokasi Pasca-Rehabilitasi', 'rumah-singgah' => 'Rumah Singgah ODGJ Terlantar', 'umum' => 'Donasi Umum Griya Satu Mimika'];
                        @endphp
                        <div class="info-row"><span class="info-key">Program</span><span class="info-val" style="text-align:right;max-width:65%">{{ $programs[$donation->program] ?? $donation->program }}</span></div>
                        <div class="info-row"><span class="info-key">Donatur</span><span class="info-val">{{ $donation->donor_name }}</span></div>
                        <div class="info-row"><span class="info-key">Email</span><span class="info-val">{{ $donation->donor_email }}</span></div>
                        <div class="info-row"><span class="info-key">Jumlah</span><span class="info-val amount-val">{{ $donation->formatted_amount }}</span></div>
                    </div>
                    <div class="status-pending" id="statusLabel">
                        <div class="order-id-wrap">
                            <div class="status-dot"></div>
                            @if($donation->status === 'paid')
                                ✅ Pembayaran berhasil.
                            @elseif($donation->status === 'expired')
                                ⚠️ Pembayaran expired.
                            @elseif($donation->status === 'failed')
                                ❌ Pembayaran gagal.
                            @else
                                Menunggu pembayaran…
                            @endif
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const donationId = @json($donation->id);
    const expiredAtMs = @json($donation->expired_at ? $donation->expired_at->timestamp * 1000 : null);
    const pollIntervalMs = @json((int) config('services.donation.poll_interval_ms', 400));
    const syncIntervalMs = @json((int) config('services.donation.sync_interval_ms', 12000));
    const initialStatus = @json($donation->status);

    const timerEl = document.getElementById('timer');
    const statusLabelEl = document.getElementById('statusLabel');
    let timerInterval = null;
    let pollTimer = null;
    let lastSyncAt = 0;
    let redirecting = false;

    function setStatusLabel(html) {
        if (!statusLabelEl) return;
        statusLabelEl.innerHTML = html;
    }

    function getRemainingSeconds() {
        if (expiredAtMs) {
            return Math.max(0, Math.floor((expiredAtMs - Date.now()) / 1000));
        }
        return 15 * 60;
    }

    function updateTimer() {
        const totalSeconds = getRemainingSeconds();
        const m = Math.floor(totalSeconds / 60).toString().padStart(2, '0');
        const s = (totalSeconds % 60).toString().padStart(2, '0');
        timerEl.textContent = `${m}:${s}`;
        timerEl.className = 'timer-display'
            + (totalSeconds <= 60 ? ' danger' : (totalSeconds <= 300 ? ' warning' : ''));

        if (totalSeconds <= 0 && !redirecting) {
            if (timerInterval) clearInterval(timerInterval);
            timerEl.textContent = '00:00';
            setStatusLabel('<span style="color:#f59e0b">⚠️ Waktu pembayaran habis. Menunggu konfirmasi terakhir...</span>');
        }
    }

    updateTimer();
    timerInterval = setInterval(updateTimer, 1000);

    const checkUrl = '{{ route('donation.check', $donation->id) }}';
    const successUrl = '{{ route('donation.success', $donation->id) }}';

    function stopPolling() {
        if (timerInterval) clearInterval(timerInterval);
        if (pollTimer) clearTimeout(pollTimer);
        timerInterval = null;
        pollTimer = null;
    }

    function handlePaidStatus() {
        if (redirecting) return;
        redirecting = true;
        stopPolling();
        setStatusLabel('<span style="color:#10b981">✅ Pembayaran berhasil! Mengarahkan...</span>');
        window.location.replace(successUrl);
    }

    function scheduleNextPoll() {
        if (redirecting) return;
        pollTimer = setTimeout(pollPaymentStatus, pollIntervalMs);
    }

    async function pollPaymentStatus() {
        if (redirecting || initialStatus === 'paid') return;

        const shouldSync = Date.now() - lastSyncAt >= syncIntervalMs;
        const url = shouldSync ? `${checkUrl}?sync=1` : checkUrl;
        if (shouldSync) lastSyncAt = Date.now();

        try {
            const res = await fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                cache: 'no-store',
            });

            if (!res.ok) {
                scheduleNextPoll();
                return;
            }

            const data = await res.json();
            const status = data.status || 'pending';
            const gatewayStatus = (data.gateway_status || status || '').toLowerCase();

            if (status === 'paid' || gatewayStatus === 'settlement' || gatewayStatus === 'capture' || gatewayStatus === 'paid') {
                handlePaidStatus();
                return;
            }

            if (status === 'expired' || gatewayStatus === 'expire') {
                stopPolling();
                setStatusLabel('<span style="color:#f59e0b">⚠️ Pembayaran expired. Silakan buat donasi baru.</span>');
                return;
            }

            if (status === 'failed' || ['cancel', 'deny', 'failure'].includes(gatewayStatus)) {
                stopPolling();
                setStatusLabel('<span style="color:#ef4444">❌ Pembayaran gagal. Silakan coba lagi.</span>');
                return;
            }

            setStatusLabel('<div class="status-dot"></div> Menunggu pembayaran…');
            scheduleNextPoll();
        } catch (e) {
            scheduleNextPoll();
        }
    }

    document.addEventListener('visibilitychange', () => {
        if (!document.hidden && !redirecting) {
            pollPaymentStatus();
        }
    });

    if (initialStatus === 'paid') {
        handlePaidStatus();
    } else {
        lastSyncAt = Date.now();
        pollPaymentStatus();
    }
</script>
@endpush
