@extends('layouts.app')

@section('title', 'Griya Satu Mimika')

@section('content')
        {{-- Hero: Professional split layout --}}
        <section class="hero hero-pro" id="beranda">
            <div class="hero-inner">
                <div class="hero-content">
                    <span class="hero-label animate-on-scroll" data-animate>Yayasan Griya Satu Mimika</span>
                    <h1 class="hero-title animate-on-scroll animate-on-scroll-delay-1" data-animate>Bantu Mereka Menemukan <span class="highlight">Kembali Dirinya</span></h1>
                    <p class="hero-desc animate-on-scroll animate-on-scroll-delay-2" data-animate>Rehabilitasi terpadu bagi Orang Dengan Gangguan Jiwa (ODGJ). Setiap donasi dan laporan Anda membantu proses pemulihan yang bermartabat.</p>
                    <div class="hero-cta animate-on-scroll animate-on-scroll-delay-3" data-animate>
                        <a href="{{ route('donation.form', ['program' => 'umum']) }}" class="btn-hero-primary">Donasi Sekarang</a>
                        <a href="{{ route('odgj-report.form') }}" class="btn-hero-outline">Laporan ODGJ</a>
                    </div>

                </div>
     
            </div>
        </section>

        {{-- Tentang Kami: Narasi terhubung dan profesional --}}
        <section class="section section-about" id="tentang">
            <div class="section-inner">
                <!-- <div class="section-head section-head-center anim-fade-up">
                    <span class="section-label">Tentang Kami</span>
                    <h2>Griya Satu Mimika — Rumah untuk Pemulihan Jiwa</h2>
                    <p class="section-lead">Griya Satu Mimika merupakan unit layanan rehabilitasi di bawah <strong>Yayasan Peduli Kasih Mimika</strong>, berbasis di Timika, Papua Tengah. Kami hadir untuk memberikan harapan baru bagi Orang Dengan Gangguan Jiwa (ODGJ) yang terlantar—melalui perawatan medis, pendampingan psikologis, dan program reintegrasi sosial yang terpadu.</p>
                </div>
                <p class="about-bridge anim-fade anim-delay-1">Dengan pendekatan yang holistik dan berorientasi pada martabat manusia, kami menjalankan tiga pilar utama:</p> -->
                <div class="about-cards">
                    <div class="about-card anim-fade-up anim-delay-1">
                        <div class="about-card-icon">🏥</div>
                        <h4>Perawatan Medis Terstruktur</h4>
                        <p>Bekerja sama dengan 48 RSJ dan klinik kesehatan jiwa terpercaya. Setiap ODGJ yang kami tangani mendapat akses ke perawatan medis sesuai kebutuhan dan rujukan yang tepat.</p>
                    </div>
                    <div class="about-card anim-fade-up anim-delay-2">
                        <div class="about-card-icon">💬</div>
                        <h4>Pendampingan Psikologis</h4>
                        <p>Tim psikiater dan psikolog klinis mendampingi proses pemulihan dari fase stabilisasi hingga persiapan kembali ke masyarakat. Keluarga juga dilibatkan dalam pendampingan.</p>
                    </div>
                    <div class="about-card anim-fade-up anim-delay-3">
                        <div class="about-card-icon">🏡</div>
                        <h4>Reintegrasi Sosial</h4>
                        <p>Program pelatihan keterampilan dan pendampingan reintegrasi agar penerima manfaat dapat kembali mandiri, diterima di lingkungan, dan memiliki penghidupan yang layak.</p>
                    </div>
                </div>
                <p class="about-close anim-fade anim-delay-2">Setiap langkah kami terdokumentasi dan transparan. Ingin mengenal kami lebih dalam?</p>
                <div class="about-links anim-fade-up anim-delay-3">
                    <a href="{{ route('profil.yayasan') }}" class="link-arrow">Profil Yayasan</a>
                    <a href="{{ route('profil.visi-misi') }}" class="link-arrow">Visi & Misi</a>
                    <a href="{{ route('profil.struktur') }}" class="link-arrow">Struktur Organisasi</a>
                </div>
            </div>
        </section>

        {{-- Layanan: Alur singkat --}}
        <section class="section section-services" id="layanan">
            <div class="section-inner">
                <div class="section-head section-head-center anim-fade-down">
                    <span class="section-label">Layanan Rehabilitasi</span>
                    <h2>Alur yang Terstruktur & Humanis</h2>
                    <p class="section-lead">Dari penjangkauan hingga reintegrasi—setiap tahap terdokumentasi dan transparan.</p>
                </div>
                <div class="services-steps">
                    <div class="step anim-fade-left anim-delay-1"><span class="step-num">1</span><span>Penjangkauan</span></div>
                    <div class="step-arrow anim-fade anim-delay-1"></div>
                    <div class="step anim-fade-left anim-delay-2"><span class="step-num">2</span><span>Asesmen</span></div>
                    <div class="step-arrow anim-fade anim-delay-2"></div>
                    <div class="step anim-fade-left anim-delay-3"><span class="step-num">3</span><span>Perawatan</span></div>
                    <div class="step-arrow anim-fade anim-delay-3"></div>
                    <div class="step anim-fade-left anim-delay-4"><span class="step-num">4</span><span>Reintegrasi</span></div>
                </div>
                <p class="services-footer"><a href="{{ route('pages.layanan') }}">Lihat detail alur layanan →</a></p>
            </div>
        </section>

        {{-- Cara Donasi --}}
        <!-- <section class="section section-donate" id="cara-donasi">
            <div class="section-inner">
                <div class="section-head section-head-center anim-scale">
                    <span class="section-label">Cara Berdonasi</span>
                    <h2>Mudah, Aman, Transparan</h2>
                </div>
                <div class="donate-steps">
                    <div class="donate-step anim-fade-up anim-delay-1"><span>1</span><p>Pilih program</p></div>
                    <div class="donate-step anim-fade-up anim-delay-2"><span>2</span><p>Tentukan nominal</p></div>
                    <div class="donate-step anim-fade-up anim-delay-3"><span>3</span><p>Bayar via QRIS</p></div>
                    <div class="donate-step anim-fade-up anim-delay-4"><span>4</span><p>Terima laporan</p></div>
                </div>
                <div class="donate-cta-wrap">
                    <a href="{{ route('donation.form', ['program' => 'umum']) }}" class="btn-donate-main">Donasi Sekarang</a>
                </div>
            </div>
        </section> -->

        {{-- Testimoni --}}
        <!-- <section class="section section-testi">
            <div class="section-inner">
                <div class="section-head section-head-center anim-fade-down">
                    <span class="section-label">Testimoni</span>
                    <h2>Cerita dari Donatur & Penerima Manfaat</h2>
                </div>
                <div class="testi-cards">
                    <div class="testi-card anim-fade-right anim-delay-1">
                        <div class="testi-stars">★★★★★</div>
                        <p>"Laporan penggunaan dana sangat transparan. Saya rutin donasi setiap bulan."</p>
                        <div class="testi-author"><strong>Sari R.</strong> Donatur, Jakarta</div>
                    </div>
                    <div class="testi-card anim-fade-up anim-delay-2">
                        <div class="testi-stars">★★★★★</div>
                        <p>"Kakak saya mantan ODGJ terlantar. Berkat program ini, sekarang sudah bekerja mandiri."</p>
                        <div class="testi-author"><strong>Budi W.</strong> Keluarga Penerima Manfaat</div>
                    </div>
                    <div class="testi-card anim-fade-left anim-delay-3">
                        <div class="testi-stars">★★★★★</div>
                        <p>"Platform mudah digunakan. Dalam 2 menit donasi selesai, laporannya lengkap."</p>
                        <div class="testi-author"><strong>Dewi P.</strong> Relawan, Bandung</div>
                    </div>
                </div>
            </div>
        </section> -->

        {{-- CTA Final --}}
        <section class="cta-section">
            <div class="section-inner anim-scale">
                <h2>Satu Langkah Kecilmu, Perubahan Besar Baginya</h2>
                <p>Bergabung dengan 15.000+ donatur. Mulai dari Rp 10.000.</p>
                <div class="cta-btns">
                    <a href="{{ route('donation.form', ['program' => 'umum']) }}" class="btn-cta-primary">Donasi Sekarang</a>
                    <a href="{{ route('odgj-report.form') }}" class="btn-cta-secondary">Laporan ODGJ</a>
                </div>
            </div>
        </section>

        {{-- Kontak --}}
        <!-- <section class="section section-contact" id="kontak">
            <div class="section-inner">
                <div class="section-head section-head-center anim-fade-up">
                    <span class="section-label">Kontak</span>
                    <h2>Hubungi Kami</h2>
                </div>
                <div class="contact-row anim-fade anim-delay-1">
                    <a href="tel:082198595245" class="contact-item">📞 0821-9859-5245</a>
                    <a href="https://wa.me/6282198595245" class="contact-item" target="_blank" rel="noopener">WhatsApp</a>
                    <a href="mailto:info@griyasatumimika.web.id" class="contact-item">📧 info@griyasatumimika.web.id</a>
                    <span class="contact-item">📍 Timika, Kab. Mimika, Papua Tengah</span>
                </div>
            </div>
        </section> -->
@endsection
