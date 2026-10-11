@extends('frontlayout.main')

@section('title', 'Wheelo – Rent. List. Ride. Any Vehicle, Any City.')

@section('content')

@php
    // ---------- Static data ----------
    $categories = [
        ['key' => 'cars',       'name' => 'Cars',              'icon' => 'car',       'count' => '2,400+', 'desc' => 'Hatchbacks, sedans and SUVs for every road trip or daily drive.',        'price' => '₹1,299', 'spec' => '4–7',    'spec_label' => 'Seats'],
        ['key' => 'bikes',      'name' => 'Bikes',             'icon' => 'bike',      'count' => '1,800+', 'desc' => 'Commuter and cruiser bikes for quick city rides and weekend trips.',     'price' => '₹449',   'spec' => '1–2',    'spec_label' => 'Riders'],
        ['key' => 'scooters',   'name' => 'Scooters',          'icon' => 'scooter',   'count' => '2,000+', 'desc' => 'Easy, gearless scooters for daily errands and short commutes.',          'price' => '₹279',   'spec' => '1–2',    'spec_label' => 'Riders'],
        ['key' => 'ev',         'name' => 'Electric Vehicles', 'icon' => 'zap',       'count' => '900+',   'desc' => 'Electric cars and two-wheelers with zero fuel cost and zero emissions.', 'price' => '₹399',   'spec' => '150 km', 'spec_label' => 'Avg. range'],
        ['key' => 'erickshaws', 'name' => 'E-Rickshaws',       'icon' => 'erickshaw', 'count' => '600+',   'desc' => 'Electric three-wheelers for last-mile passenger and cargo runs.',        'price' => '₹599',   'spec' => '4',      'spec_label' => 'Seats'],
        ['key' => 'commercial', 'name' => 'Commercial',        'icon' => 'truck',     'count' => '350+',   'desc' => 'Mini trucks and pickups for deliveries, shifting and business logistics.', 'price' => '₹1,899', 'spec' => '1.5 T',  'spec_label' => 'Payload'],
    ];

    $cities = [
        ['name' => 'Delhi NCR', 'count' => '1,900+'],
        ['name' => 'Mumbai',    'count' => '1,420+'],
        ['name' => 'Bengaluru', 'count' => '1,610+'],
        ['name' => 'Pune',      'count' => '780+'],
        ['name' => 'Hyderabad', 'count' => '870+'],
        ['name' => 'Chennai',   'count' => '740+'],
    ];

    $testimonials = [
        ['text' => 'Needed a scooter for three days during a work trip. Booking took two minutes and the price was exactly what I saw upfront.', 'name' => 'Priya Nair',     'role' => 'Renter, Bengaluru'],
        ['text' => 'We rent out our mini-truck fleet between jobs. Having commercial vehicles alongside cars and bikes brings in renters we\'d never have reached otherwise.', 'name' => 'Suresh Rathore', 'role' => 'Fleet Owner, Chennai'],
        ['text' => 'I listed my sedan on a Friday and had my first booking by Monday. The payout tracking makes it effortless to manage.', 'name' => 'Arjun Mehta',    'role' => 'Vehicle Owner, Delhi'],
        ['text' => 'Took an e-rickshaw for my delivery shifts. Daily pricing works perfectly for gig work and the pickup was right next to my area.', 'name' => 'Ravi Kumar',     'role' => 'Delivery Partner, Hyderabad'],
    ];

    // ---------- Icon helper: scooter / e-rickshaw custom SVG, baaki Lucide ----------
    $icon = function ($name, $class = 'ic') {
        $svg = [
            'scooter'   => '<circle cx="5.5" cy="17.5" r="2.5"/><circle cx="18.5" cy="17.5" r="2.5"/><path d="M8 17.5h7.5l2-7H14"/><path d="M14 4h2.5l2 6.5"/><path d="M3 13h6l2 4.5"/>',
            'erickshaw' => '<path d="M3 16V8a3 3 0 0 1 3-3h8l3 5h2a2 2 0 0 1 2 2v4"/><path d="M3 10h14"/><path d="M10 5v5"/><circle cx="6.5" cy="17" r="2"/><circle cx="17.5" cy="17" r="2"/><path d="M8.5 17h7"/>',
        ];
        if (isset($svg[$name])) {
            return '<svg class="' . $class . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">' . $svg[$name] . '</svg>';
        }
        return '<i data-lucide="' . e($name) . '" class="' . $class . '"></i>';
    };
@endphp


