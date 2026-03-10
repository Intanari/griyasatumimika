@extends('layouts.dashboard')

@section('title', 'Detail Petugas')
@section('topbar-title', 'Detail Petugas')

@section('content')
<a href="{{ route('dashboard.petugas.index') }}" class="page-back-link">Back</a>
<div class="card petugas-profile-card">
    <div class="petugas-profile-header">
        <div class="petugas-profile-avatar-wrap">
            @if($petuga->foto_url)
                <img src="{{ $petuga->foto_url }}" alt="{{ $petuga->name }}" class="petugas-profile-avatar">
            @else
                <div class="petugas-profile-avatar-placeholder">{{ strtoupper(mb_substr($petuga->name, 0, 1)) }}</div>
            @endif
            <div class="petugas-profile-status-badge petugas-status-{{ $petuga->status_kerja ?? 'aktif' }}">
                {{ $petuga->status_kerja_label }}
            </div>
        </div>
        <div class="petugas-profile-heading">
            <h1 class="petugas-profile-name">{{ $petuga->name }}</h1>
            <p class="petugas-profile-role">{{ $petuga->role_label }}</p>
            @if($petuga->shift_jaga)
                <p class="petugas-profile-shift">Shift: {{ $petuga->shift_jaga_label }}</p>
            @endif
        </div>
        <div class="petugas-profile-actions">
            <a href="{{ route('dashboard.petugas.edit', $petuga) }}" class="btn btn-primary">Edit</a>
            @if ($petuga->id !== $user->id)
                <form action="{{ route('dashboard.petugas.destroy', $petuga) }}" method="POST" style="display:inline;" data-confirm="Yakin ingin menghapus petugas {{ $petuga->name }}?">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            @endif
            <a href="{{ route('dashboard.petugas.index') }}" class="btn btn-outline">Kembali</a>
        </div>
    </div>

    <div class="petugas-profile-body">
        <div class="petugas-info-block">
            <h3 class="petugas-info-block-title">
                <span class="petugas-info-block-icon">👤</span>
                Informasi Identitas
            </h3>
            <div class="petugas-info-grid">
                <div class="petugas-info-item">
                    <span class="petugas-info-key">Nama Lengkap</span>
                    <span class="petugas-info-val">{{ $petuga->name }}</span>
                </div>
                <div class="petugas-info-item">
                    <span class="petugas-info-key">Jenis Kelamin</span>
                    <span class="petugas-info-val">{{ $petuga->jenis_kelamin_label }}</span>
                </div>
                <div class="petugas-info-item">
                    <span class="petugas-info-key">Tempat, Tanggal Lahir</span>
                    <span class="petugas-info-val">
                        @if($petuga->tempat_lahir || $petuga->tanggal_lahir)
                            {{ $petuga->tempat_lahir ?? '-' }}, {{ $petuga->tanggal_lahir?->translatedFormat('d F Y') ?? '-' }}
                        @else
                            -
                        @endif
                    </span>
                </div>
                <div class="petugas-info-item">
                    <span class="petugas-info-key">Alamat</span>
                    <span class="petugas-info-val">{{ $petuga->alamat ?? '-' }}</span>
                </div>
                <div class="petugas-info-item">
                    <span class="petugas-info-key">Nomor HP</span>
                    <span class="petugas-info-val">{{ $petuga->no_hp ?? '-' }}</span>
                </div>
                <div class="petugas-info-item">
                    <span class="petugas-info-key">Email</span>
                    <span class="petugas-info-val">{{ $petuga->email }}</span>
                </div>
            </div>
        </div>

        <div class="petugas-info-block">
            <h3 class="petugas-info-block-title">
                <span class="petugas-info-block-icon">💼</span>
                Informasi Pekerjaan
            </h3>
            <div class="petugas-info-grid">
                <div class="petugas-info-item">
                    <span class="petugas-info-key">Tanggal Bergabung</span>
                    <span class="petugas-info-val">{{ $petuga->tanggal_bergabung?->translatedFormat('d F Y') ?? '-' }}</span>
                </div>
                <div class="petugas-info-item">
                    <span class="petugas-info-key">Status Kerja</span>
                    <span class="petugas-info-val">
                        @if($petuga->status_kerja === 'aktif')
                            <span class="badge badge-paid">Aktif</span>
                        @elseif($petuga->status_kerja === 'cuti')
                            <span class="badge badge-pending">Cuti</span>
                        @else
                            <span class="badge badge-cancel">Nonaktif</span>
                        @endif
                    </span>
                </div>
                <div class="petugas-info-item">
                    <span class="petugas-info-key">Shift Jaga</span>
                    <span class="petugas-info-val">{{ $petuga->shift_jaga_label }}</span>
                </div>
                <div class="petugas-info-item">
                    <span class="petugas-info-key">Role Sistem</span>
                    <span class="petugas-info-val">{{ $petuga->role_label }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.petugas-profile-card { max-width: 720px; }
.petugas-profile-header {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 1.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--border);
    margin-bottom: 1.5rem;
}
.petugas-profile-avatar-wrap { position: relative; flex-shrink: 0; }
.petugas-profile-avatar {
    width: 100px; height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid var(--border);
}
.petugas-profile-avatar-placeholder {
    width: 100px; height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), var(--accent));
    color: white;
    font-size: 2.25rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 4px solid var(--border);
}
.petugas-profile-status-badge {
    position: absolute;
    bottom: 0;
    right: 0;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}
.petugas-status-aktif { background: #d1fae5; color: #047857; }
.petugas-status-cuti { background: #fef3c7; color: #b45309; }
.petugas-status-nonaktif { background: #f1f5f9; color: #64748b; }
.petugas-profile-heading { flex: 1; min-width: 180px; }
.petugas-profile-name { font-size: 1.35rem; font-weight: 800; color: var(--text); margin-bottom: 0.25rem; }
.petugas-profile-role { font-size: 0.9rem; color: var(--primary); font-weight: 600; }
.petugas-profile-shift { font-size: 0.85rem; color: var(--text-muted); margin-top: 0.25rem; }
.petugas-profile-actions { display: flex; flex-wrap: wrap; gap: 0.5rem; align-items: center; }

.petugas-info-block { margin-bottom: 1.5rem; }
.petugas-info-block:last-child { margin-bottom: 0; }
.petugas-info-block-title {
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.petugas-info-block-icon { font-size: 1.1rem; }
.petugas-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 0.75rem 1.5rem;
}
.petugas-info-item { display: flex; flex-direction: column; gap: 2px; }
.petugas-info-key { font-size: 0.75rem; color: var(--text-muted); font-weight: 500; }
.petugas-info-val { font-size: 0.9rem; font-weight: 600; color: var(--text); }
</style>
@endpush
@endsection
