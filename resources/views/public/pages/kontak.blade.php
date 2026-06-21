@extends('layouts.app')

@section('title', 'Kontak')

@push('styles')
<style>
    .page-hero.page-hero-contact {
        background: transparent !important;
        color: #ffffff;
    }
    .page-hero.page-hero-contact .section-header-center { max-width: 720px; margin: 0 auto; }
    .page-hero.page-hero-contact .section-tag {
        font-size: 0.8rem;
        letter-spacing: 0.12em;
        background: rgba(255,255,255,0.12);
        border-radius: 999px;
        padding-inline: 1rem;
        border: 1px solid rgba(255,255,255,0.3);
        color: #e0f2ff;
    }
    .page-hero.page-hero-contact .section-title {
        font-size: 2rem;
        line-height: 1.3;
        margin-bottom: 0.6rem;
        color: #ffffff;
    }
    .page-hero.page-hero-contact .section-desc {
        font-size: 0.95rem;
        line-height: 1.75;
        color: rgba(255,255,255,0.9);
    }
    .section-contact-page {
        background: transparent !important;
    }
    .section-contact-page .contact-layout {
        display: grid;
        grid-template-columns: minmax(0, 0.95fr) minmax(0, 1.05fr);
        gap: 2rem;
        margin-top: -2rem;
        padding: 0;
        align-items: start;
    }
    .section-contact-page .contact-info-column,
    .section-contact-page .contact-form-column {
        background: rgba(255,255,255,0.08) !important;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 16px;
        padding: 2rem 1.75rem;
        color: #ffffff;
    }
    .section-contact-page .contact-heading {
        color: #ffffff;
        font-size: 1.15rem;
        margin-bottom: 0.5rem;
    }
    .section-contact-page .contact-desc {
        color: rgba(255,255,255,0.85);
        font-size: 0.9rem;
        line-height: 1.6;
        margin-bottom: 0;
    }
    .section-contact-page .contact-info-header,
    .section-contact-page .contact-form-header {
        margin-bottom: 1.5rem;
    }
    .section-contact-page .contact-card-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    .section-contact-page .contact-card {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 1rem 1.1rem;
        border-radius: 12px;
        background: rgba(255,255,255,0.08) !important;
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,0.2);
    }
    .section-contact-page .contact-card-body h3 {
        color: #ffffff;
        font-size: 0.95rem;
        font-weight: 700;
        margin-bottom: 0.35rem;
    }
    .section-contact-page .contact-card-body p,
    .section-contact-page .contact-note {
        color: rgba(255,255,255,0.85);
        font-size: 0.85rem;
        line-height: 1.55;
    }
    .section-contact-page .contact-card-body a { color: #93c5fd; }
    .section-contact-page .contact-card-body a:hover { color: #bfdbfe; }
    .section-contact-page .contact-location-highlight {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 1rem 1.1rem;
        border-radius: 12px;
        background: rgba(255,255,255,0.08) !important;
        border: 1px solid rgba(255,255,255,0.2);
    }
    .section-contact-page .contact-pill-label {
        display: inline-block;
        background: rgba(255,255,255,0.15);
        color: #ffffff;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.65rem;
        border-radius: 999px;
        margin-bottom: 0.5rem;
    }
    .section-contact-page .contact-form {
        display: flex;
        flex-direction: column;
        gap: 0.9rem;
    }
    .section-contact-page .contact-form .form-row label {
        display: block;
        color: #ffffff;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 0.35rem;
    }
    .section-contact-page .contact-form .form-row input,
    .section-contact-page .contact-form .form-row textarea {
        width: 100%;
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.25);
        color: #ffffff;
        border-radius: 10px;
        padding: 0.65rem 0.85rem;
        font: inherit;
    }
    .section-contact-page .contact-form .form-row input::placeholder,
    .section-contact-page .contact-form .form-row textarea::placeholder {
        color: rgba(255,255,255,0.6);
    }
    .section-contact-page .contact-form .form-row input:focus,
    .section-contact-page .contact-form .form-row textarea:focus {
        outline: none;
        background: rgba(255,255,255,0.15);
        border-color: rgba(255,255,255,0.4);
        box-shadow: 0 0 0 2px rgba(255,255,255,0.1);
    }
    .section-contact-page .form-row-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.9rem;
    }
    .section-contact-page .form-error {
        color: #fecaca;
        font-size: 0.8rem;
        margin-top: 0.25rem;
    }
    .section-contact-page .contact-alert {
        padding: 0.85rem 1rem;
        border-radius: 10px;
        font-size: 0.88rem;
        line-height: 1.5;
        margin-bottom: 1rem;
    }
    .section-contact-page .contact-alert-success {
        background: rgba(34, 197, 94, 0.2);
        border: 1px solid rgba(34, 197, 94, 0.45);
        color: #dcfce7;
    }
    .section-contact-page .contact-alert-error {
        background: rgba(239, 68, 68, 0.2);
        border: 1px solid rgba(239, 68, 68, 0.45);
        color: #fee2e2;
    }
    .section-contact-page .contact-form-note {
        color: rgba(255,255,255,0.75);
        font-size: 0.8rem;
        margin-top: 0.25rem;
    }
    .section-contact-page .btn-primary.btn-full {
        width: 100%;
        background: rgba(255,255,255,0.08);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1.5px solid rgba(255,255,255,0.65);
        color: #fff;
        padding: 0.85rem 1rem;
        border-radius: 10px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: none;
    }
    .section-contact-page .btn-primary.btn-full:hover {
        background: rgba(255,255,255,0.16);
        border-color: rgba(255,255,255,0.9);
    }
    @media (max-width: 900px) {
        .section-contact-page .contact-layout,
        .section-contact-page .form-row-grid,
        .section-contact-page .contact-card-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
    <section class="section page-hero page-hero-contact">
        <div class="section-inner">
            <div class="section-header-center anim-fade-down">
                <div class="section-tag">Kontak</div>
                <h2 class="section-title">Hubungi Griya Satu Mimika</h2>
                <p class="section-desc">
                    Satu pesan Anda bisa menjadi awal proses pemulihan yang lebih baik.
                    Pilih cara tersimpel untuk terhubung dengan tim kami.
                </p>
            </div>
        </div>
    </section>

    <section class="section section-contact-page">
        <div class="section-inner">
            <div class="contact-layout">
                <div class="contact-info-column anim-fade-right">
                    <header class="contact-info-header">
                        <h2 class="contact-heading">Informasi Kontak</h2>
                        <p class="contact-desc">
                            Silakan hubungi kami pada jam operasional berikut.
                            Untuk keadaan darurat medis, segera hubungi fasilitas kesehatan terdekat di wilayah Anda.
                        </p>
                    </header>

                    <div class="contact-card-grid">
                        <div class="contact-card">
                            <div class="contact-card-icon">📍</div>
                            <div class="contact-card-body">
                                <h3>Alamat</h3>
                                <p>Jl. Rehabilitasi Jiwa No. 12<br>Timika, Kabupaten Mimika<br>Papua Tengah</p>
                            </div>
                        </div>
                        <div class="contact-card">
                            <div class="contact-card-icon">📞</div>
                            <div class="contact-card-body">
                                <h3>Telepon</h3>
                                <p>
                                    <a href="tel:082198595245">+62 821-9859-5245</a><br>
                                    <span class="contact-note">Telepon dan WhatsApp layanan informasi</span>
                                </p>
                            </div>
                        </div>
                        <div class="contact-card">
                            <div class="contact-card-icon">✉️</div>
                            <div class="contact-card-body">
                                <h3>Email</h3>
                                <p>
                                    <a href="mailto:info@griyasatumimika.web.id">info@griyasatumimika.web.id</a><br>
                                    <span class="contact-note">Balasan maksimal 1×24 jam kerja</span>
                                </p>
                            </div>
                        </div>
                        <div class="contact-card">
                            <div class="contact-card-icon">🕒</div>
                            <div class="contact-card-body">
                                <h3>Jam Layanan</h3>
                                <p>
                                    Senin – Kamis: 08.00 – 15.00 WIT<br>
                                    Jumat: 08.00 – 11.30 WIT<br>
                                    Sabtu – Minggu: Darurat tertentu
                                </p>
                            </div>
                        </div>
                    </div>

                    <aside class="contact-location-highlight">
                        <div class="contact-card-icon">🗺️</div>
                        <div class="contact-card-body">
                            <h3>Lokasi Kami</h3>
                            <p>Griya Satu Mimika berada di kawasan layanan sosial Kabupaten Mimika, mudah dijangkau dari pusat kota Timika.</p>
                        </div>
                    </aside>
                </div>

                <div class="contact-form-column anim-fade-left anim-delay-2">
                    <div class="contact-form-header">
                        <span class="contact-pill-label">Formulir Online</span>
                        <h2 class="contact-heading">Kirim Pesan</h2>
                        <p class="contact-desc">Isi formulir singkat di bawah ini. Tim kami akan merespons secepat mungkin melalui email atau WhatsApp yang Anda cantumkan.</p>
                    </div>

                    @if(session('success'))
                        <div class="contact-alert contact-alert-success">{{ session('success') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="contact-alert contact-alert-error">
                            Periksa kembali data yang Anda isi.
                        </div>
                    @endif

                    <form class="contact-form" method="post" action="{{ route('pages.kontak.store') }}" autocomplete="on">
                        @csrf
                        <div class="form-row-grid">
                            <div class="form-row">
                                <label for="nama">Nama Lengkap</label>
                                <input id="nama" name="nama" type="text" value="{{ old('nama') }}" placeholder="Tulis nama Anda" autocomplete="name" required>
                                @error('nama')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-row">
                                <label for="email">Email</label>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="email@contoh.com" autocomplete="email" required>
                                @error('email')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="form-row-grid">
                            <div class="form-row">
                                <label for="subjek">Subjek</label>
                                <input id="subjek" name="subjek" type="text" value="{{ old('subjek') }}" placeholder="Contoh: Konsultasi layanan rehabilitasi" autocomplete="off">
                                @error('subjek')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-row">
                                <label for="telepon">No. WhatsApp (opsional)</label>
                                <input id="telepon" name="telepon" type="tel" value="{{ old('telepon') }}" placeholder="Contoh: 0821xxxxxxx" autocomplete="tel">
                                @error('telepon')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <label for="pesan">Pesan</label>
                            <textarea id="pesan" name="pesan" rows="5" placeholder="Tulis pesan atau pertanyaan Anda di sini" required>{{ old('pesan') }}</textarea>
                            @error('pesan')<div class="form-error">{{ $message }}</div>@enderror
                        </div>

                        <button type="submit" class="btn-primary btn-full">Kirim Pesan</button>
                        <p class="contact-form-note">Dengan mengirim pesan, Anda menyetujui bahwa kami dapat menghubungi Anda kembali terkait permintaan informasi ini.</p>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
