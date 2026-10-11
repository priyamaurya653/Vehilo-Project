@extends('front.main')

@section('role', 'admin')
@section('title', 'Vehicle details')
@section('page_title', 'Vehicle details')

@push('styles')
<style>
    [hidden] { display: none !important; }

    .page-head { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 16px; }
    .back-link { display: inline-flex; align-items: center; gap: 6px; color: var(--accent-deep); font-size: .88rem; font-weight: 600; text-decoration: none; }
    .back-link svg { width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
    .back-link:hover { text-decoration: underline; }
    .head-actions { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; }

    .btn-sm {
        display: inline-flex; align-items: center; justify-content: center; gap: 6px;
        height: 40px; padding: 0 16px; border-radius: 10px;
        border: 1px solid var(--line); background: var(--surface); color: var(--text);
        font: inherit; font-size: .86rem; font-weight: 600; text-decoration: none; cursor: pointer;
    }
    .btn-sm:hover { border-color: var(--accent-deep); }
    .btn-sm.primary { background: var(--ink); color: #fff; border-color: var(--ink); }
    .btn-sm.primary:hover { background: var(--accent-deep); }
    .btn-sm.danger { color: var(--bad); }
    .btn-sm.danger:hover { background: var(--bad-tint); border-color: var(--bad); }
    .btn-sm:disabled { opacity: .45; cursor: not-allowed; }
    .btn-sm:focus-visible { outline: 2px solid var(--accent-deep); outline-offset: 2px; }

    .status-select {
        height: 40px; padding: 0 12px; border-radius: 10px;
        border: 1px solid transparent; font: inherit; font-size: .86rem; font-weight: 700; cursor: pointer;
    }
    .status-select.available   { background: var(--good-tint); color: var(--good); }
    .status-select.maintenance { background: var(--warn-tint); color: var(--warn); }
    .status-select.inactive    { background: #eef2ef; color: var(--muted); }

    /* ---------- Top: gallery + summary ---------- */
    .vd-top { display: grid; grid-template-columns: minmax(0, 1.35fr) minmax(0, 1fr); gap: 16px; margin-bottom: 16px; }

    .gallery { padding: 12px; }
    .gallery-main {
        position: relative; aspect-ratio: 16 / 10; border-radius: 12px; overflow: hidden;
        background: var(--paper); display: grid; place-items: center; color: var(--muted);
    }
    .gallery-main img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .gallery-main a { position: absolute; right: 10px; bottom: 10px; padding: 6px 10px; border-radius: 8px;
        background: rgba(255,255,255,.92); color: var(--text); font-size: .76rem; font-weight: 700; text-decoration: none; }
    .gallery-thumbs { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; margin-top: 8px; }
    .gallery-thumbs button {
        padding: 0; border: 2px solid transparent; border-radius: 10px; overflow: hidden;
        aspect-ratio: 4 / 3; background: var(--paper); cursor: pointer;
    }
    .gallery-thumbs button img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .gallery-thumbs button[aria-current="true"] { border-color: var(--accent-deep); }
    .gallery-thumbs button:focus-visible { outline: 2px solid var(--accent-deep); outline-offset: 2px; }

    .summary { display: flex; flex-direction: column; gap: 14px; }
    .summary .type-chip { align-self: flex-start; padding: 4px 11px; border-radius: 999px; background: var(--ink); color: var(--accent); font-size: .74rem; font-weight: 700; }
    .summary h2 { font-size: 1.5rem; font-weight: 800; line-height: 1.2; }
    .summary .sub { color: var(--muted); font-size: .9rem; margin-top: 2px; }
    .plate {
        display: inline-block; padding: 4px 10px; border-radius: 8px;
        border: 1px solid var(--line); background: var(--paper);
        font-weight: 800; letter-spacing: .06em; font-size: .86rem;
    }
    .price-box { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; }
    .price-box div { padding: 10px 12px; border: 1px solid var(--line); border-radius: 12px; }
    .price-box dt { color: var(--muted); font-size: .74rem; }
    .price-box dd { font-weight: 800; font-size: 1.05rem; margin-top: 2px; }
    .price-box .main { background: var(--accent-tint); border-color: transparent; }
    .loc { display: flex; gap: 8px; color: var(--muted); font-size: .88rem; line-height: 1.5; }
    .loc svg { width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2; flex-shrink: 0; margin-top: 2px; }

    /* ---------- Detail panels ---------- */
    .vd-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }
    .details { display: grid; grid-template-columns: 1fr 1fr; gap: 14px 20px; }
    .details dt { font-size: .78rem; color: var(--muted); }
    .details dd { font-size: .92rem; font-weight: 600; margin-top: 2px; word-break: break-word; }
    .details .full { grid-column: 1 / -1; }

    .feature-chips { display: flex; flex-wrap: wrap; gap: 8px; }
    .feature-chips span {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 12px; border-radius: 999px; background: var(--good-tint);
        color: var(--accent-deep); font-size: .82rem; font-weight: 700;
    }
    .feature-chips span::before { content: "✓"; }
    .muted { color: var(--muted); font-size: .88rem; }
    .desc { white-space: pre-line; line-height: 1.6; font-size: .92rem; }

    .state-msg { color: var(--muted); font-size: .9rem; }

    .toast {
        position: fixed; right: 20px; bottom: 20px; z-index: 120;
        padding: 12px 16px; border-radius: 12px;
        background: var(--ink); color: #fff; font-size: .86rem; font-weight: 600;
        box-shadow: 0 16px 30px -12px rgba(0,0,0,.4);
    }
    .toast.error { background: var(--bad); }

    @media (max-width: 1000px) {
        .vd-top, .vd-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 560px) {
        .details { grid-template-columns: 1fr; }
        .price-box { grid-template-columns: 1fr 1fr; }
        .price-box .main { grid-column: 1 / -1; }
        .head-actions { width: 100%; }
        .head-actions > * { flex: 1; }
        .toast { left: 16px; right: 16px; bottom: 16px; }
    }
</style>
@endpush

@section('content')

    <div class="page-head">
        <a href="{{ url('/admin/vehicle/vehicles') }}" class="back-link">
            <svg viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6" /></svg>
            Back to all vehicles
        </a>

        <div class="head-actions" id="headActions" hidden>
            <select class="status-select" id="statusSelect" aria-label="Vehicle status">
                <option value="available">Available</option>
                <option value="maintenance">Maintenance</option>
                <option value="inactive">Inactive</option>
            </select>
            <button type="button" class="btn-sm danger" id="deleteBtn">Delete</button>
            <a href="{{ url('/admin/vehicles/' . $vehicleId . '/edit') }}" class="btn-sm primary">Edit vehicle</a>
        </div>
    </div>

    <div class="panel" id="stateBox"><p class="state-msg">Loading vehicle...</p></div>

    <div id="detailsWrap" hidden>

        {{-- Gallery + summary --}}
        <div class="vd-top">
            <div class="panel gallery">
                <div class="gallery-main" id="galleryMain">No photos</div>
                <div class="gallery-thumbs" id="galleryThumbs"></div>
            </div>

            <div class="panel summary">
                <span class="type-chip" id="sType"></span>
                <div>
                    <h2 id="sName"></h2>
                    <div class="sub" id="sSub"></div>
                </div>
                <div><span class="plate" id="sPlate"></span></div>

                <dl class="price-box">
                    <div class="main"><dt>Per day</dt><dd id="pDay"></dd></div>
                    <div><dt>Per hour</dt><dd id="pHour"></dd></div>
                    <div><dt>Per week</dt><dd id="pWeek"></dd></div>
                </dl>

                <div class="loc">
                    <svg viewBox="0 0 24 24"><path d="M12 21s-7-6.2-7-11a7 7 0 0114 0c0 4.8-7 11-7 11z" /><circle cx="12" cy="10" r="2.5" /></svg>
                    <span id="sLoc"></span>
                </div>
            </div>
        </div>

        <div class="vd-grid">
            <div class="panel">
                <div class="panel-head"><h3>Specifications</h3></div>
                <dl class="details" id="specs"></dl>
            </div>

            <div class="panel">
                <div class="panel-head"><h3>Pricing and usage</h3></div>
                <dl class="details" id="pricing"></dl>
            </div>

            <div class="panel">
                <div class="panel-head"><h3>Pickup location</h3></div>
                <dl class="details" id="location"></dl>
            </div>

            <div class="panel">
                <div class="panel-head"><h3>Availability</h3></div>
                <dl class="details" id="availability"></dl>
            </div>

            <div class="panel">
                <div class="panel-head"><h3>Features</h3></div>
                <div class="feature-chips" id="features"></div>
            </div>

            <div class="panel">
                <div class="panel-head"><h3>Description</h3></div>
                <p class="desc" id="description"></p>
            </div>
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
    const LIST_URL     = @json(url('/admin/vehicle/vehicles'));
    const LOGIN_URL    = @json(url('/login'));
    const ID           = @json($vehicleId);

    const $ = id => document.getElementById(id);

    const LABELS = {
        status:       { available: 'Available', maintenance: 'Maintenance', inactive: 'Inactive' },
        fuel_type:    { petrol: 'Petrol', diesel: 'Diesel', cng: 'CNG', electric: 'Electric', hybrid: 'Hybrid' },
        transmission: { manual: 'Manual', automatic: 'Automatic', geared: 'Geared' }
    };

    const esc   = v => String(v ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    const money = n => n === null || n === undefined ? '—' : '₹' + Number(n).toLocaleString('en-IN', { maximumFractionDigits: 2 });
    const date  = d => d ? new Date(d).toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' }) : '—';
    const item  = (label, value, full) => `<div class="${full ? 'full' : ''}"><dt>${esc(label)}</dt><dd>${value}</dd></div>`;
    const text  = v => esc(v === null || v === undefined || v === '' ? '—' : v);

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
        const body = await res.text();
        let data = {};
        try { data = body ? JSON.parse(body) : {}; } catch (e) {}
        if (!res.ok) {
            const err = new Error(data.message || `Request failed (error ${res.status}).`);
            err.status = res.status;
            throw err;
        }
        return data;
    }

    /* ---------------- Gallery ---------------- */
    let photos = [];

    function showPhoto(index) {
        const p = photos[index];
        if (!p) return;
        $('galleryMain').innerHTML = `<img src="${esc(p.url)}" alt="Vehicle photo ${index + 1}">
            <a href="${esc(p.url)}" target="_blank" rel="noopener">Open full size</a>`;
        $('galleryThumbs').querySelectorAll('button').forEach((b, i) => b.setAttribute('aria-current', String(i === index)));
    }

    function renderGallery(images) {
        photos = images || [];
        if (!photos.length) {
            $('galleryMain').textContent = 'No photos uploaded';
            $('galleryThumbs').innerHTML = '';
            return;
        }
        $('galleryThumbs').innerHTML = photos.length > 1
            ? photos.map((p, i) => `<button type="button" data-photo="${i}" aria-label="Show photo ${i + 1}"><img src="${esc(p.url)}" alt=""></button>`).join('')
            : '';
        showPhoto(0);
    }

    $('galleryThumbs').addEventListener('click', e => {
        const btn = e.target.closest('[data-photo]');
        if (btn) showPhoto(Number(btn.dataset.photo));
    });

    /* ---------------- Render ---------------- */
    function render(v) {
        document.title = `${v.vehicle_name} · Vehicle`;

        renderGallery(v.images);

        $('sType').textContent  = v.vehicle_type || 'Vehicle';
        $('sName').textContent  = v.vehicle_name;
        $('sSub').textContent   = [v.brand, v.model, v.manufacturing_year, v.color].filter(Boolean).join(' · ');
        $('sPlate').textContent = v.vehicle_number;
        $('pDay').textContent   = money(v.price_per_day);
        $('pHour').textContent  = money(v.price_per_hour);
        $('pWeek').textContent  = money(v.price_per_week);
        $('sLoc').textContent   = `${v.pickup_location}, ${v.location_area}, ${v.city}, ${v.state}`;

        const electric = v.fuel_type === 'electric';
        $('specs').innerHTML = [
            item('Fuel type', text(LABELS.fuel_type[v.fuel_type])),
            item('Transmission', text(LABELS.transmission[v.transmission])),
            item('Seating capacity', text(v.seating_capacity ? `${v.seating_capacity} seats` : null)),
            electric ? '' : item('Engine', text(v.engine_cc ? `${v.engine_cc} cc` : null)),
            electric ? '' : item('Mileage', text(v.mileage ? `${v.mileage} km/l` : null)),
            ['electric', 'hybrid'].includes(v.fuel_type) ? item('Range per charge', text(v.range_per_charge ? `${v.range_per_charge} km` : null)) : '',
            item('Manufacturing year', text(v.manufacturing_year)),
            item('Color', text(v.color))
        ].join('');

        $('pricing').innerHTML = [
            item('Price per day', money(v.price_per_day)),
            item('Security deposit', money(v.security_deposit)),
            item('Included km per day', text(v.included_km !== null ? `${v.included_km} km` : null)),
            item('Extra km charge', v.extra_km_charge !== null ? `${money(v.extra_km_charge)} / km` : '—'),
            item('Price per hour', money(v.price_per_hour)),
            item('Price per week', money(v.price_per_week))
        ].join('');

        $('location').innerHTML = [
            item('Pickup location', text(v.pickup_location)),
            item('Area', text(v.location_area)),
            item('City', text(v.city)),
            item('State', text(v.state)),
            item('Pincode', text(v.pincode)),
            item('Country', text(v.country)),
            item('Pickup address', text(v.pickup_address), true)
        ].join('');

        $('availability').innerHTML = [
            item('Status', text(LABELS.status[v.status])),
            item('Rental days', `${esc(v.minimum_rental_days || 1)} to ${v.maximum_rental_days ? esc(v.maximum_rental_days) : 'any'} days`),
            item('Available from', text(v.available_from ? date(v.available_from) : 'Now')),
            item('Available to', text(v.available_to ? date(v.available_to) : 'No end date')),
            item('Added on', text(date(v.created_at))),
            item('Last updated', text(date(v.updated_at)))
        ].join('');

        $('features').innerHTML = (v.features || []).length
            ? v.features.map(f => `<span>${esc(f)}</span>`).join('')
            : '<p class="muted">No features selected. Edit the vehicle to add them.</p>';

        $('description').textContent = v.description || 'No description added.';
        $('description').classList.toggle('muted', !v.description);

        const sel = $('statusSelect');
        sel.value = v.status;
        sel.dataset.current = v.status;
        sel.className = 'status-select ' + v.status;

        $('headActions').hidden = false;
        $('stateBox').hidden    = true;
        $('detailsWrap').hidden = false;
    }

    /* ---------------- Status ---------------- */
    $('statusSelect').addEventListener('change', async function () {
        const previous = this.dataset.current;
        this.disabled = true;
        try {
            const res = await api(`${VEHICLES_URL}/${ID}/status`, {
                method: 'PATCH',
                body: JSON.stringify({ status: this.value })
            });
            toast(res.message);
            render(res.data);
        } catch (e) {
            this.value = previous;
            toast(e.message, true);
        } finally {
            this.disabled = false;
        }
    });

    /* ---------------- Delete ---------------- */
    $('deleteBtn').addEventListener('click', async function () {
        if (!confirm(`Delete ${$('sName').textContent} (${$('sPlate').textContent})? Its photos will be removed too. This can't be undone.`)) return;
        this.disabled = true;
        try {
            const res = await api(`${VEHICLES_URL}/${ID}`, { method: 'DELETE' });
            try { sessionStorage.setItem('vehicle_flash', res.message || 'Vehicle deleted.'); } catch (e) {}
            window.location.href = LIST_URL;
        } catch (e) {
            toast(e.message, true);
            this.disabled = false;
        }
    });

    /* ---------------- Load ---------------- */
    try {
        const msg = sessionStorage.getItem('vehicle_flash');
        if (msg) { sessionStorage.removeItem('vehicle_flash'); toast(msg); }
    } catch (e) {}

    api(`${VEHICLES_URL}/${ID}`)
        .then(res => render(res.data))
        .catch(e => {
            $('stateBox').innerHTML = `<p class="state-msg">${esc(e.status === 404 ? 'This vehicle does not exist or was deleted.' : e.message)}</p>`;
        });
})();
</script>
@endpush