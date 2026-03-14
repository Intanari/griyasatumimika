@extends('layouts.app')

@section('title', 'Laporan ODGJ')

@section('content')
    <section class="section page-hero" style="padding-top: calc(5.25rem + 72px);">
        <div class="section-inner">
            <div class="section-header-center anim-fade-down">
                <div class="section-tag">Laporan ODGJ</div>
                <h2 class="section-title">Laporkan Kasus ODGJ</h2>
                <p class="section-desc">Lengkapi formulir di bawah ini untuk melaporkan kasus penjemputan atau pengantaran ODGJ. Petugas akan segera menghubungi Anda.</p>
            </div>
        </div>
    </section>

    <section class="section section-odgj-form">
        <div class="section-inner">
            @if (session('success'))
                <div class="alert-success">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <div class="form-card odgj-form-card anim-fade-up anim-delay-1">
                <form action="{{ route('odgj-report.store') }}" method="POST" enctype="multipart/form-data" id="odgjForm">
                    @csrf

                    <div class="section-divider">Kategori Laporan</div>
                    <div class="form-group">
                        <label class="form-label">Pilih Kategori <span class="req">*</span></label>
                        <div class="kategori-options">
                            <label class="kategori-option {{ old('kategori') === 'penjemputan' ? 'selected' : '' }}" data-value="penjemputan">
                                <input type="radio" name="kategori" value="penjemputan" {{ old('kategori') === 'penjemputan' ? 'checked' : '' }} required>
                                <span class="kategori-icon">🚑</span>
                                <span class="kategori-text">Penjemputan ODGJ</span>
                            </label>
                            <label class="kategori-option {{ old('kategori') === 'pengantaran' ? 'selected' : '' }}" data-value="pengantaran">
                                <input type="radio" name="kategori" value="pengantaran" {{ old('kategori') === 'pengantaran' ? 'checked' : '' }}>
                                <span class="kategori-icon">🚗</span>
                                <span class="kategori-text">Pengantaran ODGJ</span>
                            </label>
                        </div>
                        @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="section-divider">Lokasi</div>
                    <div class="form-group">
                        <label class="form-label" for="lokasi">Lokasi / Alamat <span class="req">*</span></label>
                        <div class="lokasi-row">
                            <input type="text" id="lokasi" name="lokasi" class="form-input {{ $errors->has('lokasi') ? 'is-invalid' : '' }}" placeholder="Masukkan alamat atau lokasi kejadian" value="{{ old('lokasi') }}" required>
                            <button type="button" id="btnSerlok" class="btn-serlok">
                                📍 Serlok Lokasi
                            </button>
                        </div>
                        <input type="hidden" name="lokasi_lat" id="lokasi_lat" value="{{ old('lokasi_lat') }}">
                        <input type="hidden" name="lokasi_lng" id="lokasi_lng" value="{{ old('lokasi_lng') }}">
                        <div id="lokasiStatus" class="form-hint"></div>
                        @error('lokasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="section-divider">Deskripsi</div>
                    <div class="form-group">
                        <label class="form-label" for="deskripsi">Deskripsi Kejadian <span class="req">*</span></label>
                        <textarea id="deskripsi" name="deskripsi" class="form-input {{ $errors->has('deskripsi') ? 'is-invalid' : '' }}" placeholder="Jelaskan kondisi lengkap kejadian, lokasi detail, dan informasi lain yang diperlukan petugas..." maxlength="2000" required>{{ old('deskripsi') }}</textarea>
                        <div class="char-count-wrap"><span id="charCount">0</span>/2000</div>
                        @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="section-divider">Upload Foto</div>
                    <div class="form-group">
                        <label class="form-label">Upload Foto <span class="req">*</span></label>
                        <div class="form-hint">Gambar > 800 KB akan otomatis dikompresi untuk menghindari error upload.</div>
                        <input type="file" id="gambar" name="gambar" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" style="display:none;" required>
                        <div class="upload-actions">
                            <button type="button" class="btn-upload camera" id="btnCamera" title="Ambil foto dengan kamera">
                                📷 Ambil Foto
                            </button>
                            <button type="button" class="btn-upload" id="btnGallery" title="Pilih dari galeri">
                                📁 Pilih dari Galeri
                            </button>
                        </div>
                        <div id="gambarLabel" class="form-hint"></div>
                        <div id="gambarPreview" class="file-preview"></div>
                        @error('gambar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="section-divider">Kontak</div>
                    <div class="form-group">
                        <label class="form-label" for="email">Email <span class="req">*</span></label>
                        <input type="email" id="email" name="email" class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="contoh@email.com" value="{{ old('email') }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="kontak">Nomor HP / WhatsApp <span class="req">*</span></label>
                        <input type="text" id="kontak" name="kontak" class="form-input {{ $errors->has('kontak') ? 'is-invalid' : '' }}" placeholder="08xx-xxxx-xxxx" value="{{ old('kontak') }}">
                        @error('kontak')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn-submit odgj-btn-submit" id="submitBtn">
                        <span>📤</span> Kirim Laporan
                    </button>
                </form>
                <div class="trust-row">
                    <div class="trust-item"><span>🔐</span> Data Aman & Tersimpan</div>
                    <div class="trust-item"><span>📋</span> Petugas Akan Segera Menindaklanjuti</div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    .page-hero { background: transparent !important; }
    .page-hero .section-header-center { max-width: 720px; margin: 0 auto; text-align: center; }
    .page-hero .section-tag {
        font-size: 0.8rem;
        letter-spacing: 0.12em;
        background: rgba(255,255,255,0.12);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: 999px;
        padding-inline: 1rem;
        border: 1px solid rgba(255,255,255,0.3);
        color: #e0f2ff;
    }
    .page-hero .section-title {
        font-size: 2rem;
        line-height: 1.3;
        margin-bottom: 0.6rem;
        color: #ffffff;
    }
    .page-hero .section-desc {
        font-size: 0.95rem;
        line-height: 1.75;
        color: rgba(255,255,255,0.9);
    }
    .section-odgj-form { background: transparent; padding-top: 2rem; padding-bottom: 5rem; }
    .form-card.odgj-form-card {
        max-width: 680px;
        margin: 0 auto;
        padding: 2.5rem;
        background: rgba(255,255,255,0.12);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-radius: var(--radius-lg);
        border: 1px solid rgba(255,255,255,0.25);
        box-shadow: 0 16px 48px rgba(15,23,42,0.12);
    }
    .section-divider {
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: rgba(255,255,255,0.9);
        margin-bottom: 1.25rem;
        margin-top: 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .section-divider:first-child { margin-top: 0; }
    .section-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: rgba(255,255,255,0.3);
    }
    .form-group { margin-bottom: 1.25rem; }
    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: #ffffff;
        margin-bottom: 6px;
    }
    .form-label .req { color: #ef4444; margin-left: 2px; }
    .odgj-form-card .form-input,
    .odgj-form-card input.form-input,
    .odgj-form-card textarea.form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid rgba(255,255,255,0.35);
        border-radius: 14px;
        font-size: 0.95rem;
        font-family: inherit;
        color: #000000;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        outline: none;
    }
    .odgj-form-card .form-input:focus,
    .odgj-form-card input.form-input:focus,
    .odgj-form-card textarea.form-input:focus {
        border-color: rgba(59,130,246,0.8);
        box-shadow: 0 0 0 4px rgba(37,99,235,0.15);
        background: rgba(255,255,255,0.3);
    }
    .odgj-form-card .form-input.is-invalid { border-color: #ef4444; }
    .odgj-form-card .form-input::placeholder { color: #ffffff; }
    textarea.form-input { resize: vertical; min-height: 120px; }
    .form-hint { font-size: 0.78rem; color: rgba(255,255,255,0.85); margin-top: 6px; }
    .char-count-wrap { font-size: 0.75rem; color: rgba(255,255,255,0.75); margin-top: 4px; text-align: right; }
    .invalid-feedback { font-size: 0.8rem; color: #ef4444; margin-top: 4px; }

    .kategori-options { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .kategori-option {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 1rem 1.25rem;
        border: 2px solid rgba(255,255,255,0.35);
        border-radius: var(--radius-sm);
        cursor: pointer;
        transition: all 0.2s ease;
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }
    .kategori-option:hover { border-color: rgba(59,130,246,0.8); background: rgba(37,99,235,0.2); }
    .kategori-option.selected { border-color: var(--primary); background: rgba(37,99,235,0.25); }
    .kategori-option input { display: none; }
    .kategori-icon { font-size: 1.5rem; }
    .kategori-text { font-size: 0.95rem; font-weight: 600; color: #ffffff; }

    .lokasi-row { display: flex; gap: 0.75rem; }
    .lokasi-row .form-input { flex: 1; }
    .btn-serlok {
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        border: none;
        border-radius: var(--radius-sm);
        color: white;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
        transition: all 2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        display: flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 4px 14px rgba(37,99,235,0.3);
    }
    .btn-serlok:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(37,99,235,0.4); }
    .btn-serlok:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

    .file-input-wrap { position: relative; }
    .upload-actions { display: flex; gap: 0.75rem; flex-wrap: wrap; margin-top: 0.5rem; }
    .btn-upload {
        flex: 1;
        min-width: 140px;
        padding: 0.65rem 1rem;
        border: 2px solid rgba(255,255,255,0.35);
        border-radius: var(--radius-sm);
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        font-size: 0.9rem;
        font-weight: 600;
        color: #ffffff;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .btn-upload:hover { border-color: rgba(59,130,246,0.8); color: #e0f2ff; background: rgba(37,99,235,0.2); }
    .btn-upload.camera { border-color: var(--primary); color: #e0f2ff; background: rgba(37,99,235,0.25); }
    .btn-upload.camera:hover { background: rgba(37,99,235,0.35); }
    .btn-upload.camera:hover { background: rgba(37,99,235,0.12); }
    .file-preview {
        margin-top: 1rem;
        max-width: 280px;
        border-radius: var(--radius-sm);
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.3);
        position: relative;
    }
    .file-preview img { width: 100%; display: block; max-height: 200px; object-fit: cover; }
    .file-preview-remove {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(15,23,42,0.6);
        color: white;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .file-preview-remove:hover { background: #dc2626; }

    .btn-submit.odgj-btn-submit {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        border: none;
        border-radius: var(--radius-md);
        color: white;
        font-size: 1rem;
        font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        transition: all 2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        box-shadow: 0 4px 20px rgba(37,99,235,0.35);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 1.75rem;
    }
    .btn-submit.odgj-btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 28px rgba(37,99,235,0.45);
    }
    .alert-success {
        max-width: 680px;
        margin: 0 auto 1.5rem;
        padding: 1rem 1.25rem;
        background: rgba(16,185,129,0.2);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,0.3);
        border-radius: var(--radius-md);
        font-size: 0.9rem;
        color: #a7f3d0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .trust-row { display: flex; gap: 1.5rem; justify-content: center; margin-top: 1.5rem; flex-wrap: wrap; padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.2); }
    .trust-item { display: flex; align-items: center; gap: 6px; font-size: 0.8rem; color: rgba(255,255,255,0.9); }

    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

    @media (max-width: 600px) {
        .section-odgj-form { padding: 2rem 1rem 4rem; }
        .form-card.odgj-form-card { padding: 1.5rem; }
        .kategori-options { grid-template-columns: 1fr; }
        .lokasi-row { flex-direction: column; }
        .btn-serlok { width: 100%; justify-content: center; }
        .upload-actions { flex-direction: column; }
        .btn-upload { min-width: 100%; min-height: 44px; }
    }
</style>
@endpush

@push('scripts')
<script>
    const kategoriOptions = document.querySelectorAll('.kategori-option');
    kategoriOptions.forEach(opt => {
        opt.addEventListener('click', () => {
            kategoriOptions.forEach(o => o.classList.remove('selected'));
            opt.classList.add('selected');
            opt.querySelector('input').checked = true;
        });
    });

    const btnSerlok = document.getElementById('btnSerlok');
    const lokasiInput = document.getElementById('lokasi');
    const lokasiLat = document.getElementById('lokasi_lat');
    const lokasiLng = document.getElementById('lokasi_lng');
    const lokasiStatus = document.getElementById('lokasiStatus');

    btnSerlok.addEventListener('click', () => {
        if (!navigator.geolocation) {
            lokasiStatus.textContent = 'Geolokasi tidak didukung browser Anda.';
            lokasiStatus.style.color = '#dc2626';
            return;
        }
        btnSerlok.disabled = true;
        btnSerlok.innerHTML = '⏳ Mendeteksi...';
        lokasiStatus.textContent = 'Mendeteksi lokasi...';
        lokasiStatus.style.color = '';

        navigator.geolocation.getCurrentPosition(
            (pos) => {
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                lokasiLat.value = lat;
                lokasiLng.value = lng;

                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                    .then(r => r.json())
                    .then(data => {
                        const addr = data.display_name || data.address?.road || data.address?.suburb || data.address?.city || data.address?.state || data.address?.country || 'Lokasi terdeteksi';
                        lokasiInput.value = addr;
                        lokasiStatus.textContent = '✅ Lokasi berhasil dideteksi';
                        lokasiStatus.style.color = '#16a34a';
                    })
                    .catch(() => {
                        lokasiInput.value = `${lat}, ${lng}`;
                        lokasiStatus.textContent = '✅ Koordinat terdeteksi: ' + lat.toFixed(6) + ', ' + lng.toFixed(6);
                        lokasiStatus.style.color = '#16a34a';
                    });

                btnSerlok.disabled = false;
                btnSerlok.innerHTML = '📍 Serlok Lokasi';
            },
            (err) => {
                lokasiStatus.textContent = '❌ Gagal mendeteksi lokasi: ' + (err.message || 'Akses ditolak');
                lokasiStatus.style.color = '#dc2626';
                btnSerlok.disabled = false;
                btnSerlok.innerHTML = '📍 Serlok Lokasi';
            }
        );
    });

    const deskripsi = document.getElementById('deskripsi');
    const charCount = document.getElementById('charCount');
    deskripsi.addEventListener('input', () => { charCount.textContent = deskripsi.value.length; });
    charCount.textContent = deskripsi.value.length;

    const gambarInput = document.getElementById('gambar');
    const gambarLabel = document.getElementById('gambarLabel');
    const gambarPreview = document.getElementById('gambarPreview');
    const btnCamera = document.getElementById('btnCamera');
    const btnGallery = document.getElementById('btnGallery');
    const MAX_SIZE_KB = 800;
    const MAX_SIZE_BYTES = MAX_SIZE_KB * 1024;

    function compressImage(file) {
        return new Promise((resolve) => {
            if (!file || !file.type.startsWith('image/') || file.size <= MAX_SIZE_BYTES) {
                resolve(file);
                return;
            }
            const img = new Image();
            const url = URL.createObjectURL(file);
            img.onload = () => {
                URL.revokeObjectURL(url);
                const canvas = document.createElement('canvas');
                let w = img.width, h = img.height;
                const maxDim = 1200;
                if (w > maxDim || h > maxDim) {
                    if (w > h) { h = (h / w) * maxDim; w = maxDim; }
                    else { w = (w / h) * maxDim; h = maxDim; }
                }
                canvas.width = w;
                canvas.height = h;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, w, h);
                let quality = 0.8;
                const doBlob = () => {
                    canvas.toBlob((blob) => {
                        if (!blob) { resolve(file); return; }
                        if (blob.size <= MAX_SIZE_BYTES || quality <= 0.4) {
                            resolve(new File([blob], file.name.replace(/\.[^.]+$/, '.jpg'), { type: 'image/jpeg' }));
                        } else {
                            quality -= 0.15;
                            doBlob();
                        }
                    }, 'image/jpeg', quality);
                };
                doBlob();
            };
            img.onerror = () => resolve(file);
            img.src = url;
        });
    }

    function setFileToInput(file) {
        if (!file) return;
        const dt = new DataTransfer();
        dt.items.add(file);
        gambarInput.files = dt.files;
    }

    function showPreview(file) {
        gambarLabel.textContent = file ? file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)' : '';
        gambarPreview.innerHTML = '';
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (e) => {
                const wrap = document.createElement('div');
                wrap.style.position = 'relative';
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Preview';
                const btnRemove = document.createElement('button');
                btnRemove.type = 'button';
                btnRemove.className = 'file-preview-remove';
                btnRemove.innerHTML = '×';
                btnRemove.title = 'Hapus foto';
                btnRemove.addEventListener('click', () => {
                    gambarInput.value = '';
                    gambarLabel.textContent = '';
                    gambarPreview.innerHTML = '';
                });
                wrap.appendChild(img);
                wrap.appendChild(btnRemove);
                gambarPreview.appendChild(wrap);
            };
            reader.readAsDataURL(file);
        }
    }

    btnCamera.addEventListener('click', () => {
        gambarInput.setAttribute('capture', 'environment');
        gambarInput.accept = 'image/*';
        gambarInput.click();
    });

    btnGallery.addEventListener('click', () => {
        gambarInput.removeAttribute('capture');
        gambarInput.accept = 'image/jpeg,image/png,image/jpg,image/gif,image/webp';
        gambarInput.click();
    });

    gambarInput.addEventListener('change', async () => {
        let file = gambarInput.files[0];
        if (!file) return;
        if (file.size > MAX_SIZE_BYTES) {
            gambarLabel.textContent = 'Mengompresi gambar...';
            file = await compressImage(file);
            setFileToInput(file);
        }
        showPreview(file);
    });

    document.getElementById('odgjForm').addEventListener('submit', () => {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<span style="animation:spin 1s linear infinite;display:inline-block">⏳</span> Mengirim...';
    });
</script>
@endpush
