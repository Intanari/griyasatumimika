<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - PeduliJiwa</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; height: 100%; }
        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            color: #1a1a2e;
            background: linear-gradient(160deg, #f0f0ff 0%, #fdf4ff 50%, #fff7f0 100%);
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
            gap: 10px;
            font-size: 1.25rem;
            font-weight: 700;
            color: #4f46e5;
        }
        .nav-logo-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
        }
        .nav-back {
            font-size: 0.875rem;
            font-weight: 500;
            color: #4a4a6a;
            transition: color 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .nav-back:hover { color: #4f46e5; }

        /* Main Content */
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
            background: radial-gradient(circle, rgba(79,70,229,0.08) 0%, transparent 70%);
            border-radius: 50%;
        }
        .main::after {
            content: '';
            position: absolute;
            bottom: -100px;
            left: -100px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(124,58,237,0.06) 0%, transparent 70%);
            border-radius: 50%;
        }

        /* Login Card */
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 40px rgba(79,70,229,0.12);
            padding: 3rem 2.5rem;
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 1;
        }
        .card-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .card-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            font-size: 1.75rem;
            box-shadow: 0 4px 20px rgba(79,70,229,0.35);
        }
        .card-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 0.5rem;
        }
        .card-subtitle {
            font-size: 0.9rem;
            color: #6b7280;
        }

        /* Alert Error */
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 0.875rem 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 0.625rem;
        }
        .alert-error-icon { font-size: 1rem; color: #ef4444; flex-shrink: 0; margin-top: 1px; }
        .alert-error-text { font-size: 0.875rem; color: #dc2626; line-height: 1.5; }

        /* Form */
        .form-group { margin-bottom: 1.25rem; }
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            font-size: 0.925rem;
            font-family: inherit;
            color: #1a1a2e;
            background: #f9fafb;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            outline: none;
        }
        .form-input:focus {
            border-color: #4f46e5;
            background: white;
            box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
        }
        .form-input.is-invalid {
            border-color: #ef4444;
            background: #fef2f2;
        }
        .form-input.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(239,68,68,0.1);
        }
        .invalid-feedback {
            font-size: 0.8rem;
            color: #dc2626;
            margin-top: 0.375rem;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Remember & Forgot */
        .form-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        .remember-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }
        .remember-checkbox {
            width: 16px;
            height: 16px;
            accent-color: #4f46e5;
            cursor: pointer;
        }
        .remember-label {
            font-size: 0.875rem;
            color: #4a4a6a;
            cursor: pointer;
            user-select: none;
        }
        .forgot-link {
            font-size: 0.875rem;
            font-weight: 600;
            color: #4f46e5;
            transition: color 0.2s;
        }
        .forgot-link:hover { color: #7c3aed; text-decoration: underline; }

        /* Button */
        .btn-login {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 1rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.1s;
            box-shadow: 0 4px 15px rgba(79,70,229,0.35);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-login:hover { opacity: 0.9; }
        .btn-login:active { transform: scale(0.98); }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .divider-line {
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }
        .divider-text {
            font-size: 0.8rem;
            color: #9ca3af;
            white-space: nowrap;
        }

        /* Register Link */
        .register-link {
            text-align: center;
            font-size: 0.875rem;
            color: #6b7280;
        }
        .register-link a {
            color: #4f46e5;
            font-weight: 600;
            transition: color 0.2s;
        }
        .register-link a:hover { color: #7c3aed; text-decoration: underline; }

        /* Footer */
        footer {
            text-align: center;
            padding: 1.5rem;
            font-size: 0.8rem;
            color: #9ca3af;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-card { padding: 2rem 1.5rem; }
            .card-title { font-size: 1.5rem; }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-inner">
            <a href="{{ route('welcome') }}" class="nav-logo">
                <div class="nav-logo-icon">🧠</div>
                PeduliJiwa
            </a>
            <a href="{{ route('welcome') }}" class="nav-back">
                ← Kembali ke Beranda
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main">
        <div class="login-card">
            <div class="card-header">
                <div class="card-icon">🔐</div>
                <h1 class="card-title">Selamat Datang</h1>
                <p class="card-subtitle">Masuk ke akun PeduliJiwa Anda</p>
            </div>

            {{-- Alert error global --}}
            @if ($errors->any() && !$errors->has('email') && !$errors->has('password'))
                <div class="alert-error">
                    <span class="alert-error-icon">⚠️</span>
                    <span class="alert-error-text">{{ $errors->first() }}</span>
                </div>
            @endif

            {{-- Session status --}}
            @if (session('status'))
                <div class="alert-error" style="background:#f0fdf4;border-color:#86efac;">
                    <span class="alert-error-icon">✅</span>
                    <span class="alert-error-text" style="color:#15803d;">{{ session('status') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                {{-- Email --}}
                <div class="form-group">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                        value="{{ old('email') }}"
                        placeholder="nama@email.com"
                        autofocus
                        autocomplete="email"
                    >
                    @error('email')
                        <p class="invalid-feedback">⚠ {{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                        placeholder="••••••••"
                        autocomplete="current-password"
                    >
                    @error('password')
                        <p class="invalid-feedback">⚠ {{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember & Forgot --}}
                <div class="form-footer">
                    <label class="remember-group">
                        <input
                            type="checkbox"
                            name="remember"
                            class="remember-checkbox"
                            {{ old('remember') ? 'checked' : '' }}
                        >
                        <span class="remember-label">Ingat saya</span>
                    </label>
                    {{-- Uncomment jika sudah ada fitur forgot password
                    <a href="{{ route('password.request') }}" class="forgot-link">Lupa kata sandi?</a>
                    --}}
                </div>

                <button type="submit" class="btn-login">
                    🚀 Masuk Sekarang
                </button>
            </form>

            <div class="divider">
                <div class="divider-line"></div>
                <span class="divider-text">atau</span>
                <div class="divider-line"></div>
            </div>

            <p class="register-link">
                Belum punya akun?
                <a href="{{ route('register') }}">Daftar di sini</a>
            </p>
        </div>
    </main>

    <footer>
        &copy; {{ date('Y') }} PeduliJiwa. Bersama kita peduli sesama.
    </footer>
</body>
</html>
