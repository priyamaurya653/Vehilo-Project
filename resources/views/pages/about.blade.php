@extends('frontlayout.main')

@section('title', 'About Us – VEHILO')

@section('content')

{{-- =========================================================
     ABOUT PAGE CSS (sirf is page ke liye)
========================================================== --}}
<style>
    .abt {
        --v-bg: #F0F7F3;
        --v-ink: #051A13;
        --v-green: #0F4A35;
        --v-lime: #C8F542;
        --v-lime-hover: #B5E62C;
        --v-line: #DCEBE2;
        --v-slate-500: #64748b;
        --v-slate-600: #475569;
        background: var(--v-bg);
        color: var(--v-ink);
    }
    .abt *, .abt *::before, .abt *::after { box-sizing: border-box; }
    .abt h1, .abt h2, .abt h3, .abt p { margin: 0; }
    .abt ul { margin: 0; padding: 0; list-style: none; }
    .abt a { text-decoration: none; }

    .abt-container { max-width: 1280px; margin: 0 auto; padding: 0 20px; }
    .abt-section { padding: 48px 0; }
    .abt-white { background: #fff; }
    .abt-dark { background: var(--v-ink); color: #fff; }

    .abt-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--v-lime); flex-shrink: 0; }
    .abt-kicker {
        display: inline-flex; align-items: center; gap: 8px;
        font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: .22em; color: var(--v-green);
    }
    .abt-dark .abt-kicker { color: var(--v-lime); }
    .abt-h2 { margin-top: 12px; font-size: 30px; font-weight: 800; line-height: 1.2; letter-spacing: -.025em; }
    .abt-h2 span { color: var(--v-green); }
    .abt-dark .abt-h2 { color: #fff; }
    .abt-dark .abt-h2 span { color: var(--v-lime); }
    .abt-sub { margin-top: 12px; max-width: 40rem; font-size: 14px; line-height: 24px; color: var(--v-slate-600); }
    .abt-dark .abt-sub { color: rgba(255, 255, 255, .6); }
    .abt-head { max-width: 42rem; margin-bottom: 28px; }
    .abt-head-center { margin-left: auto; margin-right: auto; text-align: center; }
    .abt-head-center .abt-sub { margin-left: auto; margin-right: auto; }

    .abt-ic {
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        width: 44px; height: 44px; border-radius: 12px; background: var(--v-bg); color: var(--v-green);
    }
    .abt-ic svg { width: 22px; height: 22px; }

    /* Buttons */
    .abt-btn {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        height: 48px; padding: 0 22px; border-radius: 12px; font-size: 13px; font-weight: 800;
        transition: transform .15s, background .15s, border-color .15s;
    }
    .abt-btn svg { width: 16px; height: 16px; }
    .abt-btn-lime { background: var(--v-lime); color: var(--v-ink); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, .1); }
    .abt-btn-lime:hover { background: var(--v-lime-hover); transform: translateY(-2px); }
    .abt-btn-outline { border: 1px solid var(--v-line); background: #fff; color: var(--v-green); }
    .abt-btn-outline:hover { border-color: var(--v-green); }
    .abt-btn-ghost { border: 1px solid rgba(255, 255, 255, .2); color: #fff; }
    .abt-btn-ghost:hover { background: rgba(255, 255, 255, .08); }
    .abt-actions { margin-top: 28px; display: flex; flex-wrap: wrap; gap: 12px; }

    /* ---------- HERO BANNER ---------- */
    .abt-hero { padding: 20px 0 8px; }
    .abt-banner {
        position: relative; overflow: hidden; display: grid; gap: 32px; align-items: center;
        padding: 32px 22px; border-radius: 28px;
        background:
            radial-gradient(520px 260px at 100% 0%, rgba(200, 245, 66, .22), transparent 70%),
            radial-gradient(420px 240px at 0% 100%, rgba(15, 74, 53, .9), transparent 70%),
            var(--v-ink);
        color: #fff;
        box-shadow: 0 30px 60px -30px rgba(5, 26, 19, .55);
    }
    .abt-banner::after {
        content: ""; position: absolute; inset: 0; pointer-events: none; opacity: .5;
        background-image: radial-gradient(rgba(255, 255, 255, .08) 1px, transparent 1px);
        background-size: 18px 18px;
        mask-image: linear-gradient(90deg, transparent, #000 60%);
        -webkit-mask-image: linear-gradient(90deg, transparent, #000 60%);
    }
    .abt-banner > * { position: relative; z-index: 1; }

    .abt-badge {
        display: inline-flex; align-items: center; gap: 8px; margin-bottom: 16px; padding: 6px 12px;
        border: 1px solid rgba(255, 255, 255, .14); border-radius: 999px; background: rgba(255, 255, 255, .06);
        font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .18em; color: var(--v-lime);
    }
    .abt-crumb { display: flex; align-items: center; gap: 6px; margin-bottom: 14px; font-size: 12px; color: rgba(255, 255, 255, .5); }
    .abt-crumb a { color: rgba(255, 255, 255, .7); }
    .abt-crumb a:hover { color: var(--v-lime); }
    .abt-title { font-size: 34px; font-weight: 800; line-height: 1.08; letter-spacing: -.035em; color: #fff; }
    .abt-title span { color: var(--v-lime); }
    .abt-lead { margin-top: 16px; max-width: 34rem; font-size: 14px; line-height: 24px; color: rgba(255, 255, 255, .68); }
    .abt-banner .abt-actions { margin-top: 24px; }
    .abt-banner .abt-btn-outline { border-color: rgba(255, 255, 255, .2); background: transparent; color: #fff; }
    .abt-banner .abt-btn-outline:hover { background: rgba(255, 255, 255, .08); border-color: rgba(255, 255, 255, .35); }
    .abt-trust { margin-top: 22px; display: flex; flex-wrap: wrap; gap: 8px 18px; }
    .abt-trust li { display: flex; align-items: center; gap: 8px; font-size: 12px; color: rgba(255, 255, 255, .7); }

    /* Banner right: category tiles + floating cards */
    .abt-showcase { position: relative; }
    .abt-tiles { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
    .abt-tile {
        display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px;
        aspect-ratio: 1 / 1; border: 1px solid rgba(255, 255, 255, .1); border-radius: 18px;
        background: rgba(255, 255, 255, .05); font-size: 11px; font-weight: 600; color: rgba(255, 255, 255, .8);
        transition: background .2s, border-color .2s, transform .2s;
    }
    .abt-tile:hover { background: rgba(200, 245, 66, .1); border-color: rgba(200, 245, 66, .45); transform: translateY(-3px); }
    .abt-tile span { display: flex; align-items: center; justify-content: center; width: 38px; height: 38px; border-radius: 11px; background: rgba(200, 245, 66, .14); color: var(--v-lime); }
    .abt-tile svg { width: 20px; height: 20px; }
    .abt-tile.is-lime { background: var(--v-lime); border-color: var(--v-lime); color: var(--v-ink); }
    .abt-tile.is-lime span { background: var(--v-ink); color: var(--v-lime); }

    .abt-float {
        position: absolute; display: flex; align-items: center; gap: 10px; padding: 10px 14px;
        border-radius: 14px; background: #fff; color: var(--v-ink);
        box-shadow: 0 16px 30px -12px rgba(0, 0, 0, .45);
    }
    .abt-float strong { display: block; font-size: 15px; font-weight: 800; line-height: 1.1; }
    .abt-float small { font-size: 10px; color: var(--v-slate-500); }
    .abt-float .abt-ic { width: 34px; height: 34px; border-radius: 10px; }
    .abt-float .abt-ic svg { width: 17px; height: 17px; }
    .abt-float-1 { left: -12px; bottom: -14px; }
    .abt-float-2 { right: -10px; top: -14px; }
    .abt-float-2 .abt-ic { background: var(--v-lime); color: var(--v-ink); }

    /* Stats strip (banner ke neeche) */
    .abt-stats {
        margin-top: 14px; display: grid; grid-template-columns: repeat(2, 1fr);
        overflow: hidden; border: 1px solid var(--v-line); border-radius: 18px; background: #fff;
    }
    .abt-stat { display: flex; align-items: center; gap: 12px; padding: 14px 16px; border-bottom: 1px solid var(--v-line); }
    .abt-stat:nth-child(odd) { border-right: 1px solid var(--v-line); }
    .abt-stat:nth-last-child(-n+2) { border-bottom: 0; }
    .abt-stat .abt-ic { width: 36px; height: 36px; border-radius: 10px; }
    .abt-stat .abt-ic svg { width: 18px; height: 18px; }
    .abt-stat strong { display: block; font-size: 18px; font-weight: 800; line-height: 1.1; color: var(--v-green); }
    .abt-stat small { font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: .06em; color: var(--v-slate-500); }

    /* ---------- STORY ---------- */
    .abt-story { display: grid; gap: 40px; align-items: center; }
    .abt-story-text p + p { margin-top: 14px; }
    .abt-story-text .abt-sub { margin-top: 16px; }
    .abt-points { margin-top: 24px; display: grid; gap: 10px; }
    .abt-points li { display: flex; align-items: flex-start; gap: 10px; font-size: 13px; line-height: 20px; color: var(--v-ink); }
    .abt-points li::before {
        content: "✓"; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        width: 20px; height: 20px; border-radius: 50%; background: var(--v-lime); color: var(--v-ink); font-size: 11px; font-weight: 800;
    }

    .abt-visual { position: relative; }
    .abt-visual-glow { position: absolute; inset: -16px; border-radius: 35px; background: rgba(200, 245, 66, .2); filter: blur(40px); }
    .abt-visual-card {
        position: relative; overflow: hidden; padding: 28px; border-radius: 28px;
        background: linear-gradient(160deg, var(--v-green), var(--v-ink)); color: #fff;
        box-shadow: 0 25px 50px -12px rgba(5, 26, 19, .35);
    }
    .abt-visual-card::before {
        content: ""; position: absolute; right: -60px; top: -60px; width: 220px; height: 220px;
        border-radius: 50%; background: rgba(200, 245, 66, .16); filter: blur(40px);
    }
    .abt-visual-card > * { position: relative; }
    .abt-visual-tag {
        display: inline-flex; padding: 6px 12px; border-radius: 999px; background: var(--v-lime); color: var(--v-ink);
        font-size: 9px; font-weight: 800; text-transform: uppercase; letter-spacing: .08em;
    }
    .abt-visual-card h3 { margin-top: 18px; font-size: 22px; font-weight: 800; line-height: 1.3; }
    .abt-visual-card h3 span { color: var(--v-lime); }
    .abt-flow { margin-top: 24px; display: grid; gap: 10px; }
    .abt-flow-item {
        display: flex; align-items: center; gap: 14px; padding: 14px;
        border: 1px solid rgba(255, 255, 255, .1); border-radius: 16px; background: rgba(255, 255, 255, .05);
    }
    .abt-flow-item .abt-ic { width: 38px; height: 38px; border-radius: 10px; background: var(--v-lime); color: var(--v-ink); }
    .abt-flow-item .abt-ic svg { width: 18px; height: 18px; }
    .abt-flow-item strong { display: block; font-size: 13px; }
    .abt-flow-item small { font-size: 11px; color: rgba(255, 255, 255, .55); }

    /* ---------- WHO WE SERVE ---------- */
    .abt-serve { display: grid; gap: 16px; }
    .abt-serve-card {
        display: flex; flex-direction: column; padding: 26px; border: 1px solid var(--v-line); border-radius: 20px; background: #fff;
        transition: transform .15s, box-shadow .15s, border-color .15s;
    }
    .abt-serve-card:hover { transform: translateY(-4px); border-color: var(--v-green); box-shadow: 0 20px 40px -20px rgba(5, 26, 19, .25); }
    .abt-serve-card.is-featured { border-color: transparent; background: var(--v-ink); color: #fff; }
    .abt-serve-card.is-featured .abt-ic { background: rgba(200, 245, 66, .14); color: var(--v-lime); }
    .abt-serve-label { margin-top: 20px; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: .2em; color: var(--v-green); }
    .abt-serve-card.is-featured .abt-serve-label { color: var(--v-lime); }
    .abt-serve-card h3 { margin-top: 6px; font-size: 20px; font-weight: 800; }
    .abt-serve-card > p { margin-top: 10px; font-size: 13px; line-height: 22px; color: var(--v-slate-600); }
    .abt-serve-card.is-featured > p { color: rgba(255, 255, 255, .6); }
    .abt-serve-card ul { margin-top: 18px; display: grid; gap: 8px; }
    .abt-serve-card li { display: flex; align-items: center; gap: 8px; font-size: 12px; }
    .abt-serve-link {
        margin-top: auto; padding-top: 22px; display: inline-flex; align-items: center; gap: 6px;
        font-size: 13px; font-weight: 800; color: var(--v-green);
    }
    .abt-serve-card.is-featured .abt-serve-link { color: var(--v-lime); }
    .abt-serve-link svg { width: 15px; height: 15px; transition: transform .15s; }
    .abt-serve-link:hover svg { transform: translateX(3px); }

    /* ---------- WHY VEHILO (dark) ---------- */
    .abt-why { display: grid; gap: 16px; }
    .abt-why-card { padding: 24px; border: 1px solid rgba(255, 255, 255, .1); border-radius: 18px; background: rgba(255, 255, 255, .04); transition: border-color .15s; }
    .abt-why-card:hover { border-color: rgba(200, 245, 66, .4); }
    .abt-why-card .abt-ic { background: rgba(200, 245, 66, .14); color: var(--v-lime); }
    .abt-why-card h3 { margin-top: 18px; font-size: 16px; font-weight: 700; color: #fff; }
    .abt-why-card p { margin-top: 8px; font-size: 12px; line-height: 20px; color: rgba(255, 255, 255, .55); }

    /* ---------- CTA ---------- */
    .abt-cta {
        position: relative; overflow: hidden; padding: 36px 22px; border-radius: 28px; text-align: center;
        background: linear-gradient(140deg, var(--v-green), var(--v-ink)); color: #fff;
    }
    .abt-cta::before {
        content: ""; position: absolute; left: 50%; top: -120px; transform: translateX(-50%);
        width: 480px; height: 240px; border-radius: 50%; background: rgba(200, 245, 66, .18); filter: blur(60px);
    }
    .abt-cta > * { position: relative; }
    .abt-cta .abt-kicker { color: var(--v-lime); }
    .abt-cta h2 { max-width: 36rem; margin: 14px auto 0; font-size: 28px; font-weight: 800; line-height: 1.2; letter-spacing: -.025em; }
    .abt-cta h2 span { color: var(--v-lime); }
    .abt-cta p { max-width: 32rem; margin: 12px auto 0; font-size: 13px; line-height: 22px; color: rgba(255, 255, 255, .65); }
    .abt-cta .abt-actions { justify-content: center; }

    /* ---------- RESPONSIVE ---------- */
    @media (min-width: 640px) {
        .abt-container { padding: 0 24px; }
        .abt-banner { padding: 40px 36px; }
        .abt-title { font-size: 42px; }
        .abt-h2 { font-size: 32px; }
        .abt-stats { grid-template-columns: repeat(4, 1fr); }
        .abt-stat { border-bottom: 0; }
        .abt-stat:nth-child(odd) { border-right: 0; }
        .abt-stat + .abt-stat { border-left: 1px solid var(--v-line); }
        .abt-why { grid-template-columns: repeat(2, 1fr); }
        .abt-cta { padding: 48px 40px; }
        .abt-cta h2 { font-size: 36px; }
    }
    @media (min-width: 1024px) {
        .abt-container { padding: 0 32px; }
        .abt-section { padding: 64px 0; }
        .abt-hero { padding: 24px 0 8px; }
        .abt-banner { grid-template-columns: 1.1fr .9fr; gap: 48px; padding: 48px 48px; }
        .abt-title { font-size: 50px; }
        .abt-story { grid-template-columns: 1.05fr .95fr; gap: 64px; }
        .abt-serve { grid-template-columns: repeat(3, 1fr); }
        .abt-why { grid-template-columns: repeat(4, 1fr); }
    }
    @media (max-width: 639px) {
        .abt-float-1 { left: 6px; bottom: -16px; }
        .abt-float-2 { right: 6px; top: -16px; }
        .abt-showcase { margin: 12px 0 8px; }
    }
    @media (prefers-reduced-motion: reduce) {
        .abt-serve-card, .abt-btn, .abt-serve-link svg, .abt-tile { transition: none; }
        .abt-serve-card:hover, .abt-btn-lime:hover, .abt-tile:hover { transform: none; }
    }
</style>

@php
    // Chhote inline SVG icons (kisi library ki zaroorat nahi)
    $svg = function ($path) {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">' . $path . '</svg>';
    };
    $icons = [
        'search'   => $svg('<circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/>'),
        'key'      => $svg('<circle cx="7.5" cy="15.5" r="4.5"/><path d="m10.7 12.3 9.3-9.3"/><path d="m16 7 3 3"/><path d="m19 4 2 2"/>'),
        'handshake'=> $svg('<path d="m11 17 2 2a1 1 0 1 0 3-3"/><path d="m14 14 2.5 2.5a1 1 0 1 0 3-3l-3.9-3.9a2 2 0 0 0-2.8 0l-.9.9a2 2 0 0 1-2.8 0 1 1 0 0 1 0-1.4L12 6l.3-.3a3 3 0 0 1 4.2 0L21 10"/><path d="M3 11l5.5-5.5a2 2 0 0 1 2.8 0"/><path d="M3 11v6l4 4"/>'),
        'user'     => $svg('<circle cx="12" cy="8" r="4"/><path d="M4 21v-1a6 6 0 0 1 6-6h4a6 6 0 0 1 6 6v1"/>'),
        'car'      => $svg('<path d="M19 17h2v-4l-2-5H5L3 13v4h2"/><circle cx="7.5" cy="17.5" r="2"/><circle cx="16.5" cy="17.5" r="2"/><path d="M9.5 17.5h5"/>'),
        'building' => $svg('<rect x="4" y="3" width="16" height="18" rx="2"/><path d="M9 7h1M14 7h1M9 11h1M14 11h1M9 15h1M14 15h1"/>'),
        'shield'   => $svg('<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/>'),
        'clock'    => $svg('<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>'),
        'wallet'   => $svg('<path d="M20 12V8H6a2 2 0 0 1 0-4h12v4"/><path d="M4 6v12a2 2 0 0 0 2 2h14v-4"/><path d="M18 12a2 2 0 0 0 0 4h4v-4z"/>'),
        'headset'  => $svg('<path d="M3 14v-2a9 9 0 0 1 18 0v2"/><path d="M21 16a2 2 0 0 1-2 2h-1v-6h1a2 2 0 0 1 2 2z"/><path d="M3 16a2 2 0 0 0 2 2h1v-6H5a2 2 0 0 0-2 2z"/>'),
        'map'      => $svg('<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/>'),
        'grid'     => $svg('<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>'),
        'star'     => $svg('<path d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1 6.2L12 17.3 6.5 20.2l1-6.2L3 9.6l6.2-.9z"/>'),
        'arrow'    => $svg('<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>'),
        'bike'     => $svg('<circle cx="5.5" cy="17.5" r="3.5"/><circle cx="18.5" cy="17.5" r="3.5"/><path d="M15 6h2l2 11.5"/><path d="m5.5 17.5 4-7.5h6"/>'),
        'scooter'  => $svg('<circle cx="5.5" cy="17.5" r="2.5"/><circle cx="18.5" cy="17.5" r="2.5"/><path d="M8 17.5h7.5l2-7H14"/><path d="M14 4h2.5l2 6.5"/><path d="M3 13h6l2 4.5"/>'),
        'bolt'     => $svg('<path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z"/>'),
        'rickshaw' => $svg('<path d="M3 16V8a3 3 0 0 1 3-3h8l3 5h2a2 2 0 0 1 2 2v4"/><path d="M3 10h14"/><circle cx="6.5" cy="17" r="2"/><circle cx="17.5" cy="17" r="2"/><path d="M8.5 17h7"/>'),
        'truck'    => $svg('<path d="M1 4h13v12H1z"/><path d="M14 9h4l3 3v4h-7z"/><circle cx="5.5" cy="18.5" r="2"/><circle cx="17.5" cy="18.5" r="2"/>'),
    ];
@endphp

<div class="abt">

    {{-- =========================================================
         HERO BANNER
    ========================================================== --}}
    <section class="abt-hero">
        <div class="abt-container">

            <div class="abt-banner">

                {{-- Left: text --}}
                <div>
                    <nav class="abt-crumb" aria-label="Breadcrumb">
                        <a href="{{ url('/') }}">Home</a> <span>/</span> <span>About</span>
                    </nav>

                    <div class="abt-badge"><span class="abt-dot"></span> About VEHILO</div>

                    <h1 class="abt-title">
                        We're making mobility
                        <span>simple for India.</span>
                    </h1>

                    <p class="abt-lead">
                        VEHILO is a complete vehicle rental marketplace. Rent the right vehicle for every
                        journey, earn from your own vehicle, or build a mobility business in your city.
                    </p>

                    <div class="abt-actions">
                        <a href="{{ url('/vehicles') }}" class="abt-btn abt-btn-lime">Rent a Vehicle {!! $icons['arrow'] !!}</a>
                        <a href="{{ url('/vision') }}" class="abt-btn abt-btn-outline">Our Vision</a>
                    </div>

                    <ul class="abt-trust">
                        <li><span class="abt-dot"></span> Verified owners & renters</li>
                        <li><span class="abt-dot"></span> Transparent pricing</li>
                        <li><span class="abt-dot"></span> 24/7 support</li>
                    </ul>
                </div>

                {{-- Right: category tiles --}}
                <div class="abt-showcase">
                    <div class="abt-tiles">
                        @foreach([
                            ['car', 'Cars', false], ['bike', 'Bikes', false], ['scooter', 'Scooters', false],
                            ['bolt', 'Electric', true], ['rickshaw', 'E-Rickshaws', false], ['truck', 'Commercial', false],
                        ] as [$ic, $label, $lime])
                            <a href="{{ url('/vehicles') }}" class="abt-tile {{ $lime ? 'is-lime' : '' }}">
                                <span>{!! $icons[$ic] !!}</span>
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>

                    <div class="abt-float abt-float-1">
                        <div class="abt-ic">{!! $icons['shield'] !!}</div>
                        <div><strong>Verified</strong><small>Owners & partners</small></div>
                    </div>
                    <div class="abt-float abt-float-2">
                        <div class="abt-ic">{!! $icons['star'] !!}</div>
                        <div><strong>4.8/5</strong><small>Average rating</small></div>
                    </div>
                </div>

            </div>

            {{-- Stats strip --}}
            <div class="abt-stats">
                <div class="abt-stat"><div class="abt-ic">{!! $icons['car'] !!}</div><div><strong>8,400+</strong><small>Vehicles listed</small></div></div>
                <div class="abt-stat"><div class="abt-ic">{!! $icons['map'] !!}</div><div><strong>36</strong><small>Cities covered</small></div></div>
                <div class="abt-stat"><div class="abt-ic">{!! $icons['grid'] !!}</div><div><strong>6</strong><small>Vehicle categories</small></div></div>
                <div class="abt-stat"><div class="abt-ic">{!! $icons['headset'] !!}</div><div><strong>24/7</strong><small>Customer support</small></div></div>
            </div>

        </div>
    </section>


    {{-- =========================================================
         OUR STORY
    ========================================================== --}}
    <section class="abt-section abt-white">
        <div class="abt-container">
            <div class="abt-story">

                <div class="abt-story-text">
                    <span class="abt-kicker"><span class="abt-dot"></span> Our story</span>
                    <h2 class="abt-h2">Renting a vehicle shouldn't mean <span>settling for less.</span></h2>

                    <p class="abt-sub">
                        Finding a vehicle on rent in India usually means calling around, comparing unclear prices
                        and picking from whatever is left. Owners, meanwhile, have vehicles standing idle with no
                        easy way to rent them out safely.
                    </p>
                    <p class="abt-sub">
                        VEHILO was built to fix both sides. One platform where every kind of vehicle — from a
                        scooter to a commercial truck — can be listed, found and booked with verified people and
                        transparent pricing.
                    </p>

                    <ul class="abt-points">
                        <li>Every vehicle category in one place, not just electric</li>
                        <li>Verified owners, renters and partners</li>
                        <li>Separate dashboards for users, partners and admins</li>
                    </ul>
                </div>

                <div class="abt-visual">
                    <div class="abt-visual-glow"></div>
                    <div class="abt-visual-card">
                        <span class="abt-visual-tag">How VEHILO works</span>
                        <h3>One platform. <span>Three ways to move.</span></h3>

                        <div class="abt-flow">
                            <div class="abt-flow-item">
                                <div class="abt-ic">{!! $icons['search'] !!}</div>
                                <div><strong>Riders find & book</strong><small>Pick a vehicle, dates and confirm in seconds</small></div>
                            </div>
                            <div class="abt-flow-item">
                                <div class="abt-ic">{!! $icons['key'] !!}</div>
                                <div><strong>Owners list & earn</strong><small>Add a vehicle and manage booking requests</small></div>
                            </div>
                            <div class="abt-flow-item">
                                <div class="abt-ic">{!! $icons['handshake'] !!}</div>
                                <div><strong>Partners build & grow</strong><small>Run hubs, fleets and charging in their city</small></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    {{-- =========================================================
         WHO WE SERVE
    ========================================================== --}}
    <section class="abt-section">
        <div class="abt-container">

            <div class="abt-head abt-head-center">
                <span class="abt-kicker"><span class="abt-dot"></span> Who we serve</span>
                <h2 class="abt-h2">Built for everyone <span>on the road.</span></h2>
                <p class="abt-sub">Whether you need a ride, own a vehicle or want to build a business, VEHILO has a place for you.</p>
            </div>

            @php
                $serve = [
                    [
                        'icon' => 'user', 'label' => 'For Riders', 'title' => 'Rent any vehicle',
                        'text' => 'Daily commuters, tourists, gig workers and businesses find the exact vehicle they need.',
                        'points' => ['Cars, bikes, scooters & more', 'Upfront daily pricing', 'Live availability'],
                        'link' => url('/vehicles'), 'cta' => 'Browse vehicles', 'featured' => false,
                    ],
                    [
                        'icon' => 'building', 'label' => 'For Partners', 'title' => 'Build a mobility business',
                        'text' => 'Launch a VEHILO franchise, fleet, charging point or delivery operation in your city.',
                        'points' => ['EV franchise & fleet models', 'Dedicated partner dashboard', 'Support from application to launch'],
                        'link' => url('/partner'), 'cta' => 'Become a partner', 'featured' => true,
                    ],
                    [
                        'icon' => 'car', 'label' => 'For Owners', 'title' => 'Earn from your vehicle',
                        'text' => 'List a vehicle in minutes and turn idle time into steady income.',
                        'points' => ['Guided listing flow', 'Approve or decline requests', 'Track earnings in real time'],
                        'link' => url('/partner'), 'cta' => 'List your vehicle', 'featured' => false,
                    ],
                ];
            @endphp

            <div class="abt-serve">
                @foreach($serve as $item)
                    <div class="abt-serve-card {{ $item['featured'] ? 'is-featured' : '' }}">
                        <div class="abt-ic">{!! $icons[$item['icon']] !!}</div>
                        <p class="abt-serve-label">{{ $item['label'] }}</p>
                        <h3>{{ $item['title'] }}</h3>
                        <p>{{ $item['text'] }}</p>
                        <ul>
                            @foreach($item['points'] as $point)
                                <li><span class="abt-dot"></span> {{ $point }}</li>
                            @endforeach
                        </ul>
                        <a href="{{ $item['link'] }}" class="abt-serve-link">{{ $item['cta'] }} {!! $icons['arrow'] !!}</a>
                    </div>
                @endforeach
            </div>

        </div>
    </section>


    {{-- =========================================================
         WHY VEHILO
    ========================================================== --}}
    <section class="abt-section abt-dark">
        <div class="abt-container">

            <div class="abt-head">
                <span class="abt-kicker"><span class="abt-dot"></span> Why VEHILO</span>
                <h2 class="abt-h2">Trust, built into <span>every trip.</span></h2>
                <p class="abt-sub">We focus on the things that matter most when you hand over — or take — the keys.</p>
            </div>

            <div class="abt-why">
                @foreach([
                    ['shield',  'Verified Community', 'Every owner, renter and partner is ID-checked before they can transact.'],
                    ['wallet',  'Transparent Pricing', 'What you see is what you pay. Owners see clear payouts too.'],
                    ['clock',   'Real-Time Updates',   'Live availability and booking status from request to return.'],
                    ['headset', '24/7 Support',        'Our team is available around the clock whenever you need help.'],
                ] as [$ic, $title, $text])
                    <div class="abt-why-card">
                        <div class="abt-ic">{!! $icons[$ic] !!}</div>
                        <h3>{{ $title }}</h3>
                        <p>{{ $text }}</p>
                    </div>
                @endforeach
            </div>

        </div>
    </section>


    {{-- =========================================================
         CTA
    ========================================================== --}}
    <section class="abt-section">
        <div class="abt-container">
            <div class="abt-cta">
                <span class="abt-kicker"><span class="abt-dot"></span> Get started</span>
                <h2>Ready to rent, list <span>or partner?</span></h2>
                <p>Join thousands of riders, owners and partners already moving with VEHILO.</p>

                <div class="abt-actions">
                    <a href="{{ url('/vehicles') }}" class="abt-btn abt-btn-lime">Rent a Vehicle {!! $icons['arrow'] !!}</a>
                    <a href="{{ url('/contact') }}" class="abt-btn abt-btn-ghost">Contact Us</a>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection