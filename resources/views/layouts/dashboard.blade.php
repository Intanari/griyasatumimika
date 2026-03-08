<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - PeduliJiwa</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --primary-light: #60a5fa;
            --accent: #0ea5e9;
            --accent-green: #10b981;
            --accent-amber: #f59e0b;
            --accent-rose: #f43f5e;
            --bg: linear-gradient(135deg, #eff6ff 0%, #dbeafe 50%, #e0f2fe 100%);
            --card: #ffffff;
            --text: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --shadow: 0 1px 3px rgba(0,0,0,0.05);
            --shadow-lg: 0 10px 40px -10px rgba(59,130,246,0.15);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; color: var(--text); background: var(--bg); min-height: 100vh; }
        a { text-decoration: none; color: inherit; }

        .sidebar {
            position: fixed; top: 0; left: 0; width: 280px; height: 100vh;
            background: linear-gradient(180deg, #ffffff 0%, #f0f9ff 100%);
            border-right: 1px solid var(--border);
            display: flex; flex-direction: column; z-index: 50;
            box-shadow: 4px 0 24px rgba(59,130,246,0.06);
        }
        .sidebar-logo {
            display: flex; align-items: center; gap: 12px;
            padding: 1.5rem 1.5rem 1.25rem;
            font-size: 1.25rem; font-weight: 800; color: var(--primary-dark);
        }
        .sidebar-logo-icon {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 1.25rem;
            box-shadow: 0 4px 14px rgba(59,130,246,0.4);
        }
        .sidebar-nav { flex: 1; padding: 1rem 0.75rem; overflow-y: auto; }
        .nav-section-title {
            font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.1em; color: var(--text-muted);
            padding: 0.75rem 0.75rem 0.5rem;
        }
        .nav-item {
            display: flex; align-items: center; gap: 0.875rem;
            padding: 0.75rem 1rem; border-radius: 12px;
            font-size: 0.9rem; font-weight: 500; color: var(--text-muted);
            transition: all 0.2s ease; margin-bottom: 4px;
        }
        .nav-item:hover { background: linear-gradient(135deg, rgba(59,130,246,0.08), rgba(14,165,233,0.06)); color: var(--primary-dark); }
        .nav-item.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            color: white;
            box-shadow: 0 4px 16px rgba(59,130,246,0.35);
        }
        .nav-item-icon { font-size: 1.15rem; flex-shrink: 0; opacity: 0.9; }
        .nav-item.active .nav-item-icon { opacity: 1; }

        .sidebar-footer { padding: 1rem 0.75rem; border-top: 1px solid var(--border); }
        .user-card {
            display: flex; align-items: center; gap: 0.875rem;
            padding: 1rem; background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border-radius: 14px; margin-bottom: 0.75rem;
            border: 1px solid rgba(59,130,246,0.1);
        }
        .user-avatar {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 1rem; font-weight: 700;
            box-shadow: 0 2px 8px rgba(99,102,241,0.3);
        }
        .user-name { font-size: 0.9rem; font-weight: 600; color: var(--text); }
        .user-role {
            font-size: 0.72rem; color: var(--primary); font-weight: 600;
            background: rgba(99,102,241,0.1); padding: 3px 8px; border-radius: 6px;
            display: inline-block; margin-top: 4px;
        }
        .btn-logout {
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
            width: 100%; padding: 0.75rem;
            background: #fff5f5; border: 1px solid #fecaca;
            border-radius: 12px; color: #dc2626;
            font-size: 0.875rem; font-weight: 600; font-family: inherit;
            cursor: pointer; transition: all 0.2s;
        }
        .btn-logout:hover { background: #fee2e2; border-color: #ef4444; }

        .main-content { margin-left: 280px; min-height: 100vh; }
        .topbar {
            background: rgba(255,255,255,0.9); backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            padding: 0 2rem; height: 72px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 20;
        }
        .topbar-left h1 { font-size: 1.2rem; font-weight: 700; color: var(--text); }
        .topbar-left p { font-size: 0.8rem; color: var(--text-muted); margin-top: 2px; }
        .topbar-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: linear-gradient(135deg, rgba(59,130,246,0.1), rgba(14,165,233,0.08));
            color: var(--primary-dark); font-size: 0.8rem; font-weight: 600;
            padding: 6px 14px; border-radius: 10px;
            border: 1px solid rgba(99,102,241,0.2);
        }
        .content { padding: 2rem; }

        .alert-success {
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            border: 1px solid #86efac;
            border-radius: 14px; padding: 1rem 1.25rem; margin-bottom: 1.5rem;
            font-size: 0.9rem; color: #047857;
            display: flex; align-items: center; gap: 0.75rem;
        }
        .alert-error {
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            border: 1px solid #fecaca;
            border-radius: 14px; padding: 1rem 1.25rem; margin-bottom: 1.5rem;
            font-size: 0.9rem; color: #b91c1c;
            display: flex; align-items: center; gap: 0.75rem;
        }
        .alert-info {
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            border: 1px solid #93c5fd;
            border-radius: 14px; padding: 1rem 1.25rem; margin-bottom: 1.5rem;
            font-size: 0.9rem; color: #1d4ed8;
            display: flex; align-items: center; gap: 0.75rem;
        }

        .stats-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.25rem; margin-bottom: 2rem; }
        .stat-card {
            background: var(--card); border-radius: 18px; padding: 1.5rem;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            position: relative; overflow: hidden;
        }
        .stat-card::before {
            content: ''; position: absolute; top: 0; left: 0;
            width: 4px; height: 100%; border-radius: 4px 0 0 4px;
        }
        .stat-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); }
        .stat-card.purple::before { background: linear-gradient(180deg, var(--primary), var(--accent)); }
        .stat-card.green::before { background: linear-gradient(180deg, var(--accent-green), #34d399); }
        .stat-card.orange::before { background: linear-gradient(180deg, var(--accent-amber), #fbbf24); }
        .stat-card.teal::before { background: linear-gradient(180deg, var(--accent), #22d3ee); }
        .stat-card.blue::before { background: linear-gradient(180deg, #3b82f6, #60a5fa); }
        .stat-card.rose::before { background: linear-gradient(180deg, var(--accent-rose), #fb7185); }
        .stat-header { display: flex; align-items: flex-start; justify-content: space-between; }
        .stat-icon {
            width: 48px; height: 48px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
        }
        .stat-icon.purple { background: linear-gradient(135deg, rgba(59,130,246,0.15), rgba(14,165,233,0.1)); }
        .stat-icon.green { background: linear-gradient(135deg, rgba(16,185,129,0.15), rgba(52,211,153,0.1)); }
        .stat-icon.orange { background: linear-gradient(135deg, rgba(245,158,11,0.15), rgba(251,191,36,0.1)); }
        .stat-icon.teal { background: linear-gradient(135deg, rgba(6,182,212,0.15), rgba(34,211,238,0.1)); }
        .stat-icon.blue { background: linear-gradient(135deg, rgba(59,130,246,0.15), rgba(96,165,250,0.1)); }
        .stat-icon.rose { background: linear-gradient(135deg, rgba(244,63,94,0.15), rgba(251,113,133,0.1)); }
        .stat-value { font-size: 1.75rem; font-weight: 800; color: var(--text); line-height: 1.2; letter-spacing: -0.02em; }
        .stat-label { font-size: 0.8rem; color: var(--text-muted); margin-top: 4px; font-weight: 500; }
        .stat-sub { font-size: 0.75rem; color: var(--text-muted); margin-top: 6px; opacity: 0.9; }

        .card {
            background: var(--card); border-radius: 20px; padding: 1.75rem;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            margin-bottom: 1.5rem;
            transition: box-shadow 0.2s;
        }
        .card:hover { box-shadow: var(--shadow-lg); }
        .card-title {
            font-size: 1rem; font-weight: 700; color: var(--text);
            margin-bottom: 1.25rem; padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between; gap: 0.5rem;
        }
        .table-wrapper { overflow-x: auto; border-radius: 12px; }
        table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
        th {
            text-align: left; padding: 0.875rem 1rem;
            font-size: 0.72rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.06em; color: var(--text-muted);
            background: #f8fafc; border-bottom: 2px solid var(--border);
        }
        td { padding: 0.875rem 1rem; border-bottom: 1px solid #f1f5f9; color: var(--text); }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #fafbff; }
        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 4px 12px; border-radius: 8px;
            font-size: 0.75rem; font-weight: 600;
        }
        .badge-paid { background: #d1fae5; color: #047857; }
        .badge-pending { background: #fef3c7; color: #b45309; }
        .badge-failed { background: #fee2e2; color: #dc2626; }
        .badge-cancel { background: #f1f5f9; color: #64748b; }
        .empty-state { text-align: center; padding: 3rem 1.5rem; color: var(--text-muted); font-size: 0.9rem; }
        .empty-state .empty-icon { font-size: 3rem; margin-bottom: 1rem; opacity: 0.5; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .program-item {
            display: flex; align-items: center; justify-content: space-between;
            padding: 0.875rem 0; border-bottom: 1px solid #f1f5f9;
        }
        .program-item:last-child { border-bottom: none; }
        .program-name { font-size: 0.9rem; font-weight: 600; color: var(--text); }
        .program-count { font-size: 0.78rem; color: var(--text-muted); margin-top: 2px; }
        .program-amount { font-size: 0.95rem; font-weight: 700; color: var(--primary); }
        .info-item { display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #f1f5f9; font-size: 0.9rem; }
        .info-item:last-child { border-bottom: none; }
        .info-key { color: var(--text-muted); }
        .info-val { font-weight: 600; color: var(--text); text-align: right; }
        .btn-link {
            font-size: 0.85rem; font-weight: 600; color: var(--primary);
            padding: 6px 12px; border-radius: 8px;
            transition: all 0.2s;
        }
        .btn-link:hover { background: rgba(59,130,246,0.1); }
        .btn { font-family: inherit; cursor: pointer; border: none; border-radius: 10px; font-weight: 600; transition: all 0.2s; }
        .btn-sm { padding: 6px 12px; font-size: 0.8rem; }
        .btn-primary { background: linear-gradient(135deg, var(--primary), var(--accent)); color: white; }
        .btn-primary:hover { filter: brightness(1.05); }
        .btn-success { background: linear-gradient(135deg, #10b981, #34d399); color: white; }
        .btn-success:hover { filter: brightness(1.1); box-shadow: 0 2px 8px rgba(16,185,129,0.4); }
        .btn-danger { background: linear-gradient(135deg, #ef4444, #f87171); color: white; }
        .btn-danger:hover { filter: brightness(1.1); box-shadow: 0 2px 8px rgba(239,68,68,0.4); }
        .btn-outline { background: transparent; border: 1px solid var(--border); color: var(--text); }
        .btn-outline:hover { background: rgba(59,130,246,0.08); border-color: var(--primary); color: var(--primary); }

        .welcome-banner {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 50%, #38bdf8 100%);
            border-radius: 24px; padding: 2.5rem 3rem; color: white;
            margin-bottom: 2rem; position: relative; overflow: hidden;
        }
        .welcome-banner::before {
            content: ''; position: absolute; top: -80px; right: -80px;
            width: 280px; height: 280px;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
            border-radius: 50%;
        }
        .welcome-banner::after {
            content: ''; position: absolute; bottom: -100px; right: 100px;
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
            border-radius: 50%;
        }
        .welcome-banner h2 { font-size: 1.6rem; font-weight: 800; margin-bottom: 0.5rem; position: relative; z-index: 1; }
        .welcome-banner p { font-size: 0.95rem; opacity: 0.95; position: relative; z-index: 1; }

        nav ul.pagination { display: flex; gap: 0.5rem; flex-wrap: wrap; justify-content: center; list-style: none; padding: 0; margin: 0; }
        nav ul.pagination li { display: inline-block; }
        nav ul.pagination a, nav ul.pagination span {
            display: inline-block; padding: 0.5rem 0.875rem; border-radius: 10px;
            font-size: 0.875rem; font-weight: 500;
            background: var(--card); border: 1px solid var(--border);
            color: var(--text); text-decoration: none;
            transition: all 0.2s;
        }
        nav ul.pagination a:hover { background: rgba(59,130,246,0.1); border-color: var(--primary); color: var(--primary); }
        nav ul.pagination li.active span {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white; border-color: transparent;
        }
        nav ul.pagination li.disabled span { opacity: 0.5; cursor: not-allowed; }

        /* Respon notifikasi mirip email (setiap tombol) */
        .toast-inbox {
            position: fixed; top: 1rem; right: 1rem; z-index: 9999;
            display: flex; flex-direction: column; gap: 0.75rem;
            max-width: 380px; width: 100%;
        }
        .toast-email {
            background: var(--card);
            border-radius: 14px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.12), 0 0 1px rgba(0,0,0,0.08);
            border: 1px solid var(--border);
            overflow: hidden;
            animation: toastIn 0.35s ease;
        }
        @keyframes toastIn {
            from { opacity: 0; transform: translateX(100%); }
            to { opacity: 1; transform: translateX(0); }
        }
        .toast-email-header {
            display: flex; align-items: center; gap: 0.5rem;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            border-bottom: 1px solid var(--border);
        }
        .toast-email-success .toast-email-header { background: linear-gradient(135deg, #ecfdf5, #d1fae5); color: #047857; }
        .toast-email-error .toast-email-header { background: linear-gradient(135deg, #fef2f2, #fee2e2); color: #b91c1c; }
        .toast-email-info .toast-email-header { background: linear-gradient(135deg, #eff6ff, #dbeafe); color: var(--primary-dark); }
        .toast-email-icon { font-size: 1.1rem; font-weight: 700; }
        .toast-email-header strong { flex: 1; }
        .toast-email-close {
            background: none; border: none; font-size: 1.25rem; line-height: 1;
            cursor: pointer; opacity: 0.7; padding: 0 4px;
            color: inherit; font-family: inherit;
        }
        .toast-email-close:hover { opacity: 1; }
        .toast-email-body {
            padding: 1rem 1rem;
            font-size: 0.875rem; color: var(--text); line-height: 1.45;
        }

        /* Hamburger & Mobile Sidebar */
        .mobile-menu-btn {
            display: none;
            width: 44px; height: 44px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border: none; border-radius: 12px;
            color: white; font-size: 1.25rem;
            cursor: pointer;
            align-items: center; justify-content: center;
            box-shadow: 0 2px 12px rgba(59,130,246,0.35);
        }
        .sidebar-overlay {
            display: none;
            position: fixed; inset: 0; background: rgba(0,0,0,0.4);
            z-index: 40; backdrop-filter: blur(2px);
            opacity: 0; transition: opacity 0.25s;
        }
        .sidebar-overlay.open { opacity: 1; }

        @media (max-width: 1024px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 768px) {
            .mobile-menu-btn { display: flex; }
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                width: 280px; max-width: 85vw;
            }
            .sidebar.open { transform: translateX(0); }
            .sidebar-overlay { display: block; pointer-events: none; }
            .sidebar-overlay.open { pointer-events: auto; }
            .main-content { margin-left: 0; }
            .topbar {
                padding: 0 1rem;
                height: 64px;
                flex-wrap: wrap;
            }
            .topbar-left h1 { font-size: 1rem; }
            .topbar-left p { font-size: 0.72rem; }
            .topbar-badge { font-size: 0.7rem; padding: 5px 10px; }
            .content { padding: 1rem; }
            .stats-grid { grid-template-columns: 1fr; }
            .grid-2 { grid-template-columns: 1fr; }
            .form-row { grid-template-columns: 1fr; }
            .toast-inbox {
                top: auto; bottom: 1rem; left: 1rem; right: 1rem;
                max-width: none;
            }
            .stat-card { padding: 1.25rem; }
            .stat-value { font-size: 1.5rem; }
            .card { padding: 1.25rem; }
            .card-title { font-size: 0.95rem; flex-wrap: wrap; gap: 0.75rem; }
            .table-wrapper { margin: 0 -1rem; overflow-x: auto; -webkit-overflow-scrolling: touch; }
            .table-wrapper table { min-width: 700px; font-size: 0.8rem; }
            th, td { padding: 0.65rem 0.75rem; }
            .welcome-banner { padding: 1.5rem 1.25rem; }
            .welcome-banner h2 { font-size: 1.25rem; }
            .welcome-banner p { font-size: 0.85rem; }
            .btn-sm { padding: 8px 12px; font-size: 0.82rem; }
        }
        @media (max-width: 480px) {
            .topbar { gap: 0.5rem; }
            .topbar-badge { display: none; }
        }
    </style>
    @stack('styles')
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay" aria-hidden="true" tabindex="-1"></div>
<div class="sidebar" id="sidebar">
    <a href="{{ route('dashboard') }}" class="sidebar-logo">
        <div class="sidebar-logo-icon">🧠</div>
        PeduliJiwa
    </a>
    <nav class="sidebar-nav">
        <div class="nav-section-title">Menu Utama</div>
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') && !request()->routeIs('dashboard.donasi') && !request()->routeIs('dashboard.laporan') && !request()->routeIs('dashboard.patients.*') ? 'active' : '' }}">
            <span class="nav-item-icon">🏠</span>
            Dashboard
        </a>
        <a href="{{ route('dashboard.donasi') }}" class="nav-item {{ request()->routeIs('dashboard.donasi') ? 'active' : '' }}">
            <span class="nav-item-icon">❤️</span>
            Data Donasi
        </a>
        <a href="{{ route('dashboard.laporan') }}" class="nav-item {{ request()->routeIs('dashboard.laporan') ? 'active' : '' }}">
            <span class="nav-item-icon">🚨</span>
            Data Laporan ODGJ
        </a>
        <a href="{{ route('dashboard.patients.index') }}" class="nav-item {{ request()->routeIs('dashboard.patients.*') ? 'active' : '' }}">
            <span class="nav-item-icon">👥</span>
            Data Pasien
        </a>
        <a href="{{ route('dashboard.riwayat-pemeriksaan.index') }}" class="nav-item {{ request()->routeIs('dashboard.riwayat-pemeriksaan.*') ? 'active' : '' }}">
            <span class="nav-item-icon">🩺</span>
            Riwayat Pemeriksaan
        </a>
        <a href="{{ route('dashboard.patient-activities.index') }}" class="nav-item {{ request()->routeIs('dashboard.patient-activities.*') ? 'active' : '' }}">
            <span class="nav-item-icon">📋</span>
            Aktivitas Pasien
        </a>
        <a href="{{ route('dashboard.jadwal-pasien.index') }}" class="nav-item {{ request()->routeIs('dashboard.jadwal-pasien.*') ? 'active' : '' }}">
            <span class="nav-item-icon">📅</span>
            Jadwal Pasien
        </a>
        <a href="{{ route('dashboard.jadwal-rehabilitasi.index') }}" class="nav-item {{ request()->routeIs('dashboard.jadwal-rehabilitasi.*') ? 'active' : '' }}">
            <span class="nav-item-icon">🔄</span>
            Jadwal Rehabilitasi
        </a>
        <a href="{{ route('dashboard.petugas.index') }}" class="nav-item {{ request()->routeIs('dashboard.petugas.*') ? 'active' : '' }}">
            <span class="nav-item-icon">🧑‍⚕️</span>
            Data Petugas
        </a>
        <a href="{{ route('dashboard.jadwal-petugas.index') }}" class="nav-item {{ request()->routeIs('dashboard.jadwal-petugas.*') ? 'active' : '' }}">
            <span class="nav-item-icon">📋</span>
            Jadwal Petugas
        </a>
        <a href="{{ route('dashboard.stock.index') }}" class="nav-item {{ request()->routeIs('dashboard.stock.*') ? 'active' : '' }}">
            <span class="nav-item-icon">📦</span>
            Stok Barang
        </a>
        <div class="nav-section-title">Aksi Cepat</div>
        <a href="{{ route('donation.form') }}" class="nav-item" target="_blank">
            <span class="nav-item-icon">📝</span>
            Form Donasi Publik
        </a>
        <a href="{{ route('odgj-report.form') }}" class="nav-item" target="_blank">
            <span class="nav-item-icon">📋</span>
            Form Laporan ODGJ
        </a>
        <a href="{{ route('welcome') }}" class="nav-item">
            <span class="nav-item-icon">🌐</span>
            Halaman Utama
        </a>
    </nav>
    <div class="sidebar-footer">
        <div class="user-card">
            <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
            <div style="flex:1; min-width:0;">
                <div class="user-name" style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $user->name }}</div>
                <div class="user-role">🏥 {{ $user->role_label }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">🚪 Keluar</button>
        </form>
    </div>
</div>

<div class="main-content">
    <header class="topbar">
        <button type="button" class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Buka menu">☰</button>
        <div class="topbar-left">
            <h1>@yield('topbar-title', 'Dashboard')</h1>
            <p>{{ now()->locale('id')->translatedFormat('l, d F Y') }}</p>
        </div>
        <div class="topbar-badge">👮 {{ $user->jabatan ?? 'Petugas Rehabilitasi' }}</div>
    </header>

    <div class="content">
        @if (session('success'))
            <div class="alert-success">✅ {{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert-error">⚠️ {{ session('error') }}</div>
        @endif
        @if (session('info'))
            <div class="alert-info">ℹ️ {{ session('info') }}</div>
        @endif
        @yield('content')
    </div>

    {{-- Respon notifikasi mirip email untuk setiap tombol/aksi --}}
    <div id="toast-inbox" class="toast-inbox" aria-live="polite">
        @if (session('success'))
            <div class="toast-email toast-email-success" data-auto-dismiss>
                <div class="toast-email-header">
                    <span class="toast-email-icon">✓</span>
                    <strong>Berhasil</strong>
                    <button type="button" class="toast-email-close" onclick="this.closest('.toast-email').remove()" aria-label="Tutup">×</button>
                </div>
                <div class="toast-email-body">{{ session('success') }}</div>
            </div>
        @endif
        @if (session('error'))
            <div class="toast-email toast-email-error" data-auto-dismiss>
                <div class="toast-email-header">
                    <span class="toast-email-icon">⚠</span>
                    <strong>Gagal</strong>
                    <button type="button" class="toast-email-close" onclick="this.closest('.toast-email').remove()" aria-label="Tutup">×</button>
                </div>
                <div class="toast-email-body">{{ session('error') }}</div>
            </div>
        @endif
        @if (session('info'))
            <div class="toast-email toast-email-info" data-auto-dismiss>
                <div class="toast-email-header">
                    <span class="toast-email-icon">ℹ</span>
                    <strong>Info</strong>
                    <button type="button" class="toast-email-close" onclick="this.closest('.toast-email').remove()" aria-label="Tutup">×</button>
                </div>
                <div class="toast-email-body">{{ session('info') }}</div>
            </div>
        @endif
    </div>
</div>

@stack('scripts')
<script>
(function() {
    var sidebar = document.getElementById('sidebar');
    var overlay = document.getElementById('sidebarOverlay');
    var btn = document.getElementById('mobileMenuBtn');
    function openMenu() {
        sidebar.classList.add('open');
        overlay.classList.add('open');
        document.body.style.overflow = 'hidden';
        btn.setAttribute('aria-label', 'Tutup menu');
        btn.innerHTML = '✕';
    }
    function closeMenu() {
        sidebar.classList.remove('open');
        overlay.classList.remove('open');
        document.body.style.overflow = '';
        btn.setAttribute('aria-label', 'Buka menu');
        btn.innerHTML = '☰';
    }
    if (btn) btn.addEventListener('click', function() {
        sidebar.classList.contains('open') ? closeMenu() : openMenu();
    });
    if (overlay) overlay.addEventListener('click', closeMenu);
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar && sidebar.classList.contains('open')) closeMenu();
    });

    document.querySelectorAll('#toast-inbox [data-auto-dismiss]').forEach(function(el) {
        setTimeout(function() {
            if (el.parentNode) el.remove();
        }, 6000);
    });
})();
</script>
</body>
</html>
