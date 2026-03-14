@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<section class="section profile-section" style="padding-top: calc(5.25rem + 72px);">
    <div class="section-inner">
        <div class="section-header-center anim-fade-up" style="margin-bottom:2.5rem;">
            <div class="section-tag">Profil</div>
            <h2 class="section-title">Kenali Yayasan Griya Satu Mimika</h2>
            <p class="section-desc">
                Ringkasan singkat tentang identitas, visi, dan susunan pengurus Yayasan Griya Satu Mimika.
                Detail lengkap tersedia di halaman terpisah agar informasi lebih mudah dibaca.
            </p>
        </div>
        <div class="profile-grid">
            <div class="profile-body anim-fade-right anim-delay-1">
                <p class="profile-intro-text">
                    Griya Satu Mimika merupakan yayasan nirlaba yang berfokus pada layanan rehabilitasi terpadu bagi
                    Orang Dengan Gangguan Jiwa (ODGJ). Kami memadukan pendekatan medis, psikososial, dan
                    pemberdayaan agar penerima manfaat dapat kembali hidup bermartabat di tengah keluarga
                    dan masyarakat.
                </p>
                <div class="pill-list">
                    <span>Rehabilitasi Jiwa Terpadu</span>
                    <span>Akuntabel &amp; Transparan</span>
                    <span>Berorientasi Kemandirian</span>
                </div>
            </div>
            <div class="profile-body anim-fade-left anim-delay-2">
                <div class="profile-subsections">
                    <div>
                        <div class="profile-card-label">
                            <span class="icon">📄</span>
                            <span>Profil Yayasan</span>
                        </div>
                        <h3>Profil Yayasan</h3>
                        <p>
                            Penjelasan lengkap mengenai latar belakang, sejarah singkat,
                            dan identitas resmi Yayasan Griya Satu Mimika.
                        </p>
                        <p style="margin-top:0.85rem;">
                            <a href="{{ route('profil.yayasan') }}" class="btn-prog">
                                Lihat Profil Yayasan →
                            </a>
                        </p>
                    </div>
                    <div>
                        <div class="profile-card-label">
                            <span class="icon">🎯</span>
                            <span>Visi &amp; Misi</span>
                        </div>
                        <h3>Visi &amp; Misi</h3>
                        <p>
                            Arah tujuan dan misi yang menjadi dasar seluruh program
                            dan layanan rehabilitasi yang dijalankan yayasan.
                        </p>
                        <p style="margin-top:0.85rem;">
                            <a href="{{ route('profil.visi-misi') }}" class="btn-prog">
                                Lihat Visi &amp; Misi →
                            </a>
                        </p>
                    </div>
                    <div>
                        <div class="profile-card-label">
                            <span class="icon">🧩</span>
                            <span>Struktur Organisasi</span>
                        </div>
                        <h3>Struktur Organisasi</h3>
                        <p>
                            Susunan pengurus dan tim pelaksana yang memastikan program
                            berjalan profesional, transparan, dan berkelanjutan.
                        </p>
                        <p style="margin-top:0.85rem;">
                            <a href="{{ route('profil.struktur') }}" class="btn-prog">
                                Lihat Struktur Organisasi →
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

