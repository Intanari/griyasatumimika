@extends('layouts.dashboard')

@section('title', 'Tambah Akun')
@section('topbar-title', 'Tambah Akun Petugas')

@section('content')
<a href="{{ route('dashboard.admin-users.index') }}" class="page-back-link">Kembali ke Daftar Akun</a>

<div class="card admin-account-form-card">
    <div class="admin-account-form-header">
        <div class="admin-account-form-header-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <div>
            <h2 class="admin-account-form-title">Tambah Akun Petugas</h2>
            <p class="admin-account-form-subtitle">Buat akun baru untuk petugas. Isi data profil, password, dan role.</p>
            @if(isset($isSuperAdmin) && $isSuperAdmin)
                <span class="admin-account-badge-super">Super Admin</span>
            @endif
        </div>
    </div>

    <form action="{{ route('dashboard.admin-users.store') }}" method="POST" class="admin-account-form">
        @csrf

        {{-- 1. Data Profil --}}
        <div class="admin-account-section">
            <h3 class="admin-account-section-title">
                <span class="admin-account-section-icon">👤</span>
                Data Profil
            </h3>
            <p class="admin-account-section-desc">Nama lengkap dan email untuk login.</p>
            <div class="form-row">
                <div class="form-group">
                    <label for="name">Nama Lengkap <span class="required">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required maxlength="255" placeholder="Nama lengkap petugas">
                    @error('name')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required maxlength="255" placeholder="email@contoh.com">
                    @error('email')<span class="form-error">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        {{-- 2. Buat Password --}}
        <div class="admin-account-section">
            <h3 class="admin-account-section-title">
                <span class="admin-account-section-icon">🔐</span>
                Buat Password
            </h3>
            <p class="admin-account-section-desc">Password untuk login pertama kali. Minimal 8 karakter.</p>
            <div class="form-group">
                <label for="password">Password <span class="required">*</span></label>
                <input type="password" id="password" name="password" required minlength="8" placeholder="Minimal 8 karakter">
                @error('password')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password <span class="required">*</span></label>
                <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8" placeholder="Ulangi password yang sama">
            </div>
        </div>

        {{-- 3. Ubah Role --}}
        <div class="admin-account-section">
            <h3 class="admin-account-section-title">
                <span class="admin-account-section-icon">⚙️</span>
                Role
            </h3>
            <p class="admin-account-section-desc">Hak akses pengguna dalam sistem.</p>
            <div class="form-group">
                <label for="role">Role <span class="required">*</span></label>
                <select id="role" name="role" required>
                    <option value="{{ \App\Models\User::ROLE_PETUGAS }}" {{ old('role', isset($isSuperAdmin) && !$isSuperAdmin ? \App\Models\User::ROLE_PETUGAS : null) === \App\Models\User::ROLE_PETUGAS ? 'selected' : '' }}>Petugas User</option>
                    @if(isset($isSuperAdmin) && $isSuperAdmin)
                        <option value="{{ \App\Models\User::ROLE_ADMIN }}" {{ old('role') === \App\Models\User::ROLE_ADMIN ? 'selected' : '' }}>Petugas Admin</option>
                    @endif
                </select>
                @error('role')<span class="form-error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan Akun</button>
            <a href="{{ route('dashboard.admin-users.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>

@push('styles')
<style>
.admin-account-form-card { max-width: 640px; overflow: hidden; }
.admin-account-form-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem 1.75rem;
    border-bottom: 1px solid var(--border);
    background: #f8fafc;
}
.admin-account-form-header-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: linear-gradient(135deg, #eff6ff, #dbeafe);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
}
.admin-account-form-title { font-size: 1.1rem; font-weight: 700; color: var(--text); margin: 0 0 2px; }
.admin-account-form-subtitle { font-size: 0.82rem; color: var(--text-muted); margin: 0.25rem 0 0 0; }
.admin-account-badge-super {
    display: inline-block;
    padding: 4px 10px;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    border-radius: 8px;
    background: linear-gradient(135deg, rgba(139,92,246,0.2), rgba(168,85,247,0.15));
    color: #7c3aed;
    border: 1px solid rgba(124,58,237,0.3);
    margin-top: 0.5rem;
}
.admin-account-form { padding: 1.5rem 1.75rem; }
.admin-account-section {
    margin-bottom: 2rem;
    padding: 1.25rem 1.35rem;
    background: #f8fafc;
    border-radius: 12px;
    border: 1px solid var(--border);
}
.admin-account-section:last-of-type { margin-bottom: 0; }
.admin-account-section-title {
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.admin-account-section-icon { font-size: 1.1rem; }
.admin-account-section-desc {
    font-size: 0.8rem;
    color: var(--text-muted);
    margin-bottom: 1rem;
}
.admin-account-form .form-group {
    margin-bottom: 1.1rem;
}
.admin-account-form .form-group:last-child { margin-bottom: 0; }
.admin-account-form .form-group label {
    display: block;
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 0.45rem;
}
.admin-account-form .form-group .required { color: #dc2626; }
.admin-account-form .form-group input,
.admin-account-form .form-group select {
    width: 100%;
    padding: 0.55rem 0.875rem;
    font-size: 0.9rem;
    font-family: inherit;
    color: var(--text);
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 10px;
}
.admin-account-form .form-group input:focus,
.admin-account-form .form-group select:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(37,99,235,0.12);
}
.admin-account-form .form-group select {
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.9rem center;
    padding-right: 2.25rem;
}
.admin-account-form .form-error {
    display: block;
    font-size: 0.8rem;
    color: #dc2626;
    margin-top: 0.35rem;
}
.admin-account-form .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.1rem;
}
.admin-account-form .form-actions {
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--border);
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}
.admin-account-form .form-actions .btn { padding: 0.65rem 1.35rem; font-size: 0.9rem; }
@media (max-width: 600px) {
    .admin-account-form .form-row { grid-template-columns: 1fr; }
}
</style>
@endpush
@endsection

