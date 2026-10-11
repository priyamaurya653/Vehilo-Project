@php
    $navLinks = [
        ['label' => 'Home',       'icon' => 'house',          'url' => url('/'),           'active' => request()->is('/')],
        ['label' => 'Careers',    'icon' => 'briefcase',      'url' => url('/careers'),    'active' => request()->is('careers*')],
        ['label' => 'Leadership', 'icon' => 'users',          'url' => url('/leadership'), 'active' => request()->is('leadership*')],
        ['label' => 'Vision',     'icon' => 'eye',            'url' => url('/vision'),     'active' => request()->is('vision*')],
        ['label' => 'About',      'icon' => 'info',           'url' => url('/about'),      'active' => request()->is('about*')],
        ['label' => 'Contact',    'icon' => 'message-circle', 'url' => url('/contact'),    'active' => request()->is('contact*')],
    ];
@endphp

<header class="site-header" id="siteHeader">
    <div class="container">
        <div class="header-bar">

            {{-- Mobile: menu button (left) --}}
            <button class="nav-toggle" id="navToggle" type="button" aria-label="Open menu" aria-expanded="false" aria-controls="mobileDrawer">
                <span class="burger"><span></span><span></span><span></span></span>
            </button>

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="brand" aria-label="Wheelo home">
                <img src="{{ asset('image/vehilo1.png') }}" alt="Wheelo" class="brand-logo"
                     >
                
            </a>

            {{-- Desktop nav --}}
            <nav class="main-nav" aria-label="Main">
                <ul class="nav-links">
                    @foreach ($navLinks as $link)
                        <li>
                            <a href="{{ $link['url'] }}" class="{{ $link['active'] ? 'is-active' : '' }}"
                               @if($link['active']) aria-current="page" @endif>{{ $link['label'] }}</a>
                        </li>
                    @endforeach
                </ul>

                <div class="nav-actions">
                    <a href="{{ url('/login') }}" class="btn btn-ghost btn-sm">
                        <i data-lucide="user-round" class="ic-xs"></i> User Login
                    </a>
                    <a href="{{ url('/partner') }}" class="btn btn-outline btn-sm">Become a Partner</a>
                    <a href="{{ url('/register') }}" class="btn btn-lime btn-sm">
                        <i data-lucide="zap" class="ic-xs"></i> Rent a Vehicle
                    </a>
                </div>
            </nav>

            {{-- Mobile: quick Book EV (right) --}}
            <a href="{{ url('/register') }}" class="btn btn-lime btn-sm header-quick">
                <i data-lucide="zap" class="ic-xs"></i> <span>Book EV</span>
            </a>

        </div>
    </div>
</header>


{{-- =========================================================
     MOBILE DRAWER (left se khulta hai)
========================================================== --}}
<div class="drawer-overlay" id="drawerOverlay" aria-hidden="true"></div>

<aside class="drawer" id="mobileDrawer" role="dialog" aria-modal="true" aria-label="Menu" aria-hidden="true" inert>

    <div class="drawer-head">
        <a href="{{ url('/') }}" class="brand" aria-label="Wheelo home">
            <img src="{{ asset('image/vehilo1.png') }}" alt="Wheelo" class="brand-logo"
                >
    
        </a>
        <button type="button" class="drawer-close" id="drawerClose" aria-label="Close menu">
            <i data-lucide="x" class="ic-sm"></i>
        </button>
    </div>

    <div class="drawer-body">

        {{-- Promo card --}}
        <div class="drawer-promo">
            <span class="drawer-promo-ic"><i data-lucide="zap" class="ic-sm"></i></span>
            <div>
                <strong>Rent any vehicle</strong>
                <small>Cars, bikes, EVs & more in 36 cities</small>
            </div>
            <a href="{{ url('/register') }}" class="drawer-promo-go" aria-label="Book EV"><i data-lucide="arrow-right" class="ic-xs"></i></a>
        </div>

        {{-- Links --}}
        <p class="drawer-label">Menu</p>
        <ul class="drawer-nav">
            @foreach ($navLinks as $i => $link)
                <li style="--i: {{ $i }}">
                    <a href="{{ $link['url'] }}" class="{{ $link['active'] ? 'is-active' : '' }}"
                       @if($link['active']) aria-current="page" @endif>
                        <span class="drawer-nav-ic"><i data-lucide="{{ $link['icon'] }}" class="ic-sm"></i></span>
                        <span class="drawer-nav-text">{{ $link['label'] }}</span>
                        <i data-lucide="chevron-right" class="ic-xs drawer-nav-arrow"></i>
                    </a>
                </li>
            @endforeach
        </ul>

        {{-- Actions --}}
        <div class="drawer-actions">
            <a href="{{ url('/login') }}" class="btn btn-outline"><i data-lucide="user-round" class="ic-xs"></i> User Login</a>
            <a href="{{ url('/partner') }}" class="btn btn-dark"><i data-lucide="handshake" class="ic-xs"></i> Become a Partner</a>
        </div>
    </div>

    {{-- Footer of drawer --}}
    <div class="drawer-foot">
        <a href="mailto:info@wheelo.in"><i data-lucide="mail" class="ic-xs"></i> info@wheelo.in</a>
        <div class="drawer-social">
            <a href="#" aria-label="Instagram"><i data-lucide="instagram" class="ic-xs"></i></a>
            <a href="#" aria-label="Facebook"><i data-lucide="facebook" class="ic-xs"></i></a>
            <a href="#" aria-label="LinkedIn"><i data-lucide="linkedin" class="ic-xs"></i></a>
            <a href="#" aria-label="X / Twitter"><i data-lucide="twitter" class="ic-xs"></i></a>
        </div>
    </div>
</aside>