{{-- =========================================================
     HERO
========================================================== --}}
<section class="hero">
    <div class="container">
        <div class="hero-banner">

            <span class="orb orb-1" aria-hidden="true"></span>
            <span class="orb orb-2" aria-hidden="true"></span>
            <span class="orb orb-3" aria-hidden="true"></span>

            <div class="hero-grid">

                {{-- Left --}}
                <div class="hero-copy">
                    <span class="hero-badge" data-reveal>
                        <span class="live-dot"></span> India's complete vehicle rental marketplace
                    </span>

                    <h1 class="hero-title" data-reveal style="--d:.08s">
                        Rent. List. Ride.<br>
                        <span class="shine-text">Any Vehicle, Any City.</span>
                    </h1>

                    <p class="hero-text" data-reveal style="--d:.16s">
                        Find the right vehicle for your journey or turn your own vehicle into an earning opportunity.
                        Cars, bikes, scooters, electric vehicles, e-rickshaws and commercial vehicles — all on one platform.
                    </p>

                    <div class="hero-actions" data-reveal style="--d:.24s">
                        <a href="{{ url('/register') }}" class="btn btn-lime btn-lg">Rent a Vehicle <i data-lucide="arrow-right" class="ic-xs"></i></a>
                        <a href="{{ url('/partner') }}" class="btn btn-glass btn-lg">Become a Partner <i data-lucide="arrow-up-right" class="ic-xs"></i></a>
                    </div>

                    <div class="hero-stats" data-reveal style="--d:.32s">
                        <div class="stat"><span class="stat-ic"><i data-lucide="car" class="ic-sm"></i></span><div><strong data-count="8400" data-suffix="+">8,400+</strong><small>Vehicles listed</small></div></div>
                        <div class="stat"><span class="stat-ic"><i data-lucide="map-pin" class="ic-sm"></i></span><div><strong data-count="36">36</strong><small>Cities covered</small></div></div>
                        <div class="stat"><span class="stat-ic"><i data-lucide="layout-grid" class="ic-sm"></i></span><div><strong data-count="6">6</strong><small>Vehicle categories</small></div></div>
                        <div class="stat"><span class="stat-ic"><i data-lucide="star" class="ic-sm"></i></span><div><strong data-count="4.8" data-decimals="1" data-suffix="/5">4.8/5</strong><small>Average rating</small></div></div>
                    </div>
                </div>

                {{-- Right: category preview --}}
                <div class="preview-card" id="categoryPreview" data-categories='@json($categories)' data-reveal style="--d:.2s">
                    <div class="float-chip float-chip-1" aria-hidden="true">
                        <span><i data-lucide="shield-check" class="ic-xs"></i></span> Verified owners
                    </div>
                    <div class="float-chip float-chip-2" aria-hidden="true">
                        <span><i data-lucide="timer" class="ic-xs"></i></span> Book in 2 min
                    </div>

                    <div class="preview-top">
                        <span class="preview-label">Pick a category to preview</span>
                        <span class="preview-live"><span class="live-dot"></span> Live</span>
                    </div>

                    <div class="preview-tabs" role="tablist">
                        @foreach ($categories as $i => $cat)
                            <button type="button" role="tab" class="preview-tab {{ $i === 0 ? 'is-active' : '' }}" data-index="{{ $i }}" aria-selected="{{ $i === 0 ? 'true' : 'false' }}">
                                {!! $icon($cat['icon'], 'ic-sm') !!}
                                <span>{{ $cat['name'] }}</span>
                            </button>
                        @endforeach
                    </div>

                    <div class="preview-body" id="previewBody">
                        <div class="preview-head">
                            <span class="preview-ic" data-preview="icon">{!! $icon($categories[0]['icon'], 'ic-sm') !!}</span>
                            <div>
                                <strong data-preview="name">{{ $categories[0]['name'] }}</strong>
                                <small>Available near you</small>
                            </div>
                            <a href="{{ url('/vehicles?category=' . $categories[0]['key']) }}" class="preview-go" data-preview-link aria-label="View vehicles">
                                <i data-lucide="arrow-up-right" class="ic-sm"></i>
                            </a>
                        </div>
                        <p data-preview="desc">{{ $categories[0]['desc'] }}</p>
                        <div class="preview-meta">
                            <div><strong data-preview="price">{{ $categories[0]['price'] }}</strong><small>Avg. price / day</small></div>
                            <div><strong data-preview="spec">{{ $categories[0]['spec'] }}</strong><small data-preview="spec_label">{{ $categories[0]['spec_label'] }}</small></div>
                            <div><strong data-preview="count">{{ $categories[0]['count'] }}</strong><small>Listings</small></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Search bar (hero ke upar overlap) --}}
        <form class="search-bar" action="{{ url('/vehicles') }}" method="GET" data-reveal style="--d:.3s">
            <label class="field">
                <span>Category</span>
                <div class="input-wrap">
                    <i data-lucide="layout-grid" class="ic-xs"></i>
                    <select name="category">
                        <option value="">All Categories</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat['key'] }}">{{ $cat['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </label>
            <label class="field">
                <span>Location</span>
                <div class="input-wrap">
                    <i data-lucide="map-pin" class="ic-xs"></i>
                    <input type="text" name="location" placeholder="City or area">
                </div>
            </label>
            <label class="field">
                <span>Pickup</span>
                <div class="input-wrap">
                    <i data-lucide="calendar" class="ic-xs"></i>
                    <input type="date" name="pickup" min="{{ date('Y-m-d') }}">
                </div>
            </label>
            <label class="field">
                <span>Return</span>
                <div class="input-wrap">
                    <i data-lucide="calendar-check" class="ic-xs"></i>
                    <input type="date" name="return" min="{{ date('Y-m-d') }}">
                </div>
            </label>
            <button type="submit" class="btn btn-dark search-btn"><i data-lucide="search" class="ic-xs"></i> Search Vehicles</button>
        </form>

        {{-- Built for (moving strip) --}}
        <div class="built-for" data-reveal>
            <span class="built-label"><span class="live-dot"></span> Built for</span>
            <div class="built-marquee">
                <div class="built-track">
                    @foreach ([false, true] as $dup)
                        @foreach (['Daily Commuters', 'Businesses', 'Fleet Operators', 'Delivery Partners', 'Gig Workers', 'Tourists'] as $who)
                            <span class="chip" @if($dup) aria-hidden="true" @endif><i data-lucide="check" class="ic-xs"></i> {{ $who }}</span>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>


{{-- =========================================================
     CATEGORIES (dynamic: admin ke banaye Vehicle Types, API se)
========================================================== --}}
<style>
    /* =========== Vehicle type cards (full image) =========== */
    #categories .tc-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
        gap: 20px;
    }

    #categories .tc-card {
        position: relative; display: flex; flex-direction: column;
        background: #fff; border: 1px solid #dcebe2; border-radius: 24px; overflow: hidden;
        text-decoration: none; color: #051a13;
        transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
    }
    #categories .tc-card:hover {
        transform: translateY(-6px);
        border-color: #bcd7c8;
        box-shadow: 0 24px 44px -26px rgba(5, 26, 19, .45);
    }
    #categories .tc-card:focus-visible { outline: 3px solid #0f4a35; outline-offset: 3px; }
    #categories .tc-card.is-active { border-color: #c8f542; box-shadow: 0 0 0 3px #c8f542; }

    /* Image: poora upar ka box */
    #categories .tc-media {
        position: relative; aspect-ratio: 4 / 3; overflow: hidden;
        background: radial-gradient(circle at 30% 25%, #1c5a40 0%, #062117 70%);
        display: grid; place-items: center;
    }
    #categories .tc-media img {
        position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;
        transition: transform .6s ease;
    }
    #categories .tc-card:hover .tc-media img { transform: scale(1.08); }
    #categories .tc-media::after {
        content: ""; position: absolute; inset: 0; pointer-events: none;
        background: linear-gradient(180deg, rgba(5,26,19,0) 45%, rgba(5,26,19,.55) 100%);
    }
    #categories .tc-art {
        width: 96px; height: 96px; border-radius: 50%;
        display: grid; place-items: center; color: #fff;
        background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.16);
    }
    #categories .tc-art svg, #categories .tc-art i { width: 44px; height: 44px; }

    #categories .tc-count {
        position: absolute; left: 12px; bottom: 12px; z-index: 2;
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 12px; border-radius: 999px;
        background: #c8f542; color: #051a13; font-size: 13px; font-weight: 800;
    }
    #categories .tc-count svg, #categories .tc-count i { width: 14px; height: 14px; }
    #categories .tc-go {
        position: absolute; right: 12px; top: 12px; z-index: 2;
        width: 38px; height: 38px; border-radius: 50%;
        display: grid; place-items: center;
        background: rgba(255,255,255,.92); color: #051a13;
        transform: translateY(-4px); opacity: 0;
        transition: opacity .3s ease, transform .3s ease, background .2s;
    }
    #categories .tc-go svg, #categories .tc-go i { width: 18px; height: 18px; }
    #categories .tc-card:hover .tc-go,
    #categories .tc-card:focus-visible .tc-go { opacity: 1; transform: translateY(0); }
    #categories .tc-card:hover .tc-go { background: #c8f542; }

    /* Content: image ke neeche */
    #categories .tc-body { display: flex; flex-direction: column; gap: 10px; padding: 16px 18px 18px; flex: 1; }
    #categories .tc-title { display: flex; align-items: center; justify-content: space-between; gap: 10px; }
    #categories .tc-title h3 { font-size: 19px; font-weight: 800; letter-spacing: -.01em; line-height: 1.25; }
    #categories .tc-title span { color: #0f4a35; font-size: 13px; font-weight: 700; white-space: nowrap; }
    #categories .tc-desc {
        color: #5b6f66; font-size: 14px; line-height: 1.5;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    #categories .tc-feats { display: flex; flex-wrap: wrap; gap: 6px; margin-top: auto; }
    #categories .tc-feats span {
        padding: 4px 10px; border-radius: 999px;
        background: #f0f7f3; color: #0f4a35; font-size: 12px; font-weight: 700;
    }
    #categories .tc-feats span.more { background: transparent; border: 1px dashed #cfe0d6; color: #5b6f66; }

    /* Skeleton */
    #categories .tc-card.is-skeleton { pointer-events: none; }
    #categories .ck {
        display: block; border-radius: 10px;
        background: linear-gradient(90deg, #e9f1ec 25%, #f4f8f5 50%, #e9f1ec 75%);
        background-size: 200% 100%; animation: ckShimmer 1.2s linear infinite;
    }
    #categories .tc-media .ck { position: absolute; inset: 0; border-radius: 0; }
    @keyframes ckShimmer { from { background-position: 200% 0; } to { background-position: -200% 0; } }

    /* Empty */
    #categories .cat-empty {
        grid-column: 1 / -1; text-align: center; padding: 36px 20px;
        border: 1px dashed #cfe0d6; border-radius: 18px; color: #5b6f66; line-height: 1.6;
    }
    #categories .cat-empty strong { display: block; color: #051a13; font-size: 18px; margin-bottom: 4px; }
    #categories .cat-empty a { color: #0f4a35; font-weight: 700; }

    @media (max-width: 560px) {
        #categories .tc-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
        #categories .tc-body { padding: 12px; }
        #categories .tc-title { flex-direction: column; align-items: flex-start; gap: 2px; }
        #categories .tc-title h3 { font-size: 16px; }
        #categories .tc-desc, #categories .tc-feats { display: none; }
        #categories .tc-go { opacity: 1; transform: none; width: 32px; height: 32px; }
    }
    @media (prefers-reduced-motion: reduce) {
        #categories .tc-card, #categories .tc-media img, #categories .ck { transition: none; animation: none; }
    }
