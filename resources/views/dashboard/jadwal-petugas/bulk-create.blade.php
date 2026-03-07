@extends('layouts.dashboard')

@section('title', 'Tambah Banyak Jadwal')
@section('topbar-title', 'Tambah Banyak Jadwal')

@section('content')
<nav class="jp-breadcrumb" aria-label="Breadcrumb">
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <span class="jp-breadcrumb-sep">/</span>
    <a href="{{ route('dashboard.jadwal-petugas.index') }}">Jadwal Petugas</a>
    <span class="jp-breadcrumb-sep">/</span>
    <span class="jp-breadcrumb-current">Tambah Banyak</span>
</nav>

<div class="card jadwal-form-card">
    <div class="jadwal-form-header">
        <a href="{{ route('dashboard.jadwal-petugas.index') }}" class="jadwal-back-link">← Kembali ke Daftar</a>
        <div class="jadwal-form-header-main">
            <div class="jadwal-form-icon jadwal-form-icon-bulk">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><line x1="8" y1="14" x2="8" y2="14.01"/><line x1="12" y1="14" x2="12" y2="14.01"/><line x1="16" y1="14" x2="16" y2="14.01"/><line x1="8" y1="18" x2="8" y2="18.01"/><line x1="12" y1="18" x2="12" y2="18.01"/><line x1="16" y1="18" x2="16" y2="18.01"/></svg>
            </div>
            <div>
                <h2 class="jadwal-form-title">Tambah Banyak Jadwal</h2>
                <p class="jadwal-form-subtitle">Buat jadwal shift untuk satu petugas di banyak tanggal sekaligus. Pilih rentang tanggal dan hari dalam minggu yang ingin diisi.</p>
            </div>
        </div>
    </div>

    <div class="jadwal-form-bulk-hint">
        <span class="jadwal-form-bulk-icon">💡</span>
        <div>
            <strong>Contoh:</strong> Pilih Budi, tanggal 10–14 Maret, centang Senin–Jumat, shift Pagi → akan terbuat 5 jadwal (Senin s/d Jumat).
        </div>
    </div>

    <form action="{{ route('dashboard.jadwal-petugas.bulk-store') }}" method="POST" class="jadwal-form">
        @csrf
        <div class="rw-form-grid">
            <div class="rw-form-group rw-col-full">
                <label class="rw-label">Petugas <span class="rw-required">*</span></label>
                <select name="user_id" class="rw-input {{ $errors->has('user_id') ? 'rw-invalid' : '' }}" required>
                    <option value="">-- Pilih Petugas --</option>
                    @foreach($petugasList as $p)
                        <option value="{{ $p->id }}" {{ old('user_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}@if($p->jabatan) ({{ $p->jabatan }})@endif</option>
                    @endforeach
                </select>
                @error('user_id')<span class="rw-error">{{ $message }}</span>@enderror
            </div>

            <div class="rw-form-group">
                <label class="rw-label">Tanggal dari <span class="rw-required">*</span></label>
                <input type="date" name="tanggal_dari" value="{{ old('tanggal_dari', now()->format('Y-m-d')) }}" class="rw-input {{ $errors->has('tanggal_dari') ? 'rw-invalid' : '' }}" required>
                @error('tanggal_dari')<span class="rw-error">{{ $message }}</span>@enderror
            </div>

            <div class="rw-form-group">
                <label class="rw-label">Tanggal sampai <span class="rw-required">*</span></label>
                <input type="date" name="tanggal_sampai" value="{{ old('tanggal_sampai', now()->addWeek()->format('Y-m-d')) }}" class="rw-input {{ $errors->has('tanggal_sampai') ? 'rw-invalid' : '' }}" required>
                @error('tanggal_sampai')<span class="rw-error">{{ $message }}</span>@enderror
            </div>

            <div class="rw-form-group rw-col-full">
                <label class="rw-label">Hari dalam minggu <span class="rw-required">*</span></label>
                <p class="rw-hint">Pilih hari yang ingin diisi jadwal. Jadwal hanya dibuat untuk tanggal yang jatuh pada hari terpilih.</p>
                <div class="jadwal-hari-grid">
                    <label class="jadwal-hari-chip">
                        <input type="checkbox" name="hari[]" value="1" {{ in_array('1', old('hari', [])) ? 'checked' : '' }}>
                        <span>Senin</span>
                    </label>
                    <label class="jadwal-hari-chip">
                        <input type="checkbox" name="hari[]" value="2" {{ in_array('2', old('hari', [])) ? 'checked' : '' }}>
                        <span>Selasa</span>
                    </label>
                    <label class="jadwal-hari-chip">
                        <input type="checkbox" name="hari[]" value="3" {{ in_array('3', old('hari', [])) ? 'checked' : '' }}>
                        <span>Rabu</span>
                    </label>
                    <label class="jadwal-hari-chip">
                        <input type="checkbox" name="hari[]" value="4" {{ in_array('4', old('hari', [])) ? 'checked' : '' }}>
                        <span>Kamis</span>
                    </label>
                    <label class="jadwal-hari-chip">
                        <input type="checkbox" name="hari[]" value="5" {{ in_array('5', old('hari', [])) ? 'checked' : '' }}>
                        <span>Jumat</span>
                    </label>
                    <label class="jadwal-hari-chip">
                        <input type="checkbox" name="hari[]" value="6" {{ in_array('6', old('hari', [])) ? 'checked' : '' }}>
                        <span>Sabtu</span>
                    </label>
                    <label class="jadwal-hari-chip">
                        <input type="checkbox" name="hari[]" value="0" {{ in_array('0', old('hari', [])) ? 'checked' : '' }}>
                        <span>Minggu</span>
                    </label>
                </div>
                @error('hari')<span class="rw-error">{{ $message }}</span>@enderror
            </div>

            <div class="rw-form-group">
                <label class="rw-label">Shift <span class="rw-required">*</span></label>
                <select name="shift" class="rw-input {{ $errors->has('shift') ? 'rw-invalid' : '' }}" required>
                    <option value="pagi" {{ old('shift', 'pagi') === 'pagi' ? 'selected' : '' }}>Pagi</option>
                    <option value="siang" {{ old('shift') === 'siang' ? 'selected' : '' }}>Siang</option>
                    <option value="malam" {{ old('shift') === 'malam' ? 'selected' : '' }}>Malam</option>
                </select>
                @error('shift')<span class="rw-error">{{ $message }}</span>@enderror
            </div>

            <div class="rw-form-group">
                <label class="rw-label">Jam Mulai</label>
                <input type="time" name="jam_mulai" value="{{ old('jam_mulai') }}" class="rw-input {{ $errors->has('jam_mulai') ? 'rw-invalid' : '' }}">
                @error('jam_mulai')<span class="rw-error">{{ $message }}</span>@enderror
            </div>

            <div class="rw-form-group">
                <label class="rw-label">Jam Selesai</label>
                <input type="time" name="jam_selesai" value="{{ old('jam_selesai') }}" class="rw-input {{ $errors->has('jam_selesai') ? 'rw-invalid' : '' }}">
                @error('jam_selesai')<span class="rw-error">{{ $message }}</span>@enderror
            </div>

            <div class="rw-form-group rw-col-full">
                <label class="rw-label">Lokasi</label>
                <input type="text" name="lokasi" value="{{ old('lokasi') }}" class="rw-input {{ $errors->has('lokasi') ? 'rw-invalid' : '' }}" placeholder="Contoh: Griya Satumimika, Puskesmas">
                @error('lokasi')<span class="rw-error">{{ $message }}</span>@enderror
            </div>

            <div class="rw-form-group rw-col-full">
                <label class="rw-label">Keterangan</label>
                <textarea name="keterangan" rows="2" class="rw-input {{ $errors->has('keterangan') ? 'rw-invalid' : '' }}" style="resize:vertical;" placeholder="Opsional">{{ old('keterangan') }}</textarea>
                @error('keterangan')<span class="rw-error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="jadwal-form-actions">
            <button type="submit" class="jadwal-btn-submit jadwal-btn-bulk">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Buat Jadwal Sekaligus
            </button>
            <a href="{{ route('dashboard.jadwal-petugas.index') }}" class="jadwal-btn-cancel">Batal</a>
        </div>
    </form>
</div>

@push('styles')
<style>
.jadwal-form-card { padding: 0; overflow: hidden; }
.jadwal-form-header { padding: 1.25rem 1.75rem; border-bottom: 1px solid var(--border); background: #f8fafc; }
.jadwal-back-link { display: inline-block; font-size: 0.85rem; font-weight: 600; color: #64748b; margin-bottom: 0.75rem; text-decoration: none; }
.jadwal-back-link:hover { color: var(--primary); }
.jadwal-form-header-main { display: flex; align-items: center; gap: 1rem; }
.jadwal-form-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.jadwal-form-icon-bulk { background: linear-gradient(135deg, #fef3c7, #fde68a); border: 1px solid #fcd34d; color: #b45309; }
.jadwal-form-title { font-size: 1.1rem; font-weight: 700; color: #0f172a; margin: 0 0 2px; }
.jadwal-form-subtitle { font-size: 0.82rem; color: #64748b; margin: 0; }
.jadwal-form-bulk-hint {
    margin: 0 1.75rem 1rem; padding: 1rem 1.25rem;
    background: linear-gradient(135deg, #eff6ff, #dbeafe); border: 1px solid #93c5fd; border-radius: 12px;
    font-size: 0.9rem; color: #1d4ed8; display: flex; align-items: flex-start; gap: 0.75rem;
}
.jadwal-form-bulk-icon { font-size: 1.25rem; }
.jp-breadcrumb { font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1rem; }
.jp-breadcrumb a { color: var(--primary); text-decoration: none; }
.jp-breadcrumb a:hover { text-decoration: underline; }
.jp-breadcrumb-sep { margin: 0 0.35rem; opacity: 0.6; }
.jp-breadcrumb-current { color: var(--text); font-weight: 600; }
.jadwal-form { max-width: 860px; padding: 1.5rem 1.75rem; }
.jadwal-form .rw-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
.jadwal-form .rw-col-full { grid-column: 1 / -1; }
.jadwal-form .rw-form-group { display: flex; flex-direction: column; gap: 0.35rem; }
.jadwal-form .rw-label { font-size: 0.85rem; font-weight: 600; color: var(--text); }
.jadwal-form .rw-required { color: #dc2626; }
.jadwal-form .rw-hint { font-size: 0.8rem; color: #64748b; margin: 0 0 0.5rem; }
.jadwal-form .rw-input { padding: 0.55rem 0.875rem; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.9rem; font-family: inherit; background: #fff; width: 100%; }
.jadwal-form .rw-input:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.12); }
.jadwal-form .rw-invalid { border-color: #ef4444 !important; }
.jadwal-form .rw-error { font-size: 0.8rem; color: #dc2626; }
.jadwal-hari-grid { display: flex; flex-wrap: wrap; gap: 0.5rem; }
.jadwal-hari-chip {
    display: inline-flex; align-items: center; gap: 0.5rem;
    padding: 0.5rem 1rem; background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 10px;
    font-size: 0.875rem; font-weight: 600; color: #475569; cursor: pointer;
    transition: all 0.2s;
}
.jadwal-hari-chip:hover { background: #f1f5f9; border-color: #cbd5e1; }
.jadwal-hari-chip input { accent-color: var(--primary); cursor: pointer; }
.jadwal-hari-chip:has(input:checked) { background: linear-gradient(135deg, #eff6ff, #dbeafe); border-color: #60a5fa; color: #1d4ed8; }
.jadwal-form-actions { display: flex; gap: 0.875rem; padding: 1.5rem 1.75rem; border-top: 1px solid var(--border); background: #f8fafc; }
.jadwal-btn-submit { display: inline-flex; align-items: center; gap: 8px; padding: 0.65rem 1.5rem; background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff; font-size: 0.925rem; font-weight: 700; border: none; border-radius: 10px; cursor: pointer; font-family: inherit; }
.jadwal-btn-submit:hover { background: linear-gradient(135deg, #1d4ed8, #1e40af); transform: translateY(-1px); }
.jadwal-btn-bulk { background: linear-gradient(135deg, #059669, #047857) !important; }
.jadwal-btn-bulk:hover { background: linear-gradient(135deg, #047857, #065f46) !important; }
.jadwal-btn-cancel { display: inline-flex; align-items: center; padding: 0.65rem 1.25rem; background: #fff; color: #64748b; font-size: 0.9rem; font-weight: 600; border: 1.5px solid #cbd5e1; border-radius: 10px; text-decoration: none; }
.jadwal-btn-cancel:hover { background: #f1f5f9; color: #334155; border-color: #94a3b8; }
@media (max-width: 640px) { .jadwal-form .rw-form-grid { grid-template-columns: 1fr; } .jadwal-form .rw-col-full { grid-column: 1; } }
</style>
@endpush

@push('scripts')
<script>
document.querySelector('form').addEventListener('submit', function(e) {
    var checked = document.querySelectorAll('input[name="hari[]"]:checked').length;
    if (checked === 0) {
        e.preventDefault();
        alert('Pilih minimal satu hari dalam minggu (Senin–Minggu).');
        return false;
    }
});
</script>
@endpush
@endsection
