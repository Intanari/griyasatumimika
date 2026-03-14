@extends('layouts.dashboard')

@section('title', 'Manajemen Akun')
@section('topbar-title', 'Manajemen Akun')

@section('content')
<a href="{{ route('dashboard') }}" class="page-back-link">Kembali</a>

<div class="card admin-account-card">
    <div class="admin-account-header">
        <div class="admin-account-header-text">
            <div class="admin-account-title-row">
                <h2 class="admin-account-title">Manajemen Akun Petugas</h2>
                @if(isset($isSuperAdmin) && $isSuperAdmin)
                    <span class="admin-account-badge-super">Super Admin</span>
                @endif
            </div>
            <p class="admin-account-desc">
                @if(isset($isSuperAdmin) && $isSuperAdmin)
                    Kelola akun login petugas (email, password, role) untuk Petugas User dan Petugas Admin yang dapat mengakses dashboard.
                @else
                    Kelola akun login (email, password) untuk Petugas User yang dapat mengakses sistem rehabilitasi.
                @endif
            </p>
        </div>
        <a href="{{ route('dashboard.admin-users.create') }}" class="btn btn-primary btn-sm admin-account-btn-add">+ Tambah Akun</a>
    </div>

    <div class="admin-account-filters">
        <form action="{{ route('dashboard.admin-users.index') }}" method="GET" class="admin-account-filter-form">
            <div class="admin-account-filter-row">
                <div class="admin-account-filter-group admin-account-filter-search">
                    <label for="q">Cari</label>
                    <input
                        type="text"
                        id="q"
                        name="q"
                        value="{{ $search ?? '' }}"
                        placeholder="Cari nama atau email petugas"
                    >
                </div>

                @if(isset($isSuperAdmin) && $isSuperAdmin)
                    <div class="admin-account-filter-group admin-account-filter-role">
                        <label for="role">Role</label>
                        <select id="role" name="role">
                            <option value="">Semua role</option>
                            <option value="{{ \App\Models\User::ROLE_PETUGAS }}" {{ ($activeRoleFilter ?? '') === \App\Models\User::ROLE_PETUGAS ? 'selected' : '' }}>Petugas User</option>
                            <option value="{{ \App\Models\User::ROLE_ADMIN }}" {{ ($activeRoleFilter ?? '') === \App\Models\User::ROLE_ADMIN ? 'selected' : '' }}>Petugas Admin</option>
                        </select>
                    </div>
                @endif

                <div class="admin-account-filter-actions">
                    <button type="submit" class="btn btn-primary btn-sm">Terapkan</button>
                    @if(!empty($search) || !empty($activeRoleFilter))
                        <a href="{{ route('dashboard.admin-users.index') }}" class="btn btn-outline btn-sm">Reset</a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    @if ($accounts->isEmpty())
        <div class="admin-account-empty">
            <div class="admin-account-empty-icon">👥</div>
            <p class="admin-account-empty-text">Belum ada akun petugas.</p>
            <a href="{{ route('dashboard.admin-users.create') }}" class="btn btn-primary">+ Buat Akun Pertama</a>
        </div>
    @else
        <div class="admin-account-table-wrap">
            <table class="admin-account-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($accounts as $index => $account)
                        <tr>
                            <td class="admin-account-cell-num" data-label="No">{{ $accounts->firstItem() + $index }}</td>
                            <td class="admin-account-cell-name" data-label="Nama">{{ $account->name }}</td>
                            <td class="admin-account-cell-email" data-label="Email">{{ $account->email }}</td>
                            <td data-label="Role"><span class="admin-account-badge-role">{{ $account->role_label }}</span></td>
                            <td class="admin-account-cell-actions" data-label="Aksi">
                                <a href="{{ route('dashboard.admin-users.edit', $account) }}" class="btn btn-sm btn-outline">Edit</a>
                                @if ($account->id !== $user->id)
                                    <form action="{{ route('dashboard.admin-users.destroy', $account) }}" method="POST" data-confirm="Yakin ingin menghapus akun {{ $account->email }}?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($accounts->hasPages())
            <div class="admin-account-pagination">
                {{ $accounts->links('pagination::default') }}
            </div>
        @endif
    @endif
