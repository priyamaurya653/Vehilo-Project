@extends('frontlayout.main')

@section('title', 'Leadership – VEHILO')

@section('content')

{{-- =========================================================
     LEADERSHIP PAGE CSS (Vision page jaisa, compact)
========================================================== --}}
<style>
    .ldr {
        --v-bg: #F0F7F3;
        --v-ink: #051A13;
        --v-green: #0F4A35;
        --v-lime: #C8F542;
        --v-lime-hover: #B5E62C;
        --v-line: #DCEBE2;
        --v-muted: #5b6b64;
        background: var(--v-bg);
        color: var(--v-ink);
    }
    .ldr *, .ldr *::before, .ldr *::after { box-sizing: border-box; }
    .ldr h1, .ldr h2, .ldr h3, .ldr p, .ldr blockquote { margin: 0; }
    .ldr a { text-decoration: none; }

    .ldr-container { max-width: 1200px; margin: 0 auto; padding: 0 16px; }
    .ldr-section { padding: 32px 0; }
    .ldr-white { background: #fff; }
    .ldr-dark { background: var(--v-ink); color: #fff; }

    .ldr-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--v-lime); flex-shrink: 0; }
    .ldr-kicker {
        display: inline-flex; align-items: center; gap: 8px;
        font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: .2em; color: var(--v-green);
    }
    .ldr-dark .ldr-kicker { color: var(--v-lime); }
    .ldr-h2 { margin-top: 6px; font-size: 24px; font-weight: 800; line-height: 1.2; letter-spacing: -.025em; }
    .ldr-h2 span { color: var(--v-green); }
    .ldr-dark .ldr-h2 { color: #fff; }
    .ldr-dark .ldr-h2 span { color: var(--v-lime); }
    .ldr-head { margin-bottom: 18px; }

    .ldr-ic {
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        width: 38px; height: 38px; border-radius: 10px; background: var(--v-bg); color: var(--v-green);
    }
    .ldr-ic svg { width: 19px; height: 19px; }

    /* Buttons */
    .ldr-actions { margin-top: 18px; display: flex; flex-wrap: wrap; gap: 10px; }
    .ldr-btn {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        height: 44px; padding: 0 18px; border-radius: 12px; font-size: 13px; font-weight: 800;
        transition: transform .15s, background .15s, border-color .15s;
    }
    .ldr-btn svg { width: 15px; height: 15px; }
    .ldr-btn-lime { background: var(--v-lime); color: var(--v-ink); }
    .ldr-btn-lime:hover { background: var(--v-lime-hover); transform: translateY(-2px); }
    .ldr-btn-ghost { border: 1px solid rgba(255, 255, 255, .2); color: #fff; }
    .ldr-btn-ghost:hover { background: rgba(255, 255, 255, .08); }
    .ldr-btn:focus-visible { outline: 3px solid var(--v-lime); outline-offset: 3px; }

    /* Avatar: photo ho to photo, warna initials */
    .ldr-av {
        display: grid; place-items: center; flex-shrink: 0; overflow: hidden;
        width: 52px; height: 52px; border-radius: 50%;
        background: linear-gradient(140deg, var(--v-lime), #8fd14f); color: var(--v-ink);
        font-size: 16px; font-weight: 800;
    }
    .ldr-av img { width: 100%; height: 100%; object-fit: cover; }
    .ldr-av.is-dark { background: linear-gradient(140deg, var(--v-green), var(--v-ink)); color: var(--v-lime); }

    /* =========================================================
       HERO
    ========================================================= */
    .ldr-hero { padding: 16px 0 4px; }
    .ldr-banner {
        position: relative; overflow: hidden; display: grid; gap: 22px; align-items: center;
        padding: 24px 18px; border-radius: 24px; color: #fff;
        background:
            radial-gradient(480px 240px at 100% 0%, rgba(200, 245, 66, .22), transparent 70%),
            radial-gradient(380px 220px at 0% 100%, rgba(15, 74, 53, .9), transparent 70%),
            var(--v-ink);
    }
    .ldr-banner::after {
        content: ""; position: absolute; inset: 0; pointer-events: none; opacity: .5;
        background-image: radial-gradient(rgba(255, 255, 255, .08) 1px, transparent 1px);
        background-size: 18px 18px;
        mask-image: linear-gradient(90deg, transparent, #000 60%);
        -webkit-mask-image: linear-gradient(90deg, transparent, #000 60%);
    }
    .ldr-banner > * { position: relative; z-index: 1; }

    .ldr-crumb { display: flex; gap: 6px; margin-bottom: 10px; font-size: 12px; color: rgba(255, 255, 255, .5); }
    .ldr-crumb a { color: rgba(255, 255, 255, .7); }
    .ldr-crumb a:hover { color: var(--v-lime); }
    .ldr-badge {
        display: inline-flex; align-items: center; gap: 8px; margin-bottom: 12px; padding: 5px 11px;
        border: 1px solid rgba(255, 255, 255, .14); border-radius: 999px; background: rgba(255, 255, 255, .06);
        font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .16em; color: var(--v-lime);
    }
    .ldr-title { font-size: 30px; font-weight: 800; line-height: 1.1; letter-spacing: -.035em; }
    .ldr-title span { color: var(--v-lime); }
    .ldr-lead { margin-top: 10px; max-width: 30rem; font-size: 14px; line-height: 22px; color: rgba(255, 255, 255, .68); }

    .ldr-hero-card {
        padding: 18px; border: 1px solid rgba(255, 255, 255, .12); border-radius: 18px;
        background: rgba(255, 255, 255, .06);
        backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
    }
    .ldr-stack { display: flex; align-items: center; }
    .ldr-stack .ldr-av { width: 42px; height: 42px; font-size: 13px; border: 3px solid var(--v-ink); }
    .ldr-stack .ldr-av + .ldr-av { margin-left: -10px; }
    .ldr-stack-text { margin-left: 12px; }
    .ldr-stack-text strong { display: block; font-size: 14px; }
    .ldr-stack-text small { font-size: 11px; color: rgba(255, 255, 255, .55); }
    .ldr-hero-card blockquote { margin-top: 14px; font-size: 16px; font-weight: 700; line-height: 1.45; }
    .ldr-hero-card blockquote span { color: var(--v-lime); }

    /* =========================================================
       FOUNDER
    ========================================================= */
    .ldr-founder {
        display: grid; gap: 18px; align-items: center;
        padding: 18px; border: 1px solid var(--v-line); border-radius: 22px; background: #fff;
    }
    .ldr-founder-photo {
        position: relative; overflow: hidden; aspect-ratio: 1 / 1; max-height: 260px; border-radius: 18px;
        background:
            radial-gradient(200px 160px at 100% 0%, rgba(200, 245, 66, .25), transparent 70%),
            linear-gradient(150deg, var(--v-green), var(--v-ink));
        display: grid; place-items: center;
    }
    .ldr-founder-photo img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
    .ldr-founder-photo .ldr-av { width: 110px; height: 110px; font-size: 34px; }
    .ldr-founder-tag {
        position: absolute; left: 12px; bottom: 12px;
        padding: 5px 10px; border-radius: 999px; background: var(--v-lime); color: var(--v-ink);
        font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: .1em;
    }
    .ldr-role { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: .16em; color: var(--v-green); }
    .ldr-founder h3 { margin-top: 6px; font-size: 24px; font-weight: 800; letter-spacing: -.02em; }
    .ldr-founder p { margin-top: 8px; font-size: 14px; line-height: 22px; color: var(--v-muted); }
    .ldr-quote {
        margin-top: 14px; padding: 12px 16px; border-left: 4px solid var(--v-lime); border-radius: 0 12px 12px 0;
        background: var(--v-bg); font-size: 15px; font-weight: 700; line-height: 1.45;
    }
    .ldr-social { margin-top: 14px; display: flex; flex-wrap: wrap; gap: 8px; }
    .ldr-social a {
        display: inline-flex; align-items: center; gap: 7px; height: 36px; padding: 0 12px;
        border: 1px solid var(--v-line); border-radius: 10px; color: var(--v-ink); font-size: 12px; font-weight: 700;
        transition: border-color .2s, background .2s;
    }
    .ldr-social a:hover { border-color: var(--v-green); background: var(--v-bg); }
    .ldr-social a:focus-visible { outline: 3px solid var(--v-green); outline-offset: 2px; }
    .ldr-social svg { width: 15px; height: 15px; }

    /* =========================================================
       TEAM
    ========================================================= */
    .ldr-team { display: grid; gap: 12px; }
    .ldr-card {
        position: relative; overflow: hidden; display: flex; flex-direction: column;
        padding: 16px; border: 1px solid var(--v-line); border-radius: 18px; background: #fff;
        transition: transform .2s, box-shadow .2s, border-color .2s;
    }
    .ldr-card::before {
        content: ""; position: absolute; left: 0; top: 0; height: 3px; width: 0; background: var(--v-lime); transition: width .3s;
    }
    .ldr-card:hover { transform: translateY(-3px); border-color: var(--v-green); box-shadow: 0 16px 32px -20px rgba(5, 26, 19, .3); }
    .ldr-card:hover::before { width: 100%; }
    .ldr-card-top { display: flex; align-items: center; gap: 12px; }
    .ldr-card h3 { font-size: 16px; font-weight: 800; }
    .ldr-card .ldr-role { display: block; margin-top: 2px; letter-spacing: .12em; }
    .ldr-card p { margin-top: 10px; font-size: 13px; line-height: 20px; color: var(--v-muted); }
    .ldr-card-foot { margin-top: auto; padding-top: 12px; display: flex; align-items: center; justify-content: space-between; gap: 8px; }
    .ldr-tags { display: flex; flex-wrap: wrap; gap: 5px; }
    .ldr-tags span { padding: 3px 9px; border-radius: 999px; background: var(--v-bg); color: var(--v-green); font-size: 11px; font-weight: 700; }
    .ldr-card-foot a {
        display: grid; place-items: center; width: 32px; height: 32px; border-radius: 9px; flex-shrink: 0;
        border: 1px solid var(--v-line); color: var(--v-green); transition: background .2s, color .2s;
    }
    .ldr-card-foot a:hover { background: var(--v-ink); color: var(--v-lime); }
    .ldr-card-foot a:focus-visible { outline: 3px solid var(--v-green); outline-offset: 2px; }
    .ldr-card-foot svg { width: 15px; height: 15px; }

    /* =========================================================
       PRINCIPLES (dark)
    ========================================================= */
    .ldr-principles { display: grid; gap: 10px; }
    .ldr-principle {
        display: flex; gap: 12px; align-items: flex-start;
        padding: 16px; border: 1px solid rgba(255, 255, 255, .1); border-radius: 16px; background: rgba(255, 255, 255, .04);
        transition: border-color .2s;
    }
    .ldr-principle:hover { border-color: rgba(200, 245, 66, .4); }
    .ldr-principle .ldr-ic { background: rgba(200, 245, 66, .14); color: var(--v-lime); }
    .ldr-principle h3 { font-size: 15px; font-weight: 800; color: #fff; }
    .ldr-principle p { margin-top: 3px; font-size: 12px; line-height: 19px; color: rgba(255, 255, 255, .6); }

    /* =========================================================
       CTA
    ========================================================= */
    .ldr-cta {
        display: grid; gap: 14px; align-items: center;
        padding: 22px 18px; border-radius: 22px; color: #fff;
        background:
            radial-gradient(420px 200px at 100% 100%, rgba(200, 245, 66, .2), transparent 70%),
            linear-gradient(140deg, var(--v-green), var(--v-ink));
    }
    .ldr-cta h2 { font-size: 22px; font-weight: 800; line-height: 1.25; letter-spacing: -.02em; }
    .ldr-cta h2 span { color: var(--v-lime); }
    .ldr-cta p { margin-top: 4px; font-size: 13px; color: rgba(255, 255, 255, .65); }
    .ldr-cta .ldr-actions { margin-top: 0; }

    /* =========================================================
       RESPONSIVE
    ========================================================= */
    @media (min-width: 640px) {
        .ldr-container { padding: 0 24px; }
        .ldr-banner { padding: 30px 28px; }
        .ldr-title { font-size: 38px; }
        .ldr-h2 { font-size: 28px; }
        .ldr-team, .ldr-principles { grid-template-columns: repeat(2, 1fr); }
        .ldr-founder { grid-template-columns: 220px 1fr; padding: 20px; gap: 24px; }
        .ldr-cta { padding: 26px 28px; }
    }
    @media (min-width: 1024px) {
        .ldr-section { padding: 44px 0; }
        .ldr-hero { padding: 20px 0 4px; }
        .ldr-banner { grid-template-columns: 1.15fr .85fr; gap: 36px; padding: 36px 40px; }
        .ldr-title { font-size: 44px; }
        .ldr-team, .ldr-principles { grid-template-columns: repeat(4, 1fr); }
        .ldr-founder { grid-template-columns: 240px 1fr; }
        .ldr-cta { grid-template-columns: 1fr auto; gap: 24px; padding: 28px 36px; }
    }
    @media (prefers-reduced-motion: reduce) {
        .ldr-card, .ldr-card::before, .ldr-btn, .ldr-principle { transition: none; }
        .ldr-card:hover, .ldr-btn-lime:hover { transform: none; }
    }
</style>

@php
    // Chhote inline SVG icons
    $svg = function ($path) {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">' . $path . '</svg>';
    };
    $icons = [
        'shield'   => $svg('<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/>'),
        'users'    => $svg('<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.9"/><path d="M16 3.1a4 4 0 0 1 0 7.8"/>'),
        'bolt'     => $svg('<path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z"/>'),
        'ear'      => $svg('<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>'),
        'arrow'    => $svg('<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>'),
        'linkedin' => $svg('<path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/>'),
        'mail'     => $svg('<rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 6L2 7"/>'),
    ];

    // Naam se initials (photo na ho tab)
    $initials = function ($name) {
        $parts = preg_split('/\s+/', trim($name));
        return strtoupper(mb_substr($parts[0] ?? '', 0, 1) . mb_substr($parts[1] ?? '', 0, 1));
    };

    /*
    |--------------------------------------------------------------------------
    | NOTE: Naam, bio aur links placeholder hain -- apni team ki asli details bharo.
    | 'photo' => asset('images/team/founder.jpg')  (null ho to initials dikhenge)
    |--------------------------------------------------------------------------
    */
    $founder = [
        'name'     => 'Founder Name',
        'role'     => 'Founder & CEO',
        'photo'    => null,
        'bio'      => 'Started VEHILO so anyone can get the right vehicle easily, and every idle vehicle can become someone\'s income.',
        'quote'    => '"We are building the mobility network India\'s cities deserve."',
        'linkedin' => '#',
        'email'    => 'founder@vehilo.com',
    ];

    $team = [
        ['name' => 'Leader Name', 'role' => 'Co-Founder & COO',   'photo' => null, 'bio' => 'Runs operations, partner onboarding and fleet readiness.', 'tags' => ['Operations', 'Fleet'],       'linkedin' => '#'],
        ['name' => 'Leader Name', 'role' => 'CTO',                'photo' => null, 'bio' => 'Builds the VEHILO platform, dashboards and APIs.',          'tags' => ['Platform', 'Security'],      'linkedin' => '#'],
        ['name' => 'Leader Name', 'role' => 'Head of Partnerships','photo' => null, 'bio' => 'Grows our franchise, fleet and charging partner network.', 'tags' => ['Franchise', 'Partners'],     'linkedin' => '#'],
        ['name' => 'Leader Name', 'role' => 'Head of Customer Experience', 'photo' => null, 'bio' => 'Keeps every rider and owner supported, any time.', 'tags' => ['Support', 'Trust'],       'linkedin' => '#'],
    ];

    $principles = [
        ['icon' => 'ear',    'title' => 'Listen First',     'text' => 'Riders, owners and partners shape what we build.'],
        ['icon' => 'shield', 'title' => 'Earn Trust Daily', 'text' => 'Verified people, fair pricing, honest talk.'],
        ['icon' => 'bolt',   'title' => 'Move Fast, Safely','text' => 'Ship quickly without cutting corners.'],
        ['icon' => 'users',  'title' => 'Grow Together',    'text' => 'When partners grow, VEHILO grows.'],
    ];
@endphp

<div class="ldr">

    {{-- ================= HERO ================= --}}
    <section class="ldr-hero">
        <div class="ldr-container">
            <div class="ldr-banner">

                <div>
                    <nav class="ldr-crumb" aria-label="Breadcrumb">
                        <a href="{{ url('/') }}">Home</a> <span>/</span> <span>Leadership</span>
                    </nav>

                    <div class="ldr-badge"><span class="ldr-dot"></span> Leadership</div>

                    <h1 class="ldr-title">The people driving <span>VEHILO forward.</span></h1>

                    <p class="ldr-lead">
                        A team from mobility, technology and operations — working to make every vehicle
                        accessible in every Indian city.
                    </p>

                    <div class="ldr-actions">
                        <a href="#team" class="ldr-btn ldr-btn-lime">Meet the Team {!! $icons['arrow'] !!}</a>
                        <a href="{{ url('/careers') }}" class="ldr-btn ldr-btn-ghost">Join VEHILO</a>
                    </div>
                </div>

                <div class="ldr-hero-card">
                    <div class="ldr-stack">
                        <span class="ldr-av">{{ $initials($founder['name']) }}</span>
                        @foreach($team as $member)
                            <span class="ldr-av {{ $loop->even ? '' : 'is-dark' }}">{{ $initials($member['name']) }}</span>
                        @endforeach
                        <div class="ldr-stack-text">
                            <strong>{{ count($team) + 1 }} leaders</strong>
                            <small>One shared mission</small>
                        </div>
                    </div>
                    <blockquote>
                        Great mobility is built by a team that <span>listens, moves fast and earns trust.</span>
                    </blockquote>
                </div>

            </div>
        </div>
    </section>


    {{-- ================= FOUNDER ================= --}}
    <section class="ldr-section">
        <div class="ldr-container">

            <div class="ldr-head">
                <span class="ldr-kicker"><span class="ldr-dot"></span> Founder's desk</span>
                <h2 class="ldr-h2">Where it all <span>started.</span></h2>
            </div>

            <div class="ldr-founder">
                <div class="ldr-founder-photo">
                    @if($founder['photo'])
                        <img src="{{ $founder['photo'] }}" alt="{{ $founder['name'] }}">
                    @else
                        <span class="ldr-av">{{ $initials($founder['name']) }}</span>
                    @endif
                    <span class="ldr-founder-tag">Founder</span>
                </div>

                <div>
                    <span class="ldr-role">{{ $founder['role'] }}</span>
                    <h3>{{ $founder['name'] }}</h3>
                    <p>{{ $founder['bio'] }}</p>
                    <div class="ldr-quote">{{ $founder['quote'] }}</div>
                    <div class="ldr-social">
                        <a href="{{ $founder['linkedin'] }}" target="_blank" rel="noopener">{!! $icons['linkedin'] !!} LinkedIn</a>
                        <a href="mailto:{{ $founder['email'] }}">{!! $icons['mail'] !!} {{ $founder['email'] }}</a>
                    </div>
                </div>
            </div>

        </div>
    </section>


    {{-- ================= TEAM ================= --}}
    <section class="ldr-section ldr-white" id="team">
        <div class="ldr-container">

            <div class="ldr-head">
                <span class="ldr-kicker"><span class="ldr-dot"></span> Leadership team</span>
                <h2 class="ldr-h2">Meet the people <span>behind VEHILO.</span></h2>
            </div>

            <div class="ldr-team">
                @foreach($team as $member)
                    <article class="ldr-card">
                        <div class="ldr-card-top">
                            <span class="ldr-av {{ $loop->even ? 'is-dark' : '' }}">
                                @if($member['photo'])
                                    <img src="{{ $member['photo'] }}" alt="{{ $member['name'] }}">
                                @else
                                    {{ $initials($member['name']) }}
                                @endif
                            </span>
                            <div>
                                <h3>{{ $member['name'] }}</h3>
                                <span class="ldr-role">{{ $member['role'] }}</span>
                            </div>
                        </div>

                        <p>{{ $member['bio'] }}</p>

                        <div class="ldr-card-foot">
                            <div class="ldr-tags">
                                @foreach($member['tags'] as $tag)
                                    <span>{{ $tag }}</span>
                                @endforeach
                            </div>
                            <a href="{{ $member['linkedin'] }}" target="_blank" rel="noopener" aria-label="{{ $member['name'] }} on LinkedIn">{!! $icons['linkedin'] !!}</a>
                        </div>
                    </article>
                @endforeach
            </div>

        </div>
    </section>


    {{-- ================= HOW WE LEAD ================= --}}
    <section class="ldr-section ldr-dark">
        <div class="ldr-container">

            <div class="ldr-head">
                <span class="ldr-kicker"><span class="ldr-dot"></span> How we lead</span>
                <h2 class="ldr-h2">Principles we <span>live by.</span></h2>
            </div>

            <div class="ldr-principles">
                @foreach($principles as $item)
                    <div class="ldr-principle">
                        <div class="ldr-ic">{!! $icons[$item['icon']] !!}</div>
                        <div>
                            <h3>{{ $item['title'] }}</h3>
                            <p>{{ $item['text'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>


    {{-- ================= CTA ================= --}}
    <section class="ldr-section">
        <div class="ldr-container">
            <div class="ldr-cta">
                <div>
                    <h2>Build the future of mobility <span>with us.</span></h2>
                    <p>Join the team or partner with VEHILO in your city.</p>
                </div>
                <div class="ldr-actions">
                    <a href="{{ url('/careers') }}" class="ldr-btn ldr-btn-lime">View Open Roles {!! $icons['arrow'] !!}</a>
                    <a href="{{ url('/partner') }}" class="ldr-btn ldr-btn-ghost">Become a Partner</a>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection