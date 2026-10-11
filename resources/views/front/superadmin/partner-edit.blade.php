@extends('front.main')

@section('role', 'superadmin')
@section('title', 'Edit partner')
@section('page_title', 'Edit partner')

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

    <div class="page-head">
        <a href="{{ url('/superadmin/partners/' . $partnerId) }}" class="back-link">
            <svg viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6" /></svg>
            Back to partner details
        </a>
    </div>

    {{-- Loading / error --}}
    <div class="panel" id="stateBox">
        <p class="cell-sub">Loading partner...</p>
    </div>

    <form id="editForm" novalidate hidden>

        <div class="alert-error" id="formError" hidden></div>

        <div class="grid-2">

            {{-- ============ Account ============ --}}
            <div class="panel">
                <div class="panel-head"><h3>Account</h3></div>

                <div class="form-grid">
                    <div class="full">
                        <label for="f_name">Full name</label>
                        <input type="text" id="f_name" name="name" class="input" required>
                        <p class="field-error" data-error="name"></p>
                    </div>
                    <div class="full">
                        <label for="f_email">Email</label>
                        <input type="email" id="f_email" name="email" class="input" required>
                        <p class="field-error" data-error="email"></p>
                    </div>
                    <div class="full">
                        <label for="f_mobile">Mobile</label>
                        <input type="tel" id="f_mobile" name="mobile" class="input" maxlength="20" required>
                        <p class="field-error" data-error="mobile"></p>
                    </div>
                    <div class="full">
                        <label for="f_is_active">Login access</label>
                        <select id="f_is_active" name="is_active" class="input">
                            <option value="1">Active (can log in)</option>
                            <option value="0">Inactive (login blocked)</option>
                        </select>
                        <p class="field-error" data-error="is_active"></p>
                    </div>
                </div>
            </div>

            {{-- ============ Application ============ --}}
            <div class="panel">
                <div class="panel-head"><h3>Application</h3></div>

                <div class="form-grid">
                    <div class="full">
                        <label for="f_application_status">Application status</label>
                        <select id="f_application_status" name="application_status" class="input" data-options="status"></select>
                        <p class="field-error" data-error="application_status"></p>
                    </div>
                    <div>
                        <label for="f_partnership_type">Partnership type</label>
                        <select id="f_partnership_type" name="partnership_type" class="input" data-options="partnership_type"></select>
                        <p class="field-error" data-error="partnership_type"></p>
                    </div>
                    <div>
                        <label for="f_investment">Investment range</label>
                        <select id="f_investment" name="investment" class="input" data-options="investment"></select>
                        <p class="field-error" data-error="investment"></p>
                    </div>
                    <div>
                        <label for="f_property">Owns / leases property</label>
                        <select id="f_property" name="property" class="input" data-options="property"></select>
                        <p class="field-error" data-error="property"></p>
                    </div>
                    <div>
                        <label for="f_space">Available space</label>
                        <select id="f_space" name="space" class="input" data-options="space"></select>
                        <p class="field-error" data-error="space"></p>
                    </div>
                    <div>
                        <label for="f_experience">Business experience</label>
                        <select id="f_experience" name="experience" class="input" data-options="experience"></select>
                        <p class="field-error" data-error="experience"></p>
                    </div>
                    <div>
                        <label for="f_fleet_size">Planned fleet size</label>
                        <select id="f_fleet_size" name="fleet_size" class="input" data-options="fleet_size"></select>
                        <p class="field-error" data-error="fleet_size"></p>
                    </div>
                </div>
            </div>

        </div>

        <div class="form-actions">
            <a href="{{ url('/superadmin/partners/' . $partnerId) }}" class="btn-sm btn-lg">Cancel</a>
            <button type="submit" class="btn-sm primary btn-lg" id="saveBtn">Save changes</button>
        </div>

    </form>

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
        if (!localStorage.getItem('access_token')) return;

        const P    = window.Partner;
        const ID   = @json($partnerId);
        const $    = id => document.getElementById(id);
        const form = $('editForm');
        const saveBtn = $('saveBtn');

        const FIELDS = ['partnership_type', 'investment', 'property', 'space', 'experience', 'fleet_size'];

        /* ---------------- Errors ---------------- */
        function clearErrors() {
            $('formError').hidden = true;
            form.querySelectorAll('[data-error]').forEach(el => el.textContent = '');
            form.querySelectorAll('.input.invalid').forEach(el => el.classList.remove('invalid'));
        }

        function setFieldError(name, message) {
            const box = form.querySelector(`[data-error="${name}"]`);
            if (box) box.textContent = message;
            const input = form.querySelector(`[name="${name}"]`);
            if (input) input.classList.add('invalid');
        }

        function showFormError(message) {
            $('formError').textContent = message;
            $('formError').hidden = false;
            $('formError').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        form.addEventListener('input', e => {
            if (!e.target.name) return;
            e.target.classList.remove('invalid');
            const box = form.querySelector(`[data-error="${e.target.name}"]`);
            if (box) box.textContent = '';
        });

        /* ---------------- Load partner ---------------- */
        async function load() {
            try {
                const res = await P.api(`${P.API_URL}/${ID}`);
                const p   = res.data;
                const app = p.application || {};

                document.title = `Edit ${p.name} · Partner`;
                $('f_name').value   = p.name || '';
                $('f_email').value  = p.email || '';
                $('f_mobile').value = p.mobile || '';
                $('f_is_active').value = p.is_active ? '1' : '0';
                $('f_application_status').value = app.status || 'pending';
                FIELDS.forEach(f => { $('f_' + f).value = app[f] || ''; });

                $('stateBox').hidden = true;
                form.hidden = false;
                $('f_name').focus();

            } catch (e) {
                $('stateBox').innerHTML = `<p class="cell-sub">${P.esc(e.status === 404 ? 'This partner does not exist or was removed.' : e.message)}</p>`;
            }
        }

        /* ---------------- Save ---------------- */
        form.addEventListener('submit', async e => {
            e.preventDefault();
            clearErrors();

            const fd = new FormData(form);
            const payload = {
                name:               String(fd.get('name') || '').trim(),
                email:              String(fd.get('email') || '').trim(),
                mobile:             String(fd.get('mobile') || '').trim(),
                is_active:          fd.get('is_active') === '1',
                application_status: fd.get('application_status')
            };
            FIELDS.forEach(f => payload[f] = fd.get(f));

            // Chhota client check (asli validation API karti hai)
            let hasError = false;
            ['name', 'email', 'mobile', ...FIELDS].forEach(f => {
                if (!payload[f]) { setFieldError(f, 'This field is required.'); hasError = true; }
            });
            if (hasError) { showFormError('Fill in the highlighted fields.'); return; }

            saveBtn.disabled = true;
            saveBtn.textContent = 'Saving...';

            try {
                const res = await P.api(`${P.API_URL}/${ID}`, {
                    method: 'PUT',
                    body: JSON.stringify(payload)
                });

                P.flash(res.message || 'Partner updated.');
                window.location.href = `${P.PAGE_URL}/${ID}`;

            } catch (err) {
                if (err.data && err.data.errors) {
                    Object.entries(err.data.errors).forEach(([field, msgs]) => setFieldError(field, Array.isArray(msgs) ? msgs[0] : msgs));
                    showFormError('Fix the highlighted fields and save again.');
                } else {
                    showFormError(err.message);
                }
                saveBtn.disabled = false;
                saveBtn.textContent = 'Save changes';
            }
        });

        /* ---------------- Init ---------------- */
        document.querySelectorAll('select[data-options]').forEach(sel => P.fillOptions(sel, sel.dataset.options, sel.dataset.options === 'status' ? '' : 'Select'));
        load();
    })();
    </script>
@endpush