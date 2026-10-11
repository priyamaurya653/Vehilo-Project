@extends('frontlayout.main')

@section('title', 'Careers – Wheelo | Join Our Team')

@section('content')

{{-- =========================================================
     CAREERS PAGE CSS (sirf is page ke liye)
========================================================== --}}
<style>
    .car {
        --v-bg: #F0F7F3;
        --v-ink: #051A13;
        --v-green: #0F4A35;
        --v-lime: #C8F542;
        --v-lime-hover: #B5E62C;
        --v-line: #DCEBE2;
        --v-slate-400: #94a3b8;
        --v-slate-500: #64748b;
        --v-slate-600: #475569;
        background: var(--v-bg);
        color: var(--v-ink);
    }

    .car *,
    .car *::before,
    .car *::after {
        box-sizing: border-box;
    }

    .car h1,
    .car h2,
    .car h3,
    .car p {
        margin: 0;
    }

    .car ul {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .car a {
        text-decoration: none;
    }

    .car button,
    .car input,
    .car select,
    .car textarea {
        font: inherit;
    }

    .car [hidden] {
        display: none !important;
    }

    .car-container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .car-section {
        padding: 48px 0;
    }

    .car-white {
        background: #fff;
    }

    .car-dark {
        background: var(--v-ink);
        color: #fff;
    }

    .car-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--v-lime);
        flex-shrink: 0;
    }

    .car-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .22em;
        color: var(--v-green);
    }

    .car-dark .car-kicker {
        color: var(--v-lime);
    }

    .car-h2 {
        margin-top: 10px;
        font-size: 28px;
        font-weight: 800;
        line-height: 1.2;
        letter-spacing: -.025em;
    }

    .car-h2 span {
        color: var(--v-green);
    }

    .car-dark .car-h2 {
        color: #fff;
    }

    .car-dark .car-h2 span {
        color: var(--v-lime);
    }

    .car-sub {
        margin-top: 10px;
        max-width: 40rem;
        font-size: 14px;
        line-height: 24px;
        color: var(--v-slate-600);
    }

    .car-dark .car-sub {
        color: rgba(255, 255, 255, .6);
    }

    .car-head {
        max-width: 42rem;
        margin-bottom: 24px;
    }

    .car-head-row {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        justify-content: space-between;
        gap: 16px;
        max-width: none;
    }

    .car-head-row .car-sub {
        max-width: 26rem;
        margin-top: 0;
    }

    .car-head-center {
        margin-left: auto;
        margin-right: auto;
        text-align: center;
    }

    .car-head-center .car-sub {
        margin-left: auto;
        margin-right: auto;
    }

    .car svg {
        width: 16px;
        height: 16px;
        flex-shrink: 0;
    }

    /* default size – koi icon bada na ho */
    .car-ic {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: var(--v-bg);
        color: var(--v-green);
    }

    .car-ic svg {
        width: 22px;
        height: 22px;
    }

    /* Buttons */
    .car-actions {
        margin-top: 24px;
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .car-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        height: 48px;
        padding: 0 22px;
        border: 0;
        border-radius: 12px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 800;
        transition: transform .15s, background .15s, border-color .15s, color .15s;
    }

    .car-btn svg {
        width: 16px;
        height: 16px;
    }

    .car-btn-sm {
        height: 38px;
        padding: 0 14px;
        font-size: 12px;
        border-radius: 10px;
    }

    .car-btn-lime {
        background: var(--v-lime);
        color: var(--v-ink);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, .12);
    }

    .car-btn-lime:hover {
        background: var(--v-lime-hover);
        transform: translateY(-2px);
    }

    .car-btn-ghost {
        border: 1px solid rgba(255, 255, 255, .2);
        background: transparent;
        color: #fff;
    }

    .car-btn-ghost:hover {
        background: rgba(255, 255, 255, .08);
        border-color: rgba(255, 255, 255, .35);
    }

    .car-btn-soft {
        border: 1px solid var(--v-line);
        background: #fff;
        color: var(--v-green);
    }

    .car-btn-soft:hover {
        background: var(--v-ink);
        border-color: var(--v-ink);
        color: var(--v-lime);
    }

    /* =========================================================
       HERO BANNER
    ========================================================= */
    .car-hero {
        padding: 20px 0 8px;
    }

    .car-banner {
        position: relative;
        overflow: hidden;
        display: grid;
        gap: 28px;
        align-items: center;
        padding: 30px 20px;
        border-radius: 28px;
        color: #fff;
        background:
            radial-gradient(520px 260px at 100% 0%, rgba(200, 245, 66, .22), transparent 70%),
            radial-gradient(420px 240px at 0% 100%, rgba(15, 74, 53, .9), transparent 70%),
            var(--v-ink);
        box-shadow: 0 30px 60px -30px rgba(5, 26, 19, .55);
    }

    .car-banner::after {
        content: "";
        position: absolute;
        inset: 0;
        pointer-events: none;
        opacity: .5;
        background-image: radial-gradient(rgba(255, 255, 255, .08) 1px, transparent 1px);
        background-size: 18px 18px;
        mask-image: linear-gradient(90deg, transparent, #000 60%);
        -webkit-mask-image: linear-gradient(90deg, transparent, #000 60%);
    }

    .car-banner>* {
        position: relative;
        z-index: 1;
        min-width: 0;
    }

    .car-crumb {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 14px;
        font-size: 12px;
        color: rgba(255, 255, 255, .5);
    }

    .car-crumb a {
        color: rgba(255, 255, 255, .7);
    }

    .car-crumb a:hover {
        color: var(--v-lime);
    }

    .car-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 16px;
        padding: 6px 12px;
        border: 1px solid rgba(255, 255, 255, .14);
        border-radius: 999px;
        background: rgba(255, 255, 255, .06);
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .16em;
        color: var(--v-lime);
    }

    .car-title {
        font-size: 34px;
        font-weight: 800;
        line-height: 1.08;
        letter-spacing: -.035em;
        color: #fff;
    }

    .car-title span {
        color: var(--v-lime);
    }

    .car-lead {
        margin-top: 16px;
        max-width: 34rem;
        font-size: 14px;
        line-height: 24px;
        color: rgba(255, 255, 255, .68);
    }

    .car-hero-stats {
        margin-top: 24px;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        max-width: 34rem;
    }

    .car-hero-stat {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px;
        border: 1px solid rgba(255, 255, 255, .1);
        border-radius: 14px;
        background: rgba(255, 255, 255, .05);
    }

    .car-hero-stat span {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: rgba(200, 245, 66, .14);
        color: var(--v-lime);
    }

    .car-hero-stat svg {
        width: 16px;
        height: 16px;
    }

    .car-hero-stat strong {
        display: block;
        font-size: 16px;
        font-weight: 800;
        line-height: 1.1;
    }

    .car-hero-stat small {
        font-size: 10px;
        color: rgba(255, 255, 255, .55);
    }

    /* Team preview (tabs) */
    .car-preview {
        padding: 18px;
        border-radius: 22px;
        background: #fff;
        color: var(--v-ink);
        box-shadow: 0 24px 50px -20px rgba(0, 0, 0, .5);
    }

    .car-preview-label {
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .18em;
        color: var(--v-slate-500);
    }

    .car-tabs {
        margin-top: 12px;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
    }

    .car-tab {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 6px;
        min-height: 72px;
        padding: 10px 6px;
        border: 1px solid var(--v-line);
        border-radius: 14px;
        background: var(--v-bg);
        color: var(--v-slate-600);
        cursor: pointer;
        text-align: center;
        font-size: 11px;
        font-weight: 700;
        line-height: 1.25;
        transition: background .15s, border-color .15s, color .15s, transform .15s;
    }

    .car-tab svg {
        width: 18px;
        height: 18px;
    }

    .car-tab:hover {
        border-color: var(--v-green);
        color: var(--v-ink);
        transform: translateY(-2px);
    }

    .car-tab.is-active {
        background: var(--v-ink);
        border-color: var(--v-ink);
        color: var(--v-lime);
    }

    .car-tab:focus-visible {
        outline: 2px solid var(--v-green);
        outline-offset: 2px;
    }

    .car-panel {
        margin-top: 12px;
        padding: 18px;
        border-radius: 16px;
        color: #fff;
        background: radial-gradient(300px 160px at 100% 0%, rgba(200, 245, 66, .16), transparent 70%), var(--v-ink);
        animation: car-fade .25s ease;
    }

    @keyframes car-fade {
        from {
            opacity: .4;
            transform: translateY(4px);
        }

        to {
            opacity: 1;
            transform: none;
        }
    }

    .car-panel-head {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .car-panel-ic {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: var(--v-lime);
        color: var(--v-ink);
        flex-shrink: 0;
    }

    .car-panel-ic svg {
        width: 20px;
        height: 20px;
    }

    .car-panel-head strong {
        display: block;
        font-size: 15px;
        font-weight: 800;
    }

    .car-panel-live {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        color: rgba(255, 255, 255, .6);
    }

    .car-panel-live::before {
        content: "";
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #4ade80;
        box-shadow: 0 0 0 3px rgba(74, 222, 128, .2);
    }

    .car-panel-desc {
        margin-top: 12px;
        font-size: 13px;
        line-height: 21px;
        color: rgba(255, 255, 255, .75);
    }

    .car-panel-meta {
        margin-top: 14px;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
        padding-top: 14px;
        border-top: 1px solid rgba(255, 255, 255, .1);
    }

    .car-panel-meta strong {
        display: block;
        font-size: 14px;
        font-weight: 800;
        color: var(--v-lime);
        line-height: 1.2;
    }

    .car-panel-meta small {
        font-size: 10px;
        color: rgba(255, 255, 255, .5);
    }

    .car-panel-roles {
        margin-top: 14px;
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .car-panel-roles span {
        padding: 5px 10px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .08);
        font-size: 11px;
        color: rgba(255, 255, 255, .85);
    }

    .car-panel .car-btn {
        margin-top: 16px;
        width: 100%;
    }

    /* Hiring for chips */
    .car-chips-bar {
        margin-top: 14px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px 14px;
        padding: 12px 16px;
        border: 1px solid var(--v-line);
        border-radius: 18px;
        background: #fff;
    }

    .car-chips-bar>span {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .18em;
        color: var(--v-green);
    }

    .car-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .car-chip {
        padding: 5px 12px;
        border: 1px solid var(--v-line);
        border-radius: 999px;
        background: var(--v-bg);
        font-size: 12px;
        font-weight: 600;
        color: var(--v-slate-600);
    }

    /* =========================================================
       DEPARTMENTS
    ========================================================= */
    .car-depts {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .car-dept {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
        padding: 18px;
        border: 1px solid var(--v-line);
        border-radius: 18px;
        background: #fff;
        color: var(--v-ink);
        cursor: pointer;
        text-align: left;
        transition: transform .15s, border-color .15s, box-shadow .15s;
    }

    .car-dept:hover {
        transform: translateY(-3px);
        border-color: var(--v-green);
        box-shadow: 0 18px 36px -20px rgba(5, 26, 19, .3);
    }

    .car-dept:hover .car-ic {
        background: var(--v-ink);
        color: var(--v-lime);
    }

    .car-dept .car-ic {
        transition: background .15s, color .15s;
    }

    .car-dept strong {
        font-size: 14px;
        font-weight: 700;
        line-height: 1.3;
    }

    .car-dept small {
        margin-top: auto;
        width: 100%;
        padding-top: 12px;
        border-top: 1px dashed var(--v-line);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        white-space: nowrap;
        font-size: 12px;
        font-weight: 700;
        color: var(--v-green);
    }

    .car-dept small svg {
        width: 28px;
        height: 28px;
        padding: 7px;
        border-radius: 50%;
        background: var(--v-bg);
        color: var(--v-green);
        transition: background .15s, color .15s, transform .15s;
    }

    .car-dept:hover small svg {
        background: var(--v-lime);
        color: var(--v-ink);
        transform: translateX(3px);
    }

    /* =========================================================
       OPENINGS
    ========================================================= */
    .car-filters {
        display: flex;
        gap: 8px;
        overflow-x: auto;
        padding-bottom: 4px;
        margin-bottom: 18px;
        scrollbar-width: thin;
    }

    .car-filter {
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        height: 36px;
        padding: 0 14px;
        border: 1px solid var(--v-line);
        border-radius: 999px;
        background: #fff;
        cursor: pointer;
        font-size: 12px;
        font-weight: 700;
        color: var(--v-slate-600);
        transition: background .15s, color .15s, border-color .15s;
    }

    .car-filter em {
        font-style: normal;
        padding: 1px 7px;
        border-radius: 999px;
        background: var(--v-bg);
        font-size: 10px;
        color: var(--v-green);
    }

    .car-filter:hover {
        border-color: var(--v-green);
        color: var(--v-ink);
    }

    .car-filter.is-active {
        background: var(--v-ink);
        border-color: var(--v-ink);
        color: #fff;
    }

    .car-filter.is-active em {
        background: var(--v-lime);
        color: var(--v-ink);
    }

    .car-jobs {
        display: grid;
        gap: 14px;
    }

    .car-job {
        display: flex;
        flex-direction: column;
        padding: 18px;
        border: 1px solid var(--v-line);
        border-radius: 18px;
        background: #fff;
        transition: transform .15s, border-color .15s, box-shadow .15s;
    }

    .car-job:hover {
        transform: translateY(-3px);
        border-color: var(--v-green);
        box-shadow: 0 18px 36px -20px rgba(5, 26, 19, .3);
    }

    .car-job-top {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .car-job-top .car-ic {
        width: 42px;
        height: 42px;
        background: var(--v-ink);
        color: var(--v-lime);
    }

    .car-job-top .car-ic svg {
        width: 20px;
        height: 20px;
    }

    .car-job-tag {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 6px;
        background: var(--v-bg);
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: var(--v-green);
    }

    .car-job h3 {
        margin-top: 6px;
        font-size: 16px;
        font-weight: 800;
        line-height: 1.3;
    }

    .car-job-specs {
        margin: 14px 0 16px;
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .car-job-specs li {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 9px;
        border-radius: 8px;
        background: var(--v-bg);
        font-size: 11px;
        font-weight: 600;
        color: var(--v-slate-600);
    }

    .car-job-specs svg {
        width: 13px;
        height: 13px;
        color: var(--v-green);
    }

    .car-job-foot {
        margin-top: auto;
        padding-top: 14px;
        border-top: 1px dashed var(--v-line);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .car-salary strong {
        display: block;
        font-size: 15px;
        font-weight: 800;
        color: var(--v-green);
    }

    .car-salary small {
        font-size: 10px;
        color: var(--v-slate-500);
    }

    .car-empty {
        padding: 32px 20px;
        border: 1px dashed var(--v-line);
        border-radius: 18px;
        background: #fff;
        text-align: center;
        font-size: 13px;
        color: var(--v-slate-500);
    }

    .car-empty a {
        font-weight: 800;
        color: var(--v-green);
    }

    .car-more {
        margin-top: 16px;
        text-align: center;
        font-size: 13px;
        color: var(--v-slate-500);
    }

    .car-more a {
        font-weight: 800;
        color: var(--v-green);
    }

    .car-more a:hover {
        text-decoration: underline;
    }

    /* =========================================================
       PERKS
    ========================================================= */
    .car-perks {
        display: grid;
        gap: 12px;
    }

    .car-perk {
        padding: 20px;
        border: 1px solid rgba(255, 255, 255, .1);
        border-radius: 18px;
        background: rgba(255, 255, 255, .04);
        transition: border-color .15s;
    }

    .car-perk:hover {
        border-color: rgba(200, 245, 66, .4);
    }

    .car-perk .car-ic {
        background: rgba(200, 245, 66, .14);
        color: var(--v-lime);
    }

    .car-perk h3 {
        margin-top: 16px;
        font-size: 15px;
        font-weight: 700;
        color: #fff;
    }

    .car-perk p {
        margin-top: 6px;
        font-size: 12px;
        line-height: 20px;
        color: rgba(255, 255, 255, .55);
    }

    .car-perk-bar {
        margin-top: 16px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 14px 18px;
        border-radius: 16px;
        background: var(--v-lime);
        color: var(--v-ink);
    }

    .car-perk-bar ul {
        display: flex;
        flex-wrap: wrap;
        gap: 6px 18px;
        font-size: 12px;
        font-weight: 700;
    }

    .car-perk-bar li {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .car-perk-bar li::before {
        content: "";
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--v-ink);
    }

    .car-perk-bar .car-btn {
        background: var(--v-ink);
        color: var(--v-lime);
        box-shadow: none;
    }

    .car-perk-bar .car-btn:hover {
        background: var(--v-green);
    }

    /* =========================================================
       PROCESS
    ========================================================= */
    .car-steps {
        display: grid;
        gap: 12px;
        counter-reset: step;
    }

    .car-step {
        position: relative;
        padding: 20px;
        border: 1px solid var(--v-line);
        border-radius: 18px;
        background: #fff;
    }

    .car-step-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .car-step-num {
        font-size: 30px;
        font-weight: 800;
        line-height: 1;
        color: rgba(15, 74, 53, .12);
    }

    .car-step h3 {
        margin-top: 14px;
        font-size: 15px;
        font-weight: 700;
    }

    .car-step p {
        margin-top: 6px;
        font-size: 12px;
        line-height: 20px;
        color: var(--v-slate-500);
    }

    .car-step-time {
        display: inline-block;
        margin-top: 12px;
        padding: 3px 9px;
        border-radius: 999px;
        background: var(--v-bg);
        font-size: 10px;
        font-weight: 700;
        color: var(--v-green);
    }

    /* =========================================================
       OFFICES
    ========================================================= */
    .car-offices {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .car-office {
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        gap: 2px;
        min-height: 110px;
        padding: 16px;
        border-radius: 18px;
        color: #fff;
        background: linear-gradient(160deg, var(--v-green), var(--v-ink));
    }

    .car-office span {
        position: absolute;
        left: 16px;
        top: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: var(--v-lime);
        color: var(--v-ink);
    }

    .car-office span svg {
        width: 15px;
        height: 15px;
    }

    .car-office strong {
        font-size: 15px;
        font-weight: 800;
    }

    .car-office small {
        font-size: 11px;
        color: rgba(255, 255, 255, .6);
    }

    .car-office.is-hq {
        background: var(--v-lime);
        color: var(--v-ink);
    }

    .car-office.is-hq span {
        background: var(--v-ink);
        color: var(--v-lime);
    }

    .car-office.is-hq small {
        color: var(--v-green);
        font-weight: 700;
    }

    /* =========================================================
       APPLICATION FORM
    ========================================================= */
    .car-apply {
        display: grid;
        overflow: hidden;
        border: 1px solid var(--v-line);
        border-radius: 26px;
        background: #fff;
        box-shadow: 0 30px 60px -36px rgba(5, 26, 19, .35);
    }

    .car-apply-side {
        position: relative;
        overflow: hidden;
        padding: 26px;
        color: #fff;
        background: radial-gradient(360px 200px at 100% 0%, rgba(200, 245, 66, .18), transparent 70%), var(--v-ink);
    }

    .car-apply-side h3 {
        margin-top: 12px;
        font-size: 22px;
        font-weight: 800;
        line-height: 1.25;
    }

    .car-apply-side h3 span {
        color: var(--v-lime);
    }

    .car-apply-side>p {
        margin-top: 1px;
        margin-bottom: 5px;
        font-size: 13px;
        line-height: 21px;
        color: rgba(255, 255, 255, .6);
    }

    .car-apply-steps {
        margin-top: 20px;
        display: grid;
        gap: 12px;
    }

    .car-apply-steps li {
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }

    .car-apply-steps b {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 26px;
        height: 26px;
        border-radius: 8px;
        background: rgba(200, 245, 66, .14);
        color: var(--v-lime);
        font-size: 12px;
    }

    .car-apply-steps strong {
        display: block;
        font-size: 13px;
    }

    .car-apply-steps small {
        font-size: 11px;
        color: rgba(255, 255, 255, .55);
    }

    .car-apply-contact {
        margin-top: 20px;
        padding: 14px;
        border: 1px solid rgba(255, 255, 255, .1);
        border-radius: 14px;
        background: rgba(255, 255, 255, .05);
        font-size: 12px;
        color: rgba(255, 255, 255, .7);
    }

    .car-apply-contact a {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 4px;
        font-weight: 800;
        color: var(--v-lime);
    }

    .car-apply-contact svg {
        width: 14px;
        height: 14px;
    }

    /* Left panel image (contact ke neeche) */
    .car-apply-side {
        display: flex;
        flex-direction: column;
    }

    .car-apply-photo {
        position: relative;
        overflow: hidden;
        flex: 1;
        min-height: 220px;
        margin-top: 16px;
        border: 1px solid rgba(255, 255, 255, .1);
        border-radius: 18px;
        background: radial-gradient(260px 160px at 80% 10%, rgba(200, 245, 66, .25), transparent 70%), linear-gradient(160deg, var(--v-green), #03110c);
    }

    .car-apply-photo img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .6s ease;
    }

    .car-apply-photo:hover img {
        transform: scale(1.05);
    }

    .car-apply-photo::after {
        content: "";
        position: absolute;
        inset: 0;
        pointer-events: none;
        background: linear-gradient(to top, rgba(5, 26, 19, .92) 0%, rgba(5, 26, 19, .25) 55%, transparent 100%);
    }

    .car-apply-photo-empty {
        position: absolute;
        left: 50%;
        top: 42%;
        transform: translate(-50%, -50%);
        display: flex;
        align-items: center;
        justify-content: center;
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: rgba(200, 245, 66, .14);
        color: var(--v-lime);
    }

    .car-apply-photo-empty svg {
        width: 26px;
        height: 26px;
    }

    .car-apply-photo figcaption {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 1;
        padding: 16px;
    }

    .car-apply-photo-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 999px;
        background: var(--v-lime);
        color: var(--v-ink);
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .08em;
    }

    .car-apply-photo figcaption strong {
        display: block;
        margin-top: 8px;
        font-size: 15px;
        font-weight: 800;
        line-height: 1.3;
        color: #fff;
    }

    .car-apply-photo figcaption small {
        display: block;
        margin-top: 2px;
        font-size: 11px;
        color: rgba(255, 255, 255, .65);
    }

    .car-form {
        padding: 24px 20px;
    }

    .car-form-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 18px;
    }

    .car-form-head h3 {
        font-size: 20px;
        font-weight: 800;
        letter-spacing: -.02em;
    }

    .car-form-head p {
        margin-top: 2px;
        font-size: 12px;
        color: var(--v-slate-500);
    }

    .car-form-pill {
        flex-shrink: 0;
        padding: 6px 10px;
        border-radius: 999px;
        background: var(--v-bg);
        font-size: 10px;
        font-weight: 700;
        color: var(--v-green);
    }

    .car-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
        padding: 12px 14px;
        border: 1px solid #bbf7d0;
        border-radius: 12px;
        background: #f0fdf4;
        font-size: 13px;
        color: #15803d;
    }

    .car-alert svg {
        width: 18px;
        height: 18px;
    }

    .car-alert-error {
        border-color: #fecaca;
        background: #fef2f2;
        color: #b91c1c;
    }

    .car-grid {
        display: grid;
        gap: 14px;
    }

    .car-field {
        min-width: 0;
    }

    .car-label {
        display: block;
        margin-bottom: 6px;
        font-size: 11px;
        font-weight: 700;
        color: var(--v-ink);
    }

    .car-label i {
        font-style: normal;
        color: #ef4444;
    }

    .car-label em {
        font-style: normal;
        font-weight: 500;
        color: var(--v-slate-400);
    }

    .car-input-wrap {
        position: relative;
    }

    .car-input-wrap>svg {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        width: 16px;
        height: 16px;
        color: var(--v-slate-400);
        pointer-events: none;
        transition: color .15s;
    }

    .car-input {
        width: 100%;
        height: 46px;
        padding: 0 14px 0 38px;
        border: 1px solid var(--v-line);
        border-radius: 12px;
        background: #fff;
        color: var(--v-ink);
        font-size: 13px;
        outline: none;
        appearance: none;
        -webkit-appearance: none;
        transition: border-color .15s, box-shadow .15s;
    }

    .car-input::placeholder {
        color: var(--v-slate-400);
    }

    .car-input:focus {
        border-color: var(--v-green);
        box-shadow: 0 0 0 4px rgba(200, 245, 66, .2);
    }

    .car-input-wrap:focus-within>svg {
        color: var(--v-green);
    }

    select.car-input {
        padding-right: 36px;
        cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%230F4A35' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
    }

    textarea.car-input {
        height: 110px;
        padding-top: 12px;
        resize: vertical;
        line-height: 1.5;
    }

    .car-input-wrap.is-textarea>svg {
        top: 15px;
        transform: none;
    }

    .car-input.is-invalid {
        border-color: #f87171;
    }

    .car-error {
        display: block;
        margin-top: 5px;
        font-size: 11px;
        color: #dc2626;
    }

    .car-drop {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px;
        cursor: pointer;
        border: 1.5px dashed var(--v-line);
        border-radius: 14px;
        background: var(--v-bg);
        transition: border-color .15s, background .15s;
    }

    .car-drop:hover,
    .car-drop.is-drag {
        border-color: var(--v-green);
        background: #fff;
    }

    .car-drop.has-file {
        border-style: solid;
        border-color: var(--v-green);
        background: #fff;
    }

    .car-drop .car-ic {
        width: 40px;
        height: 40px;
        background: #fff;
    }

    .car-drop.has-file .car-ic {
        background: var(--v-lime);
        color: var(--v-ink);
    }

    .car-drop strong {
        display: block;
        font-size: 13px;
        font-weight: 700;
        word-break: break-all;
    }

    .car-drop small {
        font-size: 11px;
        color: var(--v-slate-500);
    }

    .car-drop input {
        position: absolute;
        width: 1px;
        height: 1px;
        opacity: 0;
        pointer-events: none;
    }

    .car-consent {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        cursor: pointer;
        font-size: 12px;
        line-height: 18px;
        color: var(--v-slate-500);
    }

    .car-consent input {
        width: 16px;
        height: 16px;
        margin: 1px 0 0;
        accent-color: var(--v-green);
        flex-shrink: 0;
    }

    .car-submit {
        width: 100%;
        height: 50px;
        margin-top: 4px;
    }

    /* =========================================================
       FINAL CTA
    ========================================================= */
    .car-cta {
        display: grid;
        gap: 18px;
        align-items: center;
        padding: 28px 22px;
        border-radius: 26px;
        color: #fff;
        background: radial-gradient(480px 240px at 100% 100%, rgba(200, 245, 66, .2), transparent 70%), linear-gradient(140deg, var(--v-green), var(--v-ink));
    }

    .car-cta h2 {
        font-size: 26px;
        font-weight: 800;
        line-height: 1.2;
        letter-spacing: -.025em;
    }

    .car-cta h2 span {
        color: var(--v-lime);
    }

    .car-cta p {
        margin-top: 8px;
        font-size: 13px;
        line-height: 22px;
        color: rgba(255, 255, 255, .65);
    }

    .car-cta .car-actions {
        margin-top: 0;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */
    @media (min-width: 640px) {
        .car-container {
            padding: 0 24px;
        }

        .car-banner {
            padding: 38px 32px;
        }

        .car-title {
            font-size: 42px;
        }

        .car-h2 {
            font-size: 32px;
        }

        .car-hero-stats {
            grid-template-columns: repeat(4, 1fr);
        }

        .car-hero-stat {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .car-depts {
            grid-template-columns: repeat(3, 1fr);
        }

        .car-jobs {
            grid-template-columns: repeat(2, 1fr);
        }

        .car-perks,
        .car-steps {
            grid-template-columns: repeat(2, 1fr);
        }

        .car-offices {
            grid-template-columns: repeat(3, 1fr);
        }

        .car-form {
            padding: 28px;
        }

        .car-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .car-field-full {
            grid-column: 1 / -1;
        }

        .car-cta {
            padding: 36px;
        }

        .car-cta h2 {
            font-size: 30px;
        }
    }

    @media (min-width: 1024px) {
        .car-container {
            padding: 0 32px;
        }

        .car-section {
            padding: 64px 0;
        }

        .car-hero {
            padding: 24px 0 8px;
        }

        .car-banner {
            grid-template-columns: 1.05fr .95fr;
            gap: 44px;
            padding: 44px;
        }

        .car-title {
            font-size: 50px;
        }

        .car-depts {
            grid-template-columns: repeat(6, 1fr);
        }

        .car-jobs {
            grid-template-columns: repeat(3, 1fr);
        }

        .car-perks,
        .car-steps {
            grid-template-columns: repeat(4, 1fr);
        }

        .car-offices {
            grid-template-columns: repeat(6, 1fr);
        }

        .car-apply {
            grid-template-columns: .8fr 1.2fr;
        }

        .car-apply-side {
            padding: 34px;
        }

        .car-form {
            padding: 34px;
        }

        .car-cta {
            grid-template-columns: 1fr auto;
            gap: 32px;
            padding: 40px 44px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .car-panel {
            animation: none;
        }

        .car-apply-photo img {
            transition: none;
        }

        .car-apply-photo:hover img {
            transform: none;
        }

        .car-btn,
        .car-tab,
        .car-dept,
        .car-job,
        .car-filter,
        .car-dept small svg {
            transition: none;
        }

        .car-btn-lime:hover,
        .car-tab:hover,
        .car-dept:hover,
        .car-job:hover {
            transform: none;
        }
    }

    .car-job-open {
        margin-left: auto;
        flex-shrink: 0;
        padding: 3px 8px;
        border-radius: 999px;
        background: var(--v-lime);
        font-size: 10px;
        font-weight: 800;
        color: var(--v-ink);
        white-space: nowrap;
    }

    .car-job-desc {
        margin-top: 12px;
        font-size: 12.5px;
        line-height: 20px;
        color: var(--v-slate-600);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .car-job-more {
        margin: -4px 0 14px;
    }

    .car-job-more summary {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        list-style: none;
        font-size: 12px;
        font-weight: 800;
        color: var(--v-green);
    }

    .car-job-more summary::-webkit-details-marker {
        display: none;
    }

    .car-job-more summary::after {
        content: "+";
        display: grid;
        place-items: center;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: var(--v-bg);
        font-size: 13px;
    }

    .car-job-more[open] summary::after {
        content: "–";
    }

    .car-job-more-body {
        margin-top: 10px;
        padding: 12px;
        border-radius: 12px;
        background: var(--v-bg);
        font-size: 12.5px;
        line-height: 1.6;
        color: var(--v-slate-600);
    }

    .car-job-more-body p {
        white-space: pre-line;
    }

    .car-job-more-body strong {
        display: block;
        margin: 8px 0 4px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: var(--v-ink);
    }

    .car-job-more-body ul {
        margin: 0;
        padding-left: 18px;
        list-style: disc;
    }
</style>

@php
// ---------- Inline SVG icons ----------
$svg = function ($path) {
return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $path . '</svg>';
};
$icons = [
'phone' => $svg('
<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z" />'),
'code' => $svg('
<path d="m16 18 6-6-6-6" />
<path d="m8 6-6 6 6 6" />'),
'settings' => $svg('
<circle cx="12" cy="12" r="3" />
<path d="M19.4 15a1.7 1.7 0 0 0 .3 1.8l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.8-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1.1-1.5 1.7 1.7 0 0 0-1.8.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.8 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.5-1.1 1.7 1.7 0 0 0-.3-1.8l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.8.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.8-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.8V9a1.7 1.7 0 0 0 1.5 1H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1z" />'),
'headset' => $svg('
<path d="M3 14v-2a9 9 0 0 1 18 0v2" />
<path d="M21 16a2 2 0 0 1-2 2h-1v-6h1a2 2 0 0 1 2 2z" />
<path d="M3 16a2 2 0 0 0 2 2h1v-6H5a2 2 0 0 0-2 2z" />'),
'pen' => $svg('
<path d="m12 19 7-7 3 3-7 7-3-3z" />
<path d="m18 13-1.5-7.5L2 2l3.5 14.5L13 18l5-5z" />
<path d="m2 2 7.6 7.6" />
<circle cx="11" cy="11" r="2" />'),
'megaphone'=> $svg('
<path d="m3 11 18-5v12L3 14v-3z" />
<path d="M11.6 16.8a3 3 0 1 1-5.8-1.6" />'),
'users' => $svg('
<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
<circle cx="9" cy="7" r="4" />
<path d="M22 21v-2a4 4 0 0 0-3-3.9" />
<path d="M16 3.1a4 4 0 0 1 0 7.8" />'),
'pin' => $svg('
<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z" />
<circle cx="12" cy="10" r="3" />'),
'briefcase'=> $svg('
<rect x="2" y="7" width="20" height="14" rx="2" />
<path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />'),
'clock' => $svg('
<circle cx="12" cy="12" r="9" />
<path d="M12 7v5l3 2" />'),
'moon' => $svg('
<path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9z" />'),
'lang' => $svg('
<path d="m5 8 6 6" />
<path d="m4 14 6-6 2-3" />
<path d="M2 5h12" />
<path d="M7 2h1" />
<path d="m22 22-5-10-5 10" />
<path d="M14 18h6" />'),
'target' => $svg('
<circle cx="12" cy="12" r="9" />
<circle cx="12" cy="12" r="5" />
<circle cx="12" cy="12" r="1" />'),
'cap' => $svg('
<path d="M22 10 12 5 2 10l10 5 10-5z" />
<path d="M6 12v5c3 3 9 3 12 0v-5" />'),
'laptop' => $svg('
<rect x="4" y="4" width="16" height="11" rx="2" />
<path d="M2 20h20" />'),
'trophy' => $svg('
<path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6" />
<path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18" />
<path d="M4 22h16" />
<path d="M10 14.7V17c0 .6-.5 1-1 1.2C7.9 18.8 7 20.2 7 22" />
<path d="M14 14.7V17c0 .6.5 1 1 1.2 1.1.6 2 2 2 3.8" />
<path d="M18 2H6v7a6 6 0 0 0 12 0V2z" />'),
'trend' => $svg('
<path d="m22 7-8.5 8.5-5-5L2 17" />
<path d="M16 7h6v6" />'),
'heart' => $svg('
<path d="M19 14c1.5-1.5 3-3.2 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.8 0-3 .5-4.5 2-1.5-1.5-2.7-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4 3 5.5l7 7z" />
<path d="M3.2 12H9l.5-1 2 4.5 2-7 1.5 3.5h5.3" />'),
'home' => $svg('
<path d="m3 10 9-7 9 7v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
<path d="M9 22V12h6v10" />'),
'file' => $svg('
<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
<path d="M14 2v6h6" />
<path d="M16 13H8" />
<path d="M16 17H8" />'),
'party' => $svg('
<path d="M5.8 11.3 2 22l10.7-3.8" />
<path d="M4 3h.01" />
<path d="M22 8h.01" />
<path d="M15 2h.01" />
<path d="M22 20h.01" />
<path d="m22 2-2.2.8a2.9 2.9 0 0 0-1.9 3.2c.1.9-.5 1.7-1.4 1.7h-.4c-.9 0-1.7.6-1.9 1.5L14 11" />
<path d="M11 13c1.9 1.9 2.8 4 2 4.7-.8.8-2.9-.1-4.8-2S5.5 11.8 6.2 11c.8-.8 2.9.1 4.8 2z" />'),
'building' => $svg('
<rect x="4" y="3" width="16" height="18" rx="2" />
<path d="M9 7h1M14 7h1M9 11h1M14 11h1M9 15h1M14 15h1" />'),
'user' => $svg('
<circle cx="12" cy="8" r="4" />
<path d="M4 21v-1a6 6 0 0 1 6-6h4a6 6 0 0 1 6 6v1" />'),
'mail' => $svg('
<rect x="2" y="4" width="20" height="16" rx="2" />
<path d="m22 7-10 6L2 7" />'),
'grid' => $svg('
<rect x="3" y="3" width="7" height="7" rx="1" />
<rect x="14" y="3" width="7" height="7" rx="1" />
<rect x="3" y="14" width="7" height="7" rx="1" />
<rect x="14" y="14" width="7" height="7" rx="1" />'),
'rupee' => $svg('
<path d="M6 3h12" />
<path d="M6 8h12" />
<path d="m6 13 8.5 8" />
<path d="M6 13h3" />
<path d="M9 13c6.7 0 6.7-10 0-10" />'),
'calendar' => $svg('
<rect x="3" y="4" width="18" height="18" rx="2" />
<path d="M16 2v4M8 2v4M3 10h18" />'),
'upload' => $svg('
<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
<path d="m17 8-5-5-5 5" />
<path d="M12 3v12" />'),
'message' => $svg('
<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />'),
'send' => $svg('
<path d="m22 2-7 20-4-9-9-4z" />
<path d="M22 2 11 13" />'),
'arrow' => $svg('
<path d="M5 12h14" />
<path d="m12 5 7 7-7 7" />'),
'check' => $svg('
<circle cx="12" cy="12" r="9" />
<path d="m8 12 3 3 5-6" />'),
'alert' => $svg('
<circle cx="12" cy="12" r="9" />
<path d="M12 8v4M12 16h.01" />'),
];

// ---------- Departments (hero tabs + cards + filters) ----------
$departments = [
'sales' => [
'name' => 'Sales & Telecalling', 'short' => 'Sales', 'icon' => 'phone', 'count' => 49,
'desc' => 'Call leads, close deals and drive vehicle bookings across cities. Freshers welcome — full training provided.',
'salary' => '₹18K–45K/mo', 'mode' => 'On-site',
'roles' => ['Telecaller', 'Tele-Sales Executive', 'Inside Sales', 'Sales Team Lead'],
],
'engineering' => [
'name' => 'Engineering', 'short' => 'Engineering', 'icon' => 'code', 'count' => 18,
'desc' => 'Build the booking, listing and partner platforms that power every ride on Wheelo.',
'salary' => '₹16–38 LPA', 'mode' => 'Hybrid / Remote',
'roles' => ['Backend Engineer', 'Frontend (React)', 'Android', 'QA'],
],
'operations' => [
'name' => 'Operations', 'short' => 'Operations', 'icon' => 'settings', 'count' => 12,
'desc' => 'Run city launches, partner onboarding and fleet quality on the ground.',
'salary' => '₹6–18 LPA', 'mode' => 'On-site',
'roles' => ['City Ops Manager', 'Fleet Associate', 'Partner Onboarding'],
],
'support' => [
'name' => 'Customer Support', 'short' => 'Support', 'icon' => 'headset', 'count' => 9,
'desc' => 'Help riders and owners with bookings, payments and issues — by call, chat and email.',
'salary' => '₹4–6 LPA', 'mode' => 'On-site',
'roles' => ['Support Executive', 'Chat Support', 'Escalations'],
],
'design' => [
'name' => 'Design', 'short' => 'Design', 'icon' => 'pen', 'count' => 5,
'desc' => 'Design simple, clear experiences for riders, owners and partners across web and app.',
'salary' => '₹12–18 LPA', 'mode' => 'Remote',
'roles' => ['Product Designer', 'UI Designer'],
],
'marketing' => [
'name' => 'Marketing', 'short' => 'Marketing', 'icon' => 'megaphone', 'count' => 6,
'desc' => 'Grow the Wheelo brand and bring in riders, owners and partners across every city.',
'salary' => '₹8–24 LPA', 'mode' => 'Hybrid',
'roles' => ['Performance Marketing', 'Content', 'Brand'],
],
];

// ---------- Open roles ----------
$jobs = [
['title' => 'Telecaller (Hindi/English)', 'dept' => 'sales', 'icon' => 'phone', 'city' => 'Delhi NCR', 'specs' => [['pin', 'On-site'], ['clock', 'Day shift'], ['lang', 'Hindi, English']], 'salary' => '₹18,000–25,000', 'per' => 'per month'],
['title' => 'Tele-Sales Executive', 'dept' => 'sales', 'icon' => 'headset', 'city' => 'Bengaluru', 'specs' => [['pin', 'On-site'], ['clock', 'Day shift'], ['target', 'Incentives']], 'salary' => '₹20,000–30,000', 'per' => 'per month'],
['title' => 'Inside Sales Executive', 'dept' => 'sales', 'icon' => 'briefcase', 'city' => 'Mumbai', 'specs' => [['pin', 'On-site'], ['clock', 'Day shift'], ['target', 'Incentives']], 'salary' => '₹22,000–32,000', 'per' => 'per month'],
['title' => 'Sales Team Lead', 'dept' => 'sales', 'icon' => 'users', 'city' => 'Hyderabad', 'specs' => [['pin', 'On-site'], ['clock', 'Day shift'], ['cap', '3–5 yrs']], 'salary' => '₹35,000–45,000', 'per' => 'per month'],
['title' => 'Telecaller – Night Shift', 'dept' => 'sales', 'icon' => 'phone', 'city' => 'Chennai', 'specs' => [['pin', 'On-site'], ['moon', 'Night shift'], ['lang', 'Tamil, English']], 'salary' => '₹19,000–24,000', 'per' => 'per month'],
['title' => 'Senior Backend Engineer', 'dept' => 'engineering', 'icon' => 'code', 'city' => 'Bengaluru', 'specs' => [['laptop', 'Hybrid'], ['clock', 'Full-time'], ['cap', '4–6 yrs']], 'salary' => '₹28–38 LPA', 'per' => 'per year'],
['title' => 'Frontend Engineer (React)', 'dept' => 'engineering', 'icon' => 'code', 'city' => 'Remote', 'specs' => [['laptop', 'Remote'], ['clock', 'Full-time'], ['cap', '2–4 yrs']], 'salary' => '₹16–24 LPA', 'per' => 'per year'],
['title' => 'City Operations Manager', 'dept' => 'operations', 'icon' => 'settings', 'city' => 'Mumbai', 'specs' => [['pin', 'On-site'], ['clock', 'Full-time'], ['cap', '3–5 yrs']], 'salary' => '₹14–18 LPA', 'per' => 'per year'],
['title' => 'Customer Support Executive', 'dept' => 'support', 'icon' => 'headset', 'city' => 'Pune', 'specs' => [['pin', 'On-site'], ['clock', 'Full-time'], ['cap', '0–2 yrs']], 'salary' => '₹4–6 LPA', 'per' => 'per year'],
['title' => 'Product Designer', 'dept' => 'design', 'icon' => 'pen', 'city' => 'Remote', 'specs' => [['laptop', 'Remote'], ['clock', 'Full-time'], ['cap', '2–4 yrs']], 'salary' => '₹12–18 LPA', 'per' => 'per year'],
['title' => 'Performance Marketing Lead', 'dept' => 'marketing', 'icon' => 'megaphone', 'city' => 'Hyderabad', 'specs' => [['laptop', 'Hybrid'], ['clock', 'Full-time'], ['cap', '4–7 yrs']], 'salary' => '₹18–24 LPA', 'per' => 'per year'],
];

$totalOpen = array_sum(array_column($departments, 'count'));
$cities = ['Delhi NCR', 'Mumbai', 'Bengaluru', 'Pune', 'Hyderabad', 'Chennai', 'Remote'];
$firstKey = array_key_first($departments);
$first = $departments[$firstKey];

// JS ke liye preview data (icon HTML ke saath)
$previewData = [];
foreach ($departments as $key => $d) {
$previewData[$key] = $d + ['icon_svg' => $icons[$d['icon']]];
}
@endphp

<div class="car">

    {{-- =========================================================
         HERO BANNER
    ========================================================== --}}
    <section class="car-hero">
        <div class="car-container">

            <div class="car-banner">

                {{-- Left --}}
                <div>
                    <nav class="car-crumb" aria-label="Breadcrumb">
                        <a href="{{ url('/') }}">Home</a> <span>/</span> <span>Careers</span>
                    </nav>

                    <div class="car-badge"><span class="car-dot"></span> We're hiring · {{ $totalOpen }}+ roles</div>

                    <h1 class="car-title">Build. Sell. Grow <span>with Wheelo.</span></h1>

                    <p class="car-lead">
                        From telecalling and sales to engineering and operations — Wheelo is hiring across 6 cities.
                        Freshers welcome in Sales, experienced hires welcome everywhere.
                    </p>

                    <div class="car-actions">
                        <a href="#openings" class="car-btn car-btn-lime">View All Openings {!! $icons['arrow'] !!}</a>
                        <a href="#applyForm" class="car-btn car-btn-ghost">Apply Now</a>
                    </div>

                    <div class="car-hero-stats">
                        <div class="car-hero-stat"><span>{!! $icons['users'] !!}</span>
                            <div><strong>320+</strong><small>Team members</small></div>
                        </div>
                        <div class="car-hero-stat"><span>{!! $icons['pin'] !!}</span>
                            <div><strong>6</strong><small>Office cities</small></div>
                        </div>
                        <div class="car-hero-stat"><span>{!! $icons['briefcase'] !!}</span>
                            <div><strong>{{ $totalOpen }}+</strong><small>Open positions</small></div>
                        </div>
                        <div class="car-hero-stat"><span>{!! $icons['phone'] !!}</span>
                            <div><strong>{{ $departments['sales']['count'] }}</strong><small>Sales openings</small></div>
                        </div>
                    </div>
                </div>

                {{-- Right: team preview (clickable) --}}
                <div class="car-preview" id="teamPreview" data-teams='@json($previewData)'>
                    <p class="car-preview-label">Pick a team to preview</p>

                    <div class="car-tabs" role="tablist" aria-label="Teams">
                        @foreach($departments as $key => $d)
                        <button type="button" role="tab" class="car-tab {{ $key === $firstKey ? 'is-active' : '' }}"
                            data-team="{{ $key }}" aria-selected="{{ $key === $firstKey ? 'true' : 'false' }}">
                            {!! $icons[$d['icon']] !!}
                            <span>{{ $d['name'] }}</span>
                        </button>
                        @endforeach
                    </div>

                    <div class="car-panel" id="teamPanel" role="tabpanel" aria-live="polite">
                        <div class="car-panel-head">
                            <span class="car-panel-ic" data-p="icon">{!! $icons[$first['icon']] !!}</span>
                            <div>
                                <strong data-p="name">{{ $first['name'] }}</strong>
                                <span class="car-panel-live">Hiring now</span>
                            </div>
                        </div>

                        <p class="car-panel-desc" data-p="desc">{{ $first['desc'] }}</p>

                        <div class="car-panel-meta">
                            <div><strong data-p="count">{{ $first['count'] }}</strong><small>Open roles</small></div>
                            <div><strong data-p="salary">{{ $first['salary'] }}</strong><small>Salary range</small></div>
                            <div><strong data-p="mode">{{ $first['mode'] }}</strong><small>Work mode</small></div>
                        </div>

                        <div class="car-panel-roles" data-p="roles">
                            @foreach($first['roles'] as $role)
                            <span>{{ $role }}</span>
                            @endforeach
                        </div>

                        <button type="button" class="car-btn car-btn-lime" id="panelViewBtn" data-team="{{ $firstKey }}">
                            <span data-p="btn">View {{ $first['short'] }} roles</span> {!! $icons['arrow'] !!}
                        </button>
                    </div>
                </div>

            </div>

            {{-- Hiring for --}}
            <div class="car-chips-bar">
                <span><span class="car-dot"></span> Hiring for</span>
                <div class="car-chips">
                    @foreach(['Freshers', 'Telecallers', 'Sales', 'Engineers', 'Operations', 'Support', 'Design', 'Marketing'] as $chip)
                    <span class="car-chip">{{ $chip }}</span>
                    @endforeach
                </div>
            </div>

        </div>
    </section>


    {{-- =========================================================
         DEPARTMENTS
    ========================================================== --}}
    <section class="car-section" id="departments">
        <div class="car-container">

            <div class="car-head car-head-row">
                <div>
                    <span class="car-kicker"><span class="car-dot"></span> Browse by team</span>
                    <h2 class="car-h2">Every team, <span>one mission.</span></h2>
                </div>
                <p class="car-sub">Every team at Wheelo ships work that reaches riders and owners directly. Pick one to see its roles.</p>
            </div>

            <div class="car-depts">
                @foreach($departments as $key => $d)
                <button type="button" class="car-dept" data-filter-go="{{ $key }}">
                    <span class="car-ic">{!! $icons[$d['icon']] !!}</span>
                    <strong>{{ $d['name'] }}</strong>
                    <small><span>{{ $d['count'] }} openings</span> {!! $icons['arrow'] !!}</small>
                </button>
                @endforeach
            </div>

        </div>
    </section>


    {{-- =========================================================
         OPEN ROLES
    ========================================================== --}}
    {{-- =========================================================
     OPEN ROLES – Super Admin ki jobs (DB se, sirf Live wali)
========================================================== --}}
    @php
    // Department ka icon (careers page ke $icons ke keys)
    $deptIcons = [
    'sales' => 'phone', 'engineering' => 'code', 'operations' => 'settings',
    'support' => 'headset', 'design' => 'pen', 'marketing' => 'megaphone',
    ];

    try {
    $jobRows = \App\Models\CareerJob::active()
    ->orderBy('sort_order')
    ->orderByDesc('id')
    ->get();
    } catch (\Throwable $e) {
    report($e); // table/column ki problem ho to page crash na ho
    $jobRows = collect();
    }

    $openJobs = $jobRows->map(function ($job) use ($deptIcons) {
    $specs = [];
    $specs[] = $job->work_mode === 'On-site' ? ['pin', 'On-site'] : ['laptop', $job->work_mode];

    if ($job->shift === 'Night') $specs[] = ['moon', 'Night shift'];
    elseif ($job->shift) $specs[] = ['clock', $job->shift . ' shift'];
    else $specs[] = ['clock', $job->job_type];

    $specs[] = ['cap', $job->experience];
    if ($job->languages) $specs[] = ['lang', $job->languages];

    return [
    'title' => $job->title,
    'dept' => $job->department,
    'icon' => $deptIcons[$job->department] ?? 'briefcase',
    'city' => $job->city,
    'specs' => $specs,
    'salary' => $job->salary,
    'per' => $job->salary_period === 'year' ? 'per year' : 'per month',
    'openings' => (int) $job->openings,
    'job_type' => $job->job_type,
    'description' => $job->description,
    'requirements' => $job->requirements_list,
    ];
    })->values()->all();
    @endphp


    <section class="car-section car-white" id="openings">
        <div class="car-container">

            <div class="car-head car-head-row">
                <div>
                    <span class="car-kicker"><span class="car-dot"></span> Open roles</span>
                    <h2 class="car-h2">Positions hiring <span>right now.</span></h2>
                </div>
                <p class="car-sub">Tap a team to filter. Click “Apply” and the form fills the role for you.</p>
            </div>

            <div class="car-filters" role="tablist" aria-label="Filter roles">
                <button type="button" class="car-filter is-active" data-filter="all">All <em>{{ count($openJobs) }}</em></button>
                @foreach($departments as $key => $d)
                <button type="button" class="car-filter" data-filter="{{ $key }}">
                    {{ $d['short'] }} <em>{{ collect($openJobs)->where('dept', $key)->count() }}</em>
                </button>
                @endforeach
            </div>

            <div class="car-jobs" id="jobList">
                @foreach($openJobs as $job)
                <article class="car-job" data-dept="{{ $job['dept'] }}">
                    <div class="car-job-top">
                        <span class="car-ic">{!! $icons[$job['icon']] ?? $icons['briefcase'] !!}</span>
                        <div>
                            <span class="car-job-tag">{{ $departments[$job['dept']]['short'] ?? ucfirst($job['dept']) }} · {{ $job['city'] }}</span>
                            <h3>{{ $job['title'] }}</h3>
                        </div>
                        <span class="car-job-open">{{ $job['openings'] }} {{ $job['openings'] == 1 ? 'opening' : 'openings' }}</span>
                    </div>

                    @if($job['description'])
                    <p class="car-job-desc">{{ $job['description'] }}</p>
                    @endif

                    <ul class="car-job-specs">
                        @foreach($job['specs'] as [$ic, $label])
                        <li>{!! $icons[$ic] ?? '' !!} {{ $label }}</li>
                        @endforeach
                    </ul>

                    @if($job['description'] || count($job['requirements']))
                    <details class="car-job-more">
                        <summary>View details</summary>
                        <div class="car-job-more-body">
                            @if($job['description'])
                            <strong>About the role</strong>
                            <p>{{ $job['description'] }}</p>
                            @endif
                            @if(count($job['requirements']))
                            <strong>Requirements</strong>
                            <ul>
                                @foreach($job['requirements'] as $req)
                                <li>{{ $req }}</li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                    </details>
                    @endif

                    <div class="car-job-foot">
                        <div class="car-salary">
                            <strong>{{ $job['salary'] }}</strong>
                            <small>{{ $job['per'] }} · {{ $job['job_type'] }}</small>
                        </div>
                        <button type="button" class="car-btn car-btn-soft car-btn-sm js-apply"
                            data-position="{{ $job['title'] }}"
                            data-department="{{ $departments[$job['dept']]['name'] ?? '' }}"
                            data-city="{{ $job['city'] }}">
                            Apply {!! $icons['arrow'] !!}
                        </button>
                    </div>
                </article>
                @endforeach
            </div>

            <div class="car-empty" id="jobEmpty" @if(count($openJobs)) hidden @endif>
                No roles listed here right now. <a href="#applyForm">Send your resume anyway →</a>
            </div>

            <p class="car-more">Don't see your role? <a href="#applyForm">Apply with a general application</a></p>

        </div>
    </section>


    {{-- =========================================================
         WHY WHEELO (PERKS)
    ========================================================== --}}
    <section class="car-section car-dark" id="why">
        <div class="car-container">

            <div class="car-head car-head-row">
                <div>
                    <span class="car-kicker"><span class="car-dot"></span> Why Wheelo</span>
                    <h2 class="car-h2">Built for people <span>who want to ship.</span></h2>
                </div>
                <p class="car-sub">We hire owners, not order-takers. Every team moves fast and sees the direct impact of its work.</p>
            </div>

            <div class="car-perks">
                @foreach([
                ['trophy', 'Daily Incentives', 'Per-call and per-conversion incentives for sales roles, on top of fixed salary.'],
                ['trend', 'Fast Growth', 'Move up within 6–12 months of strong performance, across every team.'],
                ['heart', 'Health Insurance', 'Medical cover for you and your family from day one.'],
                ['home', 'Hybrid Friendly', 'Most teams run hybrid, with fully remote roles open across the org.'],
                ] as [$ic, $title, $text])
                <div class="car-perk">
                    <span class="car-ic">{!! $icons[$ic] !!}</span>
                    <h3>{{ $title }}</h3>
                    <p>{{ $text }}</p>
                </div>
                @endforeach
            </div>

            <div class="car-perk-bar">
                <ul>
                    <li>{{ $totalOpen }}+ open roles</li>
                    <li>6 office cities</li>
                    <li>Hybrid & remote</li>
                    <li>320+ team members</li>
                </ul>
                <a href="#applyForm" class="car-btn car-btn-sm">Apply Now {!! $icons['arrow'] !!}</a>
            </div>

        </div>
    </section>


    {{-- =========================================================
         HIRING PROCESS
    ========================================================== --}}
    <section class="car-section" id="process">
        <div class="car-container">

            <div class="car-head car-head-center">
                <span class="car-kicker"><span class="car-dot"></span> Hiring process</span>
                <h2 class="car-h2">From application <span>to offer.</span></h2>
                <p class="car-sub">No unnecessary rounds — clear timelines at every step.</p>
            </div>

            <div class="car-steps">
                @foreach([
                ['file', 'Apply', 'Submit your application and resume for the role that fits you best.', 'Day 0'],
                ['phone', 'Screening Call', 'A short call with our talent team about your background and goals.', 'Within 3 days'],
                ['users', 'Interview Round', 'Role-specific interview, or a quick voice test for calling roles.', 'Week 1'],
                ['party', 'Offer', 'Get your offer with clear pay, benefits and start-date details.', 'Week 1–2'],
                ] as $i => [$ic, $title, $text, $time])
                <div class="car-step">
                    <div class="car-step-top">
                        <span class="car-ic">{!! $icons[$ic] !!}</span>
                        <span class="car-step-num">{{ sprintf('%02d', $i + 1) }}</span>
                    </div>
                    <h3>{{ $title }}</h3>
                    <p>{{ $text }}</p>
                    <span class="car-step-time">{{ $time }}</span>
                </div>
                @endforeach
            </div>

        </div>
    </section>


    {{-- =========================================================
         OFFICES
    ========================================================== --}}
    <section class="car-section car-white" id="offices">
        <div class="car-container">

            <div class="car-head car-head-row">
                <div>
                    <span class="car-kicker"><span class="car-dot"></span> Where we work</span>
                    <h2 class="car-h2">Our office <span>locations.</span></h2>
                </div>
                <p class="car-sub">Teams across major cities, with hybrid and remote options for most roles.</p>
            </div>

            <div class="car-offices">
                @foreach([
                ['Delhi NCR', 'Headquarters', true],
                ['Mumbai', '80+ team', false],
                ['Bengaluru', '120+ team', false],
                ['Pune', '40+ team', false],
                ['Hyderabad', '35+ team', false],
                ['Chennai', '30+ team', false],
                ] as [$city, $note, $hq])
                <div class="car-office {{ $hq ? 'is-hq' : '' }}">
                    <span>{!! $icons['building'] !!}</span>
                    <strong>{{ $city }}</strong>
                    <small>{{ $note }}</small>
                </div>
                @endforeach
            </div>

        </div>
    </section>


    {{-- =========================================================
         APPLICATION FORM
    ========================================================== --}}
    <section class="car-section" id="applyForm">
        <div class="car-container">

            <div class="car-apply">

                {{-- Left info --}}
                <aside class="car-apply-side">
                    <span class="car-kicker"><span class="car-dot"></span> Apply now</span>
                    <h3>Start your <span>application.</span></h3>
                    <p class="mb-3">One form for every role — Sales, Telecalling, Engineering, Operations, Support, Design or Marketing.</p>

                    <ul class="car-apply-steps mt-2">
                        <li><b>1</b>
                            <div><strong>Fill the form</strong><small>Takes about 2 minutes</small></div>
                        </li>
                        <li><b>2</b>
                            <div><strong>We review your profile</strong><small>Our talent team reads every application</small></div>
                        </li>
                        <li><b>3</b>
                            <div><strong>Get a call</strong><small>Shortlisted candidates hear back within 3 days</small></div>
                        </li>
                    </ul>

                    <div class="car-apply-contact">
                        Questions about a role?
                        <br>
                        <a href="mailto:careers@wheelo.in">{!! $icons['mail'] !!} careers@wheelo.in</a>
                    </div>

                    {{-- Image: public/images/careers-team.jpg (na mile to design wala placeholder dikhega) --}}
                    <figure class="car-apply-photo" style="margin-left:0;margin-right:0;margin-bottom:0;">
                        <span class="car-apply-photo-empty">{!! $icons['users'] !!}</span>
                        <img src="{{ asset('images/careers-team.jpg') }}" alt="Wheelo team at work" loading="lazy"
                            onerror="this.remove()">
                        <figcaption>
                            <span class="car-apply-photo-tag"><span class="car-dot" style="background:#051A13"></span> Life at Wheelo</span>
                            <strong>320+ people building the future of mobility.</strong>
                            <small>6 cities · Hybrid & remote teams</small>
                        </figcaption>
                    </figure>
                </aside>

                {{-- Right form --}}
                <div class="car-form">

                    <div class="car-form-head">
                        <div>
                            <h3>Application form</h3>
                            <p>Fields marked <span style="color:#ef4444">*</span> are required.</p>
                        </div>
                        <span class="car-form-pill">~2 min</span>
                    </div>

                    @if (session('success'))
                    <div class="car-alert" role="status">{!! $icons['check'] !!} {{ session('success') }}</div>
                    @endif

                    @if ($errors->any())
                    <div class="car-alert car-alert-error" role="alert">{!! $icons['alert'] !!} Please fix the highlighted fields and try again.</div>
                    @endif

                    <form action="{{ url('/careers/apply') }}" method="POST" enctype="multipart/form-data" id="careerForm" novalidate>
                        @csrf

                        <div class="car-grid">

                            {{-- Name --}}
                            <div class="car-field">
                                <label for="c_name" class="car-label">Full Name <i>*</i></label>
                                <div class="car-input-wrap">
                                    {!! $icons['user'] !!}
                                    <input type="text" id="c_name" name="name" value="{{ old('name') }}" placeholder="Your full name" required autocomplete="name"
                                        class="car-input @error('name') is-invalid @enderror">
                                </div>
                                @error('name') <small class="car-error">{{ $message }}</small> @enderror
                            </div>

                            {{-- Phone --}}
                            <div class="car-field">
                                <label for="c_phone" class="car-label">Phone Number <i>*</i></label>
                                <div class="car-input-wrap">
                                    {!! $icons['phone'] !!}
                                    <input type="tel" id="c_phone" name="phone" value="{{ old('phone') }}" placeholder="+91 98765 43210" required autocomplete="tel"
                                        class="car-input @error('phone') is-invalid @enderror">
                                </div>
                                @error('phone') <small class="car-error">{{ $message }}</small> @enderror
                            </div>

                            {{-- Email --}}
                            <div class="car-field car-field-full">
                                <label for="c_email" class="car-label">Email <i>*</i></label>
                                <div class="car-input-wrap">
                                    {!! $icons['mail'] !!}
                                    <input type="email" id="c_email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required autocomplete="email"
                                        class="car-input @error('email') is-invalid @enderror">
                                </div>
                                @error('email') <small class="car-error">{{ $message }}</small> @enderror
                            </div>

                            {{-- Department --}}
                            <div class="car-field">
                                <label for="c_department" class="car-label">Department <i>*</i></label>
                                <div class="car-input-wrap">
                                    {!! $icons['grid'] !!}
                                    <select id="c_department" name="department" required class="car-input @error('department') is-invalid @enderror">
                                        <option value="">Select department</option>
                                        @foreach($departments as $d)
                                        <option value="{{ $d['name'] }}" {{ old('department') == $d['name'] ? 'selected' : '' }}>{{ $d['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('department') <small class="car-error">{{ $message }}</small> @enderror
                            </div>

                            {{-- Position --}}
                            <div class="car-field">
                                <label for="position" class="car-label">Position <i>*</i></label>
                                <div class="car-input-wrap">
                                    {!! $icons['briefcase'] !!}
                                    <input type="text" id="position" name="position" value="{{ old('position') }}" placeholder="e.g. Telecaller" required
                                        class="car-input @error('position') is-invalid @enderror">
                                </div>
                                @error('position') <small class="car-error">{{ $message }}</small> @enderror
                            </div>

                            {{-- City --}}
                            <div class="car-field">
                                <label for="c_city" class="car-label">Preferred City <i>*</i></label>
                                <div class="car-input-wrap">
                                    {!! $icons['pin'] !!}
                                    <select id="c_city" name="city" required class="car-input @error('city') is-invalid @enderror">
                                        <option value="">Select city</option>
                                        @foreach($cities as $city)
                                        <option value="{{ $city }}" {{ old('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('city') <small class="car-error">{{ $message }}</small> @enderror
                            </div>

                            {{-- Experience --}}
                            <div class="car-field">
                                <label for="c_experience" class="car-label">Experience <i>*</i></label>
                                <div class="car-input-wrap">
                                    {!! $icons['cap'] !!}
                                    <select id="c_experience" name="experience" required class="car-input @error('experience') is-invalid @enderror">
                                        <option value="">Select</option>
                                        @foreach(['Fresher' => 'Fresher', '0-1' => '0 – 1 years', '1-3' => '1 – 3 years', '3-5' => '3 – 5 years', '5+' => '5+ years'] as $val => $label)
                                        <option value="{{ $val }}" {{ old('experience') == $val ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('experience') <small class="car-error">{{ $message }}</small> @enderror
                            </div>

                            {{-- Languages --}}
                            <div class="car-field">
                                <label for="c_languages" class="car-label">Languages Known <em>(optional)</em></label>
                                <div class="car-input-wrap">
                                    {!! $icons['lang'] !!}
                                    <input type="text" id="c_languages" name="languages" value="{{ old('languages') }}" placeholder="e.g. Hindi, English"
                                        class="car-input @error('languages') is-invalid @enderror">
                                </div>
                                @error('languages') <small class="car-error">{{ $message }}</small> @enderror
                            </div>

                            {{-- Expected salary --}}
                            <div class="car-field">
                                <label for="c_salary" class="car-label">Expected Salary <i>*</i></label>
                                <div class="car-input-wrap">
                                    {!! $icons['rupee'] !!}
                                    <input type="text" id="c_salary" name="expected_salary" value="{{ old('expected_salary') }}" placeholder="e.g. ₹20,000/mo or ₹15 LPA" required
                                        class="car-input @error('expected_salary') is-invalid @enderror">
                                </div>
                                @error('expected_salary') <small class="car-error">{{ $message }}</small> @enderror
                            </div>

                            {{-- Notice period --}}
                            <div class="car-field">
                                <label for="c_notice" class="car-label">Notice Period <i>*</i></label>
                                <div class="car-input-wrap">
                                    {!! $icons['calendar'] !!}
                                    <select id="c_notice" name="notice_period" required class="car-input @error('notice_period') is-invalid @enderror">
                                        <option value="">Select</option>
                                        @foreach(['Immediate', '15 days', '30 days', '60 days'] as $np)
                                        <option value="{{ $np }}" {{ old('notice_period') == $np ? 'selected' : '' }}>{{ $np }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('notice_period') <small class="car-error">{{ $message }}</small> @enderror
                            </div>

                            {{-- Resume --}}
                            <div class="car-field car-field-full">
                                <span class="car-label">Resume <i>*</i></span>
                                <label class="car-drop" id="resumeDrop" for="c_resume">
                                    <span class="car-ic">{!! $icons['upload'] !!}</span>
                                    <div>
                                        <strong id="fileLabel">Click to upload or drag your resume here</strong>
                                        <small id="fileHint">PDF, DOC or DOCX · max 3MB</small>
                                    </div>
                                    <input type="file" id="c_resume" name="resume" accept=".pdf,.doc,.docx" required>
                                </label>
                                <small class="car-error" id="fileError" hidden></small>
                                @error('resume') <small class="car-error">{{ $message }}</small> @enderror
                            </div>

                            {{-- Message --}}
                            <div class="car-field car-field-full">
                                <label for="c_message" class="car-label">Cover Message <em>(optional)</em></label>
                                <div class="car-input-wrap is-textarea">
                                    {!! $icons['message'] !!}
                                    <textarea id="c_message" name="message" placeholder="Tell us why you're a fit for this role"
                                        class="car-input @error('message') is-invalid @enderror">{{ old('message') }}</textarea>
                                </div>
                                @error('message') <small class="car-error">{{ $message }}</small> @enderror
                            </div>

                            {{-- Consent + submit --}}
                            <div class="car-field car-field-full">
                                <label class="car-consent">
                                    <input type="checkbox" name="consent" value="1" required {{ old('consent') ? 'checked' : '' }}>
                                    <span>I confirm the details are correct and agree to be contacted by Wheelo about this application.</span>
                                </label>
                            </div>

                            <div class="car-field car-field-full">
                                <button type="submit" class="car-btn car-btn-lime car-submit" id="careerSubmit">
                                    {!! $icons['send'] !!} <span>Submit Application</span>
                                </button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>

        </div>
    </section>


    {{-- =========================================================
         FINAL CTA
    ========================================================== --}}
    <section class="car-section" style="padding-top: 0;">
        <div class="car-container">
            <div class="car-cta">
                <div>
                    <span class="car-kicker" style="color:#C8F542;"><span class="car-dot"></span> Join us</span>
                    <h2 style="margin-top:10px;">Ready to build the future <span>of mobility?</span></h2>
                    <p>Find your role, apply in 2 minutes and hear back within days.</p>
                </div>
                <div class="car-actions">
                    <a href="#openings" class="car-btn car-btn-lime">View All Openings {!! $icons['arrow'] !!}</a>
                    <a href="#applyForm" class="car-btn car-btn-ghost">Apply Now</a>
                </div>
            </div>
        </div>
    </section>

</div>


{{-- =========================================================
     CAREERS JAVASCRIPT
========================================================== --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {

        /* ---------- Helpers ---------- */
        function scrollToEl(el) {
            if (!el) return;
            var header = document.querySelector('header');
            var offset = header ? header.offsetHeight + 12 : 12;
            var top = el.getBoundingClientRect().top + window.pageYOffset - offset;
            window.scrollTo({
                top: top,
                behavior: 'smooth'
            });
        }

        /* ---------- 1. Hero team tabs ---------- */
        var preview = document.getElementById('teamPreview');
        var teams = {};
        try {
            teams = preview ? JSON.parse(preview.dataset.teams || '{}') : {};
        } catch (e) {
            teams = {};
        }

        var panel = document.getElementById('teamPanel');
        var viewBtn = document.getElementById('panelViewBtn');
        var tabs = preview ? preview.querySelectorAll('.car-tab') : [];

        function setP(key, value) {
            var el = panel.querySelector('[data-p="' + key + '"]');
            if (el) el.textContent = value;
        }

        function showTeam(key) {
            var t = teams[key];
            if (!t) return;

            tabs.forEach(function(tab) {
                var on = tab.dataset.team === key;
                tab.classList.toggle('is-active', on);
                tab.setAttribute('aria-selected', on ? 'true' : 'false');
            });

            setP('name', t.name);
            setP('desc', t.desc);
            setP('count', t.count);
            setP('salary', t.salary);
            setP('mode', t.mode);
            setP('btn', 'View ' + t.short + ' roles');
            panel.querySelector('[data-p="icon"]').innerHTML = t.icon_svg;

            var roles = panel.querySelector('[data-p="roles"]');
            roles.innerHTML = '';
            t.roles.forEach(function(r) {
                var s = document.createElement('span');
                s.textContent = r;
                roles.appendChild(s);
            });

            viewBtn.dataset.team = key;

            // chhota animation dobara chalao
            panel.style.animation = 'none';
            panel.offsetHeight;
            panel.style.animation = '';
        }

        tabs.forEach(function(tab) {
            tab.addEventListener('click', function() {
                showTeam(tab.dataset.team);
            });
        });

        /* ---------- 2. Job filter ---------- */
        var filters = document.querySelectorAll('.car-filter');
        var emptyBox = document.getElementById('jobEmpty');

        function filterJobs(key) {
            var shown = 0;
            var currentJobs = document.querySelectorAll('#jobList .car-job');

            filters.forEach(function(f) {
                f.classList.toggle('is-active', f.dataset.filter === key);
            });

            currentJobs.forEach(function(job) {
                var match = key === 'all' || job.dataset.dept === key;
                job.hidden = !match;

                if (match) {
                    shown++;
                }
            });

            if (emptyBox) {
                emptyBox.hidden = shown > 0;
            }
        }

        filters.forEach(function(f) {
            f.addEventListener('click', function() {
                filterJobs(f.dataset.filter);
            });
        });

        // Hero "View roles" + department cards -> filter + scroll
        if (viewBtn) {
            viewBtn.addEventListener('click', function() {
                filterJobs(viewBtn.dataset.team);
                scrollToEl(document.getElementById('openings'));
            });
        }
        document.querySelectorAll('[data-filter-go]').forEach(function(card) {
            card.addEventListener('click', function() {
                var key = card.dataset.filterGo;
                filterJobs(key);
                showTeam(key);
                scrollToEl(document.getElementById('openings'));
            });
        });

        // URL se filter: /careers?department=sales
        var params = new URLSearchParams(window.location.search);
        var dep = params.get('department');
        if (dep && teams[dep]) {
            filterJobs(dep);
            showTeam(dep);
        }

        /* ---------- 3. Apply buttons -> form auto-fill ---------- */
        var form = document.getElementById('careerForm');
        var posInput = document.getElementById('position');
        var depSelect = document.getElementById('c_department');
        var citySel = document.getElementById('c_city');

        document.querySelectorAll('#jobList .js-apply').forEach(function(btn) {
            btn.addEventListener('click', function() {
                if (posInput) {
                    posInput.value = btn.dataset.position || '';
                }

                if (depSelect) {
                    depSelect.value = btn.dataset.department || '';
                }

                if (
                    citySel &&
                    btn.dataset.city &&
                    Array.from(citySel.options).some(function(option) {
                        return option.value === btn.dataset.city;
                    })
                ) {
                    citySel.value = btn.dataset.city;
                }

                scrollToEl(document.getElementById('applyForm'));

                var nameInput = document.getElementById('c_name');
                if (nameInput) {
                    setTimeout(function() {
                        nameInput.focus({
                            preventScroll: true
                        });
                    }, 500);
                }
            });
        });

        /* ---------- 4. Resume upload ---------- */
        var drop = document.getElementById('resumeDrop');
        var fileInput = document.getElementById('c_resume');
        var fileLabel = document.getElementById('fileLabel');
        var fileHint = document.getElementById('fileHint');
        var fileError = document.getElementById('fileError');
        var MAX = 3 * 1024 * 1024;

        function showFile() {
            var f = fileInput.files[0];
            fileError.hidden = true;

            if (!f) {
                drop.classList.remove('has-file');
                fileLabel.textContent = 'Click to upload or drag your resume here';
                fileHint.textContent = 'PDF, DOC or DOCX · max 3MB';
                return;
            }
            if (!/\.(pdf|docx?)$/i.test(f.name)) {
                fileError.textContent = 'Please upload a PDF, DOC or DOCX file.';
                fileError.hidden = false;
                fileInput.value = '';
                return showFile();
            }
            if (f.size > MAX) {
                fileError.textContent = 'File is larger than 3MB. Please upload a smaller file.';
                fileError.hidden = false;
                fileInput.value = '';
                return showFile();
            }
            drop.classList.add('has-file');
            fileLabel.textContent = f.name;
            fileHint.textContent = (f.size / 1024 / 1024).toFixed(2) + ' MB · click to change';
        }

        fileInput.addEventListener('change', showFile);

        ['dragenter', 'dragover'].forEach(function(ev) {
            drop.addEventListener(ev, function(e) {
                e.preventDefault();
                drop.classList.add('is-drag');
            });
        });
        ['dragleave', 'drop'].forEach(function(ev) {
            drop.addEventListener(ev, function(e) {
                e.preventDefault();
                drop.classList.remove('is-drag');
            });
        });
        drop.addEventListener('drop', function(e) {
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                showFile();
            }
        });

        /* ---------- 5. Simple client validation ---------- */
        form.addEventListener('submit', function(e) {
            var firstBad = null;
            form.querySelectorAll('[required]').forEach(function(el) {
                var bad = el.type === 'checkbox' ? !el.checked : !String(el.value).trim();
                if (el.type === 'file') {
                    bad = !el.files.length;
                    drop.style.borderColor = bad ? '#f87171' : '';
                } else if (el.classList.contains('car-input')) {
                    el.classList.toggle('is-invalid', bad);
                }
                if (bad && !firstBad) firstBad = el;
            });

            if (firstBad) {
                e.preventDefault();
                scrollToEl(firstBad.closest('.car-field'));
                if (firstBad.type !== 'file') firstBad.focus({
                    preventScroll: true
                });
                return;
            }

            var btn = document.getElementById('careerSubmit');
            btn.disabled = true;
            btn.querySelector('span').textContent = 'Submitting...';
        });

        form.addEventListener('input', function(e) {
            if (e.target.classList.contains('is-invalid') && String(e.target.value).trim()) {
                e.target.classList.remove('is-invalid');
            }
        });

        // Validation error ke baad page form pe hi khule
        @if($errors -> any() || session('success'))
        scrollToEl(document.getElementById('applyForm'));
        @endif
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // ---------- Fetch jobs from API and render ----------
        var jobList = document.getElementById('jobList');
        var jobLoading = document.getElementById('jobLoading');
        var jobEmpty = document.getElementById('jobEmpty');
        var allJobs = [];

        if (!jobList) {
            return;
        }

        var miniIcons = {
            pin: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg>',
            clock: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>',
            cap: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M22 10 12 5 2 10l10 5 10-5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>',
            lang: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m5 8 6 6"/><path d="m4 14 6-6 2-3"/><path d="M2 5h12"/></svg>',
            arrow: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>'
        };

        function esc(value) {
            return String(value == null ? '' : value).replace(/[&<>"']/g, function(char) {
                return {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#39;'
                } [char];
            });
        }

        function renderJobCard(job) {
            var department = job.department || job.dept || '';
            var departmentName = job.department_name || job.departmentName || department;
            var city = job.city || '';
            var workMode = job.work_mode || job.workMode || '';
            var shift = job.shift || '';
            var jobType = job.job_type || job.jobType || '';
            var experience = job.experience || '';
            var languages = job.languages || '';
            var salary = job.salary || 'Not disclosed';
            var salaryPeriod = job.salary_period || job.salaryPeriod || 'month';
            var title = job.title || 'Open Position';

            var firstSpec = workMode && workMode !== 'On-site' ?
                [miniIcons.pin, workMode] :
                [miniIcons.pin, 'On-site'];

            var secondSpec = shift ?
                [miniIcons.clock, shift + ' shift'] :
                [miniIcons.clock, jobType || 'Full-time'];

            var thirdSpec = languages ?
                [miniIcons.lang, languages] :
                [miniIcons.cap, experience || 'Experience not specified'];

            var specs = [firstSpec, secondSpec, thirdSpec];

            var specsHtml = specs.map(function(spec) {
                return '<li>' + spec[0] + ' ' + esc(spec[1]) + '</li>';
            }).join('');

            return (
                '<article class="car-job" data-dept="' + esc(department) + '">' +
                '<div class="car-job-top">' +
                '<span class="car-ic">' + miniIcons.cap + '</span>' +
                '<div>' +
                '<span class="car-job-tag">' + esc(departmentName) + ' · ' + esc(city) + '</span>' +
                '<h3>' + esc(title) + '</h3>' +
                '</div>' +
                '</div>' +

                (job.description ?
                    '<p class="car-job-desc">' + esc(job.description) + '</p>' :
                    '') +

                '<ul class="car-job-specs">' + specsHtml + '</ul>' +

                '<div class="car-job-foot">' +
                '<div class="car-salary">' +
                '<strong>' + esc(salary) + '</strong>' +
                '<small>per ' + esc(salaryPeriod) + '</small>' +
                '</div>' +

                '<button type="button" class="car-btn car-btn-soft car-btn-sm js-apply" ' +
                'data-position="' + esc(title) + '" ' +
                'data-department="' + esc(department) + '" ' +
                'data-city="' + esc(city) + '">' +
                'Apply ' + miniIcons.arrow +
                '</button>' +
                '</div>' +
                '</article>'
            );
        }

        function updateCounts() {
            var allCount = document.getElementById('cnt-all');

            if (allCount) {
                allCount.textContent = allJobs.length;
            }

            var byDept = {};

            allJobs.forEach(function(job) {
                var key = job.department || job.dept;

                if (key) {
                    byDept[key] = (byDept[key] || 0) + 1;
                }
            });

            Object.keys(byDept).forEach(function(key) {
                var el = document.getElementById('cnt-' + key);

                if (el) {
                    el.textContent = byDept[key];
                }
            });
        }

        function bindApplyButtons() {
            document.querySelectorAll('#jobList .js-apply').forEach(function(btn) {
                if (btn.dataset.bound === '1') {
                    return;
                }

                btn.dataset.bound = '1';

                btn.addEventListener('click', function() {
                    var positionInput = document.getElementById('position');
                    var departmentSelect = document.getElementById('c_department');
                    var citySelect = document.getElementById('c_city');
                    var applyForm = document.getElementById('applyForm');
                    var nameInput = document.getElementById('c_name');

                    if (positionInput) {
                        positionInput.value = btn.dataset.position || '';
                    }

                    if (departmentSelect) {
                        departmentSelect.value = btn.dataset.department || '';
                    }

                    if (
                        citySelect &&
                        btn.dataset.city &&
                        Array.from(citySelect.options).some(function(option) {
                            return option.value === btn.dataset.city;
                        })
                    ) {
                        citySelect.value = btn.dataset.city;
                    }

                    if (applyForm) {
                        scrollToEl(applyForm);
                    }

                    if (nameInput) {
                        setTimeout(function() {
                            nameInput.focus({
                                preventScroll: true
                            });
                        }, 500);
                    }
                });
            });
        }

        fetch('{{ url("/api/v1/careers/jobs") }}', {
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('HTTP ' + response.status);
                }

                return response.json();
            })
            .then(function(response) {
                allJobs = Array.isArray(response) ?
                    response :
                    (Array.isArray(response.data) ? response.data : []);

                if (jobLoading) {
                    jobLoading.hidden = true;
                }

                if (!allJobs.length) {
                    if (jobEmpty) {
                        jobEmpty.hidden = false;
                    }
                    return;
                }

                jobList.innerHTML = allJobs.map(renderJobCard).join('');

                updateCounts();
                bindApplyButtons();

                // API se cards replace hone ke baad current active filter dobara apply karo.
                var activeFilter = document.querySelector('.car-filter.is-active');
                filterJobs(activeFilter ? activeFilter.dataset.filter : 'all');
            })
            .catch(function(error) {
                console.error('Careers API error:', error);

                if (jobLoading) {
                    jobLoading.textContent = 'Could not load openings. Please refresh.';
                }

                // Server-rendered jobs available hon to unko visible rehne do.
                bindApplyButtons();
                filterJobs('all');
            });
    });
</script>
@endsection