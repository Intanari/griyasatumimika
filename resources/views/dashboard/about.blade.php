@extends('layouts.dashboard')

@section('title', 'Tentang Sistem')
@section('topbar-title', 'Tentang Sistem')

@section('content')
<a href="{{ route('dashboard') }}" class="page-back-link">Kembali</a>

<div class="card" style="max-width: 860px; margin-bottom: 1.5rem;">
    <div class="card-title">
        <span>Tentang Sistem PeduliJiwa</span>
    </div>

    <div class="about-grid">
        <section class="about-section">
            <h2>Tujuan Sistem</h2>
            <p>
                Aplikasi dashboard ini dirancang untuk membantu pengelolaan layanan rehabilitasi ODGJ di Griya Satu Mimika:
                mulai dari pencatatan pasien, jadwal, aktivitas harian, hingga donasi dan stok barang pendukung layanan.
            </p>
        </section>

        <section class="about-section">
            <h2>Peran Pengguna</h2>
            <ul>
                <li><strong>Super Admin</strong>: mengelola seluruh data sistem, termasuk akun Petugas Admin &amp; Petugas User.</li>
                <li><strong>Petugas Admin</strong>: mengelola data operasional (pasien, jadwal, stok) dan akun Petugas User.</li>
                <li><strong>Petugas User</strong>: mengisi data harian pasien, aktivitas, dan jadwal sesuai tugas masing‑masing.</li>
            </ul>
        </section>

        <section class="about-section">
            <h2>Fitur Utama</h2>
            <ul class="about-feature-list">
                <li><strong>Dashboard Ringkasan</strong>: statistik donasi, laporan ODGJ, pasien, dan stok barang.</li>
                <li><strong>Manajemen Pasien</strong>: data pasien, riwayat pemeriksaan, dan aktivitas harian.</li>
                <li><strong>Jadwal</strong>: jadwal pasien, jadwal rehabilitasi, dan jadwal petugas.</li>
                <li><strong>Donasi</strong>: pengelolaan donasi masuk &amp; pengeluaran donasi.</li>
                <li><strong>Stok Barang</strong>: pencatatan persediaan &amp; pengeluaran stok barang.</li>
                <li><strong>Manajemen Akun</strong>: pengaturan akun login petugas sesuai peran.</li>
            </ul>
        </section>

        <section class="about-section">
            <h2>Alur Singkat Penggunaan</h2>
            <ol>
                <li>Super Admin / Petugas Admin membuat akun Petugas User di menu <strong>Manajemen Akun</strong>.</li>
                <li>Petugas menginput data pasien, jadwal, dan aktivitas harian sesuai kewenangan.</li>
                <li>Admin memantau laporan ODGJ, donasi, dan stok barang dari halaman dashboard.</li>
                <li>Data dapat diekspor (PDF/Excel) sesuai kebutuhan pelaporan.</li>
            </ol>
        </section>
    </div>
</div>

<style>
.about-grid {
    display: grid;
    grid-template-columns: minmax(0, 1.1fr) minmax(0, 1.1fr);
    gap: 1.25rem 1.75rem;
}
@media (max-width: 900px) {
    .about-grid { grid-template-columns: minmax(0, 1fr); }
}
.about-section h2 {
    font-size: 0.95rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    letter-spacing: -0.01em;
}
.about-section p {
    font-size: 0.88rem;
    line-height: 1.6;
    color: var(--text-muted);
}
.about-section ul,
.about-section ol {
    margin: 0;
    padding-left: 1.1rem;
    font-size: 0.88rem;
    line-height: 1.6;
    color: var(--text-muted);
}
.about-section li + li {
    margin-top: 0.2rem;
}
.about-feature-list {
    list-style: disc;
}
</style>
@endsection

