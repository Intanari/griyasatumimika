@extends('layouts.dashboard')

@section('title', 'Aktivitas Pasien')
@section('topbar-title', 'Aktivitas Pasien')

@section('content')
<a href="{{ route('dashboard') }}" class="page-back-link">Kembali</a>

{{-- Kartu terpisah: Tambah Aktivitas Pasien (tidak digabung dengan tabel) --}}
<div class="card pa-card pa-card-form">
    <div class="pa-header">
        <h1 class="pa-title">Tambah Aktivitas Pasien</h1>
        <button type="button" class="pa-btn-add" id="btnTambahAktivitas" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Aktivitas Pasien
        </button>
    </div>

    {{-- Form Tambah Aktivitas (collapse) — kotak ini terpisah dari tabel di bawah --}}
    <div class="pa-form-wrap" id="formTambahAktivitas" hidden>
        <form action="{{ route('dashboard.patient-activities.store-simple') }}" method="POST" class="pa-form" enctype="multipart/form-data">
            @csrf

            <div class="pa-form-section">
                <label class="pa-label">Pilih Pasien <span class="pa-required">*</span></label>
                <div class="pa-checkbox-group">
                    @forelse($patients as $p)
                        <label class="pa-checkbox-item">
                            <input type="checkbox" name="patient_ids[]" value="{{ $p->id }}" {{ in_array($p->id, old('patient_ids', [])) ? 'checked' : '' }}>
                            <span>{{ $p->nama_lengkap }}</span>
                        </label>
                    @empty
                        <p class="pa-empty-hint">Belum ada data pasien.</p>
                    @endforelse
                </div>
                @error('patient_ids')<span class="pa-error">{{ $message }}</span>@enderror
            </div>

            <div class="pa-form-section">
                <label class="pa-label" for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" class="pa-textarea" placeholder="Tulis deskripsi...">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')<span class="pa-error">{{ $message }}</span>@enderror
            </div>

            <div class="pa-form-section">
                <label class="pa-label">Gambar / Foto <span class="pa-optional">(opsional, bisa banyak)</span></label>
                <div class="pa-image-options">
                    <label class="pa-image-btn pa-image-file" for="imagesFile">
                        <span class="pa-image-icon">📁</span>
                        <span>Unggah dari Galeri (banyak)</span>
                    </label>
                    <input type="file" name="images[]" id="imagesFile" accept="image/*" multiple class="pa-file-input">
                    <label class="pa-image-btn pa-image-camera" for="imagesCamera">
                        <span class="pa-image-icon">📷</span>
                        <span>Ambil Foto (Kamera)</span>
                    </label>
                    <input type="file" name="images_camera[]" id="imagesCamera" accept="image/*" capture="environment" multiple class="pa-file-input">
                </div>
                <p class="pa-image-hint">Maks. 20 foto, masing-masing 5 MB. Format: JPG, PNG, GIF, WebP</p>
                <div class="pa-preview-list" id="imagePreviewList"></div>
                @error('images')<span class="pa-error">{{ $message }}</span>@enderror
                @error('images.*')<span class="pa-error">{{ $message }}</span>@enderror
            </div>

            <div class="pa-form-footer">
                <button type="submit" class="pa-btn-save">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Aktifitas Pasien
                </button>
                <button type="button" class="pa-btn-cancel" id="btnCancelTambah">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- Kartu terpisah: Tabel Aktivitas Pasien --}}
