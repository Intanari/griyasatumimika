<script>
    (function() {
        var toggle = document.getElementById('navMobileToggle');
        var drawer = document.getElementById('navDrawer');
        var overlay = document.getElementById('navDrawerOverlay');
        var closeBtn = document.getElementById('navDrawerClose');
        var navbar = document.querySelector('.navbar');

        function openDrawer() {
            if (!drawer || !overlay || !toggle) return;
            drawer.classList.add('is-open');
            overlay.classList.add('is-open');
            toggle.classList.add('is-active');
            toggle.setAttribute('aria-expanded', 'true');
            toggle.setAttribute('aria-label', 'Tutup menu navigasi');
            drawer.setAttribute('aria-hidden', 'false');
            overlay.setAttribute('aria-hidden', 'false');
            document.body.classList.add('nav-drawer-open');
        }

        function closeDrawer() {
            if (!drawer || !overlay || !toggle) return;
            drawer.classList.remove('is-open');
            overlay.classList.remove('is-open');
            toggle.classList.remove('is-active');
            toggle.setAttribute('aria-expanded', 'false');
            toggle.setAttribute('aria-label', 'Buka menu navigasi');
            drawer.setAttribute('aria-hidden', 'true');
            overlay.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('nav-drawer-open');
        }

        if (toggle && drawer && overlay) {
            toggle.addEventListener('click', function() {
                if (drawer.classList.contains('is-open')) closeDrawer();
                else openDrawer();
            });
            if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
            overlay.addEventListener('click', closeDrawer);
            document.querySelectorAll('.mobile-nav-close').forEach(function(link) {
                link.addEventListener('click', closeDrawer);
            });
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && drawer.classList.contains('is-open')) closeDrawer();
            });
            window.addEventListener('resize', function() {
                if (window.innerWidth > 1024 && drawer.classList.contains('is-open')) closeDrawer();
            });
        }

        if (navbar) {
            var onScroll = function() {
                if (window.scrollY > 16) navbar.classList.add('scrolled');
                else navbar.classList.remove('scrolled');
            };
            window.addEventListener('scroll', onScroll);
            onScroll();
        }
        document.querySelectorAll('.faq-item').forEach(function(item) {
            var header = item.querySelector('.faq-header');
            var body = item.querySelector('.faq-body');
            if (!header || !body) return;
            header.addEventListener('click', function() {
                var isOpen = item.classList.contains('open');
                document.querySelectorAll('.faq-item.open').forEach(function(openItem) {
                    if (openItem !== item) {
                        openItem.classList.remove('open');
                        var openBody = openItem.querySelector('.faq-body');
                        if (openBody) openBody.style.maxHeight = null;
                    }
                });
                if (!isOpen) {
                    item.classList.add('open');
                    body.style.maxHeight = body.scrollHeight + 'px';
                } else {
                    item.classList.remove('open');
                    body.style.maxHeight = null;
                }
            });
        });
        function initScrollAnimations() {
            var animSelectors = '.animate-on-scroll[data-animate], .anim-fade-up, .anim-fade-down, .anim-fade-left, .anim-fade-right, .anim-scale, .anim-fade';
            var els = document.querySelectorAll(animSelectors);
            var hero = document.querySelector('.hero');
            if (hero) {
                hero.querySelectorAll(animSelectors).forEach(function(el, i) {
                    setTimeout(function() { el.classList.add('visible'); }, 120 * i);
                });
            }
            var io = typeof IntersectionObserver !== 'undefined' ? new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        entry.target.classList.remove('leaving');
                        entry.target.setAttribute('data-in-view', '1');
                    } else if (entry.target.getAttribute('data-in-view') === '1') {
                        entry.target.classList.remove('visible');
                        entry.target.classList.add('leaving');
                    }
                });
            }, { rootMargin: '0px 0px -60px 0px', threshold: 0.08 }) : null;
            if (io) {
                els.forEach(function(el) {
                    if (hero && el.closest('.hero')) return;
                    io.observe(el);
                });
            } else {
                els.forEach(function(el) { el.classList.add('visible'); });
            }
        }
        function initGalleryFilters() {
            var filterButtons = document.querySelectorAll('.gallery-pill');
            var items = document.querySelectorAll('.gallery-item[data-category]');
            if (!filterButtons.length || !items.length) return;

            filterButtons.forEach(function(btn) {
                btn.addEventListener('click', function () {
                    var target = btn.getAttribute('data-filter') || 'all';
                    filterButtons.forEach(function(el) { el.classList.remove('is-active'); });
                    btn.classList.add('is-active');

                    items.forEach(function(card) {
                        var cat = card.getAttribute('data-category');
                        if (target === 'all' || cat === target) {
                            card.style.display = '';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
        }

        function initGalleryLightbox() {
            var links = Array.prototype.slice.call(document.querySelectorAll('.gallery-thumb-link'));
            var lightbox = document.getElementById('galleryLightbox');
            if (!links.length || !lightbox) return;

            var imageEl = lightbox.querySelector('.gallery-lightbox-image');
            var closeBtn = lightbox.querySelector('.gallery-lightbox-close');
            var prevBtn = lightbox.querySelector('.gallery-lightbox-prev');
            var nextBtn = lightbox.querySelector('.gallery-lightbox-next');
            var currentIndex = 0;
            var isOpen = false;

            function showAt(index) {
                if (!imageEl) return;
                if (index < 0) index = links.length - 1;
                if (index >= links.length) index = 0;
                currentIndex = index;
                var link = links[currentIndex];
                imageEl.src = link.getAttribute('href');
                var nameEl = lightbox.querySelector('.gallery-lightbox-caption-name');
                var descEl = lightbox.querySelector('.gallery-lightbox-caption-desc');
                if (nameEl) nameEl.textContent = link.getAttribute('data-patient-name') || '';
                if (descEl) descEl.textContent = link.getAttribute('data-description') || '';
                lightbox.classList.add('open');
                lightbox.setAttribute('aria-hidden', 'false');
                document.body.classList.add('gallery-lightbox-open');
                isOpen = true;
            }

            function hideLightbox() {
                lightbox.classList.remove('open');
                lightbox.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('gallery-lightbox-open');
                isOpen = false;
            }

            links.forEach(function(link, idx) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    showAt(idx);
                });
            });

            if (closeBtn) {
                closeBtn.addEventListener('click', hideLightbox);
            }

            if (prevBtn) {
                prevBtn.addEventListener('click', function() {
                    showAt(currentIndex - 1);
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', function() {
                    showAt(currentIndex + 1);
                });
            }

            lightbox.addEventListener('click', function(e) {
                var keepOpen = e.target.closest('.gallery-lightbox-image') ||
                    e.target.closest('.gallery-lightbox-prev') ||
                    e.target.closest('.gallery-lightbox-next');
                if (!keepOpen) hideLightbox();
            });

            document.addEventListener('keydown', function(e) {
                if (!isOpen) return;
                if (e.key === 'Escape') hideLightbox();
                if (e.key === 'ArrowRight') showAt(currentIndex + 1);
                if (e.key === 'ArrowLeft') showAt(currentIndex - 1);
            });
        }

        var pasienSelect = document.getElementById('nav-pasien-select');
        if (pasienSelect) {
            pasienSelect.addEventListener('change', function() {
                var url = this.value;
                if (url) window.location.href = url;
            });
        }

        function onReady() {
            initScrollAnimations();
            initGalleryFilters();
            initGalleryLightbox();
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', onReady);
        } else {
            onReady();
        }
    })();
</script>
