@extends('frontlayout.main')

@section('content')

<style>
    * {
        box-sizing: border-box;
    }

    .vh-login-page {
 
        background: #f5f8fa;
        padding: 25px 30px;
        font-family: Arial, Helvetica, sans-serif;
        color: #081b15;
    }

    .vh-login-wrapper {
        max-width: 1450px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 43% 57%;
        background: #fff;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 15px 45px rgba(10, 35, 25, .08);
    }

    /* LEFT */
    .vh-login-left {
        position: relative;
        padding: 45px 45px;
        overflow: hidden;
        background:
            radial-gradient(circle at 85% 15%, rgba(98, 205, 139, .14), transparent 28%),
            linear-gradient(145deg, #101a30 0%, #17283b 48%, #0f5139 100%);
        color: #fff;
    }

    .vh-login-left::after {
        content: "";
        position: absolute;
        width: 230px;
        height: 230px;
        right: -80px;
        bottom: -80px;
        border-radius: 50%;
        background: rgba(200, 245, 66, .08);
        filter: blur(10px);
    }

    .vh-secure-badge {
        position: relative;
        z-index: 2;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border: 1px solid rgba(255,255,255,.15);
        border-radius: 25px;
        background: rgba(255,255,255,.08);
        font-size: 13px;
        font-weight: 700;
    }

    .vh-secure-icon {
        color: #67d49a;
        font-size: 16px;
    }

    .vh-left-heading {
        position: relative;
        z-index: 2;
        margin: 30px 0 0;
        max-width: 600px;
        font-size: 48px;
        line-height: 1.04;
        letter-spacing: -1.8px;
        font-weight: 800;
    }

    .vh-left-heading span {
        color: #61d095;
    }

    .vh-left-description {
        position: relative;
        z-index: 2;
        max-width: 550px;
        margin-top: 18px;
        color: #d6e6ed;
        font-size: 15px;
        line-height: 1.65;
    }

    /* FEATURES */
    .vh-feature-list {
        position: relative;
        z-index: 2;
        margin-top: 35px;
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .vh-feature {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .vh-feature-icon {
        width: 45px;
        height: 45px;
        flex: 0 0 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: rgba(255,255,255,.10);
        color: #61d095;
        font-size: 19px;
    }

    .vh-feature-content h4 {
        margin: 0;
        font-size: 15px;
        font-weight: 700;
    }

    .vh-feature-content p {
        margin: 3px 0 0;
        color: #c9dce5;
        font-size: 12px;
        line-height: 1.4;
    }

    /* RIGHT */
    .vh-login-right {
        background: #fff;
        padding: 35px 7%;
        position: relative;
    }

    /* STEPS */
    .vh-steps {
        width: 100%;
        display: flex;
        align-items: flex-start;
        margin-bottom: 40px;
    }

    .vh-step-item {
        flex: 1;
        position: relative;
        text-align: center;
    }

    .vh-step-item:not(:last-child)::after {
        content: "";
        position: absolute;
        top: 16px;
        left: calc(50% + 22px);
        right: calc(-50% + 22px);
        height: 2px;
        background: #edf1f3;
        z-index: 0;
    }

    .vh-step-item.completed:not(:last-child)::after,
    .vh-step-item.active:not(:last-child)::after {
        background: #198754;
    }

    .vh-step-circle {
        width: 42px;
        height: 42px;
        margin: 0 auto;
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #f1f4f7;
        color: #91a0ae;
        font-size: 14px;
        font-weight: 700;
    }

    .vh-step-item.active .vh-step-circle,
    .vh-step-item.completed .vh-step-circle {
        background: #198754;
        color: #fff;
    }

    .vh-step-label {
        margin-top: 7px;
        color: #84909c;
        font-size: 12px;
    }

    .vh-step-item.active .vh-step-label,
    .vh-step-item.completed .vh-step-label {
        color: #081b15;
        font-weight: 600;
    }

    /* FORM */
    .vh-form-container {
        max-width: 680px;
        margin: 0 auto;
    }

    .vh-form-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        background: #edf8f1;
        color: #198754;
        font-size: 22px;
        margin-bottom: 15px;
    }

    .vh-form-title {
        margin: 0;
        font-size: 27px;
        line-height: 1.2;
        font-weight: 800;
        color: #081b15;
    }

    .vh-form-subtitle {
        margin: 7px 0 0;
        color: #65717c;
        font-size: 14px;
        line-height: 1.5;
    }

    .vh-form {
        margin-top: 28px;
    }

    .vh-form-group {
        margin-bottom: 18px;
    }

    .vh-form-label {
        display: block;
        margin-bottom: 7px;
        font-size: 13px;
        font-weight: 700;
        color: #17221e;
    }

    .vh-required {
        color: #dc3545;
    }

    .vh-input-wrapper {
        display: flex;
        width: 100%;
        height: 52px;
        border: 1px solid #dce4df;
        border-radius: 11px;
        overflow: hidden;
        background: #fff;
        transition: .2s;
    }

    .vh-input-wrapper:focus-within {
        border-color: #198754;
        box-shadow: 0 0 0 3px rgba(25,135,84,.08);
    }

    .vh-country-code {
        min-width: 65px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-right: 1px solid #e4e9e6;
        background: #fafcfb;
        color: #33413a;
        font-size: 14px;
    }

    .vh-input-wrapper input {
        width: 100%;
        border: 0;
        outline: none;
        padding: 0 15px;
        font-size: 14px;
        color: #101915;
        background: transparent;
    }

    .vh-input {
        width: 100%;
        height: 52px;
        border: 1px solid #dce4df;
        border-radius: 11px;
        padding: 0 15px;
        outline: none;
        font-size: 14px;
        background: #fff;
        transition: .2s;
    }

    .vh-input:focus {
        border-color: #198754;
        box-shadow: 0 0 0 3px rgba(25,135,84,.08);
    }

    /* BUTTON */
    .vh-btn {
        width: 100%;
        height: 52px;
        border: 0;
        border-radius: 28px;
        background: #c8f542;
        color: #07150f;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: .2s;
        box-shadow: 0 8px 20px rgba(150,190,30,.14);
    }

    .vh-btn:hover {
        background: #b9e934;
        transform: translateY(-1px);
    }

    /* OTP */
    .vh-change-mobile {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 18px;
        color: #52615b;
        font-size: 13px;
        cursor: pointer;
    }

    .vh-change-mobile:hover {
        color: #198754;
    }

    .vh-otp-wrapper {
        display: flex;
        gap: 10px;
        margin: 25px 0 25px;
    }

    .vh-otp-input {
        width: 100%;
        height: 58px;
        border: 1px solid #dce4df;
        border-radius: 11px;
        text-align: center;
        font-size: 21px;
        font-weight: 700;
        outline: none;
        background: #fff;
    }

    .vh-otp-input:focus {
        border-color: #198754;
        box-shadow: 0 0 0 3px rgba(25,135,84,.08);
    }

    .vh-resend {
        display: block;
        margin: 16px auto 0;
        border: 0;
        background: none;
        color: #087b51;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
    }

    /* PROFILE */
    .vh-profile-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .vh-full {
        grid-column: 1 / -1;
    }

    .vh-verified {
        height: 52px;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0 15px;
        border: 1px solid #c9f1d8;
        border-radius: 11px;
        background: #f0fff5;
        color: #198754;
        font-size: 13px;
        font-weight: 600;
    }

    /* SUCCESS */
    .vh-success {
        display: none;
        text-align: center;
        padding: 30px 15px;
    }

    .vh-success-icon {
        width: 65px;
        height: 65px;
        margin: 0 auto 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #eaf8ef;
        color: #198754;
        font-size: 30px;
    }

    .vh-success h2 {
        margin: 0;
        font-size: 25px;
    }

    .vh-success p {
        margin-top: 7px;
        color: #66736d;
        font-size: 14px;
    }

    /* HIDDEN */
    .vh-panel {
        display: none;
    }

    .vh-panel.active {
        display: block;
    }

    /* RESPONSIVE */
    @media (max-width: 1100px) {
        .vh-login-page {
            padding: 20px;
        }

        .vh-login-wrapper {
            grid-template-columns: 1fr;
        }

        .vh-login-left {
            padding: 35px 35px;
        }

        .vh-left-heading {
            font-size: 42px;
        }

        .vh-login-right {
            padding: 35px;
        }
    }

    @media (max-width: 700px) {
        .vh-login-page {
            padding: 0;
        }

        .vh-login-wrapper {
            border-radius: 0;
            min-height: 100vh;
        }

        .vh-login-left {
            padding: 28px 22px;
        }

        .vh-left-heading {
            margin-top: 24px;
            font-size: 35px;
        }

        .vh-left-description {
            font-size: 14px;
            margin-top: 14px;
        }

        .vh-feature-list {
            margin-top: 25px;
            gap: 15px;
        }

        .vh-feature-icon {
            width: 40px;
            height: 40px;
            flex-basis: 40px;
        }

        .vh-login-right {
            padding: 28px 18px;
        }

        .vh-steps {
            margin-bottom: 30px;
        }

        .vh-step-circle {
            width: 38px;
            height: 38px;
        }

        .vh-step-item:not(:last-child)::after {
            top: 14px;
            left: calc(50% + 19px);
            right: calc(-50% + 19px);
        }

        .vh-profile-grid {
            grid-template-columns: 1fr;
        }

        .vh-full {
            grid-column: auto;
        }

        .vh-otp-wrapper {
            gap: 6px;
        }

        .vh-otp-input {
            height: 52px;
            font-size: 19px;
        }
    }
</style>


<div class="vh-login-page mt-20">

    <div class="vh-login-wrapper">

        {{-- ================= LEFT SIDE ================= --}}
        <div class="vh-login-left">

            <div class="vh-secure-badge">
                <span class="vh-secure-icon">🛡</span>
                Secure Login
            </div>

            <h1 class="vh-left-heading">
                Welcome back
                to <span>VEHILO.</span>
            </h1>

            <p class="vh-left-description">
                Login to your VEHILO account and continue your
                journey with India's next-generation electric
                mobility platform.
            </p>

            <div class="vh-feature-list">

                <div class="vh-feature">
                    <div class="vh-feature-icon">⌂</div>

                    <div class="vh-feature-content">
                        <h4>Your Account</h4>
                        <p>
                            Access your VEHILO profile and account details.
                        </p>
                    </div>
                </div>

                <div class="vh-feature">
                    <div class="vh-feature-icon">✓</div>

                    <div class="vh-feature-content">
                        <h4>Secure Access</h4>
                        <p>
                            Your account is protected with secure verification.
                        </p>
                    </div>
                </div>

                <div class="vh-feature">
                    <div class="vh-feature-icon">⚡</div>

                    <div class="vh-feature-content">
                        <h4>Quick Login</h4>
                        <p>
                            Verify your details and continue in a few simple steps.
                        </p>
                    </div>
                </div>

            </div>

        </div>


        {{-- ================= RIGHT SIDE ================= --}}
        <div class="vh-login-right">

            {{-- STEP PROGRESS --}}
            <div class="vh-steps">

                <div class="vh-step-item active" id="stepItem1">

                    <div class="vh-step-circle" id="stepCircle1">
                        1
                    </div>

                    <div class="vh-step-label">
                        Login
                    </div>

                </div>


                <div class="vh-step-item" id="stepItem2">

                    <div class="vh-step-circle" id="stepCircle2">
                        2
                    </div>

                    <div class="vh-step-label">
                        Verification
                    </div>

                </div>


                <div class="vh-step-item" id="stepItem3">

                    <div class="vh-step-circle" id="stepCircle3">
                        3
                    </div>

                    <div class="vh-step-label">
                        Account
                    </div>

                </div>

            </div>


            <div class="vh-form-container">

                {{-- ================= STEP 1 ================= --}}
                <div class="vh-panel active" id="loginStep">

                    <h2 class="vh-form-title">
                        Welcome back
                    </h2>

                    <p class="vh-form-subtitle">
                        Login to your account to continue.
                    </p>


                    <form class="vh-form" id="loginForm">

                        <div class="vh-form-group">

                            <label class="vh-form-label">
                                Mobile Number
                                <span class="vh-required">*</span>
                            </label>

                            <div class="vh-input-wrapper">

                                <div class="vh-country-code">
                                    +91
                                </div>

                                <input
                                    type="tel"
                                    id="mobileNumber"
                                    maxlength="10"
                                    placeholder="Enter mobile number"
                                    autocomplete="off"
                                    required
                                >

                            </div>

                        </div>


                        <button type="submit" class="vh-btn">
                            Continue
                        </button>

                    </form>

                </div>


                {{-- ================= STEP 2 ================= --}}
                <div class="vh-panel" id="otpStep">

                    <div
                        class="vh-change-mobile"
                        onclick="showStep(1)"
                    >
                        ← Change mobile number
                    </div>



                    <h2 class="vh-form-title">
                        Verify OTP
                    </h2>

                    <p class="vh-form-subtitle">
                        Enter the 6 digit verification code sent to
                        <strong id="displayMobile"></strong>
                    </p>


                    <form class="vh-form" id="otpForm">

                        <div class="vh-otp-wrapper">

                            @for($i = 0; $i < 6; $i++)
                                <input
                                    type="text"
                                    maxlength="1"
                                    class="vh-otp-input"
                                    inputmode="numeric"
                                >
                            @endfor

                        </div>


                        <button type="submit" class="vh-btn">
                            Verify & Continue
                        </button>

                    </form>


                    <button
                        type="button"
                        class="vh-resend"
                        onclick="resendOtp()"
                    >
                        Resend OTP
                    </button>

                </div>


                {{-- ================= STEP 3 ================= --}}
                <div class="vh-panel" id="profileStep">

                    <h2 class="vh-form-title">
                        Complete your profile
                    </h2>

                    <p class="vh-form-subtitle">
                        Enter your details to finish creating your account.
                    </p>


                    <form class="vh-form" id="profileForm">

                        <div class="vh-profile-grid">

                            {{-- Full Name --}}
                            <div class="vh-form-group">

                                <label class="vh-form-label">
                                    Full Name
                                    <span class="vh-required">*</span>
                                </label>

                                <input
                                    type="text"
                                    id="fullName"
                                    class="vh-input"
                                    placeholder="Enter full name"
                                    required
                                >

                            </div>


                            {{-- Email --}}
                            <div class="vh-form-group">

                                <label class="vh-form-label">
                                    Email Address
                                    <span class="vh-required">*</span>
                                </label>

                                <input
                                    type="email"
                                    class="vh-input"
                                    placeholder="Enter email address"
                                    required
                                >

                            </div>


                            {{-- Verified Mobile --}}
                            <div class="vh-form-group vh-full">

                                <label class="vh-form-label">
                                    Verified Mobile Number
                                </label>

                                <div class="vh-verified">
                                    ✓
                                    <span id="verifiedMobile"></span>
                                </div>

                            </div>


                            {{-- Password --}}
                            <div class="vh-form-group">

                                <label class="vh-form-label">
                                    Password
                                    <span class="vh-required">*</span>
                                </label>

                                <input
                                    type="password"
                                    class="vh-input"
                                    placeholder="Enter password"
                                    required
                                >

                            </div>


                            {{-- Confirm Password --}}
                            <div class="vh-form-group">

                                <label class="vh-form-label">
                                    Confirm Password
                                    <span class="vh-required">*</span>
                                </label>

                                <input
                                    type="password"
                                    class="vh-input"
                                    placeholder="Confirm password"
                                    required
                                >

                            </div>


                            <div class="vh-full">

                                <button
                                    type="submit"
                                    class="vh-btn"
                                >
                                    Create Account
                                </button>

                            </div>

                        </div>

                    </form>

                </div>


                {{-- ================= SUCCESS ================= --}}
                <div class="vh-success" id="successStep">

                    <div class="vh-success-icon">
                        ✓
                    </div>

                    <h2>
                        Account Created!
                    </h2>

                    <p>
                        Your VEHILO account has been created successfully.
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>


<script>

    let currentMobile = "";

    /* ================= STEP FUNCTION ================= */

    function showStep(step) {

        document.querySelectorAll('.vh-panel').forEach(function(panel) {
            panel.classList.remove('active');
        });

        if (step === 1) {
            document.getElementById('loginStep').classList.add('active');
        }

        if (step === 2) {
            document.getElementById('otpStep').classList.add('active');
        }

        if (step === 3) {
            document.getElementById('profileStep').classList.add('active');
        }

        updateSteps(step);
    }


    /* ================= PROGRESS ================= */

    function updateSteps(step) {

        const items = [
            document.getElementById('stepItem1'),
            document.getElementById('stepItem2'),
            document.getElementById('stepItem3')
        ];

        const circles = [
            document.getElementById('stepCircle1'),
            document.getElementById('stepCircle2'),
            document.getElementById('stepCircle3')
        ];

        items.forEach(function(item) {
            item.classList.remove('active', 'completed');
        });

        circles[0].innerHTML = '1';
        circles[1].innerHTML = '2';
        circles[2].innerHTML = '3';


        if (step === 1) {

            items[0].classList.add('active');

        }


        if (step === 2) {

            items[0].classList.add('completed');
            items[1].classList.add('active');

            circles[0].innerHTML = '✓';

        }


        if (step === 3) {

            items[0].classList.add('completed');
            items[1].classList.add('completed');
            items[2].classList.add('active');

            circles[0].innerHTML = '✓';
            circles[1].innerHTML = '✓';

        }

    }


    /* ================= LOGIN ================= */

    document
        .getElementById('loginForm')
        .addEventListener('submit', function(event) {

            event.preventDefault();

            const mobile =
                document
                    .getElementById('mobileNumber')
                    .value
                    .replace(/\D/g, '');

            if (mobile.length !== 10) {

                alert('Please enter a valid 10 digit mobile number.');

                return;
            }

            currentMobile = mobile;

            document.getElementById('displayMobile').innerText =
                '+91 ' + mobile;

            document.getElementById('verifiedMobile').innerText =
                '+91 ' + mobile;

            showStep(2);

            setTimeout(function() {

                document
                    .querySelector('.vh-otp-input')
                    .focus();

            }, 200);

        });


    /* ================= OTP INPUT ================= */

    const otpInputs =
        document.querySelectorAll('.vh-otp-input');


    otpInputs.forEach(function(input, index) {

        input.addEventListener('input', function() {

            this.value =
                this.value.replace(/\D/g, '');

            if (
                this.value &&
                index < otpInputs.length - 1
            ) {

                otpInputs[index + 1].focus();

            }

        });


        input.addEventListener('keydown', function(event) {

            if (
                event.key === 'Backspace' &&
                !this.value &&
                index > 0
            ) {

                otpInputs[index - 1].focus();

            }

        });

    });


    /* ================= OTP SUBMIT ================= */

    document
        .getElementById('otpForm')
        .addEventListener('submit', function(event) {

            event.preventDefault();

            let otp = "";

            otpInputs.forEach(function(input) {
                otp += input.value;
            });

            if (otp.length !== 6) {

                alert('Please enter the complete 6 digit OTP.');

                return;
            }

            showStep(3);

        });


    /* ================= RESEND OTP ================= */

    function resendOtp() {

        alert(
            'OTP has been resent to +91 ' + currentMobile
        );

    }


    /* ================= PROFILE ================= */

    document
        .getElementById('profileForm')
        .addEventListener('submit', function(event) {

            event.preventDefault();

            const passwords =
                document.querySelectorAll(
                    '#profileForm input[type="password"]'
                );

            if (passwords[0].value !== passwords[1].value) {

                alert(
                    'Password and Confirm Password do not match.'
                );

                return;
            }

            document
                .getElementById('profileStep')
                .classList.remove('active');

            document
                .getElementById('successStep')
                .style.display = 'block';

            document
                .getElementById('stepItem3')
                .classList.add('active');

            document
                .getElementById('stepCircle3')
                .innerHTML = '✓';

        });

</script>

@endsection