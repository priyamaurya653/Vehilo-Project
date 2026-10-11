@extends('frontlayout.main')

@section('content')

<section class="ptn-page">

    {{-- =========================================================
         HERO + APPLICATION
    ========================================================== --}}
    <section class="ptn-hero">

        <div class="ptn-blob ptn-blob-1"></div>
        <div class="ptn-blob ptn-blob-2"></div>

        <div class="ptn-container ptn-hero-inner">

            <div class="ptn-hero-grid">

                {{-- =================================================
                     LEFT CONTENT
                ================================================== --}}
                <div>

                    <div class="ptn-badge">
                        <span class="ptn-dot"></span>
                        Partnership Program
                    </div>

                    <h1 class="ptn-title">
                        Build the Future
                        <br>
                        With
                        <span class="ptn-brand">
                            VEHILO
                            <span class="ptn-underline"></span>
                        </span>
                    </h1>

                    <p class="ptn-lead">
                        Join India's next-generation electric mobility ecosystem.
                        Launch a VEHILO franchise and build a sustainable business
                        across EV rentals, smart charging, fleet operations,
                        mobility hubs and delivery services.
                    </p>

                    {{-- Tags --}}
                    <div class="ptn-tags">
                        @foreach(['Fast Approval', 'Dedicated Support', 'PAN India Expansion', 'Trusted EV Platform'] as $tag)
                            <span class="ptn-tag">
                                <span class="ptn-dot"></span>
                                {{ $tag }}
                            </span>
                        @endforeach
                    </div>

                    {{-- Stats --}}
                    <div class="ptn-stats">
                        <div class="ptn-stat">
                            <div class="ptn-stat-num">24</div>
                            <div class="ptn-stat-label">Hrs Response</div>
                        </div>
                        <div class="ptn-stat">
                            <div class="ptn-stat-num">5+</div>
                            <div class="ptn-stat-label">Partner Types</div>
                        </div>
                        <div class="ptn-stat">
                            <div class="ptn-stat-num">PAN</div>
                            <div class="ptn-stat-label">India Reach</div>
                        </div>
                    </div>

                    {{-- Features --}}
                    <div class="ptn-block">

                        <div class="ptn-kicker">
                            <span class="ptn-dot"></span>
                            Built For Partners
                        </div>

                        <h2 class="ptn-h2">
                            More than a franchise.
                            <span class="ptn-accent">A complete mobility partnership.</span>
                        </h2>

                        <p class="ptn-muted">
                            VEHILO brings technology, mobility solutions and
                            operational support together so partners can focus
                            on building and growing their local business.
                        </p>

                        <div class="ptn-feature-grid">
                            @foreach([
                                ['icon' => '⚡', 'title' => 'Quick Onboarding', 'text' => 'Simple application and onboarding process.'],
                                ['icon' => '👥', 'title' => 'Partner Support',  'text' => 'Dedicated assistance throughout your journey.'],
                                ['icon' => '📈', 'title' => 'Grow Locally',     'text' => 'Build your presence in the growing EV market.'],
                            ] as $feature)
                                <div class="ptn-feature">
                                    <div class="ptn-feature-ic">{{ $feature['icon'] }}</div>
                                    <h3>{{ $feature['title'] }}</h3>
                                    <p>{{ $feature['text'] }}</p>
                                </div>
                            @endforeach
                        </div>

                    </div>

                </div>


                {{-- =================================================
                     RIGHT FORM
                ================================================== --}}
                <div class="ptn-form-wrap">

                    <div class="ptn-form-outer">

                        <div class="ptn-form-glow"></div>

                        <div class="ptn-form-card">

                            {{-- Header --}}
                            <div class="ptn-form-head">
                                <div class="ptn-form-top">
                                    <div class="ptn-form-ic">🤝</div>
                                    <span class="ptn-pill">Takes 2 minutes</span>
                                </div>

                                <h2 class="ptn-form-title">Franchise Application</h2>

                                <p class="ptn-form-sub">
                                    Tell us about your business goals, create your partner
                                    account and access your partner dashboard.
                                </p>
                            </div>

                            {{-- Success --}}
                            <div id="registerSuccess" role="status" class="v-alert v-alert-success hidden"></div>

                            {{-- Error --}}
                            <div id="registerError" role="alert" class="v-alert v-alert-error hidden"></div>


                            <form id="partnerRegisterForm" method="POST" class="ptn-form">

                                @csrf

                                {{-- Name / Mobile --}}
                                <div class="ptn-row">

                                    <div>
                                        <label for="pr_name" class="ptn-label">
                                            Full Name <span class="ptn-req">*</span>
                                        </label>
                                        <input type="text" id="pr_name" name="name" required autocomplete="name"
                                            placeholder="Enter full name" class="pr-input ptn-input">
                                        <p class="ptn-error hidden" data-error="name"></p>
                                    </div>

                                    <div>
                                        <label for="pr_mobile" class="ptn-label">
                                            Mobile Number <span class="ptn-req">*</span>
                                        </label>
                                        <input type="tel" id="pr_mobile" name="mobile" required maxlength="20" autocomplete="tel"
                                            placeholder="+91 XXXXX XXXXX" class="pr-input ptn-input">
                                        <p class="ptn-error hidden" data-error="mobile"></p>
                                    </div>

                                </div>

                                {{-- Email --}}
                                <div>
                                    <label for="pr_email" class="ptn-label">
                                        Email Address <span class="ptn-req">*</span>
                                    </label>
                                    <input type="email" id="pr_email" name="email" required autocomplete="email"
                                        placeholder="you@example.com" class="pr-input ptn-input">
                                    <p class="ptn-error hidden" data-error="email"></p>
                                </div>

                                {{-- Password --}}
                                <div class="ptn-row">

                                    <div>
                                        <label for="pr_password" class="ptn-label">
                                            Password <span class="ptn-req">*</span>
                                        </label>
                                        <input type="password" id="pr_password" name="password" required minlength="8" autocomplete="new-password"
                                            placeholder="Minimum 8 characters" class="pr-input ptn-input">
                                        <p class="ptn-error hidden" data-error="password"></p>
                                    </div>

                                    <div>
                                        <label for="pr_password_confirmation" class="ptn-label">
                                            Confirm Password <span class="ptn-req">*</span>
                                        </label>
                                        <input type="password" id="pr_password_confirmation" name="password_confirmation" required minlength="8" autocomplete="new-password"
                                            placeholder="Confirm password" class="pr-input ptn-input">
                                        <p class="ptn-error hidden" data-error="password_confirmation"></p>
                                    </div>

                                </div>

                                {{-- Partnership / Investment --}}
                                <div class="ptn-row">

                                    <div>
                                        <label for="pr_partnership_type" class="ptn-label">
                                            Partnership Type <span class="ptn-req">*</span>
                                        </label>
                                        <select id="pr_partnership_type" name="partnership_type" required class="pr-input ptn-input">
                                            <option value="">Select partnership</option>
                                            <option value="franchise">EV Franchise</option>
                                            <option value="fleet">Fleet Partner</option>
                                            <option value="rental">Rental Partner</option>
                                            <option value="charging">Charging Partner</option>
                                            <option value="delivery">Delivery Partner</option>
                                        </select>
                                        <p class="ptn-error hidden" data-error="partnership_type"></p>
                                    </div>

                                    <div>
                                        <label for="pr_investment" class="ptn-label">
                                            Investment Range <span class="ptn-req">*</span>
                                        </label>
                                        <select id="pr_investment" name="investment" required class="pr-input ptn-input">
                                            <option value="">Select investment</option>
                                            <option value="under-5">Under ₹5 Lakhs</option>
                                            <option value="5-10">₹5–10 Lakhs</option>
                                            <option value="10-25">₹10–25 Lakhs</option>
                                            <option value="25-50">₹25–50 Lakhs</option>
                                            <option value="50-plus">₹50+ Lakhs</option>
                                        </select>
                                        <p class="ptn-error hidden" data-error="investment"></p>
                                    </div>

                                </div>

                                {{-- Property --}}
                                <fieldset class="ptn-fieldset">
                                    <legend class="ptn-label">
                                        Do you own/lease a property? <span class="ptn-req">*</span>
                                    </legend>

                                    <div class="ptn-radio-grid">
                                        <label class="pr-radio ptn-radio">
                                            <input type="radio" name="property" value="yes" required>
                                            <span>Yes</span>
                                        </label>
                                        <label class="pr-radio ptn-radio">
                                            <input type="radio" name="property" value="no" required>
                                            <span>No</span>
                                        </label>
                                    </div>
                                    <p class="ptn-error hidden" data-error="property"></p>
                                </fieldset>

                                {{-- Space --}}
                                <div>
                                    <label for="pr_space" class="ptn-label">
                                        Available Space <span class="ptn-req">*</span>
                                    </label>
                                    <select id="pr_space" name="space" required class="pr-input ptn-input">
                                        <option value="">Select available space</option>
                                        <option value="under-500">Under 500 sq.ft</option>
                                        <option value="500-1000">500–1,000 sq.ft</option>
                                        <option value="1000-2500">1,000–2,500 sq.ft</option>
                                        <option value="2500-plus">2,500+ sq.ft</option>
                                    </select>
                                    <p class="ptn-error hidden" data-error="space"></p>
                                </div>

                                {{-- Experience / Fleet --}}
                                <div class="ptn-row">

                                    <div>
                                        <label for="pr_experience" class="ptn-label">
                                            Business Experience <span class="ptn-req">*</span>
                                        </label>
                                        <select id="pr_experience" name="experience" required class="pr-input ptn-input">
                                            <option value="">Select experience</option>
                                            <option value="new">New Business</option>
                                            <option value="1-3">1–3 Years</option>
                                            <option value="3-5">3–5 Years</option>
                                            <option value="5-plus">5+ Years</option>
                                        </select>
                                        <p class="ptn-error hidden" data-error="experience"></p>
                                    </div>

                                    <div>
                                        <label for="pr_fleet_size" class="ptn-label">
                                            Planned Fleet Size <span class="ptn-req">*</span>
                                        </label>
                                        <select id="pr_fleet_size" name="fleet_size" required class="pr-input ptn-input">
                                            <option value="">Select fleet size</option>
                                            <option value="1-5">1–5 Vehicles</option>
                                            <option value="6-10">6–10 Vehicles</option>
                                            <option value="11-25">11–25 Vehicles</option>
                                            <option value="25-plus">25+ Vehicles</option>
                                        </select>
                                        <p class="ptn-error hidden" data-error="fleet_size"></p>
                                    </div>

                                </div>

                                {{-- Consent --}}
                                <div>
                                    <label class="ptn-check">
                                        <input type="checkbox" name="consent" value="1" required>
                                        <span>
                                            I agree to be contacted by VEHILO regarding
                                            partnership and franchise opportunities.
                                        </span>
                                    </label>
                                    <p class="ptn-error hidden" data-error="consent"></p>
                                </div>

                                {{-- Submit --}}
                                <button id="registerButton" type="submit" class="ptn-submit">
                                    <span id="registerButtonText">Create Partner Account</span>
                                    <svg id="registerLoader" class="v-spinner hidden" fill="none" viewBox="0 0 24 24">
                                        <circle class="v-op25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="v-op75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                    </svg>
                                </button>

                                <p class="ptn-form-foot">
                                    Already registered?
                                    <a href="{{ url('/login') }}">Log in here</a>
                                </p>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
         PARTNERSHIP TYPES
    ========================================================== --}}
    <section class="ptn-types">

        <div class="ptn-container">

            <div class="ptn-types-head">
                <div class="ptn-kicker ptn-kicker-lime">
                    <span class="ptn-dot"></span>
                    Partnership Opportunities
                </div>

                <h2 class="ptn-h2-light">
                    Choose your way to <span>partner.</span>
                </h2>

                <p>Multiple business models. One growing electric mobility ecosystem.</p>
            </div>

            @php
                $partnerships = [
                    ['number' => '01', 'title' => 'EV Franchise',     'text' => 'Build and operate a VEHILO mobility hub in your city.'],
                    ['number' => '02', 'title' => 'Fleet Partner',    'text' => 'Add vehicles to the platform and build rental revenue.'],
                    ['number' => '03', 'title' => 'Charging Partner', 'text' => 'Create EV charging infrastructure for growing demand.'],
                    ['number' => '04', 'title' => 'Delivery Partner', 'text' => 'Power last-mile mobility and delivery operations.'],
                ];
            @endphp

            <div class="ptn-type-grid">
                @foreach($partnerships as $item)
                    <div class="ptn-type-card">
                        <div class="ptn-type-top">
                            <span class="ptn-type-num">{{ $item['number'] }}</span>
                            <span class="ptn-type-arrow">↗</span>
                        </div>
                        <h3>{{ $item['title'] }}</h3>
                        <p>{{ $item['text'] }}</p>
                    </div>
                @endforeach
            </div>

        </div>

    </section>


    {{-- =========================================================
         WHY PARTNER
    ========================================================== --}}
    <section class="ptn-why">

        <div class="ptn-container">

            <div class="ptn-why-grid">

                {{-- LEFT --}}
                <div>
                    <div class="ptn-kicker ptn-kicker-why">
                        <span class="ptn-dot"></span>
                        Why Partner
                    </div>

                    <h2 class="ptn-h2-lg">
                        Everything you need to launch,
                        <span class="ptn-accent">backed by VEHILO.</span>
                    </h2>

                    <p class="ptn-why-text">
                        From EV rentals to mobility hubs, our partnership
                        team supports you from application through launch.
                    </p>

                    <div class="ptn-benefit-grid">
                        @foreach([
                            ['title' => 'Higher Earnings',        'text' => 'Unlock new revenue opportunities through the VEHILO ecosystem.'],
                            ['title' => 'PAN India Expansion',    'text' => 'Build a franchise presence in your city with operational support.'],
                            ['title' => 'Fast Verification',      'text' => 'Applications reviewed through a simple onboarding process.'],
                            ['title' => 'Dedicated Partner Team', 'text' => 'Get assistance from application to launch.'],
                        ] as $benefit)
                            <div class="ptn-benefit">
                                <div class="ptn-benefit-ic">✓</div>
                                <h3>{{ $benefit['title'] }}</h3>
                                <p>{{ $benefit['text'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- RIGHT IMAGE --}}
                <div class="ptn-media">

                    <div class="ptn-media-glow"></div>

                    <div class="ptn-media-card">

                        <div class="ptn-media-img">

                            <img src="{{ asset('images/partner.jpg') }}" alt="VEHILO Partnership">

                            <div class="ptn-media-shade"></div>

                            <div class="ptn-media-caption">
                                <div class="ptn-media-badge">VEHILO Partner Network</div>
                                <h3>
                                    Build your business.
                                    <span>Move the future.</span>
                                </h3>
                                <p>
                                    Join the electric mobility ecosystem and
                                    create new opportunities with VEHILO.
                                </p>
                            </div>

                        </div>

                        <div class="ptn-float ptn-float-dark">
                            <div class="ptn-float-num">24 Hrs</div>
                            <div class="ptn-float-label">Avg. Response</div>
                        </div>

                        <div class="ptn-float ptn-float-light">
                            <div class="ptn-float-num">PAN India</div>
                            <div class="ptn-float-label">Partner Network</div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</section>


{{-- =========================================================
     REGISTER JAVASCRIPT
     API: POST /api/v1/partner/register (same as before)
     Register hote hi user role = admin banta hai ->
     Super Admin > Partners > All partners list me dikhega
========================================================== --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('partnerRegisterForm');
    if (!form) return;

    const button     = document.getElementById('registerButton');
    const buttonText = document.getElementById('registerButtonText');
    const loader     = document.getElementById('registerLoader');
    const successBox = document.getElementById('registerSuccess');
    const errorBox   = document.getElementById('registerError');

    /* ---------------- Error helpers ---------------- */
    function clearErrors() {
        errorBox.classList.add('hidden');
        successBox.classList.add('hidden');

        form.querySelectorAll('[data-error]').forEach(function (el) {
            el.textContent = '';
            el.classList.add('hidden');
        });

        form.querySelectorAll('.is-invalid').forEach(function (el) {
            el.classList.remove('is-invalid');
        });
    }

    function setFieldError(field, message) {
        const box = form.querySelector('[data-error="' + field + '"]');
        if (box) {
            box.textContent = message;
            box.classList.remove('hidden');
        }

        form.querySelectorAll('[name="' + field + '"]').forEach(function (input) {
            const target = input.type === 'radio' ? input.closest('.pr-radio') : input;
            if (target) target.classList.add('is-invalid');
        });
    }

    function showError(message) {
        errorBox.innerText = message;
        errorBox.classList.remove('hidden');
        errorBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    // Field badalte hi uska error hata do
    form.addEventListener('input', function (e) {
        const name = e.target.name;
        if (!name) return;
        const box = form.querySelector('[data-error="' + name + '"]');
        if (box) { box.textContent = ''; box.classList.add('hidden'); }
        form.querySelectorAll('[name="' + name + '"]').forEach(function (input) {
            const target = input.type === 'radio' ? input.closest('.pr-radio') : input;
            if (target) target.classList.remove('is-invalid');
        });
    });

    /* ---------------- Submit ---------------- */
    form.addEventListener('submit', async function (event) {

        event.preventDefault();
        clearErrors();

        const formData = new FormData(form);

        const password             = formData.get('password') || '';
        const passwordConfirmation = formData.get('password_confirmation') || '';

        if (password !== passwordConfirmation) {
            setFieldError('password_confirmation', 'Passwords do not match.');
            showError('Password and confirm password do not match.');
            return;
        }

        const payload = {
            name:                  String(formData.get('name') || '').trim(),
            mobile:                String(formData.get('mobile') || '').trim(),
            email:                 String(formData.get('email') || '').trim(),
            password:              password,
            password_confirmation: passwordConfirmation,
            partnership_type:      formData.get('partnership_type'),
            investment:            formData.get('investment'),
            property:              formData.get('property'),
            space:                 formData.get('space'),
            experience:            formData.get('experience'),
            fleet_size:            formData.get('fleet_size'),
            consent:               formData.get('consent') ? true : false
        };

        button.disabled = true;
        buttonText.innerText = 'Creating account...';
        loader.classList.remove('hidden');

        let registered = false;

        try {

            const response = await fetch('{{ url("/api/v1/partner/register") }}', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(payload)
            });

            const result = await response.json().catch(function () { return {}; });

            /* Validation / server error */
            if (!response.ok) {

                if (result.errors) {
                    Object.entries(result.errors).forEach(function ([field, messages]) {
                        setFieldError(field, Array.isArray(messages) ? messages[0] : messages);
                    });
                    showError('Please fix the highlighted fields and try again.');
                } else {
                    showError(result.message || 'Registration failed. Please try again.');
                }

                return;
            }

            /* Success */
            registered = true;

            successBox.innerText = 'Partner account created. Taking you to login...';
            successBox.classList.remove('hidden');
            successBox.scrollIntoView({ behavior: 'smooth', block: 'center' });

            form.reset();

            setTimeout(function () {
                window.location.href = '{{ url("/login") }}';
            }, 1500);

        } catch (error) {

            console.error('Register Error:', error);
            showError('Unable to connect to server. Please try again.');

        } finally {

            // Success par button disabled hi rahe (double submit na ho)
            if (!registered) {
                button.disabled = false;
                buttonText.innerText = 'Create Partner Account';
            } else {
                buttonText.innerText = 'Account created';
            }
            loader.classList.add('hidden');
        }
    });
});
</script>

@endsection