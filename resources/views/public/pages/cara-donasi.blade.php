@extends('layouts.app')

@section('title', 'Cara Berdonasi')

@section('content')
<section class="section steps-section" style="padding-top: calc(5.25rem + 72px);">
    <div class="section-inner">
        <div class="section-header-center anim-fade-up">
            <div class="section-tag">Cara Berdonasi</div>
            <h2 class="section-title">Mudah, Aman, dan Transparan</h2>
            <p class="section-desc">Berdonasi hanya butuh beberapa langkah. Semua transaksi aman dan terdokumentasi secara transparan.</p>
        </div>
        <div class="steps-grid">
            <div class="step-card anim-fade-left anim-delay-1"><div class="step-num">1</div><div class="step-title">Pilih Program</div><div class="step-desc">Telusuri dan pilih program rehabilitasi yang ingin kamu dukung.</div></div>
            <div class="step-card anim-fade-right anim-delay-2"><div class="step-num">2</div><div class="step-title">Tentukan Nominal</div><div class="step-desc">Masukkan jumlah donasi. Tidak ada minimum.</div></div>
            <div class="step-card anim-fade-left anim-delay-3"><div class="step-num">3</div><div class="step-title">Bayar via QRIS</div><div class="step-desc">Scan QR Code menggunakan GoPay, OVO, DANA, ShopeePay, atau m-banking.</div></div>
            <div class="step-card anim-fade-right anim-delay-4"><div class="step-num">4</div><div class="step-title">Terima Laporan</div><div class="step-desc">Dapatkan email konfirmasi dan laporan penggunaan dana secara berkala.</div></div>
        </div>
        <div style="text-align:center;margin-top:2rem;">
            <a href="{{ route('donation.form', ['program' => 'umum']) }}" class="btn-hero-primary">Donasi Sekarang</a>
        </div>
    </div>
</section>

<section class="section" id="testimoni">
    <div class="section-inner">
        <div class="section-header-center anim-fade-down">
            <div class="section-tag">Testimoni</div>
            <h2 class="section-title">Cerita dari Para Donatur</h2>
            <p class="section-desc">Ribuan orang telah merasakan kebahagiaan berbagi melalui PeduliJiwa.</p>
        </div>
        <div class="testi-grid">
            <div class="testi-card"><div class="testi-stars">★★★★★</div><div class="testi-text">"Awalnya ragu, tapi setelah melihat laporan penggunaan dana yang sangat transparan, saya makin yakin dan rutin donasi setiap bulan."</div><div class="testi-author"><div class="testi-avatar" style="background:linear-gradient(135deg,var(--primary),var(--accent))">SR</div><div><div class="testi-name">Sari Rahayu</div><div class="testi-role">Donatur Rutin, Jakarta</div></div></div></div>
            <div class="testi-card"><div class="testi-stars">★★★★★</div><div class="testi-text">"Kakak saya mantan ODGJ yang terlantar. Berkat program reintegrasi sosial PeduliJiwa, sekarang dia sudah bekerja dan hidup mandiri."</div><div class="testi-author"><div class="testi-avatar" style="background:linear-gradient(135deg,#ec4899,#f59e0b)">BW</div><div><div class="testi-name">Budi Wiyanto</div><div class="testi-role">Keluarga Penerima Manfaat, Surabaya</div></div></div></div>
            <div class="testi-card"><div class="testi-stars">★★★★★</div><div class="testi-text">"Platform yang sangat mudah digunakan. Dalam 2 menit donasi sudah selesai. Laporannya lengkap dan bisa dipercaya."</div><div class="testi-author"><div class="testi-avatar" style="background:linear-gradient(135deg,#10b981,#059669)">DP</div><div><div class="testi-name">Dewi Puspita</div><div class="testi-role">Relawan dan Donatur, Bandung</div></div></div></div>
        </div>
    </div>
</section>
@endsection

