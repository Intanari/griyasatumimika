<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PeduliJiwa - Donasi Rehabilitasi ODGJ</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        <style>
            *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
            html { scroll-behavior: smooth; }
            body { font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif; color: #1a1a2e; background: #ffffff; line-height: 1.6; }
            a { text-decoration: none; color: inherit; }
            img { max-width: 100%; display: block; }
            ul { list-style: none; }
            .navbar { position: fixed; top: 0; left: 0; right: 0; z-index: 100; background: rgba(255,255,255,0.95); backdrop-filter: blur(12px); border-bottom: 1px solid #e8e8f0; padding: 0 1.5rem; }
            .nav-inner { max-width: 1200px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; height: 68px; }
            .nav-logo { display: flex; align-items: center; gap: 10px; font-size: 1.25rem; font-weight: 700; color: #4f46e5; }
            .nav-logo-icon { width: 36px; height: 36px; background: linear-gradient(135deg, #4f46e5, #7c3aed); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.1rem; }
            .nav-links { display: flex; align-items: center; gap: 2rem; }
            .nav-links a { font-size: 0.9rem; font-weight: 500; color: #4a4a6a; transition: color 0.2s; }
            .nav-links a:hover { color: #4f46e5; }
            .nav-actions { display: flex; align-items: center; gap: 0.75rem; }
            .btn-outline { padding: 0.45rem 1.1rem; border: 1.5px solid #4f46e5; border-radius: 8px; color: #4f46e5; font-size: 0.875rem; font-weight: 600; transition: all 0.2s; }
            .btn-outline:hover { background: #4f46e5; color: white; }
            .btn-primary { padding: 0.5rem 1.2rem; background: linear-gradient(135deg, #4f46e5, #7c3aed); border-radius: 8px; color: white; font-size: 0.875rem; font-weight: 600; transition: opacity 0.2s; box-shadow: 0 2px 10px rgba(79,70,229,0.3); }
            .btn-primary:hover { opacity: 0.9; }
            .hero { min-height: 100vh; padding-top: 68px; background: linear-gradient(160deg, #f0f0ff 0%, #fdf4ff 50%, #fff7f0 100%); display: flex; align-items: center; position: relative; overflow: hidden; }
            .hero::before { content: ''; position: absolute; top: -200px; right: -200px; width: 600px; height: 600px; background: radial-gradient(circle, rgba(79,70,229,0.08) 0%, transparent 70%); border-radius: 50%; }
            .hero-inner { max-width: 1200px; margin: 0 auto; padding: 5rem 1.5rem; display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; position: relative; z-index: 1; }
            .hero-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(79,70,229,0.1); color: #4f46e5; font-size: 0.8rem; font-weight: 600; padding: 6px 14px; border-radius: 100px; margin-bottom: 1.25rem; border: 1px solid rgba(79,70,229,0.2); }
            .hero-title { font-size: 3rem; font-weight: 700; line-height: 1.2; color: #0f0f2d; margin-bottom: 1.25rem; }
            .hero-title .highlight { background: linear-gradient(135deg, #4f46e5, #7c3aed); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
            .hero-desc { font-size: 1.05rem; color: #5a5a7a; margin-bottom: 2rem; line-height: 1.75; }
            .hero-cta { display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 2.5rem; }
            .btn-hero-primary { padding: 0.9rem 2rem; background: linear-gradient(135deg, #4f46e5, #7c3aed); border-radius: 12px; color: white; font-size: 1rem; font-weight: 600; box-shadow: 0 4px 20px rgba(79,70,229,0.35); transition: transform 0.2s, box-shadow 0.2s; display: inline-flex; align-items: center; gap: 8px; }
            .btn-hero-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(79,70,229,0.45); }
            .btn-hero-secondary { padding: 0.9rem 2rem; border: 2px solid #e0e0f0; border-radius: 12px; color: #4a4a6a; font-size: 1rem; font-weight: 600; transition: all 0.2s; display: inline-flex; align-items: center; gap: 8px; background: white; }
            .btn-hero-secondary:hover { border-color: #4f46e5; color: #4f46e5; }
            .hero-stats { display: flex; gap: 2rem; }
            .hero-stat-number { font-size: 1.5rem; font-weight: 700; color: #0f0f2d; }
            .hero-stat-label { font-size: 0.8rem; color: #7a7a9a; margin-top: 2px; }
            .hero-visual { position: relative; }
            .hero-card-main { background: white; border-radius: 24px; padding: 2rem; box-shadow: 0 20px 60px rgba(79,70,229,0.12); border: 1px solid #ebebf8; }
            .campaign-label { font-size: 0.75rem; font-weight: 600; color: #7c3aed; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; }
            .campaign-title { font-size: 1.1rem; font-weight: 700; color: #0f0f2d; margin-bottom: 0.5rem; }
            .campaign-desc { font-size: 0.85rem; color: #6a6a8a; margin-bottom: 1.25rem; line-height: 1.6; }
            .progress-info { display: flex; justify-content: space-between; font-size: 0.8rem; margin-bottom: 6px; }
            .progress-raised { font-weight: 700; color: #4f46e5; }
            .progress-pct { color: #7a7a9a; }
            .progress-bar { height: 8px; background: #ebebf8; border-radius: 100px; overflow: hidden; margin-bottom: 0.75rem; }
            .progress-fill { height: 100%; background: linear-gradient(90deg, #4f46e5, #7c3aed); border-radius: 100px; }
            .campaign-footer { display: flex; align-items: center; justify-content: space-between; margin-top: 1rem; }
            .donor-avatars { display: flex; align-items: center; }
            .donor-avatar { width: 30px; height: 30px; border-radius: 50%; border: 2px solid white; margin-left: -8px; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; color: white; }
            .donor-avatar:first-child { margin-left: 0; }
            .donor-count { font-size: 0.8rem; color: #6a6a8a; margin-left: 10px; }
            .btn-donate-sm { padding: 0.45rem 1rem; background: linear-gradient(135deg, #4f46e5, #7c3aed); border-radius: 8px; color: white; font-size: 0.8rem; font-weight: 600; }
            .hero-card-float { position: absolute; background: white; border-radius: 16px; padding: 1rem 1.25rem; box-shadow: 0 10px 40px rgba(0,0,0,0.1); border: 1px solid #f0f0f8; }
            .float-1 { top: -20px; right: -20px; }
            .float-2 { bottom: 30px; left: -30px; }
            .float-icon { font-size: 1.5rem; margin-bottom: 4px; }
            .float-value { font-size: 1.1rem; font-weight: 700; color: #0f0f2d; }
            .float-label { font-size: 0.7rem; color: #8a8aaa; }
            .section { padding: 5rem 1.5rem; }
            .section-inner { max-width: 1200px; margin: 0 auto; }
            .section-tag { display: inline-block; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: #4f46e5; background: rgba(79,70,229,0.08); padding: 4px 12px; border-radius: 100px; margin-bottom: 1rem; }
            .section-title { font-size: 2.25rem; font-weight: 700; color: #0f0f2d; line-height: 1.25; margin-bottom: 1rem; }
            .section-desc { font-size: 1rem; color: #5a5a7a; max-width: 560px; line-height: 1.75; }
            .section-header-center { text-align: center; }
            .section-header-center .section-desc { margin: 0 auto; }
            .impact-section { background: linear-gradient(135deg, #4f46e5, #7c3aed); color: white; padding: 4rem 1.5rem; }
            .impact-grid { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem; text-align: center; }
            .impact-number { font-size: 2.5rem; font-weight: 700; color: white; margin-bottom: 0.25rem; }
            .impact-label { font-size: 0.9rem; color: rgba(255,255,255,0.75); }
            .impact-icon { font-size: 2rem; margin-bottom: 0.75rem; }
            .about-section { background: #fafafa; }
            .about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: center; }
            .about-img-bg { width: 100%; aspect-ratio: 4/3; background: linear-gradient(135deg, #e8e8ff 0%, #f5e8ff 100%); border-radius: 24px; display: flex; align-items: center; justify-content: center; font-size: 8rem; }
            .about-badge-float { position: absolute; bottom: -20px; right: -20px; background: white; border-radius: 16px; padding: 1rem 1.5rem; box-shadow: 0 10px 40px rgba(0,0,0,0.1); text-align: center; }
            .about-img-wrap { position: relative; }
            .about-features { margin-top: 2rem; display: flex; flex-direction: column; gap: 1.25rem; }
            .feature-item { display: flex; gap: 1rem; align-items: flex-start; }
            .feature-icon-wrap { width: 44px; height: 44px; border-radius: 12px; background: rgba(79,70,229,0.1); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; }
            .feature-title { font-size: 0.95rem; font-weight: 600; color: #0f0f2d; margin-bottom: 3px; }
            .feature-desc { font-size: 0.85rem; color: #6a6a8a; line-height: 1.5; }
            .programs-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-top: 3rem; }
            .program-card { background: white; border-radius: 20px; overflow: hidden; border: 1px solid #ebebf8; transition: transform 0.25s, box-shadow 0.25s; }
            .program-card:hover { transform: translateY(-6px); box-shadow: 0 20px 50px rgba(79,70,229,0.12); }
            .program-img { height: 180px; display: flex; align-items: center; justify-content: center; font-size: 4rem; }
            .program-body { padding: 1.5rem; }
            .program-category { font-size: 0.75rem; font-weight: 600; color: #7c3aed; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; }
            .program-title { font-size: 1rem; font-weight: 700; color: #0f0f2d; margin-bottom: 0.5rem; line-height: 1.4; }
            .program-desc { font-size: 0.85rem; color: #6a6a8a; line-height: 1.6; margin-bottom: 1.25rem; }
            .program-progress { margin-bottom: 1rem; }
            .prog-numbers { display: flex; justify-content: space-between; font-size: 0.8rem; margin-bottom: 6px; }
            .prog-raised { font-weight: 700; color: #0f0f2d; }
            .prog-target { color: #8a8aaa; }
            .program-footer { display: flex; align-items: center; justify-content: space-between; }
            .prog-days { font-size: 0.8rem; color: #8a8aaa; }
            .prog-days strong { color: #f59e0b; }
            .btn-prog { padding: 0.45rem 1.1rem; background: linear-gradient(135deg, #4f46e5, #7c3aed); border-radius: 8px; color: white; font-size: 0.82rem; font-weight: 600; transition: opacity 0.2s; }
            .btn-prog:hover { opacity: 0.85; }
            .steps-section { background: #f8f8ff; }
            .steps-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-top: 3rem; position: relative; }
            .steps-grid::before { content: ''; position: absolute; top: 28px; left: 12.5%; right: 12.5%; height: 2px; background: linear-gradient(90deg, #4f46e5, #7c3aed); z-index: 0; }
            .step-card { text-align: center; position: relative; z-index: 1; }
            .step-num { width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, #4f46e5, #7c3aed); color: white; font-size: 1.25rem; font-weight: 700; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; box-shadow: 0 4px 16px rgba(79,70,229,0.35); }
            .step-title { font-size: 0.95rem; font-weight: 700; color: #0f0f2d; margin-bottom: 0.5rem; }
            .step-desc { font-size: 0.82rem; color: #6a6a8a; line-height: 1.5; }
            .testi-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-top: 3rem; }
            .testi-card { background: white; border-radius: 20px; padding: 1.75rem; border: 1px solid #ebebf8; transition: box-shadow 0.25s; }
            .testi-card:hover { box-shadow: 0 12px 40px rgba(79,70,229,0.1); }
            .testi-stars { color: #f59e0b; font-size: 0.9rem; margin-bottom: 0.75rem; }
            .testi-text { font-size: 0.9rem; color: #4a4a6a; line-height: 1.7; font-style: italic; margin-bottom: 1.25rem; }
            .testi-author { display: flex; align-items: center; gap: 0.75rem; }
            .testi-avatar { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1rem; font-weight: 700; color: white; flex-shrink: 0; }
            .testi-name { font-size: 0.875rem; font-weight: 600; color: #0f0f2d; }
            .testi-role { font-size: 0.75rem; color: #8a8aaa; }
            .donate-cta { background: linear-gradient(135deg, #0f0f2d, #1e1b4b); color: white; text-align: center; padding: 6rem 1.5rem; position: relative; overflow: hidden; }
            .donate-cta::before { content: ''; position: absolute; top: -100px; left: 50%; transform: translateX(-50%); width: 600px; height: 600px; background: radial-gradient(circle, rgba(79,70,229,0.2) 0%, transparent 70%); border-radius: 50%; }
            .donate-cta-inner { position: relative; z-index: 1; max-width: 600px; margin: 0 auto; }
            .donate-cta h2 { font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem; line-height: 1.2; }
            .donate-cta p { font-size: 1rem; color: rgba(255,255,255,0.7); margin-bottom: 2.5rem; line-height: 1.7; }
            .cta-buttons { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
            .btn-cta-white { padding: 0.9rem 2rem; background: white; border-radius: 12px; color: #4f46e5; font-size: 1rem; font-weight: 700; transition: transform 0.2s; box-shadow: 0 4px 20px rgba(0,0,0,0.2); }
            .btn-cta-white:hover { transform: translateY(-2px); }
            .btn-cta-outline { padding: 0.9rem 2rem; border: 2px solid rgba(255,255,255,0.3); border-radius: 12px; color: white; font-size: 1rem; font-weight: 600; transition: all 0.2s; }
            .btn-cta-outline:hover { border-color: white; }
            .footer { background: #0a0a1a; color: rgba(255,255,255,0.7); padding: 4rem 1.5rem 2rem; }
            .footer-grid { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 3rem; margin-bottom: 3rem; }
            .footer-logo { display: flex; align-items: center; gap: 10px; font-size: 1.2rem; font-weight: 700; color: white; margin-bottom: 1rem; }
            .footer-logo-icon { width: 34px; height: 34px; background: linear-gradient(135deg, #4f46e5, #7c3aed); border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 1rem; }
            .footer-desc { font-size: 0.875rem; line-height: 1.7; max-width: 260px; margin-bottom: 1.5rem; }
            .footer-socials { display: flex; gap: 0.75rem; }
            .social-btn { width: 36px; height: 36px; border-radius: 10px; background: rgba(255,255,255,0.08); display: flex; align-items: center; justify-content: center; font-size: 0.9rem; transition: background 0.2s; }
            .social-btn:hover { background: rgba(79,70,229,0.5); }
            .footer-col-title { font-size: 0.9rem; font-weight: 600; color: white; margin-bottom: 1.25rem; }
            .footer-links { display: flex; flex-direction: column; gap: 0.75rem; }
            .footer-links a { font-size: 0.85rem; transition: color 0.2s; }
            .footer-links a:hover { color: white; }
            .footer-bottom { max-width: 1200px; margin: 0 auto; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.08); display: flex; justify-content: space-between; align-items: center; font-size: 0.8rem; }
            @media (max-width: 900px) {
                .nav-links { display: none; }
                .hero-inner { grid-template-columns: 1fr; }
                .hero-visual { display: none; }
                .hero-title { font-size: 2.25rem; }
                .about-grid { grid-template-columns: 1fr; }
                .about-img-wrap { display: none; }
                .programs-grid { grid-template-columns: 1fr; }
                .impact-grid { grid-template-columns: repeat(2, 1fr); }
                .steps-grid { grid-template-columns: repeat(2, 1fr); }
                .steps-grid::before { display: none; }
                .testi-grid { grid-template-columns: 1fr; }
                .footer-grid { grid-template-columns: 1fr 1fr; }
                .footer-bottom { flex-direction: column; gap: 0.75rem; text-align: center; }
                .donate-cta h2 { font-size: 1.75rem; }
            }
        </style>
    </head>
    <body>
        <nav class="navbar">
            <div class="nav-inner">
                <a href="#" class="nav-logo">
                    <div class="nav-logo-icon">🧠</div>
                    PeduliJiwa
                </a>
                <div class="nav-links">
                    <a href="#tentang">Tentang Kami</a>
                    <a href="#program">Program</a>
                    <a href="#cara-donasi">Cara Donasi</a>
                    <a href="#testimoni">Testimoni</a>
                </div>
                <div class="nav-actions">
                    <a href="{{ route('donation.form') }}" class="btn-primary">❤️ Donasi Sekarang</a>
                </div>
            </div>
        </nav>

        <section class="hero">
            <div class="hero-inner">
                <div class="hero-content">
                    <div class="hero-badge"><span>❤️</span> Bersama Pulihkan Harapan</div>
                    <h1 class="hero-title">Bantu Mereka Menemukan <span class="highlight">Kembali Dirinya</span></h1>
                    <p class="hero-desc">Setiap orang berhak mendapatkan kesempatan untuk pulih. Bersama kami, donasimu membantu proses rehabilitasi Orang Dengan Gangguan Jiwa (ODGJ) agar kembali bermartabat dan mandiri di masyarakat.</p>
                    <div class="hero-cta">
                        <a href="{{ route('donation.form', ['program' => 'umum']) }}" class="btn-hero-primary">❤️ Donasi Sekarang</a>
                        <a href="#tentang" class="btn-hero-secondary">Pelajari Lebih Lanjut →</a>
                    </div>
                    <div class="hero-stats">
                        <div class="hero-stat"><div class="hero-stat-number">2.400+</div><div class="hero-stat-label">ODGJ Terbantu</div></div>
                        <div class="hero-stat"><div class="hero-stat-number">18 Kota</div><div class="hero-stat-label">Jangkauan Program</div></div>
                        <div class="hero-stat"><div class="hero-stat-number">15.000+</div><div class="hero-stat-label">Donatur Aktif</div></div>
                    </div>
                </div>
                <div class="hero-visual">
                    <div class="hero-card-float float-1"><div class="float-icon">🏥</div><div class="float-value">48 RSJ</div><div class="float-label">Mitra Rumah Sakit</div></div>
                    <div class="hero-card-main">
                        <div class="campaign-label">Program Unggulan</div>
                        <div class="campaign-title">Rehabilitasi ODGJ Terlantar 2025</div>
                        <div class="campaign-desc">Membantu 500 ODGJ terlantar mendapatkan perawatan medis, terapi psikologis, dan pendampingan reintegrasi sosial.</div>
                        <div class="progress-info"><span class="progress-raised">Rp 348.500.000</span><span class="progress-pct">69%</span></div>
                        <div class="progress-bar"><div class="progress-fill" style="width:69%"></div></div>
                        <div style="font-size:0.78rem;color:#8a8aaa;margin-bottom:1rem;">Target: Rp 500.000.000 &bull; Sisa 38 hari</div>
                        <div class="campaign-footer">
                            <div style="display:flex;align-items:center;">
                                <div class="donor-avatars">
                                    <div class="donor-avatar" style="background:#4f46e5">A</div>
                                    <div class="donor-avatar" style="background:#7c3aed">B</div>
                                    <div class="donor-avatar" style="background:#ec4899">C</div>
                                    <div class="donor-avatar" style="background:#f59e0b">D</div>
                                </div>
                                <div class="donor-count">+1.247 donatur</div>
                            </div>
                            <a href="{{ route('donation.form', ['program' => 'umum']) }}" class="btn-donate-sm">Donasi</a>
                        </div>
                    </div>
                    <div class="hero-card-float float-2"><div class="float-icon">✅</div><div class="float-value">98.5%</div><div class="float-label">Dana Tersalurkan</div></div>
                </div>
            </div>
        </section>

        <section class="impact-section">
            <div class="impact-grid">
                <div><div class="impact-icon">🧑‍⚕️</div><div class="impact-number">2.400+</div><div class="impact-label">ODGJ Mendapat Rehabilitasi</div></div>
                <div><div class="impact-icon">💰</div><div class="impact-number">Rp 4,2M</div><div class="impact-label">Total Dana Terhimpun</div></div>
                <div><div class="impact-icon">🤝</div><div class="impact-number">15.000+</div><div class="impact-label">Donatur Setia</div></div>
                <div><div class="impact-icon">🌍</div><div class="impact-number">18 Kota</div><div class="impact-label">Wilayah Dampak</div></div>
            </div>
        </section>

        <section class="section about-section" id="tentang">
            <div class="section-inner">
                <div class="about-grid">
                    <div class="about-img-wrap">
                        <div class="about-img-bg">🧠</div>
                        <div class="about-badge-float"><div style="font-size:1.75rem;margin-bottom:4px;">🏆</div><div style="font-size:1.25rem;font-weight:700;color:#0f0f2d;">10+ Tahun</div><div style="font-size:0.75rem;color:#8a8aaa;">Pengalaman</div></div>
                    </div>
                    <div>
                        <div class="section-tag">Tentang Kami</div>
                        <h2 class="section-title">Harapan Baru untuk Jiwa yang Terluka</h2>
                        <p class="section-desc">PeduliJiwa adalah platform donasi yang fokus pada rehabilitasi Orang Dengan Gangguan Jiwa (ODGJ). Kami percaya setiap individu berhak atas kehidupan yang bermartabat.</p>
                        <div class="about-features">
                            <div class="feature-item"><div class="feature-icon-wrap">🏥</div><div><div class="feature-title">Perawatan Medis Terstruktur</div><div class="feature-desc">Bekerja sama dengan 48 RSJ dan klinik kesehatan jiwa terpercaya di seluruh Indonesia.</div></div></div>
                            <div class="feature-item"><div class="feature-icon-wrap">💬</div><div><div class="feature-title">Pendampingan Psikologis</div><div class="feature-desc">Tim psikiater dan psikolog klinis berpengalaman mendampingi proses pemulihan.</div></div></div>
                            <div class="feature-item"><div class="feature-icon-wrap">🏡</div><div><div class="feature-title">Reintegrasi Sosial</div><div class="feature-desc">Program pelatihan keterampilan agar penerima manfaat bisa kembali mandiri.</div></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section" id="program">
            <div class="section-inner">
                <div class="section-header-center">
                    <div class="section-tag">Program Donasi</div>
                    <h2 class="section-title">Pilih Program yang Kamu Dukung</h2>
                    <p class="section-desc">Setiap rupiah yang kamu sumbangkan memberi dampak nyata bagi kehidupan penerima manfaat kami.</p>
                </div>
                <div class="programs-grid">
                    <div class="program-card">
                        <div class="program-img" style="background:linear-gradient(135deg,#e8e8ff,#d4d4ff)">🏥</div>
                        <div class="program-body">
                            <div class="program-category">Kesehatan Jiwa</div>
                            <div class="program-title">Biaya Rawat Inap & Obat ODGJ</div>
                            <div class="program-desc">Menjamin ketersediaan obat-obatan dan biaya rawat inap bagi ODGJ yang tidak mampu secara ekonomi.</div>
                            <div class="program-progress"><div class="prog-numbers"><span class="prog-raised">Rp 178.400.000</span><span class="prog-target">dari Rp 250 juta</span></div><div class="progress-bar"><div class="progress-fill" style="width:71%"></div></div></div>
                            <div class="program-footer"><div class="prog-days">Sisa <strong>42 hari</strong></div><a href="{{ route('donation.form', ['program' => 'rawat-inap']) }}" class="btn-prog">Donasi</a></div>
                        </div>
                    </div>
                    <div class="program-card">
                        <div class="program-img" style="background:linear-gradient(135deg,#fde8ff,#ffc8f0)">🧑‍💼</div>
                        <div class="program-body">
                            <div class="program-category">Pemberdayaan</div>
                            <div class="program-title">Pelatihan Vokasi Pasca-Rehabilitasi</div>
                            <div class="program-desc">Melatih keterampilan kerja bagi ODGJ yang telah pulih agar dapat kembali produktif dan mandiri.</div>
                            <div class="program-progress"><div class="prog-numbers"><span class="prog-raised">Rp 62.750.000</span><span class="prog-target">dari Rp 150 juta</span></div><div class="progress-bar"><div class="progress-fill" style="width:42%"></div></div></div>
                            <div class="program-footer"><div class="prog-days">Sisa <strong>65 hari</strong></div><a href="{{ route('donation.form', ['program' => 'pelatihan-vokasi']) }}" class="btn-prog">Donasi</a></div>
                        </div>
                    </div>
                    <div class="program-card">
                        <div class="program-img" style="background:linear-gradient(135deg,#e8fff0,#c8ffe0)">🏠</div>
                        <div class="program-body">
                            <div class="program-category">Hunian</div>
                            <div class="program-title">Rumah Singgah ODGJ Terlantar</div>
                            <div class="program-desc">Menyediakan tempat tinggal sementara yang layak, aman, dan kondusif bagi ODGJ yang tidak memiliki keluarga.</div>
                            <div class="program-progress"><div class="prog-numbers"><span class="prog-raised">Rp 95.200.000</span><span class="prog-target">dari Rp 200 juta</span></div><div class="progress-bar"><div class="progress-fill" style="width:48%"></div></div></div>
                            <div class="program-footer"><div class="prog-days">Sisa <strong>55 hari</strong></div><a href="{{ route('donation.form', ['program' => 'rumah-singgah']) }}" class="btn-prog">Donasi</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section steps-section" id="cara-donasi">
            <div class="section-inner">
                <div class="section-header-center">
                    <div class="section-tag">Cara Berdonasi</div>
                    <h2 class="section-title">Mudah, Aman, dan Transparan</h2>
                    <p class="section-desc">Berdonasi hanya butuh beberapa langkah. Semua transaksi aman dan terdokumentasi secara transparan.</p>
                </div>
                <div class="steps-grid">
                    <div class="step-card"><div class="step-num">1</div><div class="step-title">Pilih Program</div><div class="step-desc">Telusuri dan pilih program rehabilitasi yang ingin kamu dukung.</div></div>
                    <div class="step-card"><div class="step-num">2</div><div class="step-title">Tentukan Nominal</div><div class="step-desc">Masukkan jumlah donasi. Tidak ada minimum — setiap rupiah berarti besar.</div></div>
                    <div class="step-card"><div class="step-num">3</div><div class="step-title">Bayar via QRIS</div><div class="step-desc">Scan QR Code menggunakan GoPay, OVO, DANA, ShopeePay, atau m-banking.</div></div>
                    <div class="step-card"><div class="step-num">4</div><div class="step-title">Terima Laporan</div><div class="step-desc">Dapatkan email konfirmasi dan laporan penggunaan dana secara berkala.</div></div>
                </div>
            </div>
        </section>

        <section class="section" id="testimoni">
            <div class="section-inner">
                <div class="section-header-center">
                    <div class="section-tag">Testimoni</div>
                    <h2 class="section-title">Cerita dari Para Donatur</h2>
                    <p class="section-desc">Ribuan orang telah merasakan kebahagiaan berbagi melalui PeduliJiwa.</p>
                </div>
                <div class="testi-grid">
                    <div class="testi-card"><div class="testi-stars">★★★★★</div><div class="testi-text">"Awalnya ragu, tapi setelah melihat laporan penggunaan dana yang sangat transparan, saya makin yakin dan rutin donasi setiap bulan."</div><div class="testi-author"><div class="testi-avatar" style="background:linear-gradient(135deg,#4f46e5,#7c3aed)">SR</div><div><div class="testi-name">Sari Rahayu</div><div class="testi-role">Donatur Rutin, Jakarta</div></div></div></div>
                    <div class="testi-card"><div class="testi-stars">★★★★★</div><div class="testi-text">"Kakak saya mantan ODGJ yang terlantar. Berkat program reintegrasi sosial PeduliJiwa, sekarang dia sudah bekerja dan hidup mandiri."</div><div class="testi-author"><div class="testi-avatar" style="background:linear-gradient(135deg,#ec4899,#f59e0b)">BW</div><div><div class="testi-name">Budi Wiyanto</div><div class="testi-role">Keluarga Penerima Manfaat, Surabaya</div></div></div></div>
                    <div class="testi-card"><div class="testi-stars">★★★★★</div><div class="testi-text">"Platform yang sangat mudah digunakan. Dalam 2 menit, donasi sudah selesai. Laporannya lengkap dan bisa dipercaya."</div><div class="testi-author"><div class="testi-avatar" style="background:linear-gradient(135deg,#10b981,#059669)">DP</div><div><div class="testi-name">Dewi Puspita</div><div class="testi-role">Relawan & Donatur, Bandung</div></div></div></div>
                </div>
            </div>
        </section>

        <section class="donate-cta">
            <div class="donate-cta-inner">
                <h2>Satu Langkah Kecilmu, Perubahan Besar Baginya</h2>
                <p>Bergabunglah bersama 15.000+ donatur yang telah mengubah kehidupan ribuan ODGJ di seluruh Indonesia. Mulai donasi dari Rp 10.000 saja.</p>
                <div class="cta-buttons">
                    <a href="{{ route('donation.form', ['program' => 'umum']) }}" class="btn-cta-white">❤️ Donasi Sekarang</a>
                    <a href="#tentang" class="btn-cta-outline">Pelajari Lebih Lanjut</a>
                </div>
            </div>
        </section>

        <footer class="footer">
            <div class="footer-grid">
                <div>
                    <div class="footer-logo"><div class="footer-logo-icon">🧠</div> PeduliJiwa</div>
                    <div class="footer-desc">Platform donasi terpercaya untuk rehabilitasi Orang Dengan Gangguan Jiwa (ODGJ) di Indonesia. Transparan, akuntabel, berdampak.</div>
                    <div class="footer-socials">
                        <a href="#" class="social-btn">📘</a>
                        <a href="#" class="social-btn">📸</a>
                        <a href="#" class="social-btn">🐦</a>
                        <a href="#" class="social-btn">▶️</a>
                    </div>
                </div>
                <div><div class="footer-col-title">Program</div><div class="footer-links"><a href="{{ route('donation.form', ['program' => 'rawat-inap']) }}">Rawat Inap & Obat</a><a href="{{ route('donation.form', ['program' => 'pelatihan-vokasi']) }}">Pelatihan Vokasi</a><a href="{{ route('donation.form', ['program' => 'rumah-singgah']) }}">Rumah Singgah</a><a href="{{ route('donation.form', ['program' => 'umum']) }}">Donasi Umum</a></div></div>
                <div><div class="footer-col-title">Organisasi</div><div class="footer-links"><a href="#tentang">Tentang Kami</a><a href="#">Tim Kami</a><a href="#">Laporan Keuangan</a><a href="#">Berita & Artikel</a></div></div>
                <div><div class="footer-col-title">Kontak</div><div class="footer-links"><a href="#">📧 info@griyasatumimika.web.id</a><a href="#">📞 (021) 1234-5678</a><a href="#">📍 Jakarta, Indonesia</a><a href="#">🕐 Senin–Jumat, 09–17 WIB</a></div></div>
            </div>
            <div class="footer-bottom">
                <div>© {{ date('Y') }} PeduliJiwa. Semua hak dilindungi.</div>
                <div style="display:flex;gap:1.5rem;"><a href="#">Kebijakan Privasi</a><a href="#">Syarat & Ketentuan</a></div>
            </div>
        </footer>
    </body>
</html>
