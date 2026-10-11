@extends('front.main')

@section('role', 'admin')
@section('title', 'Vehicle types')
@section('page_title', 'Vehicle types')

@push('styles')
<style>
    .vt-head { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 16px; }
    .vt-head p { color: var(--muted); font-size: .9rem; }

    .toolbar { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 14px; }
    .search { position: relative; flex: 1 1 260px; }
    .search svg {
        position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
        width: 17px; height: 17px; fill: none; stroke: var(--muted); stroke-width: 2; stroke-linecap: round;
    }
    .input {
        width: 100%; height: 42px; padding: 0 12px;
        border: 1px solid var(--line); border-radius: 10px;
        background: var(--surface); color: var(--text); font: inherit; font-size: .88rem;
    }
    .search .input { padding-left: 38px; }
    .input:focus { outline: none; border-color: var(--accent-deep); box-shadow: 0 0 0 4px rgba(200,245,66,.3); }
    .toolbar select.input { flex: 0 1 180px; cursor: pointer; }

    .btn-sm {
        display: inline-flex; align-items: center; justify-content: center; gap: 6px;
        height: 34px; padding: 0 13px; border-radius: 9px;
        border: 1px solid var(--line); background: var(--surface); color: var(--text);
        font: inherit; font-size: .8rem; font-weight: 600; text-decoration: none; cursor: pointer; white-space: nowrap;
    }
    .btn-sm:hover { border-color: var(--accent-deep); }
    .btn-sm.danger { color: var(--bad); }
    .btn-sm.danger:hover { background: var(--bad-tint); border-color: var(--bad); }
    .btn-sm:disabled { opacity: .45; cursor: not-allowed; }
    .btn-sm:focus-visible { outline: 2px solid var(--accent-deep); outline-offset: 2px; }

    .vt-icon {
        width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0;
        background: var(--paper); border: 1px solid var(--line);
        display: grid; place-items: center; overflow: hidden;
        font-weight: 800; color: var(--accent-deep);
    }
    .vt-icon img { width: 100%; height: 100%; object-fit: cover; }
    .vt-name { display: flex; align-items: center; gap: 12px; }
    .vt-name strong { display: block; }
    .vt-name small { display: block; color: var(--muted); font-size: .76rem; max-width: 260px; overflow: hidden; text-overflow: ellipsis; }

    .chips { display: flex; flex-wrap: wrap; gap: 5px; max-width: 320px; white-space: normal; }
    .chip { padding: 3px 9px; border-radius: 999px; background: var(--good-tint); color: var(--accent-deep); font-size: .74rem; font-weight: 600; }
    .chip.more { background: var(--paper); color: var(--muted); }

    /* Status switch */
    .switch { position: relative; display: inline-block; width: 40px; height: 22px; vertical-align: middle; }
    .switch input { position: absolute; inset: 0; opacity: 0; margin: 0; cursor: pointer; z-index: 1; }
    .switch span { position: absolute; inset: 0; border-radius: 999px; background: #D1D5DB; transition: background .2s; }
    .switch span::after {
        content: ''; position: absolute; top: 3px; left: 3px; width: 16px; height: 16px;
        border-radius: 50%; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,.2); transition: transform .2s;
    }
    .switch input:checked + span { background: var(--good); }
    .switch input:checked + span::after { transform: translateX(18px); }
    .switch input:focus-visible + span { outline: 2px solid var(--accent-deep); outline-offset: 2px; }
    .switch input:disabled { cursor: wait; }

    .actions { display: flex; gap: 6px; justify-content: flex-end; }
    .table th:last-child { text-align: right; }
    .table-msg { text-align: center; color: var(--muted); padding: 36px 12px !important; white-space: normal !important; }

    .pager { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 10px; margin-top: 14px; font-size: .82rem; color: var(--muted); }
    .pager-btns { display: flex; gap: 6px; align-items: center; }

    .toast {
        position: fixed; right: 20px; bottom: 20px; z-index: 120;
        padding: 12px 16px; border-radius: 12px;
        background: var(--ink); color: #fff; font-size: .86rem; font-weight: 600;
        box-shadow: 0 16px 30px -12px rgba(0,0,0,.4);
    }
    .toast.error { background: var(--bad); }

    @media (max-width: 640px) {
        .toolbar select.input { flex: 1 1 100%; }
        .vt-head .btn { width: 100%; justify-content: center; }
        .toast { left: 16px; right: 16px; bottom: 16px; }
    }
