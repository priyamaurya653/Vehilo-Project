{{-- =====================================================================
     ROLE BASED SIDEBAR
     - Teeno roles (superadmin / admin / user) ka menu yahin hai
     - JS login role dekh kar sirf usi role ka menu dikhata hai
     - Naya menu add karna ho to bas neeche $menus array me entry daalo
====================================================================== --}}
@php
// Icons (SVG path)
$icons = [
'home' => 'M3 12l9-9 9 9M5 10v10h5v-6h4v6h5V10',
'chart' => 'M18 20V10M12 20V4M6 20v-6',
'users' => 'M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8M22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75',
'partner' => 'M3 7h18v13H3zM8 7V4h8v3M3 12h18',
'car' => 'M5 11l1.5-4.5A2 2 0 018.4 5h7.2a2 2 0 011.9 1.5L19 11M3 11h18v6H3zM7 17v2M17 17v2',
'calendar' => 'M8 2v4M16 2v4M3 10h18M5 4h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z',
'wallet' => 'M2 7h20v12H2zM2 11h20M6 15h4',
'user' => 'M20 21a8 8 0 00-16 0M12 13a5 5 0 100-10 5 5 0 000 10z',
'settings' => 'M4 21v-7M4 10V3M12 21v-9M12 8V3M20 21v-5M20 12V3M1 14h6M9 8h6M17 16h6',
'help' => 'M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.1 9a3 3 0 015.8 1c0 2-3 2-3 4M12 17h.01',
'briefcase'=> 'M3 7h18v13H3zM8 7V5a2 2 0 012-2h4a2 2 0 012 2v2M3 13h18',
];

// Menu structure:
// ['group' => 'Label'] -> section heading
// ['label','icon','url'] -> simple link
// ['label','icon','match','children' => [[label,url]]] -> dropdown
$menus = [

/* ========== SUPER ADMIN ========== */
'superadmin' => [
['group' => 'Overview'],
['label' => 'Dashboard', 'icon' => 'home', 'match' => 'superadmin/dashboard*', 'children' => [
['Overview', 'superadmin/dashboard'],
['Analytics', 'superadmin/dashboard/analytics'],
]],
['label' => 'Reports', 'icon' => 'chart', 'match' => 'superadmin/reports*', 'children' => [
['Sales report', 'superadmin/reports/sales'],
['Revenue report', 'superadmin/reports/revenue'],
['User report', 'superadmin/reports/users'],
['Export data', 'superadmin/reports/export'],
]],
['label' => 'Careers', 'icon' => 'briefcase', 'match' => 'superadmin/careers*', 'children' => [
['Careers list', 'superadmin/careers'],
['Job hiring', 'superadmin/careers/jobs'],
]],

['group' => 'Manage'],
['label' => 'Partners', 'icon' => 'partner', 'match' => 'superadmin/partners*', 'children' => [
['All partners', 'superadmin/partners'],
['Partner requests', 'superadmin/partners/requests'],
]],
['label' => 'Users', 'icon' => 'users', 'match' => 'superadmin/users*', 'children' => [
['All users', 'superadmin/users'],
['Pending approval', 'superadmin/users/pending'],
]],
['label' => 'Bookings', 'icon' => 'calendar', 'url' => 'superadmin/bookings'],

['group' => 'System'],
['label' => 'Settings', 'icon' => 'settings', 'url' => 'superadmin/settings'],
],

/* ========== ADMIN (PARTNER) ========== */
'admin' => [
['group' => 'Overview'],
['label' => 'Dashboard', 'icon' => 'home', 'url' => 'admin/dashboard'],

['group' => 'Fleet'],
['label' => 'Vehicles', 'icon' => 'car', 'match' => 'admin/vehicle*', 'children' => [
['Add vehicle', 'admin/vehicles/create'],
['All vehicles', 'admin/vehicle/vehicles'],
['Add vehicle type', 'admin/vehicles/add-feature'],
['Vehicle types', 'admin/vehicles/types'],
]],
['label' => 'Bookings', 'icon' => 'calendar', 'url' => 'admin/bookings'],
['label' => 'Earnings', 'icon' => 'wallet', 'url' => 'admin/earnings'],

['group' => 'Account'],
['label' => 'Profile', 'icon' => 'user', 'url' => 'admin/profile'],
],

/* ========== USER ========== */
'user' => [
['group' => 'Overview'],
['label' => 'Dashboard', 'icon' => 'home', 'url' => 'user/dashboard'],

['group' => 'Rides'],
['label' => 'My bookings', 'icon' => 'calendar', 'url' => 'user/bookings'],
['label' => 'Payments', 'icon' => 'wallet', 'url' => 'user/payments'],

['group' => 'Account'],
['label' => 'Profile', 'icon' => 'user', 'url' => 'user/profile'],
['label' => 'Help', 'icon' => 'help', 'url' => 'user/help'],
],
];
@endphp

