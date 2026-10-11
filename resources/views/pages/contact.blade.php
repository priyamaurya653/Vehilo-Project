@extends('frontlayout.main')

@section('content')

@php
$vcIcons = [
'heart' => '
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
    d="M20.8 4.6a5.5 5.5 0 00-7.8 0L12 5.7l-1-1.1a5.5 5.5 0 00-7.8 7.8l1 1.1L12 21l7.8-7.5 1-1.1a5.5 5.5 0 000-7.8z" />
',
'users' => '
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
    d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H2v-2a4 4 0 014-4h3M16 3.5a4 4 0 010 7" />
<circle cx="9" cy="7" r="4" stroke-width="1.8" />',
'check' => '
<circle cx="12" cy="12" r="9" stroke-width="1.8" />
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 12l3 3 5-6" />',
'pin' => '
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
    d="M12 21s7-6.2 7-11a7 7 0 10-14 0c0 4.8 7 11 7 11z" />
<circle cx="12" cy="10" r="2.5" stroke-width="1.8" />',
'trend' => '
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 17l6-6 4 4 8-8M17 7h4v4" />',
'mail' => '
<rect x="3" y="5" width="18" height="14" rx="2" stroke-width="1.8" />
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7l9 6 9-6" />',
'bolt' => '
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />',
];

