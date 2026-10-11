@extends('frontlayout.main')

@section('content')

{{-- =========================================================
     LOGIN PAGE CSS (sirf is page ke liye)
========================================================== --}}
<style>
        /* ---------- Colors ---------- */
    :root {
        --v-bg: #F0F7F3;
        --v-ink: #051A13;
        --v-green: #0F4A35;
        --v-lime: #C8F542;
        --v-lime-hover: #B5E62C;
        --v-line: #DCEBE2;
        --v-slate-400: #94a3b8;
        --v-slate-500: #64748b;
        --v-slate-600: #475569;
    }

    .hidden { display: none !important; }

    .login-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--v-lime); flex-shrink: 0; }

    .v-spinner { width: 16px; height: 16px; animation: v-spin 1s linear infinite; }
    .v-op25 { opacity: .25; }
    .v-op75 { opacity: .75; }
    @keyframes v-spin { to { transform: rotate(360deg); } }

    /* =========================================================
       LOGIN PAGE
       ========================================================= */
    .login-page {
        display: flex; align-items: center;
        min-height: calc(100dvh - 72px);   /* 72px = header height */
        padding: 32px 16px; background: var(--v-bg);
    }
    .login-wrap { width: 100%; max-width: 56rem; margin: 0 auto; }
    .login-card {
        display: grid; overflow: hidden; border: 1px solid var(--v-line); border-radius: 24px; background: #fff;
        box-shadow: 0 24px 60px -24px rgba(5, 26, 19, .3);
    }

    /* Left panel (desktop only) */
    .login-side { position: relative; display: none; overflow: hidden; padding: 32px; background: var(--v-ink); }
    .login-blob { position: absolute; pointer-events: none; width: 240px; height: 240px; border-radius: 50%; filter: blur(64px); }
    .login-blob-1 { right: -80px; top: -80px; background: rgba(200, 245, 66, .2); }
    .login-blob-2 { left: -80px; bottom: -80px; background: var(--v-green); }
    .login-side-inner { position: relative; }
    .login-brand {
        display: inline-flex; align-items: center; gap: 8px; margin-bottom: 24px; padding: 4px 12px;
        border: 1px solid rgba(255, 255, 255, .1); border-radius: 999px; background: rgba(255, 255, 255, .05);
        font-size: 12px; font-weight: 700; color: var(--v-lime);
    }
    .login-side h1 { font-size: 30px; font-weight: 800; line-height: 1.25; letter-spacing: -.025em; color: #fff; }
    .login-side h1 span { color: var(--v-lime); }
    .login-side-text { margin-top: 12px; max-width: 20rem; font-size: 14px; line-height: 24px; color: rgba(255, 255, 255, .6); }
    .login-stats { position: relative; margin-top: 32px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
    .login-stat { padding: 10px 12px; border: 1px solid rgba(255, 255, 255, .1); border-radius: 12px; background: rgba(255, 255, 255, .05); }
    .login-stat-num { font-size: 16px; font-weight: 800; color: var(--v-lime); }
    .login-stat-label { font-size: 12px; color: rgba(255, 255, 255, .5); }

    /* Right panel */
    .login-main { padding: 32px 24px; }
    .login-form-box { width: 100%; max-width: 24rem; margin: 0 auto; }
    .login-brand-mobile {
        display: inline-flex; align-items: center; gap: 8px; margin-bottom: 16px; padding: 4px 12px;
        border-radius: 999px; background: var(--v-ink); font-size: 12px; font-weight: 700; color: var(--v-lime);
    }
    .login-head { margin-bottom: 20px; }
    .login-head h2 { font-size: 24px; font-weight: 800; letter-spacing: -.025em; color: var(--v-ink); }
    .login-head p { margin-top: 4px; font-size: 14px; color: var(--v-slate-500); }

    .login-alert { margin-bottom: 16px; padding: 10px 16px; border: 1px solid; border-radius: 12px; font-size: 14px; }
    .login-alert-error   { border-color: #fecaca; background: #fef2f2; color: #dc2626; }
    .login-alert-success { border-color: #bbf7d0; background: #f0fdf4; color: #15803d; }

    .login-form > * + * { margin-top: 16px; }
    .login-label { display: block; margin-bottom: 4px; font-size: 14px; font-weight: 600; color: var(--v-ink); }
    .login-label-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 4px; }
    .login-label-row .login-label { margin-bottom: 0; }
    .login-forgot { font-size: 12px; font-weight: 600; color: var(--v-green); }

    .login-input {
        width: 100%; height: 44px; padding: 0 16px; border: 1px solid var(--v-line); border-radius: 12px;
        background: #fff; color: var(--v-ink); font-size: 14px; outline: none;
        transition: border-color .15s, box-shadow .15s;
    }
    .login-input::placeholder { color: var(--v-slate-400); }
    .login-input:focus { border-color: var(--v-green); box-shadow: 0 0 0 4px rgba(200, 245, 66, .3); }
    .login-input-pass { padding-right: 48px; }

    /* Chrome autofill ka blue background hatao */
    .login-input:-webkit-autofill,
    .login-input:-webkit-autofill:hover,
    .login-input:-webkit-autofill:focus {
        -webkit-text-fill-color: var(--v-ink);
        -webkit-box-shadow: 0 0 0 1000px #fff inset;
        box-shadow: 0 0 0 1000px #fff inset;
        transition: background-color 9999s ease-in-out 0s;
    }

    .login-pass-wrap { position: relative; }
    .login-eye {
        position: absolute; right: 6px; top: 50%; transform: translateY(-50%);
        display: grid; place-items: center; width: 32px; height: 32px; padding: 0;
        border: 0; border-radius: 8px; background: transparent; color: var(--v-slate-400); cursor: pointer;
        transition: background .15s, color .15s;
    }
    .login-eye:hover { background: var(--v-bg); color: var(--v-green); }
    .login-eye svg { width: 20px; height: 20px; }

    .login-remember { display: flex; width: fit-content; align-items: center; gap: 8px; cursor: pointer; }
    .login-remember input { width: 16px; height: 16px; margin: 0; accent-color: var(--v-green); }
    .login-remember span { font-size: 14px; color: var(--v-slate-600); }

    .login-submit {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        width: 100%; height: 44px; padding: 0 20px; border: 0; border-radius: 12px; cursor: pointer;
        background: var(--v-lime); color: var(--v-ink); font-size: 14px; font-weight: 800;
        transition: background .15s;
    }
    .login-submit:hover:not(:disabled) { background: var(--v-lime-hover); }
    .login-submit:focus { outline: none; }
    .login-submit:focus-visible { box-shadow: 0 0 0 4px rgba(15, 74, 53, .3); }
    .login-submit:disabled { opacity: .6; cursor: not-allowed; }
    .login-submit .v-spinner { width: 20px; height: 20px; }

    .login-foot { margin-top: 20px; padding-top: 16px; border-top: 1px solid var(--v-line); text-align: center; font-size: 14px; color: var(--v-slate-500); }

    /* Login responsive */
    @media (min-width: 640px) {
        .login-page { padding-left: 24px; padding-right: 24px; }
        .login-main { padding: 32px 40px; }
    }
    @media (min-width: 1024px) {
        .login-card { grid-template-columns: .9fr 1.1fr; }
        .login-side { display: flex; flex-direction: column; justify-content: space-between; }
        .login-brand-mobile { display: none; }
    }
</style>

<section class="login-page">

    <div class="login-wrap">

        <div class="login-card">

            {{-- =====================================================
                 LEFT SIDE (sirf desktop)
            ====================================================== --}}
            <div class="login-side">

                <div class="login-blob login-blob-1"></div>
                <div class="login-blob login-blob-2"></div>

                <div class="login-side-inner">
                    <div class="login-brand">
                        <span class="login-dot"></span>
                        VEHILO
                    </div>

                    <h1>Move the future<br>with <span>VEHILO.</span></h1>

                    <p class="login-side-text">
                        Manage your mobility operations from one dashboard.
                    </p>
                </div>

                <div class="login-stats">
                    <div class="login-stat">
                        <div class="login-stat-num">EV</div>
                        <div class="login-stat-label">Mobility</div>
                    </div>
                    <div class="login-stat">
                        <div class="login-stat-num">PAN</div>
                        <div class="login-stat-label">India</div>
                    </div>
                    <div class="login-stat">
                        <div class="login-stat-num">24/7</div>
                        <div class="login-stat-label">Platform</div>
                    </div>
                </div>

            </div>

            {{-- =====================================================
                 RIGHT LOGIN
            ====================================================== --}}
            <div class="login-main">

                <div class="login-form-box">

                    {{-- Mobile par chhota brand badge (left panel hidden hota hai) --}}
                    <div class="login-brand-mobile">
                        <span class="login-dot"></span>
                        VEHILO
                    </div>

                    {{-- HEADER --}}
                    <div class="login-head">
                        <h2>Welcome back</h2>
                        <p>Log in to your VEHILO account.</p>
                    </div>

                    {{-- ERROR --}}
                    <div id="loginError" role="alert" class="login-alert login-alert-error hidden"></div>

                    {{-- SUCCESS --}}
                    <div id="loginSuccess" role="status" class="login-alert login-alert-success hidden"></div>

                    {{-- LOGIN FORM --}}
                    <form id="loginForm" class="login-form" novalidate>
                        @csrf

                        {{-- EMAIL --}}
                        <div>
                            <label for="loginEmail" class="login-label">Email address</label>
                            <input
                                type="email"
                                name="email"
                                id="loginEmail"
                                required
                                autocomplete="email"
                                placeholder="you@example.com"
                                class="login-input">
                        </div>

                        {{-- PASSWORD --}}
                        <div>
                            <div class="login-label-row">
                                <label for="loginPassword" class="login-label">Password</label>
                                <a href="#" class="login-forgot">Forgot password?</a>
                            </div>

                            <div class="login-pass-wrap">
                                <input
                                    type="password"
                                    name="password"
                                    id="loginPassword"
                                    required
                                    autocomplete="current-password"
                                    placeholder="Enter your password"
                                    class="login-input login-input-pass">

                                <button type="button" id="togglePassword" aria-label="Show password" class="login-eye">
                                    {{-- Eye open --}}
                                    <svg id="eyeOpen" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                    {{-- Eye closed --}}
                                    <svg id="eyeClosed" class="hidden" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <path d="M17.94 17.94A10.07 10.07 0 0112 19c-7 0-11-7-11-7a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 7 11 7a18.5 18.5 0 01-2.16 3.19M14.12 14.12a3 3 0 11-4.24-4.24M1 1l22 22" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- REMEMBER --}}
                        <label for="rememberMe" class="login-remember">
                            <input type="checkbox" id="rememberMe">
                            <span>Remember me</span>
                        </label>

                        {{-- LOGIN BUTTON --}}
                        <button type="submit" id="loginButton" class="login-submit">
                            <span id="loginButtonText">Log in</span>
                            <svg id="loginLoader" class="v-spinner hidden" fill="none" viewBox="0 0 24 24">
                                <circle class="v-op25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="v-op75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                        </button>
                    </form>

                    {{-- PARTNER --}}
                    <p class="login-foot">
                        Want to become a partner?
                        <a href="{{ url('/partner') }}">Apply for partnership</a>
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>


{{-- ============================================================
     LOGIN JAVASCRIPT (API logic same hai)
============================================================= --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

        /* ---------------- PASSWORD TOGGLE ---------------- */
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput  = document.getElementById('loginPassword');
        const eyeOpen        = document.getElementById('eyeOpen');
        const eyeClosed      = document.getElementById('eyeClosed');

        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function () {
                const show = passwordInput.type === 'password';
                passwordInput.type = show ? 'text' : 'password';
                eyeOpen.classList.toggle('hidden', show);
                eyeClosed.classList.toggle('hidden', !show);
                this.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
            });
        }

        /* ---------------- LOGIN FORM ---------------- */
        const loginForm = document.getElementById('loginForm');
        if (!loginForm) return;

        loginForm.addEventListener('submit', async function (event) {
            event.preventDefault();

            const email    = document.getElementById('loginEmail').value.trim();
            const password = document.getElementById('loginPassword').value;

            const errorBox   = document.getElementById('loginError');
            const successBox = document.getElementById('loginSuccess');
            const button     = document.getElementById('loginButton');
            const buttonText = document.getElementById('loginButtonText');
            const loader     = document.getElementById('loginLoader');

            function showError(msg) {
                errorBox.innerText = msg;
                errorBox.classList.remove('hidden');
            }

            /* RESET */
            errorBox.classList.add('hidden');
            successBox.classList.add('hidden');

            /* Khali field check (API call se pehle) */
            if (!email || !password) {
                showError('Enter your email and password.');
                return;
            }

            button.disabled = true;
            buttonText.innerText = 'Logging in...';
            loader.classList.remove('hidden');

            try {
                /* API LOGIN */
                const response = await fetch('{{ url("/api/v1/login") }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ email: email, password: password })
                });

                const result = await response.json().catch(() => ({}));

                /* API ERROR */
                if (!response.ok) {
                    showError(result.message || 'Login failed.');
                    return;
                }

                /* TOKEN CHECK */
                if (!result.access_token) {
                    showError('Access token was not received.');
                    return;
                }

                /* USER CHECK */
                if (!result.user) {
                    showError('User information was not received.');
                    return;
                }

                /* NORMALIZE ROLE */
                const role = String(result.user.role || '').toLowerCase().trim();

                /* SAVE TOKEN */
                localStorage.setItem('access_token', result.access_token);
                localStorage.setItem('token_type', result.token_type || 'Bearer');
                localStorage.setItem('user', JSON.stringify(result.user));
                localStorage.setItem('role', role);

                /* REMEMBER ME */
                const rememberMe = document.getElementById('rememberMe');
                if (rememberMe && rememberMe.checked) {
                    localStorage.setItem('remember_me', '1');
                } else {
                    localStorage.removeItem('remember_me');
                }

                /* SUCCESS */
                successBox.innerText = 'Logged in. Opening your dashboard...';
                successBox.classList.remove('hidden');

                /* ROLE REDIRECT */
                let redirectUrl = '{{ url("/") }}';

                if (['superadmin', 'super_admin', 'super-admin'].includes(role)) {
                    redirectUrl = '{{ url("/superadmin/dashboard") }}';
                } else if (role === 'admin') {
                    redirectUrl = '{{ url("/admin/dashboard") }}';
                } else if (role === 'user') {
                    redirectUrl = '{{ url("/user/dashboard") }}';
                }

                setTimeout(function () {
                    window.location.replace(redirectUrl);
                }, 500);

            } catch (error) {
                console.error('Login Error:', error);
                showError('Unable to connect to server. Please try again.');

            } finally {
                button.disabled = false;
                buttonText.innerText = 'Log in';
                loader.classList.add('hidden');
            }
        });
    });
</script>

@endsection