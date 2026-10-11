@extends('frontlayout.main')

@section('content')

<style>
    /* =========================================================
       VEHILO REGISTER PAGE
    ========================================================== */
    .register-page {
        min-height: 100vh;
        background: #f5f8f4;
        color: #071b14;
        padding: 28px 20px 60px;
        font-family: Arial, Helvetica, sans-serif;
    }
    .register-page [hidden] { display: none !important; }

    /* ---------- Header ---------- */
    .register-header { max-width: 760px; margin: 0 auto 30px; text-align: center; }
    .register-header h1 { margin: 0; font-size: 32px; line-height: 1.25; font-weight: 700; color: #071b14; letter-spacing: -0.8px; }
    .register-header p { max-width: 650px; margin: 12px auto 0; color: #49605a; font-size: 16px; line-height: 1.6; }

    /* ---------- Card ---------- */
    .register-wrapper { width: 100%; max-width: 672px; margin: 0 auto; }
    .register-card {
        background: #ffffff;
        border: 1px solid #dfe8df;
        border-radius: 18px;
        padding: 40px;
        box-shadow: 0 8px 30px rgba(5, 26, 19, 0.06);
    }

    /* ---------- Stepper ---------- */
    .stepper { display: flex; align-items: flex-start; width: 100%; margin-bottom: 40px; }
    .step-item { flex: 1; position: relative; text-align: center; }
    .step-item:not(:last-child)::after {
        content: ""; position: absolute; top: 18px;
        left: calc(50% + 20px); right: calc(-50% + 20px);
        height: 1px; background: #d9e2da; z-index: 1;
    }
    .step-item.completed:not(:last-child)::after { background: #188052; }
    .step-circle {
        position: relative; z-index: 2;
        width: 36px; height: 36px; margin: 0 auto;
        border-radius: 50%; border: 2px solid #d9e2da; background: #ffffff;
        display: flex; align-items: center; justify-content: center;
        color: #718079; font-size: 13px; font-weight: 500;
    }
    .step-item.active .step-circle { border-color: #188052; color: #188052; }
    .step-item.completed .step-circle { border-color: #188052; background: #188052; color: #ffffff; }
    .step-label { margin-top: 8px; font-size: 12px; color: #718079; }
    .step-item.active .step-label, .step-item.completed .step-label { color: #071b14; font-weight: 600; }

    /* ---------- Steps ---------- */
    .form-step { display: none; }
    .form-step.active { display: block; animation: fadeStep 0.3s ease; }
    @keyframes fadeStep { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
    .step-title { margin: 0 0 26px; font-size: 20px; font-weight: 600; color: #071b14; }

    /* ---------- Form ---------- */
    .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 0 20px; }
    .form-group { margin-bottom: 20px; }
    .form-group.full { grid-column: 1 / -1; }
    .form-label { display: block; margin-bottom: 8px; font-size: 14px; font-weight: 600; color: #071b14; }
    .optional { color: #78857f; font-weight: 400; font-size: 12px; }
    .required { color: #dc2626; }

    .form-input, .form-select {
        width: 100%; height: 47px;
        border: 1px solid #d8e2d9; border-radius: 11px;
        background: #ffffff; padding: 0 14px;
        font-size: 14px; color: #071b14; font-family: inherit;
        outline: none; transition: all 0.2s ease; box-sizing: border-box;
    }
    textarea.form-input { height: auto; min-height: 84px; padding: 12px 14px; resize: vertical; }
    .form-input::placeholder { color: #9aa6a0; }
    .form-input:focus, .form-select:focus { border-color: #188052; box-shadow: 0 0 0 3px rgba(200, 245, 66, 0.25); }
    .form-input.error, .form-select.error, .upload-box.error { border-color: #dc2626; }

    .field-error { margin-top: 6px; font-size: 12px; color: #dc2626; }
    .field-error:empty { display: none; }

    .form-alert { margin-bottom: 20px; padding: 12px 14px; border-radius: 11px; font-size: 13px; line-height: 1.5; }
    .form-alert.error { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
    .form-alert.info { background: #f1fbc9; color: #3f5212; border: 1px solid #dcef9c; }

    /* ---------- Buttons ---------- */
    .button-row { display: flex; align-items: center; gap: 12px; margin-top: 28px; }
    .btn {
        min-height: 46px; padding: 0 24px; border-radius: 24px;
        font-size: 14px; font-weight: 600; font-family: inherit;
        border: none; cursor: pointer; transition: all 0.25s ease;
    }
    .btn-primary { background: #c8f542; color: #071b14; box-shadow: 0 8px 20px rgba(200, 245, 66, 0.18); }
    .btn-primary:hover { background: #b8e936; transform: translateY(-1px); }
    .btn-secondary { background: #ffffff; border: 1px solid #dce5dc; color: #24352e; }
    .btn-secondary:hover { border-color: #188052; color: #188052; }
    .btn:disabled { opacity: .6; cursor: not-allowed; transform: none; }
    .btn:focus-visible { outline: 2px solid #188052; outline-offset: 2px; }

    /* ---------- OTP ---------- */
    .otp-input { font-size: 18px; letter-spacing: 5px; font-weight: 600; }
    .otp-info { margin-top: 8px; font-size: 13px; color: #64736c; }
    .otp-row { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 10px; margin-top: 10px; }
    .link-btn { background: none; border: 0; padding: 0; color: #188052; font-weight: 600; font-size: 13px; cursor: pointer; font-family: inherit; }
    .link-btn:disabled { color: #9aa6a0; cursor: not-allowed; }

    /* ---------- Upload ---------- */
    .upload-group { margin-bottom: 22px; }
    .upload-box {
        position: relative; width: 100%; height: 54px;
        border: 1px dashed #cfdcd1; border-radius: 12px; background: #f7faf7;
        display: flex; align-items: center; padding: 0 16px;
        cursor: pointer; transition: all 0.2s ease; box-sizing: border-box;
    }
    .upload-box:hover { border-color: #188052; background: #f3f9f4; }
    .upload-box:focus-within { border-color: #188052; box-shadow: 0 0 0 3px rgba(200, 245, 66, 0.25); }
    .upload-icon { width: 20px; height: 20px; margin-right: 12px; color: #188052; flex-shrink: 0; }
    .upload-text { color: #64736c; font-size: 14px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
    .upload-box input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
    .upload-hint { margin-top: 6px; font-size: 12px; color: #78857f; }

    .date-input { color: #5e6c65; }

    /* ---------- Security footer ---------- */
    .security-footer {
        border-top: 1px solid #dfe7df; margin-top: 30px; padding-top: 20px;
        display: flex; align-items: center; flex-wrap: wrap; gap: 20px;
    }
    .security-item { display: flex; align-items: center; gap: 7px; color: #64736c; font-size: 12px; }
    .security-icon { width: 15px; height: 15px; color: #188052; }

    /* ---------- Success ---------- */
    .success-box { text-align: center; padding: 25px 10px 15px; }
    .success-icon {
        width: 64px; height: 64px; margin: 0 auto 18px; border-radius: 50%;
        background: #188052; color: #ffffff;
        display: flex; align-items: center; justify-content: center;
    }
    .success-box h2 { margin: 0; font-size: 24px; color: #071b14; }
    .success-box p { margin: 10px auto 0; max-width: 460px; color: #64736c; font-size: 14px; line-height: 1.6; }
    .success-box .btn { margin-top: 22px; }

    .login-hint { margin-top: 18px; text-align: center; font-size: 13px; color: #64736c; }
    .login-hint a { color: #188052; font-weight: 600; }

    /* ---------- Mobile ---------- */
    @media (max-width: 700px) {
        .register-page { padding: 22px 14px 40px; }
        .register-header { margin-bottom: 22px; }
        .register-header h1 { font-size: 26px; }
        .register-header p { font-size: 14px; }
        .register-card { padding: 25px 20px; border-radius: 16px; }
        .stepper { margin-bottom: 30px; }
        .step-circle { width: 32px; height: 32px; font-size: 11px; }
        .step-item:not(:last-child)::after { top: 16px; left: calc(50% + 17px); right: calc(-50% + 17px); }
        .step-label { font-size: 10px; }
        .step-title { font-size: 18px; margin-bottom: 22px; }
        .form-grid { grid-template-columns: 1fr; }
        .button-row { flex-wrap: wrap; }
        .btn { padding: 0 20px; }
        .security-footer { gap: 12px; }
    }
    @media (max-width: 420px) {
        .register-card { padding: 22px 16px; }
        .step-label { font-size: 9px; }
        .button-row .btn { flex: 1; }
        .security-footer { flex-direction: column; align-items: flex-start; }
    }
</style>


<div class="register-page mt-20">

    {{-- HEADER --}}
    <div class="register-header">
        <h1>Start Your Journey With VEHILO</h1>
        <p>
            Complete your registration, verify your identity and unlock secure
            electric mobility powered by VEHILO's intelligent rider platform.
        </p>
    </div>

    <div class="register-wrapper">
        <div class="register-card">

            {{-- STEPPER --}}
            <div class="stepper" id="stepper">
                <div class="step-item active" data-step="1"><div class="step-circle">1</div><div class="step-label">Personal</div></div>
                <div class="step-item" data-step="2"><div class="step-circle">2</div><div class="step-label">Verify</div></div>
                <div class="step-item" data-step="3"><div class="step-circle">3</div><div class="step-label">KYC</div></div>
                <div class="step-item" data-step="4"><div class="step-circle">4</div><div class="step-label">Documents</div></div>
            </div>

            {{-- Top message --}}
            <div class="form-alert error" id="formAlert" role="alert" hidden></div>

            <form id="registrationForm" enctype="multipart/form-data" novalidate>

                {{-- =================================================
                     STEP 1 - PERSONAL
                ================================================== --}}
                <div class="form-step active" data-step="1">

                    <h2 class="step-title">Personal Information</h2>

                    <div class="form-grid">

                        <div class="form-group">
                            <label class="form-label" for="full_name">Full Name <span class="required">*</span></label>
                            <input type="text" name="full_name" id="full_name" class="form-input" placeholder="Enter your full name" autocomplete="name" required>
                            <p class="field-error" data-error="full_name"></p>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="email">Email Address <span class="required">*</span></label>
                            <input type="email" name="email" id="email" class="form-input" placeholder="Enter your email" autocomplete="email" required>
                            <p class="field-error" data-error="email"></p>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="mobile">Mobile Number <span class="required">*</span></label>
                            <input type="tel" name="mobile" id="mobile" class="form-input" placeholder="10 digit mobile number" maxlength="10" inputmode="numeric" autocomplete="tel-national" required>
                            <p class="field-error" data-error="mobile"></p>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="gender">Gender <span class="optional">(optional)</span></label>
                            <select name="gender" id="gender" class="form-select">
                                <option value="">Select gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                            <p class="field-error" data-error="gender"></p>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="city">City <span class="required">*</span></label>
                            <input type="text" name="city" id="city" class="form-input" placeholder="Enter your city" autocomplete="address-level2" required>
                            <p class="field-error" data-error="city"></p>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="pincode">Pincode <span class="optional">(optional)</span></label>
                            <input type="text" name="pincode" id="pincode" class="form-input" placeholder="6 digit pincode" maxlength="6" inputmode="numeric" autocomplete="postal-code">
                            <p class="field-error" data-error="pincode"></p>
                        </div>

                        <div class="form-group full">
                            <label class="form-label" for="address">Address <span class="optional">(optional)</span></label>
                            <textarea name="address" id="address" class="form-input" rows="3" maxlength="500" placeholder="House no, street, area" autocomplete="street-address"></textarea>
                            <p class="field-error" data-error="address"></p>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="password">Password <span class="required">*</span></label>
                            <input type="password" name="password" id="password" class="form-input" placeholder="Minimum 8 characters" minlength="8" autocomplete="new-password" required>
                            <p class="field-error" data-error="password"></p>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="password_confirmation">Confirm Password <span class="required">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" placeholder="Re-enter password" minlength="8" autocomplete="new-password" required>
                            <p class="field-error" data-error="password_confirmation"></p>
                        </div>

                    </div>

                    <div class="button-row">
                        <button type="button" class="btn btn-primary" id="step1Next">Continue to Verification</button>
                    </div>

                </div>


                {{-- =================================================
                     STEP 2 - VERIFY
                ================================================== --}}
                <div class="form-step" data-step="2">

                    <h2 class="step-title">Mobile Verification</h2>

                    <div class="form-alert info" id="debugOtp" hidden></div>

                    <div class="form-group">
                        <label class="form-label" for="otp">Enter OTP <span class="required">*</span></label>
                        <input type="text" name="otp" id="otp" class="form-input otp-input" placeholder="6 digit OTP" maxlength="6" inputmode="numeric" autocomplete="one-time-code">
                        <p class="field-error" data-error="otp"></p>

                        <div class="otp-row">
                            <span class="otp-info" id="otpInfo">We sent a verification code to your mobile number.</span>
                            <button type="button" class="link-btn" id="resendOtp" disabled>Resend OTP</button>
                        </div>
                    </div>

                    <div class="button-row">
                        <button type="button" class="btn btn-secondary" data-back>Back</button>
                        <button type="button" class="btn btn-primary" id="step2Next">Verify and Continue</button>
                    </div>

                </div>


                {{-- =================================================
                     STEP 3 - KYC
                ================================================== --}}
                <div class="form-step" data-step="3">

                    <h2 class="step-title">Identity Verification (KYC)</h2>

                    <div class="form-grid">

                        <div class="form-group">
                            <label class="form-label" for="aadhaar">Aadhaar Number <span class="required">*</span></label>
                            <input type="text" name="aadhaar" id="aadhaar" class="form-input" placeholder="12 digit Aadhaar number" maxlength="12" inputmode="numeric" autocomplete="off" required>
                            <p class="field-error" data-error="aadhaar"></p>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="date_of_birth">Date of Birth <span class="required">*</span></label>
                            <input type="date" name="date_of_birth" id="date_of_birth" class="form-input date-input" required>
                            <p class="field-error" data-error="date_of_birth"></p>
                        </div>

                        <div class="form-group full">
                            <label class="form-label" for="driving_license_number">Driving License Number <span class="optional">(optional)</span></label>
                            <input type="text" name="driving_license_number" id="driving_license_number" class="form-input" placeholder="e.g. HR26 20190012345" maxlength="30" autocomplete="off">
                            <p class="field-error" data-error="driving_license_number"></p>
                        </div>

                    </div>

                    <div class="button-row">
                        <button type="button" class="btn btn-secondary" data-back>Back</button>
                        <button type="button" class="btn btn-primary" id="step3Next">Continue to Documents</button>
                    </div>

                </div>


                {{-- =================================================
                     STEP 4 - DOCUMENTS
                ================================================== --}}
                <div class="form-step" data-step="4">

                    <h2 class="step-title">Upload Documents</h2>

                    @foreach([
                        ['name' => 'government_id',  'label' => 'Government ID Proof', 'required' => true,  'accept' => '.jpg,.jpeg,.png,.pdf', 'hint' => 'JPG, PNG or PDF, up to 5 MB'],
                        ['name' => 'address_proof',  'label' => 'Address Proof',       'required' => true,  'accept' => '.jpg,.jpeg,.png,.pdf', 'hint' => 'JPG, PNG or PDF, up to 5 MB'],
                        ['name' => 'passport_photo', 'label' => 'Passport Size Photo', 'required' => false, 'accept' => '.jpg,.jpeg,.png',      'hint' => 'JPG or PNG, up to 2 MB'],
                    ] as $doc)
                        <div class="upload-group">
                            <label class="form-label" for="{{ $doc['name'] }}">
                                {{ $doc['label'] }}
                                @if($doc['required'])
                                    <span class="required">*</span>
                                @else
                                    <span class="optional">(optional)</span>
                                @endif
                            </label>

                            <label class="upload-box" data-upload="{{ $doc['name'] }}">
                                <svg class="upload-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 16V4m0 0L7 9m5-5l5 5" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 20h14" />
                                </svg>
                                <span class="upload-text">Choose a file to upload</span>
                                <input type="file" name="{{ $doc['name'] }}" id="{{ $doc['name'] }}" accept="{{ $doc['accept'] }}" @if($doc['required']) required @endif>
                            </label>
                            <p class="upload-hint">{{ $doc['hint'] }}</p>
                            <p class="field-error" data-error="{{ $doc['name'] }}"></p>
                        </div>
                    @endforeach

                    <div class="button-row">
                        <button type="button" class="btn btn-secondary" data-back>Back</button>
                        <button type="submit" class="btn btn-primary" id="submitBtn">Submit Registration</button>
                    </div>

                </div>

            </form>


            {{-- SUCCESS (register hone ke baad) --}}
            <div class="success-box" id="successBox" hidden>
                <div class="success-icon">
                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12l4 4L19 6" />
                    </svg>
                </div>
                <h2>Registration submitted</h2>
                <p>
                    Your account is created and your documents are with our team for verification.
                    Log in to track your verification status.
                </p>
                <a href="{{ url('/login') }}" class="btn btn-primary" style="display:inline-flex;align-items:center;text-decoration:none">Go to login</a>
            </div>

            <p class="login-hint" id="loginHint">
                Already registered? <a href="{{ url('/login') }}">Log in</a>
            </p>


            {{-- SECURITY FOOTER --}}
            <div class="security-footer">
                @foreach(['Aadhaar Protected', 'Secure Registration', 'Verified Platform'] as $item)
                    <div class="security-item">
                        <svg class="security-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3l8 4v5c0 4.7-3.4 7.8-8 9-4.6-1.2-8-4.3-8-9V7l8-4z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4" />
                        </svg>
                        {{ $item }}
                    </div>
                @endforeach
            </div>

        </div>
    </div>

</div>


<script>
(function () {

    /* ---------------- API URLs ---------------- */
    const API = {
        sendOtp:   @json(url('/api/v1/rider/send-otp')),
        verifyOtp: @json(url('/api/v1/rider/verify-otp')),
        register:  @json(url('/api/v1/rider/register'))
    };

    const TOTAL_STEPS = 4;
    const RESEND_SECONDS = 30;

    // Kaunsa field kis step me hai (server error aaye to wahi step kholne ke liye)
    const FIELD_STEP = {
        full_name: 1, email: 1, mobile: 1, gender: 1, city: 1, pincode: 1, address: 1,
        password: 1, password_confirmation: 1,
        otp: 2,
        aadhaar: 3, date_of_birth: 3, driving_license_number: 3,
        government_id: 4, address_proof: 4, passport_photo: 4
    };

    const MAX_FILE_MB = { government_id: 5, address_proof: 5, passport_photo: 2 };

    const form      = document.getElementById('registrationForm');
    const formAlert = document.getElementById('formAlert');
    const $         = id => document.getElementById(id);

    let currentStep    = 1;
    let otpSentTo      = null;   // kis number par OTP gaya
    let verifiedMobile = null;   // kaunsa number verify hua
    let resendTimer    = null;

    /* 18 saal se kam ki DOB select na ho */
    const maxDob = new Date();
    maxDob.setFullYear(maxDob.getFullYear() - 18);
    $('date_of_birth').max = maxDob.toISOString().slice(0, 10);


    /* =========================================================
       HELPERS
    ========================================================== */
    function mobileValue() {
        return $('mobile').value.trim();
    }

    function showAlert(message) {
        formAlert.textContent = message;
        formAlert.hidden = false;
    }

    function hideAlert() {
        formAlert.hidden = true;
    }

    function fieldTarget(name) {
        return form.querySelector(`[data-upload="${name}"]`) || form.querySelector(`[name="${name}"]`);
    }

    function setError(name, message) {
        const box = form.querySelector(`[data-error="${name}"]`);
        if (box) box.textContent = message;
        const el = fieldTarget(name);
        if (el) el.classList.add('error');
    }

    function clearError(name) {
        const box = form.querySelector(`[data-error="${name}"]`);
        if (box) box.textContent = '';
        const el = fieldTarget(name);
        if (el) el.classList.remove('error');
    }

    function clearStepErrors(step) {
        Object.keys(FIELD_STEP).forEach(name => { if (FIELD_STEP[name] === step) clearError(name); });
    }

    function focusFirstError() {
        const step = form.querySelector(`.form-step[data-step="${currentStep}"]`);
        const first = step && step.querySelector('.error');
        if (!first) return;
        const input = first.matches('input, select, textarea') ? first : first.querySelector('input');
        if (input) input.focus();
    }

    function setLoading(button, loading, text) {
        if (!button.dataset.label) button.dataset.label = button.textContent;
        button.disabled = loading;
        button.textContent = loading ? text : button.dataset.label;
    }

    async function post(url, body) {
        const isForm = body instanceof FormData;
        const res = await fetch(url, {
            method: 'POST',
            headers: isForm
                ? { 'Accept': 'application/json' }
                : { 'Accept': 'application/json', 'Content-Type': 'application/json' },
            body: isForm ? body : JSON.stringify(body)
        });
        // JSON na aaye (HTML error page) to bhi crash na ho
        const text = await res.text();
        let data = {};
        try { data = text ? JSON.parse(text) : {}; } catch (e) { data = {}; }
        return { ok: res.ok, status: res.status, data };
    }

    // Server error ka saaf message (status code ke saath)
    function errorMessage(res) {
        const hints = {
            404: 'Registration API not found. Check that rider/register is in routes/api.php.',
            413: 'Files are too large for the server. Increase upload_max_filesize and post_max_size in php.ini.',
            419: 'Session expired. Refresh the page and try again.',
            429: 'Too many attempts. Wait a minute and try again.'
        };
        if (res.data && res.data.message && res.data.message !== 'Server Error') {
            return `${res.data.message} (error ${res.status})`;
        }
        return hints[res.status]
            || `Registration failed (error ${res.status}). Check storage/logs/laravel.log for details.`;
    }

    function applyServerErrors(errors) {
        let earliest = TOTAL_STEPS + 1;
        Object.entries(errors).forEach(([field, messages]) => {
            setError(field, Array.isArray(messages) ? messages[0] : messages);
            if (FIELD_STEP[field] && FIELD_STEP[field] < earliest) earliest = FIELD_STEP[field];
        });
        return earliest <= TOTAL_STEPS ? earliest : currentStep;
    }

    // Field badalte hi uska error hata do + sirf numbers wale fields
    form.addEventListener('input', e => {
        const el = e.target;
        if (['mobile', 'pincode', 'otp', 'aadhaar'].includes(el.id)) {
            el.value = el.value.replace(/[^0-9]/g, '');
        }
        if (el.name) clearError(el.name);
        hideAlert();
    });


    /* =========================================================
       STEPS
    ========================================================== */
    function showStep(step) {
        currentStep = step;
        hideAlert();

        document.querySelectorAll('.form-step').forEach(el => {
            el.classList.toggle('active', Number(el.dataset.step) === step);
        });

        document.querySelectorAll('.step-item').forEach(el => {
            const itemStep = Number(el.dataset.step);
            const circle = el.querySelector('.step-circle');

            el.classList.toggle('active', itemStep === step);
            el.classList.toggle('completed', itemStep < step);

            circle.innerHTML = itemStep < step
                ? '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12l4 4L19 6"/></svg>'
                : String(itemStep);
        });

        document.querySelector('.register-card').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    form.querySelectorAll('[data-back]').forEach(btn => {
        btn.addEventListener('click', () => { if (currentStep > 1) showStep(currentStep - 1); });
    });


    /* =========================================================
       CLIENT VALIDATION (har step)
    ========================================================== */
    function validateStep(step) {
        clearStepErrors(step);
        let ok = true;
        const fail = (name, msg) => { setError(name, msg); ok = false; };
        const val  = id => ($(id).value || '').trim();

        if (step === 1) {
            if (!val('full_name')) fail('full_name', 'Enter your full name.');
            if (!val('email')) fail('email', 'Enter your email address.');
            else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val('email'))) fail('email', 'Enter a valid email address.');
            if (!/^[0-9]{10}$/.test(val('mobile'))) fail('mobile', 'Enter a valid 10 digit mobile number.');
            if (!val('city')) fail('city', 'Enter your city.');
            if (val('pincode') && !/^[0-9]{6}$/.test(val('pincode'))) fail('pincode', 'Pincode must be 6 digits.');
            if ($('password').value.length < 8) fail('password', 'Password must be at least 8 characters.');
            if ($('password_confirmation').value !== $('password').value) fail('password_confirmation', 'Passwords do not match.');
        }

        if (step === 2) {
            if (!/^[0-9]{6}$/.test(val('otp'))) fail('otp', 'Enter the 6 digit OTP.');
        }

        if (step === 3) {
            if (!/^[0-9]{12}$/.test(val('aadhaar'))) fail('aadhaar', 'Aadhaar number must be 12 digits.');
            if (!val('date_of_birth')) fail('date_of_birth', 'Select your date of birth.');
            else if (val('date_of_birth') > $('date_of_birth').max) fail('date_of_birth', 'You must be at least 18 years old.');
        }

        if (step === 4) {
            ['government_id', 'address_proof', 'passport_photo'].forEach(name => {
                const file = $(name).files[0];
                if (!file && $(name).required) fail(name, 'Upload this document.');
                if (file && file.size > MAX_FILE_MB[name] * 1024 * 1024) fail(name, `File must be ${MAX_FILE_MB[name]} MB or smaller.`);
            });
        }

        if (!ok) focusFirstError();
        return ok;
    }


    /* =========================================================
       OTP
    ========================================================== */
    function startResendTimer() {
        const btn = $('resendOtp');
        let left = RESEND_SECONDS;
        clearInterval(resendTimer);
        btn.disabled = true;
        btn.textContent = `Resend OTP in ${left}s`;
        resendTimer = setInterval(() => {
            left--;
            if (left <= 0) {
                clearInterval(resendTimer);
                btn.disabled = false;
                btn.textContent = 'Resend OTP';
            } else {
                btn.textContent = `Resend OTP in ${left}s`;
            }
        }, 1000);
    }

    async function sendOtp() {
        const mobile = mobileValue();
        const res = await post(API.sendOtp, { mobile });

        if (!res.ok) {
            if (res.data.errors) applyServerErrors(res.data.errors);
            else showAlert(errorMessage(res));
            return false;
        }

        otpSentTo = mobile;
        $('otp').value = '';
        $('otpInfo').textContent = `We sent a 6 digit code to +91 ******${mobile.slice(-4)}.`;

        // Sirf local environment me API OTP wapas bhejti hai
        $('debugOtp').hidden = !res.data.debug_otp;
        $('debugOtp').textContent = res.data.debug_otp ? `Test mode: your OTP is ${res.data.debug_otp}` : '';

        startResendTimer();
        return true;
    }

    /* Step 1 -> OTP bhejo -> Step 2 */
    $('step1Next').addEventListener('click', async function () {
        if (!validateStep(1)) return;

        const mobile = mobileValue();

        // Isi number ka OTP pehle se verify hai
        if (verifiedMobile === mobile) { showStep(3); return; }

        // Isi number par OTP ja chuka hai
        if (otpSentTo === mobile) { showStep(2); return; }

        setLoading(this, true, 'Sending OTP...');
        try {
            if (await sendOtp()) showStep(2);
            else focusFirstError();
        } catch (e) {
            showAlert('Unable to connect to server. Please try again.');
        } finally {
            setLoading(this, false);
        }
    });

    $('resendOtp').addEventListener('click', async function () {
        this.disabled = true;
        clearError('otp');
        try {
            if (await sendOtp()) setTimeout(() => $('otp').focus(), 50);
            else this.disabled = false;
        } catch (e) {
            showAlert('Unable to connect to server. Please try again.');
            this.disabled = false;
        }
    });

    /* Step 2 -> verify -> Step 3 */
    $('step2Next').addEventListener('click', async function () {
        if (verifiedMobile === mobileValue()) { showStep(3); return; }
        if (!validateStep(2)) return;

        setLoading(this, true, 'Verifying...');
        try {
            const res = await post(API.verifyOtp, { mobile: mobileValue(), otp: $('otp').value.trim() });

            if (!res.ok) {
                if (res.data.errors) applyServerErrors(res.data.errors);
                else showAlert(errorMessage(res));
                focusFirstError();
                return;
            }

            verifiedMobile = mobileValue();
            clearInterval(resendTimer);
            $('otpInfo').textContent = 'Mobile number verified.';
            $('resendOtp').hidden = true;
            $('debugOtp').hidden = true;
            showStep(3);

        } catch (e) {
            showAlert('Unable to connect to server. Please try again.');
        } finally {
            setLoading(this, false);
        }
    });

    /* Mobile number badla to dobara verify karna padega */
    $('mobile').addEventListener('change', () => {
        if (mobileValue() !== verifiedMobile) {
            $('resendOtp').hidden = false;
            $('otp').value = '';
        }
    });

    /* Step 3 -> Step 4 */
    $('step3Next').addEventListener('click', () => {
        if (validateStep(3)) showStep(4);
    });


    /* =========================================================
       FILE NAME
    ========================================================== */
    form.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', () => {
            const text = input.closest('.upload-box').querySelector('.upload-text');
            text.textContent = input.files.length ? input.files[0].name : 'Choose a file to upload';
            clearError(input.name);
        });
    });


    /* =========================================================
       SUBMIT (multipart API)
    ========================================================== */
    form.addEventListener('submit', async e => {
        e.preventDefault();
        hideAlert();

        if (verifiedMobile !== mobileValue()) {
            showStep(1);
            showAlert('Verify your mobile number before submitting.');
            return;
        }

        if (!validateStep(4)) return;

        const btn = $('submitBtn');
        setLoading(btn, true, 'Submitting...');

        const data = new FormData(form);
        data.delete('otp');

        let done = false;

        try {
            const res = await post(API.register, data);

            if (!res.ok) {
                if (res.status === 422 && res.data.errors) {
                    const step = applyServerErrors(res.data.errors);

                    // OTP expire ho gaya ho to dobara verify
                    if (res.data.errors.otp) {
                        verifiedMobile = null;
                        otpSentTo = null;
                        $('resendOtp').hidden = false;
                        showStep(1);
                        showAlert('Your mobile verification expired. Continue to get a new OTP.');
                        return;
                    }

                    showStep(step);
                    showAlert('Some details need fixing. Check the highlighted fields.');
                    focusFirstError();
                } else {
                    showAlert(errorMessage(res));
                }
                return;
            }

            done = true;
            form.hidden = true;
            $('stepper').hidden = true;
            $('loginHint').hidden = true;
            $('successBox').hidden = false;
            document.querySelector('.register-card').scrollIntoView({ behavior: 'smooth', block: 'start' });

        } catch (err) {
            showAlert('Unable to connect to server. Please try again.');
        } finally {
            if (!done) setLoading(btn, false);
        }
    });

})();
</script>

@endsection