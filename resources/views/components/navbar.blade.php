<nav class="navbar">
    <div class="nav-inner">
        <a href="{{ route('welcome') }}" class="nav-logo">
            <!-- <div class="nav-logo-icon">🧠</div> -->
            Sahabat Jiwa
        </a>
        <div class="nav-links">
            <a href="{{ route('welcome') }}" class="nav-link">Beranda</a>
            <div class="nav-item has-dropdown">
                <button type="button" class="nav-link nav-link-profile" aria-haspopup="true" aria-expanded="false">
                    Profil
                    <svg viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                        <path fill="currentColor" d="M5.25 7.5L10 12.25L14.75 7.5H5.25Z" />
                    </svg>
                </button>
                <div class="nav-dropdown" role="menu" aria-label="Profil">
                    <ul class="nav-dropdown-list">
                        <li><a href="{{ route('profil.yayasan') }}" class="nav-dropdown-link" role="menuitem"><span>Profil Yayasan</span></a></li>
                        <li><a href="{{ route('profil.visi-misi') }}" class="nav-dropdown-link" role="menuitem"><span>Visi &amp; Misi</span></a></li>
                        <li><a href="{{ route('profil.struktur') }}" class="nav-dropdown-link" role="menuitem"><span>Struktur Organisasi</span></a></li>
                    </ul>
                </div>
            </div>
            <a href="{{ route('pages.layanan') }}" class="nav-link">Layanan</a>
            <a href="{{ route('pages.galeri') }}" class="nav-link">Galeri</a>
            <a href="{{ route('transparansi.donasi') }}" class="nav-link">Transparansi Donasi</a>
            <div class="nav-item has-dropdown">
                <button type="button" class="nav-link nav-link-profile" aria-haspopup="true" aria-expanded="false">
                    Pasien
                    <svg viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                        <path fill="currentColor" d="M5.25 7.5L10 12.25L14.75 7.5H5.25Z" />
                    </svg>
                </button>
                <div class="nav-dropdown" role="menu" aria-label="Pasien">
                    <ul class="nav-dropdown-list">
                        @foreach($patients ?? [] as $p)
                        <li><a href="{{ route('public.pasien.show', $p) }}" class="nav-dropdown-link {{ ($currentPatientId ?? '') == $p->id ? 'active' : '' }}" role="menuitem"><span>{{ $p->nama_lengkap }}</span></a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <a href="{{ route('pages.kontak') }}" class="nav-link">Kontak</a>

        </div>

        <div class="nav-actions">
            <button type="button" class="nav-mobile-toggle" id="navMobileToggle" aria-label="Menu">☰</button>
        </div>
        <div class="nav-mobile-menu" id="navMobileMenu">
            <a href="{{ route('welcome') }}" class="mobile-nav-close">Beranda</a>
            <a href="{{ route('profil.yayasan') }}" class="mobile-nav-close">Profil Yayasan</a>
            <a href="{{ route('profil.visi-misi') }}" class="mobile-nav-close">Visi &amp; Misi</a>
            <a href="{{ route('profil.struktur') }}" class="mobile-nav-close">Struktur Organisasi</a>
            <a href="{{ route('pages.layanan') }}" class="mobile-nav-close">Layanan Rehabilitasi</a>
            <a href="{{ route('pages.galeri') }}" class="mobile-nav-close">Galeri</a>
            <a href="{{ route('pages.kontak') }}" class="mobile-nav-close">Kontak</a>
            <a href="{{ route('transparansi.donasi') }}" class="mobile-nav-close">Transparansi Donasi</a>
            <a href="{{ route('public.pasien.index') }}" class="mobile-nav-close">Pasien — Pilih Pasien</a>
            @foreach($patients ?? [] as $p)
                <a href="{{ route('public.pasien.show', $p) }}" class="mobile-nav-close">Pasien: {{ $p->nama_lengkap }}</a>
            @endforeach
         </div>
    </div>
</nav>

