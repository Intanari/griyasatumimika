<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran QRIS – PeduliJiwa</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    <style>
        :root { --primary: #3b82f6; --primary-dark: #2563eb; --accent: #0ea5e9; }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; color: #0f172a; background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 50%, #e0f2fe 100%); min-height: 100vh; }
        .navbar { background: rgba(255,255,255,0.95); backdrop-filter: blur(12px); border-bottom: 1px solid #e2e8f0; padding: 0 1.5rem; }
        .nav-inner { max-width: 1100px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; height: 72px; }
        .nav-logo { display: flex; align-items: center; gap: 12px; font-size: 1.2rem; font-weight: 800; color: var(--primary-dark); text-decoration: none; }
        .nav-logo-icon { width: 42px; height: 42px; background: linear-gradient(135deg, var(--primary), var(--accent)); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.1rem; box-shadow: 0 4px 14px rgba(59,130,246,0.35); }
        .nav-secure { display: flex; align-items: center; gap: 6px; font-size: 0.82rem; color: #6a6a8a; }
        .page-wrapper { max-width: 520px; margin: 0 auto; padding: 3rem 1.5rem 5rem; }
        .steps-bar { display: flex; align-items: center; justify-content: center; margin-bottom: 2.5rem; }
        .step { display: flex; flex-direction: column; align-items: center; gap: 4px; }
        .step-circle { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.82rem; font-weight: 700; }
        .step.done .step-circle { background: #10b981; color: white; }
        .step.active .step-circle { background: linear-gradient(135deg, var(--primary), var(--accent)); color: white; }
        .step.pending .step-circle { background: #e8e8f8; color: #aaa; }
        .step-label { font-size: 0.7rem; font-weight: 600; color: #8a8aaa; }
        .step.done .step-label, .step.active .step-label { color: var(--primary-dark); }
        .step-line { height: 2px; width: 60px; background: #e0e0f0; margin-bottom: 18px; }
        .step-line.done { background: #10b981; }
        .payment-card { background: white; border-radius: 24px; box-shadow: 0 8px 40px rgba(59,130,246,0.09); border: 1px solid #e2e8f0; overflow: hidden; }
        .card-header { background: linear-gradient(135deg, var(--primary), var(--accent)); padding: 1.5rem 2rem; text-align: center; color: white; }
        .card-header-title { font-size: 0.82rem; font-weight: 600; opacity: 0.8; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 4px; }
        .card-header-amount { font-size: 2rem; font-weight: 700; line-height: 1.1; }
        .card-header-name { font-size: 0.875rem; opacity: 0.85; margin-top: 4px; }
        .card-body { padding: 2rem; }
        .qris-label { display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 0.88rem; font-weight: 600; color: var(--primary-dark); margin-bottom: 1.25rem; }
        .qris-badge { background: linear-gradient(135deg, #e4253b, #cc1e32); color: white; font-size: 0.7rem; font-weight: 700; padding: 2px 8px; border-radius: 4px; }
        .qr-container { display: flex; justify-content: center; margin-bottom: 1.5rem; }
        .qr-frame { background: white; border: 3px solid var(--primary); border-radius: 20px; padding: 1rem; position: relative; }
        .qr-frame img { width: 200px; height: 200px; display: block; border-radius: 8px; }
        .qr-demo-placeholder { width: 200px; height: 200px; background: linear-gradient(135deg, #eff6ff, #dbeafe); border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px; text-align: center; padding: 1rem; }
        .qr-demo-placeholder .qr-icon { font-size: 3rem; }
        .qr-demo-placeholder .qr-text { font-size: 0.78rem; color: #8a8aaa; line-height: 1.4; }
        .qr-corner { position: absolute; width: 14px; height: 14px; border-color: var(--primary); border-style: solid; }
        .qr-corner-tl { top: 6px; left: 6px; border-width: 3px 0 0 3px; border-radius: 2px 0 0 0; }
        .qr-corner-tr { top: 6px; right: 6px; border-width: 3px 3px 0 0; border-radius: 0 2px 0 0; }
        .qr-corner-bl { bottom: 6px; left: 6px; border-width: 0 0 3px 3px; border-radius: 0 0 0 2px; }
        .qr-corner-br { bottom: 6px; right: 6px; border-width: 0 3px 3px 0; border-radius: 0 0 2px 0; }
        .how-to { background: #eff6ff; border-radius: 12px; padding: 1rem 1.25rem; margin-bottom: 1.5rem; }
        .how-to-title { font-size: 0.82rem; font-weight: 700; color: var(--primary-dark); margin-bottom: 0.6rem; }
        .how-to-steps { display: flex; flex-direction: column; gap: 6px; }
        .how-to-step { display: flex; align-items: flex-start; gap: 8px; font-size: 0.82rem; color: #4a4a6a; }
        .step-dot { width: 18px; height: 18px; background: linear-gradient(135deg, var(--primary), var(--accent)); border-radius: 50%; color: white; font-size: 0.65rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px; }
        .timer-wrap { text-align: center; margin-bottom: 1.5rem; }
        .timer-label { font-size: 0.8rem; color: #8a8aaa; margin-bottom: 4px; }
        .timer-display { font-size: 1.5rem; font-weight: 700; color: #0f0f2d; font-variant-numeric: tabular-nums; }
        .timer-display.warning { color: #f59e0b; }
        .timer-display.danger { color: #ef4444; }
        .apps-row { display: flex; justify-content: center; gap: 12px; margin-bottom: 1.5rem; flex-wrap: wrap; }
        .app-chip { display: flex; align-items: center; gap: 5px; background: #eff6ff; border-radius: 100px; padding: 4px 12px; font-size: 0.75rem; font-weight: 600; color: var(--primary-dark); }
        .status-check { text-align: center; padding: 1rem 0 0; }
        .status-pending { display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 0.875rem; color: #f59e0b; font-weight: 600; }
        .status-dot { width: 10px; height: 10px; background: #f59e0b; border-radius: 50%; animation: pulse 1.5s ease-in-out infinite; }
        @keyframes pulse { 0%, 100% { transform: scale(1); opacity: 1; } 50% { transform: scale(1.3); opacity: 0.6; } }
        .info-table { border-top: 1px solid #ebebf8; padding-top: 1.25rem; margin-top: 1.25rem; }
        .info-row { display: flex; justify-content: space-between; align-items: center; padding: 5px 0; font-size: 0.85rem; }
        .info-key { color: #8a8aaa; }
        .info-val { font-weight: 600; color: #1a1a2e; }
        .info-val.amount-val { font-size: 1rem; color: var(--primary-dark); }
        .order-id-wrap { display: flex; align-items: center; justify-content: space-between; background: #eff6ff; border-radius: 8px; padding: 8px 12px; margin-top: 1rem; }
        .order-id-label { font-size: 0.75rem; color: #8a8aaa; }
        .order-id-val { font-size: 0.82rem; font-weight: 600; color: #4a4a6a; font-family: monospace; }
        .copy-btn { font-size: 0.75rem; color: var(--primary-dark); background: none; border: none; cursor: pointer; font-weight: 600; }

        @media (max-width: 600px) {
            .navbar { padding: 0 1rem; }
            .nav-inner { height: 64px; }
            .page-wrapper { padding: 2rem 1rem 3rem; }
            .card-header { padding: 1.25rem 1.5rem; }
            .card-header-amount { font-size: 1.5rem; }
            .card-body { padding: 1.5rem; }
            .qr-frame img, .qr-demo-placeholder { width: 180px; height: 180px; }
            .steps-bar { margin-bottom: 1.5rem; flex-wrap: wrap; gap: 0.5rem; }
            .step-line { width: 40px; }
            .how-to-steps .how-to-step { font-size: 0.8rem; }
        }
        @media (max-width: 400px) {
            .qr-frame img, .qr-demo-placeholder { width: 160px; height: 160px; }
            .card-header-amount { font-size: 1.25rem; }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-inner">
            <a href="{{ url('/') }}" class="nav-logo"><div class="nav-logo-icon">🧠</div> PeduliJiwa</a>
            <div class="nav-secure">🔒 Pembayaran Aman</div>
        </div>
    </nav>
    <div class="page-wrapper">
        <div class="steps-bar">
            <div class="step done"><div class="step-circle">✓</div><div class="step-label">Isi Data</div></div>
            <div class="step-line done"></div>
            <div class="step active"><div class="step-circle">2</div><div class="step-label">Bayar QRIS</div></div>
            <div class="step-line"></div>
            <div class="step pending"><div class="step-circle">3</div><div class="step-label">Selesai</div></div>
        </div>
        <div class="payment-card">
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
                        @if($donation->qr_code_url)
                            <img src="{{ $donation->qr_code_url }}" alt="QRIS Code">
                        @else
                            <div class="qr-demo-placeholder">
                                <div class="qr-icon">📱</div>
                                <div class="qr-text"><strong style="color:#4f46e5">QR Code QRIS</strong><br>akan muncul di sini setelah Midtrans dikonfigurasi</div>
                            </div>
                        @endif
                    </div>
                </div>
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
                    <div class="status-pending" id="statusLabel">
                        <div class="status-dot"></div> Menunggu pembayaran…
                    </div>
                </div>
                <div class="info-table">
                    @php
                        $programs = ['rawat-inap' => 'Biaya Rawat Inap & Obat ODGJ', 'pelatihan-vokasi' => 'Pelatihan Vokasi Pasca-Rehabilitasi', 'rumah-singgah' => 'Rumah Singgah ODGJ Terlantar', 'umum' => 'Donasi Umum PeduliJiwa'];
                    @endphp
                    <div class="info-row"><span class="info-key">Program</span><span class="info-val" style="text-align:right;max-width:65%">{{ $programs[$donation->program] ?? $donation->program }}</span></div>
                    <div class="info-row"><span class="info-key">Donatur</span><span class="info-val">{{ $donation->donor_name }}</span></div>
                    <div class="info-row"><span class="info-key">Email</span><span class="info-val">{{ $donation->donor_email }}</span></div>
                    <div class="info-row"><span class="info-key">Jumlah</span><span class="info-val amount-val">{{ $donation->formatted_amount }}</span></div>
                </div>
                <div class="order-id-wrap">
                    <div><div class="order-id-label">Nomor Transaksi</div><div class="order-id-val" id="orderId">{{ $donation->order_id }}</div></div>
                    <button class="copy-btn" onclick="copyOrderId()">Salin</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        let totalSeconds = 15 * 60;
        const timerEl = document.getElementById('timer');
        function updateTimer() {
            const m = Math.floor(totalSeconds / 60).toString().padStart(2, '0');
            const s = (totalSeconds % 60).toString().padStart(2, '0');
            timerEl.textContent = `${m}:${s}`;
            if (totalSeconds <= 60) timerEl.className = 'timer-display danger';
            else if (totalSeconds <= 300) timerEl.className = 'timer-display warning';
            if (totalSeconds <= 0) {
                clearInterval(timerInterval);
                timerEl.textContent = '00:00';
                document.getElementById('statusLabel').innerHTML = '<span style="color:#ef4444">⚠️ Waktu pembayaran habis. Silakan buat donasi baru.</span>';
            }
            totalSeconds--;
        }
        updateTimer();
        const timerInterval = setInterval(updateTimer, 1000);

        const checkUrl = '{{ route('donation.check', $donation->id) }}';
        const successUrl = '{{ route('donation.success', $donation->id) }}';
        async function checkPaymentStatus() {
            try {
                const res = await fetch(checkUrl);
                const data = await res.json();
                if (data.status === 'paid') {
                    clearInterval(timerInterval);
                    clearInterval(statusInterval);
                    document.getElementById('statusLabel').innerHTML = '<span style="color:#10b981">✅ Pembayaran berhasil! Mengarahkan...</span>';
                    setTimeout(() => { window.location.href = successUrl; }, 1500);
                }
            } catch (e) {}
        }
        const statusInterval = setInterval(checkPaymentStatus, 5000);

        function copyOrderId() {
            const text = document.getElementById('orderId').textContent;
            navigator.clipboard.writeText(text).then(() => {
                const btn = document.querySelector('.copy-btn');
                btn.textContent = '✓ Tersalin';
                setTimeout(() => { btn.textContent = 'Salin'; }, 2000);
            });
        }
    </script>
</body>
</html>
