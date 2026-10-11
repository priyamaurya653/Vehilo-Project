@extends('front.main')

@section('role', 'superadmin')
@section('title', 'User details')
@section('page_title', 'User details')

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

    <div class="page-head">
        <a href="{{ url('/superadmin/users') }}" class="back-link">
            <svg viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6" /></svg>
            Back to all users
        </a>

        <div class="head-actions" id="headActions" hidden>
            <button type="button" class="btn-sm danger btn-lg" id="deleteBtn">Delete</button>
            <a href="{{ url('/superadmin/users/' . $riderId . '/edit') }}" class="btn-sm primary btn-lg">Edit user</a>
        </div>
    </div>

    <div class="panel" id="stateBox"><p class="cell-sub">Loading user...</p></div>

    <div id="detailsWrap" hidden>

        <div class="panel" style="margin-bottom:14px">
            <div class="profile-head">
                <span class="profile-avatar" id="pAvatar"></span>
                <div>
                    <h2 id="pName"></h2>
                    <div class="cell-sub" id="pSince"></div>
                </div>
                <div style="margin-left:auto;display:flex;gap:6px;flex-wrap:wrap" id="pBadges"></div>
            </div>
        </div>

        <div class="grid-2">
            <div class="stack">
                <div class="panel">
                    <div class="panel-head"><h3>Personal information</h3></div>
                    <dl class="details" id="personal"></dl>
                </div>
                <div class="panel">
                    <div class="panel-head"><h3>KYC</h3></div>
                    <dl class="details" id="kyc"></dl>
                </div>
            </div>

            <div class="stack">
                <div class="panel">
                    <div class="panel-head"><h3>Documents</h3></div>
                    <div class="doc-list" id="docs"></div>
                </div>
                <div class="panel">
                    <div class="panel-head"><h3>Account</h3></div>
                    <dl class="details" id="account" style="grid-template-columns:1fr"></dl>
                </div>
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

        const R  = window.RiderAdmin;
        const ID = @json($riderId);
        const $  = id => document.getElementById(id);
        const item = (t, v) => `<div><dt>${R.esc(t)}</dt><dd>${v}</dd></div>`;
        let riderName = '';

        function render(r) {
            riderName = r.full_name;
            document.title = `${r.full_name} · User`;

            $('pAvatar').textContent = (r.full_name || '?').charAt(0).toUpperCase();
            $('pName').textContent   = r.full_name;
            $('pSince').textContent  = `Registered on ${R.formatDate(r.created_at)}`;
            $('pBadges').innerHTML   = `${R.badge('status', r.status)} ${R.badge('kyc_status', r.kyc_status)}`;

            $('personal').innerHTML = [
                item('Email', `<a href="mailto:${R.esc(r.email)}" style="color:inherit">${R.esc(r.email)}</a>`),
                item('Mobile', `<a href="tel:${R.esc(r.mobile)}" style="color:inherit">${R.esc(r.mobile)}</a>`),
                item('Alternate mobile', R.esc(r.alternate_mobile || '—')),
                item('Gender', R.esc(R.label('gender', r.gender))),
                item('City', R.esc(r.city || '—')),
                item('Pincode', R.esc(r.pincode || '—')),
                `<div style="grid-column:1/-1"><dt>Address</dt><dd>${R.esc(r.address || '—')}</dd></div>`
            ].join('');

            $('kyc').innerHTML = [
                item('Aadhaar', R.esc(r.aadhaar_masked || '—')),
                item('Date of birth', R.esc(R.formatDate(r.date_of_birth))),
                item('Driving license', R.esc(r.driving_license_number || '—')),
                item('KYC status', R.badge('kyc_status', r.kyc_status)),
                item('Mobile verified', r.mobile_verified ? 'Yes' : 'No'),
                item('Approved on', R.esc(R.formatDate(r.approved_at)))
            ].join('');

            $('docs').innerHTML = Object.entries(R.DOCS).map(([key, label]) => `
                <div class="doc-row">
                    <span>${R.esc(label)}</span>
                    ${r.documents && r.documents[key]
                        ? `<button type="button" class="btn-sm" data-doc="${key}">Open</button>`
                        : '<span class="badge muted">Not uploaded</span>'}
                </div>`).join('');

            $('account').innerHTML = [
                item('Account status', R.badge('status', r.status)),
                item('Login access', `<span class="state ${r.login_active ? 'on' : ''}">${r.login_active ? 'Can log in' : 'Blocked'}</span>`),
                item('User ID', `#${R.esc(r.id)}`)
            ].join('');

            $('headActions').hidden = false;
            $('stateBox').hidden    = true;
            $('detailsWrap').hidden = false;
        }

        $('docs').addEventListener('click', e => {
            const btn = e.target.closest('[data-doc]');
            if (btn) R.openDocument(ID, btn.dataset.doc);
        });

        $('deleteBtn').addEventListener('click', async function () {
            if (!confirm(`Delete ${riderName}? Their login, profile and documents will be removed permanently.`)) return;
            this.disabled = true;
            try {
                const res = await R.remove(ID);
                R.flash(res.message || 'User deleted.');
                window.location.href = R.PAGE_URL;
            } catch (e) {
                R.toast(e.message, true);
                this.disabled = false;
            }
        });

        R.api(`${R.API_URL}/${ID}`)
            .then(res => render(res.data))
            .catch(e => {
                $('stateBox').innerHTML = `<p class="cell-sub">${R.esc(e.status === 404 ? 'This user does not exist or was deleted.' : e.message)}</p>`;
            });
    })();
    </script>
@endpush