</style>

<section class="section" id="categories">
    <div class="container">
        <div class="section-head center" data-reveal>
            <span class="eyebrow" id="typeCount">Browse by category</span>
            <h2>Every kind of vehicle, <span>in one place.</span></h2>
            <p>Wheelo isn't just electric — find the exact vehicle type your trip or business needs.</p>
        </div>

        <div class="tc-grid" id="typeGrid" aria-live="polite" aria-busy="true">
            {{-- API aane tak skeleton --}}
            @for ($i = 0; $i < 4; $i++)
                <div class="tc-card is-skeleton" aria-hidden="true">
                    <div class="tc-media"><span class="ck"></span></div>
                    <div class="tc-body">
                        <span class="ck" style="height:18px;width:60%"></span>
                        <span class="ck" style="height:12px;width:90%"></span>
                        <span class="ck" style="height:22px;width:70%;margin-top:6px"></span>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>

<script>
(function () {
    const API_BASE = @json(rtrim(config('services.api.base_url') ?: url('/api/v1'), '/'));
    const TYPES_URL = API_BASE + '/vehicle-types';
    const HOME_URL  = @json(url('/'));
    const JOIN_URL  = @json(url('/partner'));

    const grid = document.getElementById('typeGrid');
    if (!grid) return;

    const esc = v => String(v ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));

    const CUSTOM_SVG = {
        scooter:   '<circle cx="5.5" cy="17.5" r="2.5"/><circle cx="18.5" cy="17.5" r="2.5"/><path d="M8 17.5h7.5l2-7H14"/><path d="M14 4h2.5l2 6.5"/><path d="M3 13h6l2 4.5"/>',
        erickshaw: '<path d="M3 16V8a3 3 0 0 1 3-3h8l3 5h2a2 2 0 0 1 2 2v4"/><path d="M3 10h14"/><path d="M10 5v5"/><circle cx="6.5" cy="17" r="2"/><circle cx="17.5" cy="17" r="2"/><path d="M8.5 17h7"/>'
    };

    function icon(name) {
        if (CUSTOM_SVG[name]) {
            return `<svg class="ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">${CUSTOM_SVG[name]}</svg>`;
        }
        return `<i data-lucide="${name}" class="ic"></i>`;
    }

    // Type ke naam se icon (admin ne icon upload na kiya ho tab)
    function iconFor(name) {
        const t = String(name || '').toLowerCase();
        if (t.includes('rickshaw')) return 'erickshaw';
        if (t.includes('scooter') || t.includes('scooty')) return 'scooter';
        if (t.includes('bike') || t.includes('motor') || t.includes('cycle')) return 'bike';
        if (t.includes('truck') || t.includes('commercial') || t.includes('pickup') || t.includes('tempo')) return 'truck';
        if (t.includes('bus')) return 'bus';
        if (t.includes('electric') || t === 'ev' || t.includes(' ev')) return 'zap';
        return 'car';
    }

    function refreshIcons() {
        if (window.lucide && typeof window.lucide.createIcons === 'function') window.lucide.createIcons();
    }

    function cardHtml(t) {
        const count = t.vehicles_count;
        const feats = t.vehicle_features || [];
        const name  = t.vehicle_type;
        const countText = count === null || count === undefined
            ? 'View vehicles'
            : `${count} vehicle${count === 1 ? '' : 's'}`;

        return `
            <a href="${HOME_URL}?type=${encodeURIComponent(t.id)}#featured" class="tc-card"
               data-type-id="${t.id}" data-type-name="${esc(name)}"
               aria-label="${esc(name)}, ${countText}">

                <div class="tc-media">
                    ${t.icon_url
                        ? `<img src="${esc(t.icon_url)}" alt="" loading="lazy" data-fallback="${iconFor(name)}">`
                        : `<span class="tc-art">${icon(iconFor(name))}</span>`}
                    <span class="tc-count"><i data-lucide="car-front"></i> ${esc(countText)}</span>
                    <span class="tc-go" aria-hidden="true"><i data-lucide="arrow-up-right"></i></span>
                </div>

                <div class="tc-body">
                    <div class="tc-title">
                        <h3>${esc(name)}</h3>
                        <span>Explore</span>
                    </div>
                    ${t.description ? `<p class="tc-desc">${esc(t.description)}</p>` : ''}
                    ${feats.length ? `
                        <div class="tc-feats">
                            ${feats.slice(0, 3).map(f => `<span>${esc(f)}</span>`).join('')}
                            ${feats.length > 3 ? `<span class="more">+${feats.length - 3}</span>` : ''}
                        </div>` : ''}
                </div>
            </a>`;
    }

    // Popular vehicles section ko bolo: is type ki gaadiyan dikhao
    grid.addEventListener('click', e => {
        const card = e.target.closest('[data-type-id]');
        if (!card || !window.wheeloFilterByType) return;
        e.preventDefault();
        window.wheeloFilterByType(card.dataset.typeId, card.dataset.typeName);
    });

    fetch(TYPES_URL, { headers: { 'Accept': 'application/json' } })
        .then(async res => {
            const data = await res.json().catch(() => ({}));
            if (!res.ok) throw new Error();
            return data.data || [];
        })
        .then(types => {
            grid.setAttribute('aria-busy', 'false');

            // Baaki page (Popular vehicles) ko type names chahiye
            window.WHEELO_TYPES = types;
            document.dispatchEvent(new CustomEvent('wheelo:types', { detail: types }));

            if (!types.length) {
                grid.innerHTML = `<div class="cat-empty"><strong>Vehicle categories are coming soon</strong>
                    Partners can already <a href="${JOIN_URL}">list their vehicles on Wheelo</a>.</div>`;
                return;
            }

            const total = types.length;
            document.getElementById('typeCount').textContent = `${total} vehicle categor${total === 1 ? 'y' : 'ies'}`;

            grid.innerHTML = types.map(cardHtml).join('');

            // Icon image load na ho to naam wala icon
            grid.querySelectorAll('.tc-media img').forEach(img => {
                img.addEventListener('error', () => {
                    const art = document.createElement('span');
                    art.className = 'tc-art';
                    art.innerHTML = icon(img.dataset.fallback || 'car');
                    img.replaceWith(art);
                    refreshIcons();
                }, { once: true });
            });

            // URL me ?type= ho to wo card highlight
            const active = new URLSearchParams(window.location.search).get('type');
            if (active) grid.querySelector(`[data-type-id="${CSS.escape(active)}"]`)?.classList.add('is-active');

            refreshIcons();
        })
        .catch(() => {
            grid.setAttribute('aria-busy', 'false');
            grid.innerHTML = `<div class="cat-empty"><strong>Categories could not load</strong>Refresh the page to try again.</div>`;
        });
})();
</script>


