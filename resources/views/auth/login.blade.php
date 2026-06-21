<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Masuk - Area Petugas PeduliJiwa</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    @include('auth.partials.guest-styles')
    @include('partials.yayasan-logo-styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-inner">
            <a href="{{ route('welcome') }}" class="nav-logo">
                <x-yayasan-logo variant="auth" />
            </a>
            <span class="nav-badge">🔒 <span class="badge-label">Area Petugas</span></span>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main">
        <div class="main-wrap">
        <div class="login-card">
            <div class="card-header">
                <div class="card-icon">👮</div>
                <h1 class="card-title">Masuk ke Dashboard</h1>
                <p class="card-subtitle">Akses khusus admin dan petugas rehabilitasi Yayasan Griya Satu Mimika</p>
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
                <div class="alert-success">
                    <span class="alert-success-icon">✅</span>
                    <span class="alert-success-text">{{ session('status') }}</span>
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
                    <a href="{{ route('password.request') }}" class="forgot-link">Lupa kata sandi?</a>
                </div>

                <button type="submit" class="btn-login">
                    Masuk ke Dashboard
                </button>
            </form>
        </div>
        </div>
    </main>

    <footer>
        &copy; {{ date('Y') }} PeduliJiwa — Akses Terbatas untuk Petugas Rehabilitasi
    </footer>
    @include('partials.password-toggle')
</body>
</html>
