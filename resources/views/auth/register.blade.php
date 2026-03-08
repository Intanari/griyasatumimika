<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun Petugas - PeduliJiwa</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    <style>
        :root { --primary: #3b82f6; --primary-dark: #2563eb; --accent: #0ea5e9; }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
            color: #0f172a;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 50%, #e0f2fe 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        a { text-decoration: none; color: inherit; }

        /* Navbar */
        .navbar {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid #e8e8f0;
            padding: 0 1.5rem;
        }
        .nav-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 68px;
        }
        .nav-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--primary-dark);
        }
        .nav-logo-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
            box-shadow: 0 4px 14px rgba(59,130,246,0.35);
        }
        .nav-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(59,130,246,0.1);
            color: var(--primary-dark);
            font-size: 0.75rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 100px;
            border: 1px solid rgba(59,130,246,0.2);
        }

        /* Main */
        .main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 1.5rem;
            position: relative;
        }
        .main::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(59,130,246,0.08) 0%, transparent 70%);
            border-radius: 50%;
        }

        /* Card */
        .register-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 40px rgba(59,130,246,0.12);
            width: 100%;
            max-width: 560px;
            position: relative;
            z-index: 1;
            overflow: hidden;
        }
        .card-top-banner {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            padding: 2rem 2.5rem;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .card-top-banner::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 150px;
            height: 150px;
            background: rgba(255,255,255,0.08);
            border-radius: 50%;
        }
        .card-top-banner::after {
            content: '';
            position: absolute;
            bottom: -60px;
            right: 60px;
            width: 180px;
            height: 180px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }
        .banner-icon { font-size: 2.5rem; margin-bottom: 0.75rem; position: relative; z-index: 1; }
        .banner-title { font-size: 1.5rem; font-weight: 700; margin-bottom: 0.375rem; position: relative; z-index: 1; }
        .banner-sub { font-size: 0.875rem; opacity: 0.85; position: relative; z-index: 1; }
        .banner-role-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 100px;
            margin-top: 0.75rem;
            position: relative;
            z-index: 1;
        }

        /* Form body */
        .card-body { padding: 2rem 2.5rem; }

        /* Alert */
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 0.875rem 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
            color: #dc2626;
        }

        /* Field groups */
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .form-group { margin-bottom: 1.125rem; }
        .form-label {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.45rem;
        }
        .label-required { color: #ef4444; font-size: 0.75rem; }
        .label-optional {
            font-size: 0.7rem;
            font-weight: 500;
            color: #9ca3af;
            background: #f3f4f6;
            padding: 1px 6px;
            border-radius: 4px;
        }
        .form-input {
            width: 100%;
            padding: 0.7rem 1rem;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            font-size: 0.9rem;
            font-family: inherit;
            color: #1a1a2e;
            background: #f9fafb;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            outline: none;
        }
        .form-input:focus { border-color: var(--primary); background: white; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
        .form-input.is-invalid { border-color: #ef4444; background: #fef2f2; }
        .form-input.is-invalid:focus { border-color: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,0.1); }
        .invalid-feedback { font-size: 0.78rem; color: #dc2626; margin-top: 0.3rem; }
        .form-hint { font-size: 0.78rem; color: #9ca3af; margin-top: 0.3rem; }

        /* Section divider */
        .section-divider {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 1.25rem 0 1rem;
        }
        .section-divider-line { flex: 1; height: 1px; background: #f0f0f8; }
        .section-divider-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #9ca3af;
            white-space: nowrap;
        }

        /* Submit button */
        .btn-submit {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 1rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.1s;
            box-shadow: 0 4px 15px rgba(59,130,246,0.35);
            margin-top: 1.5rem;
            margin-bottom: 1.25rem;
        }
        .btn-submit:hover { opacity: 0.9; }
        .btn-submit:active { transform: scale(0.98); }

        .login-link { text-align: center; font-size: 0.875rem; color: #6b7280; }
        .login-link a { color: var(--primary-dark); font-weight: 600; }
        .login-link a:hover { text-decoration: underline; }

        /* Info box */
        .info-box {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 10px;
            padding: 0.875rem 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.825rem;
            color: #0369a1;
            line-height: 1.6;
        }

        footer { text-align: center; padding: 1.5rem; font-size: 0.8rem; color: #9ca3af; }

        @media (max-width: 560px) {
            .navbar { padding: 0 1rem; }
            .nav-inner { height: 60px; }
            .main { padding: 2rem 1rem; }
            .card-body { padding: 1.5rem; }
            .card-top-banner { padding: 1.5rem; }
            .banner-title { font-size: 1.25rem; }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-inner">
            <a href="{{ route('welcome') }}" class="nav-logo">
                <div class="nav-logo-icon">🧠</div>
                PeduliJiwa
            </a>
            <span class="nav-badge">🔒 Area Petugas</span>
        </div>
    </nav>

    <main class="main">
        <div class="register-card">
            <!-- Banner atas -->
            <div class="card-top-banner">
                <div class="banner-icon">👮</div>
                <div class="banner-title">Pendaftaran Akun Petugas</div>
                <div class="banner-sub">Formulir ini khusus untuk tenaga rehabilitasi PeduliJiwa</div>
                <div class="banner-role-badge">🏥 Pegawai Rehabilitasi</div>
            </div>

            <div class="card-body">
                <div class="info-box">
                    ℹ️ <strong>Perhatian:</strong> Halaman ini hanya untuk pendaftaran akun <strong>Petugas / Pegawai Rehabilitasi</strong>. Pastikan data yang diisi sesuai dengan data resmi kepegawaian Anda.
                </div>

                @if ($errors->any())
                    <div class="alert-error">
                        ⚠️ Terdapat kesalahan pada formulir. Silakan periksa kembali data yang diisi.
                    </div>
                @endif

                <form method="POST" action="{{ route('register.post') }}">
                    @csrf

                    <!-- Info Pribadi -->
                    <div class="section-divider">
                        <div class="section-divider-line"></div>
                        <span class="section-divider-label">Data Pribadi</span>
                        <div class="section-divider-line"></div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="form-label">
                            Nama Lengkap
                            <span class="label-required">*</span>
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                            value="{{ old('name') }}"
                            placeholder="Nama lengkap sesuai KTP"
                            autofocus
                        >
                        @error('name')
                            <p class="invalid-feedback">⚠ {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email" class="form-label">
                                Email
                                <span class="label-required">*</span>
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                value="{{ old('email') }}"
                                placeholder="nama@email.com"
                            >
                            @error('email')
                                <p class="invalid-feedback">⚠ {{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="no_hp" class="form-label">
                                No. HP
                                <span class="label-optional">opsional</span>
                            </label>
                            <input
                                type="tel"
                                id="no_hp"
                                name="no_hp"
                                class="form-input {{ $errors->has('no_hp') ? 'is-invalid' : '' }}"
                                value="{{ old('no_hp') }}"
                                placeholder="08xxxxxxxxxx"
                            >
                            @error('no_hp')
                                <p class="invalid-feedback">⚠ {{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                     <!-- Info Kepegawaian -->
                     <div class="section-divider">
                        <div class="section-divider-line"></div>
                        <span class="section-divider-label">Data Kepegawaian</span>
                        <div class="section-divider-line"></div>
                    </div>

                    <div class="form-group">
                        <label for="jabatan" class="form-label">
                            Jabatan
                            <span class="label-required">*</span>
                        </label>
                        <input
                            type="text"
                            id="jabatan"
                            name="jabatan"
                            class="form-input {{ $errors->has('jabatan') ? 'is-invalid' : '' }}"
                            value="{{ old('jabatan') }}"
                            placeholder="cth: Perawat, Konselor, Psikolog"
                        >
                        @error('jabatan')
                            <p class="invalid-feedback">⚠ {{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Keamanan Akun -->
                    <div class="section-divider">
                        <div class="section-divider-line"></div>
                        <span class="section-divider-label">Keamanan Akun</span>
                        <div class="section-divider-line"></div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">
                            Kata Sandi
                            <span class="label-required">*</span>
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                            placeholder="Minimal 8 karakter"
                            autocomplete="new-password"
                        >
                        <p class="form-hint">Gunakan minimal 8 karakter dengan kombinasi huruf dan angka</p>
                        @error('password')
                            <p class="invalid-feedback">⚠ {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">
                            Konfirmasi Kata Sandi
                            <span class="label-required">*</span>
                        </label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-input"
                            placeholder="Ulangi kata sandi"
                            autocomplete="new-password"
                        >
                    </div>

                    <button type="submit" class="btn-submit">
                        👮 Daftarkan Akun Petugas
                    </button>
                </form>

                <p class="login-link">
                    Sudah punya akun petugas?
                    <a href="{{ route('login') }}">Masuk di sini</a>
                </p>
            </div>
        </div>
    </main>

    <footer>
        &copy; {{ date('Y') }} PeduliJiwa &mdash; Akses Terbatas untuk Petugas Rehabilitasi
    </footer>
</body>
</html>