$vcContacts = [
['icon' => 'heart', 'title' => 'Customer Support', 'text' => 'Assistance for bookings, rentals, payments and rider
support.', 'link' => 'support@vehilo.com', 'href' => 'mailto:support@vehilo.com'],
['icon' => 'users', 'title' => 'Business Partnerships','text' => 'Fleet operators, franchise partners and strategic
collaborations.', 'link' => 'partners@vehilo.com', 'href' => 'mailto:partners@vehilo.com'],
['icon' => 'check', 'title' => 'Careers', 'text' => 'Join our growing team and help shape the future of electric
mobility.', 'link' => 'careers@vehilo.com', 'href' => 'mailto:careers@vehilo.com'],
['icon' => 'pin', 'title' => 'Corporate Office', 'text' => 'Summit Building, 7th Floor, Gomti Nagar, Lucknow, Uttar
Pradesh.', 'link' => null, 'href' => null],
['icon' => 'trend', 'title' => 'Business Growth', 'text' => 'Looking for large fleet solutions or enterprise
partnerships?', 'link' => "Let's Talk", 'href' => '#vc-form'],
];

$vcHelp = [
['icon' => 'bolt', 'title' => 'Fast Response', 'text' => 'Our team works to respond as quickly as possible.'],
['icon' => 'check', 'title' => 'Dedicated Team', 'text' => 'Every request reaches the appropriate department.'],
['icon' => 'check', 'title' => 'Secure Communication', 'text' => 'Your information stays safe and confidential.'],
['icon' => 'heart', 'title' => 'Customer First', 'text' => 'Delivering exceptional support is at the heart of VEHILO.'],
];
@endphp

<style>
/* ===== Scoped styles: everything lives under .vc-page ===== */
.vc-page,
.vc-page *,
.vc-page *::before,
.vc-page *::after {
    box-sizing: border-box;
}

.vc-page {
    background: #F0F7F3;
    color: #051A13;
    line-height: 1.5;
    min-height: 100vh;
}

.vc-page h1,
.vc-page h2,
.vc-page h3,
.vc-page p {
    margin: 0;
    padding: 0;
}

.vc-page a {
    text-decoration: none;
}

.vc-page svg {
    display: block;
    fill: none;
    stroke: currentColor;
}

.vc-wrap {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 32px;
}

/* Hero */
.vc-hero {
    position: relative;
    overflow: hidden;
    padding: 96px 0 48px;
}

.vc-glow {
    position: absolute;
    top: -120px;
    right: -120px;
    width: 420px;
    height: 420px;
    border-radius: 50%;
    background: rgba(200, 245, 66, .22);
    filter: blur(70px);
    pointer-events: none;
}

.vc-hero-inner {
    position: relative;
    max-width: 680px;
}

.vc-label {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
    font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .2em;
    text-transform: uppercase;
    color: #0F4A35;
}

.vc-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #C8F542;
    flex-shrink: 0;
}

.vc-dot-dark {
    background: #0F4A35;
}

.vc-h1 {
    font-size: 54px;
    line-height: 1.05;
    font-weight: 800;
    letter-spacing: -.035em;
    color: #051A13;
}

.vc-lead {
    margin-top: 24px;
    max-width: 600px;
    font-size: 16px;
    line-height: 1.7;
    color: #5b6b64;
}

.vc-btns {
    margin-top: 28px;
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}

.vc-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    height: 46px;
    padding: 0 22px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 700;
    color: #051A13;
    transition: transform .25s, background .25s, border-color .25s;
}

.vc-btn:hover {
    transform: translateY(-2px);
}

.vc-btn-lime {
    background: #C8F542;
    font-weight: 800;
    box-shadow: 0 10px 24px rgba(200, 245, 66, .3);
}

.vc-btn-lime:hover {
    background: #B5E62C;
}

.vc-btn-line {
    background: #fff;
    border: 1px solid #DCEBE2;
}

.vc-btn-line:hover {
    border-color: #0F4A35;
}

.vc-btn svg {
    width: 14px;
    height: 14px;
    stroke-width: 2;
}

.vc-tags {
    margin-top: 24px;
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.vc-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border: 1px solid #DCEBE2;
    border-radius: 999px;
    background: #fff;
    font-size: 11px;
    font-weight: 600;
    color: #0F4A35;
}

/* Section titles */
.vc-title {
    font-size: 34px;
    font-weight: 800;
    letter-spacing: -.02em;
    color: #051A13;
}

.vc-title-center {
    text-align: center;
}

/* Cards */
.vc-section {
    padding: 32px 0 96px;
}

.vc-grid-3 {
    margin-top: 32px;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

.vc-grid-4 {
    margin-top: 48px;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

.vc-card {
    background: #fff;
    border: 1px solid rgba(220, 235, 226, .7);
    border-radius: 18px;
    padding: 24px;
    box-shadow: 0 1px 3px rgba(5, 26, 19, .05);
    transition: transform .3s, box-shadow .3s;
}

.vc-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 30px rgba(5, 26, 19, .08);
}

.vc-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: #E8F3ED;
    color: #0F4A35;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background .3s;
}

.vc-icon svg {
    width: 20px;
    height: 20px;
}

.vc-card:hover .vc-icon {
    background: #C8F542;
}

.vc-card h3 {
    margin-top: 20px;
    font-size: 16px;
    font-weight: 700;
    color: #051A13;
}

.vc-card p {
    margin-top: 8px;
    font-size: 13.5px;
    line-height: 1.7;
    color: #6b7a73;
}

.vc-link {
    margin-top: 12px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 13.5px;
    font-weight: 600;
    color: #0F4A35;
}

.vc-link:hover {
    text-decoration: underline;
}

.vc-link svg {
    width: 11px;
    height: 11px;
    stroke-width: 2;
}

/* Form section */
.vc-form-section {
    background: #EBF4EE;
    padding: 80px 0;
}

.vc-split {
    display: grid;
    grid-template-columns: 0.9fr 1.1fr;
    gap: 32px;
    align-items: start;
}

.vc-stack {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.vc-stack .vc-card:hover {
    transform: none;
    box-shadow: 0 1px 3px rgba(5, 26, 19, .05);
}

.vc-dark {
    background: #051A13;
    border-radius: 18px;
    padding: 24px;
    box-shadow: 0 20px 40px rgba(5, 26, 19, .12);
}

.vc-dark .vc-label {
    margin: 0;
    color: #C8F542;
    font-size: 11px;
}

.vc-dark p {
    margin-top: 32px;
    font-size: 13.5px;
    line-height: 1.7;
    color: rgba(255, 255, 255, .62);
}

.vc-dark a {
    margin-top: 12px;
    display: inline-block;
    font-size: 13.5px;
    font-weight: 600;
    color: #C8F542;
}

.vc-dark a:hover {
    text-decoration: underline;
}

.vc-formbox {
    background: #fff;
    border: 1px solid rgba(220, 235, 226, .7);
    border-radius: 22px;
    padding: 36px;
    box-shadow: 0 1px 3px rgba(5, 26, 19, .05);
}

.vc-formbox h2 {
    font-size: 21px;
    font-weight: 800;
    letter-spacing: -.01em;
}

.vc-formbox .vc-sub {
    margin-top: 6px;
    font-size: 13.5px;
    color: #6b7a73;
}

.vc-form {
    margin-top: 28px;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.vc-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.vc-field label {
    display: block;
    margin-bottom: 8px;
    font-size: 12.5px;
    font-weight: 700;
    color: #051A13;
}

.vc-field input,
.vc-field select,
.vc-field textarea {
    display: block;
    width: 100%;
    height: 48px;
    padding: 0 16px;
    margin: 0;
    border: 1px solid #DCEBE2;
    border-radius: 12px;
    background: #fff;
    color: #051A13;
    font-family: inherit;
    font-size: 13.5px;
    outline: none;
    box-shadow: none;
    transition: border-color .2s, box-shadow .2s;
}

.vc-field select {
    color: #5b6b64;
}

.vc-field textarea {
    height: auto;
    min-height: 110px;
    padding: 14px 16px;
    resize: none;
    line-height: 1.5;
}

.vc-field textarea::placeholder {
    color: #94a3a0;
}

.vc-field input:focus,
.vc-field select:focus,
.vc-field textarea:focus {
    border-color: #0F4A35;
    box-shadow: 0 0 0 4px rgba(200, 245, 66, .2);
}

.vc-submit {
    align-self: flex-start;
    height: 48px;
    padding: 0 28px;
    border: 0;
    border-radius: 999px;
    background: #C8F542;
    color: #051A13;
    font-family: inherit;
    font-size: 13.5px;
    font-weight: 800;
    cursor: pointer;
    box-shadow: 0 10px 24px rgba(200, 245, 66, .35);
    transition: transform .25s, background .25s;
}

.vc-submit:hover {
    transform: translateY(-2px);
    background: #B5E62C;
}

.vc-help {
    padding: 80px 0 96px;
}

/* Tablet */
@media (max-width:1024px) {
    .vc-grid-3 {
        grid-template-columns: repeat(2, 1fr);
    }

    .vc-grid-4 {
        grid-template-columns: repeat(2, 1fr);
    }

    .vc-split {
        grid-template-columns: 1fr;
    }

    .vc-h1 {
        font-size: 46px;
    }
}

/* Mobile */
@media (max-width:640px) {
    .vc-wrap {
        padding: 0 20px;
    }

    .vc-hero {
        padding: 72px 0 32px;
    }

    .vc-h1 {
        font-size: 36px;
    }

    .vc-title {
        font-size: 28px;
    }

    .vc-grid-3,
    .vc-grid-4,
    .vc-row {
        grid-template-columns: 1fr;
    }

    .vc-formbox {
        padding: 24px;
    }

    .vc-form-section,
    .vc-help {
        padding: 56px 0;
    }
}
</style>

<div class="vc-page">

    {{-- ================= HERO ================= --}}
    <section class="vc-hero">
        <div class="vc-glow"></div>

        <div class="vc-wrap">
            <div class="vc-hero-inner">

                <div class="vc-label"><span class="vc-dot"></span>Get In Touch</div>

                <h1 class="vc-h1">Let's Build The Future Together</h1>

                <p class="vc-lead">
                    Whether you're looking to become a rider, partner with VEHILO,
                    explore business opportunities, media collaborations or simply
                    have a question, our team is here to help you.
                </p>

                <div class="vc-btns">
                    <a href="#" class="vc-btn vc-btn-lime">
                        Become a Rider
                        <svg viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6" />
                        </svg>
                    </a>
                    <a href="#" class="vc-btn vc-btn-line">
                        Become a Partner
                        <svg viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6" />
                        </svg>
                    </a>
                </div>

                <div class="vc-tags">
                    @foreach(['Fast Response', 'Dedicated Support', 'Business Partnerships'] as $vcTag)
                    <span class="vc-tag"><span class="vc-dot vc-dot-dark"></span>{{ $vcTag }}</span>
                    @endforeach
                </div>

            </div>
        </div>
    </section>


    {{-- ================= GET IN TOUCH CARDS ================= --}}
    <section class="vc-section">
        <div class="vc-wrap">

            <h2 class="vc-title">Get In Touch</h2>

            <div class="vc-grid-3">
                @foreach($vcContacts as $vcItem)
                <div class="vc-card">
                    <div class="vc-icon">
                        <svg viewBox="0 0 24 24">{!! $vcIcons[$vcItem['icon']] !!}</svg>
                    </div>
                    <h3>{{ $vcItem['title'] }}</h3>
                    <p>{{ $vcItem['text'] }}</p>
                    @if($vcItem['link'])
                    <a href="{{ $vcItem['href'] }}" class="vc-link">
                        {{ $vcItem['link'] }}
                        <svg viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M8 7h9v9" />
                        </svg>
                    </a>
                    @endif
                </div>
                @endforeach
            </div>

        </div>
    </section>


    {{-- ================= INFO + FORM ================= --}}
    <section class="vc-form-section" id="vc-form">
        <div class="vc-wrap">
            <div class="vc-split">

                {{-- Left --}}
                <div class="vc-stack">

                    <div class="vc-card">
                        <div class="vc-icon">
                            <svg viewBox="0 0 24 24">{!! $vcIcons['pin'] !!}</svg>
                        </div>
                        <h3>Corporate Office</h3>
                        <p>
                            Summit Building, 7th Floor<br>
                            Vibhuti Khand, Gomti Nagar<br>
                            Lucknow, Uttar Pradesh - 226010
                        </p>
                    </div>

                    <div class="vc-card">
                        <div class="vc-icon">
                            <svg viewBox="0 0 24 24">{!! $vcIcons['mail'] !!}</svg>
                        </div>
                        <h3>General Enquiries</h3>
                        <p>Have a question? Need assistance? Our team is happy to help.</p>
                        <a href="mailto:info@vehilo.com" class="vc-link">info@vehilo.com</a>
                    </div>

                    <div class="vc-dark">
                        <div class="vc-label">Executive Director</div>
                        <p>
                            For strategic partnerships, corporate collaborations, franchise
                            opportunities and business expansion, feel free to connect with
                            the Executive Director's office.
                        </p>
                        <a href="mailto:director@vehilo.com">director@vehilo.com</a>
                    </div>

                </div>

                {{-- Right: Form --}}
                <div class="vc-formbox">

                    <h2>We'd Love To Hear From You</h2>
                    <p class="vc-sub">Fill in the form below and our team will respond shortly.</p>

                    <form action="#" method="POST" class="vc-form">
                        @csrf

                        <div class="vc-row">
                            <div class="vc-field">
                                <label for="vc_name">Full Name</label>
                                <input type="text" id="vc_name" name="name" required>
                            </div>
                            <div class="vc-field">
                                <label for="vc_email">Email Address</label>
                                <input type="email" id="vc_email" name="email" required>
                            </div>
                        </div>

                        <div class="vc-row">
                            <div class="vc-field">
                                <label for="vc_phone">Phone Number</label>
                                <input type="tel" id="vc_phone" name="phone">
                            </div>
                            <div class="vc-field">
                                <label for="vc_subject">Subject</label>
                                <select id="vc_subject" name="subject" required>
                                    <option value="">Select a topic</option>
                                    <option value="support">Customer Support</option>
                                    <option value="rider">Become a Rider</option>
                                    <option value="partner">Business Partnership</option>
                                    <option value="careers">Careers</option>
                                    <option value="media">Media Collaboration</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="vc-field">
                            <label for="vc_message">Message</label>
                            <textarea id="vc_message" name="message" rows="4" required
                                placeholder="Tell us how we can help..."></textarea>
                        </div>

                        <button type="submit" class="vc-submit">Submit Enquiry</button>
                    </form>

                </div>

            </div>
        </div>
    </section>


    {{-- ================= ALWAYS HERE TO HELP ================= --}}
    <section class="vc-help">
        <div class="vc-wrap">

            <h2 class="vc-title vc-title-center">We're Always Here To Help</h2>

            <div class="vc-grid-4">
                @foreach($vcHelp as $vcItem)
                <div class="vc-card">
                    <div class="vc-icon">
                        <svg viewBox="0 0 24 24">{!! $vcIcons[$vcItem['icon']] !!}</svg>
                    </div>
                    <h3>{{ $vcItem['title'] }}</h3>
                    <p>{{ $vcItem['text'] }}</p>
                </div>
                @endforeach
            </div>

        </div>
    </section>

</div>

@endsection