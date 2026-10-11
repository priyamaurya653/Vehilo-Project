@extends('frontlayout.main')

@section('title', 'Vehicle details – Wheelo')

@section('content')

<style>
    .vd-page {
        --vd-ink: #051a13;
        --vd-deep: #0f4a35;
        --vd-lime: #c8f542;
        --vd-lime-tint: #f1fbc9;
        --vd-paper: #f0f7f3;
        --vd-line: #dcebe2;
        --vd-muted: #5b6f66;
        --vd-good: #1f7a4d;
        --vd-good-tint: #dff5e8;
        --vd-bad: #b3392f;
        --vd-bad-tint: #fbe4e0;

        background: var(--vd-paper);
        color: var(--vd-ink);
          padding: 40px 0 40px;
    }
    .vd-page [hidden] { display: none !important; }
    .vd-wrap { max-width: 1200px; margin: 0 auto; padding: 0 20px; }

    /* Breadcrumb */
    .vd-crumbs { display: flex; flex-wrap: wrap; align-items: center; gap: 8px; margin-bottom: 18px; font-size: 14px; color: var(--vd-muted); }
    .vd-crumbs a { color: var(--vd-deep); font-weight: 600; text-decoration: none; }
    .vd-crumbs a:hover { text-decoration: underline; }
    .vd-crumbs span[aria-current] { color: var(--vd-ink); font-weight: 600; }

    .vd-card { background: #fff; border: 1px solid var(--vd-line); border-radius: 22px; }

    /* ---------- Top ---------- */
    .vd-top { display: grid; grid-template-columns: minmax(0, 1.4fr) minmax(0, 1fr); gap: 20px; align-items: start; }

    /* Gallery */
    .vd-gallery { padding: 14px; }
    .vd-main {
        position: relative; aspect-ratio: 16 / 10; border-radius: 16px; overflow: hidden;
        background: radial-gradient(circle at 30% 20%, #1c5a40, var(--vd-ink));
        display: grid; place-items: center; color: rgba(255,255,255,.8);
    }
    .vd-main img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .vd-main .vd-art { width: 120px; height: 120px; border-radius: 50%; display: grid; place-items: center; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.15); }
    .vd-main .vd-art svg, .vd-main .vd-art i { width: 56px; height: 56px; color: #fff; }
    .vd-main .vd-type {
        position: absolute; left: 14px; top: 14px; z-index: 2;
        padding: 6px 12px; border-radius: 999px;
        background: rgba(5,26,19,.8); color: var(--vd-lime); font-size: 13px; font-weight: 700;
    }
    .vd-main .vd-nav {
        position: absolute; top: 50%; transform: translateY(-50%); z-index: 2;
        width: 42px; height: 42px; border-radius: 50%; border: 0;
        background: rgba(255,255,255,.92); color: var(--vd-ink);
        display: grid; place-items: center; cursor: pointer;
    }
    .vd-main .vd-nav.prev { left: 12px; }
    .vd-main .vd-nav.next { right: 12px; }
    .vd-main .vd-nav:hover { background: var(--vd-lime); }
    .vd-main .vd-nav:focus-visible { outline: 3px solid var(--vd-lime); outline-offset: 2px; }
    .vd-main .vd-counter {
        position: absolute; right: 14px; bottom: 14px; z-index: 2;
        padding: 5px 10px; border-radius: 999px; background: rgba(5,26,19,.8); color: #fff; font-size: 12px; font-weight: 700;
    }
    .vd-thumbs { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-top: 10px; }
    .vd-thumbs button {
        padding: 0; border: 2px solid transparent; border-radius: 12px; overflow: hidden;
        aspect-ratio: 4 / 3; background: var(--vd-paper); cursor: pointer;
    }
    .vd-thumbs button img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .vd-thumbs button[aria-current="true"] { border-color: var(--vd-deep); }
    .vd-thumbs button:focus-visible { outline: 3px solid var(--vd-lime); outline-offset: 2px; }

    /* Summary (sticky) */
    .vd-summary { padding: 24px; position: sticky; top: 110px; display: flex; flex-direction: column; gap: 16px; }
    .vd-status { align-self: flex-start; display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 999px; font-size: 13px; font-weight: 700; }
    .vd-status::before { content: ""; width: 8px; height: 8px; border-radius: 50%; background: currentColor; }
    .vd-status.on  { background: var(--vd-good-tint); color: var(--vd-good); }
    .vd-status.off { background: var(--vd-bad-tint);  color: var(--vd-bad); }
    .vd-summary h1 { font-size: clamp(26px, 3vw, 34px); font-weight: 800; line-height: 1.15; letter-spacing: -.02em; }
    .vd-summary .vd-sub { color: var(--vd-muted); font-size: 15px; margin-top: 4px; }
    .vd-loc { display: flex; gap: 8px; color: var(--vd-muted); font-size: 15px; line-height: 1.5; }
    .vd-loc i, .vd-loc svg { width: 18px; height: 18px; flex-shrink: 0; margin-top: 2px; }

    .vd-price { padding: 16px; border-radius: 16px; background: var(--vd-lime-tint); }
    .vd-price strong { font-size: 34px; font-weight: 800; letter-spacing: -.02em; }
    .vd-price span { color: var(--vd-muted); font-size: 15px; }
    .vd-price-row { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-top: 12px; }
    .vd-price-row div { background: #fff; border-radius: 12px; padding: 10px 12px; }
    .vd-price-row dt { font-size: 12px; color: var(--vd-muted); }
    .vd-price-row dd { font-size: 16px; font-weight: 800; margin-top: 2px; }

    .vd-quick { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; }
    .vd-quick div { border: 1px solid var(--vd-line); border-radius: 12px; padding: 10px; text-align: center; }
    .vd-quick i, .vd-quick svg { width: 18px; height: 18px; color: var(--vd-deep); }
    .vd-quick strong { display: block; font-size: 14px; margin-top: 4px; }
    .vd-quick small { color: var(--vd-muted); font-size: 12px; }

    .vd-cta { display: flex; flex-direction: column; gap: 8px; }
    .vd-btn {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        height: 52px; padding: 0 20px; border-radius: 14px; border: 0;
        font: inherit; font-size: 16px; font-weight: 800; text-decoration: none; cursor: pointer;
    }
    .vd-btn.primary { background: var(--vd-lime); color: var(--vd-ink); }
    .vd-btn.primary:hover { background: #b5e62c; }
    .vd-btn.primary[aria-disabled="true"] { background: #e3e9e5; color: var(--vd-muted); pointer-events: none; }
    .vd-btn.ghost { background: #fff; color: var(--vd-ink); border: 1px solid var(--vd-line); height: 46px; font-size: 15px; }
    .vd-btn.ghost:hover { border-color: var(--vd-deep); }
    .vd-btn:focus-visible { outline: 3px solid var(--vd-deep); outline-offset: 2px; }
    .vd-note { font-size: 13px; color: var(--vd-muted); text-align: center; }

    /* ---------- Sections ---------- */
    .vd-sections { display: grid; grid-template-columns: minmax(0, 1.4fr) minmax(0, 1fr); gap: 20px; margin-top: 20px; align-items: start; }
    .vd-col { display: flex; flex-direction: column; gap: 20px; }
    .vd-block { padding: 24px; }
    .vd-block h2 { font-size: 20px; font-weight: 800; margin-bottom: 16px; }

    .vd-specs { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
    .vd-spec { display: flex; gap: 12px; align-items: center; padding: 12px; border-radius: 14px; background: var(--vd-paper); }
    .vd-spec .ic-box { width: 40px; height: 40px; border-radius: 12px; background: #fff; display: grid; place-items: center; flex-shrink: 0; color: var(--vd-deep); }
    .vd-spec .ic-box i, .vd-spec .ic-box svg { width: 20px; height: 20px; }
    .vd-spec small { display: block; color: var(--vd-muted); font-size: 12px; }
    .vd-spec strong { font-size: 15px; }

    .vd-features { display: flex; flex-wrap: wrap; gap: 10px; }
    .vd-features span {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 8px 14px; border-radius: 999px; background: var(--vd-good-tint);
        color: var(--vd-deep); font-weight: 700; font-size: 14px;
    }
    .vd-features i, .vd-features svg { width: 16px; height: 16px; }

    .vd-desc { white-space: pre-line; line-height: 1.7; color: #2d3f37; }
    .vd-muted { color: var(--vd-muted); }

    .vd-terms { display: flex; flex-direction: column; }
    .vd-terms div { display: flex; justify-content: space-between; gap: 12px; padding: 12px 0; border-bottom: 1px dashed var(--vd-line); font-size: 15px; }
    .vd-terms div:last-child { border-bottom: 0; }
    .vd-terms dt { color: var(--vd-muted); }
    .vd-terms dd { font-weight: 700; text-align: right; }

    .vd-address { line-height: 1.6; }
    .vd-address strong { display: block; font-size: 16px; margin-bottom: 4px; }
    .vd-map { margin-top: 14px; }

    /* Similar */
    .vd-similar { margin-top: 40px; }
    .vd-similar h2 { font-size: 24px; font-weight: 800; margin-bottom: 16px; }
    .vd-similar-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 16px; }
    .vd-mini { display: block; background: #fff; border: 1px solid var(--vd-line); border-radius: 18px; overflow: hidden; text-decoration: none; color: inherit; transition: transform .2s, box-shadow .2s; }
    .vd-mini:hover { transform: translateY(-3px); box-shadow: 0 16px 30px -20px rgba(5,26,19,.4); }
    .vd-mini:focus-visible { outline: 3px solid var(--vd-deep); outline-offset: 2px; }
    .vd-mini-img { aspect-ratio: 16 / 10; background: radial-gradient(circle at 30% 20%, #1c5a40, var(--vd-ink)); display: grid; place-items: center; color: #fff; }
    .vd-mini-img img { width: 100%; height: 100%; object-fit: cover; }
    .vd-mini-img i, .vd-mini-img svg { width: 40px; height: 40px; }
    .vd-mini-body { padding: 14px 16px; }
    .vd-mini-body strong { display: block; font-size: 16px; }
    .vd-mini-body small { color: var(--vd-muted); }
    .vd-mini-body p { margin-top: 8px; font-weight: 800; }

    /* Loading / error */
    .vd-state { padding: 60px 20px; text-align: center; color: var(--vd-muted); }
    .vd-state strong { display: block; font-size: 22px; color: var(--vd-ink); margin-bottom: 8px; }
    .vd-state a { color: var(--vd-deep); font-weight: 700; }
    .vd-sk { display: block; border-radius: 10px; background: linear-gradient(90deg, #e3ede7 25%, #eef4f0 50%, #e3ede7 75%); background-size: 200% 100%; animation: vdShimmer 1.2s linear infinite; }
    @keyframes vdShimmer { from { background-position: 200% 0; } to { background-position: -200% 0; } }
    @media (prefers-reduced-motion: reduce) { .vd-sk { animation: none; } }

    @media (max-width: 980px) {
        .vd-top, .vd-sections { grid-template-columns: 1fr; }
        .vd-summary { position: static; }
    }
    @media (max-width: 560px) {
        .vd-page { padding-top: 100px; }
        .vd-specs { grid-template-columns: 1fr 1fr; }
        .vd-quick { grid-template-columns: 1fr 1fr 1fr; }
        .vd-block, .vd-summary { padding: 18px; }
    }
</style>


<div class="vd-page">
    <div class="vd-wrap">

        <nav class="vd-crumbs" aria-label="Breadcrumb">
            <a href="{{ url('/') }}">Home</a>
            <span aria-hidden="true">/</span>
            <a href="{{ url('/') }}#featured">Vehicles</a>
            <span aria-hidden="true">/</span>
            <span aria-current="page" id="crumbName">Details</span>
        </nav>

        {{-- Loading skeleton --}}
        <div id="vdLoading" class="vd-top" aria-busy="true">
            <div class="vd-card vd-gallery"><span class="vd-sk" style="aspect-ratio:16/10;border-radius:16px"></span></div>
            <div class="vd-card vd-summary">
                <span class="vd-sk" style="height:26px;width:40%"></span>
                <span class="vd-sk" style="height:36px;width:80%"></span>
                <span class="vd-sk" style="height:120px"></span>
                <span class="vd-sk" style="height:52px"></span>
            </div>
        </div>

        {{-- Error --}}
        <div id="vdError" class="vd-card vd-state" hidden></div>

        {{-- Details --}}
        <div id="vdContent" hidden>

            <div class="vd-top">
                {{-- Gallery --}}
                <div class="vd-card vd-gallery">
                    <div class="vd-main" id="vdMain"></div>
                    <div class="vd-thumbs" id="vdThumbs"></div>
                </div>

                {{-- Summary --}}
                <aside class="vd-card vd-summary">
                    <span class="vd-status" id="vdStatus"></span>
                    <div>
                        <h1 id="vdName"></h1>
                        <p class="vd-sub" id="vdSub"></p>
                    </div>
                    <p class="vd-loc"><i data-lucide="map-pin"></i><span id="vdLoc"></span></p>

                    <div class="vd-price">
                        <strong id="vdPriceDay"></strong> <span>/ day</span>
                        <dl class="vd-price-row" id="vdPriceRow"></dl>
                    </div>

                    <div class="vd-quick" id="vdQuick"></div>

                    <div class="vd-cta">
                        <a href="{{ url('/login') }}" class="vd-btn primary" id="vdBook">
                            Book this vehicle <i data-lucide="arrow-right"></i>
                        </a>
                        <a href="#" class="vd-btn ghost" id="vdMapBtn" target="_blank" rel="noopener">
                            <i data-lucide="navigation"></i> Get directions to pickup
                        </a>
                        <p class="vd-note" id="vdNote">Log in or create an account to book.</p>
                    </div>
                </aside>
            </div>

            <div class="vd-sections">
                <div class="vd-col">
                    <section class="vd-card vd-block">
                        <h2>Specifications</h2>
                        <div class="vd-specs" id="vdSpecs"></div>
                    </section>

                    <section class="vd-card vd-block">
                        <h2>Features</h2>
                        <div class="vd-features" id="vdFeatures"></div>
                    </section>

                    <section class="vd-card vd-block">
                        <h2>About this vehicle</h2>
                        <p class="vd-desc" id="vdDesc"></p>
                    </section>
                </div>

                <div class="vd-col">
                    <section class="vd-card vd-block">
                        <h2>Rental terms</h2>
                        <dl class="vd-terms" id="vdTerms"></dl>
                    </section>

                    <section class="vd-card vd-block">
                        <h2>Pickup location</h2>
                        <div class="vd-address" id="vdAddress"></div>
                    </section>
                </div>
            </div>

            {{-- Same type ki aur gaadiyan --}}
            <section class="vd-similar" id="vdSimilarWrap" hidden>
                <h2>More vehicles like this</h2>
                <div class="vd-similar-grid" id="vdSimilar"></div>
            </section>
        </div>

    </div>
</div>


<script>
(function () {
    const API_BASE    = @json(rtrim(config('services.api.base_url') ?: url('/api/v1'), '/'));
    const VEHICLE_ID  = @json($vehicleId);
    const DETAIL_BASE = @json(url('/vehicles'));
    const HOME_URL    = @json(url('/'));
    const REGISTER_URL= @json(url('/register'));

    const $ = id => document.getElementById(id);

    const esc   = v => String(v ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    const money = n => n === null || n === undefined ? null : '₹' + Number(n).toLocaleString('en-IN', { maximumFractionDigits: 2 });
    const date  = d => d ? new Date(d).toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' }) : null;

    const LABELS = {
        fuel_type:    { petrol: 'Petrol', diesel: 'Diesel', cng: 'CNG', electric: 'Electric', hybrid: 'Hybrid' },
        transmission: { manual: 'Manual', automatic: 'Automatic', geared: 'Geared' }
    };

    const CUSTOM_SVG = {
        scooter:   '<circle cx="5.5" cy="17.5" r="2.5"/><circle cx="18.5" cy="17.5" r="2.5"/><path d="M8 17.5h7.5l2-7H14"/><path d="M14 4h2.5l2 6.5"/><path d="M3 13h6l2 4.5"/>',
        erickshaw: '<path d="M3 16V8a3 3 0 0 1 3-3h8l3 5h2a2 2 0 0 1 2 2v4"/><path d="M3 10h14"/><path d="M10 5v5"/><circle cx="6.5" cy="17" r="2"/><circle cx="17.5" cy="17" r="2"/><path d="M8.5 17h7"/>'
    };

    function icon(name) {
        if (CUSTOM_SVG[name]) {
            return `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">${CUSTOM_SVG[name]}</svg>`;
        }
        return `<i data-lucide="${name}"></i>`;
    }

    function typeIcon(v) {
        const t = String(v.vehicle_type || '').toLowerCase();
        if (t.includes('rickshaw')) return 'erickshaw';
        if (t.includes('scooter'))  return 'scooter';
        if (t.includes('bike') || t.includes('motor')) return 'bike';
        if (t.includes('truck') || t.includes('commercial') || t.includes('pickup')) return 'truck';
        if (v.fuel_type === 'electric' || t.includes('electric')) return 'zap';
        return 'car';
    }

    function refreshIcons() {
        if (window.lucide && typeof window.lucide.createIcons === 'function') window.lucide.createIcons();
    }

    async function getJson(url) {
        const res  = await fetch(url, { headers: { 'Accept': 'application/json' } });
        const data = await res.json().catch(() => ({}));
        if (!res.ok) {
            const err = new Error(data.message || 'Could not load.');
            err.status = res.status;
            throw err;
        }
        return data;
    }

    /* ---------------- Gallery ---------------- */
    let photos = [];
    let current = 0;
    let vehicle = null;

    function showPhoto(index) {
        if (!photos.length) return;
        current = (index + photos.length) % photos.length;
        const p = photos[current];

        $('vdMain').querySelector('.vd-photo-slot').innerHTML =
            `<img src="${esc(p.url)}" alt="${esc(vehicle.vehicle_name)} photo ${current + 1}">`;

        const img = $('vdMain').querySelector('img');
        img.addEventListener('error', () => {
            img.parentNode.innerHTML = `<span class="vd-art">${icon(typeIcon(vehicle))}</span>`;
            refreshIcons();
        }, { once: true });

        const counter = $('vdMain').querySelector('.vd-counter');
        if (counter) counter.textContent = `${current + 1} / ${photos.length}`;

        $('vdThumbs').querySelectorAll('button').forEach((b, i) => b.setAttribute('aria-current', String(i === current)));
    }

    function renderGallery(v) {
        photos = v.images || [];

        const nav = photos.length > 1 ? `
            <button type="button" class="vd-nav prev" data-step="-1" aria-label="Previous photo"><i data-lucide="chevron-left"></i></button>
            <button type="button" class="vd-nav next" data-step="1" aria-label="Next photo"><i data-lucide="chevron-right"></i></button>
            <span class="vd-counter"></span>` : '';

        $('vdMain').innerHTML = `
            ${v.vehicle_type ? `<span class="vd-type">${esc(v.vehicle_type)}</span>` : ''}
            <div class="vd-photo-slot" style="position:absolute;inset:0;display:grid;place-items:center">
                <span class="vd-art">${icon(typeIcon(v))}</span>
            </div>
            ${nav}`;

        $('vdThumbs').innerHTML = photos.length > 1
            ? photos.map((p, i) => `<button type="button" data-photo="${i}" aria-label="Show photo ${i + 1}"><img src="${esc(p.url)}" alt="" loading="lazy" onerror="this.remove()"></button>`).join('')
            : '';
        $('vdThumbs').hidden = photos.length < 2;

        if (photos.length) showPhoto(0);
    }

    $('vdMain').addEventListener('click', e => {
        const btn = e.target.closest('[data-step]');
        if (btn) showPhoto(current + Number(btn.dataset.step));
    });
    $('vdThumbs').addEventListener('click', e => {
        const btn = e.target.closest('[data-photo]');
        if (btn) showPhoto(Number(btn.dataset.photo));
    });
    document.addEventListener('keydown', e => {
        if (!photos.length || ['INPUT', 'TEXTAREA', 'SELECT'].includes(document.activeElement.tagName)) return;
        if (e.key === 'ArrowLeft')  showPhoto(current - 1);
        if (e.key === 'ArrowRight') showPhoto(current + 1);
    });

    /* ---------------- Render ---------------- */
    function render(v) {
        vehicle = v;
        document.title = `${v.vehicle_name} – Wheelo`;
        $('crumbName').textContent = v.vehicle_name;

        renderGallery(v);

        // Status
        const available = v.is_available !== false;
        $('vdStatus').className = 'vd-status ' + (available ? 'on' : 'off');
        $('vdStatus').textContent = available ? 'Available to book' : 'Not available right now';

        $('vdName').textContent = v.vehicle_name;
        $('vdSub').textContent  = [v.brand, v.model, v.manufacturing_year, v.color].filter(Boolean).join(' · ');
        $('vdLoc').textContent  = [v.location_area, v.city, v.state].filter(Boolean).join(', ');

        // Price
        $('vdPriceDay').textContent = money(v.price_per_day) || '—';
        const priceRows = [
            ['Per hour', money(v.price_per_hour)],
            ['Per week', money(v.price_per_week)],
            ['Security deposit', money(v.security_deposit)],
            ['Extra km', v.extra_km_charge !== null ? `${money(v.extra_km_charge)} / km` : null]
        ].filter(([, val]) => val);
        $('vdPriceRow').innerHTML = priceRows.map(([l, val]) => `<div><dt>${esc(l)}</dt><dd>${esc(val)}</dd></div>`).join('');

        // Quick facts
        const electric = v.fuel_type === 'electric';
        $('vdQuick').innerHTML = [
            ['users', v.seating_capacity ? `${v.seating_capacity}` : '—', 'Seats'],
            [electric ? 'battery' : 'fuel', LABELS.fuel_type[v.fuel_type] || '—', 'Fuel'],
            ['cog', LABELS.transmission[v.transmission] || '—', 'Gear']
        ].map(([ic, val, label]) => `<div>${icon(ic)}<strong>${esc(val)}</strong><small>${esc(label)}</small></div>`).join('');

        // Book button
        const book = $('vdBook');
        if (!available) {
            book.setAttribute('aria-disabled', 'true');
            book.innerHTML = 'Currently unavailable';
            $('vdNote').textContent = 'The owner has paused this vehicle. Check similar vehicles below.';
        } else {
            $('vdNote').innerHTML = `New to Wheelo? <a href="${REGISTER_URL}" style="color:#0f4a35;font-weight:700">Create an account</a> to book.`;
        }

        // Directions
        const mapQuery = encodeURIComponent([v.pickup_location, v.pickup_address, v.city, v.state, v.pincode].filter(Boolean).join(', '));
        $('vdMapBtn').href = `https://www.google.com/maps/search/?api=1&query=${mapQuery}`;

        // Specs
        const specs = [
            ['cog', 'Transmission', LABELS.transmission[v.transmission]],
            [electric ? 'battery' : 'fuel', 'Fuel type', LABELS.fuel_type[v.fuel_type]],
            ['users', 'Seating', v.seating_capacity ? `${v.seating_capacity} seats` : null],
            ['gauge', electric ? 'Range per charge' : 'Mileage',
                electric ? (v.range_per_charge ? `${v.range_per_charge} km` : null) : (v.mileage ? `${v.mileage} km/l` : null)],
            ['settings-2', 'Engine', !electric && v.engine_cc ? `${v.engine_cc} cc` : null],
            ['calendar', 'Model year', v.manufacturing_year],
            ['palette', 'Color', v.color],
            ['tag', 'Brand', [v.brand, v.model].filter(Boolean).join(' ')]
        ].filter(([, , val]) => val);

        $('vdSpecs').innerHTML = specs.map(([ic, label, val]) => `
            <div class="vd-spec">
                <span class="ic-box">${icon(ic)}</span>
                <div><small>${esc(label)}</small><strong>${esc(val)}</strong></div>
            </div>`).join('');

        // Features
        $('vdFeatures').innerHTML = (v.features || []).length
            ? v.features.map(f => `<span><i data-lucide="check"></i>${esc(f)}</span>`).join('')
            : '<p class="vd-muted">The owner hasn\'t listed features for this vehicle.</p>';

        // Description
        $('vdDesc').textContent = v.description || 'No description added yet.';
        $('vdDesc').classList.toggle('vd-muted', !v.description);

        // Terms
        const minDays = v.minimum_rental_days || 1;
        const terms = [
            ['Rental length', `${minDays} to ${v.maximum_rental_days ? v.maximum_rental_days : 'any number of'} day${(v.maximum_rental_days || 2) === 1 ? '' : 's'}`],
            ['Included distance', v.included_km !== null ? `${v.included_km} km / day` : null],
            ['Extra km charge', v.extra_km_charge !== null ? `${money(v.extra_km_charge)} / km` : null],
            ['Security deposit', money(v.security_deposit)],
            ['Available from', date(v.available_from) || 'Now'],
            ['Available until', date(v.available_to) || 'No end date']
        ].filter(([, val]) => val);

        $('vdTerms').innerHTML = terms.map(([l, val]) => `<div><dt>${esc(l)}</dt><dd>${esc(val)}</dd></div>`).join('');

        // Address
        $('vdAddress').innerHTML = `
            <strong>${esc(v.pickup_location || 'Pickup point')}</strong>
            <span>${esc(v.pickup_address || '')}</span><br>
            <span class="vd-muted">${esc([v.location_area, v.city, v.state, v.pincode].filter(Boolean).join(', '))}</span>
            <div class="vd-map"><a class="vd-btn ghost" href="https://www.google.com/maps/search/?api=1&query=${mapQuery}" target="_blank" rel="noopener">
                <i data-lucide="map"></i> Open in Google Maps</a></div>`;

        $('vdLoading').hidden = true;
        $('vdContent').hidden = false;
        refreshIcons();

        loadSimilar(v);
    }

    /* ---------------- Same type ki aur gaadiyan ---------------- */
    async function loadSimilar(v) {
        if (!v.vehicle_type_id) return;
        try {
            const res  = await getJson(`${API_BASE}/vehicles?show_all=1&sort=latest&per_page=5&vehicle_type_id=${encodeURIComponent(v.vehicle_type_id)}`);
            const list = (res.data || []).filter(x => x.id !== v.id).slice(0, 4);
            if (!list.length) return;

            $('vdSimilar').innerHTML = list.map(x => {
                const cover = (x.images || [])[0];
                return `
                    <a class="vd-mini" href="${DETAIL_BASE}/${x.id}">
                        <div class="vd-mini-img">${cover
                            ? `<img src="${esc(cover.url)}" alt="" loading="lazy" onerror="this.remove()">`
                            : icon(typeIcon(x))}</div>
                        <div class="vd-mini-body">
                            <strong>${esc(x.vehicle_name)}</strong>
                            <small>${esc([x.city, LABELS.fuel_type[x.fuel_type]].filter(Boolean).join(' · '))}</small>
                            <p>${money(x.price_per_day) || '—'} <small>/ day</small></p>
                        </div>
                    </a>`;
            }).join('');

            $('vdSimilarWrap').hidden = false;
            refreshIcons();
        } catch (e) { /* similar na aaye to kuch mat dikhao */ }
    }

    /* ---------------- Load ---------------- */
    getJson(`${API_BASE}/vehicles/${encodeURIComponent(VEHICLE_ID)}`)
        .then(res => render(res.data))
        .catch(e => {
            $('vdLoading').hidden = true;
            $('vdError').hidden = false;
            $('vdError').innerHTML = e.status === 404
                ? `<strong>Vehicle not found</strong>This vehicle was removed or the link is wrong. <a href="${HOME_URL}#featured">See other vehicles</a>.`
                : `<strong>Couldn't load this vehicle</strong>Refresh the page to try again, or <a href="${HOME_URL}#featured">go back to vehicles</a>.`;
        });
})();
</script>

@endsection