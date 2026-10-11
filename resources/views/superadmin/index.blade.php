@extends('front.main')

@section('title', 'Careers – Applications')

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
</style>

@php
    $svg = fn ($d) => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $d . '</svg>';
    $ic = [
        'search' => $svg('<circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/>'),
        'eye'    => $svg('<path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/><circle cx="12" cy="12" r="3"/>'),
        'edit'   => $svg('<path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/>'),
        'trash'  => $svg('<path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/>'),
        'x'      => $svg('<path d="M18 6 6 18M6 6l12 12"/>'),
        'reload' => $svg('<path d="M21 12a9 9 0 1 1-3-6.7L21 8"/><path d="M21 3v5h-5"/>'),
        'reset'  => $svg('<path d="M3 12a9 9 0 1 0 3-6.7L3 8"/><path d="M3 3v5h5"/>'),
        'sort'   => $svg('<path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/>'),
        'down'   => $svg('<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="m7 10 5 5 5-5"/><path d="M12 15V3"/>'),
        'brief'  => $svg('<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>'),
        'alert'  => $svg('<path d="M12 9v4M12 17h.01"/><path d="M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0z"/>'),
        'check'  => $svg('<circle cx="12" cy="12" r="9"/><path d="m8 12 3 3 5-6"/>'),
    ];
    $statusColors = ['pending' => '#F59E0B', 'reviewed' => '#3B82F6', 'shortlisted' => '#8B5CF6', 'rejected' => '#EF4444', 'hired' => '#22C55E'];
@endphp

