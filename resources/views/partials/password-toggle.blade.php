<style>
    .password-input-wrap {
        position: relative;
        display: block;
        width: 100%;
    }
    .password-input-wrap > input[type="password"],
    .password-input-wrap > input[type="text"].password-input-field {
        width: 100%;
        padding-right: 2.75rem;
    }
    .password-toggle-btn {
        position: absolute;
        right: 0.5rem;
        top: 50%;
        transform: translateY(-50%);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2rem;
        height: 2rem;
        padding: 0;
        border: none;
        background: transparent;
        color: #64748b;
        cursor: pointer;
        border-radius: 6px;
        transition: color 0.15s, background 0.15s;
    }
    .password-toggle-btn:hover {
        color: #2563eb;
        background: rgba(37, 99, 235, 0.08);
    }
    .password-toggle-btn:focus-visible {
        outline: 2px solid #2563eb;
        outline-offset: 2px;
    }
    .password-toggle-btn svg {
        width: 1.15rem;
        height: 1.15rem;
        pointer-events: none;
    }
</style>
<script>
(function () {
    var iconShow = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>';
    var iconHide = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>';

    function enhancePasswordInput(input) {
        if (!input || input.closest('.password-input-wrap')) {
            return;
        }

        var wrap = document.createElement('div');
        wrap.className = 'password-input-wrap';

        input.classList.add('password-input-field');
        input.parentNode.insertBefore(wrap, input);
        wrap.appendChild(input);

        var btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'password-toggle-btn';
        btn.setAttribute('aria-label', 'Tampilkan kata sandi');
        btn.innerHTML = iconShow;

        btn.addEventListener('click', function () {
            var isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            btn.innerHTML = isHidden ? iconHide : iconShow;
            btn.setAttribute('aria-label', isHidden ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
        });

        wrap.appendChild(btn);
    }

    function initPasswordToggles(root) {
        (root || document).querySelectorAll('input[type="password"]').forEach(enhancePasswordInput);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () { initPasswordToggles(); });
    } else {
        initPasswordToggles();
    }

    window.initPasswordToggles = initPasswordToggles;
})();
</script>