</style>
@endpush

@section('content')

    <div class="vt-head">
        <p>Vehicle types and features that riders see when booking.</p>
        <a href="{{ url('/admin/vehicles/add-feature') }}" class="btn btn-accent">Add vehicle type</a>
    </div>

    <div class="stats">
        <div class="stat-card"><div class="stat-label">Total types</div><div class="stat-value" id="countTotal">–</div></div>
        <div class="stat-card"><div class="stat-label">Active</div><div class="stat-value" id="countActive">–</div></div>
        <div class="stat-card"><div class="stat-label">Inactive</div><div class="stat-value" id="countInactive">–</div></div>
    </div>

    <div class="panel">

        <div class="toolbar">
            <div class="search">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7" /><path d="M20 20l-3.5-3.5" /></svg>
                <input type="search" id="searchInput" class="input" placeholder="Search by type or feature" aria-label="Search vehicle types">
            </div>
            <select id="statusFilter" class="input" aria-label="Filter by status">
                <option value="">All statuses</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Vehicle type</th>
                        <th>Features</th>
                        <th>Active</th>
                        <th>Updated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="typesBody">
                    <tr><td colspan="5" class="table-msg">Loading vehicle types...</td></tr>
                </tbody>
            </table>
        </div>

        <div class="pager">
            <span id="pagerInfo"></span>
            <div class="pager-btns">
                <button type="button" class="btn-sm" id="prevPage" disabled>Previous</button>
                <span id="pagerPage"></span>
                <button type="button" class="btn-sm" id="nextPage" disabled>Next</button>
            </div>
        </div>

    </div>

@endsection


