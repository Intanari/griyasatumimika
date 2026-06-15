<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Atur Ulang Kata Sandi - Area Petugas PeduliJiwa</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    @include('auth.partials.guest-styles')
    @include('partials.yayasan-logo-styles')
</head>
<body>
    <nav class="navbar">
        <div class="nav-inner">
            <a href="{{ route('welcome') }}" class="nav-logo">
                <x-yayasan-logo variant="auth" />
            </a>
            <span class="nav-badge">🔒 <span class="badge-label">Area Petugas</span></span>
        </div>
    </nav>

    <main class="main">
        <div class="main-wrap">
            <div class="login-card">
                <div class="card-header">
                    <div class="card-icon">🔐</div>
                    <h1 class="card-title">Kata Sandi Baru</h1>
                    <p class="card-subtitle">Buat kata sandi baru untuk akun Anda. Minimal 8 karakter.</p>
                </div>

                @if ($errors->any())
                    <div class="alert-error">
                        <span class="alert-error-icon">⚠️</span>
                        <span class="alert-error-text">{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                            value="{{ old('email', $email) }}"
                            placeholder="nama@email.com"
                            autofocus
                            autocomplete="email"
                            required
                        >
                        @error('email')
                            <p class="invalid-feedback">⚠ {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Kata Sandi Baru</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                            placeholder="••••••••"
                            autocomplete="new-password"
                            required
                        >
                        @error('password')
                            <p class="invalid-feedback">⚠ {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-input"
                            placeholder="••••••••"
                            autocomplete="new-password"
                            required
                        >
                    </div>

                    <button type="submit" class="btn-login">
                        Simpan Kata Sandi Baru
                    </button>

                    <a href="{{ route('login') }}" class="btn-secondary">
                        Kembali ke Login
                    </a>
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
