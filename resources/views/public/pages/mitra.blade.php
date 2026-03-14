@extends('layouts.app')

@section('title', 'Mitra Layanan')

@push('styles')
<style>
    .partners-section .section-header-center { text-align: center; }
    .partners-section .section-tag {
        font-size: 0.8rem;
        letter-spacing: 0.12em;
        background: rgba(255,255,255,0.12);
        border-radius: 999px;
        padding-inline: 1rem;
        border: 1px solid rgba(255,255,255,0.3);
        color: #e0f2ff;
    }
    .partners-section .section-title {
        font-size: 2rem;
        line-height: 1.3;
        margin-bottom: 0.6rem;
        color: #ffffff;
    }
    .partners-section .section-desc {
        font-size: 0.95rem;
        line-height: 1.75;
        color: rgba(255,255,255,0.9);
    }
</style>
@endpush

@section('content')
<section class="section partners-section" style="padding-top: calc(5.25rem + 72px);">
    <div class="section-inner">
        <div class="section-header-center anim-fade-down" style="max-width:720px;margin:0 auto 2rem;">
            <div class="section-tag">Mitra Layanan</div>
            <h2 class="section-title">Berjejaring dengan Banyak Pihak</h2>
            <p class="section-desc">
                Keberhasilan program rehabilitasi tidak mungkin dicapai sendiri. PeduliJiwa bekerja sama dengan rumah sakit jiwa, pemerintah daerah, lembaga keagamaan, komunitas, dan pihak swasta yang memiliki komitmen yang sama terhadap kesehatan jiwa.
            </p>
        </div>
        <div class="partners-note anim-fade-up">
                Daftar logo di bawah ini merupakan ilustrasi jenis mitra yang selama ini mendukung program. Logo aktual akan ditampilkan sesuai dengan perjanjian kerja sama dan kebijakan publikasi masing-masing lembaga.
            </div>
        </div>
        <div class="partners-grid anim-fade anim-delay-1" aria-label="Logo mitra layanan (placeholder)">
            <div class="partner-card">RS Jiwa Mitra Harapan<div class="partner-tag">Kegiatan Lapangan</div></div>
            <div class="partner-card">Dinas Sosial Kota Bersama<div class="partner-tag">Pendampingan Rehabilitasi</div></div>
            <div class="partner-card">Forum Kesehatan Jiwa Nusantara<div class="partner-tag">Advokasi dan Edukasi</div></div>
            <div class="partner-card">Komunitas Relawan Peduli Jiwa<div class="partner-tag">Relawan dan Penjangkauan</div></div>
            <div class="partner-card">Lembaga Filantropi Sahabat Jiwa<div class="partner-tag">Pendanaan Program</div></div>
            <div class="partner-card">RS Umum Mitra Sehat<div class="partner-tag">Rujukan Medis</div></div>
            <div class="partner-card">Pemerintah Kabupaten Berdaya<div class="partner-tag">Program Bersama</div></div>
            <div class="partner-card">Jaringan Psikolog Peduli<div class="partner-tag">Konseling dan Terapi</div></div>
            <div class="partner-card">Lembaga Pendidikan Kesehatan Jiwa<div class="partner-tag">Riset dan Pelatihan</div></div>
            <div class="partner-card">Komunitas Keluarga Sahabat Jiwa<div class="partner-tag">Dukungan Keluarga</div></div>
        </div>
    </div>
</section>
@endsection