{{-- =========================================================
     FEATURED / POPULAR VEHICLES (dynamic, public API se)
     Partners ki Available gaadiyan yahan aati hain
========================================================== --}}

<style>
    /* Loading skeleton */
    #featured .sk {
        display: block; border-radius: 8px;
        background: linear-gradient(90deg, #e9f1ec 25%, #f4f8f5 50%, #e9f1ec 75%);
        background-size: 200% 100%;
        animation: fvShimmer 1.2s linear infinite;
    }
    @keyframes fvShimmer { from { background-position: 200% 0; } to { background-position: -200% 0; } }
    @media (prefers-reduced-motion: reduce) { #featured .sk { animation: none; } }

    /* Empty / error */
    #featured .fv-empty {
        grid-column: 1 / -1; text-align: center;
        padding: 40px 20px; border: 1px dashed #cfe0d6; border-radius: 18px;
        color: #5b6f66; font-size: 15px; line-height: 1.6;
    }
    #featured .fv-empty strong { display: block; color: #051a13; font-size: 18px; margin-bottom: 6px; }
    #featured .fv-empty a { color: #0f4a35; font-weight: 700; }
    #featured .fv-more { display: flex; justify-content: center; margin-top: 28px; }

    #featured .fv-more[hidden] { display: none; }

    #featured .fv-more .btn:disabled { opacity: .6; cursor: wait; }

    /* =========== Vehicle cards (type cards jaise: full image + neeche content) =========== */
    #featured .vc-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
        gap: 22px;
    }
    #featured .vc-card {
        position: relative; display: flex; flex-direction: column;
        background: #fff; border: 1px solid #dcebe2; border-radius: 24px; overflow: hidden;
        color: #051a13; text-decoration: none;
        transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
    }
    #featured .vc-card:hover {
        transform: translateY(-6px); border-color: #bcd7c8;
        box-shadow: 0 24px 44px -26px rgba(5, 26, 19, .45);
    }
    #featured .vc-card:has(a:focus-visible) { outline: 3px solid #0f4a35; outline-offset: 3px; }

    /* Upar poori image */
    #featured .vc-media {
        position: relative; aspect-ratio: 4 / 3; overflow: hidden;
        background: radial-gradient(circle at 30% 25%, #1c5a40 0%, #062117 70%);
        display: grid; place-items: center;
    }
    #featured .vc-media img {
        position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;
        transition: transform .6s ease;
    }
    #featured .vc-card:hover .vc-media img { transform: scale(1.08); }
    #featured .vc-media::after {
        content: ""; position: absolute; inset: 0; pointer-events: none; z-index: 1;
        background:
            linear-gradient(180deg, rgba(5,26,19,.45) 0%, rgba(5,26,19,0) 30%),
            linear-gradient(180deg, rgba(5,26,19,0) 55%, rgba(5,26,19,.6) 100%);
    }
    #featured .vc-art {
        width: 96px; height: 96px; border-radius: 50%;
        display: grid; place-items: center; color: #fff;
        background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.16);
    }
    #featured .vc-art svg, #featured .vc-art i { width: 44px; height: 44px; }

    #featured .vc-type {
        position: absolute; left: 12px; top: 12px; z-index: 2;
        padding: 6px 12px; border-radius: 999px;
        background: rgba(5,26,19,.78); color: #c8f542; font-size: 12px; font-weight: 800;
        backdrop-filter: blur(4px);
    }
    #featured .vc-photos {
        position: absolute; right: 12px; bottom: 12px; z-index: 2;
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 10px; border-radius: 999px;
        background: rgba(255,255,255,.92); color: #051a13; font-size: 12px; font-weight: 700;
    }
    #featured .vc-photos svg, #featured .vc-photos i { width: 13px; height: 13px; }
    #featured .vc-price {
        position: absolute; left: 12px; bottom: 12px; z-index: 2;
        padding: 7px 12px; border-radius: 999px;
        background: #c8f542; color: #051a13; font-size: 15px; font-weight: 800;
    }
    #featured .vc-price small { font-size: 12px; font-weight: 700; opacity: .75; }
    #featured .vc-go {
        position: absolute; right: 12px; top: 12px; z-index: 2;
        width: 38px; height: 38px; border-radius: 50%;
        display: grid; place-items: center;
        background: rgba(255,255,255,.92); color: #051a13;
        transform: translateY(-4px); opacity: 0;
        transition: opacity .3s ease, transform .3s ease, background .2s;
    }
    #featured .vc-go svg, #featured .vc-go i { width: 18px; height: 18px; }
    #featured .vc-card:hover .vc-go, #featured .vc-card:has(a:focus-visible) .vc-go { opacity: 1; transform: translateY(0); background: #c8f542; }

    /* Unavailable */
    #featured .vc-card.is-unavailable .vc-media img,
    #featured .vc-card.is-unavailable .vc-art { filter: grayscale(.75); opacity: .7; }
    #featured .vc-off {
        position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); z-index: 2;
        padding: 7px 14px; border-radius: 999px; white-space: nowrap;
        background: rgba(5,26,19,.88); color: #fff; font-size: 12px; font-weight: 700;
    }

    /* Neeche content */
    #featured .vc-body { display: flex; flex-direction: column; gap: 10px; padding: 16px 18px 18px; flex: 1; }
    #featured .vc-title h3 { font-size: 19px; font-weight: 800; letter-spacing: -.01em; line-height: 1.25; }
    #featured .vc-title h3 a { color: inherit; text-decoration: none; }
    #featured .vc-title h3 a::after { content: ""; position: absolute; inset: 0; z-index: 3; }   /* poora card clickable */
    #featured .vc-title h3 a:focus-visible { outline: none; }
    #featured .vc-sub { margin-top: 3px; color: #5b6f66; font-size: 13px; }
    #featured .vc-loc { display: flex; align-items: center; gap: 6px; color: #5b6f66; font-size: 14px; }
    #featured .vc-loc svg, #featured .vc-loc i { width: 15px; height: 15px; color: #0f4a35; flex-shrink: 0; }

    #featured .vc-specs { display: flex; flex-wrap: wrap; gap: 6px; }
    #featured .vc-specs span {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 10px; border-radius: 10px;
        background: #f0f7f3; color: #051a13; font-size: 12px; font-weight: 700;
    }
    #featured .vc-specs svg, #featured .vc-specs i { width: 13px; height: 13px; color: #0f4a35; }

    #featured .vc-feats {
        display: flex; flex-wrap: wrap; gap: 6px;
        padding-top: 10px; margin-top: auto; border-top: 1px dashed #dcebe2;
    }
    #featured .vc-feats span {
        padding: 4px 10px; border-radius: 999px;
        background: #e7f6d0; color: #0f4a35; font-size: 12px; font-weight: 700;
    }
    #featured .vc-feats span.more { background: transparent; border: 1px dashed #cfe0d6; color: #5b6f66; }

    /* Skeleton */
    #featured .vc-card.is-skeleton { pointer-events: none; }
    #featured .vc-media .sk { position: absolute; inset: 0; border-radius: 0; }

    @media (max-width: 560px) {
        #featured .vc-grid { grid-template-columns: 1fr; gap: 16px; }
        #featured .vc-go { opacity: 1; transform: none; background: #c8f542; }
    }
    @media (prefers-reduced-motion: reduce) {
        #featured .vc-card, #featured .vc-media img { transition: none; }
    }

    /* =========== City filter =========== */
    #featured .fv-filter {
        display: flex; align-items: center; gap: 12px;
        margin: 0 0 24px; padding: 10px 12px;
        background: #f0f7f3; border: 1px solid #dcebe2; border-radius: 999px;
    }
    #featured .fv-filter-label {
        display: inline-flex; align-items: center; gap: 6px; flex-shrink: 0;
        padding: 0 6px 0 8px; color: #0f4a35; font-size: 14px; font-weight: 800;
    }
    #featured .fv-chips {
        display: flex; gap: 8px; overflow-x: auto; scroll-behavior: smooth;
        scrollbar-width: none; -ms-overflow-style: none; padding: 2px;
        mask-image: linear-gradient(90deg, #000 92%, transparent);
    }
    #featured .fv-chips::-webkit-scrollbar { display: none; }
    #featured .fv-chip {
        display: inline-flex; align-items: center; gap: 8px; flex-shrink: 0;
        height: 40px; padding: 0 16px; border-radius: 999px;
        border: 1px solid #dcebe2; background: #fff; color: #051a13;
        font: inherit; font-size: 14px; font-weight: 700; cursor: pointer; white-space: nowrap;
        transition: background .2s, color .2s, border-color .2s, transform .2s;
    }
    #featured .fv-chip small {
        min-width: 22px; height: 22px; padding: 0 6px; border-radius: 999px;
        display: inline-grid; place-items: center;
        background: #f0f7f3; color: #0f4a35; font-size: 12px; font-weight: 800;
    }
    #featured .fv-chip:hover { border-color: #0f4a35; transform: translateY(-1px); }
    #featured .fv-chip.is-active { background: #051a13; border-color: #051a13; color: #c8f542; }
    #featured .fv-chip.is-active small { background: #c8f542; color: #051a13; }
    #featured .fv-chip:focus-visible { outline: 3px solid #c8f542; outline-offset: 2px; }
    #featured .fv-chip.sk-chip { width: 96px; border: 0; pointer-events: none; }
    #featured .fv-filter-note { margin: -12px 0 20px; color: #5b6f66; font-size: 14px; }
    #featured .fv-filter-note button {
        border: 0; background: none; padding: 0; color: #0f4a35; font: inherit; font-weight: 700;
        text-decoration: underline; cursor: pointer;
    }

    @media (max-width: 640px) {
        #featured .fv-filter { border-radius: 18px; flex-direction: column; align-items: stretch; gap: 8px; }
        #featured .fv-filter-label { padding: 2px 4px; }
        #featured .fv-chips { mask-image: none; }
    }
