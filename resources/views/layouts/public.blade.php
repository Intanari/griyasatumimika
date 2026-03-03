<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'PeduliJiwa') - Donasi Rehabilitasi ODGJ</title>
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
            --text: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --bg: linear-gradient(135deg, #eff6ff 0%, #dbeafe 50%, #e0f2fe 100%);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; color: var(--text); background: var(--bg); min-height: 100vh; line-height: 1.6; }
        a { text-decoration: none; color: inherit; }

        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            background: rgba(255,255,255,0.95); backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            padding: 0 1.5rem;
        }
        .nav-inner { max-width: 1200px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; height: 72px; }
        .nav-logo {
            display: flex; align-items: center; gap: 12px;
            font-size: 1.25rem; font-weight: 800; color: var(--primary-dark);
        }
        .nav-logo-icon {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 1.1rem;
            box-shadow: 0 4px 14px rgba(59,130,246,0.35);
        }
        .nav-links { display: flex; align-items: center; gap: 2rem; }
        .nav-links a { font-size: 0.9rem; font-weight: 500; color: var(--text-muted); transition: color 0.2s; }
        .nav-links a:hover { color: var(--primary-dark); }
        .nav-actions { display: flex; align-items: center; gap: 0.75rem; }
        .btn-outline {
            padding: 0.5rem 1.25rem; border: 2px solid var(--primary);
            border-radius: 10px; color: var(--primary); font-size: 0.9rem; font-weight: 600;
            transition: all 0.2s;
        }
        .btn-outline:hover { background: var(--primary); color: white; }
        .btn-primary {
            padding: 0.55rem 1.35rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            border-radius: 10px; color: white; font-size: 0.9rem; font-weight: 600;
            box-shadow: 0 4px 16px rgba(99,102,241,0.35);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 24px rgba(59,130,246,0.4); }
        .nav-back { display: flex; align-items: center; gap: 6px; font-size: 0.9rem; font-weight: 500; color: var(--text-muted); transition: color 0.2s; }
        .nav-back:hover { color: var(--primary-dark); }

        .page-wrapper { max-width: 720px; margin: 0 auto; padding: 4rem 1.5rem 5rem; }
        .breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 0.85rem; color: var(--text-muted); margin-bottom: 2rem; }
        .breadcrumb a { color: var(--primary); font-weight: 500; }
        .form-header { text-align: center; margin-bottom: 2.5rem; }
        .form-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: linear-gradient(135deg, rgba(59,130,246,0.12), rgba(14,165,233,0.08));
            color: var(--primary-dark); font-size: 0.85rem; font-weight: 600;
            padding: 6px 16px; border-radius: 100px; margin-bottom: 1rem;
            border: 1px solid rgba(59,130,246,0.2);
        }
        .form-title { font-size: 1.9rem; font-weight: 800; color: var(--text); line-height: 1.25; margin-bottom: 0.6rem; }
        .form-subtitle { font-size: 0.95rem; color: var(--text-muted); line-height: 1.6; }
        .form-card {
            background: white; border-radius: 24px; padding: 2rem;
            box-shadow: 0 10px 40px rgba(59,130,246,0.08);
            border: 1px solid var(--border);
        }
        .section-divider {
            font-size: 0.78rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.08em; color: var(--text-muted);
            margin-bottom: 1.25rem; margin-top: 0.25rem;
            display: flex; align-items: center; gap: 10px;
        }
        .section-divider::after { content: ''; flex: 1; height: 1px; background: var(--border); }
        .form-group { margin-bottom: 1.25rem; }
        .form-label { display: block; font-size: 0.9rem; font-weight: 600; color: var(--text); margin-bottom: 6px; }
        .form-label .req { color: #ef4444; }
        .form-input {
            width: 100%; padding: 0.75rem 1rem;
            border: 2px solid var(--border); border-radius: 12px;
            font-size: 0.95rem; font-family: inherit; color: var(--text);
            background: white; transition: all 0.2s; outline: none;
        }
        .form-input:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(59,130,246,0.1); }
        .form-input.is-invalid { border-color: #ef4444; }
        .form-input::placeholder { color: #94a3b8; }
        .invalid-feedback { font-size: 0.82rem; color: #ef4444; margin-top: 6px; }
        textarea.form-input { resize: vertical; min-height: 120px; }
        .btn-submit {
            width: 100%; padding: 1rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            border: none; border-radius: 14px; color: white;
            font-size: 1rem; font-weight: 700; font-family: inherit;
            cursor: pointer; transition: all 0.2s;
            box-shadow: 0 4px 20px rgba(59,130,246,0.35);
            display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 1.75rem;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(59,130,246,0.45); }
        .alert-success {
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            border: 1px solid #86efac; border-radius: 14px;
            padding: 1rem 1.25rem; margin-bottom: 1.5rem;
            font-size: 0.9rem; color: #047857;
            display: flex; align-items: center; gap: 0.75rem;
        }
        .trust-row { display: flex; gap: 1.5rem; justify-content: center; margin-top: 1.5rem; flex-wrap: wrap; }
        .trust-item { display: flex; align-items: center; gap: 6px; font-size: 0.8rem; color: var(--text-muted); }

        @media (max-width: 768px) { .nav-links { display: none; } }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar">
        <div class="nav-inner">
            <a href="{{ url('/') }}" class="nav-logo">
                <div class="nav-logo-icon">🧠</div>
                PeduliJiwa
            </a>
            @hasSection('nav-links')
                <div class="nav-links">@yield('nav-links')</div>
            @else
                <a href="{{ url('/') }}" class="nav-back">← Kembali ke Beranda</a>
            @endif
            @hasSection('nav-actions')
                <div class="nav-actions">@yield('nav-actions')</div>
            @endif
        </div>
    </nav>
    @yield('content')
    @stack('scripts')
</body>
</html>
