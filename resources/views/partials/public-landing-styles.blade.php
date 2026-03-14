<style>
            :root {
                --anim-duration: 2s;
                --anim-ease: cubic-bezier(0.25, 0.46, 0.45, 0.94);
                --primary: #2563eb;
                --primary-dark: #1d4ed8;
                --accent: #38bdf8;
                --accent-green: #22c55e;
                --accent-amber: #fbbf24;
                --text: #ffffff;
                --text-muted: rgba(255,255,255,0.78);
                --bg: #e0f2ff;
                --gradient-hero: linear-gradient(135deg, #e0f2ff 0%, #bfdbfe 30%, #e0f2fe 60%, #eff6ff 100%);
                --gradient-impact: linear-gradient(135deg, #0f172a 0%, #1d4ed8 40%, #38bdf8 100%);
                --gradient-card: linear-gradient(145deg, #ffffff 0%, #f1f5f9 100%);
                --gradient-glow: linear-gradient(135deg, #38bdf8 0%, #60a5fa 50%, #a5b4fc 100%);
                --radius-lg: 20px;
                --radius-md: 14px;
                --radius-sm: 10px;
                --shadow-soft: 0 4px 24px rgba(37,99,235,0.12);
                --shadow-card: 0 16px 48px rgba(15,23,42,0.12);
                --shadow-elevated: 0 24px 60px rgba(37,99,235,0.22);
                --shadow-glow: 0 0 60px rgba(56,189,248,0.35);
            }
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(28px); }
                to { opacity: 1; transform: translateY(0); }
            }
            @keyframes fadeInDown {
                from { opacity: 0; transform: translateY(-28px); }
                to { opacity: 1; transform: translateY(0); }
            }
            @keyframes fadeInLeft {
                from { opacity: 0; transform: translateX(32px); }
                to { opacity: 1; transform: translateX(0); }
            }
            @keyframes fadeInRight {
                from { opacity: 0; transform: translateX(-32px); }
                to { opacity: 1; transform: translateX(0); }
            }
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            @keyframes scaleIn {
                from { opacity: 0; transform: scale(0.92); }
                to { opacity: 1; transform: scale(1); }
            }
            @keyframes zoomIn {
                from { opacity: 0; transform: scale(0.85); }
                to { opacity: 1; transform: scale(1); }
            }
            @keyframes gradientShift {
                0%, 100% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
            }
            @keyframes floatSoft {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-6px); }
            }
            @keyframes pulseGlow {
                0%, 100% { box-shadow: 0 4px 20px rgba(59,130,246,0.35); }
                50% { box-shadow: 0 8px 28px rgba(59,130,246,0.5); }
            }
            @keyframes footerMarqueeSlide {
                0% { transform: translateX(0); }
                100% { transform: translateX(-50%); }
            }
            @keyframes shimmer {
                0% { background-position: -200% 0; }
                100% { background-position: 200% 0; }
            }
            @keyframes glowPulse {
                0%, 100% { opacity: 0.6; transform: scale(1); }
                50% { opacity: 0.9; transform: scale(1.05); }
            }
            @keyframes float {
                0%, 100% { transform: translateY(0) rotate(0deg); }
                50% { transform: translateY(-12px) rotate(2deg); }
            }
            .animate-on-scroll {
                opacity: 0;
                transform: translate3d(0, 20px, 0);
                transition: opacity var(--anim-duration) var(--anim-ease), transform var(--anim-duration) var(--anim-ease);
                backface-visibility: hidden;
            }
            .animate-on-scroll.visible {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
            .animate-on-scroll.leaving {
                opacity: 0;
                transform: translate3d(0, 12px, 0);
                transition: opacity var(--anim-duration) var(--anim-ease), transform var(--anim-duration) var(--anim-ease);
            }
            .animate-on-scroll-delay-1 { transition-delay: 0.12s; }
            .animate-on-scroll-delay-2 { transition-delay: 0.2s; }
            .animate-on-scroll-delay-3 { transition-delay: 0.28s; }
            .animate-on-scroll-delay-4 { transition-delay: 0.36s; }
            .animate-on-scroll-delay-5 { transition-delay: 0.44s; }
            .animate-on-scroll-delay-6 { transition-delay: 0.52s; }

            /* Semua variant: durasi sama (1.4s) masuk & keluar - lambat dan seragam */
            .anim-fade-up { opacity: 0; transform: translate3d(0, 32px, 0); transition: opacity var(--anim-duration) var(--anim-ease), transform var(--anim-duration) var(--anim-ease); backface-visibility: hidden; }
            .anim-fade-up.visible { opacity: 1; transform: translate3d(0, 0, 0); }
            .anim-fade-up.leaving { opacity: 0; transform: translate3d(0, -20px, 0); transition: opacity var(--anim-duration) var(--anim-ease), transform var(--anim-duration) var(--anim-ease); }

            .anim-fade-down { opacity: 0; transform: translate3d(0, -32px, 0); transition: opacity var(--anim-duration) var(--anim-ease), transform var(--anim-duration) var(--anim-ease); backface-visibility: hidden; }
            .anim-fade-down.visible { opacity: 1; transform: translate3d(0, 0, 0); }
            .anim-fade-down.leaving { opacity: 0; transform: translate3d(0, 20px, 0); transition: opacity var(--anim-duration) var(--anim-ease), transform var(--anim-duration) var(--anim-ease); }

            .anim-fade-left { opacity: 0; transform: translate3d(40px, 0, 0); transition: opacity var(--anim-duration) var(--anim-ease), transform var(--anim-duration) var(--anim-ease); backface-visibility: hidden; }
            .anim-fade-left.visible { opacity: 1; transform: translate3d(0, 0, 0); }
            .anim-fade-left.leaving { opacity: 0; transform: translate3d(-24px, 0, 0); transition: opacity var(--anim-duration) var(--anim-ease), transform var(--anim-duration) var(--anim-ease); }

            .anim-fade-right { opacity: 0; transform: translate3d(-40px, 0, 0); transition: opacity var(--anim-duration) var(--anim-ease), transform var(--anim-duration) var(--anim-ease); backface-visibility: hidden; }
            .anim-fade-right.visible { opacity: 1; transform: translate3d(0, 0, 0); }
            .anim-fade-right.leaving { opacity: 0; transform: translate3d(24px, 0, 0); transition: opacity var(--anim-duration) var(--anim-ease), transform var(--anim-duration) var(--anim-ease); }

            .anim-scale { opacity: 0; transform: translate3d(0, 0, 0) scale(0.9); transition: opacity var(--anim-duration) var(--anim-ease), transform var(--anim-duration) var(--anim-ease); backface-visibility: hidden; }
            .anim-scale.visible { opacity: 1; transform: translate3d(0, 0, 0) scale(1); }
            .anim-scale.leaving { opacity: 0; transform: translate3d(0, 0, 0) scale(0.95); transition: opacity var(--anim-duration) var(--anim-ease), transform var(--anim-duration) var(--anim-ease); }

            .anim-fade { opacity: 0; transition: opacity var(--anim-duration) var(--anim-ease); backface-visibility: hidden; }
            .anim-fade.visible { opacity: 1; }
            .anim-fade.leaving { opacity: 0; transition: opacity var(--anim-duration) var(--anim-ease); }

            .anim-delay-1 { transition-delay: 0.12s; }
            .anim-delay-2 { transition-delay: 0.2s; }
            .anim-delay-3 { transition-delay: 0.28s; }
            .anim-delay-4 { transition-delay: 0.36s; }
            .anim-delay-5 { transition-delay: 0.44s; }
            .anim-delay-6 { transition-delay: 0.52s; }
            .anim-delay-7 { transition-delay: 0.6s; }
            .anim-delay-8 { transition-delay: 0.68s; }

            .public-main { transition: opacity var(--anim-duration) var(--anim-ease); }
            .public-main.page-exit { opacity: 0; }
            @media (prefers-reduced-motion: reduce) {
                .animate-on-scroll, .anim-fade-up, .anim-fade-down, .anim-fade-left, .anim-fade-right, .anim-scale, .anim-fade { opacity: 1; transform: none; transition: none; }
                .hero, .impact-section, .donate-cta, .hero-pro, .impact-bar, .cta-section { animation: none; }
                .hero-pro::before, .hero-pro::after, .cta-section::before { animation: none; opacity: 0.5; }
                .hero-card-float, .about-badge-float { animation: none; }
            }
            *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
            html { scroll-behavior: smooth; }
            body {
                font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
                color: var(--text);
                background: transparent;
                line-height: 1.6;
                position: relative;
            }
            /* Sticky footer: footer selalu di bawah halaman meski konten sedikit */
            body.public-layout {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }
            body.public-layout .public-main {
                flex: 1;
                display: flex;
                flex-direction: column;
            }
            body.public-layout .public-content {
                flex: 1;
            }
            body::before {
                content: '';
                position: fixed;
                inset: 0;
                z-index: -1;
                background-color: rgba(15, 23, 42, 0.4); /* overlay gelap ringan agar teks terbaca */
                background-image: url("{{ asset('images/landing-bg.png') }}");
                background-size: cover;
                background-attachment: fixed;
                background-position: center top;
                background-repeat: no-repeat;
                background-blend-mode: overlay;
            }
            a { text-decoration: none; color: inherit; }
            img { max-width: 100%; display: block; }
            ul { list-style: none; }
            .navbar {
                position: fixed; top: 0; left: 0; right: 0; z-index: 100;
                background: transparent;
                backdrop-filter: blur(14px);
                border-bottom: 1px solid transparent;
                padding: 0 1.5rem;
                transition: background var(--anim-duration) var(--anim-ease), box-shadow var(--anim-duration) var(--anim-ease), border-color var(--anim-duration) var(--anim-ease);
            }
            .navbar.scrolled {
                background: transparent;
                border-bottom-color: transparent;
                box-shadow: none;
            }
            .nav-inner { max-width: 1200px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; height: 72px; }
            .nav-logo { display: flex; align-items: center; gap: 12px; font-size: 1.25rem; font-weight: 800; color: #ffffff; }
            .nav-logo-icon { width: 42px; height: 42px; background: linear-gradient(135deg, var(--primary), var(--accent)); border-radius: 14px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.1rem; box-shadow: 0 4px 14px rgba(59,130,246,0.35); }
            .nav-links { display: flex; align-items: center; gap: 1.75rem; position: relative; }
            .nav-link {
                font-size: 0.9rem; font-weight: 500; color: #ffffff;
                padding: 0.25rem 0;
                position: relative;
                transition: color var(--anim-duration) var(--anim-ease), opacity var(--anim-duration) var(--anim-ease);
            }
            .nav-link::after {
                content: '';
                position: absolute;
                left: 0; right: 0; bottom: -6px;
                height: 2px;
                border-radius: 999px;
                background: linear-gradient(90deg, var(--primary), var(--accent));
                transform-origin: center;
                transform: scaleX(0);
                opacity: 0;
                transition: transform var(--anim-duration) var(--anim-ease), opacity var(--anim-duration) var(--anim-ease);
            }
            .nav-link:hover { color: #e0f2ff; }
            .nav-link:hover::after { transform: scaleX(1); opacity: 1; }
            .nav-item {
                position: relative;
                display: flex;
                align-items: center;
            }
            .nav-item.has-dropdown:hover .nav-dropdown,
            .nav-item.has-dropdown:focus-within .nav-dropdown {
                opacity: 1;
                transform: translateY(0);
                pointer-events: auto;
            }
            .nav-link-profile {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                border: none;
                background: transparent;
                cursor: pointer;
                padding: 0.4rem 0.65rem;
                margin: 0 -0.35rem;
                border-radius: 999px;
                font: inherit;
                color: #ffffff;
                position: relative;
                transition: background var(--anim-duration) var(--anim-ease), color var(--anim-duration) var(--anim-ease);
            }
            .nav-link-profile::after {
                content: '';
                position: absolute;
                left: 0.65rem; right: 0.65rem; bottom: -2px;
                height: 2px;
                border-radius: 999px;
                background: #1e3a5f;
                transform-origin: center;
                transform: scaleX(0);
                opacity: 0;
                transition: transform var(--anim-duration) var(--anim-ease), opacity var(--anim-duration) var(--anim-ease);
            }
            .nav-item.has-dropdown:hover .nav-link-profile,
            .nav-item.has-dropdown:focus-within .nav-link-profile {
                background: rgba(226,232,240,0.7);
                color: #0f172a;
            }
            .nav-item.has-dropdown:hover .nav-link-profile::after,
            .nav-item.has-dropdown:focus-within .nav-link-profile::after {
                transform: scaleX(1);
                opacity: 1;
            }
            .nav-link-profile svg {
                width: 10px;
                height: 10px;
                color: #e0f2ff;
                flex-shrink: 0;
                transition: transform var(--anim-duration) var(--anim-ease);
            }
            .nav-item.has-dropdown:hover .nav-link-profile svg,
            .nav-item.has-dropdown:focus-within .nav-link-profile svg {
                transform: rotate(180deg);
            }
            .nav-dropdown {
                position: absolute;
                top: 100%;
                left: 0;
                margin-top: 0.5rem;
                min-width: 220px;
                padding: 0.5rem;
                border-radius: 12px;
                background: #ffffff;
                box-shadow: 0 10px 40px rgba(15,23,42,0.12);
                border: 1px solid #e2e8f0;
                opacity: 0;
                transform: translateY(6px);
                pointer-events: none;
                transition: opacity var(--anim-duration) var(--anim-ease), transform var(--anim-duration) var(--anim-ease);
                z-index: 90;
            }
            .nav-dropdown-header {
                display: none;
            }
            .nav-dropdown-list {
                list-style: none;
                margin: 0;
                padding: 0;
            }
            .nav-dropdown-link {
                display: block;
                padding: 0.6rem 0.85rem;
                border-radius: 8px;
                font-size: 0.9rem;
                color: #334155;
                transition: background var(--anim-duration) var(--anim-ease), color var(--anim-duration) var(--anim-ease);
            }
            .nav-dropdown-link span {
                display: block;
            }
            .nav-dropdown-link small {
                display: block;
                font-size: 0.75rem;
                color: var(--text-muted);
                margin-top: 2px;
            }
            .nav-dropdown-link:hover {
                background: #f1f5f9;
                color: #0f172a;
            }
            .nav-dropdown-link.active {
                background: #e0f2fe;
                color: #0369a1;
                font-weight: 500;
            }

            .nav-actions { display: flex; align-items: center; gap: 0.75rem; }
            .btn-outline,
            .btn-primary {
                padding: 0.55rem 1.3rem;
                border-radius: 999px;
                border: 1.5px solid #2563eb;
                background: linear-gradient(135deg, #2563eb, #3b82f6);
                color: #ffffff;
                font-size: 0.875rem;
                font-weight: 600;
                transition: transform var(--anim-duration) var(--anim-ease), box-shadow var(--anim-duration) var(--anim-ease), opacity var(--anim-duration) var(--anim-ease);
                box-shadow: 0 4px 16px rgba(59,130,246,0.35);
            }
            .btn-outline:hover,
            .btn-primary:hover {
                opacity: 0.96;
                transform: translateY(-1px);
                box-shadow: 0 8px 22px rgba(59,130,246,0.45);
            }
            .hero {
                min-height: 90vh;
                padding-top: 72px;
                background: transparent;
                background-image: none;
                animation: none;
                display: flex;
                align-items: center;
                position: relative;
                overflow: hidden;
            }
            .hero-pro::before,
            .hero-pro::after {
                content: none;
            }
            .hero-pro .hero-inner { grid-template-columns: 1.1fr 1fr; gap: 4rem; align-items: center; padding: 4rem 1.5rem 5rem; position: relative; z-index: 1; }
            .hero-label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.15em; color: var(--primary); margin-bottom: 1rem; display: inline-block; padding: 0.4rem 1rem; background: rgba(37,99,235,0.08); border-radius: 100px; border: 1px solid rgba(37,99,235,0.2); }
            .hero-pro .hero-label { color: #ffffff; background: rgba(255,255,255,0.15); border-color: rgba(255,255,255,0.35); }
            .hero-pro .hero-title { font-size: 2.75rem; line-height: 1.2; letter-spacing: -0.02em; color: #ffffff; }
            .hero-pro .hero-title .highlight { color: #ffffff; background: none; -webkit-text-fill-color: #ffffff; }
            .hero-pro .hero-desc { font-size: 1rem; color: var(--text-muted); max-width: 480px; margin-bottom: 1.75rem; line-height: 1.7; }
            .btn-hero-outline {
                padding: 0.85rem 1.75rem;
                border-radius: var(--radius-sm);
                border: 2px solid #2563eb;
                background: linear-gradient(135deg, #2563eb, #3b82f6);
                color: #ffffff;
                font-size: 0.95rem;
                font-weight: 600;
                transition: all var(--anim-duration) var(--anim-ease);
                display: inline-flex;
            }
            .btn-hero-outline:hover {
                opacity: 0.96;
                transform: translateY(-2px);
                box-shadow: 0 8px 22px rgba(37,99,235,0.45);
            }
            .hero-metrics { display: flex; gap: 2.5rem; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e2e8f0; }
            .metric { display: flex; flex-direction: column; }
            .metric-val { font-size: 1.25rem; font-weight: 700; color: var(--text); }
            .metric-lbl { font-size: 0.8rem; color: var(--text-muted); margin-top: 2px; }
            .hero-card-wrap { display: flex; justify-content: flex-end; }
            .hero-card { background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%); border-radius: var(--radius-lg); padding: 1.75rem; box-shadow: var(--shadow-elevated); border: 1px solid rgba(37,99,235,0.15); max-width: 380px; transition: all var(--anim-duration) var(--anim-ease); position: relative; overflow: hidden; }
            .hero-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #2563eb, #06b6d4); }
            .hero-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-glow); border-color: rgba(37,99,235,0.3); }
            .hero-card-tag { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: var(--primary); margin-bottom: 0.5rem; display: block; }
            .hero-card h3 { font-size: 1.1rem; font-weight: 700; color: var(--text); margin-bottom: 0.5rem; line-height: 1.4; }
            .hero-card p { font-size: 0.875rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 1rem; }
            .hero-card-progress { margin-bottom: 1rem; }
            .progress-row { display: flex; justify-content: space-between; font-size: 0.8rem; margin-bottom: 0.35rem; }
            .progress-row span:first-child { font-weight: 700; color: var(--primary); }
            .progress-note { font-size: 0.75rem; color: var(--text-muted); }
            .btn-hero-card { display: block; text-align: center; padding: 0.75rem; background: linear-gradient(135deg, #2563eb, #3b82f6); color: white; border-radius: var(--radius-sm); font-size: 0.9rem; font-weight: 600; transition: all var(--anim-duration) var(--anim-ease); }
            .btn-hero-card:hover { transform: scale(1.02); box-shadow: 0 8px 24px rgba(37,99,235,0.4); }
            .impact-bar { background: var(--gradient-impact); padding: 4rem 1.5rem; position: relative; overflow: hidden; }
            .impact-bar::before { content: ''; position: absolute; inset: 0; background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); opacity: 0.5; }
            .impact-bar .impact-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem; text-align: center; position: relative; z-index: 1; }
            .impact-item { display: flex; flex-direction: column; gap: 0.35rem; padding: 0 1rem; border-right: 1px solid rgba(255,255,255,0.2); transition: transform var(--anim-duration) var(--anim-ease); }
            .impact-item:last-child { border-right: none; }
            .impact-item:hover { transform: translateY(-4px); }
            .impact-num { font-size: 2.25rem; font-weight: 800; color: white; letter-spacing: -0.02em; text-shadow: 0 2px 20px rgba(0,0,0,0.2); }
            .impact-txt { font-size: 0.9rem; color: rgba(255,255,255,0.85); }
            .section-head { margin-bottom: 2.5rem; }
            .section-label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.12em; color: var(--primary); margin-bottom: 0.5rem; display: inline-block; padding: 0.3rem 0.8rem; background: linear-gradient(135deg, rgba(37,99,235,0.08), rgba(6,182,212,0.06)); border-radius: 100px; }
            .section-head h2 { font-size: 2rem; font-weight: 700; color: var(--text); line-height: 1.3; letter-spacing: -0.02em; }
            .section-lead { font-size: 1rem; color: var(--text-muted); margin-top: 0.75rem; max-width: 680px; line-height: 1.8; }
            .section-head-center { text-align: center; }
            .section-head-center .section-lead { margin-left: auto; margin-right: auto; }
            .section-about { background: transparent; }
            .about-cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 2rem; }
            .about-card { padding: 2rem; background: white; border-radius: var(--radius-md); border: 1px solid #e2e8f0; transition: all var(--anim-duration) var(--anim-ease); position: relative; overflow: hidden; }
            .about-card::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 3px; background: linear-gradient(90deg, #2563eb, #06b6d4); transform: scaleX(0); transition: transform var(--anim-duration) var(--anim-ease); transform-origin: left; }
            .about-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-elevated); border-color: transparent; }
            .about-card:hover::before { transform: scaleX(1); }
            .about-card-icon { font-size: 2.25rem; margin-bottom: 1rem; width: 56px; height: 56px; border-radius: 14px; background: linear-gradient(135deg, rgba(37,99,235,0.1), rgba(6,182,212,0.1)); display: flex; align-items: center; justify-content: center; }
            .about-card h4 { font-size: 0.95rem; font-weight: 700; color: var(--text); margin-bottom: 0.35rem; }
            .about-card p { font-size: 0.85rem; color: var(--text-muted); line-height: 1.6; }
            .about-bridge { font-size: 1rem; color: var(--text-muted); margin-bottom: 2rem; text-align: center; max-width: 640px; margin-left: auto; margin-right: auto; line-height: 1.75; }
            .about-close { font-size: 0.95rem; color: var(--text-muted); margin-bottom: 1.5rem; text-align: center; }
            .about-links { display: flex; gap: 2rem; flex-wrap: wrap; justify-content: center; }
            .link-arrow { font-size: 0.9rem; font-weight: 600; color: var(--primary); transition: color var(--anim-duration) var(--anim-ease); }
            .link-arrow:hover { color: var(--primary-dark); }
            .link-arrow::after { content: ' →'; opacity: 0.7; }
            .section-services { background: transparent; }
            .services-steps { display: flex; align-items: center; justify-content: center; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 1rem; }
            .step { display: flex; flex-direction: column; align-items: center; padding: 1.25rem 1.5rem; background: white; border-radius: var(--radius-md); border: 1px solid #e2e8f0; min-width: 110px; transition: all var(--anim-duration) var(--anim-ease); box-shadow: 0 4px 16px rgba(0,0,0,0.04); }
            .step:hover { border-color: transparent; box-shadow: var(--shadow-elevated); transform: translateY(-6px) scale(1.02); }
            .step:hover .step-num { background: linear-gradient(135deg, #2563eb, #06b6d4); transform: scale(1.1); }
            .step-num { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #2563eb, #3b82f6); color: white; display: inline-flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: 700; margin-bottom: 0.75rem; transition: all var(--anim-duration) var(--anim-ease); }
            .step span:last-child { font-size: 0.85rem; font-weight: 600; color: var(--text); }
            .step-arrow { width: 28px; height: 3px; background: linear-gradient(90deg, #cbd5e1, #94a3b8); border-radius: 2px; transition: background var(--anim-duration) var(--anim-ease); }
            .services-footer { text-align: center; font-size: 0.9rem; }
            .services-footer a { color: var(--primary); font-weight: 600; }
            .section-donate { background: transparent; }
            .donate-steps { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 2rem; }
            .donate-step { text-align: center; padding: 1.5rem; background: white; border-radius: var(--radius-md); border: 1px solid #e2e8f0; transition: all var(--anim-duration) var(--anim-ease); }
            .donate-step:hover { transform: translateY(-6px); box-shadow: var(--shadow-card); border-color: rgba(37,99,235,0.2); }
            .donate-step:hover span { background: linear-gradient(135deg, #2563eb, #06b6d4); transform: rotate(5deg); }
            .donate-step span { display: flex; align-items: center; justify-content: center; width: 44px; height: 44px; border-radius: 50%; background: linear-gradient(135deg, #2563eb, #3b82f6); color: white; font-size: 1.1rem; font-weight: 700; margin: 0 auto 0.75rem; transition: all var(--anim-duration) var(--anim-ease); }
            .donate-step p { font-size: 0.9rem; font-weight: 600; color: var(--text); }
            .donate-cta-wrap { text-align: center; }
            .btn-donate-main {
                display: inline-flex;
                padding: 1rem 2.5rem;
                background: linear-gradient(135deg, #2563eb, #3b82f6);
                color: #ffffff;
                font-size: 1rem;
                font-weight: 600;
                border-radius: var(--radius-sm);
                box-shadow: 0 8px 24px rgba(37,99,235,0.35);
                transition: all var(--anim-duration) var(--anim-ease);
            }
            .btn-donate-main:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(37,99,235,0.45); }
            .section-testi { background: transparent; }
            .testi-cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
            .testi-card { padding: 2rem; background: white; border-radius: var(--radius-md); border: 1px solid #e2e8f0; position: relative; transition: all var(--anim-duration) var(--anim-ease); }
            .testi-card::before { content: '"'; position: absolute; top: 1rem; left: 1.5rem; font-size: 3rem; font-weight: 800; color: rgba(37,99,235,0.1); font-family: Georgia, serif; line-height: 1; }
            .testi-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-elevated); border-color: rgba(37,99,235,0.2); }
            .testi-stars { color: #f59e0b; font-size: 1rem; margin-bottom: 0.75rem; letter-spacing: 2px; }
            .testi-card p { font-size: 0.9rem; color: var(--text-muted); line-height: 1.7; margin-bottom: 1rem; font-style: italic; }
            .testi-author { font-size: 0.85rem; font-weight: 500; color: var(--text); }
            .cta-section {
                background: transparent;
                color: var(--text);
                text-align: center;
                padding: 5rem 1.5rem;
                position: relative;
                overflow: hidden;
            }
            .cta-section::before {
                content: none;
            }
            .cta-section .section-inner { position: relative; z-index: 1; }
            .cta-section h2 { font-size: 2.25rem; font-weight: 700; margin-bottom: 0.5rem; letter-spacing: -0.02em; text-shadow: 0 2px 20px rgba(0,0,0,0.2); }
            .cta-section p { font-size: 1rem; opacity: 0.9; margin-bottom: 2rem; }
            .cta-btns { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
            .btn-cta-primary,
            .btn-cta-secondary {
                padding: 1rem 2.25rem;
                border-radius: var(--radius-sm);
                border: 2px solid #2563eb;
                background: linear-gradient(135deg, #2563eb, #3b82f6);
                color: #ffffff;
                font-weight: 600;
                transition: all var(--anim-duration) var(--anim-ease);
            }
            .btn-cta-primary:hover,
            .btn-cta-secondary:hover {
                transform: translateY(-4px) scale(1.02);
                box-shadow: 0 16px 40px rgba(0,0,0,0.2);
            }
            .section-contact { background: transparent; }
            .contact-row { display: flex; flex-wrap: wrap; justify-content: center; gap: 2rem; }
            .section-contact .contact-item {
                padding: 0.9rem 1.5rem;
                background: rgba(255,255,255,0.12);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border-radius: var(--radius-md);
                font-size: 0.9rem;
                color: rgba(255,255,255,0.95);
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                transition: all var(--anim-duration) var(--anim-ease);
                border: 1px solid rgba(255,255,255,0.15);
                text-decoration: none;
            }
            .section-contact .contact-item:hover {
                background: rgba(255,255,255,0.18);
                border-color: rgba(255,255,255,0.25);
                transform: translateY(-2px);
                color: #ffffff;
            }
            .section-contact .contact-item:not(a) { cursor: default; }

            /* Offset konten agar tidak tertutup navbar (halaman .public-page: transparan, profil pasien, dll) */
            .public-page > section:first-child {
                padding-top: 96px;
            }

            /* Halaman statis (profil, kontak, dll) */
            .page-hero {
                padding-top: 96px;
                padding-bottom: 2.5rem;
                background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 45%, #38bdf8 100%);
                color: #e5f2ff;
            }
            .page-hero .section-inner {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
                text-align: center;
            }
            .page-breadcrumb {
                font-size: 0.8rem;
                color: rgba(226,232,240,0.9);
                margin-bottom: 0.35rem;
            }
            .page-breadcrumb a {
                color: #e0f2fe;
            }
            .page-title {
                font-size: 2.1rem;
                font-weight: 700;
                letter-spacing: -0.02em;
                color: #f9fafb;
            }
            .page-subtitle {
                max-width: 640px;
                margin: 0 auto;
                font-size: 0.95rem;
                color: rgba(226,232,240,0.9);
            }

            .section-contact-page {
                background: radial-gradient(circle at top, rgba(59,130,246,0.12), transparent 55%), #f9fafb;
            }
            .contact-layout {
                display: grid;
                grid-template-columns: minmax(0, 0.95fr) minmax(0, 1.05fr);
                gap: 2.5rem;
                margin-top: -2.25rem;
                padding: 2.5rem 2rem 3rem;
                border-radius: 32px;
                background: #ffffff;
                box-shadow: 0 22px 70px rgba(15,23,42,0.18);
                border: 1px solid #dbeafe;
            }
            .contact-info-column,
            .contact-form-column {
                background: #f9fafb;
                border-radius: var(--radius-lg);
                padding: 2rem 2.1rem;
                box-shadow: 0 14px 40px rgba(15,23,42,0.06);
                border: 1px solid #e2e8f0;
                color: var(--text);
            }
            .contact-heading {
                font-size: 1.1rem;
                font-weight: 700;
                color: #0f172a;
                margin-bottom: 0.5rem;
            }
            .contact-desc {
                font-size: 0.9rem;
                color: var(--text-muted);
                margin-bottom: 1.5rem;
            }
            .contact-card-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 1rem;
                margin-bottom: 1.5rem;
            }
            .contact-card {
                display: flex;
                align-items: flex-start;
                gap: 0.75rem;
                padding: 1rem 1.1rem;
                border-radius: var(--radius-md);
                background: var(--gradient-card);
                border: 1px solid #e2e8f0;
                transition: transform var(--anim-duration) var(--anim-ease), box-shadow var(--anim-duration) var(--anim-ease), border-color var(--anim-duration) var(--anim-ease), background var(--anim-duration) var(--anim-ease);
            }
            .contact-card-icon {
                width: 40px;
                height: 40px;
                border-radius: 12px;
                background: linear-gradient(135deg, #22c55e, #16a34a);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.2rem;
                color: white;
                flex-shrink: 0;
            }
            .contact-card--address .contact-card-icon {
                background: linear-gradient(135deg, #38bdf8, #2563eb);
            }
            .contact-card--phone .contact-card-icon {
                background: linear-gradient(135deg, #22c55e, #16a34a);
            }
            .contact-card--email .contact-card-icon {
                background: linear-gradient(135deg, #a855f7, #6366f1);
            }
            .contact-card-body h3 {
                font-size: 0.9rem;
                font-weight: 700;
                color: #0f172a;
                margin-bottom: 0.25rem;
            }
            .contact-card-body p {
                font-size: 0.85rem;
                color: var(--text-muted);
                line-height: 1.6;
            }
            .contact-card-body a {
                color: var(--primary-dark);
                font-weight: 600;
            }
            .contact-card-body a:hover {
                text-decoration: underline;
            }
            .contact-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 14px 40px rgba(15,23,42,0.12);
                border-color: #bfdbfe;
                background: #ffffff;
            }
            .contact-note {
                display: block;
                font-size: 0.78rem;
                margin-top: 2px;
                color: var(--text-muted);
            }
            .contact-location-highlight {
                margin-top: 0.5rem;
                display: flex;
                gap: 0.75rem;
                padding: 1rem 1.1rem;
                border-radius: var(--radius-md);
                background: linear-gradient(135deg, #eff6ff, #e0f2fe);
                color: var(--text);
            }
            .contact-location-highlight .contact-card-body h3 {
                color: #0f172a;
            }
            .contact-location-highlight .contact-card-body p {
                color: var(--text-muted);
            }

            .contact-form {
                display: flex;
                flex-direction: column;
                gap: 0.9rem;
            }
            .contact-form-header {
                margin-bottom: 1.25rem;
            }
            .contact-pill-label {
                display: inline-flex;
                align-items: center;
                gap: 0.35rem;
                padding: 0.25rem 0.7rem;
                border-radius: 999px;
                font-size: 0.7rem;
                font-weight: 600;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                background: rgba(191,219,254,0.7);
                color: #1d4ed8;
                margin-bottom: 0.5rem;
            }
            .form-row-grid {
                display: grid;
                grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
                gap: 0.9rem;
            }
            .form-row label {
                display: block;
                font-size: 0.82rem;
                font-weight: 600;
                color: #0f172a;
                margin-bottom: 0.3rem;
            }
            .form-row input,
            .form-row textarea {
                width: 100%;
                border-radius: 10px;
                border: 1px solid #d1d5db;
                padding: 0.55rem 0.7rem;
                font-size: 0.88rem;
                font-family: inherit;
                color: #0f172a;
                background: #f9fafb;
                transition: border-color var(--anim-duration) var(--anim-ease), box-shadow var(--anim-duration) var(--anim-ease), background var(--anim-duration) var(--anim-ease);
            }
            .form-row input:focus,
            .form-row textarea:focus {
                outline: none;
                border-color: #2563eb;
                box-shadow: 0 0 0 1px rgba(37,99,235,0.25);
                background: #ffffff;
            }
            .btn-full {
                width: 100%;
                text-align: center;
                justify-content: center;
            }
            .contact-form-note {
                margin-top: 0.5rem;
                font-size: 0.78rem;
                color: var(--text-muted);
            }
            .btn-prog-outline {
                padding: 0.45rem 1.1rem;
                border-radius: 8px;
                border: 2px solid #2563eb;
                background: linear-gradient(135deg, #2563eb, #3b82f6);
                color: #ffffff;
                font-size: 0.82rem;
                font-weight: 600;
            }
            .hero::before,
            .hero::after {
                content: none;
            }
            .hero-inner { max-width: 1200px; margin: 0 auto; padding: 5rem 1.5rem; display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; position: relative; z-index: 1; }
            .hero-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(59,130,246,0.1); color: var(--primary-dark); font-size: 0.8rem; font-weight: 600; padding: 6px 14px; border-radius: 100px; margin-bottom: 1.25rem; border: 1px solid rgba(59,130,246,0.2); }
            .hero-title { font-size: 3rem; font-weight: 800; line-height: 1.2; color: var(--text); margin-bottom: 1.25rem; }
            .hero-title .highlight { background: linear-gradient(135deg, #2563eb 0%, #06b6d4 50%, #6366f1 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
            .hero-desc { font-size: 1.05rem; color: #5a5a7a; margin-bottom: 2rem; line-height: 1.75; }
            .hero-cta { display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 2.5rem; }
            .btn-hero-primary {
                padding: 0.95rem 2rem;
                background: linear-gradient(135deg, #2563eb, #3b82f6);
                border-radius: var(--radius-sm);
                color: #ffffff;
                font-size: 0.95rem;
                font-weight: 600;
                box-shadow: 0 8px 24px rgba(37,99,235,0.35);
                transition: all var(--anim-duration) var(--anim-ease);
                display: inline-flex;
                align-items: center;
                gap: 8px;
            }
            .btn-hero-primary:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(37,99,235,0.45); }
            .btn-hero-secondary {
                padding: 0.9rem 2rem;
                border-radius: 12px;
                border: 2px solid #2563eb;
                background: linear-gradient(135deg, #2563eb, #3b82f6);
                color: #ffffff;
                font-size: 1rem;
                font-weight: 600;
                transition: all var(--anim-duration) var(--anim-ease);
                display: inline-flex;
                align-items: center;
                gap: 8px;
            }
            .btn-hero-secondary:hover {
                opacity: 0.96;
                transform: translateY(-2px);
                box-shadow: 0 10px 26px rgba(37,99,235,0.5);
            }
            .hero-stats { display: flex; gap: 2rem; }
            .hero-stat-number { font-size: 1.5rem; font-weight: 700; color: #0f0f2d; }
            .hero-stat-label { font-size: 0.8rem; color: #7a7a9a; margin-top: 2px; }
            .hero-visual { position: relative; }
            .hero-card-main { background: white; border-radius: 24px; padding: 2rem; box-shadow: 0 20px 60px rgba(59,130,246,0.12); border: 1px solid #e2e8f0; }
            .campaign-label { font-size: 0.75rem; font-weight: 600; color: var(--accent); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; }
            .campaign-title { font-size: 1.1rem; font-weight: 700; color: #0f0f2d; margin-bottom: 0.5rem; }
            .campaign-desc { font-size: 0.85rem; color: #6a6a8a; margin-bottom: 1.25rem; line-height: 1.6; }
            .progress-info { display: flex; justify-content: space-between; font-size: 0.8rem; margin-bottom: 6px; }
            .progress-raised { font-weight: 700; color: var(--primary-dark); }
            .progress-pct { color: #7a7a9a; }
            .progress-bar { height: 8px; background: #ebebf8; border-radius: 100px; overflow: hidden; margin-bottom: 0.75rem; }
            .progress-fill { height: 100%; background: linear-gradient(90deg, #2563eb, #06b6d4); border-radius: 100px; transition: width var(--anim-duration) var(--anim-ease); }
            .campaign-footer { display: flex; align-items: center; justify-content: space-between; margin-top: 1rem; }
            .donor-avatars { display: flex; align-items: center; }
            .donor-avatar { width: 30px; height: 30px; border-radius: 50%; border: 2px solid white; margin-left: -8px; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; color: white; }
            .donor-avatar:first-child { margin-left: 0; }
            .donor-count { font-size: 0.8rem; color: #6a6a8a; margin-left: 10px; }
            .btn-donate-sm {
                padding: 0.45rem 1rem;
                background: linear-gradient(135deg, #2563eb, #3b82f6);
                border-radius: 8px;
                color: #ffffff;
                font-size: 0.8rem;
                font-weight: 600;
            }
            .hero-card-float { position: absolute; background: linear-gradient(145deg, #ffffff, #f8fafc); border-radius: 16px; padding: 1rem 1.25rem; box-shadow: 0 10px 40px rgba(0,0,0,0.08); border: 1px solid #e2e8f0; transition: transform var(--anim-duration) var(--anim-ease), box-shadow var(--anim-duration) var(--anim-ease); }
            .hero-card-float:hover { transform: translateY(-4px); box-shadow: 0 16px 48px rgba(59,130,246,0.15); }
            .float-1 { top: -20px; right: -20px; animation: floatSoft 5s ease-in-out infinite; }
            .float-2 { bottom: 30px; left: -30px; animation: floatSoft 5s ease-in-out infinite 1.5s; }
            .float-icon { font-size: 1.5rem; margin-bottom: 4px; }
            .float-value { font-size: 1.1rem; font-weight: 700; color: #0f0f2d; }
            .float-label { font-size: 0.7rem; color: #8a8aaa; }
            .section { padding: 5.25rem 1.5rem; }
            .section-inner { max-width: 1200px; margin: 0 auto; }
            .section-tag { display: inline-block; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: var(--primary-dark); background: rgba(59,130,246,0.08); padding: 4px 12px; border-radius: 100px; margin-bottom: 1rem; }
            .section-title { font-size: 2.25rem; font-weight: 700; color: #0f0f2d; line-height: 1.25; margin-bottom: 1rem; }
            .section-desc { font-size: 1rem; color: #5a5a7a; max-width: 560px; line-height: 1.75; }
            .section-header-center { text-align: center; }
            .section-header-center .section-desc { margin: 0 auto; }

            /* Override: semua kotak/div utama transparan dan menggunakan efek blur di atas background */
            .hero-card,
            .hero-card-main,
            .about-card,
            .step,
            .donate-step,
            .testi-card,
            .program-card,
            .services-flow,
            .services-step,
            .profile-meta-card,
            .profile-subsections > div,
            .contact-card,
            .contact-info-column,
            .contact-form-column,
            .gallery-item,
            .faq-list,
            .faq-item,
            .partner-card,
            .cta-section,
            .section-about,
            .section-services,
            .section-donate,
            .section-testi,
            .section-contact,
            .section-contact-page,
            .services-section,
            .gallery-section,
            .faq-section {
                background: transparent !important;
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
            }
            /* Section utama tanpa efek blur tambahan, hanya transparan di atas background */
            .cta-section,
            .section-about,
            .section-services,
            .section-donate,
            .section-testi,
            .section-contact,
            .section-contact-page,
            .services-section,
            .gallery-section,
            .faq-section {
                backdrop-filter: none;
                -webkit-backdrop-filter: none;
            }
            .impact-section { background: var(--gradient-impact); background-size: 200% 200%; animation: gradientShift 15s ease infinite; color: white; padding: 4rem 1.5rem; }
            .impact-grid { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem; text-align: center; }
            .impact-grid > div { transition: transform var(--anim-duration) var(--anim-ease); }
            .impact-grid > div:hover { transform: translateY(-4px); }
            .impact-number { font-size: 2.5rem; font-weight: 700; color: white; margin-bottom: 0.25rem; text-shadow: 0 2px 12px rgba(0,0,0,0.15); }
            .impact-label { font-size: 0.9rem; color: rgba(255,255,255,0.9); }
            .impact-icon { font-size: 2rem; margin-bottom: 0.75rem; transition: transform var(--anim-duration) var(--anim-ease); }
            .impact-grid > div:hover .impact-icon { transform: scale(1.15); }
            .about-section { background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 50%, #e0f2fe 100%); }
            .about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: center; }
            .about-img-bg { width: 100%; aspect-ratio: 4/3; background: linear-gradient(135deg, #dbeafe 0%, #e0f2fe 100%); border-radius: 24px; display: flex; align-items: center; justify-content: center; font-size: 8rem; }
            .about-badge-float { position: absolute; bottom: -20px; right: -20px; background: white; border-radius: 16px; padding: 1rem 1.5rem; box-shadow: 0 10px 40px rgba(0,0,0,0.1); text-align: center; }
            .about-img-wrap { position: relative; }
            .about-features { margin-top: 2rem; display: flex; flex-direction: column; gap: 1.25rem; }
            .feature-item { display: flex; gap: 1rem; align-items: flex-start; }
            .feature-icon-wrap { width: 44px; height: 44px; border-radius: 12px; background: rgba(59,130,246,0.1); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; }
            .feature-title { font-size: 0.95rem; font-weight: 600; color: #0f0f2d; margin-bottom: 3px; }
            .feature-desc { font-size: 0.85rem; color: #6a6a8a; line-height: 1.5; }

            .profile-section {
                background: radial-gradient(circle at top left, rgba(59,130,246,0.12), transparent 60%), #f9fafb;
            }
            .profile-tabs {
                display: inline-flex;
                gap: 0.5rem;
                padding: 0.35rem;
                border-radius: 999px;
                background: #e5edf9;
                margin: 0 auto 2rem;
            }
            .profile-tab-button {
                border: none;
                background: transparent;
                padding: 0.45rem 1.1rem;
                border-radius: 999px;
                font-size: 0.85rem;
                font-weight: 600;
                color: #1e3a8a;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                gap: 0.4rem;
                transition: background var(--anim-duration) var(--anim-ease), box-shadow var(--anim-duration) var(--anim-ease), color var(--anim-duration) var(--anim-ease), transform var(--anim-duration) var(--anim-ease);
            }
            .profile-tab-button span.icon {
                font-size: 1rem;
            }
            .profile-tab-button.is-active {
                background: #ffffff;
                color: #0f172a;
                box-shadow: 0 8px 20px rgba(15,23,42,0.15);
                transform: translateY(-1px);
            }
            .profile-tab-button:not(.is-active):hover {
                background: rgba(255,255,255,0.7);
            }
            .profile-grid {
                display: grid;
                grid-template-columns: 1.4fr 1fr;
                gap: 3rem;
                align-items: flex-start;
            }
            .profile-body {
                display: flex;
                flex-direction: column;
                gap: 1.75rem;
                max-width: 880px;
            }
            .profile-meta-card {
                background: white;
                border-radius: var(--radius-lg);
                padding: 1.75rem 1.9rem;
                box-shadow: var(--shadow-soft);
                border: 1px solid #e2e8f0;
            }
            .profile-meta-title {
                font-size: 0.9rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                color: var(--primary-dark);
                margin-bottom: 1rem;
            }
            .profile-meta-list {
                font-size: 0.9rem;
                color: var(--text-muted);
            }
            .profile-meta-list dt {
                font-weight: 600;
                color: var(--text);
            }
            .profile-meta-list dd {
                margin: 0 0 0.75rem;
            }
            .pill-list {
                display: flex;
                flex-wrap: wrap;
                gap: 0.5rem;
                margin-top: 0.75rem;
            }
            .pill-list span {
                font-size: 0.8rem;
                padding: 0.35rem 0.8rem;
                border-radius: 999px;
                background: rgba(59,130,246,0.07);
                color: var(--primary-dark);
                font-weight: 500;
            }
            .profile-intro-text {
                font-size: 0.95rem;
                color: var(--text-muted);
                line-height: 1.9;
            }
            .profile-subsections {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 1.75rem;
                margin-top: 2.5rem;
            }
            .profile-subsections > div {
                position: relative;
                background: var(--gradient-card);
                border-radius: var(--radius-md);
                padding: 1.5rem 1.6rem;
                box-shadow: var(--shadow-soft);
                border: 1px solid #e2e8f0;
                overflow: hidden;
                transition: transform var(--anim-duration) var(--anim-ease), box-shadow var(--anim-duration) var(--anim-ease), border-color var(--anim-duration) var(--anim-ease);
            }
            .profile-subsections > div::before {
                content: '';
                position: absolute;
                inset: 0;
                background: radial-gradient(circle at top right, rgba(59,130,246,0.18), transparent 55%);
                opacity: 0.6;
                pointer-events: none;
            }
            .profile-subsections > div > * {
                position: relative;
                z-index: 1;
            }
            .profile-subsections > div:hover {
                transform: translateY(-4px);
                box-shadow: var(--shadow-card);
                border-color: #bfdbfe;
            }
            .profile-subsections h3 {
                font-size: 1rem;
                font-weight: 700;
                color: #0f172a;
                margin-bottom: 0.5rem;
            }
            .profile-subsections p,
            .profile-subsections ul {
                font-size: 0.9rem;
                color: var(--text-muted);
                line-height: 1.7;
            }
            .profile-subsections ul {
                padding-left: 1.1rem;
                list-style: disc;
            }
            .profile-card-label {
                display: inline-flex;
                align-items: center;
                gap: 0.4rem;
                font-size: 0.75rem;
                font-weight: 600;
                color: var(--primary-dark);
                background: rgba(59,130,246,0.08);
                padding: 0.25rem 0.7rem;
                border-radius: 999px;
                margin-bottom: 0.65rem;
            }
            .profile-card-label .icon {
                font-size: 1rem;
            }
            .profile-history {
                margin-top: 2.25rem;
            }
            .profile-history-title,
            .profile-structure-title {
                font-size: 1rem;
                font-weight: 700;
                color: #0f172a;
                margin-bottom: 0.5rem;
            }
            .profile-history-text {
                font-size: 0.9rem;
                color: var(--text-muted);
                line-height: 1.75;
            }
            .profile-structure-block {
                margin-top: 2.5rem;
                padding-top: 2rem;
                border-top: 1px solid #e2e8f0;
            }
            .profile-structure-subtitle {
                font-size: 0.85rem;
                color: var(--text-muted);
                margin-bottom: 1.5rem;
            }
            .profile-tab-panel {
                display: none;
            }
            .profile-tab-panel.is-active {
                display: block;
            }
            .org-chart {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 0;
                margin-top: 2rem;
                padding: 2rem 0;
            }
            .org-level {
                display: flex;
                justify-content: center;
                align-items: flex-start;
                gap: 2rem;
                position: relative;
            }
            .org-level-connector {
                width: 2px;
                min-height: 20px;
                background: var(--primary-dark);
                margin: 0 auto;
            }
            .org-level-connector.branch {
                display: flex;
                width: 100%;
                min-height: 20px;
                justify-content: center;
                position: relative;
            }
            .org-level-connector.branch::before {
                content: '';
                position: absolute;
                top: 0;
                left: 50%;
                transform: translateX(-50%);
                width: 2px;
                height: 10px;
                background: var(--primary-dark);
            }
            .org-level-connector.branch::after {
                content: '';
                position: absolute;
                top: 10px;
                left: 0;
                right: 0;
                height: 2px;
                background: var(--primary-dark);
            }
            .org-node {
                background: white;
                border-radius: var(--radius-md);
                padding: 1.25rem 1.5rem;
                min-width: 200px;
                max-width: 240px;
                text-align: center;
                box-shadow: 0 12px 35px rgba(15,23,42,0.08);
                border: 1px solid #e2e8f0;
                position: relative;
                cursor: pointer;
                transition: transform var(--anim-duration) var(--anim-ease), box-shadow var(--anim-duration) var(--anim-ease);
            }
            .org-node:hover {
                transform: translateY(-4px);
                box-shadow: 0 18px 45px rgba(59,130,246,0.2);
                border-color: #bfdbfe;
            }
            .org-node-photo {
                width: 80px;
                height: 80px;
                margin: 0 auto 1rem;
                border-radius: 50%;
                background: linear-gradient(135deg, var(--primary), var(--accent));
                object-fit: cover;
                border: 3px solid #e0f2fe;
                display: block;
                transition: border-color var(--anim-duration) var(--anim-ease);
            }
            .org-node:hover .org-node-photo {
                border-color: var(--primary);
            }
            .org-node-icon {
                width: 80px;
                height: 80px;
                margin: 0 auto 1rem;
                background: linear-gradient(135deg, var(--primary-dark), var(--accent));
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 2rem;
                border: 3px solid #e0f2fe;
            }
            .org-node-name {
                font-size: 0.95rem;
                font-weight: 700;
                color: #0f172a;
                margin-bottom: 0.25rem;
            }
            .org-node-title {
                font-size: 0.8rem;
                color: var(--text-muted);
                font-weight: 500;
            }
            .org-node-hint { font-size: 0.7rem; color: var(--accent); margin-top: 0.5rem; opacity: 0; transition: opacity var(--anim-duration) var(--anim-ease); }
            .org-node:hover .org-node-hint { opacity: 1; }

            .org-modal-overlay {
                position: fixed; inset: 0; z-index: 999;
                background: rgba(15,23,42,0.6);
                display: flex; align-items: center; justify-content: center;
                padding: 1.5rem;
                opacity: 0; visibility: hidden;
                transition: opacity var(--anim-duration) var(--anim-ease), visibility var(--anim-duration) var(--anim-ease);
            }
            .org-modal-overlay.open { opacity: 1; visibility: visible; }
            .org-modal {
                background: white;
                border-radius: 24px;
                padding: 2rem;
                max-width: 380px;
                width: 100%;
                text-align: center;
                box-shadow: 0 25px 60px rgba(15,23,42,0.25);
                transform: scale(0.9);
                transition: transform var(--anim-duration) var(--anim-ease);
            }
            .org-modal-overlay.open .org-modal { transform: scale(1); }
            .org-modal-photo {
                width: 120px;
                height: 120px;
                margin: 0 auto 1.25rem;
                border-radius: 50%;
                object-fit: cover;
                border: 4px solid #e0f2fe;
                display: block;
            }
            .org-modal-icon {
                width: 120px; height: 120px;
                margin: 0 auto 1.25rem;
                border-radius: 50%;
                background: linear-gradient(135deg, var(--primary), var(--accent));
                display: flex; align-items: center; justify-content: center;
                font-size: 3rem;
                border: 4px solid #e0f2fe;
            }
            .org-modal-name { font-size: 1.25rem; font-weight: 700; color: #0f172a; margin-bottom: 0.35rem; }
            .org-modal-title { font-size: 0.95rem; color: var(--primary-dark); font-weight: 600; margin-bottom: 0.75rem; }
            .org-modal-desc { font-size: 0.88rem; color: var(--text-muted); line-height: 1.6; }
            .org-modal-close {
                margin-top: 1.5rem;
                padding: 0.6rem 1.5rem;
                border-radius: 12px;
                border: none;
                background: linear-gradient(135deg, var(--primary), var(--accent));
                color: white;
                font-size: 0.9rem;
                font-weight: 600;
                cursor: pointer;
                transition: opacity var(--anim-duration) var(--anim-ease);
            }
            .org-modal-close:hover { opacity: 0.9; }
            .org-grid {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 1rem;
                margin-top: 1.75rem;
            }
            .org-card {
                background: white;
                border-radius: var(--radius-md);
                padding: 1.1rem 1.1rem 1.2rem;
                border: 1px solid #e2e8f0;
                box-shadow: 0 12px 35px rgba(15,23,42,0.05);
            }
            .org-role {
                font-size: 0.75rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                color: var(--accent-amber);
                margin-bottom: 0.25rem;
            }
            .org-name {
                font-size: 0.9rem;
                font-weight: 600;
                color: #0f172a;
                margin-bottom: 0.25rem;
            }
            .org-note {
                font-size: 0.78rem;
                color: var(--text-muted);
            }

            .services-section {
                background: linear-gradient(135deg, #eff6ff 0%, #e0f2fe 50%, #ecfeff 100%);
            }
            .services-layout {
                display: grid;
                grid-template-columns: minmax(0, 0.95fr) minmax(0, 1.05fr);
                gap: 3rem;
                align-items: flex-start;
            }
            .services-intro {
                font-size: 0.95rem;
                color: var(--text-muted);
                line-height: 1.8;
            }
            .services-highlight {
                margin-top: 1.5rem;
                padding: 1rem 1.1rem;
                border-radius: var(--radius-md);
                background: rgba(15,23,42,0.85);
                color: rgba(249,250,251,0.9);
                font-size: 0.87rem;
                line-height: 1.7;
            }
            .services-highlight strong {
                color: white;
            }
            .services-flow {
                position: relative;
                padding: 1.5rem 1.5rem 1.7rem;
                border-radius: var(--radius-lg);
                background: rgba(255,255,255,0.9);
                box-shadow: var(--shadow-card);
                border: 1px solid #dbeafe;
            }
            .services-flow::before {
                content: '';
                position: absolute;
                left: 24px;
                top: 26px;
                bottom: 26px;
                width: 2px;
                background: linear-gradient(180deg, var(--primary), var(--accent));
                opacity: 0.3;
            }
            .services-step {
                position: relative;
                padding-left: 3rem;
                padding-bottom: 1.5rem;
                margin-bottom: 0.5rem;
            }
            .services-step:last-child {
                padding-bottom: 0;
            }
            .services-step-indicator {
                position: absolute;
                left: 0;
                top: 0.1rem;
                width: 32px;
                height: 32px;
                border-radius: 999px;
                background: linear-gradient(135deg, var(--primary), var(--accent));
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.9rem;
                font-weight: 700;
                color: white;
                box-shadow: 0 4px 16px rgba(59,130,246,0.45);
            }
            .services-step-title {
                font-size: 0.95rem;
                font-weight: 700;
                color: #0f172a;
                margin-bottom: 0.25rem;
            }
            .services-step-tag {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                font-size: 0.75rem;
                padding: 0.15rem 0.65rem;
                border-radius: 999px;
                background: rgba(59,130,246,0.06);
                color: var(--primary-dark);
                margin-bottom: 0.25rem;
            }
            .services-step-desc {
                font-size: 0.85rem;
                color: var(--text-muted);
                line-height: 1.6;
            }
            .services-step-desc strong {
                color: #0f172a;
                font-weight: 600;
            }

            .programs-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-top: 3rem; }
            .program-card { background: linear-gradient(180deg, #ffffff 0%, #fafbfc 100%); border-radius: var(--radius-md); overflow: hidden; border: 1px solid #e2e8f0; transition: transform var(--anim-duration) var(--anim-ease), box-shadow var(--anim-duration) var(--anim-ease), border-color var(--anim-duration) var(--anim-ease); }
            .program-card:hover { transform: translateY(-8px); box-shadow: 0 24px 56px rgba(59,130,246,0.18); border-color: #bfdbfe; }
            .program-img { height: 180px; display: flex; align-items: center; justify-content: center; font-size: 4rem; }
            .program-body { padding: 1.5rem; }
            .program-category { font-size: 0.75rem; font-weight: 600; color: var(--accent); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; }
            .program-title { font-size: 1rem; font-weight: 700; color: #0f0f2d; margin-bottom: 0.5rem; line-height: 1.4; }
            .program-desc { font-size: 0.85rem; color: #6a6a8a; line-height: 1.6; margin-bottom: 1.25rem; }
            .program-progress { margin-bottom: 1rem; }
            .prog-numbers { display: flex; justify-content: space-between; font-size: 0.8rem; margin-bottom: 6px; }
            .prog-raised { font-weight: 700; color: #0f0f2d; }
            .prog-target { color: #8a8aaa; }
            .program-footer { display: flex; align-items: center; justify-content: space-between; }
            .prog-days { font-size: 0.8rem; color: #8a8aaa; }
            .prog-days strong { color: #f59e0b; }
            .btn-prog { padding: 0.45rem 1.1rem; background: linear-gradient(135deg, var(--primary), var(--accent)); border-radius: 8px; color: white; font-size: 0.82rem; font-weight: 600; transition: opacity var(--anim-duration) var(--anim-ease); }
            .btn-prog:hover { opacity: 0.85; }
            .steps-section { background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 50%, #e0f2fe 100%); }
            .steps-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-top: 3rem; position: relative; }
            .steps-grid::before { content: ''; position: absolute; top: 28px; left: 12.5%; right: 12.5%; height: 2px; background: linear-gradient(90deg, var(--primary), var(--accent)); z-index: 0; }
            .step-card { text-align: center; position: relative; z-index: 1; }
            .step-num { width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--accent)); color: white; font-size: 1.25rem; font-weight: 700; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; box-shadow: 0 4px 16px rgba(59,130,246,0.35); }
            .step-title { font-size: 0.95rem; font-weight: 700; color: #0f0f2d; margin-bottom: 0.5rem; }
            .step-desc { font-size: 0.82rem; color: #6a6a8a; line-height: 1.5; }
            .testi-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-top: 3rem; }
            .testi-card { background: white; border-radius: var(--radius-md); padding: 1.75rem; border: 1px solid #e2e8f0; transition: box-shadow var(--anim-duration) var(--anim-ease); }
            .testi-card:hover { box-shadow: 0 12px 40px rgba(59,130,246,0.12); }
            .testi-stars { color: #f59e0b; font-size: 0.9rem; margin-bottom: 0.75rem; }
            .testi-text { font-size: 0.9rem; color: #4a4a6a; line-height: 1.7; font-style: italic; margin-bottom: 1.25rem; }
            .testi-author { display: flex; align-items: center; gap: 0.75rem; }
            .testi-avatar { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1rem; font-weight: 700; color: white; flex-shrink: 0; }
            .testi-name { font-size: 0.875rem; font-weight: 600; color: #0f0f2d; }
            .testi-role { font-size: 0.75rem; color: #8a8aaa; }
            .donate-cta { background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 40%, #1e1b4b 100%); background-size: 200% 200%; animation: gradientShift 18s ease infinite; color: white; text-align: center; padding: 6rem 1.5rem; position: relative; overflow: hidden; }
            .donate-cta::before { content: ''; position: absolute; top: -100px; left: 50%; transform: translateX(-50%); width: 600px; height: 600px; background: radial-gradient(circle, rgba(59,130,246,0.25) 0%, transparent 65%); border-radius: 50%; }
            .donate-cta::after { content: ''; position: absolute; bottom: -80px; right: 10%; width: 300px; height: 300px; background: radial-gradient(circle, rgba(14,165,233,0.15) 0%, transparent 70%); border-radius: 50%; }
            .donate-cta-inner { position: relative; z-index: 1; max-width: 600px; margin: 0 auto; }
            .donate-cta h2 { font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem; line-height: 1.2; }
            .donate-cta p { font-size: 1rem; color: rgba(255,255,255,0.7); margin-bottom: 2.5rem; line-height: 1.7; }
            .cta-buttons { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
            .btn-cta-white { padding: 0.9rem 2rem; background: linear-gradient(145deg, #ffffff, #f8fafc); border-radius: 14px; color: var(--primary-dark); font-size: 1rem; font-weight: 700; transition: transform var(--anim-duration) var(--anim-ease), box-shadow var(--anim-duration) var(--anim-ease); box-shadow: 0 4px 20px rgba(0,0,0,0.2); }
            .btn-cta-white:hover { transform: translateY(-3px) scale(1.02); box-shadow: 0 8px 28px rgba(0,0,0,0.25); }
            .btn-cta-outline { padding: 0.9rem 2rem; border: 2px solid rgba(255,255,255,0.3); border-radius: 12px; color: white; font-size: 1rem; font-weight: 600; transition: all var(--anim-duration) var(--anim-ease); }
            .btn-cta-outline:hover { border-color: white; }
            .footer {
                background: linear-gradient(180deg, #0f172a 0%, #020617 50%, #030712 100%);
                background-size: 220% 220%;
                animation: gradientShift 18s ease infinite;
                color: rgba(255,255,255,0.7);
                padding: 4.5rem 1.5rem 2.25rem;
                position: relative;
                overflow: hidden;
            }
            .footer.footer-simple {
                background: rgba(15,23,42,0.4);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border-top: 1px solid rgba(255,255,255,0.08);
                padding: 1.25rem 1.5rem;
            }
            .footer-simple-inner {
                max-width: 1200px;
                margin: 0 auto;
                text-align: center;
                font-size: 0.875rem;
                color: rgba(255,255,255,0.8);
            }
            .footer-grid {
                max-width: 1200px;
                margin: 0 auto;
                display: grid;
                grid-template-columns: 2.1fr 1.1fr 1.1fr 1.1fr;
                gap: 3rem;
                margin-bottom: 3rem;
            }
            .footer-grid-simple { grid-template-columns: 2fr 1.5fr 1.5fr; }
            .footer-logo { display: flex; align-items: center; gap: 10px; font-size: 1.2rem; font-weight: 700; color: white; margin-bottom: 1rem; }
            .footer-logo-icon { width: 38px; height: 38px; background: linear-gradient(135deg, var(--primary), var(--accent)); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1rem; }
            .footer-desc { font-size: 0.875rem; line-height: 1.7; max-width: 260px; margin-bottom: 1.5rem; }
            .footer-socials { display: flex; gap: 0.75rem; }
            .social-btn { width: 36px; height: 36px; border-radius: 10px; background: rgba(255,255,255,0.08); display: flex; align-items: center; justify-content: center; font-size: 0.9rem; transition: background var(--anim-duration) var(--anim-ease); }
            .social-btn:hover { background: rgba(59,130,246,0.5); }
            .footer-col-title { font-size: 0.9rem; font-weight: 600; color: white; margin-bottom: 1.25rem; }
            .footer-links { display: flex; flex-direction: column; gap: 0.75rem; }
            .footer-links a, .footer-links span { font-size: 0.85rem; transition: color var(--anim-duration) var(--anim-ease); }
            .footer-links span { color: inherit; }
            .footer-links a:hover { color: white; }
            .footer-marquee {
                margin: 2rem auto 0;
                max-width: 1200px;
                overflow: hidden;
                position: relative;
                padding: 0.75rem 0;
            }
            .footer-marquee::before,
            .footer-marquee::after {
                content: '';
                position: absolute;
                top: 0;
                bottom: 0;
                width: 80px;
                pointer-events: none;
                z-index: 1;
            }
            .footer-marquee::before {
                left: 0;
                background: linear-gradient(to right, rgba(15,23,42,1), rgba(15,23,42,0));
            }
            .footer-marquee::after {
                right: 0;
                background: linear-gradient(to left, rgba(15,23,42,1), rgba(15,23,42,0));
            }
            .footer-marquee-track {
                display: flex;
                align-items: center;
                gap: 1rem;
                animation: footerMarqueeSlide 35s linear infinite;
            }
            .footer-marquee-item {
                width: 120px;
                height: 70px;
                border-radius: 16px;
                overflow: hidden;
                background-size: cover;
                background-position: center;
                box-shadow: 0 8px 20px rgba(0,0,0,0.35);
                border: 1px solid rgba(148,163,184,0.6);
                flex-shrink: 0;
            }
            .footer-marquee-item--gradient {
                background-image: linear-gradient(135deg, #22c55e, #0ea5e9);
            }
            .footer-bottom { max-width: 1200px; margin: 2rem auto 0; padding-top: 2rem; border-top: 1px solid rgba(148,163,184,0.35); display: flex; justify-content: space-between; align-items: center; font-size: 0.8rem; }
            .nav-mobile-toggle {
                display: none;
                width: 42px; height: 42px;
                background: linear-gradient(135deg, var(--primary), var(--accent));
                border: none; border-radius: 10px;
                color: white; font-size: 1.2rem;
                cursor: pointer;
                align-items: center; justify-content: center;
            }
            .nav-mobile-menu {
                display: none;
                position: absolute;
                top: 100%; left: 0; right: 0;
                background: rgba(15, 23, 42, 0.92);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(16px);
                border-bottom: 1px solid rgba(255,255,255,0.08);
                padding: 1rem;
                flex-direction: column;
                gap: 0.5rem;
                box-shadow: none;
                z-index: 99;
            }
            .nav-mobile-menu.open { display: flex; }
            .nav-mobile-menu a {
                padding: 0.75rem 1rem;
                border-radius: 10px;
                font-weight: 500;
                color: #ffffff !important;
                -webkit-text-fill-color: #ffffff !important;
            }
            .nav-mobile-menu a:hover { background: rgba(255,255,255,0.08); }

            .gallery-section {
                background: radial-gradient(circle at top, rgba(59,130,246,0.12), transparent 60%), #f9fafb;
            }
            .gallery-filters {
                display: flex;
                flex-wrap: wrap;
                gap: 0.5rem;
                margin-top: 1.75rem;
                margin-bottom: 1.5rem;
            }
            .gallery-pill {
                padding: 0.45rem 1rem;
                border-radius: 999px;
                font-size: 0.85rem;
                font-weight: 600;
                background: rgba(148,163,184,0.14);
                color: #0f172a;
                border: 1px solid rgba(148,163,184,0.5);
                cursor: pointer;
                transition: background var(--anim-duration) var(--anim-ease), color var(--anim-duration) var(--anim-ease), box-shadow var(--anim-duration) var(--anim-ease), transform var(--anim-duration) var(--anim-ease), border-color var(--anim-duration) var(--anim-ease);
            }
            .gallery-pill:hover {
                background: rgba(59,130,246,0.08);
                border-color: rgba(59,130,246,0.7);
                box-shadow: 0 4px 10px rgba(15,23,42,0.08);
                transform: translateY(-1px);
            }
            .gallery-pill.is-active {
                background: linear-gradient(135deg, var(--primary), var(--accent));
                color: #ffffff;
                border-color: transparent;
                box-shadow: 0 8px 18px rgba(37,99,235,0.4);
            }
            .gallery-grid {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 1.5rem;
                margin-top: 1.75rem;
            }
            .gallery-item {
                position: relative;
                border-radius: 16px;
                overflow: hidden;
                background: linear-gradient(135deg, #e0f2fe, #dbeafe);
                box-shadow: 0 14px 38px rgba(15,23,42,0.12);
                min-height: 200px;
                height: 200px;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: transform var(--anim-duration) var(--anim-ease), box-shadow var(--anim-duration) var(--anim-ease);
            }
            .gallery-item:hover {
                transform: translateY(-4px) scale(1.02);
                box-shadow: 0 20px 55px rgba(15,23,42,0.16);
            }
            .gallery-thumb {
                position: absolute;
                inset: 0;
                background-size: cover;
                background-position: center;
                filter: saturate(1.05);
                transition: transform var(--anim-duration) var(--anim-ease), filter var(--anim-duration) var(--anim-ease);
            }
            .gallery-item:hover .gallery-thumb {
                transform: scale(1.03);
                filter: saturate(1.18);
            }
            .gallery-overlay {
                position: absolute;
                left: 0;
                right: 0;
                bottom: 0;
                padding: 1rem 1.1rem;
                background: linear-gradient(to top, rgba(15,23,42,0.9), rgba(15,23,42,0.0));
                color: #f9fafb;
                font-size: 0.9rem;
                line-height: 1.5;
            }

            .faq-section {
                background: #f9fafb;
            }
            .faq-grid {
                display: grid;
                grid-template-columns: minmax(0, 1.1fr) minmax(0, 1.1fr);
                gap: 3rem;
                align-items: flex-start;
            }
            .faq-intro {
                font-size: 0.95rem;
                color: var(--text-muted);
                line-height: 1.8;
            }
            .faq-list {
                border-radius: var(--radius-lg);
                background: white;
                box-shadow: var(--shadow-soft);
                border: 1px solid #e2e8f0;
                padding: 0.75rem 1.25rem;
            }
            .faq-item {
                border-bottom: 1px solid #e5e7eb;
            }
            .faq-item:last-child {
                border-bottom: none;
            }
            .faq-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 1rem;
                padding: 0.75rem 0;
                cursor: pointer;
            }
            .faq-question {
                font-size: 0.92rem;
                font-weight: 600;
                color: #0f172a;
            }
            .faq-toggle {
                width: 26px;
                height: 26px;
                border-radius: 999px;
                border: 1px solid #cbd5f5;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1rem;
                color: var(--primary-dark);
                flex-shrink: 0;
            }
            .faq-body {
                max-height: 0;
                overflow: hidden;
                transition: max-height var(--anim-duration) var(--anim-ease);
            }
            .faq-body-inner {
                padding-bottom: 0.9rem;
                font-size: 0.88rem;
                color: var(--text-muted);
                line-height: 1.7;
            }
            .faq-item.open .faq-body {
                max-height: 200px;
            }
            .faq-item.open .faq-toggle {
                background: linear-gradient(135deg, var(--primary), var(--accent));
                color: white;
                border-color: transparent;
            }

            .partners-section {
                background: linear-gradient(135deg, #0f172a 0%, #020617 100%);
                color: white;
            }
            .partners-header {
                display: flex;
                justify-content: space-between;
                align-items: flex-end;
                gap: 2rem;
            }
            .partners-note {
                font-size: 0.85rem;
                color: rgba(226,232,240,0.8);
                max-width: 360px;
            }
            .partners-grid {
                margin-top: 2.25rem;
                display: grid;
                grid-template-columns: repeat(5, minmax(0, 1fr));
                gap: 1.1rem;
            }
            .partner-card {
                border-radius: var(--radius-md);
                border: 1px solid rgba(148,163,184,0.5);
                background: radial-gradient(circle at top, rgba(148,163,184,0.35), rgba(15,23,42,0.95));
                min-height: 90px;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 0.75rem;
                text-align: center;
                font-size: 0.85rem;
                font-weight: 600;
                color: #e5e7eb;
            }
            .partner-tag {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                font-size: 0.7rem;
                padding: 0.25rem 0.7rem;
                border-radius: 999px;
                background: rgba(15,23,42,0.8);
                color: #e5e7eb;
                margin-top: 0.35rem;
            }

            @media (max-width: 900px) {
                .contribute-grid { grid-template-columns: 1fr; }
                .contact-grid { grid-template-columns: 1fr; }
                .nav-links { display: none; }
                .nav-mobile-toggle { display: flex; }
                .hero-inner, .hero-pro .hero-inner { grid-template-columns: 1fr; padding: 3rem 1rem; }
                .hero-card-wrap { justify-content: center; }
                .hero-card { max-width: 100%; }
                .hero-visual { display: none; }
                .hero-title { font-size: 2.25rem; }
                .hero-desc { font-size: 0.95rem; }
                .hero-cta { flex-direction: column; }
                .hero-cta a { width: 100%; text-align: center; justify-content: center; }
                .hero-stats { flex-wrap: wrap; gap: 1.5rem; justify-content: flex-start; }
                .hero-stat-number { font-size: 1.25rem; }
                .about-grid { grid-template-columns: 1fr; }
                .about-img-wrap { display: none; }
                .programs-grid { grid-template-columns: 1fr; }
                .impact-grid, .impact-bar .impact-grid { grid-template-columns: repeat(2, 1fr); gap: 1.5rem; }
                .impact-item:nth-child(2n) { border-right: none; }
                .impact-number, .impact-num { font-size: 1.75rem; }
                .about-cards { grid-template-columns: 1fr; }
                .donate-steps { grid-template-columns: repeat(2, 1fr); }
                .testi-cards { grid-template-columns: 1fr; }
                .steps-grid { grid-template-columns: repeat(2, 1fr); gap: 1rem; }
                .steps-grid::before { display: none; }
                .testi-grid { grid-template-columns: 1fr; }
                .footer-grid, .footer-grid-simple { grid-template-columns: 1fr 1fr; gap: 2rem; }
                .profile-grid { grid-template-columns: 1fr; gap: 2rem; }
                .contact-layout {
                    grid-template-columns: 1fr;
                    margin-top: -1.5rem;
                    padding: 1.75rem 1.1rem 2.25rem;
                }
                .contact-card-grid {
                    grid-template-columns: 1fr;
                }
                .form-row-grid {
                    grid-template-columns: 1fr;
                }
                .profile-subsections { grid-template-columns: 1fr; }
                .org-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
                .org-chart .org-level { flex-wrap: wrap; justify-content: center; gap: 1.5rem; }
                .services-layout { grid-template-columns: 1fr; }
                .services-flow { margin-top: 1.75rem; }
                .gallery-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
                .faq-grid { grid-template-columns: 1fr; }
                .partners-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
                .partners-header { flex-direction: column; align-items: flex-start; }
                .footer-bottom { flex-direction: column; gap: 0.75rem; text-align: center; }
                .footer-bottom > div:last-child { flex-direction: column; gap: 0.5rem; }
                .donate-cta { padding: 4rem 1rem; }
                .donate-cta h2 { font-size: 1.75rem; }
                .donate-cta p { font-size: 0.9rem; margin-bottom: 1.5rem; }
                .section { padding: 3rem 1rem; }
                .section-title { font-size: 1.75rem; }
            }
            @media (max-width: 600px) {
                .nav-inner { height: 64px; padding: 0 1rem; }
                .hero { padding-top: 64px; }
                .public-page > section:first-child { padding-top: 80px; }
                .hero-inner { padding: 2rem 1rem; }
                .hero-title { font-size: 1.6rem; }
                .hero-desc { font-size: 0.9rem; margin-bottom: 1.5rem; }
                .hero-stats { gap: 1rem; }
                .hero-stat-number { font-size: 1.1rem; }
                .hero-stat-label { font-size: 0.72rem; }
                .nav-actions .btn-primary { padding: 0.5rem 1rem; font-size: 0.85rem; }
                .impact-grid { grid-template-columns: 1fr; gap: 1.25rem; padding: 3rem 1rem; }
                .impact-number { font-size: 1.75rem; }
                .impact-label { font-size: 0.85rem; }
                .section-title { font-size: 1.5rem; }
                .steps-grid { grid-template-columns: 1fr; }
                .donate-cta h2 { font-size: 1.4rem; }
                .footer-grid, .footer-grid-simple { grid-template-columns: 1fr; text-align: center; }
                .footer-desc { margin: 0 auto 1rem; }
                .footer-socials { justify-content: center; }
                .footer-links { align-items: center; }
                .org-grid { grid-template-columns: 1fr; }
                .org-node { min-width: 160px; max-width: none; }
                .gallery-grid { grid-template-columns: repeat(1, minmax(0, 1fr)); }
                .partners-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            }
            @media (max-width: 400px) {
                .hero-title { font-size: 1.4rem; }
                .donate-cta h2 { font-size: 1.2rem; }
            }
        </style>