</style>


<section class="section section-white" id="featured">
    <div class="container">
        <div class="section-head row" data-reveal>
            <div>
                <span class="eyebrow" id="featuredCount">Featured listings</span>
                <h2>Popular vehicles <span>ready to book.</span></h2>
            </div>
            <a href="{{ url('/vehicles') }}" class="btn btn-outline btn-sm">View all vehicles <i data-lucide="arrow-right" class="ic-xs"></i></a>
        </div>

        {{-- City filter (cities API se) --}}
        <div class="fv-filter" role="group" aria-label="Filter vehicles by city">
            <span class="fv-filter-label"><i data-lucide="map-pin" class="ic-xs"></i> City</span>
            <div class="fv-chips" id="cityChips">
                <button type="button" class="fv-chip is-active" data-city="" aria-pressed="true">All cities</button>
                <span class="fv-chip sk-chip sk" aria-hidden="true"></span>
                <span class="fv-chip sk-chip sk" aria-hidden="true"></span>
                <span class="fv-chip sk-chip sk" aria-hidden="true"></span>
            </div>
        </div>
        <p class="fv-filter-note" id="cityNote" hidden></p>

        <div class="vc-grid" id="featuredGrid" aria-live="polite" aria-busy="true">
            {{-- API aane tak skeleton cards --}}
            @for ($i = 0; $i < 6; $i++)
                <article class="vc-card is-skeleton" aria-hidden="true">
                    <div class="vc-media"><span class="sk"></span></div>
                    <div class="vc-body">
                        <span class="sk" style="height:20px;width:65%"></span>
                        <span class="sk" style="height:14px;width:45%"></span>
                        <span class="sk" style="height:24px;width:85%"></span>
                        <span class="sk" style="height:22px;width:60%;margin-top:6px"></span>
                    </div>
                </article>
            @endfor
        </div>

        <div class="fv-more" id="featuredMoreWrap" hidden>
            <button type="button" class="btn btn-outline" id="featuredMore">Show more vehicles</button>
        </div>
    </div>
</section>


