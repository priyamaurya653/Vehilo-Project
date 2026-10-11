@extends('front.main')

@section('role', 'superadmin')
@section('title', ($defaultStatus ?? '') === 'pending' ? 'Pending approval' : 'All users')
@section('page_title', ($defaultStatus ?? '') === 'pending' ? 'Pending approval' : 'All users')

@push('styles')
    <style>
        /* ---------- Page head (back link + actions) ---------- */
        .page-head {
            display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px;
            margin-bottom: 16px;
        }
        .back-link {
            display: inline-flex; align-items: center; gap: 6px;
            color: var(--accent-deep); font-size: .86rem; font-weight: 600; text-decoration: none;
        }
        .back-link svg { width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
        .back-link:hover { text-decoration: underline; }
        .head-actions { display: flex; flex-wrap: wrap; gap: 8px; }

        /* ---------- Toolbar (search + filters) ---------- */
        .toolbar { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 14px; }
        .search { position: relative; flex: 1 1 260px; }
        .search svg {
            position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
            width: 17px; height: 17px; fill: none; stroke: var(--muted); stroke-width: 2; stroke-linecap: round;
        }
        .input {
            width: 100%; height: 42px; padding: 0 12px;
            border: 1px solid var(--line); border-radius: 10px;
            background: var(--surface); color: var(--text);
            font: inherit; font-size: .88rem;
        }
        .search .input { padding-left: 38px; }
        .input:focus { outline: none; border-color: var(--accent-deep); box-shadow: 0 0 0 4px rgba(200,245,66,.3); }
        .input.invalid { border-color: var(--bad); }
        select.input { cursor: pointer; }
        .toolbar select.input { flex: 0 1 190px; }

        /* ---------- Buttons ---------- */
        .btn-sm {
            display: inline-flex; align-items: center; justify-content: center; gap: 6px;
            height: 34px; padding: 0 13px;
            border-radius: 9px; border: 1px solid var(--line);
            background: var(--surface); color: var(--text);
            font: inherit; font-size: .8rem; font-weight: 600;
            text-decoration: none; cursor: pointer; white-space: nowrap;
        }
        .btn-sm:hover { border-color: var(--accent-deep); }
        .btn-sm.primary { background: var(--ink); color: #fff; border-color: var(--ink); }
        .btn-sm.primary:hover { background: var(--accent-deep); }
        .btn-sm.approve { background: var(--good); color: #fff; border-color: var(--good); }
        .btn-sm.approve:hover { filter: brightness(1.1); }
        .btn-sm.reject { color: var(--bad); }
        .btn-sm.reject:hover { background: var(--bad-tint); border-color: var(--bad); }
        .btn-sm:disabled { opacity: .45; cursor: not-allowed; }
        .btn-sm:focus-visible { outline: 2px solid var(--accent-deep); outline-offset: 2px; }
        .btn-lg { height: 42px; padding: 0 18px; font-size: .88rem; }

        /* ---------- Table ---------- */
        .cell-main { font-weight: 600; }
        .cell-main a { color: inherit; text-decoration: none; }
        .cell-main a:hover { text-decoration: underline; }
        .cell-sub { font-size: .78rem; color: var(--muted); }
        .actions { display: flex; gap: 6px; justify-content: flex-end; }
        .table th:last-child { text-align: right; }
        .table-msg { text-align: center; color: var(--muted); padding: 36px 12px !important; white-space: normal !important; }

        .state { display: inline-flex; align-items: center; gap: 6px; font-size: .84rem; }
        .state::before { content: ''; width: 7px; height: 7px; border-radius: 50%; background: var(--bad); }
        .state.on::before { background: var(--good); }

        /* ---------- Pagination ---------- */
        .pager {
            display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 10px;
            margin-top: 14px; font-size: .82rem; color: var(--muted);
        }
        .pager-btns { display: flex; gap: 6px; align-items: center; }

        /* ---------- Detail view ---------- */
        .profile-head { display: flex; align-items: center; gap: 14px; }
        .profile-avatar {
            width: 52px; height: 52px; border-radius: 50%;
            display: grid; place-items: center; flex-shrink: 0;
            background: var(--accent); color: var(--ink); font-size: 1.2rem; font-weight: 800;
        }
        .profile-head h2 { font-size: 1.25rem; font-weight: 800; }
        .details { display: grid; grid-template-columns: 1fr 1fr; gap: 16px 20px; }
        .details dt { font-size: .78rem; color: var(--muted); }
        .details dd { font-size: .92rem; font-weight: 600; margin-top: 2px; word-break: break-word; }

        /* ---------- Edit form ---------- */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .form-grid .full { grid-column: 1 / -1; }
        .form-grid label { display: block; font-size: .82rem; font-weight: 600; margin-bottom: 5px; }
        .field-error { margin-top: 4px; font-size: .76rem; color: var(--bad); }
        .field-error:empty { display: none; }
        .alert-error {
            margin-bottom: 14px; padding: 10px 14px;
            border-radius: 10px; background: var(--bad-tint); color: var(--bad); font-size: .86rem;
        }
        .form-actions { display: flex; flex-wrap: wrap; justify-content: flex-end; gap: 8px; margin-top: 14px; }
        .stack { display: flex; flex-direction: column; gap: 14px; }

        /* ---------- Toast ---------- */
        .toast {
            position: fixed; right: 20px; bottom: 20px; z-index: 120;
            padding: 12px 16px; border-radius: 12px;
            background: var(--ink); color: #fff; font-size: .86rem; font-weight: 600;
            box-shadow: 0 16px 30px -12px rgba(0,0,0,.4);
        }
        .toast.error { background: var(--bad); }

        @media (max-width: 640px) {
            .toolbar select.input { flex: 1 1 calc(50% - 5px); }
            .details, .form-grid { grid-template-columns: 1fr; }
            .head-actions, .form-actions { width: 100%; }
            .head-actions .btn-sm, .form-actions .btn-sm { flex: 1; }
            .toast { left: 16px; right: 16px; bottom: 16px; }
        }

        /* Rider extras */
        .badge.muted { background: #eef2ef; color: var(--muted); }
        .btn-sm.danger { color: var(--bad); }
        .btn-sm.danger:hover { background: var(--bad-tint); border-color: var(--bad); }
        .doc-list { display: flex; flex-direction: column; gap: 8px; }
        .doc-row {
            display: flex; align-items: center; justify-content: space-between; gap: 10px;
            padding: 12px 14px; border: 1px solid var(--line); border-radius: 12px;
            font-size: .88rem; font-weight: 600;
        }
        textarea.input { height: auto; min-height: 84px; padding: 10px 12px; resize: vertical; }
    </style>
@endpush

@section('content')

    {{-- Counts --}}
    <div class="stats">
        <div class="stat-card">
            <div class="stat-label">Total users</div>
            <div class="stat-value" id="countTotal">–</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Awaiting approval</div>
            <div class="stat-value" id="countPending">–</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Active</div>
            <div class="stat-value" id="countActive">–</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">KYC verified</div>
            <div class="stat-value" id="countKyc">–</div>
        </div>
    </div>

    <div class="panel">

        <div class="toolbar">
            <div class="search">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7" /><path d="M20 20l-3.5-3.5" /></svg>
                <input type="search" id="searchInput" class="input" placeholder="Search by name, email, mobile or city" aria-label="Search users">
            </div>
            <select id="statusFilter" class="input" aria-label="Filter by account status"></select>
            <select id="kycFilter" class="input" aria-label="Filter by KYC status"></select>
        </div>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Mobile</th>
                        <th>City</th>
                        <th>Registered</th>
                        <th>KYC</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="usersBody">
                    <tr><td colspan="7" class="table-msg">Loading users...</td></tr>
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
    /*
    |--------------------------------------------------------------------------
    | Rider pages helper (token API, labels, toast)
    |--------------------------------------------------------------------------
    */
    window.RiderAdmin = (function () {
        const API_URL   = @json(url('/api/v1/superadmin/riders'));
        const PAGE_URL  = @json(url('/superadmin/users'));
        const LOGIN_URL = @json(url('/login'));

        const LABELS = {
            status:     { pending: 'Pending', active: 'Active', inactive: 'Inactive', rejected: 'Rejected' },
            kyc_status: { pending: 'Pending', verified: 'Verified', rejected: 'Rejected' },
            gender:     { male: 'Male', female: 'Female', other: 'Other' }
        };
        const BADGE = { pending: 'warn', active: 'good', verified: 'good', inactive: 'muted', rejected: 'bad' };
        const DOCS  = { government_id: 'Government ID proof', address_proof: 'Address proof', passport_photo: 'Passport size photo' };

        function esc(v) {
            return String(v ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
        }
        function label(group, v) { return v ? ((LABELS[group] && LABELS[group][v]) || v) : '—'; }
        function badge(group, v) { return `<span class="badge ${BADGE[v] || 'muted'}">${esc(label(group, v))}</span>`; }
        function formatDate(iso) {
            if (!iso) return '—';
            const d = new Date(iso);
            return isNaN(d) ? '—' : d.toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' });
        }
        function fillOptions(select, group, placeholder) {
            select.innerHTML = (placeholder !== null ? `<option value="">${esc(placeholder)}</option>` : '')
                + Object.entries(LABELS[group]).map(([v, l]) => `<option value="${esc(v)}">${esc(l)}</option>`).join('');
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
        function flash(message) { try { sessionStorage.setItem('rider_flash', message); } catch (e) {} }
        document.addEventListener('DOMContentLoaded', () => {
            try {
                const msg = sessionStorage.getItem('rider_flash');
                if (msg) { sessionStorage.removeItem('rider_flash'); toast(msg); }
            } catch (e) {}
        });

        function logoutExpired() {
            ['access_token', 'token_type', 'user', 'role', 'remember_me'].forEach(k => localStorage.removeItem(k));
            window.location.replace(LOGIN_URL);
        }

        async function api(url, options = {}) {
            const headers = { 'Accept': 'application/json', 'Authorization': 'Bearer ' + localStorage.getItem('access_token') };
            if (options.body) headers['Content-Type'] = 'application/json';
            const res = await fetch(url, { ...options, headers });
            if (res.status === 401) { logoutExpired(); throw new Error('Session expired. Please log in again.'); }
            const data = await res.json().catch(() => ({}));
            if (!res.ok) {
                const err = new Error(data.message || 'Request failed.');
                err.status = res.status; err.data = data;
                throw err;
            }
            return data;
        }

        function remove(id) {
            return api(`${API_URL}/${id}`, { method: 'DELETE' });
        }

        /* Document token ke saath laakar naye tab me kholo */
        async function openDocument(id, type) {
            const tab = window.open('', '_blank');
            try {
                const res = await fetch(`${API_URL}/${id}/documents/${type}`, {
                    headers: { 'Authorization': 'Bearer ' + localStorage.getItem('access_token') }
                });
                if (res.status === 401) { if (tab) tab.close(); logoutExpired(); return; }
                if (!res.ok) {
                    const data = await res.json().catch(() => ({}));
                    throw new Error(data.message || 'Could not open document.');
                }
                const url = URL.createObjectURL(await res.blob());
                if (tab) { tab.location.href = url; }
                else { const a = document.createElement('a'); a.href = url; a.target = '_blank'; a.click(); }
                setTimeout(() => URL.revokeObjectURL(url), 60000);
            } catch (e) {
                if (tab) tab.close();
                toast(e.message, true);
            }
        }

        return { API_URL, PAGE_URL, LABELS, DOCS, esc, label, badge, formatDate, fillOptions, toast, flash, api, remove, openDocument };
    })();
    </script>

    <script>
    (function () {
        if (!localStorage.getItem('access_token')) return;

        const R = window.RiderAdmin;
        const $ = id => document.getElementById(id);
        const tbody = $('usersBody');

        const state = { page: 1, search: '', status: @json($defaultStatus ?? ''), kyc: '' };

        function rowHtml(r) {
            const url = `${R.PAGE_URL}/${r.id}`;
            return `
                <tr>
                    <td>
                        <div class="cell-main"><a href="${url}">${R.esc(r.full_name)}</a></div>
                        <div class="cell-sub">${R.esc(r.email)}</div>
                    </td>
                    <td>${R.esc(r.mobile)}</td>
                    <td>${R.esc(r.city || '—')}</td>
                    <td>${R.esc(R.formatDate(r.created_at))}</td>
                    <td>${R.badge('kyc_status', r.kyc_status)}</td>
                    <td>${R.badge('status', r.status)}</td>
                    <td>
                        <div class="actions">
                            <a class="btn-sm" href="${url}">View</a>
                            <a class="btn-sm primary" href="${url}/edit">Edit</a>
                            <button type="button" class="btn-sm danger" data-delete="${r.id}" data-name="${R.esc(r.full_name)}">Delete</button>
                        </div>
                    </td>
                </tr>`;
        }

        let reqId = 0;
        async function load() {
            const myId = ++reqId;
            tbody.innerHTML = `<tr><td colspan="7" class="table-msg">Loading users...</td></tr>`;

            const params = new URLSearchParams({ page: state.page, per_page: 10 });
            if (state.search) params.set('search', state.search);
            if (state.status) params.set('status', state.status);
            if (state.kyc)    params.set('kyc_status', state.kyc);

            try {
                const res = await R.api(`${R.API_URL}?${params.toString()}`);
                if (myId !== reqId) return;

                const rows = res.data || [];
                const filtered = state.search || state.status || state.kyc;
                tbody.innerHTML = rows.length
                    ? rows.map(rowHtml).join('')
                    : `<tr><td colspan="7" class="table-msg">${filtered
                        ? 'No users match these filters. Clear the search or filters to see everyone.'
                        : 'No users yet. Riders who register will show up here.'}</td></tr>`;

                // Pending page par khali ho to alag message
                if (!rows.length && state.status === 'pending' && !state.search && !state.kyc) {
                    tbody.innerHTML = `<tr><td colspan="7" class="table-msg">No users waiting for approval.</td></tr>`;
                }

                const m = res.meta || {};
                $('pagerInfo').textContent = m.total ? `Showing ${m.from}–${m.to} of ${m.total}` : '';
                $('pagerPage').textContent = m.last_page > 1 ? `Page ${m.current_page} of ${m.last_page}` : '';
                $('prevPage').disabled = !(m.current_page > 1);
                $('nextPage').disabled = !(m.current_page < m.last_page);

                const c = res.counts || {};
                $('countTotal').textContent   = c.total ?? 0;
                $('countPending').textContent = c.pending ?? 0;
                $('countActive').textContent  = c.active ?? 0;
                $('countKyc').textContent     = c.kyc_verified ?? 0;

            } catch (e) {
                if (myId !== reqId) return;
                tbody.innerHTML = `<tr><td colspan="7" class="table-msg">${R.esc(e.message)}</td></tr>`;
            }
        }

        /* Delete */
        tbody.addEventListener('click', async e => {
            const btn = e.target.closest('[data-delete]');
            if (!btn) return;

            if (!confirm(`Delete ${btn.dataset.name}? Their login, profile and documents will be removed permanently.`)) return;

            btn.disabled = true;
            try {
                const res = await R.remove(btn.dataset.delete);
                R.toast(res.message || 'User deleted.');
                load();
            } catch (err) {
                R.toast(err.message, true);
                btn.disabled = false;
            }
        });

        /* Search / filters / pager */
        let timer;
        $('searchInput').addEventListener('input', e => {
            clearTimeout(timer);
            timer = setTimeout(() => { state.search = e.target.value.trim(); state.page = 1; load(); }, 350);
        });
        $('statusFilter').addEventListener('change', e => { state.status = e.target.value; state.page = 1; load(); });
        $('kycFilter').addEventListener('change', e => { state.kyc = e.target.value; state.page = 1; load(); });
        $('prevPage').addEventListener('click', () => { if (state.page > 1) { state.page--; load(); } });
        $('nextPage').addEventListener('click', () => { state.page++; load(); });

        R.fillOptions($('statusFilter'), 'status', 'All account statuses');
        R.fillOptions($('kycFilter'), 'kyc_status', 'All KYC statuses');
        $('statusFilter').value = state.status;
        load();
    })();
    </script>
@endpush