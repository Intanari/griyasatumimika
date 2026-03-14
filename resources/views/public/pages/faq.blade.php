@extends('layouts.app')

@section('title', 'FAQ')

@section('content')
<section class="section faq-section" style="padding-top: calc(5.25rem + 72px);">
    <div class="section-inner">
        <div class="section-header-center anim-fade-down" style="margin-bottom:2.5rem;">
            <div class="section-tag">FAQ</div>
            <h2 class="section-title">Pertanyaan yang Sering Diajukan</h2>
            <p class="section-desc">Informasi singkat untuk membantu Anda memahami siapa yang dapat dibantu, bagaimana cara mengakses layanan, dan bagaimana cara berkontribusi.</p>
        </div>
        <div class="faq-grid">
            <div class="faq-intro anim-fade-right">
                <p>
                    Jika Anda memiliki pertanyaan lain di luar daftar berikut, silakan hubungi tim kami melalui kanal kontak resmi.
                    Kami berusaha menjawab setiap pertanyaan dengan empati dan penjelasan yang mudah dipahami, khususnya bagi keluarga yang baru pertama kali berhadapan dengan kondisi ODGJ.
                </p>
                <p style="margin-top:1rem;">
                    Mohon diingat bahwa informasi di bawah ini bersifat umum. Keputusan layanan selalu mempertimbangkan kondisi individual, rekomendasi tenaga profesional, dan ketersediaan fasilitas di masing-masing wilayah.
                </p>
            </div>
            <div class="faq-list anim-fade-left anim-delay-2" aria-label="Daftar pertanyaan umum">
                @foreach([
                    ['Siapa saja yang dapat dibantu oleh PeduliJiwa?', 'PeduliJiwa memprioritaskan ODGJ yang terlantar, berisiko mengganggu keselamatan diri sendiri maupun orang lain, atau berasal dari keluarga dengan keterbatasan ekonomi. Selama memenuhi kriteria keselamatan dan ketersediaan layanan, kami juga mendampingi keluarga yang membutuhkan informasi terkait penanganan ODGJ di rumah.'],
                    ['Bagaimana cara mengajukan bantuan untuk ODGJ?', 'Anda dapat mengisi formulir laporan ODGJ melalui menu Laporan ODGJ di website ini. Lengkapi data dasar, lokasi, dan kondisi singkat yang Anda amati. Setelah laporan dikirim, tim akan melakukan verifikasi melalui telepon atau pesan singkat sebelum menentukan langkah penjangkauan berikutnya.'],
                    ['Apakah PeduliJiwa menerima relawan?', 'Ya. Kami membuka kesempatan bagi relawan dengan berbagai latar belakang, mulai dari kesehatan, sosial, hingga komunikasi. Calon relawan akan mengikuti proses seleksi dan pembekalan agar memahami prinsip dasar pendampingan ODGJ dan menjaga kerahasiaan data penerima manfaat.'],
                    ['Bagaimana cara berdonasi dan apakah aman?', 'Donasi dapat dilakukan melalui menu Donasi dengan memilih program yang ingin Anda dukung, mengisi nominal, dan melakukan pembayaran melalui QRIS atau metode lain yang tersedia. Sistem pembayaran terintegrasi dengan mitra pembayaran resmi dan setiap transaksi akan mendapatkan bukti donasi serta laporan penyaluran dana.'],
                    ['Bagaimana cara menghubungi admin atau tim PeduliJiwa?', 'Anda dapat menghubungi kami melalui alamat email, nomor telepon, atau media sosial resmi yang tercantum di bagian footer. Untuk pertanyaan terkait laporan atau donasi tertentu, mohon sertakan nomor referensi agar tim kami dapat menelusuri data dengan lebih cepat dan akurat.'],
                ] as $faq)
                <div class="faq-item">
                    <button class="faq-header" type="button">
                        <span class="faq-question">{{ $faq[0] }}</span>
                        <span class="faq-toggle" aria-hidden="true">+</span>
                    </button>
                    <div class="faq-body">
                        <div class="faq-body-inner">{{ $faq[1] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection

