<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Wheelo – Rent, List & Ride Any Vehicle')</title>
    <meta name="description" content="@yield('meta_description', 'India\'s complete vehicle rental marketplace. Rent cars, bikes, scooters, EVs, e-rickshaws and commercial vehicles, or list your own.')">
    <meta name="theme-color" content="#051A13">
    <link rel="icon" href="{{ asset('images/favicon.png') }}">

    {{-- JS on hai to animations enable (JS band ho to sab content seedha dikhe) --}}
    <script>document.documentElement.classList.add('js');</script>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    {{-- CSS (ek hi file) --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ @filemtime(public_path('css/style.css')) }}">
</head>
<body>

    @include('frontlayout.header')

    <main id="main">
        @yield('content')
    </main>

    @include('frontlayout.footer')

    {{-- Icons --}}

    <script>
        /* =========================================================
   Wheelo – main.js
   ========================================================= */
document.addEventListener('DOMContentLoaded', function () {

    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ---------- 1. Icons ---------- */
    if (window.lucide) lucide.createIcons();

    /* ---------- 2. Header: scroll state ---------- */
    var header = document.getElementById('siteHeader');
    var toTop  = document.getElementById('toTop');

    function onScroll() {
        var y = window.scrollY;
        if (header) header.classList.toggle('is-scrolled', y > 12);
        if (toTop)  toTop.classList.toggle('is-visible', y > 600);
    }
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });

    /* ---------- 3. Mobile drawer (left se) ---------- */
    var toggle   = document.getElementById('navToggle');
    var drawer   = document.getElementById('mobileDrawer');
    var overlay  = document.getElementById('drawerOverlay');
    var closeBtn = document.getElementById('drawerClose');

    function focusables() {
        return drawer.querySelectorAll('a[href], button:not([disabled])');
    }

    function setDrawer(open) {
        if (!drawer) return;
        drawer.classList.toggle('is-open', open);
        overlay.classList.toggle('is-open', open);
        document.body.classList.toggle('drawer-open', open);
        toggle.classList.toggle('is-open', open);
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        drawer.setAttribute('aria-hidden', open ? 'false' : 'true');

        if (open) {
            drawer.removeAttribute('inert');
            setTimeout(function () { closeBtn && closeBtn.focus(); }, 120);
        } else {
            drawer.setAttribute('inert', '');
            if (drawer.contains(document.activeElement)) toggle.focus();
        }
    }

    if (toggle && drawer) {
        toggle.addEventListener('click', function () { setDrawer(!drawer.classList.contains('is-open')); });
        closeBtn && closeBtn.addEventListener('click', function () { setDrawer(false); });
        overlay.addEventListener('click', function () { setDrawer(false); });
        drawer.querySelectorAll('a[href]').forEach(function (a) {
            a.addEventListener('click', function () { setDrawer(false); });
        });

        document.addEventListener('keydown', function (e) {
            if (!drawer.classList.contains('is-open')) return;
            if (e.key === 'Escape') { setDrawer(false); return; }

            // Tab ko drawer ke andar hi ghumao
            if (e.key === 'Tab') {
                var items = focusables();
                if (!items.length) return;
                var first = items[0], last = items[items.length - 1];
                if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
                else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
            }
        });

        // Swipe left karke band karo (mobile)
        var startX = null;
        drawer.addEventListener('touchstart', function (e) { startX = e.touches[0].clientX; }, { passive: true });
        drawer.addEventListener('touchend', function (e) {
            if (startX === null) return;
            if (startX - e.changedTouches[0].clientX > 60) setDrawer(false);
            startX = null;
        }, { passive: true });

        window.addEventListener('resize', function () {
            if (window.innerWidth >= 1200 && drawer.classList.contains('is-open')) setDrawer(false);
        });
    }

    /* ---------- 4. Back to top ---------- */
    if (toTop) {
        toTop.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: reduceMotion ? 'auto' : 'smooth' });
        });
    }

    /* ---------- 5. Hero category preview ---------- */
    var preview = document.getElementById('categoryPreview');
    if (preview) {
        var categories = [];
        try { categories = JSON.parse(preview.dataset.categories || '[]'); } catch (e) {}

        var body = document.getElementById('previewBody');
        var tabs = preview.querySelectorAll('.preview-tab');
        var link = preview.querySelector('[data-preview-link]');
        var baseUrl = link ? link.getAttribute('href').split('?')[0] : '';

        function set(key, value) {
            var el = preview.querySelector('[data-preview="' + key + '"]');
            if (el) el.textContent = value;
        }

        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                var cat = categories[tab.dataset.index];
                if (!cat) return;

                tabs.forEach(function (t) {
                    t.classList.remove('is-active');
                    t.setAttribute('aria-selected', 'false');
                });
                tab.classList.add('is-active');
                tab.setAttribute('aria-selected', 'true');

                set('name', cat.name);
                set('desc', cat.desc);
                set('price', cat.price);
                set('spec', cat.spec);
                set('spec_label', cat.spec_label);
                set('count', cat.count);

                var iconBox = preview.querySelector('[data-preview="icon"]');
                var tabIcon = tab.querySelector('svg');
                if (iconBox && tabIcon) iconBox.innerHTML = tabIcon.outerHTML;
                if (link) link.setAttribute('href', baseUrl + '?category=' + cat.key);

                // swap animation
                if (body && !reduceMotion) {
                    body.classList.remove('is-swap');
                    void body.offsetWidth;
                    body.classList.add('is-swap');
                }
            });
        });
    }

    /* ---------- 6. Counters ---------- */
    function runCounter(el) {
        var target   = parseFloat(el.dataset.count);
        var decimals = parseInt(el.dataset.decimals || '0', 10);
        var suffix   = el.dataset.suffix || '';
        if (isNaN(target)) return;

        if (reduceMotion) return;

        var start = null, duration = 1400;
        function frame(ts) {
            if (!start) start = ts;
            var p = Math.min((ts - start) / duration, 1);
            var eased = 1 - Math.pow(1 - p, 3);
            var val = target * eased;
            el.textContent = (decimals ? val.toFixed(decimals) : Math.round(val).toLocaleString('en-IN')) + suffix;
            if (p < 1) requestAnimationFrame(frame);
        }
        requestAnimationFrame(frame);
    }

    /* ---------- 7. Reveal on scroll ---------- */
    var revealEls = document.querySelectorAll('[data-reveal]');
    var counters  = document.querySelectorAll('[data-count]');

    if ('IntersectionObserver' in window && !reduceMotion) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-in');
                entry.target.querySelectorAll('[data-count]').forEach(function (c) {
                    if (!c.dataset.done) { c.dataset.done = '1'; runCounter(c); }
                });
                io.unobserve(entry.target);
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

        revealEls.forEach(function (el) { io.observe(el); });
    } else {
        revealEls.forEach(function (el) { el.classList.add('is-in'); });
    }

    /* ---------- 8. Card spotlight (mouse glow) ---------- */
    if (!reduceMotion && window.matchMedia('(hover: hover)').matches) {
        document.querySelectorAll('.cat-card, .feature-card, .vehicle-card, .commit-card').forEach(function (card) {
            card.addEventListener('pointermove', function (e) {
                var r = card.getBoundingClientRect();
                card.style.setProperty('--mx', (e.clientX - r.left) + 'px');
                card.style.setProperty('--my', (e.clientY - r.top) + 'px');
            });
        });
    }
});
    </script>
    <script src="https://unpkg.com/lucide@0.460.0/dist/umd/lucide.min.js"></script>
    {{-- JS --}}
    <script src="{{ asset('js/main.js') }}?v={{ @filemtime(public_path('js/main.js')) }}"></script>
</body>
</html>