</div>

<style>
/* Empty state */
.admin-account-empty {
    text-align: center;
    padding: 3rem 1.5rem;
}
.admin-account-empty-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.6;
}
.admin-account-empty-text {
    font-size: 0.95rem;
    color: var(--text-muted);
    margin: 0 0 1rem 0;
}
.admin-account-empty .btn { margin-top: 0.5rem; }
/* Filters */
.admin-account-filters {
    margin-bottom: 1.25rem;
}
.admin-account-filter-form {
    display: block;
}
.admin-account-filter-row {
    display: grid;
    grid-template-columns: minmax(0, 2fr) minmax(0, 1.3fr) auto;
    gap: 0.75rem;
    align-items: flex-end;
}
.admin-account-filter-group label {
    display: block;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--text-muted);
    margin-bottom: 0.35rem;
    text-transform: uppercase;
    letter-spacing: 0.06em;
}
.admin-account-filter-group input,
.admin-account-filter-group select {
    width: 100%;
    padding: 0.6rem 0.9rem;
    font-size: 0.875rem;
    font-family: inherit;
    color: var(--text);
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 10px;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.admin-account-filter-group input::placeholder {
    color: var(--text-muted);
    opacity: 0.8;
}
.admin-account-filter-group input:focus,
.admin-account-filter-group select:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(37,99,235,0.12);
}
.admin-account-filter-group select {
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.9rem center;
    padding-right: 2.2rem;
}
.admin-account-filter-actions {
    display: flex;
    gap: 0.5rem;
    justify-content: flex-end;
    flex-wrap: wrap;
}
.admin-account-filter-actions .btn-sm {
    padding-inline: 0.9rem;
}
/* Table */
.admin-account-table-wrap {
    overflow-x: auto;
    border-radius: 12px;
    border: 1px solid var(--border);
    background: var(--card);
}
.admin-account-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.875rem;
}
.admin-account-table th {
    text-align: left;
    padding: 0.85rem 1.15rem;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: var(--text-muted);
    background: var(--table-header-bg);
    border-bottom: 1px solid var(--border);
}
.admin-account-table th:first-child { border-radius: 11px 0 0 0; padding-left: 1.25rem; }
.admin-account-table th:last-child { border-radius: 0 11px 0 0; padding-right: 1.25rem; }
.admin-account-table td {
    padding: 0.9rem 1.15rem;
    border-bottom: 1px solid var(--table-row-border);
    color: var(--text);
    vertical-align: middle;
}
.admin-account-table td:first-child { padding-left: 1.25rem; }
.admin-account-table td:last-child { padding-right: 1.25rem; }
.admin-account-table tbody tr:last-child td { border-bottom: none; }
.admin-account-table tbody tr:hover td { background: var(--table-row-hover); }
.admin-account-cell-num {
    font-weight: 600;
    color: var(--text-muted);
    width: 3rem;
}
.admin-account-cell-name { font-weight: 600; color: var(--text); }
.admin-account-cell-email { color: var(--text-muted); font-size: 0.85rem; }
.admin-account-badge-role {
    display: inline-block;
    padding: 4px 10px;
    font-size: 0.75rem;
    font-weight: 600;
    border-radius: 8px;
    background: rgba(59,130,246,0.12);
    color: var(--primary);
    border: 1px solid rgba(59,130,246,0.2);
}
.admin-account-cell-actions {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    align-items: center;
}
.admin-account-cell-actions form { display: inline-block; }
.admin-account-pagination {
    margin-top: 1.5rem;
    display: flex;
    justify-content: center;
}
@media (max-width: 768px) {
    .admin-account-card { padding: 1.25rem 1rem; }
    .admin-account-table th,
    .admin-account-table td { padding: 0.7rem 0.85rem; font-size: 0.8rem; }
    .admin-account-table th:first-child,
    .admin-account-table td:first-child { padding-left: 1rem; }
    .admin-account-table th:last-child,
    .admin-account-table td:last-child { padding-right: 1rem; }
}
</style>
@endsection

