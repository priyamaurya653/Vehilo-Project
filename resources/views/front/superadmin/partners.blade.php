@extends('front.main')

@php $isRequests = ($defaultStatus ?? '') === 'pending'; @endphp

@section('role', 'superadmin')
@section('title', $isRequests ? 'Partner requests' : 'All partners')
@section('page_title', $isRequests ? 'Partner requests' : 'All partners')

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
    </style>
@endpush

@section('content')

    {{-- Counts --}}
    <div class="stats">
        <div class="stat-card">
            <div class="stat-label">Total partners</div>
            <div class="stat-value" id="countTotal">–</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Pending requests</div>
            <div class="stat-value" id="countPending">–</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Approved</div>
            <div class="stat-value" id="countApproved">–</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Rejected</div>
            <div class="stat-value" id="countRejected">–</div>
        </div>
    </div>

    <div class="panel">

        {{-- Search + filters --}}
        <div class="toolbar">
            <div class="search">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7" /><path d="M20 20l-3.5-3.5" /></svg>
                <input type="search" id="searchInput" class="input" placeholder="Search by name, email or mobile" aria-label="Search partners">
            </div>
            <select id="typeFilter" class="input" aria-label="Filter by partnership type"></select>
            <select id="statusFilter" class="input" aria-label="Filter by application status"></select>
        </div>

        {{-- Table --}}
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Partner</th>
                        <th>Mobile</th>
                        <th>Partnership</th>
                        <th>Applied</th>
                        <th>Status</th>
                        <th>Account</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="partnersBody">
                    <tr><td colspan="7" class="table-msg">Loading partners...</td></tr>
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
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
    | Partner pages ka shared helper (list, view, edit teeno use karte hain)
    |--------------------------------------------------------------------------
    */
    window.Partner = (function () {

        const API_URL   = @json(url('/api/v1/superadmin/partners'));
        const PAGE_URL  = @json(url('/superadmin/partners'));
        const LOGIN_URL = @json(url('/login'));

        /* Register form ke options jaise labels */
        const LABELS = {
            partnership_type: { franchise: 'EV Franchise', fleet: 'Fleet Partner', rental: 'Rental Partner', charging: 'Charging Partner', delivery: 'Delivery Partner' },
            investment:       { 'under-5': 'Under ₹5 Lakhs', '5-10': '₹5–10 Lakhs', '10-25': '₹10–25 Lakhs', '25-50': '₹25–50 Lakhs', '50-plus': '₹50+ Lakhs' },
            property:         { yes: 'Yes', no: 'No' },
            space:            { 'under-500': 'Under 500 sq.ft', '500-1000': '500–1,000 sq.ft', '1000-2500': '1,000–2,500 sq.ft', '2500-plus': '2,500+ sq.ft' },
            experience:       { new: 'New business', '1-3': '1–3 years', '3-5': '3–5 years', '5-plus': '5+ years' },
            fleet_size:       { '1-5': '1–5 vehicles', '6-10': '6–10 vehicles', '11-25': '11–25 vehicles', '25-plus': '25+ vehicles' },
            status:           { pending: 'Pending', approved: 'Approved', rejected: 'Rejected' }
        };

        const STATUS_BADGE = { pending: 'warn', approved: 'good', rejected: 'bad' };

        function esc(value) {
            return String(value ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
        }

        function label(group, value) {
            if (!value) return '—';
            return (LABELS[group] && LABELS[group][value]) || value;
        }

        function badge(status) {
            const st = status || 'pending';
            return `<span class="badge ${STATUS_BADGE[st] || 'warn'}">${esc(label('status', st))}</span>`;
        }

        function formatDate(iso) {
            if (!iso) return '—';
            const d = new Date(iso);
            return isNaN(d) ? '—' : d.toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' });
        }

        function fillOptions(select, group, placeholder) {
            const opts = Object.entries(LABELS[group])
                .map(([v, l]) => `<option value="${esc(v)}">${esc(l)}</option>`).join('');
            select.innerHTML = (placeholder ? `<option value="">${esc(placeholder)}</option>` : '') + opts;
        }

        /* Toast */
        let toastTimer;
        function toast(message, isError) {
            let el = document.querySelector('.toast');
            if (!el) {
                el = document.createElement('div');
                el.className = 'toast';
                el.setAttribute('role', 'status');
                document.body.appendChild(el);
            }
            el.textContent = message;
            el.classList.toggle('error', !!isError);
            el.hidden = false;
            clearTimeout(toastTimer);
            toastTimer = setTimeout(() => { el.hidden = true; }, 3200);
        }

        /* Redirect ke baad dikhane wala message */
        function flash(message) {
            try { sessionStorage.setItem('partner_flash', message); } catch (e) {}
        }
        document.addEventListener('DOMContentLoaded', function () {
            try {
                const msg = sessionStorage.getItem('partner_flash');
                if (msg) { sessionStorage.removeItem('partner_flash'); toast(msg); }
            } catch (e) {}
        });

        /* Token (Bearer) wali API call */
        async function api(url, options = {}) {
            const token = localStorage.getItem('access_token');
            const headers = { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token };
            if (options.body) headers['Content-Type'] = 'application/json';

            const res = await fetch(url, { ...options, headers });

            if (res.status === 401) {
                ['access_token', 'token_type', 'user', 'role', 'remember_me'].forEach(k => localStorage.removeItem(k));
                window.location.replace(LOGIN_URL);
                throw new Error('Session expired. Please log in again.');
            }

            const data = await res.json().catch(() => ({}));

            if (!res.ok) {
                const err = new Error(data.message || 'Request failed.');
                err.status = res.status;
                err.data = data;
                throw err;
            }
            return data;
        }

        /* Approve / Reject */
        function setStatus(id, status) {
            return api(`${API_URL}/${id}/status`, {
                method: 'PATCH',
                body: JSON.stringify({ status: status })
            });
        }

        return { API_URL, PAGE_URL, LABELS, esc, label, badge, formatDate, fillOptions, toast, flash, api, setStatus };
    })();
    </script>

    <script>
    (function () {
        if (!localStorage.getItem('access_token')) return; // sidebar login par bhej dega

        const P = window.Partner;
        const $ = id => document.getElementById(id);
        const tbody = $('partnersBody');

        const state = {
            page: 1,
            search: '',
            type: '',
            status: @json($defaultStatus ?? '')
        };

        /* ---------------- Row ---------------- */
        function rowHtml(p) {
            const app  = p.application || {};
            const st   = app.status || 'pending';
            const url  = `${P.PAGE_URL}/${p.id}`;

            const decide = st === 'pending'
                ? `<button type="button" class="btn-sm approve" data-id="${p.id}" data-status="approved">Approve</button>
                   <button type="button" class="btn-sm reject" data-id="${p.id}" data-status="rejected">Reject</button>`
                : '';

            return `
                <tr>
                    <td>
                        <div class="cell-main"><a href="${url}">${P.esc(p.name)}</a></div>
                        <div class="cell-sub">${P.esc(p.email)}</div>
                    </td>
                    <td>${P.esc(p.mobile || '—')}</td>
                    <td>${P.esc(P.label('partnership_type', app.partnership_type))}</td>
                    <td>${P.esc(P.formatDate(app.created_at || p.created_at))}</td>
                    <td>${P.badge(st)}</td>
                    <td><span class="state ${p.is_active ? 'on' : ''}">${p.is_active ? 'Active' : 'Inactive'}</span></td>
                    <td>
                        <div class="actions">
                            ${decide}
                            <a class="btn-sm" href="${url}">View</a>
                            <a class="btn-sm primary" href="${url}/edit">Edit</a>
                        </div>
                    </td>
                </tr>`;
        }

        /* ---------------- Load list ---------------- */
        let reqId = 0;
        async function load() {
            const myId = ++reqId;
            tbody.innerHTML = `<tr><td colspan="7" class="table-msg">Loading partners...</td></tr>`;

            const params = new URLSearchParams({ page: state.page, per_page: 10 });
            if (state.search) params.set('search', state.search);
            if (state.type)   params.set('partnership_type', state.type);
            if (state.status) params.set('status', state.status);

            try {
                const res = await P.api(`${P.API_URL}?${params.toString()}`);
                if (myId !== reqId) return;

                const rows = res.data || [];
                const emptyMsg = state.status === 'pending' && !state.search && !state.type
                    ? 'No pending partner requests. New registrations will show up here.'
                    : 'No partners match these filters. Clear the search or filters to see everyone.';

                tbody.innerHTML = rows.length
                    ? rows.map(rowHtml).join('')
                    : `<tr><td colspan="7" class="table-msg">${emptyMsg}</td></tr>`;

                const m = res.meta || {};
                $('pagerInfo').textContent = m.total ? `Showing ${m.from}–${m.to} of ${m.total}` : '';
                $('pagerPage').textContent = m.last_page > 1 ? `Page ${m.current_page} of ${m.last_page}` : '';
                $('prevPage').disabled = !(m.current_page > 1);
                $('nextPage').disabled = !(m.current_page < m.last_page);

                const c = res.counts || {};
                $('countTotal').textContent    = c.total ?? 0;
                $('countPending').textContent  = c.pending ?? 0;
                $('countApproved').textContent = c.approved ?? 0;
                $('countRejected').textContent = c.rejected ?? 0;

            } catch (e) {
                if (myId !== reqId) return;
                tbody.innerHTML = `<tr><td colspan="7" class="table-msg">${P.esc(e.message)}</td></tr>`;
            }
        }

        /* ---------------- Approve / Reject ---------------- */
        tbody.addEventListener('click', async function (e) {
            const btn = e.target.closest('[data-status]');
            if (!btn) return;

            const status = btn.dataset.status;
            if (status === 'rejected' && !confirm('Reject this partner request?')) return;

            btn.closest('.actions').querySelectorAll('button').forEach(b => b.disabled = true);

            try {
                const res = await P.setStatus(btn.dataset.id, status);
                P.toast(res.message || 'Status updated.');
                load();
            } catch (err) {
                P.toast(err.message, true);
                btn.closest('.actions').querySelectorAll('button').forEach(b => b.disabled = false);
            }
        });

        /* ---------------- Search / filters / pager ---------------- */
        let timer;
        $('searchInput').addEventListener('input', e => {
            clearTimeout(timer);
            timer = setTimeout(() => { state.search = e.target.value.trim(); state.page = 1; load(); }, 350);
        });
        $('typeFilter').addEventListener('change', e => { state.type = e.target.value; state.page = 1; load(); });
        $('statusFilter').addEventListener('change', e => { state.status = e.target.value; state.page = 1; load(); });
        $('prevPage').addEventListener('click', () => { if (state.page > 1) { state.page--; load(); } });
        $('nextPage').addEventListener('click', () => { state.page++; load(); });

        /* ---------------- Init ---------------- */
        P.fillOptions($('typeFilter'), 'partnership_type', 'All partnership types');
        P.fillOptions($('statusFilter'), 'status', 'All statuses');
        $('statusFilter').value = state.status;

        load();
    })();
    </script>
@endpush