<script>
(function () {
    const API_BASE = @json(rtrim(config('services.api.base_url') ?: url('/api/v1'), '/'));
    const API_URL  = API_BASE + '/vehicles';
    const PER_PAGE = 9;   // ek baar me kitni gaadiyan, "Show more" se baaki
    const LIST_URL = @json(url('/vehicles'));
    const DETAIL_URL = @json(url('/vehicles'));   // + /{id}
    const JOIN_URL = @json(url('/partner'));

    const grid = document.getElementById('featuredGrid');
    if (!grid) return;

    /* ---------- Helpers ---------- */
    const esc = v => String(v ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));

    const money = n => n === null || n === undefined
        ? '—'
        : '₹' + Number(n).toLocaleString('en-IN', { maximumFractionDigits: 0 });

    const LABELS = {
        fuel_type:    { petrol: 'Petrol', diesel: 'Diesel', cng: 'CNG', electric: 'Electric', hybrid: 'Hybrid' },
        transmission: { manual: 'Manual', automatic: 'Automatic', geared: 'Geared' }
    };

    // Scooter / e-rickshaw ke custom icons (baaki Lucide)
    const CUSTOM_SVG = {
        scooter:   '<circle cx="5.5" cy="17.5" r="2.5"/><circle cx="18.5" cy="17.5" r="2.5"/><path d="M8 17.5h7.5l2-7H14"/><path d="M14 4h2.5l2 6.5"/><path d="M3 13h6l2 4.5"/>',
        erickshaw: '<path d="M3 16V8a3 3 0 0 1 3-3h8l3 5h2a2 2 0 0 1 2 2v4"/><path d="M3 10h14"/><path d="M10 5v5"/><circle cx="6.5" cy="17" r="2"/><circle cx="17.5" cy="17" r="2"/><path d="M8.5 17h7"/>'
    };

    function icon(name, cls) {
        if (CUSTOM_SVG[name]) {
            return `<svg class="${cls}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">${CUSTOM_SVG[name]}</svg>`;
        }
        return `<i data-lucide="${name}" class="${cls}"></i>`;
    }

    // Vehicle type ke naam se icon (photo na ho tab)
    function typeIcon(v) {
        const t = String(v.vehicle_type || '').toLowerCase();
        if (t.includes('rickshaw')) return 'erickshaw';
        if (t.includes('scooter'))  return 'scooter';
        if (t.includes('bike') || t.includes('motor')) return 'bike';
        if (t.includes('truck') || t.includes('commercial') || t.includes('pickup')) return 'truck';
        if (v.fuel_type === 'electric' || t.includes('electric') || t.includes('ev')) return 'zap';
        return 'car';
    }

    function specs(v) {
        const list = [];
        if (v.transmission) list.push(['cog', LABELS.transmission[v.transmission] || v.transmission]);
        if (v.fuel_type)    list.push([v.fuel_type === 'electric' ? 'battery' : 'fuel', LABELS.fuel_type[v.fuel_type] || v.fuel_type]);

        if (v.seating_capacity) list.push(['users', `${v.seating_capacity} seats`]);
        if (v.fuel_type === 'electric' && v.range_per_charge) list.push(['gauge', `${v.range_per_charge} km`]);
        else if (v.mileage) list.push(['gauge', `${v.mileage} km/l`]);

        return list.slice(0, 4);
    }

    /* ---------- Card (type cards jaisa: full image + neeche content) ---------- */
    function cardHtml(v) {
        const photos    = v.images || [];
        const cover     = photos[0];
        const url       = `${DETAIL_URL}/${encodeURIComponent(v.id)}`;
        const available = v.is_available !== false;
        const feats     = v.features || [];
        const sub       = [v.brand, v.model, v.manufacturing_year].filter(Boolean).join(' · ');

        return `
            <article class="vc-card ${available ? '' : 'is-unavailable'}">
                <div class="vc-media">
                    ${cover
                        ? `<img src="${esc(cover.url)}" alt="${esc(v.vehicle_name)}" loading="lazy" data-fallback="${typeIcon(v)}">`
                        : `<span class="vc-art">${icon(typeIcon(v), '')}</span>`}

                    ${v.vehicle_type ? `<span class="vc-type">${esc(v.vehicle_type)}</span>` : ''}
                    <span class="vc-go" aria-hidden="true"><i data-lucide="arrow-up-right"></i></span>
                    <span class="vc-price">${money(v.price_per_day)} <small>/day</small></span>
                    ${photos.length > 1 ? `<span class="vc-photos"><i data-lucide="image"></i> ${photos.length}</span>` : ''}
                    ${available ? '' : '<span class="vc-off">Not available right now</span>'}
                </div>

                <div class="vc-body">
                    <div class="vc-title">
                        <h3><a href="${url}">${esc(v.vehicle_name)}</a></h3>
                        ${sub ? `<p class="vc-sub">${esc(sub)}</p>` : ''}
                    </div>

                    <p class="vc-loc"><i data-lucide="map-pin"></i> ${esc([v.location_area, v.city].filter(Boolean).join(', '))}</p>

                    <div class="vc-specs">
                        ${specs(v).map(([ic, label]) => `<span><i data-lucide="${ic}"></i> ${esc(label)}</span>`).join('')}
                    </div>

                    ${feats.length ? `
                        <div class="vc-feats">
                            ${feats.slice(0, 3).map(f => `<span>${esc(f)}</span>`).join('')}
                            ${feats.length > 3 ? `<span class="more">+${feats.length - 3} more</span>` : ''}
                        </div>` : ''}
                </div>
            </article>`;
    }

    function refreshIcons() {
        if (window.lucide && typeof window.lucide.createIcons === 'function') window.lucide.createIcons();
    }

    function showEmpty(title, text) {
        grid.innerHTML = `<div class="fv-empty"><strong>${title}</strong>${text}</div>`;
        grid.setAttribute('aria-busy', 'false');
    }

    /* ---------- State ---------- */
    const moreWrap  = document.getElementById('featuredMoreWrap');
    const moreBtn   = document.getElementById('featuredMore');
    const countEl   = document.getElementById('featuredCount');
    const chipsEl   = document.getElementById('cityChips');
    const noteEl    = document.getElementById('cityNote');
    const CITIES_URL = API_BASE + '/vehicles/cities';

    const params = new URLSearchParams(window.location.search);
    let city     = params.get('city') || '';   // ?city=Noida se khule to wahi filter
    let typeId   = params.get('type') || '';   // ?type=3 -> sirf us vehicle type ki gaadiyan
    let typeName = '';
    let page     = 0;
    let lastPage = 1;
    let shown    = 0;
    let loadId   = 0;                          // purani request ka result ignore karne ke liye

    const SKELETON = grid.innerHTML;           // loading cards dobara dikhane ke liye

    function bindPhotoFallback(scope) {
        scope.querySelectorAll('.vc-media img:not([data-bound])').forEach(img => {
            img.dataset.bound = '1';
            img.addEventListener('error', () => {
                const art = document.createElement('span');
                art.className = 'vc-art';
                art.innerHTML = icon(img.dataset.fallback || 'car', '');
                img.replaceWith(art);
                refreshIcons();
            }, { once: true });
        });
    }

    /* ---------- City chips ---------- */
    function renderChips(cities, total) {
        const chip = (value, label, count) => `
            <button type="button" class="fv-chip ${value === city ? 'is-active' : ''}" data-city="${esc(value)}" aria-pressed="${value === city}">
                ${esc(label)} ${count !== null ? `<small>${count}</small>` : ''}
            </button>`;

        // URL wali city list me na ho to bhi chip dikhe (0 count)
        if (city && !cities.some(c => c.city.toLowerCase() === city.toLowerCase())) {
            cities = [{ city, total: 0 }, ...cities];
        }

        chipsEl.innerHTML = chip('', 'All cities', total)
            + cities.map(c => chip(c.city, c.city, c.total)).join('');

        const active = chipsEl.querySelector('.is-active');
        if (active && active.dataset.city) active.scrollIntoView({ block: 'nearest', inline: 'center' });
    }

    async function loadCities() {
        try {
            const res  = await fetch(CITIES_URL, { headers: { 'Accept': 'application/json' } });
            const data = await res.json().catch(() => ({}));
            if (!res.ok) throw new Error();
            renderChips(data.data || [], data.total ?? null);
        } catch (e) {
            // Cities na aayein to sirf "All cities" rahe
            chipsEl.innerHTML = `<button type="button" class="fv-chip is-active" data-city="" aria-pressed="true">All cities</button>`;
        }
    }

    chipsEl.addEventListener('click', e => {
        const btn = e.target.closest('[data-city]');
        if (!btn || btn.dataset.city === city) return;

        city = btn.dataset.city;
        chipsEl.querySelectorAll('[data-city]').forEach(b => {
            const on = b.dataset.city === city;
            b.classList.toggle('is-active', on);
            b.setAttribute('aria-pressed', String(on));
        });

        // URL me filter rakho (refresh / share par wahi filter)
        syncUrl();
        reload();
    });

    /* ---------- Vehicles ---------- */
    function updateCount(total) {
        if (!countEl) return;
        const plural = `vehicle${total === 1 ? '' : 's'}`;
        const word   = typeName ? `${typeName} ${plural}` : plural;   // jaise: 3 Car vehicles
        countEl.textContent = city ? `${total} ${word} in ${city}` : `${total} ${word} listed`;
    }

    // Kaunse filter lage hain -> note me dikhao
    function renderNote() {
        const parts = [];
        if (typeId) parts.push(`<strong>${esc(typeName || 'selected type')}</strong>`);
        if (city)   parts.push(`in <strong>${esc(city)}</strong>`);

        if (!parts.length) { noteEl.hidden = true; return; }

        noteEl.innerHTML = `Showing ${parts.join(' ')}.
            ${typeId ? '<button type="button" id="clearType">Show all types</button>' : ''}
            ${typeId && city ? ' · ' : ''}
            ${city ? '<button type="button" id="clearCity">Show all cities</button>' : ''}`;
        noteEl.hidden = false;
    }

    function syncUrl() {
        const url = new URL(window.location.href);
        city   ? url.searchParams.set('city', city)   : url.searchParams.delete('city');
        typeId ? url.searchParams.set('type', typeId) : url.searchParams.delete('type');
        window.history.replaceState({}, '', url);
    }

    function highlightType() {
        document.querySelectorAll('#typeGrid [data-type-id]').forEach(c =>
            c.classList.toggle('is-active', c.dataset.typeId === String(typeId)));
    }

    // Categories section se call hota hai
    window.wheeloFilterByType = function (id, name) {
        typeId   = String(id || '');
        typeName = name || '';
        highlightType();
        syncUrl();
        reload();
        document.getElementById('featured').scrollIntoView({ behavior: 'smooth' });
    };

    // Type names aa gaye -> URL wale type ka naam set karo
    function setTypeNameFrom(types) {
        if (!typeId) return;
        const t = (types || []).find(x => String(x.id) === String(typeId));
        if (t) { typeName = t.vehicle_type; renderNote(); }
    }
    document.addEventListener('wheelo:types', e => setTypeNameFrom(e.detail));
    if (window.WHEELO_TYPES) setTypeNameFrom(window.WHEELO_TYPES);

    async function loadPage() {
        const myId = loadId;
        const next = page + 1;

        const q = new URLSearchParams({ show_all: 1, sort: 'latest', per_page: PER_PAGE, page: next });
        if (city) { q.set('city', city); q.set('city_exact', 1); }
        if (typeId) q.set('vehicle_type_id', typeId);

        const res  = await fetch(`${API_URL}?${q.toString()}`, { headers: { 'Accept': 'application/json' } });
        const data = await res.json().catch(() => ({}));
        if (!res.ok) throw new Error(data.message || 'Could not load vehicles.');
        if (myId !== loadId) return;   // beech me city badal gayi

        const vehicles = data.data || [];
        const meta     = data.meta || {};

        if (next === 1) {
            noteEl.hidden = true;

            if (!vehicles.length) {
                moreWrap.hidden = true;
                updateCount(0);
                renderNote();
                showEmpty(
                    typeId || city
                        ? `No ${esc(typeName || 'vehicles')}${city ? ' in ' + esc(city) : ''} yet`
                        : 'New vehicles are on the way',
                    typeId || city
                        ? `Try another ${typeId ? 'category' : 'city'}, or <a href="${JOIN_URL}">list your vehicle on Wheelo</a>.`
                        : `Partners are adding vehicles right now. Own one? <a href="${JOIN_URL}">List your vehicle on Wheelo</a>.`
                );
                return;
            }
            grid.innerHTML = '';
        }

        grid.insertAdjacentHTML('beforeend', vehicles.map(cardHtml).join(''));
        grid.setAttribute('aria-busy', 'false');
        bindPhotoFallback(grid);
        refreshIcons();

        page     = meta.current_page || next;
        lastPage = meta.last_page || page;
        shown   += vehicles.length;

        const total = meta.total || shown;
        updateCount(total);

        renderNote();

        const left = total - shown;
        moreWrap.hidden = page >= lastPage || left <= 0;
        moreBtn.textContent = `Show more vehicles (${left} more)`;
    }

    function reload() {
        loadId++;
        page = 0; shown = 0; lastPage = 1;
        moreWrap.hidden = true;
        grid.innerHTML = SKELETON;
        grid.setAttribute('aria-busy', 'true');

        loadPage().catch(() => {
            showEmpty('Vehicles could not load', `Refresh the page, or <a href="${LIST_URL}">browse all vehicles</a>.`);
        });
    }

    // "Show all cities" / "Show all types" links
    noteEl.addEventListener('click', e => {
        if (e.target.id === 'clearCity') chipsEl.querySelector('[data-city=""]').click();
        if (e.target.id === 'clearType') {
            typeId = ''; typeName = '';
            highlightType();
            syncUrl();
            reload();
        }
    });

    moreBtn.addEventListener('click', async () => {
        moreBtn.disabled = true;
        moreBtn.textContent = 'Loading...';
        try {
            await loadPage();
        } catch (e) {
            moreBtn.textContent = 'Could not load. Try again';
        } finally {
            moreBtn.disabled = false;
        }
    });

    /* ---------- Init ---------- */
    loadCities();
    reload();

    // ?city= / ?type= ke saath aaye to seedha is section par scroll
    if ((city || typeId) && window.location.hash !== '#featured') {
        document.getElementById('featured').scrollIntoView({ behavior: 'smooth' });
    }
})();
</script>


