{{-- Styles dinamis dari Pengaturan Web (dashboard admin) --}}
@php
    $ws = $webSettings ?? [];
    $fallback = '#ffffff';
    $h1 = !empty($ws['h1_color']) ? $ws['h1_color'] : $fallback;
    $h2 = !empty($ws['h2_color']) ? $ws['h2_color'] : $fallback;
    $h3 = !empty($ws['h3_color']) ? $ws['h3_color'] : $fallback;
    $h4 = !empty($ws['h4_color']) ? $ws['h4_color'] : $fallback;
    $h5 = !empty($ws['h5_color']) ? $ws['h5_color'] : $fallback;
    $h6 = !empty($ws['h6_color']) ? $ws['h6_color'] : $fallback;
    $pColor = !empty($ws['p_color']) ? $ws['p_color'] : $fallback;
    $pColors = $ws['p_colors'] ?? [];
    $spanColor = !empty($ws['span_color']) ? $ws['span_color'] : $fallback;
    $spanColors = $ws['span_colors'] ?? [];
    $divColor = !empty($ws['div_color']) ? $ws['div_color'] : $fallback;
    $divColors = $ws['div_colors'] ?? [];
    $aColor = !empty($ws['a_color']) ? $ws['a_color'] : $fallback;
    $aColors = $ws['a_colors'] ?? [];
    $buttonColor = !empty($ws['button_color']) ? $ws['button_color'] : '#2563eb';
    $buttonTextColor = !empty($ws['button_text_color']) ? $ws['button_text_color'] : $fallback;
    $customClassColors = $ws['custom_class_colors'] ?? [];
    $bgType = $ws['background_type'] ?? 'gambar';
    $bgColorMode = $ws['background_color_mode'] ?? 'global';
    $bgColors = $ws['background_colors'] ?? [];
    $bgImageMode = $ws['background_image_mode'] ?? 'global';
    $bgImages = $ws['background_images'] ?? [];
    $routeToSlug = [
        'welcome' => 'home',
        'donation.form' => 'donasi',
        'donation.payment' => 'donasi-bayar',
        'donation.success' => 'donasi-sukses',
        'odgj-report.form' => 'laporan-odgj',
        'odgj-report.success' => 'laporan-odgj-sukses',
        'profil.struktur' => 'profil-struktur',
        'profil.visi-misi' => 'profil-visi-misi',
        'profil.yayasan' => 'profil-yayasan',
        'pages.galeri' => 'galeri',
        'pages.kontak' => 'kontak',
        'pages.layanan' => 'layanan',
        'transparansi.donasi' => 'transparansi-donasi',
        'public.pasien.index' => 'pasien',
        'public.pasien.show' => 'pasien',
    ];
    $currentRoute = \Illuminate\Support\Facades\Route::currentRouteName();
    $currentSlug = $routeToSlug[$currentRoute] ?? null;
    if ($bgType === 'warna' && $bgColorMode === 'per_page' && $currentSlug && !empty($bgColors[$currentSlug])) {
        $bgColor = $bgColors[$currentSlug];
    } else {
        $bgColor = !empty($ws['background_color']) ? $ws['background_color'] : '#0f172a';
    }
    $pageImagePath = ($bgImageMode === 'per_page' && $currentSlug && !empty($bgImages[$currentSlug])) ? $bgImages[$currentSlug] : null;
    if ($pageImagePath) {
        $bgImage = asset('storage/' . $pageImagePath);
    } elseif (!empty($ws['background_image'])) {
        $bgImage = asset('storage/' . $ws['background_image']);
    } else {
        $bgImage = asset('images/landing-bg.png');
    }
    $overlayOpacity = $ws['background_overlay_opacity'] ?? '0.4';
    $overlayRgba = 'rgba(15, 23, 42, ' . (float) $overlayOpacity . ')';
