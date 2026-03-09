<!DOCTYPE html>
<html lang="id" id="html-theme">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - PeduliJiwa</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    <style>
        /* Tema terang (default) */
        :root, [data-theme="light"] {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light: #60a5fa;
            --accent: #0ea5e9;
            --accent-green: #16a34a;
            --accent-amber: #f59e0b;
            --accent-rose: #f97373;
            --success: #16a34a;
            --success-soft: #e5f9f0;
            --warning: #d97706;
            --warning-soft: #fff7e6;
            --danger: #dc2626;
            --danger-soft: #fde2e2;
            --neutral-soft: #eef2f7;
            /* Latar belakang dashboard dibuat lebih kalem dan lembut */
            --bg: linear-gradient(135deg, #e0f2fe 0%, #e5e7eb 45%, #eef2ff 100%);
            /* Kartu tidak putih pekat, sedikit abu lembut */
            --card: #f9fafb;
            --text: #0f172a;
            --text-muted: #6b7280;
            --border: #e2e8f0;
            --shadow: 0 1px 3px rgba(15,23,42,0.04);
            --shadow-lg: 0 18px 45px rgba(15,23,42,0.12);
            --sidebar-bg: linear-gradient(180deg, #f9fafb 0%, #e0f2fe 100%);
            --topbar-bg: rgba(249,250,251,0.95);
            --user-card-bg: linear-gradient(135deg, #e5edff 0%, #eff6ff 100%);
            --table-header-bg: #edf2ff;
            --table-row-border: #e5e7eb;
            --table-row-hover: #f3f4ff;
            --nav-hover-bg: linear-gradient(135deg, rgba(37,99,235,0.08), rgba(14,165,233,0.06));
            --overlay-bg: rgba(15,23,42,0.35);
        }
        /* Tema gelap */
        [data-theme="dark"] {
            --primary: #60a5fa;
            --primary-dark: #93c5fd;
            --primary-light: #3b82f6;
            --accent: #38bdf8;
            --accent-green: #34d399;
            --accent-amber: #fbbf24;
            --accent-rose: #fb7185;
            --success: #22c55e;
            --success-soft: #064e3b;
            --warning: #fbbf24;
            --warning-soft: #78350f;
            --danger: #f97316;
            --danger-soft: #7f1d1d;
            --neutral-soft: #1f2937;
            --bg: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0c4a6e 100%);
            --card: #1e293b;
            --text: #f1f5f9;
            --text-muted: #94a3b8;
            --border: #334155;
            --shadow: 0 1px 3px rgba(0,0,0,0.3);
            --shadow-lg: 0 10px 40px -10px rgba(0,0,0,0.4);
            --sidebar-bg: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            --topbar-bg: rgba(30,41,59,0.95);
            --user-card-bg: linear-gradient(135deg, #334155 0%, #1e293b 100%);
            --table-header-bg: #334155;
            --table-row-border: #334155;
            --table-row-hover: rgba(59,130,246,0.1);
            --nav-hover-bg: linear-gradient(135deg, rgba(96,165,250,0.12), rgba(56,189,248,0.08));
            --overlay-bg: rgba(0,0,0,0.6);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; color: var(--text); background: var(--bg); min-height: 100vh; }
        a { text-decoration: none; color: inherit; }

        /* ─── Sidebar (menu) — profesional & rapi ─── */
        .sidebar {
            position: fixed; top: 0; left: 0; width: 272px; height: 100vh;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border);
            display: flex; flex-direction: column; z-index: 50;
            box-shadow: 4px 0 32px rgba(0,0,0,0.04);
        }
        [data-theme="dark"] .sidebar { box-shadow: 4px 0 32px rgba(0,0,0,0.2); }
        .sidebar-logo {
            display: flex; align-items: center; gap: 14px;
            padding: 1.5rem 1.25rem 1.35rem;
            font-size: 1.2rem; font-weight: 800; color: var(--primary-dark);
            letter-spacing: -0.02em;
            border-bottom: 1px solid var(--border);
        }
        .sidebar-logo:hover { color: var(--primary-dark); }
        .sidebar-logo-icon {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 1.2rem;
            box-shadow: 0 4px 12px rgba(59,130,246,0.35);
            flex-shrink: 0;
        }
        .sidebar-nav {
            flex: 1;
            padding: 1rem 0.85rem;
            overflow-y: auto;
            overflow-x: hidden;
        }
        .nav-section-title {
            font-size: 0.68rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.12em; color: var(--text-muted);
            padding: 1rem 0.6rem 0.5rem;
            margin-top: 0.25rem;
        }
        .nav-section-title:first-of-type { padding-top: 0.5rem; margin-top: 0; }
        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 0.65rem 0.85rem; border-radius: 10px;
            font-size: 0.875rem; font-weight: 500; color: var(--text-muted);
            transition: background 0.2s ease, color 0.2s ease, transform 0.15s ease;
            margin-bottom: 2px;
            border: 1px solid transparent;
            position: relative;
        }
        .nav-item:hover {
            background: var(--nav-hover-bg);
            color: var(--primary-dark);
        }
        .nav-item.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            color: white;
            box-shadow: 0 2px 12px rgba(59,130,246,0.3);
            border-color: transparent;
        }
        .nav-item.active:hover { filter: brightness(1.05); color: white; }
        .nav-item-icon {
            width: 36px; height: 36px;
            flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            background: rgba(0,0,0,0.04);
            border-radius: 8px;
        }
        [data-theme="dark"] .nav-item-icon { background: rgba(255,255,255,0.08); }
        .nav-item:hover .nav-item-icon { background: rgba(59,130,246,0.12); }
        .nav-item.active .nav-item-icon {
            background: rgba(255,255,255,0.22);
        }
        .sidebar-footer {
            padding: 1rem 0.85rem 1.25rem;
            border-top: 1px solid var(--border);
            background: rgba(0,0,0,0.02);
        }
        [data-theme="dark"] .sidebar-footer { background: rgba(255,255,255,0.03); }
        .user-card {
            display: flex; align-items: center; gap: 12px;
            padding: 1rem 0.9rem;
            background: var(--user-card-bg);
            border-radius: 12px; margin-bottom: 0.75rem;
            border: 1px solid var(--border);
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        [data-theme="dark"] .user-card { box-shadow: 0 1px 3px rgba(0,0,0,0.2); }
        .user-avatar {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 0.95rem; font-weight: 700;
            box-shadow: 0 2px 8px rgba(59,130,246,0.3);
            flex-shrink: 0;
        }
        .user-name { font-size: 0.875rem; font-weight: 600; color: var(--text); line-height: 1.3; }
        .user-role {
            font-size: 0.7rem; color: var(--primary); font-weight: 600;
            background: rgba(59,130,246,0.12);
            padding: 4px 8px; border-radius: 6px;
            display: inline-block; margin-top: 4px;
        }
        .btn-logout {
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
            width: 100%; padding: 0.7rem 1rem;
            background: rgba(239,68,68,0.08);
            border: 1px solid rgba(239,68,68,0.25);
            border-radius: 10px; color: #dc2626;
            font-size: 0.85rem; font-weight: 600; font-family: inherit;
            cursor: pointer; transition: all 0.2s;
        }
        .btn-logout:hover {
            background: rgba(239,68,68,0.14);
            border-color: rgba(239,68,68,0.4);
        }

        .main-content { margin-left: 272px; min-height: 100vh; }
        /* ─── Topbar — bersih & konsisten ─── */
        .topbar {
            background: var(--topbar-bg);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border);
            padding: 0 1.75rem;
            height: 70px;
            display: flex; align-items: center; justify-content: space-between; gap: 1rem;
            position: sticky; top: 0; z-index: 20;
        }
        .topbar-left h1 {
            font-size: 1.15rem; font-weight: 700; color: var(--text);
            letter-spacing: -0.02em; line-height: 1.3;
        }
        .topbar-left p {
            font-size: 0.78rem; color: var(--text-muted);
            margin-top: 2px; font-weight: 500;
        }
        .topbar-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: linear-gradient(135deg, rgba(59,130,246,0.12), rgba(14,165,233,0.08));
            color: var(--primary-dark); font-size: 0.78rem; font-weight: 600;
            padding: 6px 12px; border-radius: 8px;
            border: 1px solid rgba(59,130,246,0.2);
        }
        .content { padding: 1.75rem 2rem; max-width: 1400px; margin: 0 auto; }

        .alert-success {
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            border: 1px solid #86efac;
            border-radius: 12px; padding: 1rem 1.25rem; margin-bottom: 1.5rem;
            font-size: 0.9rem; color: #047857; font-weight: 500;
            display: flex; align-items: center; gap: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .alert-error {
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            border: 1px solid #fecaca;
            border-radius: 12px; padding: 1rem 1.25rem; margin-bottom: 1.5rem;
            font-size: 0.9rem; color: #b91c1c; font-weight: 500;
            display: flex; align-items: center; gap: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .alert-info {
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            border: 1px solid #93c5fd;
            border-radius: 12px; padding: 1rem 1.25rem; margin-bottom: 1.5rem;
            font-size: 0.9rem; color: #1d4ed8; font-weight: 500;
            display: flex; align-items: center; gap: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        [data-theme="dark"] .alert-success {
            background: linear-gradient(135deg, #064e3b, #065f46);
            border-color: #047857;
            color: #6ee7b7;
        }
        [data-theme="dark"] .alert-error {
            background: linear-gradient(135deg, #7f1d1d, #991b1b);
            border-color: #b91c1c;
            color: #fca5a5;
        }
        [data-theme="dark"] .alert-info {
            background: linear-gradient(135deg, #1e3a8a, #1e40af);
            border-color: #2563eb;
            color: #93c5fd;
        }
        [data-theme="dark"] .badge-paid { background: #064e3b; color: #6ee7b7; }
        [data-theme="dark"] .badge-pending { background: #78350f; color: #fcd34d; }
        [data-theme="dark"] .badge-failed { background: #7f1d1d; color: #fca5a5; }
        [data-theme="dark"] .badge-cancel { background: #334155; color: #94a3b8; }
        [data-theme="dark"] .btn-logout {
            background: #7f1d1d;
            border-color: #991b1b;
            color: #fca5a5;
        }
        [data-theme="dark"] .btn-logout:hover { background: #991b1b; border-color: #b91c1c; }

        /* Tombol toggle tema & aksi topbar */
        .theme-toggle-wrap { display: flex; align-items: center; gap: 0.65rem; flex-shrink: 0; }
        .theme-toggle {
            width: 40px; height: 40px;
            border: 1px solid var(--border);
            background: var(--card);
            border-radius: 10px;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            transition: all 0.2s;
            color: var(--text);
        }
        .theme-toggle:hover {
            background: var(--nav-hover-bg);
            border-color: var(--primary);
            color: var(--primary);
        }
        .theme-toggle .icon-sun { display: none; }
        .theme-toggle .icon-moon { display: inline; }
        [data-theme="dark"] .theme-toggle .icon-sun { display: inline; }
        [data-theme="dark"] .theme-toggle .icon-moon { display: none; }

        /* Scrollbar sidebar (rapi) */
        .sidebar-nav::-webkit-scrollbar { width: 6px; }
        .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }
        .sidebar-nav::-webkit-scrollbar-thumb:hover { background: var(--text-muted); }

        .stats-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.25rem; margin-bottom: 2rem; }
        .stat-card {
            background: var(--card);
            border-radius: 14px;
            padding: 1.35rem 1.5rem;
            border: 1px solid var(--border);
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s;
            position: relative; overflow: hidden;
        }
        .stat-card::before {
            content: ''; position: absolute; top: 0; left: 0;
            width: 4px; height: 100%; border-radius: 4px 0 0 4px;
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); border-color: rgba(59,130,246,0.2); }
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
            background: var(--card);
            border-radius: 16px;
            padding: 1.5rem 1.75rem;
            border: 1px solid var(--border);
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
            transition: box-shadow 0.2s, border-color 0.2s;
        }
        .card:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.06); border-color: rgba(59,130,246,0.15); }
        .card-title {
            font-size: 0.95rem; font-weight: 700; color: var(--text);
            margin-bottom: 1rem; padding-bottom: 0.9rem;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between; gap: 0.5rem;
            letter-spacing: -0.01em;
        }
        .table-wrapper { overflow-x: auto; border-radius: 12px; border: 1px solid var(--border); }
        table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
        th {
            text-align: left; padding: 0.75rem 1rem;
            font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.08em; color: var(--text-muted);
            background: var(--table-header-bg); border-bottom: 1px solid var(--border);
        }
        th:first-child { border-radius: 10px 0 0 0; }
        th:last-child { border-radius: 0 10px 0 0; }
        td { padding: 0.85rem 1rem; border-bottom: 1px solid var(--table-row-border); color: var(--text); font-size: 0.875rem; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: var(--table-row-hover); }
        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 4px 12px; border-radius: 8px;
            font-size: 0.75rem; font-weight: 600;
        }
        .badge-paid { background: var(--success-soft); color: var(--success); }
        .badge-pending { background: var(--warning-soft); color: var(--warning); }
        .badge-failed { background: var(--danger-soft); color: var(--danger); }
        .badge-cancel { background: var(--neutral-soft); color: var(--text-muted); }
        .empty-state { text-align: center; padding: 3rem 1.5rem; color: var(--text-muted); font-size: 0.9rem; }
        .empty-state .empty-icon { font-size: 3rem; margin-bottom: 1rem; opacity: 0.5; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .program-item {
            display: flex; align-items: center; justify-content: space-between;
            padding: 0.875rem 0; border-bottom: 1px solid var(--table-row-border);
        }
        .program-item:last-child { border-bottom: none; }
        .program-name { font-size: 0.9rem; font-weight: 600; color: var(--text); }
        .program-count { font-size: 0.78rem; color: var(--text-muted); margin-top: 2px; }
        .program-amount { font-size: 0.95rem; font-weight: 700; color: var(--primary); }
        .info-item { display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid var(--table-row-border); font-size: 0.9rem; }
        .info-item:last-child { border-bottom: none; }
        .info-key { color: var(--text-muted); }
        .info-val { font-weight: 600; color: var(--text); text-align: right; }
        .btn-link {
            font-size: 0.825rem; font-weight: 600; color: var(--primary);
            padding: 6px 12px; border-radius: 8px;
            transition: background 0.2s, color 0.2s;
        }
        .btn-link:hover { background: rgba(59,130,246,0.1); color: var(--primary-dark); }
        .btn {
            font-family: inherit; cursor: pointer; border: none;
            border-radius: 10px; font-weight: 600;
            transition: all 0.2s;
        }
        .btn-sm { padding: 6px 12px; font-size: 0.8rem; }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            box-shadow: 0 2px 8px rgba(59,130,246,0.25);
        }
        .btn-primary:hover { filter: brightness(1.06); box-shadow: 0 4px 12px rgba(59,130,246,0.35); }
        .btn-success {
            background: linear-gradient(135deg, #10b981, #34d399);
            color: white;
            box-shadow: 0 2px 8px rgba(16,185,129,0.25);
        }
        .btn-success:hover { filter: brightness(1.06); box-shadow: 0 4px 12px rgba(16,185,129,0.35); }
        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #f87171);
            color: white;
            box-shadow: 0 2px 8px rgba(239,68,68,0.25);
        }
        .btn-danger:hover { filter: brightness(1.06); box-shadow: 0 4px 12px rgba(239,68,68,0.35); }
        .btn-outline { background: transparent; border: 1px solid var(--border); color: var(--text); }
        .btn-outline:hover { background: rgba(59,130,246,0.08); border-color: var(--primary); color: var(--primary); }

        .welcome-banner {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 50%, #38bdf8 100%);
            border-radius: 16px; padding: 2rem 2.5rem; color: white;
            margin-bottom: 2rem; position: relative; overflow: hidden;
            box-shadow: 0 4px 24px rgba(59,130,246,0.25);
        }
        .welcome-banner::before {
            content: ''; position: absolute; top: -80px; right: -80px;
            width: 280px; height: 280px;
            background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, transparent 70%);
            border-radius: 50%;
        }
        .welcome-banner::after {
            content: ''; position: absolute; bottom: -100px; right: 100px;
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(255,255,255,0.06) 0%, transparent 70%);
            border-radius: 50%;
        }
        .welcome-banner h2 { font-size: 1.5rem; font-weight: 800; margin-bottom: 0.4rem; position: relative; z-index: 1; letter-spacing: -0.02em; }
        .welcome-banner p { font-size: 0.9rem; opacity: 0.95; position: relative; z-index: 1; line-height: 1.5; }

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
            position: fixed; inset: 0; background: var(--overlay-bg);
            z-index: 40; backdrop-filter: blur(2px);
            opacity: 0; transition: opacity 0.25s;
        }
        .sidebar-overlay.open { opacity: 1; }

        @media (max-width: 1024px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 768px) {
            .mobile-menu-btn { display: flex; }
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);
                width: 272px; max-width: 88vw;
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
            .topbar-left h1 { font-size: 1.05rem; }
            .topbar-left p { font-size: 0.72rem; }
            .topbar-badge { font-size: 0.7rem; padding: 5px 10px; }
            .content { padding: 1.25rem 1rem; }
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
        /* Tombol kembali & deskripsi tabel (semua halaman) */
        .page-back-link {
            display: inline-flex; align-items: center; gap: 8px;
            font-size: 0.875rem; font-weight: 600; color: var(--text);
            text-decoration: none; margin-bottom: 1.25rem;
            padding: 0.55rem 1rem;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 10px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.04);
            transition: background 0.2s, border-color 0.2s, color 0.2s, box-shadow 0.2s;
        }
        .page-back-link:hover {
            background: rgba(59,130,246,0.06);
            border-color: rgba(59,130,246,0.3);
            color: var(--primary);
            box-shadow: 0 2px 8px rgba(59,130,246,0.1);
        }
        .page-back-link::before {
            content: "←";
            font-size: 1rem;
            font-weight: 700;
            opacity: 0.85;
        }
        .page-table-desc {
            font-size: 0.875rem; color: var(--text-muted);
            line-height: 1.5; margin: 0 0 1rem; padding: 0;
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
        <div class="theme-toggle-wrap">
            <button type="button" class="theme-toggle" id="themeToggle" aria-label="Ganti tema (terang/gelap)" title="Ganti tema">
                <span class="icon-sun" aria-hidden="true">☀️</span>
                <span class="icon-moon" aria-hidden="true">🌙</span>
            </button>
            <div class="topbar-badge">👮 {{ $user->jabatan ?? 'Petugas Rehabilitasi' }}</div>
        </div>
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
    var THEME_KEY = 'dashboard-theme';
    var html = document.documentElement;
    function getStoredTheme() {
        try {
            return localStorage.getItem(THEME_KEY) || 'light';
        } catch (e) { return 'light'; }
    }
    function setTheme(theme) {
        theme = theme === 'dark' ? 'dark' : 'light';
        html.setAttribute('data-theme', theme);
        try { localStorage.setItem(THEME_KEY, theme); } catch (e) {}
    }
    (function initTheme() {
        var saved = getStoredTheme();
        html.setAttribute('data-theme', saved);
    })();
    var themeBtn = document.getElementById('themeToggle');
    if (themeBtn) {
        themeBtn.addEventListener('click', function() {
            var current = html.getAttribute('data-theme') || 'light';
            setTheme(current === 'dark' ? 'light' : 'dark');
        });
    }

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
