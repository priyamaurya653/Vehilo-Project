<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Dashboard'))</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --ink: #051a13;
            --ink-raised: #0d2b21;
            --ink-line: rgba(255,255,255,.08);
            --ink-text: #b4c9be;
            --ink-text-dim: #6f8a7d;

            --paper: #f0f7f3;
            --surface: #ffffff;
            --line: #dcebe2;
            --text: #051a13;
            --muted: #6b8177;

            --accent: #c8f542;
            --accent-deep: #0f4a35;
            --accent-tint: #f1fbc9;

            --good: #1f7a4d;
            --good-tint: #dff5e8;
            --warn: #9a6b00;
            --warn-tint: #fbf0cf;
            --bad: #b3392f;
            --bad-tint: #fbe4e0;

            --sidebar-w: 268px;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        [hidden] { display: none !important; }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--paper);
            color: var(--text);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3 { letter-spacing: -.02em; }

        /* Role check hone tak page chhupa rahe (galat role ko content na dikhe) */
        .app { display: flex; min-height: 100vh; visibility: hidden; }
        body.auth-ok .app { visibility: visible; }

        /* ---------- Sidebar ---------- */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--ink);
            color: var(--ink-text);
            display: flex;
            flex-direction: column;
            position: fixed;
            inset: 0 auto 0 0;
            height: 100vh;
            height: 100dvh;              /* mobile browser bar ke saath sahi height */
            overflow: hidden;
            z-index: 50;
            transition: transform .25s ease;
            border-right: 1px solid var(--ink-line);
        }

        .sidebar-brand {
            display: flex; align-items: center; gap: 12px;
               padding: 23px 75px 20px;
            border-bottom: 1px solid var(--ink-line);
        }
        .brand-logo {
            height: 46px; border-radius: 10px;
               background: #dcdcdc;
            display: grid; place-items: center; flex-shrink: 0;
        }
        .brand-logo svg { width: 22px; height: 22px; fill: none; stroke: var(--ink); stroke-width: 2; }
        .brand-logo .dot { fill: var(--ink); stroke: none; }
        .brand-mark { font-size: 1.3rem; font-weight: 800; color: #fff; letter-spacing: -.02em; }

        /* Sirf menu wala hissa scroll hoga, brand + footer apni jagah fixed */
        .sidebar-nav {
            flex: 1 1 auto;
            min-height: 0;
            padding: 18px 10px 18px 14px;
            overflow-y: auto;
            overflow-x: hidden;
            overscroll-behavior: contain;          /* sidebar scroll page ko na hilaye */
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;                 /* Firefox */
            scrollbar-color: rgba(255,255,255,.22) transparent;
        }
        /* Chrome / Edge / Safari scrollbar (dark sidebar par dikhne wala) */
        .sidebar-nav::-webkit-scrollbar { width: 6px; }
        .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,.18); border-radius: 999px; }
        .sidebar-nav::-webkit-scrollbar-thumb:hover { background: rgba(200,245,66,.55); }

        .sidebar-brand, .sidebar-footer { flex-shrink: 0; }

        .nav-group-label {
            font-size: .72rem; font-weight: 600;
            color: var(--ink-text-dim);
            padding: 16px 12px 6px;
        }
        .role-menu > .nav-group-label:first-child { padding-top: 0; }

        .nav-item + .nav-item { margin-top: 4px; }

        .nav-link {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 12px;
            border-radius: 10px;
            color: var(--ink-text);
            text-decoration: none;
            font-size: .89rem; font-weight: 500;
            border-left: 2px solid transparent;
        }
        .nav-link svg {
            width: 18px; height: 18px;
            fill: none; stroke: currentColor;
            stroke-width: 1.7; stroke-linecap: round; stroke-linejoin: round;
            flex-shrink: 0; opacity: .85;
        }
        .nav-link:hover { background: var(--ink-raised); color: #fff; }
        .nav-link.active { background: var(--ink-raised); color: #fff; border-left-color: var(--accent); }
        .nav-link.active svg { opacity: 1; color: var(--accent); }

        button.nav-link {
            width: 100%;
            background: transparent;
            border: 0; border-left: 2px solid transparent;
            font-family: inherit; text-align: left; cursor: pointer;
        }
        button.nav-link:hover { background: var(--ink-raised); }
        button.nav-link.active { background: var(--ink-raised); border-left-color: var(--accent); }

        .nav-link .chev { width: 14px; height: 14px; margin-left: auto; opacity: .6; transition: transform .25s ease; }
        .has-sub.open > .nav-toggle .chev { transform: rotate(180deg); }

        .submenu { display: grid; grid-template-rows: 0fr; transition: grid-template-rows .28s ease; }
        .has-sub.open > .submenu { grid-template-rows: 1fr; }

        .submenu-inner {
            min-height: 0; overflow: hidden;
            visibility: hidden;
            margin-left: 21px;
            border-left: 1px solid var(--ink-line);
            transition: visibility 0s linear .28s;
        }
        .has-sub.open > .submenu > .submenu-inner { visibility: visible; transition-delay: 0s; }

        .sub-link {
            position: relative; display: block;
            padding: 8px 12px 8px 22px; margin: 1px 0;
            font-size: .84rem;
            color: var(--ink-text-dim);
            text-decoration: none;
            border-radius: 0 8px 8px 0;
        }
        .sub-link:hover { color: #fff; background: rgba(255,255,255,.05); }
        .sub-link.active { color: var(--accent); font-weight: 600; }
        .sub-link.active::before {
            content: ''; position: absolute;
            left: -1px; top: 6px; bottom: 6px; width: 2px;
            background: var(--accent); border-radius: 2px;
        }

        /* ---------- Sidebar footer (compact, ek line) ---------- */
        .sidebar-footer {
            flex-shrink: 0;
            display: flex; align-items: center; gap: 10px;
            padding: 12px 14px;
            border-top: 1px solid var(--ink-line);
        }
        .sidebar-user { flex: 1; min-width: 0; display: flex; align-items: center; gap: 10px; }
        .avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: var(--accent); color: var(--ink);
            display: grid; place-items: center;
            font-weight: 800; font-size: .85rem; flex-shrink: 0;
        }
        .user-info { min-width: 0; line-height: 1.3; }
        .user-name { color: #fff; font-size: .82rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-mail { font-size: .7rem; color: var(--ink-text-dim); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-role {
            display: inline-block; margin-top: 3px;
            padding: 0 7px;
            font-size: .62rem; font-weight: 700;
            color: var(--accent);
            background: rgba(200,245,66,.1);
            border: 1px solid rgba(200,245,66,.25);
            border-radius: 999px;
        }
        .user-role:empty { display: none; }

        .logout-btn {
            flex-shrink: 0;
            width: 36px; height: 36px;
            display: grid; place-items: center;
            background: transparent; color: var(--ink-text);
            border: 1px solid var(--ink-line);
            border-radius: 10px; cursor: pointer;
        }
        .logout-btn svg { width: 17px; height: 17px; fill: none; stroke: currentColor; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
        .logout-btn:hover { background: var(--bad-tint); color: var(--bad); border-color: transparent; }
        .logout-btn:disabled { opacity: .6; cursor: not-allowed; }

        .logout-btn:focus-visible, .nav-link:focus-visible, .sub-link:focus-visible,
        .sidebar-close:focus-visible, .menu-toggle:focus-visible, .btn:focus-visible, .quick-link:focus-visible {
            outline: 2px solid var(--accent); outline-offset: 2px;
        }

        /* ---------- Mobile close + overlay ---------- */
        .sidebar-close {
            display: none; margin-left: auto;
            width: 34px; height: 34px; place-items: center;
            background: transparent; color: var(--ink-text);
            border: 1px solid var(--ink-line); border-radius: 10px; cursor: pointer;
        }
        .sidebar-close svg { width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; }
        .sidebar-close:hover { background: var(--ink-raised); color: #fff; }

        .sidebar-overlay {
            position: fixed; inset: 0;
            background: rgba(3, 12, 9, .6);
            backdrop-filter: blur(2px);
            opacity: 0; pointer-events: none;
            transition: opacity .25s ease;
            z-index: 40;
        }

        /* ---------- Content ---------- */
        .content { flex: 1; margin-left: var(--sidebar-w); min-width: 0; }

        .topbar { display: flex; align-items: center; gap: 14px; padding: 22px 32px; background: var(--paper); }
        .topbar h1 { font-size: 1.45rem; font-weight: 700; }

        .menu-toggle {
            display: none;
            background: var(--surface); border: 1px solid var(--line);
            border-radius: 10px; padding: 6px 11px; cursor: pointer; font-size: 1.1rem;
            color: var(--text);
        }

        .page { padding: 0 32px 32px; }

        /* ---------- Dashboard components (teeno dashboards use karte hain) ---------- */
        .welcome {
            display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px;
            background: var(--ink); color: #fff;
            border-radius: 18px; padding: 24px 26px; margin-bottom: 20px;
        }
        .welcome h2 { font-size: 1.3rem; font-weight: 800; }
        .welcome p { color: var(--ink-text); font-size: .88rem; margin-top: 4px; max-width: 60ch; }

        .btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 16px; border-radius: 10px;
            font-size: .85rem; font-weight: 700; font-family: inherit;
            text-decoration: none; border: 0; cursor: pointer;
        }
        .btn-accent { background: var(--accent); color: var(--ink); }
        .btn-accent:hover { background: #b5e62c; }

        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px; margin-bottom: 20px; }
        .stat-card { background: var(--surface); border: 1px solid var(--line); border-radius: 14px; padding: 18px; }
        .stat-label { font-size: .8rem; color: var(--muted); font-weight: 500; }
        .stat-value { font-size: 1.6rem; font-weight: 800; margin-top: 4px; letter-spacing: -.02em; }
        .stat-note { font-size: .76rem; margin-top: 2px; color: var(--muted); }
        .stat-note.up { color: var(--good); }
        .stat-note.down { color: var(--bad); }

        .grid-2 { display: grid; grid-template-columns: minmax(0, 2fr) minmax(0, 1fr); gap: 14px; }

        .panel { background: var(--surface); border: 1px solid var(--line); border-radius: 14px; padding: 18px; min-width: 0; }
        .panel-head { display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-bottom: 12px; }
        .panel-head h3 { font-size: 1rem; font-weight: 700; }
        .panel-head a { font-size: .8rem; color: var(--accent-deep); font-weight: 600; text-decoration: none; }
        .panel-head a:hover { text-decoration: underline; }

        .table-wrap { overflow-x: auto; }
        .table { width: 100%; min-width: 520px; border-collapse: collapse; font-size: .85rem; }
        .table th { text-align: left; font-size: .76rem; color: var(--muted); font-weight: 600; padding: 10px 12px; border-bottom: 1px solid var(--line); white-space: nowrap; }
        .table td { padding: 12px; border-bottom: 1px solid var(--line); white-space: nowrap; }
        .table tr:last-child td { border-bottom: 0; }

        .badge { display: inline-block; padding: 3px 10px; border-radius: 999px; font-size: .74rem; font-weight: 700; }
        .badge.good { background: var(--good-tint); color: var(--good); }
        .badge.warn { background: var(--warn-tint); color: var(--warn); }
        .badge.bad  { background: var(--bad-tint);  color: var(--bad); }

        .quick-list { display: flex; flex-direction: column; gap: 8px; }
        .quick-link {
            display: flex; align-items: center; justify-content: space-between; gap: 10px;
            padding: 12px 14px;
            border: 1px solid var(--line); border-radius: 12px;
            color: var(--text); text-decoration: none;
            font-size: .86rem; font-weight: 600;
        }
        .quick-link small { color: var(--muted); font-weight: 500; }
        .quick-link:hover { border-color: var(--accent-deep); background: var(--paper); }

        /* ---------- Responsive ---------- */
        @media (max-width: 1100px) {
            .grid-2 { grid-template-columns: 1fr; }
        }

        @media (max-width: 900px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar-open .sidebar { transform: translateX(0); box-shadow: 8px 0 30px rgba(0,0,0,.35); }
            .sidebar-open .sidebar-overlay { opacity: 1; pointer-events: auto; }
            body.sidebar-open { overflow: hidden; }

            .sidebar-close { display: grid; }
            .content { margin-left: 0; }
            .menu-toggle { display: inline-block; }
            .topbar { padding: 16px 18px; }
            .topbar h1 { font-size: 1.2rem; }
            .page { padding: 0 18px 18px; }
        }

        @media (max-width: 560px) {
            .stats { grid-template-columns: 1fr 1fr; gap: 10px; }
            .stat-card { padding: 14px; }
            .stat-value { font-size: 1.25rem; }
            .welcome { padding: 18px; }
            .welcome .btn { width: 100%; justify-content: center; }
        }

        /* Bahut chhoti screen height (landscape phone) par poora sidebar scroll */
        @media (max-height: 520px) {
            .sidebar { overflow-y: auto; overscroll-behavior: contain; }
            .sidebar-nav { flex: 0 0 auto; overflow: visible; }
        }

        @media (prefers-reduced-motion: reduce) {
            .sidebar, .submenu, .chev, .sidebar-overlay { transition: none; }
        }
    </style>

    @stack('styles')
</head>
{{-- data-page-role: page kis role ka hai (child page @section('role') se set karta hai) --}}
<body data-page-role="@yield('role')">
<div class="app">

    @include('front.sidebar')

    <div class="content">
        <header class="topbar">
            <button class="menu-toggle" id="menuToggle" aria-label="Open menu" aria-expanded="false" aria-controls="sidebar">&#9776;</button>
            <h1>@yield('page_title', 'Dashboard')</h1>
        </header>

        <main class="page">
            @yield('content')
        </main>
    </div>

</div>

<script>
    const body     = document.body;
    const menuBtn  = document.getElementById('menuToggle');
    const closeBtn = document.getElementById('sidebarClose');
    const overlay  = document.getElementById('sidebarOverlay');

    function setSidebar(open) {
        body.classList.toggle('sidebar-open', open);
        menuBtn.setAttribute('aria-expanded', open);
    }

    menuBtn.addEventListener('click', () => setSidebar(!body.classList.contains('sidebar-open')));
    closeBtn.addEventListener('click', () => setSidebar(false));
    overlay.addEventListener('click', () => setSidebar(false));
    document.addEventListener('keydown', e => { if (e.key === 'Escape') setSidebar(false); });
    window.addEventListener('resize', () => { if (window.innerWidth > 900) setSidebar(false); });

    // Submenu accordion (ek time par ek hi khulega)
    document.querySelectorAll('.nav-toggle').forEach(btn => {
        btn.addEventListener('click', () => {
            const item     = btn.closest('.has-sub');
            const willOpen = !item.classList.contains('open');

            document.querySelectorAll('.has-sub.open').forEach(other => {
                other.classList.remove('open');
                other.querySelector('.nav-toggle').setAttribute('aria-expanded', 'false');
            });

            item.classList.toggle('open', willOpen);
            btn.setAttribute('aria-expanded', willOpen);
        });
    });

    // Mobile par link click karte hi sidebar band
    document.querySelectorAll('.sidebar a').forEach(a => {
        a.addEventListener('click', () => { if (window.innerWidth <= 900) setSidebar(false); });
    });
</script>

@stack('scripts')
</body>
</html>