{{-- =========================================================
     WHY WHEELO
========================================================== --}}
<section class="section" id="why">
    <div class="container">
        <div class="why-head">
            <div data-reveal>
                <span class="eyebrow">Why Wheelo</span>
                <h2 class="h2">Built for the future <span>of vehicle rentals.</span></h2>
                <p>Wheelo combines every vehicle category, verified people and transparent pricing to redefine renting and listing for modern cities.</p>
            </div>
            <aside class="why-note" data-reveal style="--d:.1s">
                <span class="why-note-ic"><i data-lucide="sparkles" class="ic-sm"></i></span>
                <strong>Every Vehicle, One Platform</strong>
                <p>From a scooter for a quick errand to a commercial truck for a delivery run — Wheelo covers it, not just electric.</p>
            </aside>
        </div>

        <div class="feature-grid">
            @foreach ([
                ['shield-check',    'Verified Owners & Renters', 'Every listing and account is ID-checked for a safer marketplace.'],
                ['clock',           'Live Availability',         'Real-time updates keep you informed from booking until your journey is complete.'],
                ['layout-grid',     'All Categories',            'Cars, bikes, scooters, EVs, e-rickshaws and commercial vehicles, together.'],
                ['heart-handshake', 'Customer First',            'Transparent pricing, responsive support and a seamless booking experience.'],
            ] as $i => [$ic, $title, $text])
                <div class="feature-card" data-reveal style="--d:{{ $i * 0.08 }}s">
                    <span class="feature-ic"><i data-lucide="{{ $ic }}" class="ic-sm"></i></span>
                    <h3>{{ $title }}</h3>
                    <p>{{ $text }}</p>
                </div>
            @endforeach
        </div>

        <div class="why-bar" data-reveal>
            <ul>
                <li><i data-lucide="layout-grid" class="ic-xs"></i> 6 Vehicle Categories</li>
                <li><i data-lucide="badge-check" class="ic-xs"></i> Verified Partners</li>
                <li><i data-lucide="navigation" class="ic-xs"></i> Live Tracking</li>
                <li><i data-lucide="headphones" class="ic-xs"></i> 24/7 Support</li>
            </ul>
            <div class="why-bar-cta">
                <span>Ready To Ride?</span>
                <a href="{{ url('/vehicles') }}" class="btn btn-lime btn-sm">Browse Vehicles <i data-lucide="arrow-right" class="ic-xs"></i></a>
            </div>
        </div>
    </div>
</section>


