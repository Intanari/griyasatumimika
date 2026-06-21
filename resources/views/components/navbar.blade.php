<nav class="navbar" id="siteNavbar">
    <div class="nav-inner">
        <a href="{{ route('welcome') }}" class="nav-logo">
            <x-yayasan-logo variant="nav" />
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
                    <div class="nav-dropdown-panel">
                        <div class="nav-dropdown-blur" aria-hidden="true"></div>
                        <ul class="nav-dropdown-list">
                        <li><a href="{{ route('profil.yayasan') }}" class="nav-dropdown-link" role="menuitem"><span>Profil Yayasan</span></a></li>
                        <li><a href="{{ route('profil.visi-misi') }}" class="nav-dropdown-link" role="menuitem"><span>Visi &amp; Misi</span></a></li>
                        <li><a href="{{ route('profil.struktur') }}" class="nav-dropdown-link" role="menuitem"><span>Struktur Organisasi</span></a></li>
                        </ul>
                    </div>
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
                    <div class="nav-dropdown-panel">
                        <div class="nav-dropdown-blur" aria-hidden="true"></div>
                        <ul class="nav-dropdown-list">
                        <li><a href="{{ route('public.pasien.index') }}" class="nav-dropdown-link {{ ($isPasienIndexActive ?? false) ? 'active' : '' }}" role="menuitem"><span>Semua Pasien</span></a></li>
                        @foreach($patients ?? [] as $p)
                        <li><a href="{{ route('public.pasien.show', $p) }}" class="nav-dropdown-link {{ ($currentPatientId ?? '') == $p->id ? 'active' : '' }}" role="menuitem"><span>{{ $p->nama_lengkap }}</span></a></li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <a href="{{ route('pages.kontak') }}" class="nav-link">Kontak</a>
        </div>

        <div class="nav-actions">
            <a href="{{ route('login') }}" class="btn-nav-admin">Login Admin</a>
            <button
                type="button"
                class="nav-mobile-toggle"
                id="navMobileToggle"
                aria-label="Buka menu navigasi"
                aria-expanded="false"
                aria-controls="navDrawer"
            >
                <span class="nav-toggle-icon" aria-hidden="true">
                    <span class="nav-toggle-bar"></span>
                    <span class="nav-toggle-bar"></span>
                    <span class="nav-toggle-bar"></span>
                </span>
                <span class="nav-toggle-label">Menu</span>
            </button>
        </div>
    </div>
</nav>

<div class="nav-drawer-overlay" id="navDrawerOverlay" aria-hidden="true" tabindex="-1"></div>

<aside class="nav-drawer" id="navDrawer" aria-hidden="true" aria-label="Menu navigasi">
    <div class="nav-drawer-header">
        <div class="nav-drawer-brand">
            <x-yayasan-logo variant="nav" class="nav-drawer-logo" />
        </div>
        <button type="button" class="nav-drawer-close" id="navDrawerClose" aria-label="Tutup menu">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
                <path d="M18 6L6 18M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <nav class="nav-drawer-body">
        <a href="{{ route('welcome') }}" class="nav-drawer-link mobile-nav-close">
            <span class="nav-drawer-link-icon" aria-hidden="true">🏡</span>
            <span>Beranda</span>
        </a>

        <details class="nav-drawer-accordion">
            <summary class="nav-drawer-accordion-trigger">
                <span class="nav-drawer-link-icon" aria-hidden="true">📋</span>
                <span>Profil</span>
                <svg class="nav-drawer-chevron" viewBox="0 0 20 20" aria-hidden="true"><path fill="currentColor" d="M5.25 7.5L10 12.25L14.75 7.5H5.25Z"/></svg>
            </summary>
            <div class="nav-drawer-sub">
                <a href="{{ route('profil.yayasan') }}" class="nav-drawer-sublink mobile-nav-close">Profil Yayasan</a>
                <a href="{{ route('profil.visi-misi') }}" class="nav-drawer-sublink mobile-nav-close">Visi &amp; Misi</a>
                <a href="{{ route('profil.struktur') }}" class="nav-drawer-sublink mobile-nav-close">Struktur Organisasi</a>
            </div>
        </details>

        <a href="{{ route('pages.layanan') }}" class="nav-drawer-link mobile-nav-close">
            <span class="nav-drawer-link-icon" aria-hidden="true">💙</span>
            <span>Layanan Rehabilitasi</span>
        </a>
        <a href="{{ route('pages.galeri') }}" class="nav-drawer-link mobile-nav-close">
            <span class="nav-drawer-link-icon" aria-hidden="true">🖼️</span>
            <span>Galeri</span>
        </a>
        <a href="{{ route('transparansi.donasi') }}" class="nav-drawer-link mobile-nav-close">
            <span class="nav-drawer-link-icon" aria-hidden="true">📊</span>
            <span>Transparansi Donasi</span>
        </a>

        <details class="nav-drawer-accordion">
            <summary class="nav-drawer-accordion-trigger">
                <span class="nav-drawer-link-icon" aria-hidden="true">🧑‍⚕️</span>
                <span>Pasien</span>
                <svg class="nav-drawer-chevron" viewBox="0 0 20 20" aria-hidden="true"><path fill="currentColor" d="M5.25 7.5L10 12.25L14.75 7.5H5.25Z"/></svg>
            </summary>
            <div class="nav-drawer-sub">
                <a href="{{ route('public.pasien.index') }}" class="nav-drawer-sublink mobile-nav-close {{ ($isPasienIndexActive ?? false) ? 'is-active' : '' }}">Semua Pasien</a>
                @foreach($patients ?? [] as $p)
                    <a href="{{ route('public.pasien.show', $p) }}" class="nav-drawer-sublink mobile-nav-close">{{ $p->nama_lengkap }}</a>
                @endforeach
            </div>
        </details>

        <a href="{{ route('pages.kontak') }}" class="nav-drawer-link mobile-nav-close">
            <span class="nav-drawer-link-icon" aria-hidden="true">📞</span>
            <span>Kontak</span>
        </a>
    </nav>

    <div class="nav-drawer-footer">
        <a href="{{ route('login') }}" class="nav-drawer-cta mobile-nav-close">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3"/>
            </svg>
            Login Admin
        </a>
    </div>
</aside>
