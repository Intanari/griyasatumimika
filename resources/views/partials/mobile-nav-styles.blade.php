<style>
    /* ─── Nav mobile/tablet: drawer modern ─── */
    @media (max-width: 1024px) {
        .navbar .nav-links { display: none !important; }
        .nav-actions .btn-nav-admin { display: none !important; }
        .nav-mobile-toggle {
            display: inline-flex !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        .nav-inner {
            height: auto;
            min-height: 68px;
            padding: 0.45rem 0;
            gap: 0.65rem;
        }
        .nav-logo {
            min-width: 0;
            flex: 1 1 auto;
        }
        .nav-actions {
            display: flex !important;
            align-items: center;
            flex-shrink: 0;
            margin-left: auto;
        }
    }

    .nav-mobile-toggle {
        display: none;
        align-items: center;
        justify-content: center;
        gap: 0.45rem;
        min-width: 44px;
        height: 44px;
        padding: 0 0.85rem 0 0.7rem;
        border: 1.5px solid rgba(255,255,255,0.65);
        border-radius: 12px;
        background: rgba(255,255,255,0.08);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        color: #ffffff;
        cursor: pointer;
        flex-shrink: 0;
        box-shadow: none;
        transition: transform 0.2s ease, background 0.2s ease, border-color 0.2s ease;
    }
    .nav-mobile-toggle:hover {
        background: rgba(255,255,255,0.16);
        border-color: rgba(255,255,255,0.9);
    }
    .nav-mobile-toggle:active {
        transform: scale(0.97);
    }

    .nav-toggle-icon {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 5px;
        width: 20px;
        height: 20px;
        flex-shrink: 0;
    }
    .nav-toggle-bar {
        display: block;
        width: 20px;
        height: 2.5px;
        border-radius: 2px;
        background: #ffffff;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.2s ease, width 0.3s ease;
        transform-origin: center;
    }
    .nav-toggle-label {
        font-size: 0.82rem;
        font-weight: 700;
        letter-spacing: 0.02em;
        color: #ffffff;
        white-space: nowrap;
    }
    .nav-mobile-toggle.is-active .nav-toggle-bar:nth-child(1) {
        transform: translateY(7.5px) rotate(45deg);
    }
    .nav-mobile-toggle.is-active .nav-toggle-bar:nth-child(2) {
        opacity: 0;
        width: 0;
    }
    .nav-mobile-toggle.is-active .nav-toggle-bar:nth-child(3) {
        transform: translateY(-7.5px) rotate(-45deg);
    }
    .nav-mobile-toggle.is-active .nav-toggle-label {
        display: none;
    }
    .nav-mobile-toggle.is-active {
        padding: 0;
        width: 44px;
    }

    @media (max-width: 480px) {
        .nav-toggle-label { display: none; }
        .nav-mobile-toggle {
            width: 44px;
            padding: 0;
        }
        .nav-mobile-toggle.is-active .nav-toggle-label { display: none; }
    }

    .nav-drawer-overlay {
        position: fixed;
        inset: 0;
        z-index: 1000;
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: opacity 0.35s ease, visibility 0.35s ease;
    }
    .nav-drawer-overlay.is-open {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }

    .nav-drawer {
        position: fixed;
        top: 0;
        right: 0;
        z-index: 1010;
        width: min(340px, 92vw);
        max-width: 100%;
        height: 100%;
        height: 100dvh;
        display: flex;
        flex-direction: column;
        background: linear-gradient(165deg, rgba(15, 23, 42, 0.98) 0%, rgba(30, 58, 138, 0.96) 100%);
        border-left: 1px solid rgba(255,255,255,0.12);
        box-shadow: -16px 0 48px rgba(0,0,0,0.35);
        transform: translateX(105%);
        transition: transform 0.4s cubic-bezier(0.32, 0.72, 0, 1);
        overflow: hidden;
        padding-top: env(safe-area-inset-top, 0px);
    }
    .nav-drawer.is-open {
        transform: translateX(0);
    }

    .nav-drawer-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        padding: 1rem 1.25rem;
        min-height: 64px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        flex-shrink: 0;
        background: rgba(15, 23, 42, 0.85);
        position: relative;
        z-index: 2;
    }
    .nav-drawer-brand {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        min-width: 0;
        flex: 1;
    }
    .nav-drawer-logo {
        height: 48px !important;
        max-width: min(200px, 55vw) !important;
        width: auto;
        object-fit: contain;
    }
    .nav-drawer-close {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 10px;
        background: rgba(255,255,255,0.08);
        color: #ffffff;
        cursor: pointer;
        flex-shrink: 0;
        transition: background 0.2s ease, border-color 0.2s ease;
    }
    .nav-drawer-close:hover {
        background: rgba(255,255,255,0.15);
        border-color: rgba(255,255,255,0.35);
    }

    .nav-drawer-body {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 0.75rem 0.85rem 1rem;
        -webkit-overflow-scrolling: touch;
    }
    .nav-drawer-body::-webkit-scrollbar { width: 4px; }
    .nav-drawer-body::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 4px; }

    .nav-drawer-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.85rem 1rem;
        margin-bottom: 0.25rem;
        border-radius: 12px;
        font-size: 0.95rem;
        font-weight: 600;
        color: #ffffff !important;
        -webkit-text-fill-color: #ffffff !important;
        text-decoration: none;
        transition: background 0.2s ease, transform 0.15s ease;
    }
    .nav-drawer-link:hover,
    .nav-drawer-link:focus-visible {
        background: rgba(255,255,255,0.1);
    }
    .nav-drawer-link-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: rgba(255,255,255,0.08);
        font-size: 1rem;
        flex-shrink: 0;
    }

    .nav-drawer-accordion {
        margin-bottom: 0.25rem;
        border-radius: 12px;
        overflow: hidden;
    }
    .nav-drawer-accordion-trigger {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.85rem 1rem;
        font-size: 0.95rem;
        font-weight: 600;
        color: #ffffff;
        cursor: pointer;
        list-style: none;
        transition: background 0.2s ease;
        user-select: none;
    }
    .nav-drawer-accordion-trigger::-webkit-details-marker { display: none; }
    .nav-drawer-accordion-trigger::marker { content: none; }
    .nav-drawer-accordion-trigger:hover { background: rgba(255,255,255,0.06); }
    .nav-drawer-accordion[open] > .nav-drawer-accordion-trigger {
        background: rgba(255,255,255,0.08);
    }
    .nav-drawer-chevron {
        width: 14px;
        height: 14px;
        margin-left: auto;
        flex-shrink: 0;
        color: rgba(255,255,255,0.7);
        transition: transform 0.25s ease;
    }
    .nav-drawer-accordion[open] .nav-drawer-chevron {
        transform: rotate(180deg);
    }

    .nav-drawer-sub {
        padding: 0.25rem 0.5rem 0.65rem 3.25rem;
        display: flex;
        flex-direction: column;
        gap: 0.15rem;
    }
    .nav-drawer-sublink {
        display: block;
        padding: 0.6rem 0.85rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 500;
        color: rgba(255,255,255,0.88) !important;
        -webkit-text-fill-color: rgba(255,255,255,0.88) !important;
        text-decoration: none;
        transition: background 0.2s ease, color 0.2s ease;
    }
    .nav-drawer-sublink:hover {
        background: rgba(255,255,255,0.08);
        color: #ffffff !important;
    }
    .nav-drawer-sublink.is-active {
        background: rgba(59,130,246,0.35);
        color: #ffffff !important;
        font-weight: 600;
    }

    .nav-drawer-footer {
        flex-shrink: 0;
        padding: 1rem 1.25rem calc(1rem + env(safe-area-inset-bottom, 0px));
        border-top: 1px solid rgba(255,255,255,0.1);
        background: rgba(0,0,0,0.15);
    }
    .nav-drawer-cta {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        padding: 0.85rem 1.25rem;
        border-radius: 12px;
        background: rgba(255,255,255,0.08);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1.5px solid rgba(255,255,255,0.65);
        color: #ffffff !important;
        font-size: 0.95rem;
        font-weight: 700;
        text-decoration: none;
        box-shadow: none;
        transition: transform 0.2s ease, background 0.2s ease, border-color 0.2s ease;
        min-height: 48px;
    }
    .nav-drawer-cta:hover {
        transform: translateY(-1px);
        background: rgba(255,255,255,0.16);
        border-color: rgba(255,255,255,0.9);
    }

    body.nav-drawer-open {
        overflow: hidden;
        touch-action: none;
    }
    /* Sembunyikan navbar utama saat drawer terbuka — cegah header drawer ketutupan */
    body.nav-drawer-open .navbar {
        visibility: hidden;
        pointer-events: none;
    }

    @media (prefers-reduced-motion: reduce) {
        .nav-drawer,
        .nav-drawer-overlay,
        .nav-toggle-bar {
            transition: none;
        }
    }
</style>