{{-- =========================================================
     JOURNEY
========================================================== --}}
<section class="section section-white" id="journey">
    <div class="container">
        <div class="section-head center" data-reveal>
            <span class="eyebrow">The journey</span>
            <h2>Rent smarter. <span>Ride better.</span></h2>
            <p>From choosing a vehicle to reaching your destination, Wheelo makes every journey effortless, reliable and transparent.</p>
        </div>

        <div class="steps">
            @foreach ([
                ['list-checks',    'Choose a Vehicle', 'Browse cars, bikes, scooters, EVs, e-rickshaws and commercial vehicles from one platform.'],
                ['calendar-check', 'Book Instantly',   'Pick your dates, choose the best option and confirm within seconds.'],
                ['navigation',     'Track Live',       'Follow your booking with real-time availability and journey updates.'],
                ['smile',          'Enjoy the Ride',   'Ride with confidence through verified owners and a trustworthy platform.'],
            ] as $i => [$ic, $title, $text])
                <div class="step" data-reveal style="--d:{{ $i * 0.1 }}s">
                    <span class="step-num">{{ $i + 1 }}</span>
                    <div class="step-card">
                        <span class="step-ic"><i data-lucide="{{ $ic }}" class="ic-sm"></i></span>
                        <h3>{{ $title }}</h3>
                        <p>{{ $text }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="center" data-reveal><a href="{{ url('/vehicles') }}" class="btn btn-dark btn-lg">Rent a Vehicle <i data-lucide="arrow-right" class="ic-xs"></i></a></div>
    </div>
</section>


{{-- =========================================================
     EARN
========================================================== --}}
<section class="section" id="earn">
    <div class="container">
        <div class="earn-panel">
            <span class="orb orb-earn" aria-hidden="true"></span>

            <div class="earn-head" data-reveal>
                <div>
                    <span class="eyebrow eyebrow-light">For owners & fleets</span>
                    <h2>Turn your vehicle into an <span>earning opportunity.</span></h2>
                    <p>Register any vehicle — from a scooter to a commercial truck — list it in minutes, manage booking requests, and track your earnings from one dashboard.</p>
                </div>
                <p class="earn-side">Built for individual owners, fleet operators and businesses looking to grow with Wheelo.</p>
            </div>

            <div class="earn-grid">
                @foreach ([
                    ['timer',       'List In Minutes',    'Add category, model, specs, photos and pricing with a guided listing flow.'],
                    ['inbox',       'Booking Requests',   'Review, approve or decline rental requests from one simple inbox.'],
                    ['wallet',      'Earnings Dashboard', 'Track active bookings, rental history and payouts in real time.'],
                    ['badge-check', 'Verified Renters',   'Every renter is ID-verified before a booking request reaches you.'],
                ] as $i => [$ic, $title, $text])
                    <div class="earn-card" data-reveal style="--d:{{ $i * 0.08 }}s">
                        <span class="earn-ic"><i data-lucide="{{ $ic }}" class="ic-sm"></i></span>
                        <h3>{{ $title }}</h3>
                        <p>{{ $text }}</p>
                    </div>
                @endforeach
            </div>

            <div class="earn-bar" data-reveal>
                <span><i data-lucide="sparkles" class="ic-xs"></i> Ready to list your first vehicle?</span>
                <a href="{{ url('/partner') }}" class="btn btn-lime btn-sm">Register Your Vehicle <i data-lucide="arrow-right" class="ic-xs"></i></a>
            </div>
        </div>
    </div>
</section>


{{-- =========================================================
     CITIES
========================================================== --}}
<section class="section section-white" id="cities">
    <div class="container">
        <div class="section-head row" data-reveal>
            <div>
                <span class="eyebrow">Where we operate</span>
                <h2>Popular rental <span>locations.</span></h2>
            </div>
            <p>Wheelo is live across major cities, with new locations added every quarter.</p>
        </div>

        <div class="city-grid">
            @foreach ($cities as $i => $city)
                <a href="{{ url('/') . '?city=' . urlencode($city['name']) . '#featured' }}" class="city-card" data-reveal style="--d:{{ $i * 0.06 }}s">
                    <span class="city-ic"><i data-lucide="map-pin" class="ic-xs"></i></span>
                    <span class="city-bg" aria-hidden="true"><i data-lucide="map-pin"></i></span>
                    <strong>{{ $city['name'] }}</strong>
                    <small>{{ $city['count'] }} vehicles</small>
                </a>
            @endforeach
        </div>
    </div>
</section>


{{-- =========================================================
     TESTIMONIALS
========================================================== --}}
<section class="section" id="reviews">
    <div class="container">
        <div class="section-head center" data-reveal>
            <span class="eyebrow">Customer reviews</span>
            <h2>Trusted by owners <span>and renters alike.</span></h2>
        </div>
    </div>

    <div class="marquee" aria-label="Customer reviews">
        <div class="marquee-track">
            @foreach ([false, true] as $dup)
                @foreach ($testimonials as $t)
                    <figure class="review-card" @if($dup) aria-hidden="true" @endif>
                        <div class="review-top">
                            <span class="review-quote"><i data-lucide="quote" class="ic-sm"></i></span>
                            <span class="stars">★★★★★</span>
                        </div>
                        <blockquote>"{{ $t['text'] }}"</blockquote>
                        <figcaption>
                            <span class="avatar">{{ strtoupper(substr($t['name'], 0, 1)) }}</span>
                            <div><strong>{{ $t['name'] }}</strong><small>{{ $t['role'] }}</small></div>
                        </figcaption>
                    </figure>
                @endforeach
            @endforeach
        </div>
    </div>
</section>


{{-- =========================================================
     COMMITMENT
========================================================== --}}
<section class="section section-white" id="commitment">
    <div class="container">
        <div class="section-head center" data-reveal>
            <span class="eyebrow">Our commitment</span>
            <h2>Built on trust. <span>Designed for every ride.</span></h2>
        </div>

        <div class="commit-grid">
            @foreach ([
                ['Every Vehicle',        'From two-wheelers to commercial fleets, every category is treated as a first-class citizen.'],
                ['Trust & Transparency', 'Fair pricing, dependable service — built around transparency, reliability and long-term trust.'],
                ['Built For Tomorrow',   'Continuously evolving to deliver a rental experience that scales with the city.'],
            ] as $i => [$title, $text])
                <div class="commit-card" data-reveal style="--d:{{ $i * 0.1 }}s">
                    <span class="commit-num">{{ sprintf('%02d', $i + 1) }}</span>
                    <h3>{{ $title }}</h3>
                    <p>{{ $text }}</p>
                </div>
            @endforeach
        </div>

        <div class="quote-card" data-reveal>
            <span class="quote-ic"><i data-lucide="quote" class="ic"></i></span>
            <p>"Renting shouldn't mean picking from a shortlist. It should mean finding the exact vehicle you need."</p>
            <span class="quote-by">— Team Wheelo</span>
        </div>
    </div>
</section>


{{-- =========================================================
     FINAL CTA
========================================================== --}}
<section class="section final-section">
    <div class="container">
        <div class="final-cta" data-reveal>
            <div>
                <span class="eyebrow eyebrow-dark">Get started today</span>
                <h2>Ready to rent, list or ride?</h2>
                <p>Join riders, owners and partners moving smarter with Wheelo.</p>
            </div>
            <div class="final-actions">
                <a href="{{ url('/vehicles') }}" class="btn btn-dark btn-lg">Rent a Vehicle <i data-lucide="arrow-right" class="ic-xs"></i></a>
                <a href="{{ url('/partner') }}" class="btn btn-outline-dark btn-lg">Register Your Vehicle</a>
            </div>
        </div>
    </div>
</section>

@endsection