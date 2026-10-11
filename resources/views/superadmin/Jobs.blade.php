
@extends('front.main')

@section('title', 'Careers – Job openings')

@section('content')

<style>
    .cr {
        --ink: #051A13; --green: #0F4A35; --lime: #C8F542; --lime-2: #B5E62C;
        --bg: #F0F7F3; --line: #DCEBE2; --muted: #64748b; --muted-2: #94a3b8;
        --r: 16px;
        color: var(--ink);
    }
    .cr *, .cr *::before, .cr *::after { box-sizing: border-box; }
    .cr h1, .cr h2, .cr h3, .cr p { margin: 0; }
    .cr button, .cr input, .cr select, .cr textarea { font: inherit; color: inherit; }
    .cr svg { width: 16px; height: 16px; flex-shrink: 0; }
    .cr [hidden] { display: none !important; }

    /* Head */
    .cr-head { display: flex; flex-wrap: wrap; align-items: flex-end; justify-content: space-between; gap: 12px; margin-bottom: 18px; }
    .cr-crumb { font-size: 12px; color: var(--muted); }
    .cr-title { margin-top: 4px; font-size: 24px; font-weight: 800; letter-spacing: -.02em; }
    .cr-sub { margin-top: 2px; font-size: 13px; color: var(--muted); }

    /* Buttons */
    .cr-btn {
        display: inline-flex; align-items: center; justify-content: center; gap: 7px; height: 40px; padding: 0 16px;
        border: 1px solid var(--line); border-radius: 12px; background: #fff; cursor: pointer;
        font-size: 13px; font-weight: 700; transition: background .15s, border-color .15s, color .15s, transform .15s;
    }
    .cr-btn:hover { border-color: var(--green); }
    .cr-btn:disabled { opacity: .55; cursor: not-allowed; }
    .cr-btn-lime { background: linear-gradient(180deg, #DBFF6E, var(--lime)); border-color: var(--lime); color: var(--ink); }
    .cr-btn-lime:hover { background: var(--lime-2); }
    .cr-btn-dark { background: var(--ink); border-color: var(--ink); color: #fff; }
    .cr-btn-dark:hover { background: var(--green); }
    .cr-btn-danger { background: #dc2626; border-color: #dc2626; color: #fff; }
    .cr-btn-danger:hover { background: #b91c1c; border-color: #b91c1c; }
    .cr-icon-btn {
        display: inline-grid; place-items: center; width: 34px; height: 34px; border: 1px solid var(--line); border-radius: 10px;
        background: #fff; color: var(--green); cursor: pointer; transition: background .15s, color .15s, border-color .15s;
    }
    .cr-icon-btn:hover { background: var(--ink); color: var(--lime); border-color: var(--ink); }
    .cr-icon-btn.is-danger:hover { background: #dc2626; color: #fff; border-color: #dc2626; }

    /* Stats */
    .cr-stats { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-bottom: 16px; }
    .cr-stat {
        position: relative; display: flex; flex-direction: column; gap: 4px; padding: 14px; text-align: left; cursor: pointer;
        border: 1px solid var(--line); border-radius: var(--r); background: #fff; transition: border-color .15s, box-shadow .15s, transform .15s;
    }
    .cr-stat:hover { transform: translateY(-2px); box-shadow: 0 12px 24px -16px rgba(5, 26, 19, .35); }
    .cr-stat.is-active { border-color: var(--ink); box-shadow: 0 0 0 2px var(--ink) inset; }
    .cr-stat small { display: flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: var(--muted); }
    .cr-stat small i { width: 8px; height: 8px; border-radius: 50%; }
    .cr-stat strong { font-size: 22px; font-weight: 800; line-height: 1.1; }

    /* Toolbar */
    .cr-card { border: 1px solid var(--line); border-radius: 20px; background: #fff; overflow: hidden; }
    .cr-toolbar { display: grid; gap: 10px; padding: 14px; border-bottom: 1px solid var(--line); background: #FBFDFB; }
    .cr-search { position: relative; }
    .cr-search svg { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--muted-2); }
    .cr-input, .cr-select, .cr-textarea {
        width: 100%; height: 40px; padding: 0 12px; border: 1px solid var(--line); border-radius: 11px; background: #fff;
        font-size: 13px; outline: none; transition: border-color .15s, box-shadow .15s;
    }
    .cr-search .cr-input { padding-left: 36px; }
    .cr-input:focus, .cr-select:focus, .cr-textarea:focus { border-color: var(--green); box-shadow: 0 0 0 3px rgba(200, 245, 66, .3); }
    .cr-select { cursor: pointer; }
    .cr-textarea { height: 96px; padding: 10px 12px; resize: vertical; line-height: 1.5; }
    .cr-filters { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .cr-reset { height: 40px; }

    /* Table */
    .cr-table-wrap { overflow-x: auto; }
    .cr-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .cr-table th {
        position: sticky; top: 0; padding: 11px 14px; background: #F6FAF7; border-bottom: 1px solid var(--line);
        text-align: left; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: .06em; color: var(--muted); white-space: nowrap;
    }
    .cr-table th button { display: inline-flex; align-items: center; gap: 4px; padding: 0; border: 0; background: none; cursor: pointer; font: inherit; color: inherit; text-transform: inherit; letter-spacing: inherit; }
    .cr-table th button:hover { color: var(--ink); }
    .cr-table th button svg { width: 12px; height: 12px; opacity: .4; }
    .cr-table th button.is-sorted { color: var(--ink); }
    .cr-table th button.is-sorted svg { opacity: 1; }
    .cr-table td { padding: 12px 14px; border-bottom: 1px solid #EEF4F0; vertical-align: middle; }
    .cr-table tbody tr { transition: background .12s; }
    .cr-table tbody tr:hover { background: #FAFCFA; }
    .cr-person { display: flex; align-items: center; gap: 10px; min-width: 200px; }
    .cr-avatar { display: grid; place-items: center; width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0; background: linear-gradient(145deg, var(--lime), #8FE3A8); font-weight: 800; font-size: 14px; }
    .cr-person strong { display: block; font-weight: 700; }
    .cr-person small, .cr-muted { font-size: 12px; color: var(--muted); }
    .cr-pos strong { display: block; font-weight: 700; }
    .cr-actions { display: flex; gap: 6px; justify-content: flex-end; }

    /* Status badge */
    .cr-badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 999px; font-size: 11.5px; font-weight: 700; text-transform: capitalize; white-space: nowrap; }
    .cr-badge::before { content: ""; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
    .st-pending     { background: #FEF3C7; color: #92400E; }
    .st-reviewed    { background: #DBEAFE; color: #1E40AF; }
    .st-shortlisted { background: #EDE9FE; color: #5B21B6; }
    .st-rejected    { background: #FEE2E2; color: #991B1B; }
    .st-hired       { background: #DCFCE7; color: #166534; }

    /* Skeleton / empty */
    .cr-skel { height: 14px; border-radius: 6px; background: linear-gradient(90deg, #EEF4F0 25%, #F7FAF8 50%, #EEF4F0 75%); background-size: 200% 100%; animation: cr-shimmer 1.2s infinite; }
    @keyframes cr-shimmer { to { background-position: -200% 0; } }
    .cr-empty { padding: 48px 20px; text-align: center; }
    .cr-empty-ic { display: inline-grid; place-items: center; width: 56px; height: 56px; margin-bottom: 12px; border-radius: 16px; background: var(--bg); color: var(--green); }
    .cr-empty-ic svg { width: 26px; height: 26px; }
    .cr-empty strong { display: block; font-size: 15px; }
    .cr-empty p { margin-top: 4px; font-size: 13px; color: var(--muted); }

    /* Footer / pagination */
    .cr-foot { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 10px; padding: 12px 14px; }
    .cr-foot-info { font-size: 12.5px; color: var(--muted); }
    .cr-foot-right { display: flex; align-items: center; gap: 10px; }
    .cr-foot-right .cr-select { width: auto; height: 34px; }
    .cr-pages { display: flex; gap: 4px; }
    .cr-page {
        min-width: 34px; height: 34px; padding: 0 8px; border: 1px solid var(--line); border-radius: 10px; background: #fff;
        font-size: 12.5px; font-weight: 700; cursor: pointer;
    }
    .cr-page:hover:not(:disabled) { border-color: var(--green); }
    .cr-page.is-active { background: var(--ink); border-color: var(--ink); color: var(--lime); }
    .cr-page:disabled { opacity: .4; cursor: not-allowed; }

    /* Modal */
    .cr-modal { position: fixed; inset: 0; z-index: 200; display: flex; align-items: flex-end; justify-content: center; padding: 0; }
    .cr-modal-bg { position: absolute; inset: 0; background: rgba(2, 13, 9, .55); backdrop-filter: blur(3px); animation: cr-fade .2s ease; }
    .cr-modal-box {
        position: relative; display: flex; flex-direction: column; width: 100%; max-height: 92vh;
        border-radius: 22px 22px 0 0; background: #fff; box-shadow: 0 30px 80px -20px rgba(0, 0, 0, .5);
        animation: cr-up .28s cubic-bezier(.2, .7, .2, 1);
    }
    .cr-modal-sm .cr-modal-box { max-width: 420px; }
    @keyframes cr-fade { from { opacity: 0; } }
    @keyframes cr-up { from { opacity: 0; transform: translateY(24px); } }
    .cr-modal-head { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 16px 18px; border-bottom: 1px solid var(--line); }
    .cr-modal-head h3 { font-size: 16px; font-weight: 800; }
    .cr-modal-body { overflow-y: auto; padding: 18px; }
    .cr-modal-foot { display: flex; flex-wrap: wrap; justify-content: flex-end; gap: 8px; padding: 14px 18px; border-top: 1px solid var(--line); background: #FBFDFB; border-radius: 0 0 22px 22px; }

    .cr-profile { display: flex; align-items: center; gap: 14px; padding: 16px; border-radius: 16px; background: var(--ink); color: #fff; }
    .cr-profile .cr-avatar { width: 52px; height: 52px; font-size: 20px; }
    .cr-profile strong { display: block; font-size: 17px; font-weight: 800; }
    .cr-profile small { font-size: 12.5px; color: rgba(255, 255, 255, .65); }
    .cr-profile .cr-badge { margin-left: auto; }
    .cr-dl { margin-top: 14px; display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .cr-dl div { padding: 10px 12px; border: 1px solid var(--line); border-radius: 12px; min-width: 0; }
    .cr-dl dt { font-size: 10.5px; font-weight: 800; text-transform: uppercase; letter-spacing: .06em; color: var(--muted); }
    .cr-dl dd { margin: 2px 0 0; font-size: 13.5px; font-weight: 600; word-break: break-word; }
    .cr-dl a { color: var(--green); }
    .cr-block { margin-top: 12px; padding: 12px; border-radius: 12px; background: var(--bg); font-size: 13px; line-height: 1.6; white-space: pre-line; }
    .cr-block-label { margin-top: 14px; font-size: 10.5px; font-weight: 800; text-transform: uppercase; letter-spacing: .06em; color: var(--muted); }
    .cr-resume { margin-top: 14px; display: flex; align-items: center; gap: 12px; padding: 12px; border: 1.5px dashed var(--line); border-radius: 14px; }
    .cr-resume-ic { display: grid; place-items: center; width: 42px; height: 42px; border-radius: 12px; background: var(--lime); font-size: 11px; font-weight: 800; }
    .cr-resume div { flex: 1; min-width: 0; }
    .cr-resume strong { display: block; font-size: 13px; }
    .cr-resume small { font-size: 12px; color: var(--muted); }

    .cr-form-grid { display: grid; gap: 12px; }
    .cr-field label { display: block; margin-bottom: 5px; font-size: 11.5px; font-weight: 700; }
    .cr-field-error { display: block; margin-top: 4px; font-size: 11.5px; color: #dc2626; }
    .cr-field .is-invalid { border-color: #f87171; }
    .cr-status-pick { display: grid; grid-template-columns: repeat(2, 1fr); gap: 6px; }
    .cr-status-pick label { margin: 0; }
    .cr-status-pick input { position: absolute; opacity: 0; pointer-events: none; }
    .cr-status-pick span {
        display: flex; align-items: center; justify-content: center; height: 38px; border: 1px solid var(--line); border-radius: 10px;
        cursor: pointer; font-size: 12.5px; font-weight: 700; text-transform: capitalize; transition: all .15s;
    }
    .cr-status-pick input:checked + span { border-color: var(--ink); background: var(--ink); color: var(--lime); }
    .cr-status-pick input:focus-visible + span { outline: 2px solid var(--green); outline-offset: 2px; }
    .cr-divider { margin: 6px 0 2px; padding-top: 12px; border-top: 1px dashed var(--line); font-size: 10.5px; font-weight: 800; text-transform: uppercase; letter-spacing: .08em; color: var(--muted); }

    .cr-confirm-ic { display: grid; place-items: center; width: 52px; height: 52px; margin-bottom: 12px; border-radius: 16px; background: #FEE2E2; color: #dc2626; }
    .cr-confirm-ic svg { width: 24px; height: 24px; }

    .cr-spin { width: 16px; height: 16px; border: 2px solid currentColor; border-right-color: transparent; border-radius: 50%; animation: cr-rot .7s linear infinite; }
    @keyframes cr-rot { to { transform: rotate(360deg); } }

    /* Toast */
    .cr-toasts { position: fixed; right: 16px; bottom: 16px; z-index: 300; display: grid; gap: 8px; }
    .cr-toast {
        display: flex; align-items: center; gap: 10px; min-width: 240px; max-width: 360px; padding: 12px 14px; border-radius: 14px;
        background: var(--ink); color: #fff; font-size: 13px; font-weight: 600; box-shadow: 0 18px 40px -16px rgba(0, 0, 0, .5);
        animation: cr-up .25s ease;
    }
    .cr-toast.is-error { background: #991B1B; }
    .cr-toast svg { color: var(--lime); }
    .cr-toast.is-error svg { color: #fff; }

    /* ---------- Mobile: table -> cards ---------- */
    @media (max-width: 767px) {
        .cr-table thead { display: none; }
        .cr-table, .cr-table tbody, .cr-table tr, .cr-table td { display: block; width: 100%; }
        .cr-table tr { padding: 12px 14px; border-bottom: 1px solid var(--line); }
        .cr-table td { display: flex; justify-content: space-between; align-items: center; gap: 12px; padding: 5px 0; border: 0; }
        .cr-table td[data-label]::before { content: attr(data-label); font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: var(--muted); }
        .cr-table td.cr-td-person { padding-bottom: 8px; }
        .cr-table td.cr-td-actions { padding-top: 10px; }
        .cr-person { min-width: 0; }
        .cr-actions { width: 100%; }
        .cr-actions .cr-icon-btn { flex: 1; height: 38px; }
        .cr-pos { text-align: right; }
    }

    @media (min-width: 640px) {
        .cr-stats { grid-template-columns: repeat(3, 1fr); }
        .cr-filters { grid-template-columns: repeat(4, 1fr) auto; }
        .cr-dl { grid-template-columns: repeat(3, 1fr); }
        .cr-form-grid { grid-template-columns: repeat(2, 1fr); }
        .cr-field-full { grid-column: 1 / -1; }
        .cr-status-pick { grid-template-columns: repeat(5, 1fr); }
        .cr-modal { align-items: center; padding: 20px; }
        .cr-modal-box { max-width: 760px; border-radius: 22px; }
    }
    @media (min-width: 1024px) {
        .cr-stats { grid-template-columns: repeat(6, 1fr); }
        .cr-toolbar { grid-template-columns: 1fr 2fr; align-items: center; }
    }
    @media (prefers-reduced-motion: reduce) {
        .cr *, .cr-modal *, .cr-toast { animation: none !important; transition: none !important; }
    }

    /* ---------- Job openings page extras ---------- */
    .cr-stats-4 { grid-template-columns: repeat(2, 1fr); }
    @media (min-width: 1024px) { .cr-stats-4 { grid-template-columns: repeat(4, 1fr); } }
    .cr-filters-3 { grid-template-columns: repeat(2, 1fr); }
    @media (min-width: 640px) { .cr-filters-3 { grid-template-columns: repeat(3, 1fr) auto; } }

    .cr-job strong { display: block; font-weight: 800; }
    .cr-job small { font-size: 12px; color: var(--muted); }
    .cr-dept { display: inline-flex; padding: 3px 9px; border-radius: 8px; background: var(--bg); font-size: 11.5px; font-weight: 700; color: var(--green); white-space: nowrap; }
    .cr-num { display: inline-grid; place-items: center; min-width: 30px; height: 26px; padding: 0 8px; border-radius: 8px; background: var(--ink); color: var(--lime); font-size: 12px; font-weight: 800; }
    .cr-apps { font-size: 12px; font-weight: 700; color: var(--green); }

    /* Switch */
    .cr-switch { position: relative; display: inline-flex; align-items: center; gap: 8px; cursor: pointer; font-size: 12px; font-weight: 700; }
    .cr-switch input { position: absolute; opacity: 0; width: 1px; height: 1px; }
    .cr-switch i { position: relative; width: 38px; height: 22px; border-radius: 999px; background: #CBD5E1; transition: background .2s; flex-shrink: 0; }
    .cr-switch i::after { content: ""; position: absolute; left: 3px; top: 3px; width: 16px; height: 16px; border-radius: 50%; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,.25); transition: transform .2s; }
    .cr-switch input:checked + i { background: #22C55E; }
    .cr-switch input:checked + i::after { transform: translateX(16px); }
    .cr-switch input:focus-visible + i { outline: 2px solid var(--green); outline-offset: 2px; }
    .cr-switch input:disabled + i { opacity: .5; }
    .cr-switch em { font-style: normal; color: var(--muted); }
    .cr-switch input:checked ~ em { color: #166534; }

    .cr-live { display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 999px; font-size: 11.5px; font-weight: 700; }
    .cr-live.on { background: #DCFCE7; color: #166534; }
    .cr-live.off { background: #F1F5F9; color: #475569; }

    .cr-req { margin: 8px 0 0; padding-left: 18px; font-size: 13px; line-height: 1.7; }
    .cr-hint { display: block; margin-top: 4px; font-size: 11px; color: var(--muted-2); }
    .cr-req-mark { color: #ef4444; }
</style>

@php
    $svg = fn ($d) => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $d . '</svg>';
    $ic = [
        'search' => $svg('<circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/>'),
        'eye'    => $svg('<path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/><circle cx="12" cy="12" r="3"/>'),
        'edit'   => $svg('<path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/>'),
        'trash'  => $svg('<path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/>'),
        'x'      => $svg('<path d="M18 6 6 18M6 6l12 12"/>'),
        'plus'   => $svg('<path d="M12 5v14M5 12h14"/>'),
        'reset'  => $svg('<path d="M3 12a9 9 0 1 0 3-6.7L3 8"/><path d="M3 3v5h5"/>'),
        'sort'   => $svg('<path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/>'),
        'brief'  => $svg('<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>'),
        'alert'  => $svg('<path d="M12 9v4M12 17h.01"/><path d="M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0z"/>'),
        'check'  => $svg('<circle cx="12" cy="12" r="9"/><path d="m8 12 3 3 5-6"/>'),
        'ext'    => $svg('<path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>'),
    ];
    $departments = \App\Models\CareerJob::DEPARTMENTS;
    $modes   = \App\Models\CareerJob::WORK_MODES;
    $types   = \App\Models\CareerJob::JOB_TYPES;
    $shifts  = \App\Models\CareerJob::SHIFTS;
@endphp

<div class="cr" id="jobsApp" data-icons='@json($ic)'>

    {{-- Head --}}
    <div class="cr-head">
        <div>
            <p class="cr-crumb">Super Admin / Careers</p>
            <h1 class="cr-title">Job openings</h1>
            <p class="cr-sub">Yahan jo jobs active hongi, wahi website ke Careers page pe dikhengi.</p>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap">
            <a href="{{ url('/careers') }}" target="_blank" rel="noopener" class="cr-btn">{!! $ic['ext'] !!} View careers page</a>
            <button type="button" class="cr-btn cr-btn-lime" id="jbAdd">{!! $ic['plus'] !!} Add job</button>
        </div>
    </div>

    {{-- Stats --}}
    <div class="cr-stats cr-stats-4" id="jbStats">
        <button type="button" class="cr-stat is-active" data-status=""><small><i style="background:#051A13"></i> Total jobs</small><strong data-stat="total">–</strong></button>
        <button type="button" class="cr-stat" data-status="active"><small><i style="background:#22C55E"></i> Live</small><strong data-stat="active">–</strong></button>
        <button type="button" class="cr-stat" data-status="inactive"><small><i style="background:#94A3B8"></i> Hidden</small><strong data-stat="inactive">–</strong></button>
        <div class="cr-stat" style="cursor:default"><small><i style="background:#C8F542"></i> Open positions</small><strong data-stat="openings">–</strong></div>
    </div>

    <div class="cr-card">

        {{-- Toolbar --}}
        <div class="cr-toolbar">
            <div class="cr-search">
                {!! $ic['search'] !!}
                <input type="search" class="cr-input" id="jbSearch" placeholder="Search job title or city…" autocomplete="off">
            </div>
            <div class="cr-filters cr-filters-3">
                <select class="cr-select" id="jbDept" aria-label="Department">
                    <option value="">All departments</option>
                    @foreach($departments as $key => $d)
                        <option value="{{ $key }}">{{ $d['name'] }}</option>
                    @endforeach
                </select>
                <select class="cr-select" id="jbMode" aria-label="Work mode">
                    <option value="">All work modes</option>
                    @foreach($modes as $m) <option value="{{ $m }}">{{ $m }}</option> @endforeach
                </select>
                <select class="cr-select" id="jbStatus" aria-label="Status">
                    <option value="">Live + hidden</option>
                    <option value="active">Live only</option>
                    <option value="inactive">Hidden only</option>
                </select>
                <button type="button" class="cr-btn cr-reset" id="jbReset">{!! $ic['reset'] !!} Reset</button>
            </div>
        </div>

        {{-- Table --}}
        <div class="cr-table-wrap">
            <table class="cr-table">
                <thead>
                    <tr>
                        <th><button type="button" data-sort="title">Job title {!! $ic['sort'] !!}</button></th>
                        <th><button type="button" data-sort="department">Department {!! $ic['sort'] !!}</button></th>
                        <th>Work mode</th>
                        <th>Salary</th>
                        <th><button type="button" data-sort="openings">Openings {!! $ic['sort'] !!}</button></th>
                        <th>Applications</th>
                        <th>Live</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody id="jbBody"></tbody>
            </table>
        </div>

        <div class="cr-empty" id="jbEmpty" hidden>
            <span class="cr-empty-ic">{!! $ic['brief'] !!}</span>
            <strong>No job openings found</strong>
            <p>Naya job add karne ke liye “Add job” dabao.</p>
        </div>

        <div class="cr-foot">
            <span class="cr-foot-info" id="jbInfo">Loading…</span>
            <div class="cr-foot-right">
                <select class="cr-select" id="jbPerPage" aria-label="Rows per page">
                    <option value="10">10 / page</option>
                    <option value="25">25 / page</option>
                    <option value="50">50 / page</option>
                </select>
                <div class="cr-pages" id="jbPages"></div>
            </div>
        </div>
    </div>


    {{-- ===================== FORM MODAL (Add + Edit) ===================== --}}
    <div class="cr-modal" id="formModal" role="dialog" aria-modal="true" aria-labelledby="formTitle" hidden>
        <div class="cr-modal-bg" data-close></div>
        <form class="cr-modal-box" id="jobForm" novalidate>
            <div class="cr-modal-head">
                <h3 id="formTitle">Add job opening</h3>
                <button type="button" class="cr-icon-btn" data-close aria-label="Close">{!! $ic['x'] !!}</button>
            </div>

            <div class="cr-modal-body">
                <input type="hidden" name="id">

                <div class="cr-form-grid">

                    <div class="cr-field cr-field-full">
                        <label for="f_title">Job title <span class="cr-req-mark">*</span></label>
                        <input class="cr-input" id="f_title" name="title" placeholder="e.g. Telecaller (Hindi/English)" maxlength="150">
                        <small class="cr-field-error" data-err="title"></small>
                    </div>

                    <div class="cr-field">
                        <label for="f_department">Department <span class="cr-req-mark">*</span></label>
                        <select class="cr-select" id="f_department" name="department">
                            <option value="">Select department</option>
                            @foreach($departments as $key => $d)
                                <option value="{{ $key }}">{{ $d['name'] }}</option>
                            @endforeach
                        </select>
                        <small class="cr-field-error" data-err="department"></small>
                    </div>

                    <div class="cr-field">
                        <label for="f_city">City <span class="cr-req-mark">*</span></label>
                        <input class="cr-input" id="f_city" name="city" placeholder="e.g. Delhi NCR or Remote" list="cityList" maxlength="100">
                        <datalist id="cityList">
                            @foreach(['Delhi NCR', 'Mumbai', 'Bengaluru', 'Pune', 'Hyderabad', 'Chennai', 'Lucknow', 'Remote'] as $c)
                                <option value="{{ $c }}">
                            @endforeach
                        </datalist>
                        <small class="cr-field-error" data-err="city"></small>
                    </div>

                    <div class="cr-field">
                        <label for="f_work_mode">Work mode <span class="cr-req-mark">*</span></label>
                        <select class="cr-select" id="f_work_mode" name="work_mode">
                            @foreach($modes as $m) <option value="{{ $m }}">{{ $m }}</option> @endforeach
                        </select>
                        <small class="cr-field-error" data-err="work_mode"></small>
                    </div>

                    <div class="cr-field">
                        <label for="f_job_type">Job type <span class="cr-req-mark">*</span></label>
                        <select class="cr-select" id="f_job_type" name="job_type">
                            @foreach($types as $t) <option value="{{ $t }}">{{ $t }}</option> @endforeach
                        </select>
                        <small class="cr-field-error" data-err="job_type"></small>
                    </div>

                    <div class="cr-field">
                        <label for="f_shift">Shift</label>
                        <select class="cr-select" id="f_shift" name="shift">
                            <option value="">Not specified</option>
                            @foreach($shifts as $s) <option value="{{ $s }}">{{ $s }}</option> @endforeach
                        </select>
                        <small class="cr-field-error" data-err="shift"></small>
                    </div>

                    <div class="cr-field">
                        <label for="f_experience">Experience <span class="cr-req-mark">*</span></label>
                        <input class="cr-input" id="f_experience" name="experience" placeholder="e.g. 0–2 yrs" maxlength="30">
                        <small class="cr-field-error" data-err="experience"></small>
                    </div>

                    <div class="cr-field">
                        <label for="f_salary">Salary <span class="cr-req-mark">*</span></label>
                        <input class="cr-input" id="f_salary" name="salary" placeholder="e.g. ₹18,000–25,000 or ₹12–18 LPA" maxlength="50">
                        <small class="cr-field-error" data-err="salary"></small>
                    </div>

                    <div class="cr-field">
                        <label for="f_salary_period">Salary per <span class="cr-req-mark">*</span></label>
                        <select class="cr-select" id="f_salary_period" name="salary_period">
                            <option value="month">Month</option>
                            <option value="year">Year</option>
                        </select>
                        <small class="cr-field-error" data-err="salary_period"></small>
                    </div>

                    <div class="cr-field">
                        <label for="f_openings">No. of openings <span class="cr-req-mark">*</span></label>
                        <input class="cr-input" id="f_openings" name="openings" type="number" min="1" max="999" value="1">
                        <small class="cr-field-error" data-err="openings"></small>
                    </div>

                    <div class="cr-field">
                        <label for="f_languages">Languages</label>
                        <input class="cr-input" id="f_languages" name="languages" placeholder="e.g. Hindi, English" maxlength="150">
                        <small class="cr-field-error" data-err="languages"></small>
                    </div>

                    <div class="cr-field cr-field-full">
                        <label for="f_description">Job description</label>
                        <textarea class="cr-textarea" id="f_description" name="description" placeholder="Role ke baare me 2–4 lines…"></textarea>
                        <small class="cr-field-error" data-err="description"></small>
                    </div>

                    <div class="cr-field cr-field-full">
                        <label for="f_requirements">Requirements</label>
                        <textarea class="cr-textarea" id="f_requirements" name="requirements" placeholder="Har line me ek point&#10;Good communication in Hindi&#10;Basic computer knowledge"></textarea>
                        <small class="cr-hint">Har requirement nayi line me likho.</small>
                        <small class="cr-field-error" data-err="requirements"></small>
                    </div>

                    <div class="cr-field">
                        <label for="f_sort_order">Display order</label>
                        <input class="cr-input" id="f_sort_order" name="sort_order" type="number" min="0" placeholder="Auto">
                        <small class="cr-hint">Chhota number = list me upar.</small>
                        <small class="cr-field-error" data-err="sort_order"></small>
                    </div>

                    <div class="cr-field" style="display:flex;align-items:flex-end;padding-bottom:6px">
                        <label class="cr-switch" style="margin:0">
                            <input type="checkbox" name="is_active" checked>
                            <i></i>
                            <em>Show on careers page</em>
                        </label>
                    </div>
                </div>
            </div>

            <div class="cr-modal-foot">
                <button type="button" class="cr-btn" data-close>Cancel</button>
                <button type="submit" class="cr-btn cr-btn-lime" id="formSave">{!! $ic['check'] !!} <span>Save job</span></button>
            </div>
        </form>
    </div>

    {{-- ===================== VIEW MODAL ===================== --}}
    <div class="cr-modal" id="viewModal" role="dialog" aria-modal="true" aria-labelledby="viewTitle" hidden>
        <div class="cr-modal-bg" data-close></div>
        <div class="cr-modal-box">
            <div class="cr-modal-head">
                <h3 id="viewTitle">Job details</h3>
                <button type="button" class="cr-icon-btn" data-close aria-label="Close">{!! $ic['x'] !!}</button>
            </div>
            <div class="cr-modal-body" id="viewBody"></div>
            <div class="cr-modal-foot">
                <button type="button" class="cr-btn" data-close>Close</button>
                <button type="button" class="cr-btn cr-btn-dark" id="viewEditBtn">{!! $ic['edit'] !!} Edit</button>
            </div>
        </div>
    </div>

    {{-- ===================== DELETE MODAL ===================== --}}
    <div class="cr-modal cr-modal-sm" id="deleteModal" role="alertdialog" aria-modal="true" aria-labelledby="deleteTitle" hidden>
        <div class="cr-modal-bg" data-close></div>
        <div class="cr-modal-box">
            <div class="cr-modal-body">
                <span class="cr-confirm-ic">{!! $ic['alert'] !!}</span>
                <h3 id="deleteTitle" style="font-size:17px;font-weight:800">Delete this job?</h3>
                <p style="margin-top:6px;font-size:13px;color:#64748b">
                    “<strong id="deleteName"></strong>” careers page se hat jayega. Is job pe aayi applications delete nahi hongi.
                    <br>Sirf chhupana ho to delete ki jagah “Live” switch band kar do.
                </p>
            </div>
            <div class="cr-modal-foot">
                <button type="button" class="cr-btn" data-close>Cancel</button>
                <button type="button" class="cr-btn cr-btn-danger" id="deleteConfirm">{!! $ic['trash'] !!} <span>Delete</span></button>
            </div>
        </div>
    </div>

    <div class="cr-toasts" id="jbToasts" aria-live="polite"></div>
</div>


<script>
(function () {
    const API   = "{{ url('/api/v1/superadmin/career-jobs') }}";
    const LOGIN = "{{ url('/login') }}";
    const root  = document.getElementById('jobsApp');
    const ICONS = JSON.parse(root.dataset.icons);

    const token     = localStorage.getItem('access_token');
    const tokenType = localStorage.getItem('token_type') || 'Bearer';
    if (!token) { window.location.replace(LOGIN); return; }

    const FIELDS = ['title', 'department', 'city', 'work_mode', 'job_type', 'shift', 'experience', 'salary',
                    'salary_period', 'openings', 'languages', 'description', 'requirements', 'sort_order'];
    const NULLABLE = ['shift', 'languages', 'description', 'requirements', 'sort_order'];

    const state = { page: 1, per_page: 10, search: '', department: '', work_mode: '', status: '',
                    sort: 'sort_order', dir: 'asc', rows: [], current: null, deleteId: null };

    const $ = (id) => document.getElementById(id);
    const body = $('jbBody');
    const form = $('jobForm');
    const el = (name) => form.elements.namedItem(name);

    /* ---------------- Helpers ---------------- */
    const esc = (v) => String(v ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    const dash = (v) => (v === null || v === undefined || v === '') ? '<span class="cr-muted">—</span>' : esc(v);

    function toast(msg, type = 'ok') {
        const t = document.createElement('div');
        t.className = 'cr-toast' + (type === 'error' ? ' is-error' : '');
        t.innerHTML = (type === 'error' ? ICONS.alert : ICONS.check) + '<span>' + esc(msg) + '</span>';
        $('jbToasts').appendChild(t);
        setTimeout(() => t.remove(), 3500);
    }

    function logoutRedirect() {
        ['access_token', 'token_type', 'user', 'role', 'remember_me'].forEach(k => localStorage.removeItem(k));
        window.location.replace(LOGIN);
    }

    async function api(path = '', { method = 'GET', body: payload } = {}) {
        const res = await fetch(API + path, {
            method,
            headers: {
                'Accept': 'application/json',
                'Authorization': tokenType + ' ' + token,
                ...(payload ? { 'Content-Type': 'application/json' } : {}),
            },
            body: payload ? JSON.stringify(payload) : undefined,
        });
        if (res.status === 401) { logoutRedirect(); throw new Error('Session expired'); }
        const data = await res.json().catch(() => ({}));
        if (!res.ok) {
            const err = new Error(data.message || 'Something went wrong. Please try again.');
            err.status = res.status; err.errors = data.errors || null;
            throw err;
        }
        return data;
    }

    /* ---------------- LIST ---------------- */
    function skeleton() {
        $('jbEmpty').hidden = true;
        body.innerHTML = Array.from({ length: 5 }).map(() => `<tr>${'<td><div class="cr-skel"></div></td>'.repeat(8)}</tr>`).join('');
    }

    async function load() {
        skeleton();
        const p = new URLSearchParams();
        ['page', 'per_page', 'search', 'department', 'work_mode', 'status', 'sort', 'dir'].forEach(k => {
            if (state[k] !== '' && state[k] !== null) p.set(k, state[k]);
        });
        try {
            const res = await api('?' + p.toString());
            state.rows = res.data;
            renderRows(res.data);
            renderStats(res.stats);
            renderPager(res.meta);
        } catch (e) {
            body.innerHTML = '';
            $('jbEmpty').hidden = false;
            $('jbInfo').textContent = '';
            if (e.status === 403) toast('Ye page sirf Super Admin ke liye hai.', 'error');
            else if (e.message !== 'Session expired') toast(e.message, 'error');
        }
    }

    function renderRows(rows) {
        $('jbEmpty').hidden = rows.length > 0;
        body.innerHTML = rows.map(j => `
            <tr>
                <td class="cr-td-person">
                    <div class="cr-job"><strong>${esc(j.title)}</strong><small>${esc(j.city)} · ${esc(j.experience)}</small></div>
                </td>
                <td data-label="Department"><span class="cr-dept">${esc(j.department_name)}</span></td>
                <td data-label="Work mode">${esc(j.work_mode)} <span class="cr-muted">· ${esc(j.job_type)}</span></td>
                <td data-label="Salary">${esc(j.salary)} <span class="cr-muted">/${esc(j.salary_period)}</span></td>
                <td data-label="Openings"><span class="cr-num">${j.openings}</span></td>
                <td data-label="Applications"><span class="cr-apps">${j.applications_count}</span></td>
                <td data-label="Live">
                    <label class="cr-switch" title="Show / hide on careers page">
                        <input type="checkbox" data-toggle="${j.id}" ${j.is_active ? 'checked' : ''} aria-label="Live on careers page">
                        <i></i>
                    </label>
                </td>
                <td class="cr-td-actions">
                    <div class="cr-actions">
                        <button type="button" class="cr-icon-btn" data-act="view" data-id="${j.id}" title="View" aria-label="View ${esc(j.title)}">${ICONS.eye}</button>
                        <button type="button" class="cr-icon-btn" data-act="edit" data-id="${j.id}" title="Edit" aria-label="Edit ${esc(j.title)}">${ICONS.edit}</button>
                        <button type="button" class="cr-icon-btn is-danger" data-act="delete" data-id="${j.id}" title="Delete" aria-label="Delete ${esc(j.title)}">${ICONS.trash}</button>
                    </div>
                </td>
            </tr>`).join('');
    }

    function renderStats(stats) {
        Object.entries(stats || {}).forEach(([k, v]) => {
            const s = root.querySelector(`[data-stat="${k}"]`);
            if (s) s.textContent = v;
        });
        root.querySelectorAll('.cr-stat[data-status]').forEach(b => b.classList.toggle('is-active', b.dataset.status === state.status));
    }

    function renderPager(meta) {
        $('jbInfo').textContent = meta.total ? `Showing ${meta.from}–${meta.to} of ${meta.total} jobs` : 'No jobs';
        const cur = meta.current_page, last = meta.last_page;
        let html = `<button type="button" class="cr-page" data-page="${cur - 1}" ${cur <= 1 ? 'disabled' : ''} aria-label="Previous">‹</button>`;
        for (let p = Math.max(1, cur - 2); p <= Math.min(last, cur + 2); p++) {
            html += `<button type="button" class="cr-page ${p === cur ? 'is-active' : ''}" data-page="${p}">${p}</button>`;
        }
        html += `<button type="button" class="cr-page" data-page="${cur + 1}" ${cur >= last ? 'disabled' : ''} aria-label="Next">›</button>`;
        $('jbPages').innerHTML = html;
    }

    /* ---------------- MODALS ---------------- */
    let lastFocus = null;
    function openModal(id) {
        lastFocus = document.activeElement;
        $(id).hidden = false;
        document.body.style.overflow = 'hidden';
    }
    function closeModal(id) {
        $(id).hidden = true;
        if (!root.querySelector('.cr-modal:not([hidden])')) document.body.style.overflow = '';
        lastFocus?.focus?.();
    }
    root.querySelectorAll('.cr-modal').forEach(m => m.addEventListener('click', e => {
        if (e.target.closest('[data-close]')) closeModal(m.id);
    }));
    document.addEventListener('keydown', e => {
        if (e.key !== 'Escape') return;
        const open = [...root.querySelectorAll('.cr-modal:not([hidden])')].pop();
        if (open) closeModal(open.id);
    });

    /* ---------------- FORM (Add + Edit) ---------------- */
    function clearErrors() {
        form.querySelectorAll('[data-err]').forEach(x => x.textContent = '');
        form.querySelectorAll('.is-invalid').forEach(x => x.classList.remove('is-invalid'));
    }

    function openForm(job = null) {
        clearErrors();
        form.reset();
        el('id').value = job ? job.id : '';
        $('formTitle').textContent = job ? 'Edit job · ' + job.title : 'Add job opening';
        $('formSave').querySelector('span').textContent = job ? 'Save changes' : 'Add job';

        if (job) {
            FIELDS.forEach(f => { const x = el(f); if (x) x.value = job[f] ?? ''; });
            el('is_active').checked = !!job.is_active;
        } else {
            el('openings').value = 1;
            el('is_active').checked = true;
            if (state.department) el('department').value = state.department;
        }
        openModal('formModal');
        setTimeout(() => el('title').focus(), 60);
    }

    // Simple client-side check (server bhi validate karta hai)
    function clientValidate(p) {
        const errs = {};
        ['title', 'department', 'city', 'work_mode', 'job_type', 'experience', 'salary', 'salary_period'].forEach(f => {
            if (!p[f]) errs[f] = ['This field is required.'];
        });
        if (!p.openings || p.openings < 1) errs.openings = ['At least 1 opening is required.'];
        return errs;
    }

    function showErrors(errors) {
        Object.entries(errors).forEach(([f, msgs]) => {
            const box = form.querySelector(`[data-err="${f}"]`);
            if (box) box.textContent = msgs[0];
            const x = el(f); if (x && x.classList) x.classList.add('is-invalid');
        });
        const first = form.querySelector('.is-invalid');
        first?.focus();
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        clearErrors();

        const id = el('id').value;
        const payload = {};
        FIELDS.forEach(f => {
            let v = el(f).value.trim();
            if (NULLABLE.includes(f) && v === '') v = null;
            payload[f] = v;
        });
        payload.openings  = payload.openings ? Number(payload.openings) : null;
        if (payload.sort_order !== null) payload.sort_order = Number(payload.sort_order);
        payload.is_active = el('is_active').checked;

        const errs = clientValidate(payload);
        if (Object.keys(errs).length) { showErrors(errs); return; }

        const btn = $('formSave'), label = btn.querySelector('span'), old = label.textContent;
        btn.disabled = true; label.textContent = 'Saving…';

        try {
            const res = id
                ? await api('/' + id, { method: 'PATCH', body: payload })
                : await api('', { method: 'POST', body: payload });
            toast(res.message || 'Saved');
            closeModal('formModal');
            if (!id) state.page = 1;
            load();
        } catch (err) {
            if (err.errors) { showErrors(err.errors); toast('Please fix the highlighted fields.', 'error'); }
            else toast(err.message, 'error');
        } finally {
            btn.disabled = false; label.textContent = old;
        }
    });

    /* ---------------- VIEW ---------------- */
    async function openView(id) {
        $('viewBody').innerHTML = '<div class="cr-skel" style="height:70px"></div><div class="cr-skel" style="height:160px;margin-top:12px"></div>';
        openModal('viewModal');
        try {
            const { data: j } = await api('/' + id);
            state.current = j;
            $('viewBody').innerHTML = `
                <div class="cr-profile">
                    <span class="cr-avatar">${esc(j.title.charAt(0).toUpperCase())}</span>
                    <div><strong>${esc(j.title)}</strong><small>${esc(j.department_name)} · ${esc(j.city)}</small></div>
                    <span class="cr-live ${j.is_active ? 'on' : 'off'}" style="margin-left:auto">${j.is_active ? '● Live' : '○ Hidden'}</span>
                </div>
                <dl class="cr-dl">
                    <div><dt>Work mode</dt><dd>${esc(j.work_mode)}</dd></div>
                    <div><dt>Job type</dt><dd>${esc(j.job_type)}</dd></div>
                    <div><dt>Shift</dt><dd>${dash(j.shift)}</dd></div>
                    <div><dt>Experience</dt><dd>${esc(j.experience)}</dd></div>
                    <div><dt>Salary</dt><dd>${esc(j.salary_label)}</dd></div>
                    <div><dt>Openings</dt><dd>${j.openings}</dd></div>
                    <div><dt>Languages</dt><dd>${dash(j.languages)}</dd></div>
                    <div><dt>Applications</dt><dd>${j.applications_count}</dd></div>
                    <div><dt>Display order</dt><dd>${j.sort_order}</dd></div>
                </dl>
                <p class="cr-block-label">Description</p>
                <div class="cr-block">${j.description ? esc(j.description) : '<span class="cr-muted">No description</span>'}</div>
                <p class="cr-block-label">Requirements</p>
                ${j.requirements_list.length
                    ? '<ul class="cr-req">' + j.requirements_list.map(r => `<li>${esc(r)}</li>`).join('') + '</ul>'
                    : '<div class="cr-block"><span class="cr-muted">No requirements added</span></div>'}
                <p class="cr-muted" style="margin-top:14px;font-size:12px">Created ${esc(j.created_date)} · Updated ${esc(j.updated_human)}</p>`;
        } catch (e) {
            $('viewBody').innerHTML = `<p class="cr-muted">${esc(e.message)}</p>`;
        }
    }

    $('viewEditBtn').addEventListener('click', () => {
        if (!state.current) return;
        closeModal('viewModal');
        openForm(state.current);
    });

    async function openEdit(id) {
        try {
            const { data } = await api('/' + id);
            openForm(data);
        } catch (e) { toast(e.message, 'error'); }
    }

    /* ---------------- DELETE ---------------- */
    function openDelete(id) {
        const row = state.rows.find(r => r.id === id);
        state.deleteId = id;
        $('deleteName').textContent = row ? row.title : 'This job';
        openModal('deleteModal');
    }

    $('deleteConfirm').addEventListener('click', async function () {
        if (!state.deleteId) return;
        const label = this.querySelector('span');
        this.disabled = true; label.textContent = 'Deleting…';
        try {
            const res = await api('/' + state.deleteId, { method: 'DELETE' });
            toast(res.message || 'Deleted');
            closeModal('deleteModal');
            if (state.rows.length === 1 && state.page > 1) state.page--;
            load();
        } catch (e) {
            toast(e.message, 'error');
        } finally {
            this.disabled = false; label.textContent = 'Delete'; state.deleteId = null;
        }
    });

    /* ---------------- TOGGLE LIVE ---------------- */
    body.addEventListener('change', async (e) => {
        const cb = e.target.closest('[data-toggle]');
        if (!cb) return;
        cb.disabled = true;
        try {
            const res = await api('/' + cb.dataset.toggle + '/toggle', { method: 'PATCH' });
            cb.checked = !!res.is_active;
            toast(res.message);
            load();
        } catch (err) {
            cb.checked = !cb.checked;   // wapas pehle jaisa
            toast(err.message, 'error');
        } finally {
            cb.disabled = false;
        }
    });

    /* ---------------- EVENTS ---------------- */
    body.addEventListener('click', (e) => {
        const b = e.target.closest('[data-act]');
        if (!b) return;
        const id = Number(b.dataset.id);
        if (b.dataset.act === 'view') openView(id);
        if (b.dataset.act === 'edit') openEdit(id);
        if (b.dataset.act === 'delete') openDelete(id);
    });

    $('jbAdd').addEventListener('click', () => openForm());

    let t;
    $('jbSearch').addEventListener('input', (e) => {
        clearTimeout(t);
        t = setTimeout(() => { state.search = e.target.value.trim(); state.page = 1; load(); }, 350);
    });

    [['jbDept', 'department'], ['jbMode', 'work_mode'], ['jbStatus', 'status']].forEach(([id, key]) => {
        $(id).addEventListener('change', (e) => { state[key] = e.target.value; state.page = 1; load(); });
    });

    $('jbPerPage').addEventListener('change', (e) => { state.per_page = Number(e.target.value); state.page = 1; load(); });

    $('jbPages').addEventListener('click', (e) => {
        const b = e.target.closest('[data-page]');
        if (!b || b.disabled) return;
        state.page = Number(b.dataset.page);
        load();
    });

    $('jbStats').addEventListener('click', (e) => {
        const b = e.target.closest('[data-status]');
        if (!b) return;
        state.status = b.dataset.status;
        $('jbStatus').value = state.status;
        state.page = 1;
        load();
    });

    root.querySelectorAll('th [data-sort]').forEach(b => b.addEventListener('click', () => {
        const key = b.dataset.sort;
        state.dir = (state.sort === key && state.dir === 'asc') ? 'desc' : 'asc';
        state.sort = key;
        root.querySelectorAll('th [data-sort]').forEach(x => x.classList.toggle('is-sorted', x === b));
        load();
    }));

    $('jbReset').addEventListener('click', () => {
        Object.assign(state, { page: 1, search: '', department: '', work_mode: '', status: '', sort: 'sort_order', dir: 'asc' });
        $('jbSearch').value = '';
        ['jbDept', 'jbMode', 'jbStatus'].forEach(id => $(id).value = '');
        root.querySelectorAll('th [data-sort]').forEach(x => x.classList.remove('is-sorted'));
        load();
    });

    load();
})();
</script>

@endsection