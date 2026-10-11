@extends('front.main')

@section('role', 'admin')
@section('title', 'My vehicles')
@section('page_title', 'My vehicles')

@push('styles')
<style>
    [hidden] { display: none !important; }

    .vh-head { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 16px; }
    .vh-head p { color: var(--muted); font-size: .9rem; }

    /* ---------- Toolbar ---------- */
    .toolbar { display: flex; flex-wrap: wrap; align-items: center; gap: 10px; margin-bottom: 16px; }
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

    .view-toggle { display: inline-flex; border: 1px solid var(--line); border-radius: 10px; overflow: hidden; background: var(--surface); }
    .view-toggle button {
        height: 40px; padding: 0 14px; border: 0; background: transparent; color: var(--muted);
        font: inherit; font-size: .82rem; font-weight: 600; cursor: pointer;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .view-toggle button svg { width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2; }
    .view-toggle button[aria-pressed="true"] { background: var(--ink); color: #fff; }
    .view-toggle button:focus-visible { outline: 2px solid var(--accent-deep); outline-offset: -2px; }

    /* ---------- Buttons ---------- */
    .btn-sm {
        display: inline-flex; align-items: center; justify-content: center; gap: 6px;
        height: 34px; padding: 0 12px; border-radius: 9px;
        border: 1px solid var(--line); background: var(--surface); color: var(--text);
        font: inherit; font-size: .8rem; font-weight: 600; text-decoration: none; cursor: pointer; white-space: nowrap;
    }
    .btn-sm:hover { border-color: var(--accent-deep); }
    .btn-sm.primary { background: var(--ink); color: #fff; border-color: var(--ink); }
    .btn-sm.primary:hover { background: var(--accent-deep); }
    .btn-sm.danger { color: var(--bad); }
    .btn-sm.danger:hover { background: var(--bad-tint); border-color: var(--bad); }
    .btn-sm:disabled { opacity: .45; cursor: not-allowed; }
    .btn-sm:focus-visible { outline: 2px solid var(--accent-deep); outline-offset: 2px; }

    /* ---------- Status select ---------- */
    .status-select {
        height: 30px; padding: 0 8px; border-radius: 999px;
        border: 1px solid transparent; font: inherit; font-size: .76rem; font-weight: 700; cursor: pointer;
    }
    .status-select.available   { background: var(--good-tint); color: var(--good); }
    .status-select.maintenance { background: var(--warn-tint); color: var(--warn); }
    .status-select.inactive    { background: #eef2ef; color: var(--muted); }
    .status-select:focus-visible { outline: 2px solid var(--accent-deep); outline-offset: 2px; }

    /* ---------- Grid cards ---------- */
    .vh-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(270px, 1fr)); gap: 16px; }
    .vh-card {
        display: flex; flex-direction: column;
        background: var(--surface); border: 1px solid var(--line); border-radius: 16px; overflow: hidden;
        transition: box-shadow .2s, transform .2s;
    }
    .vh-card:hover { box-shadow: 0 14px 30px -18px rgba(5,26,19,.35); transform: translateY(-2px); }
    .vh-cover { position: relative; aspect-ratio: 16 / 10; background: var(--paper); display: block; }
    .vh-cover img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .vh-cover .no-photo { position: absolute; inset: 0; display: grid; place-items: center; color: var(--muted); font-size: .82rem; }
    .vh-cover .type-chip {
        position: absolute; left: 10px; top: 10px;
        padding: 4px 10px; border-radius: 999px;
        background: rgba(5,26,19,.82); color: var(--accent); font-size: .72rem; font-weight: 700;
    }
    .vh-cover .photo-count {
        position: absolute; right: 10px; bottom: 10px;
        padding: 3px 8px; border-radius: 999px;
        background: rgba(255,255,255,.92); color: var(--text); font-size: .72rem; font-weight: 700;
    }
    .vh-body { padding: 14px 16px; display: flex; flex-direction: column; gap: 10px; flex: 1; }
    .vh-title { display: flex; justify-content: space-between; align-items: flex-start; gap: 8px; }
    .vh-title h3 { font-size: 1rem; font-weight: 800; line-height: 1.3; }
    .vh-title h3 a { color: inherit; text-decoration: none; }
    .vh-title h3 a:hover { text-decoration: underline; }
    .vh-sub { color: var(--muted); font-size: .8rem; }
    .vh-plate {
        display: inline-block; padding: 2px 8px; border-radius: 6px;
        border: 1px solid var(--line); background: var(--paper);
        font-size: .74rem; font-weight: 700; letter-spacing: .04em;
    }
    .vh-specs { display: flex; flex-wrap: wrap; gap: 6px; }
    .vh-specs span { padding: 3px 9px; border-radius: 999px; background: var(--paper); font-size: .74rem; font-weight: 600; color: var(--accent-deep); }
    .vh-loc { display: flex; align-items: center; gap: 6px; color: var(--muted); font-size: .8rem; }
    .vh-loc svg { width: 14px; height: 14px; fill: none; stroke: currentColor; stroke-width: 2; flex-shrink: 0; }
    .vh-foot { display: flex; justify-content: space-between; align-items: center; gap: 8px; padding-top: 10px; border-top: 1px solid var(--line); margin-top: auto; }
    .vh-price strong { font-size: 1.1rem; font-weight: 800; }
    .vh-price span { color: var(--muted); font-size: .78rem; }
    .vh-actions { display: flex; gap: 6px; padding: 0 16px 16px; }
    .vh-actions .btn-sm { flex: 1; }

    /* ---------- Table ---------- */
    .vh-cell { display: flex; align-items: center; gap: 12px; }
    .vh-thumb {
        width: 64px; height: 46px; border-radius: 9px; flex-shrink: 0; overflow: hidden;
        background: var(--paper); border: 1px solid var(--line);
        display: grid; place-items: center; color: var(--muted); font-size: .7rem;
    }
    .vh-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .vh-cell strong a { color: inherit; text-decoration: none; }
    .vh-cell strong a:hover { text-decoration: underline; }
    .vh-cell small { display: block; color: var(--muted); font-size: .76rem; }
    .actions { display: flex; gap: 6px; justify-content: flex-end; }
    .table th:last-child { text-align: right; }

    .state-msg { text-align: center; color: var(--muted); padding: 40px 12px; font-size: .9rem; }
    .state-msg a { color: var(--accent-deep); font-weight: 700; }

    /* ---------- Pager ---------- */
    .pager { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 10px; margin-top: 16px; font-size: .82rem; color: var(--muted); }
    .pager-btns { display: flex; gap: 6px; align-items: center; }

    .toast {
        position: fixed; right: 20px; bottom: 20px; z-index: 120;
        padding: 12px 16px; border-radius: 12px;
        background: var(--ink); color: #fff; font-size: .86rem; font-weight: 600;
        box-shadow: 0 16px 30px -12px rgba(0,0,0,.4);
    }
    .toast.error { background: var(--bad); }

    @media (max-width: 640px) {
        .toolbar select.input { flex: 1 1 calc(50% - 5px); }
        .view-toggle { width: 100%; }
        .view-toggle button { flex: 1; justify-content: center; }
        .vh-head .btn { width: 100%; justify-content: center; }
        .toast { left: 16px; right: 16px; bottom: 16px; }
    }
</style>
@endpush

@section('content')

    <div class="vh-head">
        <p>Vehicles you list for riders to book.</p>
        <a href="{{ url('/admin/vehicles/create') }}" class="btn btn-accent">Add vehicle</a>
    </div>

    <div class="stats">
        <div class="stat-card"><div class="stat-label">Total vehicles</div><div class="stat-value" id="countTotal">–</div></div>
        <div class="stat-card"><div class="stat-label">Available</div><div class="stat-value" id="countAvailable">–</div></div>
        <div class="stat-card"><div class="stat-label">In maintenance</div><div class="stat-value" id="countMaintenance">–</div></div>
        <div class="stat-card"><div class="stat-label">Inactive</div><div class="stat-value" id="countInactive">–</div></div>
    </div>

    <div class="toolbar">
        <div class="search">
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7" /><path d="M20 20l-3.5-3.5" /></svg>
            <input type="search" id="searchInput" class="input" placeholder="Search by name, number, brand or city" aria-label="Search vehicles">
        </div>
        <select id="typeFilter" class="input" aria-label="Filter by vehicle type">
            <option value="">All vehicle types</option>
        </select>
        <select id="statusFilter" class="input" aria-label="Filter by status">
            <option value="">All statuses</option>
            <option value="available">Available</option>
            <option value="maintenance">Maintenance</option>
            <option value="inactive">Inactive</option>
        </select>
        <div class="view-toggle" role="group" aria-label="Layout">
            <button type="button" data-view="grid" aria-pressed="true">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1.5" /><rect x="14" y="3" width="7" height="7" rx="1.5" /><rect x="3" y="14" width="7" height="7" rx="1.5" /><rect x="14" y="14" width="7" height="7" rx="1.5" /></svg>
                Cards
            </button>
            <button type="button" data-view="table" aria-pressed="false">
                <svg viewBox="0 0 24 24"><path d="M3 6h18M3 12h18M3 18h18" /></svg>
                Table
            </button>
        </div>
    </div>

    {{-- Loading / empty / error --}}
    <div class="panel" id="stateBox"><p class="state-msg">Loading vehicles...</p></div>

    {{-- Cards --}}
    <div class="vh-grid" id="gridView" hidden></div>

    {{-- Table --}}
    <div class="panel" id="tableView" hidden>
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Vehicle</th>
                        <th>Type</th>
                        <th>Location</th>
                        <th>Price / day</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="tableBody"></tbody>
            </table>
        </div>
    </div>

    <div class="pager" id="pager" hidden>
        <span id="pagerInfo"></span>
        <div class="pager-btns">
            <button type="button" class="btn-sm" id="prevPage" disabled>Previous</button>
            <span id="pagerPage"></span>
            <button type="button" class="btn-sm" id="nextPage" disabled>Next</button>
        </div>
    </div>

@endsection


@push('scripts')
<script>
(function () {
    const token = localStorage.getItem('access_token');
    if (!token) return;

    const API_BASE     = @json(rtrim(config('services.api.base_url') ?: url('/api/v1'), '/'));
    const VEHICLES_URL = API_BASE + '/admin/vehicles';
    const TYPES_URL    = API_BASE + '/vehicle-types';
    const PAGE_URL     = @json(url('/admin/vehicles'));
    const ADD_URL      = @json(url('/admin/vehicles/create'));
    const LOGIN_URL    = @json(url('/login'));

    const $ = id => document.getElementById(id);

    const LABELS = {
        status:       { available: 'Available', maintenance: 'Maintenance', inactive: 'Inactive' },
        fuel_type:    { petrol: 'Petrol', diesel: 'Diesel', cng: 'CNG', electric: 'Electric', hybrid: 'Hybrid' },
        transmission: { manual: 'Manual', automatic: 'Automatic', geared: 'Geared' }
    };

    let layout = 'grid';
    try { layout = localStorage.getItem('vehicles_layout') === 'table' ? 'table' : 'grid'; } catch (e) {}

    const state = { page: 1, search: '', status: '', type: '' };

    /* ---------------- Helpers ---------------- */
    const esc = v => String(v ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    const money = n => n === null || n === undefined ? '—' : '₹' + Number(n).toLocaleString('en-IN', { maximumFractionDigits: 2 });

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
        const headers = { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token };
        if (options.body) headers['Content-Type'] = 'application/json';
        const res = await fetch(url, { ...options, headers });
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

    function statusSelect(v) {
        return `<select class="status-select ${esc(v.status)}" data-status="${v.id}" data-current="${esc(v.status)}" aria-label="Status of ${esc(v.vehicle_name)}">
            ${Object.entries(LABELS.status).map(([val, label]) => `<option value="${val}" ${v.status === val ? 'selected' : ''}>${label}</option>`).join('')}
        </select>`;
    }

    function deleteBtn(v) {
        return `<button type="button" class="btn-sm danger" data-delete="${v.id}" data-name="${esc(v.vehicle_name)} (${esc(v.vehicle_number)})">Delete</button>`;
    }

    /* ---------------- Card ---------------- */
    function cardHtml(v) {
        const url    = `${PAGE_URL}/${v.id}`;
        const photos = v.images || [];
        const cover  = photos[0];
        const specs  = [
            LABELS.fuel_type[v.fuel_type],
            LABELS.transmission[v.transmission],
            v.seating_capacity ? `${v.seating_capacity} seats` : null,
            v.fuel_type === 'electric' && v.range_per_charge ? `${v.range_per_charge} km range` : (v.mileage ? `${v.mileage} km/l` : null)
        ].filter(Boolean);

        return `
            <article class="vh-card">
                <a class="vh-cover" href="${url}" aria-label="View ${esc(v.vehicle_name)}">
                    ${cover ? `<img src="${esc(cover.url)}" alt="" loading="lazy" onerror="this.outerHTML='<span class=&quot;no-photo&quot;>Photo not found</span>'">` : '<span class="no-photo">No photo</span>'}
                    ${v.vehicle_type ? `<span class="type-chip">${esc(v.vehicle_type)}</span>` : ''}
                    ${photos.length > 1 ? `<span class="photo-count">${photos.length} photos</span>` : ''}
                </a>
                <div class="vh-body">
                    <div class="vh-title">
                        <div>
                            <h3><a href="${url}">${esc(v.vehicle_name)}</a></h3>
                            <div class="vh-sub">${esc(v.brand)} ${esc(v.model)}${v.manufacturing_year ? ' · ' + esc(v.manufacturing_year) : ''}</div>
                        </div>
                        <span class="vh-plate">${esc(v.vehicle_number)}</span>
                    </div>
                    <div class="vh-specs">${specs.map(s => `<span>${esc(s)}</span>`).join('')}</div>
                    <div class="vh-loc">
                        <svg viewBox="0 0 24 24"><path d="M12 21s-7-6.2-7-11a7 7 0 0114 0c0 4.8-7 11-7 11z" /><circle cx="12" cy="10" r="2.5" /></svg>
                        ${esc(v.location_area)}, ${esc(v.city)}
                    </div>
                    <div class="vh-foot">
                        <div class="vh-price"><strong>${money(v.price_per_day)}</strong> <span>/ day</span></div>
                        ${statusSelect(v)}
                    </div>
                </div>
                <div class="vh-actions">
                    <a class="btn-sm primary" href="${url}">View</a>
                    <a class="btn-sm" href="${url}/edit">Edit</a>
                    ${deleteBtn(v)}
                </div>
            </article>`;
    }

    /* ---------------- Table row ---------------- */
    function rowHtml(v) {
        const url   = `${PAGE_URL}/${v.id}`;
        const cover = (v.images || [])[0];
        return `
            <tr>
                <td>
                    <div class="vh-cell">
                        <span class="vh-thumb">${cover ? `<img src="${esc(cover.url)}" alt="" loading="lazy" onerror="this.outerHTML='No photo'">` : 'No photo'}</span>
                        <span>
                            <strong><a href="${url}">${esc(v.vehicle_name)}</a></strong>
                            <small>${esc(v.vehicle_number)} · ${esc(v.brand)} ${esc(v.model)}</small>
                        </span>
                    </div>
                </td>
                <td>${esc(v.vehicle_type || '—')}</td>
                <td>${esc(v.city)}<small style="display:block;color:var(--muted);font-size:.76rem">${esc(v.location_area)}</small></td>
                <td><strong>${money(v.price_per_day)}</strong></td>
                <td>${statusSelect(v)}</td>
                <td>
                    <div class="actions">
                        <a class="btn-sm primary" href="${url}">View</a>
                        <a class="btn-sm" href="${url}/edit">Edit</a>
                        ${deleteBtn(v)}
                    </div>
                </td>
            </tr>`;
    }

    /* ---------------- Render ---------------- */
    let lastRows = [];

    function render() {
        const hasRows = lastRows.length > 0;
        $('stateBox').hidden  = hasRows;
        $('gridView').hidden  = !hasRows || layout !== 'grid';
        $('tableView').hidden = !hasRows || layout !== 'table';

        if (layout === 'grid') $('gridView').innerHTML = lastRows.map(cardHtml).join('');
        else $('tableBody').innerHTML = lastRows.map(rowHtml).join('');

        document.querySelectorAll('[data-view]').forEach(b => b.setAttribute('aria-pressed', String(b.dataset.view === layout)));
    }

    function showState(html) {
        lastRows = [];
        $('gridView').hidden = true;
        $('tableView').hidden = true;
        $('stateBox').hidden = false;
        $('stateBox').innerHTML = `<p class="state-msg">${html}</p>`;
    }

    /* ---------------- Load ---------------- */
    let reqId = 0;
    async function load() {
        const myId = ++reqId;
        if (!lastRows.length) showState('Loading vehicles...');

        const params = new URLSearchParams({ page: state.page, per_page: 12 });
        if (state.search) params.set('search', state.search);
        if (state.status) params.set('status', state.status);
        if (state.type)   params.set('vehicle_type_id', state.type);

        try {
            const res = await api(`${VEHICLES_URL}?${params.toString()}`);
            if (myId !== reqId) return;

            lastRows = res.data || [];

            if (!lastRows.length) {
                showState(state.search || state.status || state.type
                    ? 'No vehicles match these filters. Clear the search or filters to see all your vehicles.'
                    : `You haven't added any vehicles yet. <a href="${ADD_URL}">Add your first vehicle</a>.`);
            } else {
                render();
            }

            const m = res.meta || {};
            $('pager').hidden = !m.total;
            $('pagerInfo').textContent = m.total ? `Showing ${m.from}–${m.to} of ${m.total}` : '';
            $('pagerPage').textContent = m.last_page > 1 ? `Page ${m.current_page} of ${m.last_page}` : '';
            $('prevPage').disabled = !(m.current_page > 1);
            $('nextPage').disabled = !(m.current_page < m.last_page);

            const c = res.counts || {};
            $('countTotal').textContent       = c.total ?? 0;
            $('countAvailable').textContent   = c.available ?? 0;
            $('countMaintenance').textContent = c.maintenance ?? 0;
            $('countInactive').textContent    = c.inactive ?? 0;

        } catch (e) {
            if (myId !== reqId) return;
            showState(esc(e.message));
        }
    }

    /* ---------------- Status change (cards + table) ---------------- */
    document.addEventListener('change', async e => {
        const sel = e.target.closest('[data-status]');
        if (!sel) return;

        const previous = sel.dataset.current;
        sel.disabled = true;
        try {
            const res = await api(`${VEHICLES_URL}/${sel.dataset.status}/status`, {
                method: 'PATCH',
                body: JSON.stringify({ status: sel.value })
            });
            toast(res.message);
            load();
        } catch (err) {
            sel.value = previous;
            toast(err.message, true);
            sel.disabled = false;
        }
    });

    /* ---------------- Delete (cards + table) ---------------- */
    document.addEventListener('click', async e => {
        const btn = e.target.closest('[data-delete]');
        if (!btn) return;
        if (!confirm(`Delete ${btn.dataset.name}? Its photos will be removed too. This can't be undone.`)) return;

        btn.disabled = true;
        try {
            const res = await api(`${VEHICLES_URL}/${btn.dataset.delete}`, { method: 'DELETE' });
            toast(res.message || 'Vehicle deleted.');
            load();
        } catch (err) {
            toast(err.message, true);
            btn.disabled = false;
        }
    });

    /* ---------------- Layout toggle ---------------- */
    document.querySelectorAll('[data-view]').forEach(btn => {
        btn.addEventListener('click', () => {
            layout = btn.dataset.view;
            try { localStorage.setItem('vehicles_layout', layout); } catch (e) {}
            if (lastRows.length) render();
            else document.querySelectorAll('[data-view]').forEach(b => b.setAttribute('aria-pressed', String(b.dataset.view === layout)));
        });
    });

    /* ---------------- Filters ---------------- */
    let timer;
    $('searchInput').addEventListener('input', e => {
        clearTimeout(timer);
        timer = setTimeout(() => { state.search = e.target.value.trim(); state.page = 1; load(); }, 350);
    });
    $('statusFilter').addEventListener('change', e => { state.status = e.target.value; state.page = 1; load(); });
    $('typeFilter').addEventListener('change', e => { state.type = e.target.value; state.page = 1; load(); });
    $('prevPage').addEventListener('click', () => { if (state.page > 1) { state.page--; load(); } });
    $('nextPage').addEventListener('click', () => { state.page++; load(); });

    api(TYPES_URL).then(res => {
        $('typeFilter').insertAdjacentHTML('beforeend',
            (res.data || []).map(t => `<option value="${t.id}">${esc(t.vehicle_type)}</option>`).join(''));
    }).catch(() => {});

    try {
        const msg = sessionStorage.getItem('vehicle_flash');
        if (msg) { sessionStorage.removeItem('vehicle_flash'); toast(msg); }
    } catch (e) {}

    document.querySelectorAll('[data-view]').forEach(b => b.setAttribute('aria-pressed', String(b.dataset.view === layout)));
    load();
})();
</script>
@endpush