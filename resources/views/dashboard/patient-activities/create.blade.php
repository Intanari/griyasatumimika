@extends('layouts.dashboard')

@section('title', 'Tambah Aktivitas Pasien')
@section('topbar-title', 'Tambah Aktivitas Pasien')

@section('content')
<div class="card rw-form-card">

    <div class="rw-form-topbar">
        <a href="{{ route('dashboard.patient-activities.index') }}" class="rw-back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
        <span class="rw-breadcrumb-sep">›</span>
        <span class="rw-breadcrumb-current">Tambah Aktivitas Pasien</span>
    </div>

    <div class="rw-form-header">
        <div class="rw-form-header-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/><path d="M12 8v8"/><path d="M8 12h8"/></svg>
        </div>
        <div>
            <h2 class="rw-form-title">Tambah Aktivitas Pasien</h2>
            <p class="rw-form-subtitle">Catat aktivitas rehabilitasi pasien harian</p>
        </div>
    </div>

    <form action="{{ route('dashboard.patient-activities.store') }}" method="POST" class="rw-form">
        @csrf

        <div class="rw-section-block">
            <div class="rw-section-head">
                <div class="rw-section-num">1</div>
                <div>
                    <span class="rw-section-title">Informasi Pasien &amp; Waktu</span>
                    <p class="rw-section-desc">Pilih pasien dan tanggal aktivitas</p>
                </div>
            </div>
            <div class="rw-grid-2">
                <div class="rw-form-group rw-col-full">
                    <label class="rw-label">Nama Pasien <span class="rw-required">*</span></label>
                    <select name="patient_id" class="rw-select {{ $errors->has('patient_id') ? 'rw-invalid' : '' }}" required>
                        <option value="">— Pilih Pasien —</option>
                        @foreach($patients as $p)
                            <option value="{{ $p->id }}" {{ old('patient_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_lengkap }}</option>
                        @endforeach
                    </select>
                    @error('patient_id')<span class="rw-error-msg">{{ $message }}</span>@enderror
                </div>
                <div class="rw-form-group">
                    <label class="rw-label">Tanggal <span class="rw-required">*</span></label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', now()->format('Y-m-d')) }}"
                        class="rw-input {{ $errors->has('tanggal') ? 'rw-invalid' : '' }}" required>
                    @error('tanggal')<span class="rw-error-msg">{{ $message }}</span>@enderror
                </div>
                <div class="rw-form-group">
                    <label class="rw-label">Jenis Aktivitas <span class="rw-required">*</span></label>
                    <select name="jenis_aktivitas" class="rw-select {{ $errors->has('jenis_aktivitas') ? 'rw-invalid' : '' }}" required>
                        @foreach(\App\Models\PatientActivity::JENIS_AKTIVITAS as $key => $label)
                            <option value="{{ $key }}" {{ old('jenis_aktivitas') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('jenis_aktivitas')<span class="rw-error-msg">{{ $message }}</span>@enderror
                </div>
                <div class="rw-form-group">
                    <label class="rw-label">Tempat <span class="rw-optional">(opsional)</span></label>
                    <input type="text" name="tempat" value="{{ old('tempat') }}"
                        class="rw-input {{ $errors->has('tempat') ? 'rw-invalid' : '' }}"
                        placeholder="Contoh: Ruang Terapi, Lapangan">
                    @error('tempat')<span class="rw-error-msg">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <div class="rw-section-block">
            <div class="rw-section-head">
                <div class="rw-section-num rw-section-num-2">2</div>
                <div>
                    <span class="rw-section-title">Waktu &amp; Durasi</span>
                    <p class="rw-section-desc">Waktu mulai, selesai, atau durasi dalam menit</p>
                </div>
            </div>
            <div class="rw-grid-2">
                <div class="rw-form-group">
                    <label class="rw-label">Waktu Mulai <span class="rw-optional">(opsional)</span></label>
                    <input type="time" name="waktu_mulai" value="{{ old('waktu_mulai') }}"
                        class="rw-input {{ $errors->has('waktu_mulai') ? 'rw-invalid' : '' }}">
                    @error('waktu_mulai')<span class="rw-error-msg">{{ $message }}</span>@enderror
                </div>
                <div class="rw-form-group">
                    <label class="rw-label">Waktu Selesai <span class="rw-optional">(opsional)</span></label>
                    <input type="time" name="waktu_selesai" value="{{ old('waktu_selesai') }}"
                        class="rw-input {{ $errors->has('waktu_selesai') ? 'rw-invalid' : '' }}">
                    @error('waktu_selesai')<span class="rw-error-msg">{{ $message }}</span>@enderror
                </div>
                <div class="rw-form-group">
                    <label class="rw-label">Durasi (menit) <span class="rw-optional">(opsional)</span></label>
                    <input type="number" name="durasi_menit" value="{{ old('durasi_menit') }}" min="0" max="1440"
                        class="rw-input {{ $errors->has('durasi_menit') ? 'rw-invalid' : '' }}"
                        placeholder="Contoh: 60">
                    @error('durasi_menit')<span class="rw-error-msg">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <div class="rw-section-block">
            <div class="rw-section-head">
                <div class="rw-section-num rw-section-num-3">3</div>
                <div>
                    <span class="rw-section-title">Deskripsi &amp; Evaluasi</span>
                    <p class="rw-section-desc">Detail aktivitas dan hasil evaluasi/capaian</p>
                </div>
            </div>
            <div class="rw-grid-full">
                <div class="rw-form-group">
                    <label class="rw-label">Deskripsi Aktivitas <span class="rw-optional">(opsional)</span></label>
                    <textarea name="deskripsi" rows="3" class="rw-textarea {{ $errors->has('deskripsi') ? 'rw-invalid' : '' }}"
                        placeholder="Catatan atau deskripsi aktivitas yang dilakukan pasien...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')<span class="rw-error-msg">{{ $message }}</span>@enderror
                </div>
                <div class="rw-form-group">
                    <label class="rw-label">Hasil Evaluasi / Capaian <span class="rw-optional">(opsional)</span></label>
                    <textarea name="hasil_evaluasi" rows="3" class="rw-textarea {{ $errors->has('hasil_evaluasi') ? 'rw-invalid' : '' }}"
                        placeholder="Evaluasi hasil aktivitas, capaian, atau catatan perkembangan pasien...">{{ old('hasil_evaluasi') }}</textarea>
                    @error('hasil_evaluasi')<span class="rw-error-msg">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <div class="rw-form-footer">
            <button type="submit" class="rw-submit-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                Simpan Aktivitas
            </button>
            <a href="{{ route('dashboard.patient-activities.index') }}" class="rw-cancel-btn">Batal</a>
        </div>
    </form>
</div>

@push('styles')
<style>
.rw-form-card { padding: 0; overflow: hidden; }
.rw-form-topbar { display: flex; align-items: center; padding: 1rem 1.75rem; border-bottom: 1px solid var(--border); background: #f8fafc; }
.rw-back-btn { display: inline-flex; align-items: center; gap: 4px; font-size: 0.85rem; font-weight: 600; color: #64748b; text-decoration: none; padding: 4px 8px; border-radius: 7px; transition: all 0.15s; }
.rw-back-btn:hover { color: #1e293b; background: #e2e8f0; }
.rw-breadcrumb-sep { color: #cbd5e1; font-size: 0.9rem; margin: 0 0.5rem; }
.rw-breadcrumb-current { font-size: 0.85rem; color: #334155; font-weight: 600; }
.rw-form-header { display: flex; align-items: center; gap: 1rem; padding: 1.5rem 1.75rem; border-bottom: 1px solid var(--border); }
.rw-form-header-icon { width: 48px; height: 48px; flex-shrink: 0; border-radius: 12px; background: linear-gradient(135deg, #eff6ff, #dbeafe); display: flex; align-items: center; justify-content: center; color: #2563eb; border: 1px solid #bfdbfe; }
.rw-form-title { font-size: 1.1rem; font-weight: 700; color: #0f172a; margin: 0 0 3px; }
.rw-form-subtitle { font-size: 0.82rem; color: #64748b; margin: 0; }
.rw-form { max-width: 860px; }
.rw-section-block { padding: 1.5rem 1.75rem; border-bottom: 1px solid #f1f5f9; }
.rw-section-head { display: flex; align-items: flex-start; gap: 0.875rem; margin-bottom: 1.5rem; }
.rw-section-num { width: 28px; height: 28px; flex-shrink: 0; border-radius: 50%; background: linear-gradient(135deg, #2563eb, #3b82f6); color: #fff; font-size: 0.8rem; font-weight: 700; display: flex; align-items: center; justify-content: center; margin-top: 1px; }
.rw-section-num-2 { background: linear-gradient(135deg, #7c3aed, #a78bfa); }
.rw-section-num-3 { background: linear-gradient(135deg, #059669, #10b981); }
.rw-section-title { font-size: 0.9rem; font-weight: 700; color: #1e293b; display: block; margin-bottom: 2px; }
.rw-section-desc { font-size: 0.78rem; color: #94a3b8; margin: 0; }
.rw-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
.rw-col-full { grid-column: 1 / -1; }
.rw-form-group { display: flex; flex-direction: column; gap: 6px; }
.rw-label { font-size: 0.875rem; font-weight: 600; color: #1e293b; }
.rw-required { color: #ef4444; }
.rw-optional { font-size: 0.75rem; font-weight: 400; color: #94a3b8; }
.rw-input, .rw-select, .rw-textarea { width: 100%; padding: 0.625rem 0.875rem; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.9rem; font-family: inherit; background: #fff; color: #1e293b; transition: border-color 0.15s, box-shadow 0.15s; }
.rw-input:focus, .rw-select:focus, .rw-textarea:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.12); }
.rw-textarea { resize: vertical; min-height: 96px; line-height: 1.6; }
.rw-invalid { border-color: #ef4444 !important; }
.rw-error-msg { font-size: 0.8rem; color: #dc2626; }
.rw-form-footer { display: flex; align-items: center; gap: 0.875rem; padding: 1.5rem 1.75rem; background: #f8fafc; border-top: 1px solid var(--border); }
.rw-submit-btn { display: inline-flex; align-items: center; gap: 7px; padding: 0.65rem 1.5rem; background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff; font-size: 0.925rem; font-weight: 700; border: none; border-radius: 10px; cursor: pointer; font-family: inherit; box-shadow: 0 2px 10px rgba(37,99,235,0.35); transition: all 0.18s ease; }
.rw-submit-btn:hover { background: linear-gradient(135deg, #1d4ed8, #1e40af); box-shadow: 0 4px 16px rgba(37,99,235,0.45); transform: translateY(-1px); }
.rw-cancel-btn { display: inline-flex; padding: 0.65rem 1.25rem; background: #fff; color: #64748b; font-size: 0.9rem; font-weight: 600; border: 1.5px solid #cbd5e1; border-radius: 10px; text-decoration: none; transition: all 0.15s; }
.rw-cancel-btn:hover { background: #f1f5f9; color: #334155; border-color: #94a3b8; }
.rw-grid-full { display: flex; flex-direction: column; gap: 1.25rem; }
@media (max-width: 640px) { .rw-grid-2 { grid-template-columns: 1fr; } }
</style>
@endpush
@push('scripts')
<script>
(function(){
    var wm = document.querySelector('input[name="waktu_mulai"]');
    var ws = document.querySelector('input[name="waktu_selesai"]');
    var dm = document.querySelector('input[name="durasi_menit"]');
    function calc(){
        if(!wm || !ws || !dm) return;
        var v1 = wm.value, v2 = ws.value;
        if(!v1 || !v2) return;
        var [h1,m1]=v1.split(':').map(Number), [h2,m2]=v2.split(':').map(Number);
        var d = (h2*60+m2) - (h1*60+m1);
        dm.value = d > 0 ? d : '';
    }
    if(wm) wm.addEventListener('change', calc);
    if(ws) ws.addEventListener('change', calc);
})();
</script>
@endpush
@endsection
