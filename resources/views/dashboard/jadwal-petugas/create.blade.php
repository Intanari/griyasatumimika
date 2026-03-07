@extends('layouts.dashboard')

@section('title', 'Tambah Jadwal Petugas')
@section('topbar-title', 'Tambah Jadwal Petugas')

@section('content')
<div class="jp-create-page">
    <nav class="jp-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="jp-breadcrumb-sep">/</span>
        <a href="{{ route('dashboard.jadwal-petugas.index') }}">Jadwal Petugas</a>
        <span class="jp-breadcrumb-sep">/</span>
        <span class="jp-breadcrumb-current">Tambah Jadwal</span>
    </nav>

    <div class="jp-create-card">
        <div class="jp-create-header">
            <a href="{{ route('dashboard.jadwal-petugas.index') }}" class="jp-create-back">← Kembali ke Daftar</a>
            <div class="jp-create-header-main">
                <div class="jp-create-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <div>
                    <h2 class="jp-create-title">Tambah Jadwal Petugas</h2>
                    <p class="jp-create-subtitle">Atur jadwal per hari: pilih shift dari data shift yang tersedia.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('dashboard.jadwal-petugas.store') }}" method="POST" class="jp-create-form" id="jp-create-form">
            @csrf
            <div class="jp-create-section">
                <label class="jp-create-label">Nama Petugas <span class="jp-required">*</span></label>
                <select name="user_id" class="jp-create-select {{ $errors->has('user_id') ? 'is-invalid' : '' }}" required>
                    <option value="">-- Pilih Petugas --</option>
                    @foreach($petugasList as $p)
                        <option value="{{ $p->id }}" {{ old('user_id', $copyFrom?->user_id) == $p->id ? 'selected' : '' }}>{{ $p->name }}@if($p->jabatan) ({{ $p->jabatan }})@endif</option>
                    @endforeach
                </select>
                <p class="jp-hint">Pilih shift pada tabel di bawah per hari. Kosongkan = Libur di hari itu.</p>
                @error('user_id')<span class="jp-error">{{ $message }}</span>@enderror
            </div>

            <input type="hidden" name="tanggal_dari" value="{{ old('tanggal_dari', now()->startOfWeek(Carbon\Carbon::MONDAY)->format('Y-m-d')) }}">
            <input type="hidden" name="tanggal_sampai" value="{{ old('tanggal_sampai', now()->addWeeks(3)->endOfWeek(Carbon\Carbon::SUNDAY)->format('Y-m-d')) }}">
            <input type="hidden" name="ulang_setiap" value="{{ old('ulang_setiap', 'minggu') }}">

            <div class="jp-create-section jp-matrix-section">
                <p class="jp-matrix-hint">Tentukan <strong>hari</strong> dalam seminggu: centang shift yang dijalani petugas. Kosongkan = Libur di hari itu.</p>
                <div class="jp-matrix-table-wrap">
                    <table class="jp-matrix-table">
                        <thead>
                            <tr>
                                <th>Hari</th>
                                @foreach($shifts as $shift)
                                    <th class="jp-th-shift">{{ $shift->nama }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $dayNames = [1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu', 0 => 'Minggu'];
                                $oldShifts = old('shifts_by_day', []);
                            @endphp
                            @foreach($dayNames as $dayNum => $dayName)
                                @php
                                    $oldForDay = $oldShifts[$dayNum] ?? [];
                                @endphp
                                <tr>
                                    <td class="jp-day-name">{{ $dayName }}</td>
                                    @foreach($shifts as $shift)
                                        <td class="jp-cell-shift">
                                            <label class="jp-check-cell">
                                                <input type="checkbox" name="shifts_by_day[{{ $dayNum }}][]" value="{{ $shift->id }}" {{ in_array((string)$shift->id, $oldForDay) ? 'checked' : '' }} data-day="{{ $dayNum }}">
                                                <span>{{ \Carbon\Carbon::parse($shift->jam_mulai)->format('H:i') }}–{{ \Carbon\Carbon::parse($shift->jam_selesai)->format('H:i') }}</span>
                                            </label>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @error('shifts_by_day')<span class="jp-error">{{ $message }}</span>@enderror
            </div>

            <div class="jp-create-actions">
                <button type="submit" class="jp-btn-submit">Simpan Jadwal Rutin</button>
                <a href="{{ route('dashboard.jadwal-petugas.index') }}" class="jp-btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.jp-create-page { max-width: 720px; margin: 0 auto; padding: 0 0.5rem; font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; }
.jp-breadcrumb { font-size: 0.875rem; color: #64748b; margin-bottom: 1.5rem; }
.jp-breadcrumb a { color: var(--primary); text-decoration: none; font-weight: 500; }
.jp-breadcrumb a:hover { text-decoration: underline; }
.jp-breadcrumb-sep { margin: 0 0.35rem; opacity: 0.6; }
.jp-breadcrumb-current { color: #1e293b; font-weight: 600; }

.jp-create-card { background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.04); border: 1px solid #e2e8f0; }
.jp-create-header { padding: 1.5rem 2rem; border-bottom: 1px solid #e2e8f0; background: linear-gradient(180deg, #f8fafc 0%, #fff 100%); }
.jp-create-back { display: block; font-size: 0.85rem; font-weight: 600; color: #64748b; margin-bottom: 0.75rem; text-decoration: none; }
.jp-create-back:hover { color: var(--primary); }
.jp-create-header-main { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
.jp-create-icon { width: 52px; height: 52px; border-radius: 14px; background: linear-gradient(135deg, rgba(59,130,246,0.12), rgba(14,165,233,0.08)); border: 1px solid rgba(59,130,246,0.2); color: var(--primary); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.jp-create-title { font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 0; }
.jp-create-subtitle { font-size: 0.9rem; color: #64748b; margin: 4px 0 0; }

.jp-create-form { padding: 1.75rem 2rem; }
.jp-create-section { margin-bottom: 1.5rem; }
.jp-create-label { display: block; font-size: 0.9rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem; }
.jp-hint { font-size: 0.82rem; color: #64748b; margin: 0.35rem 0 0 0; }
.jp-required { color: #dc2626; }
.jp-create-select { width: 100%; max-width: 360px; padding: 0.65rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 0.95rem; font-family: inherit; background: #fff; }
.jp-create-select:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.12); }
.jp-create-select.is-invalid { border-color: #ef4444; }
.jp-error { display: block; font-size: 0.8rem; color: #dc2626; margin-top: 0.35rem; }

.jp-matrix-section { margin-top: 1.75rem; }
.jp-matrix-hint { font-size: 0.85rem; color: #64748b; margin-bottom: 1rem; }
.jp-matrix-table-wrap { overflow-x: auto; border: 1px solid #e2e8f0; border-radius: 12px; }
.jp-matrix-table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
.jp-matrix-table thead th { padding: 0.75rem 1rem; text-align: left; font-weight: 700; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; background: #f8fafc; border-bottom: 2px solid #e2e8f0; }
.jp-matrix-table thead th.jp-th-shift { text-align: center; }
.jp-matrix-table tbody tr { border-bottom: 1px solid #f1f5f9; }
.jp-matrix-table tbody tr:last-child { border-bottom: none; }
.jp-matrix-table tbody tr:hover { background: #fafbff; }
.jp-day-name { padding: 0.75rem 1rem; font-weight: 600; color: #1e293b; width: 100px; }
.jp-cell-shift { padding: 0.5rem 0.75rem; text-align: center; }
.jp-check-cell { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.4rem 0.75rem; border-radius: 8px; cursor: pointer; transition: background 0.15s; }
.jp-check-cell:hover { background: #f1f5f9; }
.jp-check-cell input { accent-color: var(--primary); cursor: pointer; }
.jp-check-cell input:checked + span { font-weight: 600; color: #1d4ed8; }

.jp-create-actions { display: flex; gap: 0.875rem; padding-top: 1.5rem; margin-top: 1.5rem; border-top: 1px solid #e2e8f0; }
.jp-btn-submit { padding: 0.7rem 1.5rem; background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff; font-size: 0.95rem; font-weight: 700; border: none; border-radius: 10px; cursor: pointer; font-family: inherit; }
.jp-btn-submit:hover { filter: brightness(1.05); }
.jp-btn-submit.jp-btn-sm { padding: 0.5rem 1rem; font-size: 0.875rem; }
.jp-btn-cancel { padding: 0.65rem 1.25rem; background: #fff; color: #64748b; font-size: 0.9rem; font-weight: 600; border: 1.5px solid #e2e8f0; border-radius: 10px; text-decoration: none; }
.jp-btn-cancel:hover { background: #f8fafc; color: #334155; border-color: #cbd5e1; }

.jp-section-divider { height: 1px; background: #e2e8f0; margin: 1.5rem 2rem; }
.jp-subsection { border-bottom: none; padding: 1rem 0 0.75rem; }
.jp-subsection .jp-create-icon { width: 40px; height: 40px; }
.jp-icon-libur { background: linear-gradient(135deg, rgba(234,179,8,0.12), rgba(245,158,11,0.08)); border-color: rgba(234,179,8,0.25); color: #ca8a04; }
.jp-icon-ganti { background: linear-gradient(135deg, rgba(34,197,94,0.12), rgba(22,163,74,0.08)); border-color: rgba(34,197,94,0.25); color: #16a34a; }
.jp-subsection-title { font-size: 1rem; font-weight: 700; color: #1e293b; margin: 0; }
.jp-subsection-desc { font-size: 0.82rem; color: #64748b; margin: 4px 0 0; }

.jp-form-group { min-width: 140px; }
.jp-form-group.jp-flex-grow { flex: 1; min-width: 160px; }
.jp-form-group.jp-form-submit { flex-shrink: 0; }
.jp-input-date { min-width: 140px; }

@media (max-width: 640px) {
    .jp-matrix-table thead th, .jp-day-name, .jp-cell-shift { padding: 0.6rem 0.5rem; font-size: 0.8rem; }
    .jp-check-cell { padding: 0.35rem 0.5rem; }
    .jp-form-row { flex-direction: column; }
    .jp-form-group { min-width: 100%; }
    .jp-form-group.jp-form-submit { width: 100%; }
    .jp-section-divider { margin-left: 1rem; margin-right: 1rem; }
}
</style>
@endpush

@push('scripts')
<script>
document.getElementById('jp-create-form').addEventListener('submit', function(e) {
    var hasAny = false;
    this.querySelectorAll('input[name^="shifts_by_day"]').forEach(function(cb) {
        if (cb.checked) hasAny = true;
    });
    if (!hasAny) {
        e.preventDefault();
        alert('Pilih minimal satu shift pada satu atau lebih hari. Hari tanpa centang = Libur.');
        return false;
    }
});
</script>
@endpush
@endsection