<div class="card pa-card pa-card-table">
    <div class="pa-table-header">
        <h2 class="pa-title">Data Aktivitas Pasien</h2>
    </div>
    <div class="pa-data-section">
        <p class="page-table-desc">
            Tabel di bawah menampilkan riwayat aktivitas pasien (tanggal, nama pasien, deskripsi, dan gambar).
            Gunakan tombol <strong>Tambah Aktivitas Pasien</strong> di atas untuk menambahkan catatan aktivitas baru.
        </p>
        @if ($groups->isEmpty())
            <div class="pa-empty">
                <p class="pa-empty-title">Belum ada data aktivitas pasien</p>
                <p class="pa-empty-desc">Klik tombol &ldquo;Tambah Aktivitas Pasien&rdquo; untuk mulai mencatat aktivitas.</p>
            </div>
        @else
            <div class="pa-table-wrap">
                <table class="pa-table">
                <thead>
                    <tr>
                        <th class="pa-th-no">No</th>
                        <th>Tanggal Waktu</th>
                        <th>Nama Pasien</th>
                        <th>Deskripsi</th>
                        <th class="pa-th-gambar">Gambar</th>
                        <th class="pa-th-aksi">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($groups as $i => $g)
                    <tr>
                        <td class="pa-td-no" data-label="No">{{ $groups->firstItem() + $i }}</td>
                        <td class="pa-td-datetime" data-label="Tanggal Waktu">
                            <span class="pa-date">{{ $g->tanggal->translatedFormat('l, j F Y') }}</span>
                            <span class="pa-time">{{ $g->waktu }}</span>
                        </td>
                        <td data-label="Nama Pasien">{{ $g->pasien }}</td>
                        <td class="pa-td-desc" data-label="Deskripsi">{{ $g->deskripsi ? \Str::limit($g->deskripsi, 80) : '–' }}</td>
                        <td class="pa-td-gambar" data-label="Gambar">
                            @if(!empty($g->image_urls))
                                <div class="pa-thumbs-wrap">
                                    @foreach($g->image_urls as $url)
                                        <a href="{{ $url }}" target="_blank" rel="noopener" class="pa-thumb-link">
                                            <img src="{{ $url }}" alt="Aktivitas" class="pa-thumb">
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                –
                            @endif
                        </td>
                        <td class="pa-td-aksi" data-label="Aksi">
                            <div class="pa-action-buttons">
                                <a href="{{ route('dashboard.patient-activities.show', $g->id) }}" class="pa-btn pa-btn-detail" title="Detail">Detail</a>
                                <a href="{{ route('dashboard.patient-activities.edit', $g->id) }}" class="pa-btn pa-btn-edit" title="Edit">Edit</a>
                                <form action="{{ route('dashboard.patient-activities.destroy', $g->id) }}" method="POST" class="pa-action-form" data-confirm="Yakin ingin menghapus aktivitas ini?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="pa-btn pa-btn-hapus" title="Hapus">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

            @if ($groups->hasPages())
                <div class="pa-pagination">
                    {{ $groups->links('pagination::default') }}
                </div>
            @endif
        @endif
    </div>
</div>{{-- akhir kartu tabel --}}