@endphp
<style id="public-web-settings-dynamic">
    /* Pengaturan Web TIDAK berlaku untuk navbar - hanya konten utama .public-main */
    /* Warna heading H1-H6 */
    body.public-layout .public-main h1, body.public-layout .public-main .public-page h1 { color: {{ $h1 }} !important; }
    body.public-layout .public-main h2, body.public-layout .public-main .public-page h2 { color: {{ $h2 }} !important; }
    body.public-layout .public-main h3, body.public-layout .public-main .public-page h3 { color: {{ $h3 }} !important; }
    body.public-layout .public-main h4, body.public-layout .public-main .public-page h4 { color: {{ $h4 }} !important; }
    body.public-layout .public-main h5, body.public-layout .public-main .public-page h5 { color: {{ $h5 }} !important; }
    body.public-layout .public-main h6, body.public-layout .public-main .public-page h6 { color: {{ $h6 }} !important; }
    /* Warna teks paragraf (p) tanpa class */
    body.public-layout .public-main p:not([class]),
    body.public-layout .public-main .public-page p:not([class]) { color: {{ $pColor }} !important; }
    @foreach($pColors as $pc)
    @if(!empty($pc['class']))
    @php $pClr = $pc['color'] ?? '#ffffff'; @endphp
    body.public-layout .public-main p.{{ $pc['class'] }},
    body.public-layout .public-main .public-page p.{{ $pc['class'] }} { color: {{ $pClr }} !important; }
    @endif
    @endforeach
    /* Warna span tanpa class */
    body.public-layout .public-main span:not([class]),
    body.public-layout .public-main .public-page span:not([class]) {
        color: {{ $spanColor }} !important;
        -webkit-text-fill-color: {{ $spanColor }} !important;
    }
    @foreach($spanColors as $sc)
    @if(!empty($sc['class']))
    @php $spanClr = $sc['color'] ?? '#ffffff'; @endphp
    body.public-layout .public-main span.{{ $sc['class'] }},
    body.public-layout .public-main .public-page span.{{ $sc['class'] }},
    body.public-layout .public-main .hero-title span.{{ $sc['class'] }},
    body.public-layout .public-main .hero-pro .hero-title span.{{ $sc['class'] }} {
        color: {{ $spanClr }} !important;
        -webkit-text-fill-color: {{ $spanClr }} !important;
        background: none !important;
        -webkit-background-clip: unset !important;
        background-clip: unset !important;
    }
    @endif
    @endforeach
    /* Tombol tanpa class */
    body.public-layout .public-main button:not([class]),
    body.public-layout .public-main a:not([class])[role="button"] {
        background: {{ $buttonColor }} !important;
        background-image: none !important;
        border-color: {{ $buttonColor }} !important;
        color: {{ $buttonTextColor }} !important;
    }
    /* Warna link (a) tanpa class */
    body.public-layout .public-main a:not([class]),
    body.public-layout .public-main .public-page a:not([class]) { color: {{ $aColor }} !important; }
    @foreach($aColors as $ac)
    @if(!empty($ac['class']))
    @php $aClr = $ac['color'] ?? '#ffffff'; @endphp
    body.public-layout .public-main a.{{ $ac['class'] }},
    body.public-layout .public-main .public-page a.{{ $ac['class'] }} { color: {{ $aClr }} !important; }
    @endif
    @endforeach
    /* Warna div tanpa class */
    body.public-layout .public-main div:not([class]),
    body.public-layout .public-main .public-page div:not([class]) { color: {{ $divColor }} !important; }
    /* Warna tombol per class */
    @foreach(($ws['button_colors'] ?? []) as $bc)
    @if(!empty($bc['class']))
    @php $btnClr = $bc['color'] ?? '#2563eb'; $btnTextClr = $bc['text_color'] ?? '#ffffff'; @endphp
    body.public-layout .public-main .{{ $bc['class'] }},
    body.public-layout .public-main a.{{ $bc['class'] }},
    body.public-layout .public-main button.{{ $bc['class'] }} {
        background: {{ $btnClr }} !important;
        background-image: none !important;
        border-color: {{ $btnClr }} !important;
        color: {{ $btnTextClr }} !important;
    }
    body.public-layout .public-main .{{ $bc['class'] }}:hover,
    body.public-layout .public-main a.{{ $bc['class'] }}:hover,
    body.public-layout .public-main button.{{ $bc['class'] }}:hover {
        filter: brightness(1.1);
    }
    @endif
    @endforeach
    /* Warna div per class dari Pengaturan Web */
    @foreach($divColors as $dc)
    @if(!empty($dc['class']))
    @php $divClr = $dc['color'] ?? '#ffffff'; @endphp
    body.public-layout .public-main div.{{ $dc['class'] }},
    body.public-layout .public-main .public-page div.{{ $dc['class'] }} {
        color: {{ $divClr }} !important;
        -webkit-text-fill-color: {{ $divClr }} !important;
    }
    @endif
    @endforeach
    /* Warna khusus class (class bebas) */
    @foreach($customClassColors as $cc)
    @if(!empty($cc['class']))
    @php $ccClr = $cc['color'] ?? '#ffffff'; @endphp
    body.public-layout .public-main .{{ $cc['class'] }},
    body.public-layout .public-main .public-page .{{ $cc['class'] }} {
        color: {{ $ccClr }} !important;
        -webkit-text-fill-color: {{ $ccClr }} !important;
    }
    @endif
    @endforeach
    /* Background dari Pengaturan Web (warna atau gambar) */
    body.public-layout { background: transparent !important; }
    body.public-layout::before {
        content: '';
        position: fixed;
        inset: 0;
        z-index: -1;
        @if($bgType === 'warna')
        background-color: {{ $overlayRgba }} !important;
        background-image: linear-gradient({{ $bgColor }}, {{ $bgColor }}) !important;
        background-size: cover;
        background-attachment: fixed;
        background-position: center top;
        background-repeat: no-repeat;
        background-blend-mode: overlay;
        @else
        background-color: {{ $overlayRgba }} !important;
        background-image: url("{{ $bgImage }}") !important;
        background-size: cover;
        background-attachment: fixed;
        background-position: center top;
        background-repeat: no-repeat;
        background-blend-mode: overlay;
        @endif
    }
</style>
