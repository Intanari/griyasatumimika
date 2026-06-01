<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Kata Sandi - Area Petugas PeduliJiwa</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    @include('auth.partials.guest-styles')
</head>
<body>
    <nav class="navbar">
        <div class="nav-inner">
            <a href="{{ route('welcome') }}" class="nav-logo">
                <div class="nav-logo-icon">🧠</div>
                <span class="nav-logo-text">PeduliJiwa</span>
            </a>
            <span class="nav-badge">🔒 <span class="badge-label">Area Petugas</span></span>
        </div>
    </nav>

    <main class="main">
        <div class="main-wrap">
            <div class="login-card">
                <div class="card-header">
                    <div class="card-icon">🔑</div>
                    <h1 class="card-title">Lupa Kata Sandi</h1>
                    <p class="card-subtitle">Masukkan email akun Anda. Kami akan mengirim tautan untuk mengatur ulang kata sandi.</p>
                </div>

                @if (session('status'))
                    <div class="alert-success">
                        <span class="alert-success-icon">✅</span>
                        <span class="alert-success-text">{{ session('status') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert-error">
                        <span class="alert-error-icon">⚠️</span>
                        <span class="alert-error-text">{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

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
                            required
                        >
                        @error('email')
                            <p class="invalid-feedback">⚠ {{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn-login">
                        Kirim Tautan Reset
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
</body>
</html>
