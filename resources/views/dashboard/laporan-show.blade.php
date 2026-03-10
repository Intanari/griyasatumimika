@extends('layouts.dashboard')

@section('title', 'Detail Laporan ODGJ')
@section('topbar-title', 'Detail Laporan ODGJ')

@section('content')
<a href="{{ route('dashboard.laporan') }}" class="page-back-link">Back</a>
<nav class="laporan-detail-breadcrumb" aria-label="Breadcrumb">
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <span class="laporan-detail-sep">/</span>
    <a href="{{ route('dashboard.laporan') }}">Laporan ODGJ</a>
    <span class="laporan-detail-sep">/</span>
    <span class="laporan-detail-current">Detail #{{ $laporan->nomor_laporan }}</span>
</nav>

@if (session('success'))
    <div class="laporan-detail-alert success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="laporan-detail-alert error">{{ session('error') }}</div>
@endif

<div class="card laporan-detail-card">
    <div class="card-title" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.75rem;">
        <span>📋 Laporan ODGJ — {{ $laporan->nomor_laporan }}</span>
        <div style="display:flex;gap:0.5rem;">
            <a href="{{ route('dashboard.laporan') }}" class="btn btn-outline btn-sm">← Kembali ke Daftar</a>
            @if ($laporan->status === 'baru')
                <form action="{{ route('dashboard.laporan.terima', $laporan) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-success">✓ Terima</button>
                </form>
                <form action="{{ route('dashboard.laporan.tolak', $laporan) }}" method="POST" style="display:inline;" data-confirm="Yakin ingin menolak laporan ini?">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger">✗ Tolak</button>
                </form>
            @endif
        </div>
    </div>

    <div class="laporan-detail-grid">
        <div class="laporan-detail-section">
            <h3 class="laporan-detail-section-title">Data Laporan</h3>
            <dl class="laporan-detail-dl">
                <dt>No. Laporan</dt>
                <dd><strong>{{ $laporan->nomor_laporan }}</strong></dd>

                <dt>Kategori</dt>
                <dd>{{ $laporan->kategori_label }}</dd>

                <dt>Status</dt>
                <dd>
                    @if ($laporan->status === 'baru')
                        <span class="badge badge-pending">🆕 Baru</span>
                    @elseif ($laporan->status === 'diproses')
                        <span class="badge badge-paid">⏳ Diproses</span>
                    @elseif ($laporan->status === 'ditolak')
                        <span class="badge badge-cancel">❌ Ditolak</span>
                    @else
                        <span class="badge badge-paid">✅ Selesai</span>
                    @endif
                </dd>

                <dt>Tanggal Laporan</dt>
                <dd>{{ $laporan->created_at->locale('id')->translatedFormat('d F Y, H:i WIB') }}</dd>

                <dt>Lokasi</dt>
                <dd>
                    @if($laporan->lokasi)
                        {{ $laporan->lokasi }}
                        @if($laporan->lokasi_lat && $laporan->lokasi_lng)
                            <a href="https://www.google.com/maps?q={{ $laporan->lokasi_lat }},{{ $laporan->lokasi_lng }}" target="_blank" rel="noopener" class="laporan-detail-maps">📍 Buka di Maps</a>
                        @endif
                    @else
                        <span class="text-muted">–</span>
                    @endif
                </dd>

                <dt>Deskripsi</dt>
                <dd>{{ $laporan->deskripsi ? nl2br(e($laporan->deskripsi)) : '–' }}</dd>

                @if($laporan->gambar)
                <dt>Gambar</dt>
                <dd>
                    <a href="{{ $laporan->gambar_url }}" target="_blank" rel="noopener">
                        <img src="{{ $laporan->gambar_url }}" alt="Lampiran" class="laporan-detail-img">
                    </a>
                </dd>
                @endif
            </dl>
        </div>

        <div class="laporan-detail-section">
            <h3 class="laporan-detail-section-title">Kontak Pelapor</h3>
            <dl class="laporan-detail-dl">
                <dt>Email</dt>
                <dd>
                    @if($laporan->email)
                        <a href="mailto:{{ $laporan->email }}">{{ $laporan->email }}</a>
                    @else
                        <span class="text-muted">–</span>
                    @endif
                </dd>

                <dt>No. HP / WhatsApp</dt>
                <dd>
                    @if($laporan->kontak)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $laporan->kontak) }}" target="_blank" rel="noopener" style="color:var(--accent-green);font-weight:600;">{{ $laporan->kontak }}</a>
                    @else
                        <span class="text-muted">–</span>
                    @endif
                </dd>
            </dl>
        </div>
    </div>
