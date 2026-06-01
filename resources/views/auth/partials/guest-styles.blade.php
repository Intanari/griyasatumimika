<style>
    :root { --primary: #3b82f6; --primary-dark: #2563eb; --accent: #0ea5e9; }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html {
        scroll-behavior: smooth;
        height: 100%;
        -webkit-text-size-adjust: 100%;
    }
    body {
        font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
        color: #0f172a;
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 50%, #e0f2fe 100%);
        min-height: 100vh;
        min-height: 100dvh;
        display: flex;
        flex-direction: column;
        overflow-x: hidden;
    }
    a { text-decoration: none; color: inherit; }

    .navbar {
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(12px);
        border-bottom: 1px solid #e8e8f0;
        padding: 0 1.5rem;
    }
    .nav-inner {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        min-height: 68px;
        height: auto;
        padding: 0.65rem 0;
    }
    .nav-logo {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: clamp(1rem, 4vw, 1.25rem);
        font-weight: 800;
        color: var(--primary-dark);
        min-width: 0;
    }
    .nav-logo-text {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .nav-logo-icon {
        width: 42px;
        height: 42px;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.1rem;
        box-shadow: 0 4px 14px rgba(59,130,246,0.35);
    }
    .nav-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: rgba(59,130,246,0.1);
        color: var(--primary-dark);
        font-size: clamp(0.65rem, 2.5vw, 0.75rem);
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 100px;
        border: 1px solid rgba(59,130,246,0.2);
        flex-shrink: 0;
        white-space: nowrap;
    }

    .main {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: clamp(1.25rem, 5vw, 3rem) clamp(1rem, 4vw, 1.5rem);
        position: relative;
        width: 100%;
    }
    .main-wrap {
        width: 100%;
        max-width: 440px;
        margin: 0 auto;
    }
    .main::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(59,130,246,0.08) 0%, transparent 70%);
        border-radius: 50%;
    }
    .main::after {
        content: '';
        position: absolute;
        bottom: -100px;
        left: -100px;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(14,165,233,0.06) 0%, transparent 70%);
        border-radius: 50%;
    }

    .login-card {
        background: white;
        border-radius: clamp(16px, 4vw, 20px);
        box-shadow: 0 4px 40px rgba(59,130,246,0.12);
        padding: clamp(1.5rem, 6vw, 3rem) clamp(1.25rem, 5vw, 2.5rem);
        width: 100%;
        position: relative;
        z-index: 1;
    }
    .card-header {
        text-align: center;
        margin-bottom: clamp(1.25rem, 5vw, 2rem);
    }
    .card-icon {
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.25rem;
        font-size: 1.75rem;
        box-shadow: 0 4px 20px rgba(59,130,246,0.35);
    }
    .card-title {
        font-size: clamp(1.35rem, 5vw, 1.75rem);
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 0.5rem;
        line-height: 1.25;
    }
    .card-subtitle {
        font-size: clamp(0.8rem, 3.2vw, 0.9rem);
        color: #6b7280;
        line-height: 1.55;
        max-width: 32ch;
        margin: 0 auto;
    }

    .alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 10px;
        padding: 0.875rem 1rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 0.625rem;
    }
    .alert-error-icon { font-size: 1rem; color: #ef4444; flex-shrink: 0; margin-top: 1px; }
    .alert-error-text { font-size: 0.875rem; color: #dc2626; line-height: 1.5; }
    .alert-success {
        background: #f0fdf4;
        border: 1px solid #86efac;
        border-radius: 10px;
        padding: 0.875rem 1rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 0.625rem;
    }
    .alert-success-icon { font-size: 1rem; color: #16a34a; flex-shrink: 0; margin-top: 1px; }
    .alert-success-text { font-size: 0.875rem; color: #15803d; line-height: 1.5; }

    .form-group { margin-bottom: 1.25rem; }
    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
    }
    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1.5px solid #e5e7eb;
        border-radius: 10px;
        font-size: 1rem;
        min-height: 48px;
        font-family: inherit;
        color: #1a1a2e;
        background: #f9fafb;
        transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        outline: none;
    }
    .form-input:focus {
        border-color: var(--primary-dark);
        background: white;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    }
    .form-input.is-invalid {
        border-color: #ef4444;
        background: #fef2f2;
    }
    .form-input.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(239,68,68,0.1);
    }
    .invalid-feedback {
        font-size: 0.8rem;
        color: #dc2626;
        margin-top: 0.375rem;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .form-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }
    .remember-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }
    .remember-checkbox {
        width: 16px;
        height: 16px;
        accent-color: var(--primary-dark);
        cursor: pointer;
    }
    .remember-label {
        font-size: 0.875rem;
        color: #4a4a6a;
        cursor: pointer;
        user-select: none;
    }
    .forgot-link, .back-link {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--primary-dark);
        transition: color 0.2s;
    }
    .forgot-link:hover, .back-link:hover { color: var(--accent); text-decoration: underline; }

    .btn-login {
        width: 100%;
        padding: 0.875rem;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        border: none;
        border-radius: 10px;
        color: white;
        font-size: 1rem;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        transition: opacity 0.2s, transform 0.1s;
        box-shadow: 0 4px 15px rgba(59,130,246,0.35);
        margin-bottom: 0;
        min-height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .btn-login:hover { opacity: 0.9; }
    .btn-login:active { transform: scale(0.98); }
    .btn-secondary {
        width: 100%;
        padding: 0.75rem;
        background: white;
        border: 1.5px solid #e5e7eb;
        border-radius: 10px;
        color: #374151;
        font-size: 0.9rem;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        transition: border-color 0.2s, background 0.2s;
        min-height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 0.75rem;
    }
    .btn-secondary:hover {
        border-color: var(--primary-dark);
        background: #f8fafc;
    }

    footer {
        text-align: center;
        padding: 1rem 1.25rem calc(1rem + env(safe-area-inset-bottom, 0px));
        font-size: clamp(0.72rem, 2.8vw, 0.8rem);
        color: #9ca3af;
        line-height: 1.5;
        max-width: 100%;
        padding-left: max(1.25rem, env(safe-area-inset-left, 0px));
        padding-right: max(1.25rem, env(safe-area-inset-right, 0px));
    }

    @media (max-width: 640px) {
        .navbar { padding: 0 0.875rem; }
        .nav-logo-icon {
            width: 36px;
            height: 36px;
            font-size: 1rem;
            border-radius: 10px;
        }
        .nav-logo { gap: 8px; }
        .card-subtitle { max-width: none; }
        .card-icon {
            width: 56px;
            height: 56px;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
    }

    @media (max-width: 380px) {
        .nav-badge span.badge-label { display: none; }
        .nav-badge::after { content: 'Petugas'; }
    }
</style>