@push('scripts')
<script>
(function () {
    const token = localStorage.getItem('access_token');
    if (!token) return;

    const API_BASE  = @json(rtrim(config('services.api.base_url') ?: url('/api/v1'), '/'));
    const API_URL   = API_BASE + '/admin/vehicle-types';
    const EDIT_URL  = @json(url('/admin/vehicles/types'));
    const ADD_URL   = @json(url('/admin/vehicles/add-feature'));
    const LOGIN_URL = @json(url('/login'));

    const $ = id => document.getElementById(id);
    const tbody = $('typesBody');
    const state = { page: 1, search: '', status: '' };

    /* ---------------- Helpers ---------------- */
    function esc(v) {
        return String(v ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    }
    function formatDate(iso) {
        if (!iso) return '—';
        const d = new Date(iso);
        return isNaN(d) ? '—' : d.toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' });
    }

    let toastTimer;
    function toast(message, isError) {
        let el = document.querySelector('.toast');
        if (!el) { el = document.createElement('div'); el.className = 'toast'; el.setAttribute('role', 'status'); document.body.appendChild(el); }
        el.textContent = message;
        el.classList.toggle('error', !!isError);
        el.hidden = false;
        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => { el.hidden = true; }, 3200);
    }

    async function api(url, options = {}) {
        const res = await fetch(url, { ...options, headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token } });
        if (res.status === 401) {
            ['access_token', 'token_type', 'user', 'role', 'remember_me'].forEach(k => localStorage.removeItem(k));
            window.location.replace(LOGIN_URL);
            throw new Error('Session expired. Please log in again.');
        }
        const text = await res.text();
        let data = {};
        try { data = text ? JSON.parse(text) : {}; } catch (e) {}
        if (!res.ok) {
            const err = new Error(data.message || `Request failed (error ${res.status}).`);
            err.status = res.status;
            throw err;
        }
        return data;
    }

    /* ---------------- Row ---------------- */
    function rowHtml(t) {
        const feats = t.vehicle_features || [];
        const shown = feats.slice(0, 4).map(f => `<span class="chip">${esc(f)}</span>`).join('');
        const more  = feats.length > 4 ? `<span class="chip more">+${feats.length - 4} more</span>` : '';
        const letter = esc((t.vehicle_type || '?').charAt(0).toUpperCase());
        // Image load na ho (storage:link nahi hai) to pehla letter dikhao
        const icon  = t.icon_url
            ? `<img src="${esc(t.icon_url)}" alt="${letter}" onerror="this.parentNode.textContent=this.alt">`
            : letter;

        return `
            <tr>
                <td>
                    <div class="vt-name">
                        <span class="vt-icon">${icon}</span>
                        <span>
                            <strong>${esc(t.vehicle_type)}</strong>
                            ${t.description ? `<small title="${esc(t.description)}">${esc(t.description)}</small>` : ''}
                        </span>
                    </div>
                </td>
                <td><div class="chips">${shown}${more}</div></td>
                <td>
                    <label class="switch" title="${t.status ? 'Active' : 'Inactive'}">
                        <input type="checkbox" data-toggle="${t.id}" ${t.status ? 'checked' : ''} aria-label="Active: ${esc(t.vehicle_type)}">
                        <span></span>
                    </label>
                </td>
                <td>${esc(formatDate(t.updated_at))}</td>
                <td>
                    <div class="actions">
                        <a class="btn-sm" href="${EDIT_URL}/${t.id}/edit">Edit</a>
                        <button type="button" class="btn-sm danger" data-delete="${t.id}" data-name="${esc(t.vehicle_type)}">Delete</button>
                    </div>
                </td>
            </tr>`;
    }

    /* ---------------- Load ---------------- */
    let reqId = 0;
    async function load() {
        const myId = ++reqId;
        tbody.innerHTML = `<tr><td colspan="5" class="table-msg">Loading vehicle types...</td></tr>`;

        const params = new URLSearchParams({ page: state.page, per_page: 10 });
        if (state.search) params.set('search', state.search);
        if (state.status) params.set('status', state.status);

        try {
            const res = await api(`${API_URL}?${params.toString()}`);
            if (myId !== reqId) return;

            const rows = res.data || [];
            tbody.innerHTML = rows.length
                ? rows.map(rowHtml).join('')
                : `<tr><td colspan="5" class="table-msg">${state.search || state.status
                    ? 'No vehicle types match these filters.'
                    : `No vehicle types yet. <a href="${ADD_URL}" style="color:var(--accent-deep);font-weight:600">Add the first one</a>.`}</td></tr>`;

            const m = res.meta || {};
            $('pagerInfo').textContent = m.total ? `Showing ${m.from}–${m.to} of ${m.total}` : '';
            $('pagerPage').textContent = m.last_page > 1 ? `Page ${m.current_page} of ${m.last_page}` : '';
            $('prevPage').disabled = !(m.current_page > 1);
            $('nextPage').disabled = !(m.current_page < m.last_page);

            const c = res.counts || {};
            $('countTotal').textContent    = c.total ?? 0;
            $('countActive').textContent   = c.active ?? 0;
            $('countInactive').textContent = c.inactive ?? 0;

        } catch (e) {
            if (myId !== reqId) return;
            tbody.innerHTML = `<tr><td colspan="5" class="table-msg">${esc(e.message)}</td></tr>`;
        }
    }

    /* ---------------- Toggle ---------------- */
    tbody.addEventListener('change', async e => {
        const input = e.target.closest('[data-toggle]');
        if (!input) return;

        input.disabled = true;
        try {
            const res = await api(`${API_URL}/${input.dataset.toggle}/toggle`, { method: 'PATCH' });
            input.checked = !!res.data.status;
            toast(res.message);
            load();
        } catch (err) {
            input.checked = !input.checked;
            toast(err.message, true);
        } finally {
            input.disabled = false;
        }
    });

    /* ---------------- Delete ---------------- */
    tbody.addEventListener('click', async e => {
        const btn = e.target.closest('[data-delete]');
        if (!btn) return;
        if (!confirm(`Delete "${btn.dataset.name}"? This can't be undone.`)) return;

        btn.disabled = true;
        try {
            const res = await api(`${API_URL}/${btn.dataset.delete}`, { method: 'DELETE' });
            toast(res.message || 'Deleted.');
            load();
        } catch (err) {
            toast(err.message, true);
            btn.disabled = false;
        }
    });

    /* ---------------- Search / filter / pager ---------------- */
    let timer;
    $('searchInput').addEventListener('input', e => {
        clearTimeout(timer);
        timer = setTimeout(() => { state.search = e.target.value.trim(); state.page = 1; load(); }, 350);
    });
    $('statusFilter').addEventListener('change', e => { state.status = e.target.value; state.page = 1; load(); });
    $('prevPage').addEventListener('click', () => { if (state.page > 1) { state.page--; load(); } });
    $('nextPage').addEventListener('click', () => { state.page++; load(); });

    /* Save ke baad aaya message */
    try {
        const msg = sessionStorage.getItem('vehicle_type_flash');
        if (msg) { sessionStorage.removeItem('vehicle_type_flash'); toast(msg); }
    } catch (e) {}

    load();
})();
</script>
@endpush