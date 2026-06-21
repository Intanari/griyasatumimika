<style>
    /* ═══ Responsif dashboard — desktop · tablet · mobile ═══ */
    html { -webkit-text-size-adjust: 100%; }
    body { overflow-x: hidden; max-width: 100vw; }
    img { max-width: 100%; height: auto; }

    /* ── Tablet (≤1024px) ── */
    @media (max-width: 1024px) {
        .content { padding: 1.5rem 1.25rem; }
        .grid-2 { grid-template-columns: 1fr; }
        .topbar { padding: 0 1.25rem; }
        .stats-grid { grid-template-columns: repeat(2, 1fr); }

        .mobile-menu-btn { display: flex !important; }
        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);
            width: 272px;
            max-width: 88vw;
        }
        .sidebar.open { transform: translateX(0); }
        .sidebar-overlay { display: block; pointer-events: none; }
        .sidebar-overlay.open { pointer-events: auto; }
        .main-content { margin-left: 0; }

        .petugas-toolbar,
        .jp-toolbar,
        .stock-toolbar {
            flex-direction: column;
            align-items: stretch;
            gap: 1rem;
        }
        .petugas-toolbar-left,
        .petugas-toolbar-center,
        .petugas-toolbar-right,
        .jp-toolbar-primary,
        .jp-toolbar-actions,
        .stock-toolbar-actions {
            width: 100%;
            justify-content: stretch;
        }
        .petugas-btn-add,
        .stock-btn,
        .jp-toolbar-actions .btn {
            justify-content: center;
            min-height: 44px;
        }
    }

    /* ── Mobile (≤768px) ── */
    @media (max-width: 768px) {
        .content { padding: 1.25rem 1rem; }
        .stats-grid { grid-template-columns: 1fr; }

        .topbar {
            padding: 0 1rem;
            min-height: 64px;
            height: auto;
            flex-wrap: nowrap;
            gap: 0.5rem;
        }
        .topbar-left {
            flex: 1;
            min-width: 0;
            overflow: hidden;
        }
        .topbar-left h1 {
            font-size: 1.05rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .topbar-left p { display: none; }
        .topbar-badge { display: none; }
        .theme-toggle-wrap { flex-shrink: 0; }

        .petugas-form-card,
        .admin-account-form-card,
        .jadwal-form-card,
        .rw-form-card,
        .card.card-form { max-width: none; width: 100%; }

        .petugas-form-header,
        .admin-account-form-header,
        .jadwal-form-header,
        .rw-form-header,
        .jadwal-form-header-main {
            flex-wrap: wrap;
            padding: 1rem 1.25rem;
            gap: 0.75rem;
        }

        .petugas-form,
        .admin-account-form,
        .jadwal-form-body,
        .rw-form-body,
        .rw-section-block { padding: 1.25rem 1rem; }

        .petugas-form-fields {
            min-width: 0;
            width: 100%;
            grid-template-columns: 1fr;
        }
        .petugas-form-grid { flex-direction: column; align-items: stretch; }
        .petugas-form-grid-single,
        .rw-form-grid,
        .jadwal-form .rw-form-grid { grid-template-columns: 1fr; }
        .rw-col-full { grid-column: 1; }

        .petugas-form-actions,
        .jadwal-form-actions,
        .rw-form-footer,
        .form-actions {
            flex-direction: column;
            align-items: stretch;
        }
        .petugas-form-actions .btn,
        .jadwal-form-actions .btn,
        .rw-form-footer .btn,
        .form-actions .btn,
        .form-actions a.btn {
            width: 100%;
            justify-content: center;
            text-align: center;
            min-height: 44px;
        }

        .stock-show-dl,
        .jadwal-show-dl,
        [class*="-show-dl"] {
            grid-template-columns: 1fr;
            gap: 0.35rem 0;
            max-width: none;
        }
        .stock-show-dl dt,
        .jadwal-show-dl dt { margin-top: 0.65rem; }
        .stock-show-dl dt:first-child,
        .jadwal-show-dl dt:first-child { margin-top: 0; }

        .stock-toolbar-head { min-width: 0; }
        .stock-form { max-width: none; width: 100%; }

        .card { padding: 1.25rem; }
        .card-title {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 0.75rem;
        }

        .admin-account-card { padding: 1.25rem 1rem; }
        .admin-account-header { flex-direction: column; align-items: stretch; }

        .rw-form-topbar {
            flex-wrap: wrap;
            padding: 1rem;
            gap: 0.5rem;
        }

        .info-item,
        .program-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }
        .info-val { text-align: left; }

        .patient-detail-layout { flex-direction: column; align-items: center; }
        .patient-detail-form-grid { width: 100%; grid-template-columns: 1fr; min-width: 0; }

        .welcome-banner { padding: 1.5rem 1.25rem; }
        .welcome-banner h2 { font-size: 1.25rem; }

        .toast-inbox {
            top: auto;
            bottom: 1rem;
            left: 1rem;
            right: 1rem;
            max-width: none;
        }

        .stat-card { padding: 1.25rem; }
        .stat-value { font-size: 1.5rem; }
        .form-row { grid-template-columns: 1fr; }
        .grid-2 { grid-template-columns: 1fr; }
    }

    /* ── Mobile kecil (≤480px) ── */
    @media (max-width: 480px) {
        .content { padding: 1rem 0.75rem; }
        .page-back-link {
            width: 100%;
            justify-content: center;
            box-sizing: border-box;
        }
        .stat-value { font-size: 1.35rem; }
        .card { padding: 1rem; border-radius: 12px; }
        .mobile-menu-btn { width: 40px; height: 40px; font-size: 1.1rem; }
        .topbar-left h1 { font-size: 0.95rem; }
        .sidebar-logo { font-size: 1rem; padding: 1.25rem 1rem; }
    }
</style>
