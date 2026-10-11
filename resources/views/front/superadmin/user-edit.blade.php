@extends('front.main')

@section('role', 'superadmin')
@section('title', 'Edit user')
@section('page_title', 'Edit user')

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
        <a href="{{ url('/superadmin/users/' . $riderId) }}" class="back-link">
            <svg viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6" /></svg>
            Back to user details
        </a>
    </div>

    <div class="panel" id="stateBox"><p class="cell-sub">Loading user...</p></div>

    <form id="editForm" novalidate hidden>

        <div class="alert-error" id="formError" hidden></div>

        <div class="grid-2">

            {{-- Personal --}}
            <div class="panel">
                <div class="panel-head"><h3>Personal information</h3></div>
                <div class="form-grid">
                    <div class="full">
                        <label for="f_full_name">Full name</label>
                        <input type="text" id="f_full_name" name="full_name" class="input">
                        <p class="field-error" data-error="full_name"></p>
                    </div>
                    <div>
                        <label for="f_email">Email</label>
                        <input type="email" id="f_email" name="email" class="input">
                        <p class="field-error" data-error="email"></p>
                    </div>
                    <div>
                        <label for="f_mobile">Mobile</label>
                        <input type="tel" id="f_mobile" name="mobile" class="input" maxlength="10" inputmode="numeric">
                        <p class="field-error" data-error="mobile"></p>
                    </div>
                    <div>
                        <label for="f_alternate_mobile">Alternate mobile</label>
                        <input type="tel" id="f_alternate_mobile" name="alternate_mobile" class="input" maxlength="10" inputmode="numeric">
                        <p class="field-error" data-error="alternate_mobile"></p>
                    </div>
                    <div>
                        <label for="f_gender">Gender</label>
                        <select id="f_gender" name="gender" class="input" data-options="gender" data-placeholder="Not specified"></select>
                        <p class="field-error" data-error="gender"></p>
                    </div>
                    <div>
                        <label for="f_city">City</label>
                        <input type="text" id="f_city" name="city" class="input">
                        <p class="field-error" data-error="city"></p>
                    </div>
                    <div>
                        <label for="f_pincode">Pincode</label>
                        <input type="text" id="f_pincode" name="pincode" class="input" maxlength="6" inputmode="numeric">
                        <p class="field-error" data-error="pincode"></p>
                    </div>
                    <div class="full">
                        <label for="f_address">Address</label>
                        <textarea id="f_address" name="address" class="input" rows="3" maxlength="500"></textarea>
                        <p class="field-error" data-error="address"></p>
                    </div>
                </div>
            </div>

            {{-- KYC + status --}}
            <div class="stack">
                <div class="panel">
                    <div class="panel-head"><h3>Approval</h3></div>
                    <div class="form-grid">
                        <div>
                            <label for="f_status">Account status</label>
                            <select id="f_status" name="status" class="input" data-options="status"></select>
                            <p class="field-error" data-error="status"></p>
                        </div>
                        <div>
                            <label for="f_kyc_status">KYC status</label>
                            <select id="f_kyc_status" name="kyc_status" class="input" data-options="kyc_status"></select>
                            <p class="field-error" data-error="kyc_status"></p>
                        </div>
                        <p class="full cell-sub">Pending and Active users can log in. Inactive or Rejected users are logged out and blocked.</p>
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-head"><h3>KYC details</h3></div>
                    <div class="form-grid">
                        <div>
                            <label for="f_date_of_birth">Date of birth</label>
                            <input type="date" id="f_date_of_birth" name="date_of_birth" class="input">
                            <p class="field-error" data-error="date_of_birth"></p>
                        </div>
                        <div>
                            <label for="f_driving_license_number">Driving license</label>
                            <input type="text" id="f_driving_license_number" name="driving_license_number" class="input" maxlength="30">
                            <p class="field-error" data-error="driving_license_number"></p>
                        </div>
                        <p class="full cell-sub">Aadhaar: <strong id="aadhaarMasked"></strong> (can't be edited here)</p>
                    </div>
                </div>
            </div>

        </div>

        <div class="form-actions">
            <a href="{{ url('/superadmin/users/' . $riderId) }}" class="btn-sm btn-lg">Cancel</a>
            <button type="submit" class="btn-sm primary btn-lg" id="saveBtn">Save changes</button>
        </div>

    </form>

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

        const R    = window.RiderAdmin;
        const ID   = @json($riderId);
        const $    = id => document.getElementById(id);
        const form = $('editForm');
        const saveBtn = $('saveBtn');

        const FIELDS = ['full_name', 'email', 'mobile', 'alternate_mobile', 'gender', 'city', 'pincode',
                        'address', 'date_of_birth', 'driving_license_number', 'status', 'kyc_status'];

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
            const el = e.target;
            if (['mobile', 'alternate_mobile', 'pincode'].includes(el.name)) el.value = el.value.replace(/[^0-9]/g, '');
            if (!el.name) return;
            el.classList.remove('invalid');
            const box = form.querySelector(`[data-error="${el.name}"]`);
            if (box) box.textContent = '';
        });

        async function load() {
            try {
                const res = await R.api(`${R.API_URL}/${ID}`);
                const r = res.data;

                document.title = `Edit ${r.full_name} · User`;
                FIELDS.forEach(f => { $('f_' + f).value = r[f] ?? ''; });
                $('aadhaarMasked').textContent = r.aadhaar_masked || 'not provided';

                $('stateBox').hidden = true;
                form.hidden = false;
                $('f_full_name').focus();
            } catch (e) {
                $('stateBox').innerHTML = `<p class="cell-sub">${R.esc(e.status === 404 ? 'This user does not exist or was deleted.' : e.message)}</p>`;
            }
        }

        form.addEventListener('submit', async e => {
            e.preventDefault();
            clearErrors();

            const fd = new FormData(form);
            const payload = {};
            FIELDS.forEach(f => {
                const v = String(fd.get(f) ?? '').trim();
                payload[f] = v === '' ? null : v;
            });

            let hasError = false;
            if (!payload.full_name) { setFieldError('full_name', 'Enter the full name.'); hasError = true; }
            if (!payload.email) { setFieldError('email', 'Enter the email.'); hasError = true; }
            if (!/^[0-9]{10}$/.test(payload.mobile || '')) { setFieldError('mobile', 'Enter a valid 10 digit mobile number.'); hasError = true; }
            if (payload.alternate_mobile && !/^[0-9]{10}$/.test(payload.alternate_mobile)) { setFieldError('alternate_mobile', 'Enter a valid 10 digit number.'); hasError = true; }
            if (!payload.city) { setFieldError('city', 'Enter the city.'); hasError = true; }
            if (payload.pincode && !/^[0-9]{6}$/.test(payload.pincode)) { setFieldError('pincode', 'Pincode must be 6 digits.'); hasError = true; }
            if (hasError) { showFormError('Fix the highlighted fields.'); return; }

            saveBtn.disabled = true;
            saveBtn.textContent = 'Saving...';

            try {
                const res = await R.api(`${R.API_URL}/${ID}`, { method: 'PUT', body: JSON.stringify(payload) });
                R.flash(res.message || 'User updated.');
                window.location.href = `${R.PAGE_URL}/${ID}`;
            } catch (err) {
                if (err.data && err.data.errors) {
                    Object.entries(err.data.errors).forEach(([f, msgs]) => setFieldError(f, Array.isArray(msgs) ? msgs[0] : msgs));
                    showFormError('Fix the highlighted fields and save again.');
                } else {
                    showFormError(err.message);
                }
                saveBtn.disabled = false;
                saveBtn.textContent = 'Save changes';
            }
        });

        document.querySelectorAll('select[data-options]').forEach(sel => {
            R.fillOptions(sel, sel.dataset.options, sel.dataset.placeholder ?? null);
        });
        load();
    })();
    </script>
@endpush