<aside class="sidebar" id="sidebar" aria-label="Main navigation">
    <div class="sidebar-brand">
        <a href="{{ url('/') }}" class="brand" aria-label="Wheelo home">
            <img src="{{ asset('image/vehilo1.png') }}" alt="Wheelo" class="brand-logo">
        </a>

        {{-- Mobile close (X) --}}
        <button type="button" class="sidebar-close" id="sidebarClose" aria-label="Close menu">
            <svg viewBox="0 0 24 24">
                <path d="M6 6l12 12M18 6L6 18" />
            </svg>
        </button>
    </div>

    <nav class="sidebar-nav">
        @foreach ($menus as $role => $items)
        {{-- Har role ka menu by default hidden, JS sahi wala dikhayega --}}
        <div class="role-menu" data-role="{{ $role }}" hidden>
            @foreach ($items as $i => $item)

            @if (isset($item['group']))
            <div class="nav-group-label">{{ $item['group'] }}</div>

            @elseif (!empty($item['children']))
            @php
            $open = request()->is($item['match']);
            $subId = 'sub-' . $role . '-' . $i;
            @endphp
            <div class="nav-item has-sub {{ $open ? 'open' : '' }}">
                <button type="button"
                    class="nav-link nav-toggle {{ $open ? 'active' : '' }}"
                    aria-expanded="{{ $open ? 'true' : 'false' }}"
                    aria-controls="{{ $subId }}">
                    <svg viewBox="0 0 24 24">
                        <path d="{{ $icons[$item['icon']] ?? $icons['home'] }}" />
                    </svg>
                    <span>{{ $item['label'] }}</span>
                    <svg class="chev" viewBox="0 0 24 24">
                        <path d="M6 9l6 6 6-6" />
                    </svg>
                </button>
                <div class="submenu" id="{{ $subId }}">
                    <div class="submenu-inner">
                        @foreach ($item['children'] as $child)
                        <a href="{{ url($child[1]) }}"
                            class="sub-link {{ request()->is($child[1]) ? 'active' : '' }}">{{ $child[0] }}</a>
                        @endforeach
                    </div>
                </div>
            </div>

            @else
            <div class="nav-item">
                <a href="{{ url($item['url']) }}"
                    class="nav-link {{ request()->is($item['url'] . '*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24">
                        <path d="{{ $icons[$item['icon']] ?? $icons['home'] }}" />
                    </svg>
                    <span>{{ $item['label'] }}</span>
                </a>
            </div>
            @endif

            @endforeach
        </div>
        @endforeach
    </nav>

    {{-- Profile (localStorage se fill hota hai) --}}
    <div class="sidebar-footer">
        <div class="sidebar-user">
            <span class="avatar" id="sbAvatar">U</span>
            <div class="user-info">
                <div class="user-name" id="sbName">User</div>
                <div class="user-mail" id="sbEmail"></div>
                <span class="user-role" id="sbRole"></span>
            </div>
        </div>
        <button type="button" class="logout-btn" id="sbLogout" aria-label="Log out" title="Log out">
            <svg viewBox="0 0 24 24">
                <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9" />
            </svg>
        </button>
    </div>
</aside>

{{-- Mobile overlay: bahar click karne par sidebar band --}}
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<script>
    (function() {
        const loginUrl = "{{ url('/login') }}";

        // Har role ka apna dashboard
        const dashboards = {
            superadmin: "{{ url('/superadmin/dashboard') }}",
            admin: "{{ url('/admin/dashboard') }}",
            user: "{{ url('/user/dashboard') }}",
        };

        const roleLabels = {
            superadmin: 'Super Admin',
            admin: 'Partner',
            user: 'User'
        };

        function clearAuth() {
            ['access_token', 'token_type', 'user', 'role', 'remember_me']
            .forEach(k => localStorage.removeItem(k));
        }

        // 1) Token nahi hai -> login
        const token = localStorage.getItem('access_token');
        if (!token) {
            window.location.replace(loginUrl);
            return;
        }

        // 2) User + role nikalo (superadmin ke sab variants ek kar do)
        let user = {};
        try {
            user = JSON.parse(localStorage.getItem('user') || '{}') || {};
        } catch (e) {}

        const rawRole = String(localStorage.getItem('role') || user.role || '').toLowerCase().trim();
        const role = ['superadmin', 'super_admin', 'super-admin'].includes(rawRole) ? 'superadmin' : rawRole;

        // 3) Unknown role -> logout karke login
        if (!dashboards[role]) {
            clearAuth();
            window.location.replace(loginUrl);
            return;
        }

        // 4) Galat role ka page khola -> apne dashboard par bhejo
        const pageRole = document.body.dataset.pageRole || '';
        if (pageRole && pageRole !== role) {
            window.location.replace(dashboards[role]);
            return;
        }

        // 5) Sirf apne role ka menu dikhao
        document.querySelectorAll('.role-menu').forEach(function(el) {
            el.hidden = el.dataset.role !== role;
        });

        // 6) Profile fill
        const name = user.name || roleLabels[role];
        const email = user.email || '';

        document.getElementById('sbName').textContent = name;
        document.getElementById('sbEmail').textContent = email;
        document.getElementById('sbAvatar').textContent = name.charAt(0).toUpperCase();
        document.getElementById('sbRole').textContent = roleLabels[role];

        // Page par jahan bhi .js-user-name hai wahan naam daal do
        document.querySelectorAll('.js-user-name').forEach(el => el.textContent = name);

        // Sab theek hai -> page dikhao
        document.body.classList.add('auth-ok');

        // 7) Logout
        document.getElementById('sbLogout').addEventListener('click', async function() {
            this.disabled = true;
            try {
                await fetch("{{ url('/api/v1/logout') }}", {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + token
                    }
                });
            } catch (e) {
                /* API fail ho to bhi local logout */
            }

            clearAuth();
            window.location.replace(loginUrl);
        });
    })();
</script>