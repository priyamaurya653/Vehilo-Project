@extends('frontlayout.main')

@section('title', 'Our Vision – VEHILO')

@section('content')

{{-- =========================================================
     VISION PAGE CSS (sirf is page ke liye)
========================================================== --}}
<style>
    .vsn {
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
    .vsn *, .vsn *::before, .vsn *::after { box-sizing: border-box; }
    .vsn h1, .vsn h2, .vsn h3, .vsn p, .vsn blockquote { margin: 0; }
    .vsn ul { margin: 0; padding: 0; list-style: none; }
    .vsn a { text-decoration: none; }

    .vsn-container { max-width: 1280px; margin: 0 auto; padding: 0 20px; }
    .vsn-section { padding: 48px 0; }
    .vsn-white { background: #fff; }
    .vsn-dark { background: var(--v-ink); color: #fff; }

    .vsn-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--v-lime); flex-shrink: 0; }
    .vsn-kicker {
        display: inline-flex; align-items: center; gap: 8px;
        font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: .22em; color: var(--v-green);
    }
    .vsn-dark .vsn-kicker { color: var(--v-lime); }
    .vsn-h2 { margin-top: 10px; font-size: 28px; font-weight: 800; line-height: 1.2; letter-spacing: -.025em; }
    .vsn-h2 span { color: var(--v-green); }
    .vsn-dark .vsn-h2 { color: #fff; }
    .vsn-dark .vsn-h2 span { color: var(--v-lime); }
    .vsn-sub { margin-top: 10px; max-width: 40rem; font-size: 14px; line-height: 24px; color: var(--v-slate-600); }
    .vsn-dark .vsn-sub { color: rgba(255, 255, 255, .6); }
    .vsn-head { max-width: 42rem; margin-bottom: 28px; }
    .vsn-head-row { display: flex; flex-wrap: wrap; align-items: flex-end; justify-content: space-between; gap: 16px; max-width: none; }
    .vsn-head-row .vsn-sub { max-width: 26rem; margin-top: 0; }
    .vsn-head-center { margin-left: auto; margin-right: auto; text-align: center; }
    .vsn-head-center .vsn-sub { margin-left: auto; margin-right: auto; }

    .vsn-ic {
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        width: 44px; height: 44px; border-radius: 12px; background: var(--v-bg); color: var(--v-green);
    }
    .vsn-ic svg { width: 22px; height: 22px; }

    /* Buttons */
    .vsn-actions { margin-top: 24px; display: flex; flex-wrap: wrap; gap: 12px; }
    .vsn-btn {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        height: 48px; padding: 0 22px; border-radius: 12px; font-size: 13px; font-weight: 800;
        transition: transform .15s, background .15s, border-color .15s;
    }
    .vsn-btn svg { width: 16px; height: 16px; }
    .vsn-btn-lime { background: var(--v-lime); color: var(--v-ink); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, .12); }
    .vsn-btn-lime:hover { background: var(--v-lime-hover); transform: translateY(-2px); }
    .vsn-btn-ghost { border: 1px solid rgba(255, 255, 255, .2); color: #fff; }
    .vsn-btn-ghost:hover { background: rgba(255, 255, 255, .08); border-color: rgba(255, 255, 255, .35); }

    /* =========================================================
       HERO BANNER
    ========================================================= */
    .vsn-hero { padding: 20px 0 8px; }
    .vsn-banner {
        position: relative; overflow: hidden; display: grid; gap: 32px; align-items: center;
        padding: 32px 22px; border-radius: 28px; color: #fff;
        background:
            radial-gradient(520px 260px at 100% 0%, rgba(200, 245, 66, .22), transparent 70%),
            radial-gradient(420px 240px at 0% 100%, rgba(15, 74, 53, .9), transparent 70%),
            var(--v-ink);
        box-shadow: 0 30px 60px -30px rgba(5, 26, 19, .55);
    }
    .vsn-banner::after {
        content: ""; position: absolute; inset: 0; pointer-events: none; opacity: .5;
        background-image: radial-gradient(rgba(255, 255, 255, .08) 1px, transparent 1px);
        background-size: 18px 18px;
        mask-image: linear-gradient(90deg, transparent, #000 60%);
        -webkit-mask-image: linear-gradient(90deg, transparent, #000 60%);
    }
    .vsn-banner > * { position: relative; z-index: 1; }

    .vsn-crumb { display: flex; align-items: center; gap: 6px; margin-bottom: 14px; font-size: 12px; color: rgba(255, 255, 255, .5); }
    .vsn-crumb a { color: rgba(255, 255, 255, .7); }
    .vsn-crumb a:hover { color: var(--v-lime); }
    .vsn-badge {
        display: inline-flex; align-items: center; gap: 8px; margin-bottom: 16px; padding: 6px 12px;
        border: 1px solid rgba(255, 255, 255, .14); border-radius: 999px; background: rgba(255, 255, 255, .06);
        font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .18em; color: var(--v-lime);
    }
    .vsn-title { font-size: 34px; font-weight: 800; line-height: 1.08; letter-spacing: -.035em; color: #fff; }
    .vsn-title span { color: var(--v-lime); }
    .vsn-lead { margin-top: 16px; max-width: 34rem; font-size: 14px; line-height: 24px; color: rgba(255, 255, 255, .68); }

    /* Right: quote + pillars */
    .vsn-quote {
        padding: 22px; border: 1px solid rgba(255, 255, 255, .12); border-radius: 22px;
        background: rgba(255, 255, 255, .06);
        backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
    }
    .vsn-quote-top { display: flex; align-items: center; justify-content: space-between; }
    .vsn-quote-mark {
        display: flex; align-items: center; justify-content: center; width: 40px; height: 40px;
        border-radius: 12px; background: var(--v-lime); color: var(--v-ink); font-size: 26px; font-weight: 800; line-height: 1; padding-top: 8px;
    }
    .vsn-quote-tag { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .14em; color: rgba(255, 255, 255, .5); }
    .vsn-quote blockquote { margin-top: 16px; font-size: 18px; font-weight: 700; line-height: 1.45; }
    .vsn-quote blockquote span { color: var(--v-lime); }
    .vsn-quote-by { margin-top: 12px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .14em; color: rgba(255, 255, 255, .5); }

    .vsn-pillars { margin-top: 12px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
    .vsn-pillar {
        padding: 14px 12px; border: 1px solid rgba(255, 255, 255, .1); border-radius: 16px; background: rgba(255, 255, 255, .04);
        transition: border-color .2s, background .2s;
    }
    .vsn-pillar:hover { border-color: rgba(200, 245, 66, .45); background: rgba(200, 245, 66, .08); }
    .vsn-pillar span { display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 10px; background: rgba(200, 245, 66, .14); color: var(--v-lime); }
    .vsn-pillar svg { width: 17px; height: 17px; }
    .vsn-pillar strong { display: block; margin-top: 10px; font-size: 12px; font-weight: 700; }
    .vsn-pillar small { font-size: 10px; color: rgba(255, 255, 255, .5); }

    /* Stats strip */
    .vsn-stats {
        margin-top: 14px; display: grid; grid-template-columns: repeat(2, 1fr);
        overflow: hidden; border: 1px solid var(--v-line); border-radius: 18px; background: #fff;
    }
    .vsn-stat { display: flex; align-items: center; gap: 12px; padding: 14px 16px; border-bottom: 1px solid var(--v-line); }
    .vsn-stat:nth-child(odd) { border-right: 1px solid var(--v-line); }
    .vsn-stat:nth-last-child(-n+2) { border-bottom: 0; }
    .vsn-stat .vsn-ic { width: 36px; height: 36px; border-radius: 10px; }
    .vsn-stat .vsn-ic svg { width: 18px; height: 18px; }
    .vsn-stat strong { display: block; font-size: 18px; font-weight: 800; line-height: 1.1; color: var(--v-green); }
    .vsn-stat small { font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: .06em; color: var(--v-slate-500); }

    /* =========================================================
       MISSION / VISION
    ========================================================= */
    .vsn-mv-grid { display: grid; gap: 16px; }
    .vsn-mv-card {
        position: relative; overflow: hidden; padding: 26px; border: 1px solid var(--v-line); border-radius: 22px; background: var(--v-bg);
    }
    .vsn-mv-card.is-dark {
        border-color: transparent; color: #fff;
        background: radial-gradient(380px 200px at 100% 0%, rgba(200, 245, 66, .16), transparent 70%), var(--v-ink);
    }
    .vsn-mv-watermark {
        position: absolute; right: -18px; bottom: -18px; width: 140px; height: 140px;
        color: rgba(15, 74, 53, .06); pointer-events: none;
    }
    .vsn-mv-card.is-dark .vsn-mv-watermark { color: rgba(200, 245, 66, .07); }
    .vsn-mv-watermark svg { width: 100%; height: 100%; }
    .vsn-mv-card > *:not(.vsn-mv-watermark) { position: relative; }
    .vsn-mv-top { display: flex; align-items: center; gap: 12px; }
    .vsn-mv-card.is-dark .vsn-ic { background: rgba(200, 245, 66, .14); color: var(--v-lime); }
    .vsn-mv-card.is-light { background: #fff; }
    .vsn-mv-label { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: .2em; color: var(--v-green); }
    .vsn-mv-card.is-dark .vsn-mv-label { color: var(--v-lime); }
    .vsn-mv-card h3 { margin-top: 18px; font-size: 21px; font-weight: 800; line-height: 1.3; letter-spacing: -.02em; }
    .vsn-mv-card p { margin-top: 10px; font-size: 13px; line-height: 22px; color: var(--v-slate-600); }
    .vsn-mv-card.is-dark p { color: rgba(255, 255, 255, .6); }
    .vsn-mv-list { margin-top: 16px; display: grid; gap: 8px; }
    .vsn-mv-list li { display: flex; align-items: flex-start; gap: 10px; font-size: 13px; line-height: 20px; }
    .vsn-mv-list li::before {
        content: "✓"; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        width: 20px; height: 20px; border-radius: 50%; background: var(--v-lime); color: var(--v-ink); font-size: 11px; font-weight: 800;
    }

    /* =========================================================
       VALUES
    ========================================================= */
    .vsn-values { display: grid; gap: 14px; }
    .vsn-value {
        position: relative; overflow: hidden; padding: 22px; border: 1px solid var(--v-line); border-radius: 18px; background: #fff;
        transition: transform .2s, box-shadow .2s, border-color .2s;
    }
    .vsn-value::before {
        content: ""; position: absolute; left: 0; top: 0; height: 3px; width: 0; background: var(--v-lime); transition: width .3s;
    }
    .vsn-value:hover { transform: translateY(-4px); border-color: var(--v-green); box-shadow: 0 20px 40px -20px rgba(5, 26, 19, .25); }
    .vsn-value:hover::before { width: 100%; }
    .vsn-value:hover .vsn-ic { background: var(--v-ink); color: var(--v-lime); }
    .vsn-value .vsn-ic { transition: background .2s, color .2s; }
    .vsn-value-top { display: flex; align-items: center; justify-content: space-between; }
    .vsn-value-num { font-size: 28px; font-weight: 800; line-height: 1; color: rgba(15, 74, 53, .1); letter-spacing: -.02em; }
    .vsn-value h3 { margin-top: 18px; font-size: 16px; font-weight: 700; }
    .vsn-value p { margin-top: 6px; font-size: 12px; line-height: 20px; color: var(--v-slate-500); }

    /* =========================================================
       ROADMAP (timeline)
    ========================================================= */
    .vsn-road { position: relative; display: grid; gap: 14px; padding-left: 28px; }
    .vsn-road::before {
        content: ""; position: absolute; left: 9px; top: 8px; bottom: 8px; width: 2px;
        background: linear-gradient(180deg, var(--v-lime), rgba(255, 255, 255, .1));
    }
    .vsn-step { position: relative; }
    .vsn-step-pin {
        position: absolute; left: -28px; top: 22px; width: 20px; height: 20px; border-radius: 50%;
        background: var(--v-ink); border: 2px solid rgba(255, 255, 255, .25);
    }
    .vsn-step.is-now .vsn-step-pin { border-color: var(--v-lime); background: var(--v-lime); box-shadow: 0 0 0 6px rgba(200, 245, 66, .15); }
    .vsn-step-card {
        height: 100%; padding: 22px; border: 1px solid rgba(255, 255, 255, .1); border-radius: 20px; background: rgba(255, 255, 255, .04);
        transition: border-color .2s;
    }
    .vsn-step-card:hover { border-color: rgba(200, 245, 66, .35); }
    .vsn-step.is-now .vsn-step-card { border-color: rgba(200, 245, 66, .5); background: rgba(200, 245, 66, .06); }
    .vsn-step-top { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
    .vsn-step-num { font-size: 12px; font-weight: 800; letter-spacing: .14em; color: var(--v-lime); }
    .vsn-step-tag {
        padding: 5px 10px; border-radius: 999px; border: 1px solid rgba(255, 255, 255, .15);
        font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: .12em; color: rgba(255, 255, 255, .6);
    }
    .vsn-step.is-now .vsn-step-tag { border-color: transparent; background: var(--v-lime); color: var(--v-ink); }
    .vsn-step h3 { margin-top: 14px; font-size: 18px; font-weight: 800; color: #fff; }
    .vsn-step p { margin-top: 6px; font-size: 12px; line-height: 20px; color: rgba(255, 255, 255, .55); }
    .vsn-progress { margin-top: 16px; height: 4px; border-radius: 999px; background: rgba(255, 255, 255, .08); overflow: hidden; }
    .vsn-progress span { display: block; height: 100%; border-radius: 999px; background: var(--v-lime); }
    .vsn-step ul { margin-top: 16px; display: grid; gap: 8px; }
    .vsn-step li { display: flex; align-items: center; gap: 8px; font-size: 12px; color: rgba(255, 255, 255, .8); }

    /* =========================================================
       IMPACT
    ========================================================= */
    .vsn-impact-grid { display: grid; gap: 28px; align-items: stretch; }
    .vsn-impact-list { display: grid; gap: 12px; }
    .vsn-impact {
        display: flex; gap: 14px; align-items: flex-start; padding: 18px;
        border: 1px solid var(--v-line); border-radius: 18px; background: var(--v-bg);
        transition: border-color .2s, background .2s;
    }
    .vsn-impact:hover { border-color: var(--v-green); background: #fff; }
    .vsn-impact .vsn-ic { background: #fff; }
    .vsn-impact h3 { font-size: 15px; font-weight: 700; }
    .vsn-impact p { margin-top: 4px; font-size: 12px; line-height: 20px; color: var(--v-slate-500); }

    .vsn-cats {
        display: flex; flex-direction: column; padding: 26px; border-radius: 24px; color: #fff;
        background: radial-gradient(420px 220px at 100% 0%, rgba(200, 245, 66, .16), transparent 70%), var(--v-ink);
        box-shadow: 0 25px 50px -12px rgba(5, 26, 19, .3);
    }
    .vsn-cats h3 { font-size: 20px; font-weight: 800; line-height: 1.3; }
    .vsn-cats h3 span { color: var(--v-lime); }
    .vsn-cats > p { margin-top: 6px; font-size: 12px; line-height: 20px; color: rgba(255, 255, 255, .55); }
    .vsn-cat-grid { margin-top: 18px; display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .vsn-cat {
        display: flex; align-items: center; gap: 10px; padding: 12px;
        border: 1px solid rgba(255, 255, 255, .1); border-radius: 14px; background: rgba(255, 255, 255, .05);
        font-size: 12px; font-weight: 600; color: #fff;
        transition: border-color .2s, background .2s;
    }
    .vsn-cat:hover { border-color: rgba(200, 245, 66, .45); background: rgba(200, 245, 66, .08); }
    .vsn-cat span { display: flex; align-items: center; justify-content: center; width: 30px; height: 30px; border-radius: 8px; background: var(--v-lime); color: var(--v-ink); flex-shrink: 0; }
    .vsn-cat svg { width: 16px; height: 16px; }
    .vsn-cats-foot {
        margin-top: auto; padding-top: 18px; display: flex; align-items: center; justify-content: space-between; gap: 12px;
        font-size: 12px; color: rgba(255, 255, 255, .6);
    }
    .vsn-cats-foot a { display: inline-flex; align-items: center; gap: 6px; font-weight: 800; color: var(--v-lime); }
    .vsn-cats-foot svg { width: 15px; height: 15px; }

    /* =========================================================
       CTA
    ========================================================= */
    .vsn-cta {
        position: relative; overflow: hidden; display: grid; gap: 20px; align-items: center;
        padding: 30px 22px; border-radius: 26px; color: #fff;
        background:
            radial-gradient(480px 240px at 100% 100%, rgba(200, 245, 66, .2), transparent 70%),
            linear-gradient(140deg, var(--v-green), var(--v-ink));
    }
    .vsn-cta .vsn-kicker { color: var(--v-lime); }
    .vsn-cta h2 { margin-top: 10px; font-size: 26px; font-weight: 800; line-height: 1.2; letter-spacing: -.025em; }
    .vsn-cta h2 span { color: var(--v-lime); }
    .vsn-cta p { margin-top: 8px; max-width: 32rem; font-size: 13px; line-height: 22px; color: rgba(255, 255, 255, .65); }
    .vsn-cta .vsn-actions { margin-top: 0; }

    /* =========================================================
       RESPONSIVE
    ========================================================= */
    @media (max-width: 639px) {
        .vsn-pillars { grid-template-columns: 1fr; }
        .vsn-pillar { display: flex; align-items: center; gap: 12px; }
        .vsn-pillar strong { margin-top: 0; }
    }
    @media (min-width: 640px) {
        .vsn-container { padding: 0 24px; }
        .vsn-banner { padding: 40px 36px; }
        .vsn-title { font-size: 42px; }
        .vsn-h2 { font-size: 32px; }
        .vsn-stats { grid-template-columns: repeat(4, 1fr); }
        .vsn-stat { border-bottom: 0; }
        .vsn-stat:nth-child(odd) { border-right: 0; }
        .vsn-stat + .vsn-stat { border-left: 1px solid var(--v-line); }
        .vsn-values { grid-template-columns: repeat(2, 1fr); }
        .vsn-cat-grid { grid-template-columns: repeat(3, 1fr); }
        .vsn-cta { padding: 40px 36px; }
        .vsn-cta h2 { font-size: 32px; }
    }
    @media (min-width: 1024px) {
        .vsn-container { padding: 0 32px; }
        .vsn-section { padding: 64px 0; }
        .vsn-hero { padding: 24px 0 8px; }
        .vsn-banner { grid-template-columns: 1.1fr .9fr; gap: 48px; padding: 48px; }
        .vsn-title { font-size: 50px; }
        .vsn-mv-grid { grid-template-columns: 1fr 1fr; }
        .vsn-values { grid-template-columns: repeat(3, 1fr); }

        /* Timeline horizontal */
        .vsn-road { grid-template-columns: repeat(3, 1fr); gap: 20px; padding-left: 0; padding-top: 34px; }
        .vsn-road::before {
            left: 16px; right: 16px; top: 9px; bottom: auto; width: auto; height: 2px;
            background: linear-gradient(90deg, var(--v-lime), rgba(255, 255, 255, .1));
        }
        .vsn-step-pin { left: 22px; top: -34px; }

        .vsn-impact-grid { grid-template-columns: 1fr 1fr; gap: 40px; }
        .vsn-cta { grid-template-columns: 1fr auto; gap: 32px; padding: 44px 48px; }
    }
    @media (prefers-reduced-motion: reduce) {
        .vsn-value, .vsn-value::before, .vsn-btn, .vsn-pillar, .vsn-cat, .vsn-impact, .vsn-step-card { transition: none; }
        .vsn-value:hover, .vsn-btn-lime:hover { transform: none; }
    }
</style>

@php
    // Chhote inline SVG icons (kisi library ki zaroorat nahi)
    $svg = function ($path) {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">' . $path . '</svg>';
    };
    $icons = [
        'eye'      => $svg('<path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/><circle cx="12" cy="12" r="3"/>'),
        'target'   => $svg('<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1"/>'),
        'leaf'     => $svg('<path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.5 19 2c1 2 2 4.2 2 8 0 5.5-4.8 10-10 10z"/><path d="M2 21c0-3 1.9-5.4 5.1-6"/>'),
        'shield'   => $svg('<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/>'),
        'users'    => $svg('<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.9"/><path d="M16 3.1a4 4 0 0 1 0 7.8"/>'),
        'bolt'     => $svg('<path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z"/>'),
        'map'      => $svg('<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/>'),
        'chart'    => $svg('<path d="M3 3v18h18"/><path d="m7 15 4-4 3 3 5-6"/>'),
        'wallet'   => $svg('<path d="M20 12V8H6a2 2 0 0 1 0-4h12v4"/><path d="M4 6v12a2 2 0 0 0 2 2h14v-4"/><path d="M18 12a2 2 0 0 0 0 4h4v-4z"/>'),
        'grid'     => $svg('<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>'),
        'headset'  => $svg('<path d="M3 14v-2a9 9 0 0 1 18 0v2"/><path d="M21 16a2 2 0 0 1-2 2h-1v-6h1a2 2 0 0 1 2 2z"/><path d="M3 16a2 2 0 0 0 2 2h1v-6H5a2 2 0 0 0-2 2z"/>'),
        'arrow'    => $svg('<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>'),
        'car'      => $svg('<path d="M19 17h2v-4l-2-5H5L3 13v4h2"/><circle cx="7.5" cy="17.5" r="2"/><circle cx="16.5" cy="17.5" r="2"/><path d="M9.5 17.5h5"/>'),
        'bike'     => $svg('<circle cx="5.5" cy="17.5" r="3.5"/><circle cx="18.5" cy="17.5" r="3.5"/><path d="M15 6h2l2 11.5"/><path d="m5.5 17.5 4-7.5h6"/>'),
        'scooter'  => $svg('<circle cx="5.5" cy="17.5" r="2.5"/><circle cx="18.5" cy="17.5" r="2.5"/><path d="M8 17.5h7.5l2-7H14"/><path d="M14 4h2.5l2 6.5"/><path d="M3 13h6l2 4.5"/>'),
        'rickshaw' => $svg('<path d="M3 16V8a3 3 0 0 1 3-3h8l3 5h2a2 2 0 0 1 2 2v4"/><path d="M3 10h14"/><circle cx="6.5" cy="17" r="2"/><circle cx="17.5" cy="17" r="2"/><path d="M8.5 17h7"/>'),
        'truck'    => $svg('<path d="M1 4h13v12H1z"/><path d="M14 9h4l3 3v4h-7z"/><circle cx="5.5" cy="18.5" r="2"/><circle cx="17.5" cy="18.5" r="2"/>'),
    ];

    $values = [
        ['icon' => 'shield', 'title' => 'Trust First',        'text' => 'Every account and listing is verified, so riders and owners can deal with confidence.'],
        ['icon' => 'leaf',   'title' => 'Clean Mobility',     'text' => 'We push electric options forward and help partners make the switch to EVs.'],
        ['icon' => 'users',  'title' => 'Partner Growth',     'text' => 'Our partners are our foundation. When they grow, the whole network grows.'],
        ['icon' => 'wallet', 'title' => 'Fair & Transparent', 'text' => 'Clear pricing for renters and clear earnings for owners — no surprises.'],
        ['icon' => 'bolt',   'title' => 'Built for Speed',    'text' => 'Quick onboarding, instant booking and fast support at every step.'],
        ['icon' => 'map',    'title' => 'Local Everywhere',   'text' => 'From metros to smaller cities, mobility should be available close to home.'],
    ];

    $phases = [
        [
            'num' => 'PHASE 01', 'tag' => 'In progress', 'now' => true, 'progress' => 70,
            'title' => 'Build the Marketplace',
            'text'  => 'One platform for every vehicle category, with verified users and live availability.',
            'points'=> ['Cars, bikes, scooters, EVs, e-rickshaws & commercial', 'Owner & partner dashboards', 'Secure token-based accounts'],
        ],
        [
            'num' => 'PHASE 02', 'tag' => 'Next', 'now' => false, 'progress' => 25,
            'title' => 'Grow the Partner Network',
            'text'  => 'Franchise partners launch mobility hubs, fleets and charging points in their cities.',
            'points'=> ['EV franchise hubs', 'Fleet & charging partners', 'Delivery partner programs'],
        ],
        [
            'num' => 'PHASE 03', 'tag' => 'Future', 'now' => false, 'progress' => 5,
            'title' => 'Connected Mobility',
            'text'  => 'A nationwide, electric-first network where every trip is smart, tracked and sustainable.',
            'points'=> ['Smart fleet & live tracking', 'City-wide EV infrastructure', 'Mobility for every Indian city'],
        ],
    ];
@endphp

<div class="vsn">

    {{-- =========================================================
         HERO BANNER
    ========================================================== --}}
    <section class="vsn-hero">
        <div class="vsn-container">

            <div class="vsn-banner">

                {{-- Left: text --}}
                <div>
                    <nav class="vsn-crumb" aria-label="Breadcrumb">
                        <a href="{{ url('/') }}">Home</a> <span>/</span> <span>Vision</span>
                    </nav>

                    <div class="vsn-badge"><span class="vsn-dot"></span> Our Vision</div>

                    <h1 class="vsn-title">
                        Every vehicle, every city,
                        <span>one platform.</span>
                    </h1>

                    <p class="vsn-lead">
                        VEHILO is building India's most trusted mobility marketplace — where anyone can rent
                        the exact vehicle they need, and any owner or partner can turn a vehicle into a steady
                        business. Cleaner, simpler and open to everyone.
                    </p>

                    <div class="vsn-actions">
                        <a href="{{ url('/partner') }}" class="vsn-btn vsn-btn-lime">Become a Partner {!! $icons['arrow'] !!}</a>
                        <a href="{{ url('/about') }}" class="vsn-btn vsn-btn-ghost">About VEHILO</a>
                    </div>
                </div>

                {{-- Right: quote + pillars --}}
                <div>
                    <div class="vsn-quote">
                        <div class="vsn-quote-top">
                            <div class="vsn-quote-mark">“</div>
                            <span class="vsn-quote-tag">Our belief</span>
                        </div>
                        <blockquote>
                            Mobility should be <span>accessible, electric-first</span> and fair —
                            for the rider, the owner and the city.
                        </blockquote>
                        <p class="vsn-quote-by">— Team VEHILO</p>
                    </div>

                    <div class="vsn-pillars">
                        <div class="vsn-pillar">
                            <span>{!! $icons['leaf'] !!}</span>
                            <div><strong>Cleaner</strong><small>Electric-first</small></div>
                        </div>
                        <div class="vsn-pillar">
                            <span>{!! $icons['shield'] !!}</span>
                            <div><strong>Safer</strong><small>Verified people</small></div>
                        </div>
                        <div class="vsn-pillar">
                            <span>{!! $icons['users'] !!}</span>
                            <div><strong>Open</strong><small>For everyone</small></div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Stats strip --}}
            <div class="vsn-stats">
                <div class="vsn-stat"><div class="vsn-ic">{!! $icons['grid'] !!}</div><div><strong>6</strong><small>Vehicle categories</small></div></div>
                <div class="vsn-stat"><div class="vsn-ic">{!! $icons['map'] !!}</div><div><strong>PAN India</strong><small>Partner network</small></div></div>
                <div class="vsn-stat"><div class="vsn-ic">{!! $icons['bolt'] !!}</div><div><strong>EV-first</strong><small>Mobility focus</small></div></div>
                <div class="vsn-stat"><div class="vsn-ic">{!! $icons['headset'] !!}</div><div><strong>24/7</strong><small>Platform & support</small></div></div>
            </div>

        </div>
    </section>


    {{-- =========================================================
         MISSION + VISION
    ========================================================== --}}
    <section class="vsn-section">
        <div class="vsn-container">

            <div class="vsn-head vsn-head-row">
                <div>
                    <span class="vsn-kicker"><span class="vsn-dot"></span> What drives us</span>
                    <h2 class="vsn-h2">A clear purpose, <span>a bigger picture.</span></h2>
                </div>
                <p class="vsn-sub">Our mission is what we do every day. Our vision is where it all leads.</p>
            </div>

            <div class="vsn-mv-grid">

                <div class="vsn-mv-card is-light">
                    <div class="vsn-mv-watermark">{!! $icons['target'] !!}</div>
                    <div class="vsn-mv-top">
                        <div class="vsn-ic">{!! $icons['target'] !!}</div>
                        <p class="vsn-mv-label">Our Mission</p>
                    </div>
                    <h3>Make renting and listing any vehicle simple, safe and transparent.</h3>
                    <p>
                        We connect riders, vehicle owners and franchise partners on one platform —
                        with verified people, fair pricing and real-time availability.
                    </p>
                    <ul class="vsn-mv-list">
                        <li>Verified owners, renters and partners</li>
                        <li>Upfront pricing with no hidden charges</li>
                        <li>One dashboard for bookings and earnings</li>
                    </ul>
                </div>

                <div class="vsn-mv-card is-dark">
                    <div class="vsn-mv-watermark">{!! $icons['eye'] !!}</div>
                    <div class="vsn-mv-top">
                        <div class="vsn-ic">{!! $icons['eye'] !!}</div>
                        <p class="vsn-mv-label">Our Vision</p>
                    </div>
                    <h3>A connected, electric-first mobility network across every Indian city.</h3>
                    <p>
                        We see a future where getting a vehicle is as easy as ordering a meal — and where
                        local partners grow alongside the shift to clean mobility.
                    </p>
                    <ul class="vsn-mv-list">
                        <li>EV rentals, charging and hubs in every city</li>
                        <li>Local businesses powering local mobility</li>
                        <li>Less pollution, more livelihoods</li>
                    </ul>
                </div>

            </div>
        </div>
    </section>


    {{-- =========================================================
         CORE VALUES
    ========================================================== --}}
    <section class="vsn-section vsn-white">
        <div class="vsn-container">

            <div class="vsn-head vsn-head-center">
                <span class="vsn-kicker"><span class="vsn-dot"></span> Core values</span>
                <h2 class="vsn-h2">What we <span>stand for.</span></h2>
                <p class="vsn-sub">These principles guide every feature we build and every partner we bring on board.</p>
            </div>

            <div class="vsn-values">
                @foreach($values as $i => $value)
                    <div class="vsn-value">
                        <div class="vsn-value-top">
                            <div class="vsn-ic">{!! $icons[$value['icon']] !!}</div>
                            <span class="vsn-value-num">{{ sprintf('%02d', $i + 1) }}</span>
                        </div>
                        <h3>{{ $value['title'] }}</h3>
                        <p>{{ $value['text'] }}</p>
                    </div>
                @endforeach
            </div>

        </div>
    </section>


    {{-- =========================================================
         ROADMAP
    ========================================================== --}}
    <section class="vsn-section vsn-dark">
        <div class="vsn-container">

            <div class="vsn-head vsn-head-row">
                <div>
                    <span class="vsn-kicker"><span class="vsn-dot"></span> The road ahead</span>
                    <h2 class="vsn-h2">How we get <span>there.</span></h2>
                </div>
                <p class="vsn-sub">Our vision unfolds in three phases — each one building on the last.</p>
            </div>

            <div class="vsn-road">
                @foreach($phases as $phase)
                    <div class="vsn-step {{ $phase['now'] ? 'is-now' : '' }}">
                        <span class="vsn-step-pin"></span>
                        <div class="vsn-step-card">
                            <div class="vsn-step-top">
                                <span class="vsn-step-num">{{ $phase['num'] }}</span>
                                <span class="vsn-step-tag">{{ $phase['tag'] }}</span>
                            </div>
                            <h3>{{ $phase['title'] }}</h3>
                            <p>{{ $phase['text'] }}</p>
                            <div class="vsn-progress" aria-hidden="true"><span style="width: {{ $phase['progress'] }}%;"></span></div>
                            <ul>
                                @foreach($phase['points'] as $point)
                                    <li><span class="vsn-dot"></span> {{ $point }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>


    {{-- =========================================================
         IMPACT
    ========================================================== --}}
    <section class="vsn-section vsn-white">
        <div class="vsn-container">
            <div class="vsn-impact-grid">

                <div>
                    <div class="vsn-head" style="margin-bottom: 20px;">
                        <span class="vsn-kicker"><span class="vsn-dot"></span> The impact we want</span>
                        <h2 class="vsn-h2">Better for riders, owners <span>and cities.</span></h2>
                    </div>

                    <div class="vsn-impact-list">
                        <div class="vsn-impact">
                            <div class="vsn-ic">{!! $icons['leaf'] !!}</div>
                            <div>
                                <h3>Cleaner Air</h3>
                                <p>More electric trips on the road means less fuel burned and quieter, cleaner streets.</p>
                            </div>
                        </div>
                        <div class="vsn-impact">
                            <div class="vsn-ic">{!! $icons['chart'] !!}</div>
                            <div>
                                <h3>New Livelihoods</h3>
                                <p>Owners, fleet operators and franchise partners earn from vehicles that would otherwise sit idle.</p>
                            </div>
                        </div>
                        <div class="vsn-impact">
                            <div class="vsn-ic">{!! $icons['users'] !!}</div>
                            <div>
                                <h3>Access for Everyone</h3>
                                <p>Commuters, gig workers, businesses and tourists get the right vehicle without having to own one.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="vsn-cats">
                    <h3>Not just electric. <span>Every kind of vehicle.</span></h3>
                    <p>Our vision covers the full range of mobility needs — with EVs leading the way.</p>

                    <div class="vsn-cat-grid">
                        @foreach([
                            ['car', 'Cars'], ['bike', 'Bikes'], ['scooter', 'Scooters'],
                            ['bolt', 'Electric'], ['rickshaw', 'E-Rickshaws'], ['truck', 'Commercial'],
                        ] as [$ic, $label])
                            <a href="{{ url('/vehicles') }}" class="vsn-cat"><span>{!! $icons[$ic] !!}</span> {{ $label }}</a>
                        @endforeach
                    </div>

                    <div class="vsn-cats-foot">
                        <span>One platform for every journey</span>
                        <a href="{{ url('/vehicles') }}">Explore {!! $icons['arrow'] !!}</a>
                    </div>
                </div>

            </div>
        </div>
    </section>


    {{-- =========================================================
         CTA
    ========================================================== --}}
    <section class="vsn-section">
        <div class="vsn-container">
            <div class="vsn-cta">
                <div>
                    <span class="vsn-kicker"><span class="vsn-dot"></span> Be part of it</span>
                    <h2>Let's build the future of mobility <span>together.</span></h2>
                    <p>Rent a vehicle, list your own, or partner with VEHILO to bring smarter mobility to your city.</p>
                </div>

                <div class="vsn-actions">
                    <a href="{{ url('/partner') }}" class="vsn-btn vsn-btn-lime">Become a Partner {!! $icons['arrow'] !!}</a>
                    <a href="{{ url('/contact') }}" class="vsn-btn vsn-btn-ghost">Contact Us</a>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection