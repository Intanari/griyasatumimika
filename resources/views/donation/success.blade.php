<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Donasi Berhasil – PeduliJiwa</title>
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
        .page-wrapper { max-width: 520px; margin: 0 auto; padding: 3rem 1.5rem 5rem; text-align: center; }
        .steps-bar { display: flex; align-items: center; justify-content: center; margin-bottom: 2.5rem; }
        .step { display: flex; flex-direction: column; align-items: center; gap: 4px; }
        .step-circle { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.82rem; font-weight: 700; }
        .step.done .step-circle { background: #10b981; color: white; }
        .step-label { font-size: 0.7rem; font-weight: 600; }
        .step.done .step-label { color: #10b981; }
        .step-line { height: 2px; width: 60px; background: #10b981; margin-bottom: 18px; }
        .success-icon-wrap { display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem; }
        .success-circle { width: 90px; height: 90px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; box-shadow: 0 8px 32px rgba(16,185,129,0.35); animation: popIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        @keyframes popIn { 0% { transform: scale(0); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
        .success-title { font-size: 1.75rem; font-weight: 700; color: #0f0f2d; margin-bottom: 0.6rem; line-height: 1.2; }
        .success-subtitle { font-size: 0.95rem; color: #6a6a8a; line-height: 1.65; margin-bottom: 2rem; }
        .success-subtitle strong { color: var(--primary-dark); }
        .receipt-card { background: white; border-radius: 24px; box-shadow: 0 10px 40px rgba(59,130,246,0.09); border: 1px solid #e2e8f0; overflow: hidden; margin-bottom: 2rem; text-align: left; }
        .receipt-header { background: linear-gradient(135deg, #10b981, #059669); padding: 1.25rem 1.75rem; display: flex; align-items: center; gap: 12px; }
        .receipt-header-icon { font-size: 1.5rem; }
        .receipt-header-text { color: white; }
        .receipt-header-title { font-size: 0.82rem; opacity: 0.85; margin-bottom: 2px; }
        .receipt-header-amount { font-size: 1.5rem; font-weight: 700; }
        .receipt-body { padding: 1.5rem 1.75rem; }
        .info-row { display: flex; justify-content: space-between; align-items: flex-start; padding: 8px 0; border-bottom: 1px solid #f5f5ff; font-size: 0.875rem; }
        .info-row:last-child { border-bottom: none; }
        .info-key { color: #8a8aaa; flex-shrink: 0; }
        .info-val { font-weight: 600; color: #1a1a2e; text-align: right; max-width: 65%; }
        .info-val.green { color: #10b981; }
        .order-id-chip { background: #eff6ff; border-radius: 8px; padding: 8px 12px; margin-top: 1rem; display: flex; align-items: center; justify-content: space-between; }
        .order-id-label { font-size: 0.72rem; color: #8a8aaa; margin-bottom: 2px; }
        .order-id-val { font-size: 0.82rem; font-weight: 600; font-family: monospace; color: #4a4a6a; }
        .message-card { background: #fffbf0; border: 1.5px solid #fde68a; border-radius: 16px; padding: 1.25rem 1.5rem; margin-bottom: 2rem; text-align: left; }
        .message-label { font-size: 0.75rem; font-weight: 600; color: #d97706; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.05em; }
        .message-text { font-size: 0.9rem; color: #78350f; line-height: 1.6; font-style: italic; }
        .actions { display: flex; flex-direction: column; gap: 12px; }
        .btn-home { display: block; padding: 0.9rem; background: linear-gradient(135deg, var(--primary), var(--accent)); border-radius: 14px; color: white; font-size: 0.95rem; font-weight: 700; text-decoration: none; text-align: center; transition: all 0.2s; box-shadow: 0 4px 16px rgba(59,130,246,0.35); }
        .btn-home:hover { transform: translateY(-2px); }
        .btn-share { display: block; padding: 0.9rem; border: 2px solid #e0e0f0; border-radius: 12px; color: #4a4a6a; font-size: 0.95rem; font-weight: 600; text-align: center; background: white; cursor: pointer; font-family: inherit; transition: all 0.2s; }
        .btn-share:hover { border-color: var(--primary); color: var(--primary-dark); }
        .impact-note { background: rgba(59,130,246,0.06); border-radius: 16px; padding: 1.5rem; margin-top: 2rem; text-align: center; }
        .impact-note-icon { font-size: 2rem; margin-bottom: 0.5rem; }
        .impact-note-text { font-size: 0.88rem; color: #64748b; line-height: 1.65; }
        .impact-note-text strong { color: var(--primary-dark); }

        /* ─── Modal alert (sama gaya konfirmasi dashboard) ─── */
        .modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 10000;
            background: rgba(15, 23, 42, 0.35);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s ease, visibility 0.2s ease;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }
        .modal-overlay.open {
            opacity: 1;
            visibility: visible;
        }
        .modal-box {
            background: white;
            border-radius: 16px;
            padding: 1.5rem 1.75rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.12);
            max-width: 420px;
            width: 100%;
            min-width: 0;
            max-height: calc(100vh - 2rem);
            margin: auto;
            transform: scale(0.95);
            transition: transform 0.2s ease;
        }
        .modal-overlay.open .modal-box {
            transform: scale(1);
        }
        .modal-title {
            font-size: 1rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.75rem;
            line-height: 1.3;
            word-break: break-word;
        }
        .modal-message {
            font-size: 0.9rem;
            color: #64748b;
            line-height: 1.5;
            margin-bottom: 1.25rem;
            word-break: break-word;
            max-height: 50vh;
            overflow-y: auto;
        }
        .modal-actions {
            display: flex;
            justify-content: flex-end;
        }
        .modal-actions .btn {
            min-width: 100px;
            padding: 0.6rem 1.25rem;
            font-size: 0.875rem;
            font-weight: 600;
            border-radius: 10px;
            border: none;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            font-family: inherit;
            cursor: pointer;
            min-height: 44px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.25);
        }
        .modal-actions .btn:hover {
            filter: brightness(1.06);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.35);
        }

        @media (max-width: 600px) {
            .navbar { padding: 0 1rem; }
            .nav-inner { height: 64px; }
            .page-wrapper { padding: 2rem 1rem 3rem; }
            .success-title { font-size: 1.4rem; }
            .success-subtitle { font-size: 0.88rem; }
            .receipt-header, .receipt-body { padding: 1rem 1.25rem; }
            .info-row { flex-direction: column; align-items: flex-start; gap: 4px; }
            .info-val { text-align: left; max-width: none; }
            .actions { gap: 0.75rem; }
            .modal-overlay {
                padding: 0.75rem;
                padding-top: 2rem;
                padding-bottom: 2rem;
                align-items: flex-start;
            }
            .modal-box {
                max-width: 100%;
                padding: 1.25rem 1.5rem;
                max-height: calc(100vh - 4rem);
            }
            .modal-title { font-size: 0.95rem; }
            .modal-message { font-size: 0.875rem; max-height: 45vh; }
            .modal-actions .btn {
                width: 100%;
                min-height: 48px;
            }
        }
        @media (max-width: 380px) {
            .modal-box { padding: 1.25rem 1.25rem; border-radius: 14px; }
            .modal-title { font-size: 0.9rem; }
            .modal-message { font-size: 0.85rem; max-height: 40vh; }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-inner">
            <a href="{{ url('/') }}" class="nav-logo"><div class="nav-logo-icon">🧠</div> PeduliJiwa</a>
        </div>
    </nav>
    <div class="page-wrapper">
        <div class="steps-bar">
            <div class="step done"><div class="step-circle">✓</div><div class="step-label" style="color:#10b981">Isi Data</div></div>
            <div class="step-line"></div>
            <div class="step done"><div class="step-circle">✓</div><div class="step-label" style="color:#10b981">Bayar QRIS</div></div>
            <div class="step-line"></div>
            <div class="step done"><div class="step-circle">✓</div><div class="step-label" style="color:#10b981">Selesai</div></div>
        </div>
        <div class="success-icon-wrap"><div class="success-circle">✅</div></div>
        <h1 class="success-title">Terima Kasih, {{ $donation->donor_name }}! 🙏</h1>
        <p class="success-subtitle">Donasi sebesar <strong>{{ $donation->formatted_amount }}</strong> kamu telah berhasil kami terima.<br>Email konfirmasi sudah dikirim ke <strong>{{ $donation->donor_email }}</strong>.</p>

        @php
            $programs = ['rawat-inap' => 'Biaya Rawat Inap & Obat ODGJ', 'pelatihan-vokasi' => 'Pelatihan Vokasi Pasca-Rehabilitasi', 'rumah-singgah' => 'Rumah Singgah ODGJ Terlantar', 'umum' => 'Donasi Umum PeduliJiwa'];
        @endphp

        <div class="receipt-card">
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

        <div class="actions">
            <a href="{{ url('/') }}" class="btn-home">🏠 Kembali ke Beranda</a>
            <button class="btn-share" onclick="shareReceipt()">🔗 Bagikan ke Teman</button>
        </div>
        <div class="impact-note">
            <div class="impact-note-icon">💜</div>
            <div class="impact-note-text">Donasimu akan kami salurkan langsung kepada program <strong>{{ $programs[$donation->program] ?? $donation->program }}</strong>. Terima kasih telah menjadi bagian dari perubahan!</div>
        </div>
    </div>

    <div id="alertModal" class="modal-overlay" aria-hidden="true" role="dialog">
        <div class="modal-box">
            <h3 id="alertModalTitle" class="modal-title">Info</h3>
            <p id="alertModalMessage" class="modal-message"></p>
            <div class="modal-actions">
                <button type="button" id="alertModalOk" class="btn">OK</button>
            </div>
        </div>
    </div>

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
            const text = `Saya baru saja berdonasi {{ $donation->formatted_amount }} untuk program "{{ $programs[$donation->program] ?? $donation->program }}" melalui PeduliJiwa. Yuk ikut berbagi! 💜`;
            if (navigator.share) { navigator.share({ title: 'Donasi PeduliJiwa', text: text, url: window.location.origin }); }
            else { navigator.clipboard.writeText(text).then(() => showAlertModal('Pesan sudah disalin!', 'Berhasil')); }
        }
        const colors = ['#4f46e5', '#7c3aed', '#ec4899', '#10b981', '#f59e0b'];
        for (let i = 0; i < 30; i++) {
            const c = document.createElement('div');
            c.style.cssText = `position:fixed;width:${6+Math.random()*6}px;height:${6+Math.random()*6}px;background:${colors[Math.floor(Math.random()*colors.length)]};border-radius:${Math.random()>0.5?'50%':'2px'};top:-10px;left:${Math.random()*100}vw;opacity:${0.7+Math.random()*0.3};animation:fall${i} ${1.5+Math.random()*2}s ease-in ${Math.random()}s forwards;pointer-events:none;z-index:9999;`;
            const style = document.createElement('style');
            style.textContent = `@keyframes fall${i}{to{transform:translateY(105vh) rotate(${Math.random()*360}deg);opacity:0;}}`;
            document.head.appendChild(style);
            document.body.appendChild(c);
        }
    </script>
</body>
</html>
