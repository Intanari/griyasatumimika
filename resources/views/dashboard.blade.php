<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Petugas - PeduliJiwa</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            color: #1a1a2e;
            background: #f5f5ff;
            min-height: 100vh;
        }
        a { text-decoration: none; color: inherit; }

        /* ─── Sidebar ─── */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: 260px;
            height: 100vh;
            background: white;
            border-right: 1px solid #e8e8f0;
            display: flex;
            flex-direction: column;
            z-index: 50;
            box-shadow: 2px 0 20px rgba(79,70,229,0.06);
        }
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 1.5rem 1.5rem 1rem;
            font-size: 1.2rem;
            font-weight: 700;
            color: #4f46e5;
            border-bottom: 1px solid #f0f0f8;
        }
        .sidebar-logo-icon {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 1.1rem; flex-shrink: 0;
        }
        .sidebar-nav { flex: 1; padding: 1rem 0.75rem; overflow-y: auto; }
        .nav-section-title {
            font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.08em; color: #9ca3af;
            padding: 0.75rem 0.75rem 0.375rem;
        }
        .nav-item {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.625rem 0.875rem; border-radius: 10px;
            font-size: 0.9rem; font-weight: 500; color: #4a4a6a;
            transition: all 0.15s; margin-bottom: 2px;
        }
        .nav-item:hover { background: #f0f0ff; color: #4f46e5; }
        .nav-item.active {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            box-shadow: 0 2px 10px rgba(79,70,229,0.3);
        }
        .nav-item-icon { font-size: 1.1rem; flex-shrink: 0; }

        .sidebar-footer { padding: 1rem 0.75rem; border-top: 1px solid #f0f0f8; }
        .user-card {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.75rem; background: #f8f8ff; border-radius: 12px; margin-bottom: 0.75rem;
        }
        .user-avatar {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 1.1rem; font-weight: 700; flex-shrink: 0;
        }
        .user-name { font-size: 0.875rem; font-weight: 600; color: #1a1a2e; }
        .user-role {
            font-size: 0.72rem; color: #4f46e5; font-weight: 600;
            background: rgba(79,70,229,0.08); padding: 2px 7px; border-radius: 4px;
            display: inline-block; margin-top: 2px;
        }
        .btn-logout {
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
            width: 100%; padding: 0.625rem;
            background: #fef2f2; border: 1.5px solid #fecaca; border-radius: 10px;
            color: #dc2626; font-size: 0.875rem; font-weight: 600; font-family: inherit;
            cursor: pointer; transition: all 0.15s;
        }
        .btn-logout:hover { background: #fee2e2; border-color: #ef4444; }

        /* ─── Main Content ─── */
        .main-content { margin-left: 260px; min-height: 100vh; }
        .topbar {
            background: white; border-bottom: 1px solid #e8e8f0;
            padding: 0 2rem; height: 68px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 10;
        }
        .topbar-left h1 { font-size: 1.1rem; font-weight: 700; color: #1a1a2e; }
        .topbar-left p { font-size: 0.825rem; color: #6b7280; }
        .topbar-badge {
            display: inline-flex; align-items: center; gap: 5px;
            background: rgba(79,70,229,0.08); color: #4f46e5;
            font-size: 0.75rem; font-weight: 600;
            padding: 5px 12px; border-radius: 100px;
            border: 1px solid rgba(79,70,229,0.2);
        }

        .content { padding: 2rem; }

        /* Alert success */
        .alert-success {
            background: #f0fdf4; border: 1px solid #86efac; border-radius: 12px;
            padding: 1rem 1.25rem; margin-bottom: 1.5rem;
            font-size: 0.875rem; color: #15803d;
            display: flex; align-items: center; gap: 0.625rem;
        }

        /* ─── Welcome Banner ─── */
        .welcome-banner {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #9333ea 100%);
            border-radius: 20px; padding: 2rem 2.5rem; color: white;
            margin-bottom: 2rem; position: relative; overflow: hidden;
            display: flex; align-items: center; justify-content: space-between; gap: 1rem;
        }
        .welcome-banner::before {
            content: ''; position: absolute; top: -50px; right: -50px;
            width: 200px; height: 200px; background: rgba(255,255,255,0.08); border-radius: 50%;
        }
        .welcome-banner::after {
            content: ''; position: absolute; bottom: -80px; right: 80px;
            width: 250px; height: 250px; background: rgba(255,255,255,0.05); border-radius: 50%;
        }
        .welcome-text h2 { font-size: 1.4rem; font-weight: 700; margin-bottom: 0.375rem; }
        .welcome-text p { font-size: 0.875rem; opacity: 0.85; }
        .welcome-badge {
            background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3);
            padding: 0.5rem 1rem; border-radius: 10px;
            font-size: 0.875rem; font-weight: 600; white-space: nowrap;
            position: relative; z-index: 1;
        }

        /* ─── Stats Grid ─── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: white; border-radius: 16px; padding: 1.5rem;
            border: 1px solid #f0f0f8;
            box-shadow: 0 1px 10px rgba(79,70,229,0.06);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 4px 20px rgba(79,70,229,0.1); }
        .stat-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; }
        .stat-icon {
            width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center; font-size: 1.4rem;
        }
        .stat-icon.purple { background: #f0f0ff; }
        .stat-icon.green  { background: #f0fdf4; }
        .stat-icon.orange { background: #fff7ed; }
        .stat-icon.red    { background: #fef2f2; }
        .stat-icon.blue   { background: #eff6ff; }
        .stat-icon.teal   { background: #f0fdfa; }
        .stat-value { font-size: 1.75rem; font-weight: 700; color: #1a1a2e; line-height: 1; }
        .stat-label { font-size: 0.8rem; color: #6b7280; margin-top: 4px; }
        .stat-sub { font-size: 0.78rem; color: #9ca3af; margin-top: 2px; }

        /* ─── Grid 2 kolom ─── */
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem; }

        /* ─── Card ─── */
        .card {
            background: white; border-radius: 16px; padding: 1.5rem;
            border: 1px solid #f0f0f8;
            box-shadow: 0 1px 10px rgba(79,70,229,0.06);
        }
        .card-title {
            font-size: 0.95rem; font-weight: 700; color: #1a1a2e;
            margin-bottom: 1.25rem; padding-bottom: 0.875rem;
            border-bottom: 1px solid #f5f5ff;
            display: flex; align-items: center; gap: 0.5rem;
        }

        /* ─── Tabel Donasi ─── */
        .table-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
        th {
            text-align: left; padding: 0.6rem 0.875rem;
            font-size: 0.75rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.04em; color: #9ca3af;
            border-bottom: 2px solid #f0f0f8;
        }
        td { padding: 0.75rem 0.875rem; border-bottom: 1px solid #f9f9ff; color: #374151; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #fafaff; }

        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 10px; border-radius: 100px;
            font-size: 0.72rem; font-weight: 600;
        }
        .badge-paid    { background: #f0fdf4; color: #16a34a; }
        .badge-pending { background: #fefce8; color: #ca8a04; }
        .badge-failed  { background: #fef2f2; color: #dc2626; }
        .badge-cancel  { background: #f9fafb; color: #6b7280; }

        /* ─── Program List ─── */
        .program-item {
            display: flex; align-items: center; justify-content: space-between;
            padding: 0.75rem 0; border-bottom: 1px solid #f5f5ff;
        }
        .program-item:last-child { border-bottom: none; }
        .program-name { font-size: 0.875rem; font-weight: 600; color: #1a1a2e; }
        .program-count { font-size: 0.78rem; color: #9ca3af; }
        .program-amount { font-size: 0.875rem; font-weight: 700; color: #4f46e5; }

        /* ─── Info Akun ─── */
        .info-item {
            display: flex; justify-content: space-between; align-items: center;
            padding: 0.625rem 0; border-bottom: 1px solid #f9f9ff; font-size: 0.875rem;
        }
        .info-item:last-child { border-bottom: none; }
        .info-key { color: #6b7280; }
        .info-val { font-weight: 600; color: #1a1a2e; text-align: right; }

        /* ─── Empty state ─── */
        .empty-state {
            text-align: center; padding: 2.5rem 1rem;
            color: #9ca3af; font-size: 0.875rem;
        }
        .empty-state .empty-icon { font-size: 2.5rem; margin-bottom: 0.75rem; }

        /* Responsive */
        @media (max-width: 1024px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .main-content { margin-left: 0; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .grid-2 { grid-template-columns: 1fr; }
            .welcome-badge { display: none; }
        }
        @media (max-width: 480px) {
            .stats-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    {{-- ─────────── Sidebar ─────────── --}}
    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="sidebar-logo-icon">🧠</div>
            PeduliJiwa
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-title">Menu Petugas</div>
            <div class="nav-item active">
                <span class="nav-item-icon">🏠</span>
                Dashboard
            </div>
            <a href="{{ route('donation.form') }}" class="nav-item">
                <span class="nav-item-icon">❤️</span>
                Form Donasi Publik
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
                    <div class="user-role">🏥 Petugas Rehabilitasi</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    🚪 Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- ─────────── Main Content ─────────── --}}
    <div class="main-content">

        {{-- Topbar --}}
        <header class="topbar">
            <div class="topbar-left">
                <h1>Dashboard Petugas Rehabilitasi</h1>
                <p>{{ now()->locale('id')->translatedFormat('l, d F Y') }}</p>
            </div>
            <div class="topbar-badge">
                👮 {{ $user->jabatan ?? 'Petugas Rehabilitasi' }}
            </div>
        </header>

        <div class="content">

            {{-- Alert sukses --}}
            @if (session('success'))
                <div class="alert-success">
                    ✅ {{ session('success') }}
                </div>
            @endif

            {{-- Welcome Banner --}}
            <div class="welcome-banner">
                <div class="welcome-text" style="position:relative;z-index:1;">
                    <h2>Selamat datang, {{ $user->name }}! 👋</h2>
                    <p>Berikut ringkasan data donasi dan aktivitas terkini sistem PeduliJiwa.</p>
                </div>
                <div class="welcome-badge">🏥 Petugas Rehabilitasi</div>
            </div>

            {{-- ─── Stats Cards ─── --}}
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-value">{{ number_format($stats['total_donasi']) }}</div>
                            <div class="stat-label">Total Semua Donasi</div>
                        </div>
                        <div class="stat-icon purple">📋</div>
                    </div>
                    <div class="stat-sub">Seluruh transaksi masuk</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-value">{{ number_format($stats['donasi_sukses']) }}</div>
                            <div class="stat-label">Donasi Berhasil</div>
                        </div>
                        <div class="stat-icon green">✅</div>
                    </div>
                    <div class="stat-sub">Status: paid / lunas</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-value">{{ number_format($stats['donasi_pending']) }}</div>
                            <div class="stat-label">Donasi Pending</div>
                        </div>
                        <div class="stat-icon orange">⏳</div>
                    </div>
                    <div class="stat-sub">Menunggu pembayaran</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-value" style="font-size:1.3rem;">Rp {{ number_format($stats['total_terkumpul'], 0, ',', '.') }}</div>
                            <div class="stat-label">Total Dana Terkumpul</div>
                        </div>
                        <div class="stat-icon teal">💰</div>
                    </div>
                    <div class="stat-sub">Dari donasi berhasil</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-value" style="font-size:1.3rem;">Rp {{ number_format($stats['donasi_bulan_ini'], 0, ',', '.') }}</div>
                            <div class="stat-label">Dana Bulan Ini</div>
                        </div>
                        <div class="stat-icon blue">📅</div>
                    </div>
                    <div class="stat-sub">{{ now()->locale('id')->translatedFormat('F Y') }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-value">{{ number_format($stats['total_petugas']) }}</div>
                            <div class="stat-label">Total Petugas Aktif</div>
                        </div>
                        <div class="stat-icon red">👮</div>
                    </div>
                    <div class="stat-sub">Pegawai rehabilitasi</div>
                </div>
            </div>

            {{-- ─── Grid 2 Kolom ─── --}}
            <div class="grid-2">

                {{-- Donasi per Program --}}
                <div class="card">
                    <div class="card-title">📊 Rekap Donasi Per Program</div>
                    @if ($donasi_per_program->isEmpty())
                        <div class="empty-state">
                            <div class="empty-icon">📭</div>
                            <p>Belum ada data donasi berhasil.</p>
                        </div>
                    @else
                        @foreach ($donasi_per_program as $item)
                            <div class="program-item">
                                <div>
                                    <div class="program-name">{{ $item->program }}</div>
                                    <div class="program-count">{{ $item->total }} donatur</div>
                                </div>
                                <div class="program-amount">Rp {{ number_format($item->total_amount, 0, ',', '.') }}</div>
                            </div>
                        @endforeach
                    @endif
                </div>

                {{-- Info Akun Petugas --}}
                <div class="card">
                    <div class="card-title">👤 Informasi Akun Saya</div>
                    <div class="info-item">
                        <span class="info-key">Nama Lengkap</span>
                        <span class="info-val">{{ $user->name }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-key">Email</span>
                        <span class="info-val">{{ $user->email }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-key">Jabatan</span>
                        <span class="info-val">{{ $user->jabatan ?? '-' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-key">No. HP</span>
                        <span class="info-val">{{ $user->no_hp ?? '-' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-key">Role</span>
                        <span class="info-val" style="color:#4f46e5;">🏥 Petugas Rehabilitasi</span>
                    </div>
                    <div class="info-item">
                        <span class="info-key">Status Akun</span>
                        <span class="info-val" style="color:#16a34a;">✅ Aktif</span>
                    </div>
                    <div class="info-item">
                        <span class="info-key">Bergabung</span>
                        <span class="info-val">{{ $user->created_at->locale('id')->translatedFormat('d F Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- ─── Tabel Donasi Terbaru ─── --}}
            <div class="card">
                <div class="card-title">🕐 Donasi Terbaru</div>
                @if ($donasi_terbaru->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">📭</div>
                        <p>Belum ada data donasi.</p>
                    </div>
                @else
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Donatur</th>
                                    <th>Program</th>
                                    <th>Nominal</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($donasi_terbaru as $index => $donasi)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div style="font-weight:600;">{{ $donasi->donor_name }}</div>
                                            <div style="font-size:0.78rem;color:#9ca3af;">{{ $donasi->donor_email }}</div>
                                        </td>
                                        <td>{{ $donasi->program }}</td>
                                        <td style="font-weight:700;color:#4f46e5;">{{ $donasi->formatted_amount }}</td>
                                        <td>
                                            @if ($donasi->status === 'paid')
                                                <span class="badge badge-paid">✅ Berhasil</span>
                                            @elseif ($donasi->status === 'pending')
                                                <span class="badge badge-pending">⏳ Pending</span>
                                            @elseif ($donasi->status === 'failed')
                                                <span class="badge badge-failed">❌ Gagal</span>
                                            @else
                                                <span class="badge badge-cancel">🚫 {{ ucfirst($donasi->status) }}</span>
                                            @endif
                                        </td>
                                        <td style="color:#9ca3af;font-size:0.8rem;">
                                            {{ $donasi->created_at->locale('id')->translatedFormat('d M Y, H:i') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>

</body>
</html>
