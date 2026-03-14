@extends('layouts.app')

@section('title', 'Form Donasi')

@push('styles')
<style>
    .section-donation-form { background: transparent !important; }
    .page-hero { background: transparent !important; }
    .donation-page-inner { max-width: 680px; margin: 0 auto; padding: 0 1.5rem 4rem; }
    .page-hero .section-header-center { max-width: 720px; margin: 0 auto; text-align: center; }
    .page-hero .section-tag {
        font-size: 0.8rem;
        letter-spacing: 0.12em;
        background: rgba(255,255,255,0.12);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
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
    .selected-program { background: rgba(255,255,255,0.12); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.25); border-radius: 16px; padding: 1.25rem 1.5rem; display: flex; align-items: center; gap: 14px; margin-bottom: 2rem; }
    .prog-icon { width: 48px; height: 48px; background: linear-gradient(135deg, #2563eb, #38bdf8); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex-shrink: 0; box-shadow: 0 4px 14px rgba(59,130,246,0.4); }
    .prog-info-label { font-size: 0.75rem; color: rgba(255,255,255,0.7); margin-bottom: 2px; }
    .prog-info-name { font-size: 0.95rem; font-weight: 700; color: #ffffff; }
    .form-card-donation { background: rgba(255,255,255,0.12); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border-radius: 24px; padding: 2rem; box-shadow: 0 16px 48px rgba(15,23,42,0.12); border: 1px solid rgba(255,255,255,0.25); }
    .section-divider { font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: rgba(255,255,255,0.9); margin-bottom: 1.25rem; margin-top: 0.25rem; display: flex; align-items: center; gap: 10px; }
    .section-divider::after { content: ''; flex: 1; height: 1px; background: rgba(255,255,255,0.3); }
    .form-group { margin-bottom: 1.25rem; }
    .form-label { display: block; font-size: 0.875rem; font-weight: 600; color: #ffffff; margin-bottom: 6px; }
    .form-label .req { color: #ef4444; margin-left: 2px; }
    .form-card-donation .form-input,
    .form-card-donation input.form-input,
    .form-card-donation textarea.form-input { width: 100%; padding: 0.75rem 1rem; border: 2px solid rgba(255,255,255,0.35); border-radius: 14px; font-size: 0.95rem; font-family: inherit; color: #000000; background: rgba(255,255,255,0.2); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease; outline: none; }
    .form-card-donation .form-input:focus,
    .form-card-donation input.form-input:focus,
    .form-card-donation textarea.form-input:focus { border-color: rgba(59,130,246,0.8); box-shadow: 0 0 0 4px rgba(37,99,235,0.15); background: rgba(255,255,255,0.3); }
    .form-card-donation .form-input.is-invalid { border-color: #ef4444; }
    .form-card-donation .form-input::placeholder { color: #ffffff; }
    .invalid-feedback { font-size: 0.8rem; color: #ef4444; margin-top: 4px; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .form-card-donation .form-row .form-label,
    .form-card-donation .form-row label { color: #ffffff !important; }
    textarea.form-input { resize: vertical; min-height: 100px; }
    .amount-presets { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; margin-bottom: 10px; }
    .preset-btn { padding: 0.55rem 0.5rem; border: 1.5px solid rgba(255,255,255,0.35); border-radius: 9px; background: rgba(255,255,255,0.1); backdrop-filter: blur(8px); font-size: 0.82rem; font-weight: 600; color: #ffffff; cursor: pointer; transition: all 2s cubic-bezier(0.25, 0.46, 0.45, 0.94); text-align: center; }
    .preset-btn:hover, .preset-btn.active { border-color: #2563eb; color: #e0f2ff; background: rgba(37,99,235,0.25); }
    .amount-input-wrap { position: relative; }
    .amount-prefix { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); font-weight: 600; color: rgba(255,255,255,0.9); font-size: 0.95rem; pointer-events: none; }
    .amount-input-wrap .form-input { padding-left: 3rem; }
    .btn-submit { width: 100%; padding: 1rem; background: linear-gradient(135deg, #2563eb, #38bdf8); border: none; border-radius: 14px; color: white; font-size: 1rem; font-weight: 700; font-family: inherit; cursor: pointer; transition: all 2s cubic-bezier(0.25, 0.46, 0.45, 0.94); box-shadow: 0 4px 20px rgba(37,99,235,0.35); display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 1.75rem; }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(37,99,235,0.45); }
    .trust-row { display: flex; gap: 1.5rem; justify-content: center; margin-top: 1.5rem; flex-wrap: wrap; }
    .trust-item { display: flex; align-items: center; gap: 6px; font-size: 0.78rem; color: rgba(255,255,255,0.9); }
    @media (max-width: 600px) {
        .form-row { grid-template-columns: 1fr; }
        .amount-presets { grid-template-columns: repeat(2, 1fr); }
        .page-hero .section-title { font-size: 1.5rem; }
        .donation-page-inner { padding: 0 1rem 3rem; }
        .form-card-donation { padding: 1.5rem; }
        .donation-form-badge { font-size: 0.8rem; padding: 5px 12px; }
        .preset-btn { padding: 0.65rem 0.5rem; font-size: 0.78rem; min-height: 44px; }
        .trust-row { flex-direction: column; gap: 0.75rem; align-items: center; }
    }
    @media (max-width: 400px) {
        .page-hero .section-title { font-size: 1.3rem; }
        .amount-presets { grid-template-columns: 1fr; }
    }
    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>
@endpush

@section('content')
    <section class="section page-hero" style="padding-top: calc(5.25rem + 72px);">
        <div class="section-inner">
            <div class="section-header-center anim-fade-down">
                <div class="section-tag">Donasi</div>
                <h2 class="section-title">Isi Data Donasi Kamu</h2>
                <p class="section-desc">Lengkapi formulir di bawah ini, lalu lanjutkan pembayaran menggunakan QRIS.</p>
            </div>
        </div>
    </section>

    <section class="section section-donation-form">
        <div class="donation-page-inner">
            <div class="selected-program anim-fade-right">
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
            <div class="form-card-donation anim-fade-up anim-delay-2">
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
                      
                            <input type="number" id="amount" name="amount" class="form-input {{ $errors->has('amount') ? 'is-invalid' : '' }}" placeholder="10000" min="10000" step="1000" value="{{ old('amount') }}">
                        </div>
                        @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div style="font-size:0.78rem;color:rgba(255,255,255,0.85);margin-top:6px;">Minimal donasi Rp 10.000. Setiap rupiah sangat berarti! 🙏</div>
                    </div>
                    <div class="section-divider" style="margin-top:0.5rem;">Pesan / Doa (Opsional)</div>
                    <div class="form-group" style="margin-bottom:0">
                        <label class="form-label" for="message">Pesan atau Doa</label>
                        <textarea id="message" name="message" class="form-input" placeholder="Tuliskan doa atau pesan semangat untuk para penerima manfaat…" maxlength="500">{{ old('message') }}</textarea>
                        <div style="font-size:0.75rem;color:rgba(255,255,255,0.75);margin-top:4px;text-align:right;"><span id="charCount">0</span>/500</div>
                    </div>
                    <button type="submit" class="btn-submit" id="submitBtn">
                        <span>🔒</span> Lanjutkan ke Pembayaran QRIS
                    </button>
                </form>
                <div class="trust-row">
                    <div class="trust-item"><span>🔐</span> Transaksi Aman & Terenkripsi</div>
                    <div class="trust-item"><span>📋</span> Laporan Donasi Transparan</div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
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
@endpush
