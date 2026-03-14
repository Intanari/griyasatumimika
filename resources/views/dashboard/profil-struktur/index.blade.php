@extends('layouts.dashboard')

@section('title', 'Profil Struktur Organisasi')
@section('topbar-title', 'Profil Struktur Organisasi')

@section('content')
<a href="{{ route('dashboard') }}" class="page-back-link">Kembali</a>

@if(session('success'))
    <div class="alert alert-success" style="margin-bottom: 1rem; padding: 0.75rem 1rem; background: var(--success-soft); color: var(--success); border-radius: 8px;">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger" style="margin-bottom: 1rem; padding: 0.75rem 1rem; background: var(--danger-soft); color: var(--danger); border-radius: 8px;">{{ session('error') }}</div>
@endif

{{-- Form Kepengurusan (6 jabatan tetap) --}}
<div class="card admin-account-card">
    <div class="admin-account-header">
        <div class="admin-account-header-text">
            <h2 class="admin-account-title">Kepengurusan Yayasan</h2>
            <p class="admin-account-desc">Edit data jabatan tetap (foto, nama, status, keterangan). Struktur pohon di halaman publik tidak berubah.</p>
        </div>
    </div>

    <form action="{{ route('dashboard.profil-struktur.update-kepengurusan') }}" method="POST" enctype="multipart/form-data" class="struktur-form">
        @csrf
        @method('PUT')

        @php
            $labels = [
                'pembina' => '1. Pembina',
                'ketua_yayasan' => '2. Ketua Yayasan',
                'ketua_pengawas' => '3. Ketua Pengawas',
                'sekretaris' => '4. Sekretaris',
                'bendahara' => '5. Bendahara',
                'pengawas' => '6. Pengawas',
            ];
        @endphp

        @foreach($kepengurusan as $item)
            <div class="struktur-jabatan-block">
                <h3 class="struktur-jabatan-title">{{ $labels[$item->role] ?? $item->role }}</h3>
                <div class="struktur-jabatan-grid">
                    <div class="form-group struktur-foto-wrap">
                        <label>Foto Profil</label>
                        @if($item->foto_url)
                            <div class="struktur-foto-preview"><img src="{{ $item->foto_url }}" alt=""></div>
                        @else
                            <div class="struktur-foto-initials">{{ $item->avatar_initials }}</div>
                        @endif
                        <input type="file" name="{{ $item->role }}_foto" accept="image/jpeg,image/png,image/webp" class="struktur-file-input">
                    </div>
                    <div class="struktur-fields">
                        <div class="form-group">
                            <label for="nama_{{ $item->role }}">Nama</label>
                            <input type="text" id="nama_{{ $item->role }}" name="{{ $item->role }}_nama" value="{{ old($item->role.'_nama', $item->nama) }}" maxlength="255" placeholder="Nama lengkap">
                        </div>
                        <div class="form-group">
                            <label for="status_{{ $item->role }}">Status / Jabatan</label>
                            <input type="text" id="status_{{ $item->role }}" name="{{ $item->role }}_status" value="{{ old($item->role.'_status', $item->status) }}" maxlength="255" placeholder="Contoh: Ketua Yayasan">
                        </div>
                        <div class="form-group">
                            <label for="keterangan_{{ $item->role }}">Keterangan</label>
                            <textarea id="keterangan_{{ $item->role }}" name="{{ $item->role }}_keterangan" rows="3" placeholder="Deskripsi singkat">{{ old($item->role.'_keterangan', $item->keterangan) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan Kepengurusan</button>
        </div>
    </form>
</div>

{{-- Petugas Yayasan --}}
<div class="card admin-account-card">
    <div class="admin-account-header">
        <div class="admin-account-header-text">
            <h2 class="admin-account-title">Petugas Yayasan</h2>
            <p class="admin-account-desc">Tambah dan kelola petugas yayasan. Ditampilkan di halaman publik dalam bentuk kotak.</p>
        </div>
        <a href="{{ route('dashboard.petugas-yayasan.create') }}" class="btn btn-primary btn-sm admin-account-btn-add">+ Tambah Petugas Yayasan</a>
    </div>

    @if($petugas->isEmpty())
        <div class="admin-account-empty">
            <div class="admin-account-empty-icon">👥</div>
            <p class="admin-account-empty-text">Belum ada petugas yayasan.</p>
            <a href="{{ route('dashboard.petugas-yayasan.create') }}" class="btn btn-primary">+ Tambah Petugas Yayasan</a>
        </div>
    @else
        <div class="petugas-yayasan-grid">
            @foreach($petugas as $p)
                <div class="petugas-yayasan-card">
                    <div class="petugas-yayasan-card-avatar">
                        @if($p->foto_url)
                            <img src="{{ $p->foto_url }}" alt="">
                        @else
                            <span class="petugas-yayasan-initials">{{ $p->avatar_initials }}</span>
                        @endif
                    </div>
                    <div class="petugas-yayasan-card-name">{{ $p->nama }}</div>
                    @if($p->status)
                        <div class="petugas-yayasan-card-status">{{ $p->status }}</div>
                    @endif
                    @if($p->keterangan)
                        <p class="petugas-yayasan-card-desc">{{ Str::limit($p->keterangan, 80) }}</p>
                    @endif
                    <div class="petugas-yayasan-card-actions">
                        <a href="{{ route('dashboard.petugas-yayasan.show', $p) }}" class="btn btn-sm btn-outline">Detail</a>
                        <a href="{{ route('dashboard.petugas-yayasan.edit', $p) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('dashboard.petugas-yayasan.destroy', $p) }}" method="POST" class="petugas-yayasan-form-delete" data-confirm="Yakin hapus petugas « {{ $p->nama }} »?">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@push('styles')
<style>
.struktur-form { padding: 1rem 1.75rem 1.75rem; }
.struktur-jabatan-block { margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border); }
.struktur-jabatan-block:last-of-type { border-bottom: 0; margin-bottom: 0; }
.struktur-jabatan-title { font-size: 1rem; font-weight: 700; color: var(--primary-dark); margin: 0 0 1rem; }
.struktur-jabatan-grid { display: grid; grid-template-columns: 120px 1fr; gap: 1.5rem; align-items: start; }
@media (max-width: 640px) { .struktur-jabatan-grid { grid-template-columns: 1fr; } }
.struktur-foto-wrap { margin: 0; }
.struktur-foto-preview, .struktur-foto-initials {
    width: 100px; height: 100px; border-radius: 50%;
    background: var(--neutral-soft);
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 0.5rem; overflow: hidden;
}
.struktur-foto-preview img { width: 100%; height: 100%; object-fit: cover; }
.struktur-foto-initials { font-size: 1.5rem; font-weight: 700; color: var(--primary); }
.struktur-file-input { font-size: 0.8rem; margin-top: 0.25rem; }
.struktur-fields .form-group { margin-bottom: 0.75rem; }
.struktur-fields .form-group:last-child { margin-bottom: 0; }
.struktur-fields label { display: block; font-size: 0.8rem; font-weight: 500; margin-bottom: 0.25rem; color: var(--text); }
.struktur-fields input, .struktur-fields textarea {
    width: 100%; padding: 0.5rem 0.75rem;
    border: 1px solid var(--border); border-radius: 8px;
    font-size: 0.9rem; background: var(--card); color: var(--text);
}
.form-actions { margin-top: 1.5rem; }

.petugas-yayasan-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.25rem; padding: 1rem 1.75rem 1.75rem; }
.petugas-yayasan-card {
    background: var(--card); border: 1px solid var(--border); border-radius: 12px;
    padding: 1.25rem; box-shadow: var(--shadow);
    display: flex; flex-direction: column; align-items: center; text-align: center;
}
.petugas-yayasan-card:hover { box-shadow: var(--shadow-lg); border-color: var(--primary-light); }
.petugas-yayasan-card-avatar {
    width: 80px; height: 80px; border-radius: 50%;
    background: var(--neutral-soft);
    overflow: hidden; margin-bottom: 0.75rem;
    display: flex; align-items: center; justify-content: center;
}
.petugas-yayasan-card-avatar img { width: 100%; height: 100%; object-fit: cover; }
.petugas-yayasan-initials { font-size: 1.25rem; font-weight: 700; color: var(--primary); }
.petugas-yayasan-card-name { font-size: 1rem; font-weight: 700; color: var(--text); margin-bottom: 0.25rem; }
.petugas-yayasan-card-status { font-size: 0.75rem; font-weight: 600; color: var(--primary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; }
.petugas-yayasan-card-desc { font-size: 0.85rem; color: var(--text-muted); line-height: 1.5; margin: 0 0 1rem; flex: 1; }
.petugas-yayasan-card-actions { display: flex; flex-wrap: wrap; gap: 0.5rem; justify-content: center; }
.petugas-yayasan-card-actions form { display: inline; }
.petugas-yayasan-form-delete button { cursor: pointer; }
</style>
@endpush

@push('scripts')
<script>
document.querySelectorAll('.petugas-yayasan-form-delete').forEach(function(f) {
    f.addEventListener('submit', function(e) {
        if (!confirm(this.getAttribute('data-confirm') || 'Yakin?')) e.preventDefault();
    });
});
</script>
@endpush
@endsection
