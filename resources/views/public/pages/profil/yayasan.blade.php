@extends('layouts.app')

@section('title', 'Profil Yayasan')

@push('styles')
<style>
    .page-hero { background: transparent !important; }
    .page-hero .section-header-center { max-width: 720px; margin: 0 auto; text-align: center; }
    .page-hero .section-tag {
        font-size: 0.8rem;
        letter-spacing: 0.12em;
        background: rgba(255,255,255,0.12);
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
    .profile-section { background: transparent !important; }
    .yayasan-layout { max-width: 960px; margin: 0 auto; }
    .yayasan-layout .profile-body { margin-left: auto; margin-right: auto; width: 100%; }
    .yayasan-grid { display: grid; grid-template-columns: 1fr; gap: 1.75rem; }
    @media (min-width: 768px) {
        .yayasan-grid--two { grid-template-columns: 1fr 1fr; }
    }
    .profile-meta-card h2 { margin-bottom: 1rem; font-size: 1.15rem; }
    .profile-meta-card h3 { margin: 1.25rem 0 0.5rem; font-size: 1rem; display: flex; align-items: center; gap: 0.4rem; }
    .profile-meta-card ul { margin: 0; padding-left: 1.25rem; font-size: 0.9rem; color: var(--text-muted); line-height: 1.8; }
    .profile-meta-card p { margin: 0 0 0.75rem; font-size: 0.9rem; line-height: 1.75; color: var(--text-muted); }
    .profile-meta-card p:last-of-type { margin-bottom: 0; }
    .profile-meta-card .profile-meta-content { font-size: 0.9rem; line-height: 1.75; color: var(--text-muted); }
    .profile-meta-card .profile-meta-content br + * { margin-top: 0.75rem; }
    .yayasan-cta {
        display: flex; flex-direction: column; gap: 0.35rem;
        margin-top: 1rem; padding: 1.25rem 1.5rem;
        background: linear-gradient(135deg, #eff6ff 0%, #e0f2fe 100%);
        border-radius: 12px; border: 1px solid #bfdbfe;
        text-decoration: none; color: inherit; transition: transform 2s cubic-bezier(0.25, 0.46, 0.45, 0.94), box-shadow 2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .yayasan-cta:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(37,99,235,0.15); }
    .yayasan-cta .arrow { font-size: 0.85rem; color: var(--primary-dark); font-weight: 600; margin-top: 0.25rem; }
    .yayasan-contact { display: grid; grid-template-columns: 1fr; gap: 1rem; margin-top: 0.5rem; }
    @media (min-width: 560px) { .yayasan-contact { grid-template-columns: 1fr 1fr; } }
    .yayasan-contact-item {
        display: flex; align-items: flex-start; gap: 1rem; padding: 1rem 1.1rem;
        background: #f9fafb; border-radius: 10px; border: 1px solid #e2e8f0;
        transition: background 2s cubic-bezier(0.25, 0.46, 0.45, 0.94), border-color 2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .yayasan-contact-item:hover { background: #f1f5f9; border-color: #cbd5e1; }
    .yayasan-contact-icon { width: 40px; height: 40px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; background: linear-gradient(135deg, #2563eb, #3b82f6); border-radius: 10px; color: white; }
    .yayasan-contact-label { font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: var(--primary-dark); margin-bottom: 0.2rem; }
    .yayasan-contact-value { font-size: 0.9rem; color: var(--text); line-height: 1.5; }
    .yayasan-contact-value a { color: var(--primary-dark); font-weight: 500; }
    .yayasan-contact-value a:hover { text-decoration: underline; }
</style>
@endpush

@section('content')
    {{-- Hero --}}
    <section class="section page-hero" style="padding-top: calc(5.25rem + 72px);">
        <div class="section-inner yayasan-layout">
            <div class="section-header-center anim-fade-down">
                <div class="section-tag">Profil Yayasan</div>
                <h2 class="section-title">Profil Griya Satu Mimika</h2>
                <p class="section-desc">
                    Identitas, nilai, dan komitmen kami dalam menyelenggarakan layanan rehabilitasi bagi Orang Dengan Gangguan Jiwa (ODGJ) di wilayah Mimika dan sekitarnya.
                </p>
            </div>
        </div>
    </section>

    {{-- Content: dari data dashboard admin (Profil Yayasan) --}}
    <section class="section profile-section">
        <div class="section-inner yayasan-layout">
            <div class="profile-body">
                @forelse($profilItems ?? [] as $index => $item)
                    <article class="profile-meta-card {{ $index % 2 === 0 ? 'anim-fade-right' : 'anim-fade-left' }} {{ $index > 0 ? 'anim-delay-2' : '' }}">
                        <h2>{{ $item->judul }}</h2>
                        <div class="profile-meta-content">{!! nl2br(e($item->keterangan)) !!}</div>
                    </article>
                @empty
                    <article class="profile-meta-card anim-fade-right">
                        <h2>Profil Yayasan</h2>
                        <p>Konten profil yayasan belum ditambahkan. Silakan kelola dari dashboard admin.</p>
                    </article>
                @endforelse
            </div>
        </div>
    </section>
@endsection

