@extends('layouts.dashboard')

@section('title', 'Data Pasien')
@section('topbar-title', 'Data Pasien')

@section('content')
<div class="card">
    <div class="card-title patients-card-title">
        <span>Data Pasien</span>
        <a href="{{ route('dashboard.patients.create') }}" class="btn-add-pasien">+ Tambah Pasien</a>
    </div>

    <div class="patients-toolbar">
        <form method="GET" action="{{ route('dashboard.patients.index') }}" class="patients-search-form">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau tempat lahir..." class="search-input">
            <select name="jenis_kelamin" class="filter-select">
                <option value="">Semua Jenis Kelamin</option>
                <option value="L" {{ request('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ request('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
            <select name="status" class="filter-select">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai / Sehat</option>
                <option value="dirujuk" {{ request('status') === 'dirujuk' ? 'selected' : '' }}>Dirujuk</option>
            </select>
            <button type="submit" class="btn btn-sm btn-primary">Cari</button>
            @if(request()->hasAny(['search','status','jenis_kelamin']))
                <a href="{{ route('dashboard.patients.index') }}" class="btn btn-sm btn-outline">Reset</a>
            @endif
        </form>
    </div>

    @if ($patients->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">📋</div>
            <p>Belum ada data pasien.</p>
            <a href="{{ route('dashboard.patients.create') }}" class="btn-add-pasien" style="margin-top:0.75rem;">+ Tambah pasien pertama</a>
        </div>
    @else
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama Lengkap</th>
                        <th>Tempat, Tanggal Lahir</th>
                        <th>Umur</th>
                        <th>Jenis Kelamin</th>
                        <th>Tanggal Masuk</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($patients as $index => $patient)
                        <tr>
                            <td>{{ $patients->firstItem() + $index }}</td>
                            <td>
                                <a href="{{ route('dashboard.patients.show', $patient) }}" class="patient-photo-cell">
                                    @if($patient->foto_url)
                                        <img src="{{ asset('storage/' . $patient->foto) }}" alt="{{ $patient->nama_lengkap }}" class="patient-photo-thumb" loading="lazy">
                                    @else
                                        <div class="patient-photo-placeholder" title="{{ $patient->nama_lengkap }}">{{ strtoupper(mb_substr($patient->nama_lengkap, 0, 1)) }}</div>
                                    @endif
                                </a>
                            </td>
                            <td>{{ $patient->nama_lengkap }}</td>
                            <td>
                                @if($patient->tempat_lahir || $patient->tanggal_lahir)
                                    {{ $patient->tempat_lahir ?? '-' }}, {{ $patient->tanggal_lahir?->translatedFormat('d M Y') ?? '-' }}
                                @else
                                    <span style="color:var(--text-muted);">-</span>
                                @endif
                            </td>
                            <td>{{ $patient->umur ? $patient->umur . ' th' : '-' }}</td>
                            <td>{{ $patient->jenis_kelamin_label }}</td>
                            <td style="font-size:0.85rem;">{{ $patient->tanggal_masuk->translatedFormat('d M Y') }}</td>
                            <td>
                                @if ($patient->status === 'aktif')
                                    <span class="badge badge-paid">Aktif</span>
                                @elseif ($patient->status === 'selesai')
                                    <span class="badge badge-cancel">Selesai</span>
                                @else
                                    <span class="badge badge-pending">Dirujuk</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('dashboard.patients.show', $patient) }}" class="btn btn-sm btn-outline" title="Detail">Detail</a>
                                    <a href="{{ route('dashboard.patients.edit', $patient) }}" class="btn btn-sm btn-outline" title="Edit">Edit</a>
                                    <form action="{{ route('dashboard.patients.destroy', $patient) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus pasien {{ $patient->nama_lengkap }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($patients->hasPages())
            <div style="margin-top:1.5rem;display:flex;justify-content:center;">{{ $patients->links('pagination::default') }}</div>
        @endif
    @endif
</div>

@push('styles')
<style>
.patients-card-title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}
.btn-add-pasien {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 0.55rem 1.25rem;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff;
    font-size: 0.9rem;
    font-weight: 600;
    border-radius: 10px;
    text-decoration: none;
    box-shadow: 0 2px 8px rgba(37, 99, 235, 0.35);
    transition: all 0.18s ease;
    border: none;
    white-space: nowrap;
}
.btn-add-pasien:hover {
    background: linear-gradient(135deg, #1d4ed8, #1e40af);
    color: #fff;
    box-shadow: 0 4px 16px rgba(37, 99, 235, 0.45);
    transform: translateY(-1px);
}
.patients-toolbar { margin-bottom: 1.25rem; }
.patients-search-form { display: flex; gap: 0.75rem; flex-wrap: wrap; align-items: center; }
.search-input {
    padding: 0.5rem 1rem; border: 1px solid var(--border); border-radius: 10px;
    font-size: 0.9rem; min-width: 220px; font-family: inherit;
}
.search-input:focus { outline: none; border-color: var(--primary); }
.filter-select {
    padding: 0.5rem 1rem; border: 1px solid var(--border); border-radius: 10px;
    font-size: 0.9rem; font-family: inherit; background: white;
}
.btn-primary { background: linear-gradient(135deg, var(--primary), var(--accent)); color: white; padding: 0.5rem 1rem; }
.btn-primary:hover { filter: brightness(1.05); }
.btn-outline { background: transparent; border: 1px solid var(--border); color: var(--text); }
.btn-outline:hover { background: rgba(59,130,246,0.08); border-color: var(--primary); color: var(--primary); }
.action-buttons { display: flex; gap: 6px; flex-wrap: wrap; }
.patient-photo-cell { display: inline-block; text-decoration: none; }
.patient-photo-thumb {
    width: 48px; height: 48px; border-radius: 50%;
    object-fit: cover; border: 2px solid var(--border);
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: transform 0.2s, box-shadow 0.2s;
}
.patient-photo-thumb:hover { transform: scale(1.08); box-shadow: 0 4px 12px rgba(59,130,246,0.25); }
.patient-photo-placeholder {
    width: 48px; height: 48px; border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), var(--accent));
    color: white; font-size: 1.1rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    border: 2px solid var(--border); box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}
</style>
@endpush
@endsection
