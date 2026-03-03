<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Donasi – PeduliJiwa</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    <style>
        :root { --primary: #3b82f6; --primary-dark: #2563eb; --accent: #0ea5e9; --text: #0f172a; --text-muted: #64748b; --border: #e2e8f0; --bg: linear-gradient(135deg, #eff6ff 0%, #dbeafe 50%, #e0f2fe 100%); }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; color: var(--text); background: var(--bg); min-height: 100vh; }
        .navbar { background: rgba(255,255,255,0.95); backdrop-filter: blur(12px); border-bottom: 1px solid var(--border); padding: 0 1.5rem; }
        .nav-inner { max-width: 1100px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; height: 72px; }
        .nav-logo { display: flex; align-items: center; gap: 12px; font-size: 1.2rem; font-weight: 800; color: var(--primary-dark); text-decoration: none; }
        .nav-logo-icon { width: 42px; height: 42px; background: linear-gradient(135deg, var(--primary), var(--accent)); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.1rem; box-shadow: 0 4px 14px rgba(59,130,246,0.35); }
        .nav-back { display: flex; align-items: center; gap: 6px; font-size: 0.9rem; font-weight: 500; color: var(--text-muted); text-decoration: none; transition: color 0.2s; }
        .nav-back:hover { color: var(--primary-dark); }
        .page-wrapper { max-width: 680px; margin: 0 auto; padding: 4rem 1.5rem 5rem; }
        .breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 0.85rem; color: var(--text-muted); margin-bottom: 2rem; }
        .breadcrumb a { color: var(--primary); font-weight: 500; }
        .form-header { text-align: center; margin-bottom: 2.5rem; }
        .form-badge { display: inline-flex; align-items: center; gap: 6px; background: linear-gradient(135deg, rgba(59,130,246,0.12), rgba(14,165,233,0.08)); color: var(--primary-dark); font-size: 0.85rem; font-weight: 600; padding: 6px 16px; border-radius: 100px; margin-bottom: 1rem; border: 1px solid rgba(59,130,246,0.2); }
        .form-title { font-size: 1.9rem; font-weight: 800; color: var(--text); line-height: 1.25; margin-bottom: 0.6rem; }
        .form-subtitle { font-size: 0.95rem; color: var(--text-muted); line-height: 1.6; }
        .selected-program { background: white; border: 2px solid var(--border); border-radius: 16px; padding: 1.25rem 1.5rem; display: flex; align-items: center; gap: 14px; margin-bottom: 2rem; box-shadow: 0 4px 20px rgba(59,130,246,0.06); }
        .prog-icon { width: 48px; height: 48px; background: linear-gradient(135deg, var(--primary), var(--accent)); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex-shrink: 0; box-shadow: 0 4px 14px rgba(59,130,246,0.3); }
        .prog-info-label { font-size: 0.75rem; color: #8a8aaa; margin-bottom: 2px; }
        .prog-info-name { font-size: 0.95rem; font-weight: 700; color: #0f0f2d; }
        .form-card { background: white; border-radius: 24px; padding: 2rem; box-shadow: 0 10px 40px rgba(59,130,246,0.08); border: 1px solid var(--border); }
        .section-divider { font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: #8a8aaa; margin-bottom: 1.25rem; margin-top: 0.25rem; display: flex; align-items: center; gap: 10px; }
        .section-divider::after { content: ''; flex: 1; height: 1px; background: #ebebf8; }
        .form-group { margin-bottom: 1.25rem; }
        .form-label { display: block; font-size: 0.875rem; font-weight: 600; color: #1a1a2e; margin-bottom: 6px; }
        .form-label .req { color: #ef4444; margin-left: 2px; }
        .form-input { width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--border); border-radius: 12px; font-size: 0.95rem; font-family: inherit; color: var(--text); background: white; transition: all 0.2s; outline: none; }
        .form-input:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(59,130,246,0.1); }
        .form-input.is-invalid { border-color: #ef4444; }
        .form-input::placeholder { color: #aaa; }
        .invalid-feedback { font-size: 0.8rem; color: #ef4444; margin-top: 4px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        textarea.form-input { resize: vertical; min-height: 100px; }
        .amount-presets { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; margin-bottom: 10px; }
        .preset-btn { padding: 0.55rem 0.5rem; border: 1.5px solid #e0e0f0; border-radius: 9px; background: white; font-size: 0.82rem; font-weight: 600; color: #4a4a6a; cursor: pointer; transition: all 0.2s; text-align: center; }
        .preset-btn:hover, .preset-btn.active { border-color: var(--primary); color: var(--primary-dark); background: rgba(59,130,246,0.08); }
        .amount-input-wrap { position: relative; }
        .amount-prefix { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); font-weight: 600; color: #4a4a6a; font-size: 0.95rem; pointer-events: none; }
        .amount-input-wrap .form-input { padding-left: 3rem; }
        .btn-submit { width: 100%; padding: 1rem; background: linear-gradient(135deg, var(--primary), var(--accent)); border: none; border-radius: 14px; color: white; font-size: 1rem; font-weight: 700; font-family: inherit; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 20px rgba(59,130,246,0.35); display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 1.75rem; }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(59,130,246,0.45); }
        .trust-row { display: flex; gap: 1.5rem; justify-content: center; margin-top: 1.5rem; flex-wrap: wrap; }
        .trust-item { display: flex; align-items: center; gap: 6px; font-size: 0.78rem; color: #8a8aaa; }
        @media (max-width: 600px) { .form-row { grid-template-columns: 1fr; } .amount-presets { grid-template-columns: repeat(2, 1fr); } .form-title { font-size: 1.5rem; } }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-inner">
            <a href="{{ url('/') }}" class="nav-logo"><div class="nav-logo-icon">🧠</div> PeduliJiwa</a>
            <a href="{{ url('/') }}" class="nav-back">← Kembali ke Beranda</a>
        </div>
    </nav>
    <div class="page-wrapper">
        <div class="breadcrumb">
            <a href="{{ url('/') }}">Beranda</a>
            <span>›</span>
            <span>Form Donasi</span>
        </div>
        <div class="form-header">
            <div class="form-badge">❤️ Donasi Sekarang</div>
            <h1 class="form-title">Isi Data Donasi Kamu</h1>
            <p class="form-subtitle">Lengkapi formulir di bawah ini, lalu lanjutkan pembayaran menggunakan QRIS.</p>
        </div>
        <div class="selected-program">
            <div class="prog-icon">
                @if($program === 'rawat-inap') 🏥
                @elseif($program === 'pelatihan-vokasi') 🧑‍💼
                @elseif($program === 'rumah-singgah') 🏠
                @else ❤️
                @endif
            </div>
            <div>
                <div class="prog-info-label">Program yang dipilih</div>
                <div class="prog-info-name">{{ $programLabel }}</div>
            </div>
        </div>
        <div class="form-card">
            <form action="{{ route('donation.store') }}" method="POST" id="donationForm">
                @csrf
                <input type="hidden" name="program" value="{{ $program }}">
                <div class="section-divider">Data Donatur</div>
                <div class="form-group">
                    <label class="form-label" for="donor_name">Nama Lengkap <span class="req">*</span></label>
                    <input type="text" id="donor_name" name="donor_name" class="form-input {{ $errors->has('donor_name') ? 'is-invalid' : '' }}" placeholder="Masukkan nama lengkap kamu" value="{{ old('donor_name') }}" autocomplete="name">
                    @error('donor_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-row">
                    <div class="form-group" style="margin-bottom:0">
                        <label class="form-label" for="donor_email">Alamat Email <span class="req">*</span></label>
                        <input type="email" id="donor_email" name="donor_email" class="form-input {{ $errors->has('donor_email') ? 'is-invalid' : '' }}" placeholder="contoh@email.com" value="{{ old('donor_email') }}" autocomplete="email">
                        @error('donor_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group" style="margin-bottom:0">
                        <label class="form-label" for="donor_phone">Nomor Telepon <span class="req">*</span></label>
                        <input type="tel" id="donor_phone" name="donor_phone" class="form-input {{ $errors->has('donor_phone') ? 'is-invalid' : '' }}" placeholder="08xx-xxxx-xxxx" value="{{ old('donor_phone') }}" autocomplete="tel">
                        @error('donor_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="section-divider" style="margin-top:1.75rem;">Jumlah Donasi</div>
                <div class="form-group">
                    <label class="form-label">Pilih Nominal <span class="req">*</span></label>
                    <div class="amount-presets">
                        <button type="button" class="preset-btn" data-amount="25000">Rp 25.000</button>
                        <button type="button" class="preset-btn" data-amount="50000">Rp 50.000</button>
                        <button type="button" class="preset-btn" data-amount="100000">Rp 100.000</button>
                        <button type="button" class="preset-btn" data-amount="250000">Rp 250.000</button>
                        <button type="button" class="preset-btn" data-amount="500000">Rp 500.000</button>
                        <button type="button" class="preset-btn" data-amount="1000000">Rp 1.000.000</button>
                        <button type="button" class="preset-btn" data-amount="2500000">Rp 2.500.000</button>
                        <button type="button" class="preset-btn" data-amount="custom">Lainnya</button>
                    </div>
                    <div class="amount-input-wrap">
                        <span class="amount-prefix">Rp</span>
                        <input type="number" id="amount" name="amount" class="form-input {{ $errors->has('amount') ? 'is-invalid' : '' }}" placeholder="10.000" min="10000" step="1000" value="{{ old('amount') }}">
                    </div>
                    @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div style="font-size:0.78rem;color:#8a8aaa;margin-top:6px;">Minimal donasi Rp 10.000. Setiap rupiah sangat berarti! 🙏</div>
                </div>
                <div class="section-divider" style="margin-top:0.5rem;">Pesan / Doa (Opsional)</div>
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label" for="message">Pesan atau Doa</label>
                    <textarea id="message" name="message" class="form-input" placeholder="Tuliskan doa atau pesan semangat untuk para penerima manfaat…" maxlength="500">{{ old('message') }}</textarea>
                    <div style="font-size:0.75rem;color:#aaa;margin-top:4px;text-align:right;"><span id="charCount">0</span>/500</div>
                </div>
                <button type="submit" class="btn-submit" id="submitBtn">
                    <span>🔒</span> Lanjutkan ke Pembayaran QRIS
                </button>
            </form>
            <div class="trust-row">
                <div class="trust-item"><span>🔐</span> Transaksi Aman & Terenkripsi</div>
                <div class="trust-item"><span>📋</span> Laporan Donasi Transparan</div>
                <div class="trust-item"><span>✅</span> Organisasi Terverifikasi</div>
            </div>
        </div>
    </div>
    <script>
        const presets = document.querySelectorAll('.preset-btn[data-amount]');
        const amountInput = document.getElementById('amount');
        presets.forEach(btn => {
            btn.addEventListener('click', () => {
                presets.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                const val = btn.dataset.amount;
                if (val !== 'custom') { amountInput.value = val; } else { amountInput.value = ''; amountInput.focus(); }
            });
        });
        amountInput.addEventListener('input', () => presets.forEach(b => b.classList.remove('active')));
        const msgTextarea = document.getElementById('message');
        const charCount = document.getElementById('charCount');
        msgTextarea.addEventListener('input', () => { charCount.textContent = msgTextarea.value.length; });
        document.getElementById('donationForm').addEventListener('submit', () => {
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerHTML = '<span style="animation:spin 1s linear infinite;display:inline-block">⏳</span> Memproses...';
        });
    </script>
</body>
</html>
