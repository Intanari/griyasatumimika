<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan ODGJ – PeduliJiwa</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    <style>
        :root { --primary: #3b82f6; --primary-dark: #2563eb; --accent: #0ea5e9; --text: #0f172a; --text-muted: #64748b; --border: #e2e8f0; --bg: linear-gradient(135deg, #eff6ff 0%, #dbeafe 50%, #e0f2fe 100%); }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; color: var(--text); background: var(--bg); min-height: 100vh; }
        .navbar { background: rgba(255,255,255,0.95); backdrop-filter: blur(12px); border-bottom: 1px solid var(--border); padding: 0 1.5rem; }
        .nav-inner { max-width: 1100px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; height: 72px; }
        .nav-logo { display: flex; align-items: center; gap: 12px; font-size: 1.2rem; font-weight: 800; color: var(--primary-dark); text-decoration: none; }
        .nav-logo-icon { width: 42px; height: 42px; background: linear-gradient(135deg, var(--primary), var(--accent)); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.1rem; box-shadow: 0 4px 14px rgba(59,130,246,0.35); }
        .nav-back { display: flex; align-items: center; gap: 6px; font-size: 0.9rem; font-weight: 500; color: var(--text-muted); text-decoration: none; transition: color 0.2s; }
        .nav-back:hover { color: var(--primary-dark); }
        .page-wrapper { max-width: 680px; margin: 0 auto; padding: 4rem 1.5rem 5rem; }
        .breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 0.85rem; color: var(--text-muted); margin-bottom: 2rem; }
        .breadcrumb a { color: var(--primary); font-weight: 500; }
        .form-header { text-align: center; margin-bottom: 2.5rem; }
        .form-badge { display: inline-flex; align-items: center; gap: 6px; background: linear-gradient(135deg, rgba(59,130,246,0.12), rgba(14,165,233,0.08)); color: var(--primary-dark); font-size: 0.85rem; font-weight: 600; padding: 6px 16px; border-radius: 100px; margin-bottom: 1rem; border: 1px solid rgba(59,130,246,0.2); }
        .form-title { font-size: 1.9rem; font-weight: 800; color: var(--text); line-height: 1.25; margin-bottom: 0.6rem; }
        .form-subtitle { font-size: 0.95rem; color: var(--text-muted); line-height: 1.6; }
        .form-card { background: white; border-radius: 24px; padding: 2rem; box-shadow: 0 10px 40px rgba(59,130,246,0.08); border: 1px solid var(--border); }
        .section-divider { font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: #8a8aaa; margin-bottom: 1.25rem; margin-top: 0.25rem; display: flex; align-items: center; gap: 10px; }
        .section-divider::after { content: ''; flex: 1; height: 1px; background: #ebebf8; }
        .form-group { margin-bottom: 1.25rem; }
        .form-label { display: block; font-size: 0.875rem; font-weight: 600; color: #1a1a2e; margin-bottom: 6px; }
        .form-label .req { color: #ef4444; margin-left: 2px; }
        .form-input { width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--border); border-radius: 12px; font-size: 0.95rem; font-family: inherit; color: var(--text); background: white; transition: all 0.2s; outline: none; }
        .form-input:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(59,130,246,0.1); }
        .form-input.is-invalid { border-color: #ef4444; }
        .form-input::placeholder { color: #aaa; }
        .invalid-feedback { font-size: 0.8rem; color: #ef4444; margin-top: 4px; }
        textarea.form-input { resize: vertical; min-height: 120px; }
        .kategori-options { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .kategori-option { display: flex; align-items: center; gap: 10px; padding: 1rem 1.25rem; border: 2px solid #e0e0f0; border-radius: 12px; cursor: pointer; transition: all 0.2s; background: white; }
        .kategori-option:hover { border-color: var(--primary); background: rgba(59,130,246,0.04); }
        .kategori-option.selected { border-color: var(--primary); background: rgba(59,130,246,0.08); }
        .kategori-option input { display: none; }
        .kategori-icon { font-size: 1.5rem; }
        .kategori-text { font-size: 0.95rem; font-weight: 600; color: #1a1a2e; }
        .lokasi-row { display: flex; gap: 0.75rem; }
        .lokasi-row .form-input { flex: 1; }
        .btn-serlok { padding: 0.75rem 1.5rem; background: linear-gradient(135deg, var(--primary), var(--accent)); border: none; border-radius: 12px; color: white; font-size: 0.9rem; font-weight: 600; cursor: pointer; white-space: nowrap; transition: all 0.2s; display: flex; align-items: center; gap: 6px; box-shadow: 0 4px 14px rgba(59,130,246,0.3); }
        .btn-serlok:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(59,130,246,0.4); }
        .btn-serlok:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
        .file-input-wrap { position: relative; }
        .file-input-wrap input[type="file"] { position: absolute; opacity: 0; width: 100%; height: 100%; cursor: pointer; }
        .file-input-wrap .form-input { cursor: pointer; }
        .upload-actions { display: flex; gap: 0.75rem; flex-wrap: wrap; margin-top: 0.5rem; }
        .btn-upload { flex: 1; min-width: 140px; padding: 0.65rem 1rem; border: 1.5px solid #e0e0f0; border-radius: 10px; background: white; font-size: 0.9rem; font-weight: 600; color: #4a4a6a; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .btn-upload:hover { border-color: var(--primary); color: var(--primary-dark); background: rgba(59,130,246,0.04); }
        .btn-upload.camera { border-color: var(--primary); color: var(--primary-dark); background: rgba(59,130,246,0.08); }
        .btn-upload.camera:hover { background: rgba(59,130,246,0.12); }
        .file-preview { margin-top: 1rem; max-width: 280px; border-radius: 12px; overflow: hidden; border: 1px solid #e8e8f0; position: relative; }
        .file-preview img { width: 100%; display: block; max-height: 200px; object-fit: cover; }
        .file-preview-remove { position: absolute; top: 8px; right: 8px; width: 32px; height: 32px; border-radius: 50%; background: rgba(0,0,0,0.6); color: white; border: none; cursor: pointer; font-size: 1rem; display: flex; align-items: center; justify-content: center; transition: background 0.2s; }
        .file-preview-remove:hover { background: #dc2626; }
        .btn-submit { width: 100%; padding: 1rem; background: linear-gradient(135deg, var(--primary), var(--accent)); border: none; border-radius: 14px; color: white; font-size: 1rem; font-weight: 700; font-family: inherit; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 20px rgba(59,130,246,0.35); display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 1.75rem; }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(59,130,246,0.45); }
        .alert-success { background: linear-gradient(135deg, #ecfdf5, #d1fae5); border: 1px solid #86efac; border-radius: 14px; padding: 1rem 1.25rem; margin-bottom: 1.5rem; font-size: 0.9rem; color: #047857; display: flex; align-items: center; gap: 0.75rem; }
        .trust-row { display: flex; gap: 1.5rem; justify-content: center; margin-top: 1.5rem; flex-wrap: wrap; }
        .trust-item { display: flex; align-items: center; gap: 6px; font-size: 0.8rem; color: var(--text-muted); }
        @media (max-width: 600px) { .kategori-options { grid-template-columns: 1fr; } .lokasi-row { flex-direction: column; } }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-inner">
            <a href="{{ url('/') }}" class="nav-logo"><div class="nav-logo-icon">🧠</div> PeduliJiwa</a>
            <a href="{{ url('/') }}" class="nav-back">← Kembali ke Beranda</a>
        </div>
    </nav>
    <div class="page-wrapper">
        <div class="breadcrumb">
            <a href="{{ url('/') }}">Beranda</a>
            <span>›</span>
            <span>Laporan ODGJ</span>
        </div>
        <div class="form-header">
            <div class="form-badge">🚨 Pelaporan ODGJ</div>
            <h1 class="form-title">Laporkan Kasus ODGJ</h1>
            <p class="form-subtitle">Lengkapi formulir di bawah ini untuk melaporkan kasus penjemputan atau pengantaran ODGJ. Petugas akan segera menghubungi Anda.</p>
        </div>

        @if (session('success'))
            <div class="alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="form-card">
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
                    <label class="form-label" for="lokasi">Lokasi / Alamat</label>
                    <div class="lokasi-row">
                        <input type="text" id="lokasi" name="lokasi" class="form-input {{ $errors->has('lokasi') ? 'is-invalid' : '' }}" placeholder="Masukkan alamat atau lokasi kejadian" value="{{ old('lokasi') }}">
                        <button type="button" id="btnSerlok" class="btn-serlok">
                            📍 Serlok Lokasi
                        </button>
                    </div>
                    <input type="hidden" name="lokasi_lat" id="lokasi_lat" value="{{ old('lokasi_lat') }}">
                    <input type="hidden" name="lokasi_lng" id="lokasi_lng" value="{{ old('lokasi_lng') }}">
                    <div id="lokasiStatus" style="font-size:0.78rem;color:#8a8aaa;margin-top:6px;"></div>
                    @error('lokasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="section-divider">Deskripsi</div>
                <div class="form-group">
                    <label class="form-label" for="deskripsi">Deskripsi Kejadian</label>
                    <textarea id="deskripsi" name="deskripsi" class="form-input {{ $errors->has('deskripsi') ? 'is-invalid' : '' }}" placeholder="Jelaskan kondisi lengkap kejadian, lokasi detail, dan informasi lain yang diperlukan petugas..." maxlength="2000">{{ old('deskripsi') }}</textarea>
                    <div style="font-size:0.75rem;color:#aaa;margin-top:4px;text-align:right;"><span id="charCount">0</span>/2000</div>
                    @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="section-divider">Gambar (Opsional)</div>
                <div class="form-group">
                    <label class="form-label">Upload Foto</label>
                    <div style="font-size:0.78rem;color:#8a8aaa;margin-bottom:0.5rem;">Gambar > 800 KB akan otomatis dikompresi untuk menghindari error upload.</div>
                    <input type="file" id="gambar" name="gambar" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" style="display:none;">
                    <div class="upload-actions">
                        <button type="button" class="btn-upload camera" id="btnCamera" title="Ambil foto dengan kamera">
                            📷 Ambil Foto
                        </button>
                        <button type="button" class="btn-upload" id="btnGallery" title="Pilih dari galeri">
                            📁 Pilih dari Galeri
                        </button>
                    </div>
                    <div id="gambarLabel" style="font-size:0.82rem;color:#8a8aaa;margin-top:0.5rem;"></div>
                    <div id="gambarPreview" class="file-preview"></div>
                    @error('gambar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="section-divider">Kontak</div>
                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="contoh@email.com" value="{{ old('email') }}">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="kontak">Nomor HP / WhatsApp <span class="req">*</span></label>
                    <input type="text" id="kontak" name="kontak" class="form-input {{ $errors->has('kontak') ? 'is-invalid' : '' }}" placeholder="08xx-xxxx-xxxx" value="{{ old('kontak') }}">
                    @error('kontak')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn-submit" id="submitBtn">
                    <span>📤</span> Kirim Laporan
                </button>
            </form>
            <div class="trust-row">
                <div class="trust-item"><span>🔐</span> Data Aman & Tersimpan</div>
                <div class="trust-item"><span>📋</span> Petugas Akan Segera Menindaklanjuti</div>
                <div class="trust-item"><span>✅</span> Organisasi Terverifikasi</div>
            </div>
        </div>
    </div>
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
                return;
            }
            btnSerlok.disabled = true;
            btnSerlok.innerHTML = '⏳ Mendeteksi...';
            lokasiStatus.textContent = 'Mendeteksi lokasi...';

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
</body>
</html>