<div class="cr" id="careersApp" data-icons='@json($ic)'>

    {{-- Head --}}
    <div class="cr-head">
        <div>
            <p class="cr-crumb">Super Admin / Careers</p>
            <h1 class="cr-title">Careers list</h1>
            <p class="cr-sub">Website ke careers form se aayi saari applications.</p>
        </div>
        <button type="button" class="cr-btn" id="crReload">{!! $ic['reload'] !!} Refresh</button>
    </div>

    {{-- Stats (click = filter) --}}
    <div class="cr-stats" id="crStats">
        <button type="button" class="cr-stat is-active" data-status="">
            <small><i style="background:#051A13"></i> Total</small><strong data-stat="total">–</strong>
        </button>
        @foreach($statusColors as $status => $color)
            <button type="button" class="cr-stat" data-status="{{ $status }}">
                <small><i style="background:{{ $color }}"></i> {{ ucfirst($status) }}</small><strong data-stat="{{ $status }}">–</strong>
            </button>
        @endforeach
    </div>

    <div class="cr-card">

        {{-- Toolbar --}}
        <div class="cr-toolbar">
            <div class="cr-search">
                {!! $ic['search'] !!}
                <input type="search" class="cr-input" id="crSearch" placeholder="Search name, email, phone or position…" autocomplete="off">
            </div>
            <div class="cr-filters">
                <select class="cr-select" id="crStatus" aria-label="Status">
                    <option value="">All status</option>
                    @foreach(array_keys($statusColors) as $s)
                        <option value="{{ $s }}">{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <select class="cr-select" id="crDept" aria-label="Department"><option value="">All departments</option></select>
                <select class="cr-select" id="crCity" aria-label="City"><option value="">All cities</option></select>
                <select class="cr-select" id="crExp" aria-label="Experience">
                    <option value="">All experience</option>
                    <option value="Fresher">Fresher</option>
                    <option value="0-1">0 – 1 years</option>
                    <option value="1-3">1 – 3 years</option>
                    <option value="3-5">3 – 5 years</option>
                    <option value="5+">5+ years</option>
                </select>
                <button type="button" class="cr-btn cr-reset" id="crReset" title="Clear filters">{!! $ic['reset'] !!} Reset</button>
            </div>
        </div>

        {{-- Table --}}
        <div class="cr-table-wrap">
            <table class="cr-table">
                <thead>
                    <tr>
                        <th><button type="button" data-sort="name">Applicant {!! $ic['sort'] !!}</button></th>
                        <th>Phone</th>
                        <th><button type="button" data-sort="position">Position {!! $ic['sort'] !!}</button></th>
                        <th><button type="button" data-sort="city">City {!! $ic['sort'] !!}</button></th>
                        <th>Experience</th>
                        <th><button type="button" data-sort="created_at" class="is-sorted">Applied {!! $ic['sort'] !!}</button></th>
                        <th><button type="button" data-sort="status">Status {!! $ic['sort'] !!}</button></th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody id="crBody"></tbody>
            </table>
        </div>

        <div class="cr-empty" id="crEmpty" hidden>
            <span class="cr-empty-ic">{!! $ic['brief'] !!}</span>
            <strong>No applications found</strong>
            <p>Search ya filters badal ke dekho.</p>
        </div>

        {{-- Footer --}}
        <div class="cr-foot">
            <span class="cr-foot-info" id="crInfo">Loading…</span>
            <div class="cr-foot-right">
                <select class="cr-select" id="crPerPage" aria-label="Rows per page">
                    <option value="10">10 / page</option>
                    <option value="25">25 / page</option>
                    <option value="50">50 / page</option>
                </select>
                <div class="cr-pages" id="crPages"></div>
            </div>
        </div>
    </div>


    {{-- ===================== VIEW MODAL ===================== --}}
    <div class="cr-modal" id="viewModal" role="dialog" aria-modal="true" aria-labelledby="viewTitle" hidden>
        <div class="cr-modal-bg" data-close></div>
        <div class="cr-modal-box">
            <div class="cr-modal-head">
                <h3 id="viewTitle">Application details</h3>
                <button type="button" class="cr-icon-btn" data-close aria-label="Close">{!! $ic['x'] !!}</button>
            </div>
            <div class="cr-modal-body" id="viewBody"></div>
            <div class="cr-modal-foot">
                <button type="button" class="cr-btn" data-close>Close</button>
                <button type="button" class="cr-btn cr-btn-dark" id="viewEditBtn">{!! $ic['edit'] !!} Edit</button>
            </div>
        </div>
    </div>

    {{-- ===================== EDIT MODAL ===================== --}}
    <div class="cr-modal" id="editModal" role="dialog" aria-modal="true" aria-labelledby="editTitle" hidden>
        <div class="cr-modal-bg" data-close></div>
        <form class="cr-modal-box" id="editForm" novalidate>
            <div class="cr-modal-head">
                <h3 id="editTitle">Edit application</h3>
                <button type="button" class="cr-icon-btn" data-close aria-label="Close">{!! $ic['x'] !!}</button>
            </div>
            <div class="cr-modal-body">
                <input type="hidden" name="id">

                <div class="cr-form-grid">
                    <div class="cr-field cr-field-full">
                        <label>Status</label>
                        <div class="cr-status-pick">
                            @foreach(array_keys($statusColors) as $s)
                                <label><input type="radio" name="status" value="{{ $s }}"><span>{{ $s }}</span></label>
                            @endforeach
                        </div>
                        <small class="cr-field-error" data-err="status"></small>
                    </div>

                    <div class="cr-field cr-field-full">
                        <label for="e_remarks">Admin / HR remarks</label>
                        <textarea class="cr-textarea" id="e_remarks" name="admin_remarks" placeholder="Interview notes, feedback…"></textarea>
                        <small class="cr-field-error" data-err="admin_remarks"></small>
                    </div>

                    <p class="cr-divider cr-field-full">Applicant details</p>

                    @foreach([
                        ['name', 'Full name', 'text'], ['phone', 'Phone', 'tel'], ['email', 'Email', 'email'],
                        ['department', 'Department', 'text'], ['position', 'Position', 'text'], ['city', 'City', 'text'],
                        ['experience', 'Experience', 'text'], ['languages', 'Languages', 'text'],
                        ['expected_salary', 'Expected salary', 'text'], ['notice_period', 'Notice period', 'text'],
                    ] as [$field, $label, $type])
                        <div class="cr-field">
                            <label for="e_{{ $field }}">{{ $label }}</label>
                            <input class="cr-input" id="e_{{ $field }}" type="{{ $type }}" name="{{ $field }}">
                            <small class="cr-field-error" data-err="{{ $field }}"></small>
                        </div>
                    @endforeach

                    <div class="cr-field cr-field-full">
                        <label for="e_message">Cover message</label>
                        <textarea class="cr-textarea" id="e_message" name="message"></textarea>
                        <small class="cr-field-error" data-err="message"></small>
                    </div>
                </div>
            </div>
            <div class="cr-modal-foot">
                <button type="button" class="cr-btn" data-close>Cancel</button>
                <button type="submit" class="cr-btn cr-btn-lime" id="editSave">{!! $ic['check'] !!} <span>Save changes</span></button>
            </div>
        </form>
    </div>

    {{-- ===================== DELETE MODAL ===================== --}}
    <div class="cr-modal cr-modal-sm" id="deleteModal" role="alertdialog" aria-modal="true" aria-labelledby="deleteTitle" hidden>
        <div class="cr-modal-bg" data-close></div>
        <div class="cr-modal-box">
            <div class="cr-modal-body">
                <span class="cr-confirm-ic">{!! $ic['alert'] !!}</span>
                <h3 id="deleteTitle" style="font-size:17px;font-weight:800">Delete this application?</h3>
                <p style="margin-top:6px;font-size:13px;color:#64748b">
                    <strong id="deleteName"></strong> ki application aur resume hamesha ke liye delete ho jayenge. Ye wapas nahi aayega.
                </p>
            </div>
            <div class="cr-modal-foot">
                <button type="button" class="cr-btn" data-close>Cancel</button>
                <button type="button" class="cr-btn cr-btn-danger" id="deleteConfirm">{!! $ic['trash'] !!} <span>Delete</span></button>
            </div>
        </div>
    </div>

    <div class="cr-toasts" id="crToasts" aria-live="polite"></div>
</div>


<script>
(function () {
    /* =========================================================
       CONFIG
    ========================================================= */
    const API      = "{{ url('/api/v1/superadmin/careers') }}";
    const LOGIN    = "{{ url('/login') }}";
    const root     = document.getElementById('careersApp');
    const ICONS    = JSON.parse(root.dataset.icons);

    const token     = localStorage.getItem('access_token');
    const tokenType = localStorage.getItem('token_type') || 'Bearer';
    if (!token) { window.location.replace(LOGIN); return; }

    const state = {
        page: 1, per_page: 10, search: '', status: '', department: '', city: '', experience: '',
        sort: 'created_at', dir: 'desc',
        rows: [], current: null, deleteId: null, optionsLoaded: false,
    };

    const $ = (id) => document.getElementById(id);
    const body = $('crBody');

    /* =========================================================
       HELPERS
    ========================================================= */
    function esc(v) {
        return String(v ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    }
    const dash = (v) => (v === null || v === undefined || v === '') ? '<span class="cr-muted">—</span>' : esc(v);
    const initial = (n) => esc(String(n || '?').trim().charAt(0).toUpperCase());
    const badge = (s) => `<span class="cr-badge st-${esc(s)}">${esc(s)}</span>`;

    // 👇 NEW: normalize any of {data: [...]}, {data:{data:[...]}}, or bare [...] into a plain array
    function extractRows(res) {
        if (Array.isArray(res)) return res;
        if (Array.isArray(res?.data)) return res.data;
        if (Array.isArray(res?.data?.data)) return res.data.data;
        return [];
    }

    // 👇 NEW: normalize pagination meta from either res.meta or a Laravel paginator inside res.data
    function extractMeta(res, rowsLen) {
        if (res?.meta) return res.meta;
        const p = res?.data;
        if (p && !Array.isArray(p) && typeof p === 'object') {
            return {
                current_page: p.current_page ?? 1,
                last_page:    p.last_page ?? 1,
                total:        p.total ?? rowsLen,
                from:         p.from ?? (rowsLen ? 1 : 0),
                to:           p.to ?? rowsLen,
            };
        }
        return { current_page: 1, last_page: 1, total: rowsLen, from: rowsLen ? 1 : 0, to: rowsLen };
    }

    function toast(msg, type = 'ok') {
        const t = document.createElement('div');
        t.className = 'cr-toast' + (type === 'error' ? ' is-error' : '');
        t.innerHTML = (type === 'error' ? ICONS.alert : ICONS.check) + '<span>' + esc(msg) + '</span>';
        $('crToasts').appendChild(t);
        setTimeout(() => t.remove(), 3500);
    }

    function logoutRedirect() {
        ['access_token', 'token_type', 'user', 'role', 'remember_me'].forEach(k => localStorage.removeItem(k));
        window.location.replace(LOGIN);
    }

    // Har API call yahin se (token automatic lagta hai)
    async function api(path = '', { method = 'GET', body: payload, raw = false } = {}) {
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
        if (raw && res.ok) return res;

        const data = await res.json().catch(() => ({}));
        if (!res.ok) {
            const err = new Error(data.message || 'Something went wrong. Please try again.');
            err.status = res.status;
            err.errors = data.errors || null;
            throw err;
        }
        return data;
    }

    /* =========================================================
       LIST
    ========================================================= */
    function skeleton() {
        $('crEmpty').hidden = true;
        body.innerHTML = Array.from({ length: 5 }).map(() =>
            `<tr>${'<td><div class="cr-skel"></div></td>'.repeat(8)}</tr>`).join('');
    }

    async function load() {
        skeleton();
        const params = new URLSearchParams();
        ['page', 'per_page', 'search', 'status', 'department', 'city', 'experience', 'sort', 'dir'].forEach(k => {
            if (state[k] !== '' && state[k] !== null) params.set(k, state[k]);
        });

        try {
            const res = await api('?' + params.toString());

            // 👇 FIX: safely normalize rows + meta, regardless of exact API response shape
            const rows = extractRows(res);
            const meta = extractMeta(res, rows.length);

            state.rows = rows;
            renderRows(rows);
            renderStats(res.stats);
            renderOptions(res.options);
            renderPager(meta);
        } catch (e) {
            body.innerHTML = '';
            $('crEmpty').hidden = false;
            $('crInfo').textContent = '';
            if (e.status === 403) toast('Ye page sirf Super Admin ke liye hai.', 'error');
            else if (e.message !== 'Session expired') toast(e.message, 'error');
        }
    }

    function renderRows(rows) {
        $('crEmpty').hidden = rows.length > 0;
        body.innerHTML = rows.map(r => `
            <tr>
                <td class="cr-td-person">
                    <div class="cr-person">
                        <span class="cr-avatar">${initial(r.name)}</span>
                        <div><strong>${esc(r.name)}</strong><small>${esc(r.email)}</small></div>
                    </div>
                </td>
                <td data-label="Phone"><a href="tel:${esc(r.phone)}">${esc(r.phone)}</a></td>
                <td data-label="Position"><div class="cr-pos"><strong>${esc(r.position)}</strong><span class="cr-muted">${esc(r.department)}</span></div></td>
                <td data-label="City">${esc(r.city)}</td>
                <td data-label="Experience">${esc(r.experience)}</td>
                <td data-label="Applied"><span title="${esc(r.created_date)}">${esc(r.created_human)}</span></td>
                <td data-label="Status">${badge(r.status)}</td>
                <td class="cr-td-actions">
                    <div class="cr-actions">
                        <button type="button" class="cr-icon-btn" data-act="view" data-id="${r.id}" title="View" aria-label="View ${esc(r.name)}">${ICONS.eye}</button>
                        <button type="button" class="cr-icon-btn" data-act="edit" data-id="${r.id}" title="Edit" aria-label="Edit ${esc(r.name)}">${ICONS.edit}</button>
                        <button type="button" class="cr-icon-btn is-danger" data-act="delete" data-id="${r.id}" title="Delete" aria-label="Delete ${esc(r.name)}">${ICONS.trash}</button>
                    </div>
                </td>
            </tr>`).join('');
    }

    function renderStats(stats) {
        Object.entries(stats || {}).forEach(([k, v]) => {
            const el = root.querySelector(`[data-stat="${k}"]`);
            if (el) el.textContent = v;
        });
        root.querySelectorAll('.cr-stat').forEach(b => b.classList.toggle('is-active', b.dataset.status === state.status));
    }

    function renderOptions(opts) {
        if (!opts) return;
        [['crDept', opts.departments, 'All departments', 'department'], ['crCity', opts.cities, 'All cities', 'city']]
            .forEach(([id, list, label, key]) => {
                const sel = $(id);
                sel.innerHTML = `<option value="">${label}</option>` +
                    (list || []).map(v => `<option value="${esc(v)}">${esc(v)}</option>`).join('');
                sel.value = state[key];
            });
    }

    function renderPager(meta) {
        $('crInfo').textContent = meta.total
            ? `Showing ${meta.from}–${meta.to} of ${meta.total} applications`
            : 'No applications';

        const cur = meta.current_page, last = meta.last_page;
        const pages = [];
        const from = Math.max(1, cur - 2), to = Math.min(last, cur + 2);
        for (let p = from; p <= to; p++) pages.push(p);

        $('crPages').innerHTML =
            `<button type="button" class="cr-page" data-page="${cur - 1}" ${cur <= 1 ? 'disabled' : ''} aria-label="Previous">‹</button>` +
            (from > 1 ? `<button type="button" class="cr-page" data-page="1">1</button>${from > 2 ? '<span class="cr-muted" style="padding:0 4px">…</span>' : ''}` : '') +
            pages.map(p => `<button type="button" class="cr-page ${p === cur ? 'is-active' : ''}" data-page="${p}">${p}</button>`).join('') +
            (to < last ? `${to < last - 1 ? '<span class="cr-muted" style="padding:0 4px">…</span>' : ''}<button type="button" class="cr-page" data-page="${last}">${last}</button>` : '') +
            `<button type="button" class="cr-page" data-page="${cur + 1}" ${cur >= last ? 'disabled' : ''} aria-label="Next">›</button>`;
    }

    /* =========================================================
       MODALS
    ========================================================= */
    let lastFocus = null;
    function openModal(id) {
        lastFocus = document.activeElement;
        const m = $(id);
        m.hidden = false;
        document.body.style.overflow = 'hidden';
        setTimeout(() => (m.querySelector('[data-close].cr-icon-btn') || m.querySelector('button'))?.focus(), 50);
    }
    function closeModal(id) {
        $(id).hidden = true;
        if (!root.querySelector('.cr-modal:not([hidden])')) document.body.style.overflow = '';
        lastFocus?.focus?.();
    }
    root.querySelectorAll('.cr-modal').forEach(m => {
        m.addEventListener('click', e => { if (e.target.closest('[data-close]')) closeModal(m.id); });
    });
    document.addEventListener('keydown', e => {
        if (e.key !== 'Escape') return;
        const open = [...root.querySelectorAll('.cr-modal:not([hidden])')].pop();
        if (open) closeModal(open.id);
    });

    /* ---------- VIEW ---------- */
    async function openView(id) {
        $('viewBody').innerHTML = '<div class="cr-skel" style="height:70px"></div><div class="cr-skel" style="height:160px;margin-top:12px"></div>';
        openModal('viewModal');
        try {
            const { data: a } = await api('/' + id + '?mark_reviewed=1');
            state.current = a;
            $('viewBody').innerHTML = `
                <div class="cr-profile">
                    <span class="cr-avatar">${initial(a.name)}</span>
                    <div><strong>${esc(a.name)}</strong><small>${esc(a.position)} · ${esc(a.department)}</small></div>
                    ${badge(a.status)}
                </div>
                <dl class="cr-dl">
                    <div><dt>Email</dt><dd><a href="mailto:${esc(a.email)}">${esc(a.email)}</a></dd></div>
                    <div><dt>Phone</dt><dd><a href="tel:${esc(a.phone)}">${esc(a.phone)}</a></dd></div>
                    <div><dt>City</dt><dd>${dash(a.city)}</dd></div>
                    <div><dt>Experience</dt><dd>${dash(a.experience)}</dd></div>
                    <div><dt>Expected salary</dt><dd>${dash(a.expected_salary)}</dd></div>
                    <div><dt>Notice period</dt><dd>${dash(a.notice_period)}</dd></div>
                    <div><dt>Languages</dt><dd>${dash(a.languages)}</dd></div>
                    <div><dt>Applied on</dt><dd>${dash(a.created_date)}</dd></div>
                    <div><dt>Consent</dt><dd>${a.consent ? 'Yes' : 'No'}</dd></div>
                </dl>
                <p class="cr-block-label">Cover message</p>
                <div class="cr-block">${a.message ? esc(a.message) : '<span class="cr-muted">No message</span>'}</div>
                <p class="cr-block-label">Admin remarks</p>
                <div class="cr-block">${a.admin_remarks ? esc(a.admin_remarks) : '<span class="cr-muted">No remarks yet</span>'}</div>
                <div class="cr-resume">
                    <span class="cr-resume-ic">${esc(a.resume_ext || 'FILE')}</span>
                    <div><strong>Resume</strong><small>${a.has_resume ? 'Click to download' : 'File not found'}</small></div>
                    <button type="button" class="cr-btn cr-btn-lime" id="resumeBtn" ${a.has_resume ? '' : 'disabled'}>${ICONS.down} Download</button>
                </div>`;
            $('resumeBtn')?.addEventListener('click', () => downloadResume(a));

            // pending -> reviewed hua ho to list bhi refresh
            const row = state.rows.find(r => r.id === a.id);
            if (row && row.status !== a.status) load();
        } catch (e) {
            $('viewBody').innerHTML = `<p class="cr-muted">${esc(e.message)}</p>`;
        }
    }

    async function downloadResume(a) {
        const btn = $('resumeBtn');
        btn.disabled = true;
        try {
            const res  = await api('/' + a.id + '/resume', { raw: true });
            const blob = await res.blob();
            const cd   = res.headers.get('Content-Disposition') || '';
            const name = (cd.match(/filename="?([^"]+)"?/) || [])[1] || ('Resume-' + a.id + '.' + (a.resume_ext || 'pdf').toLowerCase());
            const url  = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url; link.download = name;
            document.body.appendChild(link); link.click(); link.remove();
            setTimeout(() => URL.revokeObjectURL(url), 2000);
        } catch (e) {
            toast(e.message, 'error');
        } finally {
            btn.disabled = false;
        }
    }

    $('viewEditBtn').addEventListener('click', () => {
        if (!state.current) return;
        closeModal('viewModal');
        fillEdit(state.current);
    });

    /* ---------- EDIT ---------- */
    const form = $('editForm');

    function clearErrors() {
        form.querySelectorAll('[data-err]').forEach(el => el.textContent = '');
        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    }

    function fillEdit(a) {
        clearErrors();
        form.elements.namedItem('id').value = a.id;
        ['name', 'phone', 'email', 'department', 'position', 'city', 'experience', 'languages',
         'expected_salary', 'notice_period', 'message', 'admin_remarks'].forEach(f => {
            const el = form.elements.namedItem(f); if (el) el.value = a[f] ?? '';
        });
        form.querySelectorAll('input[name="status"]').forEach(r => r.checked = r.value === a.status);
        $('editTitle').textContent = 'Edit · ' + a.name;
        openModal('editModal');
    }

    async function openEdit(id) {
        try {
            const { data } = await api('/' + id);
            state.current = data;
            fillEdit(data);
        } catch (e) { toast(e.message, 'error'); }
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        clearErrors();

        const id = form.elements.namedItem('id').value;
        const payload = {};
        ['name', 'phone', 'email', 'department', 'position', 'city', 'experience', 'languages',
         'expected_salary', 'notice_period', 'message', 'admin_remarks'].forEach(f => {
            payload[f] = form.elements.namedItem(f).value.trim();
        });
        const st = form.querySelector('input[name="status"]:checked');
        if (st) payload.status = st.value;
        ['languages', 'message', 'admin_remarks'].forEach(f => { if (payload[f] === '') payload[f] = null; });

        const btn = $('editSave');
        btn.disabled = true;
        btn.querySelector('span').textContent = 'Saving…';

        try {
            const res = await api('/' + id, { method: 'PATCH', body: payload });
            toast(res.message || 'Saved');
            closeModal('editModal');
            load();
        } catch (err) {
            if (err.errors) {
                Object.entries(err.errors).forEach(([f, msgs]) => {
                    const box = form.querySelector(`[data-err="${f}"]`);
                    if (box) box.textContent = msgs[0];
                    const el = form.elements.namedItem(f); if (el && el.classList) el.classList.add('is-invalid');
                });
                toast('Please fix the highlighted fields.', 'error');
            } else {
                toast(err.message, 'error');
            }
        } finally {
            btn.disabled = false;
            btn.querySelector('span').textContent = 'Save changes';
        }
    });

    /* ---------- DELETE ---------- */
    function openDelete(id) {
        const row = state.rows.find(r => r.id === id);
        state.deleteId = id;
        $('deleteName').textContent = row ? row.name : 'Is applicant';
        openModal('deleteModal');
    }

    $('deleteConfirm').addEventListener('click', async function () {
        if (!state.deleteId) return;
        this.disabled = true;
        this.querySelector('span').textContent = 'Deleting…';
        try {
            const res = await api('/' + state.deleteId, { method: 'DELETE' });
            toast(res.message || 'Deleted');
            closeModal('deleteModal');
            if (state.rows.length === 1 && state.page > 1) state.page--;   // page khali ho gaya to peeche jao
            load();
        } catch (e) {
            toast(e.message, 'error');
        } finally {
            this.disabled = false;
            this.querySelector('span').textContent = 'Delete';
            state.deleteId = null;
        }
    });

    /* =========================================================
       EVENTS
    ========================================================= */
    body.addEventListener('click', (e) => {
        const btn = e.target.closest('[data-act]');
        if (!btn) return;
        const id = Number(btn.dataset.id);
        if (btn.dataset.act === 'view') openView(id);
        if (btn.dataset.act === 'edit') openEdit(id);
        if (btn.dataset.act === 'delete') openDelete(id);
    });

    // Search (typing rukne ke 350ms baad)
    let t;
    $('crSearch').addEventListener('input', (e) => {
        clearTimeout(t);
        t = setTimeout(() => { state.search = e.target.value.trim(); state.page = 1; load(); }, 350);
    });

    [['crStatus', 'status'], ['crDept', 'department'], ['crCity', 'city'], ['crExp', 'experience']].forEach(([id, key]) => {
        $(id).addEventListener('change', (e) => { state[key] = e.target.value; state.page = 1; load(); });
    });

    $('crPerPage').addEventListener('change', (e) => { state.per_page = Number(e.target.value); state.page = 1; load(); });

    $('crPages').addEventListener('click', (e) => {
        const b = e.target.closest('[data-page]');
        if (!b || b.disabled) return;
        state.page = Number(b.dataset.page);
        load();
        root.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });

    // Stats cards = status filter
    $('crStats').addEventListener('click', (e) => {
        const b = e.target.closest('[data-status]');
        if (!b) return;
        state.status = b.dataset.status;
        $('crStatus').value = state.status;
        state.page = 1;
        load();
    });

    // Sorting
    root.querySelectorAll('th [data-sort]').forEach(b => {
        b.addEventListener('click', () => {
            const key = b.dataset.sort;
            state.dir = (state.sort === key && state.dir === 'desc') ? 'asc' : 'desc';
            state.sort = key;
            root.querySelectorAll('th [data-sort]').forEach(x => x.classList.toggle('is-sorted', x === b));
            load();
        });
    });

    $('crReset').addEventListener('click', () => {
        Object.assign(state, { page: 1, search: '', status: '', department: '', city: '', experience: '', sort: 'created_at', dir: 'desc' });
        $('crSearch').value = '';
        ['crStatus', 'crDept', 'crCity', 'crExp'].forEach(id => $(id).value = '');
        root.querySelectorAll('th [data-sort]').forEach(x => x.classList.toggle('is-sorted', x.dataset.sort === 'created_at'));
        load();
    });

    $('crReload').addEventListener('click', load);

    // Start
    load();
})();
</script>

@endsection