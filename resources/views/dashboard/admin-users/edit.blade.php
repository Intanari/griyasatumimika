@extends('layouts.dashboard')

@section('title', 'Edit Akun')
@section('topbar-title', 'Edit Akun Petugas')

@section('content')
<a href="{{ route('dashboard.admin-users.index') }}" class="page-back-link">Kembali</a>

<div class="card admin-account-card">
    <div class="admin-account-header">
        <div class="admin-account-header-text">
            <div class="admin-account-title-row">
                <h2 class="admin-account-title">Edit Akun Petugas</h2>
                @if(isset($isSuperAdmin) && $isSuperAdmin)
                    <span class="admin-account-badge-super">Super Admin</span>
                @endif
            </div>
            <p class="admin-account-desc">
                Ubah data profil (nama, email), password, atau role untuk <strong>{{ $account->email }}</strong>.
            </p>
        </div>
        <a href="{{ route('dashboard.admin-users.index') }}" class="btn btn-outline btn-sm admin-account-btn-add">Kembali ke Daftar</a>
    </div>

    {{-- 1. Edit Profil (nama, email) --}}
    <div class="admin-account-edit-section">
        <h3 class="admin-account-edit-section-title">Edit Profil</h3>
        <form action="{{ route('dashboard.admin-users.update-profile', $account) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-row">
                <div class="form-group">
                    <label for="name">Nama Lengkap <span class="required">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $account->name) }}" required maxlength="255" placeholder="Nama lengkap petugas">
                    @error('name')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email', $account->email) }}" required maxlength="255" placeholder="email@contoh.com">
                    @error('email')<span class="form-error">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan Profil</button>
            </div>
        </form>
    </div>

    {{-- 2. Edit Password --}}
    <div class="admin-account-edit-section">
        <h3 class="admin-account-edit-section-title">Edit Password</h3>
        <form action="{{ route('dashboard.admin-users.update-password', $account) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="password">Password Baru <span class="required">*</span></label>
                <input type="password" id="password" name="password" required minlength="8" placeholder="Min. 8 karakter">
                @error('password')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password Baru <span class="required">*</span></label>
                <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8" placeholder="Ulangi password baru">
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Ubah Password</button>
            </div>
        </form>
    </div>

    {{-- 3. Edit Role (hanya jika punya akses) --}}
    <div class="admin-account-edit-section">
        <h3 class="admin-account-edit-section-title">Edit Role</h3>
        <form action="{{ route('dashboard.admin-users.update-role', $account) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="role">Role <span class="required">*</span></label>
                <select id="role" name="role" required>
                    <option value="{{ \App\Models\User::ROLE_PETUGAS }}" {{ old('role', $account->role) === \App\Models\User::ROLE_PETUGAS ? 'selected' : '' }}>Petugas User</option>
                    @if(isset($isSuperAdmin) && $isSuperAdmin)
                        <option value="{{ \App\Models\User::ROLE_ADMIN }}" {{ old('role', $account->role) === \App\Models\User::ROLE_ADMIN ? 'selected' : '' }}>Petugas Admin</option>
                    @endif
                </select>
                @error('role')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan Role</button>
            </div>
        </form>
    </div>
</div>
@endsection