</div>

{{-- Form Respon Laporan: kirim pesan dari admin ke email pelapor ─────────────── --}}
@if($laporan->email)
<div class="card laporan-detail-card">
    <div class="card-title">📩 Respon Laporan — Kirim Pesan ke Email Pelapor</div>
    <p class="laporan-detail-respon-desc">Pesan yang Anda tulis di bawah akan dikirim ke <strong>{{ $laporan->email }}</strong> sebagai respons terhadap laporan ini.</p>
    <form action="{{ route('dashboard.laporan.respon', $laporan) }}" method="POST" class="laporan-detail-respon-form">
        @csrf
        <div class="form-group">
            <label for="pesan_respon">Pesan respons <span class="required">*</span></label>
            <textarea id="pesan_respon" name="pesan_respon" rows="6" required maxlength="2000" placeholder="Tulis pesan respons dari admin untuk pelapor (akan dikirim ke email pelapor)&#10;&#10;Contoh: Terima kasih telah melaporkan. Tim kami akan segera menindaklanjuti dan menghubungi Anda via WhatsApp.">{{ old('pesan_respon') }}</textarea>
            <span class="form-hint">Maks. 2000 karakter. Pesan akan dikirim ke email pelapor.</span>
            @error('pesan_respon')<span class="form-error">{{ $message }}</span>@enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Kirim Respon ke Email Pelapor</button>
        </div>
    </form>
</div>
@else
<div class="card laporan-detail-card">
    <div class="card-title">📩 Respon Laporan</div>
    <p class="laporan-detail-respon-desc" style="color:var(--text-muted);">Pelapor tidak mengisi alamat email. Respon tidak dapat dikirim via email. Anda dapat menghubungi pelapor via nomor WhatsApp jika tersedia.</p>
</div>
@endif

@push('styles')
<style>
.laporan-detail-breadcrumb { font-size: 0.875rem; color: var(--text-muted); margin-bottom: 1rem; }
.laporan-detail-breadcrumb a { color: var(--primary); text-decoration: none; font-weight: 500; }
.laporan-detail-breadcrumb a:hover { text-decoration: underline; }
.laporan-detail-sep { margin: 0 0.35rem; opacity: 0.6; }
.laporan-detail-current { color: var(--text); font-weight: 600; }
.laporan-detail-alert { padding: 0.75rem 1rem; border-radius: 10px; margin-bottom: 1rem; font-size: 0.9rem; }
.laporan-detail-alert.success { background: #dcfce7; color: #166534; border: 1px solid #86efac; }
.laporan-detail-alert.error { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
.laporan-detail-card { margin-bottom: 1.5rem; }
.laporan-detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
@media (max-width: 768px) { .laporan-detail-grid { grid-template-columns: 1fr; } }
.laporan-detail-section-title { font-size: 1rem; font-weight: 700; color: var(--text); margin-bottom: 0.75rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--border); }
.laporan-detail-dl { margin: 0; }
.laporan-detail-dl dt { font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.03em; margin-top: 1rem; margin-bottom: 0.25rem; }
.laporan-detail-dl dt:first-child { margin-top: 0; }
.laporan-detail-dl dd { margin: 0; font-size: 0.95rem; color: var(--text); line-height: 1.5; }
.laporan-detail-maps { display: inline-block; margin-top: 0.25rem; font-size: 0.85rem; color: var(--primary); }
.laporan-detail-img { max-width: 280px; max-height: 200px; object-fit: contain; border-radius: 12px; border: 1px solid var(--border); }
.laporan-detail-respon-desc { font-size: 0.9rem; color: var(--text-muted); margin-bottom: 1rem; }
.laporan-detail-respon-form .form-group { margin-bottom: 1rem; }
.laporan-detail-respon-form label { display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.4rem; color: var(--text); }
.laporan-detail-respon-form textarea { width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border); border-radius: 10px; font-size: 0.95rem; font-family: inherit; resize: vertical; }
.laporan-detail-respon-form .form-hint { display: block; font-size: 0.8rem; color: var(--text-muted); margin-top: 0.25rem; }
.laporan-detail-respon-form .form-error { display: block; font-size: 0.8rem; color: #dc2626; margin-top: 0.25rem; }
.laporan-detail-respon-form .form-actions { margin-top: 1rem; }
.laporan-detail-respon-form .required { color: #dc2626; }
.text-muted { color: var(--text-muted); }
</style>
@endpush
@endsection
