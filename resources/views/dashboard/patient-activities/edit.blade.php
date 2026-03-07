@extends('layouts.dashboard')

@section('title', 'Edit Aktivitas Pasien')
@section('topbar-title', 'Edit Aktivitas Pasien')

@section('content')
<div class="card rw-form-card">

    <div class="rw-form-topbar">
        <div class="rw-form-topbar-left">
            <a href="{{ route('dashboard.patient-activities.index') }}" class="rw-back-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <span class="rw-breadcrumb-sep">›</span>
            <span class="rw-breadcrumb-current">Edit Aktivitas Pasien</span>
        </div>
        <a href="{{ route('dashboard.patient-activities.show', $patientActivity) }}" class="rw-detail-link">Lihat Detail</a>
    </div>

    <div class="rw-form-header rw-form-header-edit">
        <div class="rw-form-header-icon rw-header-icon-edit">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        </div>
        <div>
            <h2 class="rw-form-title">Edit Aktivitas Pasien</h2>
            <p class="rw-form-subtitle">
                <strong>{{ $patientActivity->patient->nama_lengkap ?? '–' }}</strong>
                · {{ $patientActivity->tanggal->translatedFormat('d F Y') }} · {{ $patientActivity->jenis_aktivitas_label }}
            </p>
        </div>
    </div>

    <form action="{{ route('dashboard.patient-activities.update', $patientActivity) }}" method="POST" class="rw-form">
        @csrf
        @method('PUT')

        <div class="rw-section-block">
            <div class="rw-section-head">
                <div class="rw-section-num">1</div>
                <div>
                    <span class="rw-section-title">Informasi Pasien &amp; Waktu</span>
                </div>
            </div>
            <div class="rw-grid-2">
                <div class="rw-form-group rw-col-full">
                    <label class="rw-label">Nama Pasien <span class="rw-required">*</span></label>
                    <select name="patient_id" class="rw-select {{ $errors->has('patient_id') ? 'rw-invalid' : '' }}" required>
                        @foreach($patients as $p)
                            <option value="{{ $p->id }}" {{ old('patient_id', $patientActivity->patient_id) == $p->id ? 'selected' : '' }}>{{ $p->nama_lengkap }}</option>
                        @endforeach
                    </select>
                    @error('patient_id')<span class="rw-error-msg">{{ $message }}</span>@enderror
                </div>
                <div class="rw-form-group">
                    <label class="rw-label">Tanggal <span class="rw-required">*</span></label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $patientActivity->tanggal->format('Y-m-d')) }}"
                        class="rw-input {{ $errors->has('tanggal') ? 'rw-invalid' : '' }}" required>
                    @error('tanggal')<span class="rw-error-msg">{{ $message }}</span>@enderror
                </div>
                <div class="rw-form-group">
                    <label class="rw-label">Jenis Aktivitas <span class="rw-required">*</span></label>
                    <select name="jenis_aktivitas" class="rw-select {{ $errors->has('jenis_aktivitas') ? 'rw-invalid' : '' }}" required>
                        @foreach(\App\Models\PatientActivity::JENIS_AKTIVITAS as $key => $label)
                            <option value="{{ $key }}" {{ old('jenis_aktivitas', $patientActivity->jenis_aktivitas) == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('jenis_aktivitas')<span class="rw-error-msg">{{ $message }}</span>@enderror
                </div>
                <div class="rw-form-group">
                    <label class="rw-label">Tempat</label>
                    <input type="text" name="tempat" value="{{ old('tempat', $patientActivity->tempat) }}"
                        class="rw-input {{ $errors->has('tempat') ? 'rw-invalid' : '' }}">
                    @error('tempat')<span class="rw-error-msg">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <div class="rw-section-block">
            <div class="rw-section-head">
                <div class="rw-section-num rw-section-num-2">2</div>
                <div>
                    <span class="rw-section-title">Waktu &amp; Durasi</span>
                </div>
            </div>
            <div class="rw-grid-2">
                <div class="rw-form-group">
                    <label class="rw-label">Waktu Mulai</label>
                    <input type="time" name="waktu_mulai" value="{{ old('waktu_mulai', $patientActivity->waktu_mulai?->format('H:i')) }}"
                        class="rw-input {{ $errors->has('waktu_mulai') ? 'rw-invalid' : '' }}">
                    @error('waktu_mulai')<span class="rw-error-msg">{{ $message }}</span>@enderror
                </div>
                <div class="rw-form-group">
                    <label class="rw-label">Waktu Selesai</label>
                    <input type="time" name="waktu_selesai" value="{{ old('waktu_selesai', $patientActivity->waktu_selesai?->format('H:i')) }}"
                        class="rw-input {{ $errors->has('waktu_selesai') ? 'rw-invalid' : '' }}">
                    @error('waktu_selesai')<span class="rw-error-msg">{{ $message }}</span>@enderror
                </div>
                <div class="rw-form-group">
                    <label class="rw-label">Durasi (menit)</label>
                    <input type="number" name="durasi_menit" value="{{ old('durasi_menit', $patientActivity->durasi_menit) }}" min="0" max="1440"
                        class="rw-input {{ $errors->has('durasi_menit') ? 'rw-invalid' : '' }}">
                    @error('durasi_menit')<span class="rw-error-msg">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <div class="rw-section-block">
            <div class="rw-section-head">
                <div class="rw-section-num rw-section-num-3">3</div>
                <div>
                    <span class="rw-section-title">Deskripsi &amp; Evaluasi</span>
                </div>
            </div>
            <div class="rw-form-group">
                <label class="rw-label">Deskripsi Aktivitas</label>
                <textarea name="deskripsi" rows="3" class="rw-textarea {{ $errors->has('deskripsi') ? 'rw-invalid' : '' }}">{{ old('deskripsi', $patientActivity->deskripsi) }}</textarea>
                @error('deskripsi')<span class="rw-error-msg">{{ $message }}</span>@enderror
            </div>
            <div class="rw-form-group">
                <label class="rw-label">Hasil Evaluasi / Capaian</label>
                <textarea name="hasil_evaluasi" rows="3" class="rw-textarea {{ $errors->has('hasil_evaluasi') ? 'rw-invalid' : '' }}" placeholder="Evaluasi hasil aktivitas, capaian, atau catatan perkembangan pasien...">{{ old('hasil_evaluasi', $patientActivity->hasil_evaluasi) }}</textarea>
                @error('hasil_evaluasi')<span class="rw-error-msg">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="rw-form-footer">
            <button type="submit" class="rw-submit-btn">Simpan Perubahan</button>
            <a href="{{ route('dashboard.patient-activities.show', $patientActivity) }}" class="rw-cancel-btn">Batal</a>
        </div>
    </form>
</div>

@push('styles')
<style>
.rw-form-card { padding: 0; overflow: hidden; }
.rw-form-topbar { display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.75rem; border-bottom: 1px solid var(--border); background: #f8fafc; }
.rw-form-topbar-left { display: flex; align-items: center; gap: 0.5rem; }
.rw-back-btn { display: inline-flex; align-items: center; gap: 4px; font-size: 0.85rem; font-weight: 600; color: #64748b; text-decoration: none; padding: 4px 8px; border-radius: 7px; transition: all 0.15s; }
.rw-back-btn:hover { color: #1e293b; background: #e2e8f0; }
.rw-breadcrumb-sep { color: #cbd5e1; margin: 0 0.5rem; }
.rw-breadcrumb-current { font-size: 0.85rem; color: #334155; font-weight: 600; }
.rw-detail-link { display: inline-flex; font-size: 0.82rem; font-weight: 600; color: #2563eb; text-decoration: none; padding: 5px 10px; border-radius: 8px; border: 1px solid #bfdbfe; background: #eff6ff; transition: all 0.15s; }
.rw-detail-link:hover { background: #dbeafe; }
.rw-form-header { display: flex; align-items: center; gap: 1rem; padding: 1.5rem 1.75rem; border-bottom: 1px solid var(--border); }
.rw-form-header-icon { width: 48px; height: 48px; flex-shrink: 0; border-radius: 12px; background: linear-gradient(135deg, #eff6ff, #dbeafe); display: flex; align-items: center; justify-content: center; color: #2563eb; border: 1px solid #bfdbfe; }
.rw-header-icon-edit { background: linear-gradient(135deg, #f0fdf4, #dcfce7); color: #16a34a; border-color: #bbf7d0; }
.rw-form-title { font-size: 1.1rem; font-weight: 700; color: #0f172a; margin: 0 0 3px; }
.rw-form-subtitle { font-size: 0.82rem; color: #64748b; margin: 0; }
.rw-form-subtitle strong { color: #1e293b; }
.rw-form { max-width: 860px; }
.rw-section-block { padding: 1.5rem 1.75rem; border-bottom: 1px solid #f1f5f9; }
.rw-section-head { display: flex; align-items: flex-start; gap: 0.875rem; margin-bottom: 1.5rem; }
.rw-section-num { width: 28px; height: 28px; flex-shrink: 0; border-radius: 50%; background: linear-gradient(135deg, #2563eb, #3b82f6); color: #fff; font-size: 0.8rem; font-weight: 700; display: flex; align-items: center; justify-content: center; margin-top: 1px; }
.rw-section-num-2 { background: linear-gradient(135deg, #7c3aed, #a78bfa); }
.rw-section-num-3 { background: linear-gradient(135deg, #059669, #10b981); }
.rw-section-title { font-size: 0.9rem; font-weight: 700; color: #1e293b; }
.rw-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
.rw-col-full { grid-column: 1 / -1; }
.rw-form-group { display: flex; flex-direction: column; gap: 6px; }
.rw-label { font-size: 0.875rem; font-weight: 600; color: #1e293b; }
.rw-required { color: #ef4444; }
.rw-input, .rw-select, .rw-textarea { width: 100%; padding: 0.625rem 0.875rem; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.9rem; font-family: inherit; background: #fff; color: #1e293b; }
.rw-input:focus, .rw-select:focus, .rw-textarea:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.12); }
.rw-textarea { resize: vertical; min-height: 96px; line-height: 1.6; }
.rw-invalid { border-color: #ef4444 !important; }
.rw-error-msg { font-size: 0.8rem; color: #dc2626; }
.rw-form-footer { display: flex; gap: 0.875rem; padding: 1.5rem 1.75rem; background: #f8fafc; border-top: 1px solid var(--border); }
.rw-submit-btn { padding: 0.65rem 1.5rem; background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff; font-size: 0.925rem; font-weight: 700; border: none; border-radius: 10px; cursor: pointer; font-family: inherit; }
.rw-submit-btn:hover { filter: brightness(1.05); transform: translateY(-1px); }
.rw-cancel-btn { padding: 0.65rem 1.25rem; background: #fff; color: #64748b; font-size: 0.9rem; font-weight: 600; border: 1.5px solid #cbd5e1; border-radius: 10px; text-decoration: none; }
.rw-cancel-btn:hover { background: #f1f5f9; color: #334155; }
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
