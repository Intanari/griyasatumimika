<style>
    /* ═══ Responsif global — desktop · tablet · mobile ═══ */
    html {
        -webkit-text-size-adjust: 100%;
        scroll-behavior: smooth;
    }
    body.public-layout {
        overflow-x: hidden;
        max-width: 100vw;
    }
    .public-main,
    .public-content {
        min-width: 0;
        max-width: 100%;
        overflow-x: clip;
    }
    .section-inner {
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }
    img, video, iframe, svg { max-width: 100%; height: auto; }
    table { max-width: 100%; }

    .nav-inner { position: relative; }

    /* ── Tablet (≤1024px) ── */
    @media (max-width: 1024px) {
        .navbar { padding: 0 0.75rem; }
        .nav-inner {
            height: auto !important;
            min-height: 68px;
            padding: 0.5rem 0;
            gap: 0.65rem;
        }
        .nav-logo { min-width: 0; flex: 1 1 auto; }

        .section { padding: 3.5rem 1.25rem; }
        .hero { min-height: auto; padding-top: 72px; }
        .hero-pro .hero-inner {
            grid-template-columns: 1fr !important;
            padding: 2.5rem 1.25rem 3rem !important;
            gap: 2rem !important;
        }
        .hero-pro .hero-title { font-size: clamp(1.75rem, 4.5vw, 2.35rem); }
        .hero-pro .hero-desc { max-width: none; }
        .hero-inner { padding: 2.5rem 1.25rem; gap: 2rem; }

        .impact-grid,
        .impact-bar .impact-grid { grid-template-columns: repeat(2, 1fr); gap: 1.5rem; }
        .impact-item:nth-child(2n) { border-right: none; }
        .gallery-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1rem; }
        .org-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .partners-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .footer-grid,
        .footer-grid-simple { grid-template-columns: repeat(2, 1fr); gap: 2rem; }
        .contact-layout {
            grid-template-columns: 1fr;
            margin-top: -1.5rem;
            padding: 1.75rem 1.25rem 2.25rem;
        }
        .contact-card-grid { grid-template-columns: 1fr; }
        .form-row-grid { grid-template-columns: 1fr; }
        .profile-grid { grid-template-columns: 1fr; }
        .profile-subsections { grid-template-columns: 1fr; }
        .services-layout { grid-template-columns: 1fr; }
        .about-grid { grid-template-columns: 1fr; }
        .about-cards { grid-template-columns: 1fr; }
        .programs-grid { grid-template-columns: 1fr; }
        .donate-steps { grid-template-columns: repeat(2, 1fr); }
        .testi-cards, .testi-grid { grid-template-columns: 1fr; }
        .steps-grid { grid-template-columns: repeat(2, 1fr); }
        .steps-grid::before { display: none; }
        .faq-grid { grid-template-columns: 1fr; }
        .services-steps { flex-wrap: wrap; justify-content: center; }
    }

    /* Hero / halaman statis — offset navbar */
    .page-hero,
    .layanan-hero,
    .page-hero-contact,
    .struktur-main-wrap,
    .gallery-section,
    .public-page > section:first-child,
    .section.profile-section:first-of-type {
        padding-top: clamp(5rem, 12vw, calc(5.25rem + 84px)) !important;
    }
    .page-title { font-size: clamp(1.45rem, 4.5vw, 2.1rem); }
    .page-subtitle {
        font-size: clamp(0.85rem, 2.5vw, 0.95rem);
        padding: 0 0.5rem;
    }

    .profile-tabs {
        flex-wrap: wrap;
        justify-content: center;
        max-width: 100%;
    }
    .profile-body,
    .profile-meta-card,
    .profile-meta-card h2,
    .profile-meta-content {
        max-width: 100%;
        min-width: 0;
        overflow-wrap: anywhere;
        word-break: break-word;
    }
    .profile-section .section-inner { overflow-x: clip; max-width: 100%; }

    /* Tabel publik — scroll horizontal aman */
    .transparan-table-scroll,
    .table-scroll-wrap {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        max-width: 100%;
    }

    /* ── Mobile landscape / phablet (≤768px) ── */
    @media (max-width: 768px) {
        .navbar { padding: 0 0.65rem; }
        .nav-inner { min-height: 64px; }

        .section { padding: 2.75rem 1rem; }
        .page-hero .section-title { font-size: clamp(1.35rem, 5vw, 1.65rem); }
        .page-hero .section-desc { font-size: 0.9rem; }
        .section-head h2,
        .section-title { font-size: clamp(1.3rem, 5vw, 1.75rem); }
        .section-lead { font-size: 0.92rem; }

        .hero-pro .hero-inner { padding: 2rem 1rem 2.5rem !important; }
        .hero-title { font-size: clamp(1.5rem, 6vw, 2rem); }
        .hero-cta { flex-direction: column; width: 100%; }
        .hero-cta a { width: 100%; text-align: center; justify-content: center; }
        .hero-metrics, .hero-stats { flex-wrap: wrap; gap: 1.25rem; }

        .contact-info-column,
        .contact-form-column { padding: 1.35rem 1.15rem; }
        .contact-layout { padding: 1.35rem 1rem 2rem; border-radius: 20px; }

        .transparan-cards { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 0.85rem; }
        .transparan-pdf-btns { flex-direction: column; align-items: stretch; }
        .transparan-pdf-btns a { width: 100%; text-align: center; justify-content: center; }
        .transparan-filter-form { flex-direction: column; align-items: stretch; }
        .transparan-filter-field { flex: 1 1 auto; width: 100%; }
        .transparan-filter-actions { width: 100%; }
        .transparan-filter-actions .transparan-filter-btn { flex: 1; min-height: 44px; }

        .impact-bar .impact-item {
            border-right: none;
            border-bottom: 1px solid rgba(255,255,255,0.15);
            padding-bottom: 1rem;
        }
        .impact-bar .impact-item:last-child { border-bottom: none; }

        .about-links { flex-direction: column; align-items: center; gap: 0.75rem; }
        .footer-grid, .footer-grid-simple { grid-template-columns: 1fr; text-align: center; }
        .footer-desc { margin: 0 auto 1rem; }
        .footer-socials { justify-content: center; }
        .footer-links { align-items: center; }
        .footer-bottom { flex-direction: column; gap: 0.75rem; text-align: center; }
        .footer-simple-inner {
            font-size: 0.82rem;
            line-height: 1.55;
            padding: 0 0.5rem;
        }

        .org-chart .org-level { flex-wrap: wrap; justify-content: center; gap: 1rem; }
        .services-steps { flex-direction: column; align-items: stretch; }
        .step-arrow { display: none; }
        .step { width: 100%; min-width: 0; }
    }

    /* ── Mobile (≤600px) ── */
    @media (max-width: 600px) {
        .section { padding: 2.5rem 0.875rem; }
        .public-page > section:first-child { padding-top: clamp(4.5rem, 14vw, 5.5rem) !important; }
        .page-hero .section-title { font-size: clamp(1.25rem, 5.5vw, 1.5rem); }
        .page-hero .section-tag { font-size: 0.72rem; }
        .profile-meta-card { padding: 1.2rem 1.15rem; }
        .transparan-cards { grid-template-columns: 1fr; }
        .transparan-table { font-size: 0.78rem; }
        .transparan-table th,
        .transparan-table td { padding: 0.55rem 0.6rem; white-space: nowrap; }
        .transparan-pagination { flex-direction: column; gap: 0.65rem; }
        .donate-steps { grid-template-columns: 1fr; }
        .impact-grid,
        .impact-bar .impact-grid { grid-template-columns: 1fr; }
        .gallery-grid { grid-template-columns: 1fr; }
        .org-grid { grid-template-columns: 1fr; }
        .partners-grid { grid-template-columns: repeat(2, 1fr); }
        .steps-grid { grid-template-columns: 1fr; }
    }

    /* ── Mobile kecil (≤480px) ── */
    @media (max-width: 480px) {
        .nav-inner { min-height: 58px; }
        .section { padding: 2.25rem 0.75rem; }
        .yayasan-logo--nav { height: 48px; max-width: 58vw; }

        .cta-btns,
        .cta-buttons {
            flex-direction: column;
            align-items: stretch;
            width: 100%;
            max-width: 100%;
            margin-left: auto;
            margin-right: auto;
        }
        .btn-cta-primary,
        .btn-cta-secondary,
        .btn-hero-primary,
        .btn-hero-secondary,
        .btn-hero-outline,
        .btn-donate-main {
            width: 100%;
            justify-content: center;
            text-align: center;
            min-height: 48px;
        }
        .hero-metrics { flex-direction: column; gap: 1rem; }
        .hero-stats { justify-content: flex-start; }
        .contact-row { flex-direction: column; align-items: stretch; gap: 1rem; }
        .section-contact .contact-item { justify-content: center; }
        .org-chart .org-level { flex-direction: column; align-items: center; }
        .org-level-connector.branch::after { display: none; }
        .org-node { min-width: 0; max-width: 100%; width: 100%; }

        .footer.footer-simple { padding: 1rem 0.75rem calc(1rem + env(safe-area-inset-bottom, 0px)); }
    }
</style>
