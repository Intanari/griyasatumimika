@extends('layouts.dashboard')

@section('title', 'Tambah Akun')
@section('topbar-title', 'Tambah Akun Petugas')

@section('content')
<a href="{{ route('dashboard.admin-users.index') }}" class="page-back-link">Kembali</a>

<div class="card admin-account-form-card" style="max-width: 560px;">
    <div class="admin-account-form-card-title">
        <span>Form Tambah Akun Petugas</span>
        @if(isset($isSuperAdmin) && $isSuperAdmin)
            <span class="admin-account-badge-super">Super Admin</span>
        @endif
    </div>

    <form action="{{ route('dashboard.admin-users.store') }}" method="POST" class="admin-account-form">
        @csrf

        <div class="form-section">
            <div class="form-section-title">Data Profil</div>
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

        <div class="form-section">
            <div class="form-section-title">Password</div>
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

        <div class="form-section">
            <div class="form-section-title">Role</div>
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
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('dashboard.admin-users.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>

<style>
/* Card & layout */
.admin-account-form-card {
    box-shadow: 0 4px 24px rgba(15,23,42,0.06);
    border-radius: 16px;
    padding: 1.75rem 2rem;
}
.admin-account-form-card .admin-account-form-card-title,
.admin-account-form-card .card-title {
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    font-size: 1.05rem;
    font-weight: 700;
    letter-spacing: -0.02em;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 0.65rem;
    flex-wrap: wrap;
}
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
}
[data-theme="dark"] .admin-account-badge-super {
    background: rgba(139,92,246,0.25);
    color: #a78bfa;
    border-color: rgba(167,139,250,0.4);
}
/* Sections */
.admin-account-form .form-section {
    margin-bottom: 1.75rem;
    padding: 1.25rem 1.35rem;
    background: rgba(0,0,0,0.02);
    border-radius: 12px;
    border: 1px solid var(--border);
}
[data-theme="dark"] .admin-account-form .form-section {
    background: rgba(255,255,255,0.03);
}
.admin-account-form .form-section:last-of-type { margin-bottom: 0; }
.admin-account-form .form-section-title {
    font-size: 0.72rem;
    font-weight: 700;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid var(--border);
}
/* Form groups */
.admin-account-form .form-group {
    margin-bottom: 1.1rem;
}
.admin-account-form .form-group:last-child { margin-bottom: 0; }
.admin-account-form .form-group label {
    display: block;
    font-size: 0.8125rem;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 0.45rem;
}
.admin-account-form .form-group .required { color: #dc2626; }
.admin-account-form .form-group input,
.admin-account-form .form-group select {
    width: 100%;
    padding: 0.65rem 0.95rem;
    font-size: 0.9rem;
    font-family: inherit;
    color: var(--text);
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 10px;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.admin-account-form .form-group input::placeholder {
    color: var(--text-muted);
    opacity: 0.8;
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
/* Form row (Nama | Email) */
.admin-account-form .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.1rem;
}
@media (max-width: 600px) {
    .admin-account-form .form-row { grid-template-columns: 1fr; }
}
/* Actions */
.admin-account-form .form-actions {
    margin-top: 1.75rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--border);
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}
.admin-account-form .form-actions .btn { padding: 0.65rem 1.35rem; font-size: 0.9rem; }
</style>
@endsection