@push('styles')
<style>
.pa-card { padding: 0; overflow: hidden; }
.pa-card-table { margin-top: 1.5rem; }
.pa-table-header { padding: 1.25rem 1.75rem; border-bottom: 1px solid var(--border); }
.pa-table-header .pa-title { font-size: 1.05rem; }
.pa-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; padding: 1.5rem 1.75rem; border-bottom: 1px solid var(--border); }
.pa-title { font-size: 1.15rem; font-weight: 700; color: var(--text); margin: 0; }
.pa-btn-add { display: inline-flex; align-items: center; gap: 8px; padding: 0.6rem 1.25rem; background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff; font-size: 0.9rem; font-weight: 600; border: none; border-radius: 10px; cursor: pointer; font-family: inherit; box-shadow: 0 2px 8px rgba(37,99,235,0.3); transition: all 0.2s; }
.pa-btn-add:hover { background: linear-gradient(135deg, #1d4ed8, #1e40af); box-shadow: 0 4px 14px rgba(37,99,235,0.4); transform: translateY(-1px); }
.pa-form-wrap { padding: 1.5rem 1.75rem; border-bottom: 1px solid var(--border); background: #f8fafc; }
.pa-form-wrap[hidden] { display: none !important; }
.pa-form { max-width: 640px; }
/* Bagian data tabel: hanya di luar form Tambah Aktifitas Pasien */
.pa-data-section { padding: 1.5rem 1.75rem; }
.pa-form-section { margin-bottom: 1.25rem; }
.pa-label { display: block; font-size: 0.875rem; font-weight: 600; color: var(--text); margin-bottom: 0.5rem; }
.pa-required { color: #dc2626; }
.pa-checkbox-group { display: flex; flex-wrap: wrap; gap: 0.75rem 1.5rem; padding: 0.75rem; background: #fff; border: 1px solid var(--border); border-radius: 10px; max-height: 180px; overflow-y: auto; }
.pa-checkbox-item { display: flex; align-items: center; gap: 8px; font-size: 0.9rem; cursor: pointer; white-space: nowrap; }
.pa-checkbox-item input { width: 18px; height: 18px; accent-color: #2563eb; cursor: pointer; }
.pa-empty-hint { font-size: 0.9rem; color: var(--text-muted); margin: 0; }
.pa-optional { font-size: 0.75rem; font-weight: 400; color: #94a3b8; }
.pa-image-options { display: flex; gap: 1rem; flex-wrap: wrap; }
.pa-image-btn { display: inline-flex; align-items: center; gap: 8px; padding: 0.65rem 1.25rem; background: #fff; border: 2px dashed #cbd5e1; border-radius: 10px; font-size: 0.9rem; font-weight: 600; color: #475569; cursor: pointer; transition: all 0.2s; }
.pa-image-btn:hover { border-color: #2563eb; color: #2563eb; background: #eff6ff; }
.pa-image-icon { font-size: 1.25rem; }
.pa-file-input { position: absolute; width: 0.1px; height: 0.1px; opacity: 0; overflow: hidden; }
.pa-image-hint { font-size: 0.78rem; color: #94a3b8; margin: 0.5rem 0 0; }
.pa-preview-list { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 0.75rem; }
.pa-preview-list img { width: 64px; height: 64px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border); }
.pa-textarea { width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.9rem; font-family: inherit; resize: vertical; min-height: 100px; line-height: 1.5; }
.pa-textarea:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.12); }
.pa-error { display: block; font-size: 0.8rem; color: #dc2626; margin-top: 0.35rem; }
.pa-form-footer { display: flex; align-items: center; gap: 0.75rem; margin-top: 1.25rem; }
.pa-btn-save { display: inline-flex; align-items: center; gap: 8px; padding: 0.6rem 1.35rem; background: linear-gradient(135deg, #059669, #10b981); color: #fff; font-size: 0.9rem; font-weight: 600; border: none; border-radius: 10px; cursor: pointer; font-family: inherit; }
.pa-btn-save:hover { background: linear-gradient(135deg, #047857, #059669); box-shadow: 0 2px 10px rgba(16,185,129,0.4); transform: translateY(-1px); }
.pa-btn-cancel { padding: 0.6rem 1.2rem; background: #fff; color: #64748b; font-size: 0.9rem; font-weight: 600; border: 1.5px solid #cbd5e1; border-radius: 10px; cursor: pointer; font-family: inherit; }
.pa-btn-cancel:hover { background: #f1f5f9; color: #334155; }
.pa-empty { text-align: center; padding: 3rem 2rem; color: var(--text-muted); }
.pa-empty-title { font-size: 1rem; font-weight: 700; color: var(--text); margin-bottom: 0.4rem; }
.pa-empty-desc { font-size: 0.9rem; margin: 0; }
.pa-table-wrap { overflow-x: auto; border-radius: 12px; border: 1px solid var(--border); }
.pa-table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
.pa-table thead th { padding: 1rem 1.5rem; text-align: left; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: #64748b; background: #f8fafc; border-bottom: 1px solid #e2e8f0; }
.pa-table thead th:first-child { border-radius: 12px 0 0 0; }
.pa-table thead th:last-child { border-radius: 0 12px 0 0; }
.pa-th-no { width: 56px; text-align: center; }
.pa-th-gambar { width: 180px; text-align: center; min-width: 180px; }
.pa-td-gambar { text-align: center; vertical-align: middle; padding: 1rem 1.5rem !important; }
.pa-thumbs-wrap { display: flex; flex-wrap: wrap; gap: 8px; justify-content: center; align-items: center; }
.pa-thumb-link { display: inline-block; }
.pa-thumb { width: 88px; height: 88px; object-fit: cover; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.06); transition: transform 0.2s, box-shadow 0.2s; }
.pa-thumb:hover { transform: scale(1.05); box-shadow: 0 4px 12px rgba(0,0,0,0.1); opacity: 1; }
.pa-table tbody td { padding: 1.25rem 1.5rem; border-bottom: 1px solid #f1f5f9; vertical-align: top; color: var(--text); }
.pa-table tbody tr:last-child td { border-bottom: none; }
.pa-table tbody tr:hover td { background: #f8fbff; }
.pa-td-no { text-align: center; color: #94a3b8; font-weight: 600; }
.pa-td-datetime { min-width: 200px; }
.pa-td-datetime .pa-date { display: block; font-weight: 600; color: #1d4ed8; margin-bottom: 0.35rem; }
.pa-td-datetime .pa-time { display: block; font-size: 0.85rem; font-weight: 600; color: #64748b; }
.pa-td-desc { max-width: 360px; line-height: 1.5; }
.pa-th-aksi { width: 160px; text-align: center; min-width: 140px; }
.pa-td-aksi { text-align: center; vertical-align: middle; white-space: nowrap; }
.pa-action-buttons { display: flex; flex-wrap: wrap; gap: 0.5rem; justify-content: center; align-items: center; }
.pa-action-form { display: inline; margin: 0; }
.pa-btn { display: inline-block; padding: 0.4rem 0.75rem; font-size: 0.8rem; font-weight: 600; border-radius: 8px; text-decoration: none; border: none; cursor: pointer; font-family: inherit; transition: all 0.2s; }
.pa-btn-detail { background: #eff6ff; color: #1d4ed8; }
.pa-btn-detail:hover { background: #dbeafe; }
.pa-btn-edit { background: #fef3c7; color: #b45309; }
.pa-btn-edit:hover { background: #fde68a; }
.pa-btn-hapus { background: #fee2e2; color: #dc2626; }
.pa-btn-hapus:hover { background: #fecaca; }
.pa-pagination { padding: 1.25rem 1.75rem; border-top: 1px solid var(--border); display: flex; justify-content: center; }
</style>
@endpush

@push('scripts')
<script>
(function(){
    var btn = document.getElementById('btnTambahAktivitas');
    var form = document.getElementById('formTambahAktivitas');
    var cancel = document.getElementById('btnCancelTambah');
    if (btn && form) {
        btn.addEventListener('click', function(){
            var show = form.hidden;
            form.hidden = !show;
            btn.setAttribute('aria-expanded', show);
            if (show) form.querySelector('textarea')?.focus();
        });
    }
    if (cancel && form) {
        cancel.addEventListener('click', function(){
            form.hidden = true;
            if (btn) btn.setAttribute('aria-expanded', 'false');
        });
    }
    // Show form if validation errors
    if (document.querySelector('.pa-error')) {
        form.hidden = false;
        if (btn) btn.setAttribute('aria-expanded', 'true');
    }

    // Multiple image preview (dari galeri + kamera)
    var imagesFile = document.getElementById('imagesFile');
    var imagesCamera = document.getElementById('imagesCamera');
    var previewList = document.getElementById('imagePreviewList');
    function refreshPreviews(){
        if (!previewList) return;
        var f1 = imagesFile && imagesFile.files ? imagesFile.files : [];
        var f2 = imagesCamera && imagesCamera.files ? imagesCamera.files : [];
        var all = [];
        for (var i = 0; i < f1.length; i++) all.push(f1[i]);
        for (var j = 0; j < f2.length; j++) all.push(f2[j]);
        previewList.innerHTML = '';
        all.forEach(function(file){
            var r = new FileReader();
            r.onload = function(){
                var img = document.createElement('img');
                img.src = r.result;
                previewList.appendChild(img);
            };
            r.readAsDataURL(file);
        });
    }
    if (imagesFile) imagesFile.addEventListener('change', refreshPreviews);
    if (imagesCamera) imagesCamera.addEventListener('change', refreshPreviews);
})();
</script>
@endpush
@endsection
