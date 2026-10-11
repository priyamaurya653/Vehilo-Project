@extends('front.main')

@php
    $isEdit = !empty($vehicleId);

    $states = ['Andhra Pradesh', 'Assam', 'Bihar', 'Chandigarh', 'Chhattisgarh', 'Delhi', 'Goa', 'Gujarat',
        'Haryana', 'Himachal Pradesh', 'Jammu and Kashmir', 'Jharkhand', 'Karnataka', 'Kerala', 'Madhya Pradesh',
        'Maharashtra', 'Odisha', 'Punjab', 'Rajasthan', 'Tamil Nadu', 'Telangana', 'Uttar Pradesh',
        'Uttarakhand', 'West Bengal'];

    // Har section ke fields (name => input). Naya field add karna ho to yahin karo.
    $sections = [
        [
            'no' => '01', 'title' => 'Basic Vehicle Details',
            'fields' => [
                ['name' => 'vehicle_type_id', 'label' => 'Vehicle Type', 'type' => 'select', 'required' => true, 'placeholder' => 'Loading vehicle types...'],
                ['name' => 'vehicle_name', 'label' => 'Vehicle Name', 'required' => true, 'placeholder' => 'e.g. Swift Hatchback', 'attrs' => 'maxlength="100"'],
                ['name' => 'vehicle_number', 'label' => 'Vehicle Number', 'required' => true, 'placeholder' => 'e.g. RJ14AB1234', 'attrs' => 'maxlength="15" autocomplete="off"'],
                ['name' => 'brand', 'label' => 'Brand', 'required' => true, 'placeholder' => 'e.g. Maruti Suzuki', 'attrs' => 'maxlength="60"'],
                ['name' => 'model', 'label' => 'Model', 'required' => true, 'placeholder' => 'e.g. Swift', 'attrs' => 'maxlength="60"'],
                ['name' => 'manufacturing_year', 'label' => 'Manufacturing Year', 'type' => 'number', 'placeholder' => 'e.g. 2024', 'attrs' => 'min="1990" max="' . (date('Y') + 1) . '"'],
                ['name' => 'color', 'label' => 'Vehicle Color', 'placeholder' => 'e.g. White', 'attrs' => 'maxlength="30"'],
            ],
        ],
        'images',
        [
            'no' => '03', 'title' => 'Vehicle Specifications',
            'fields' => [
                ['name' => 'transmission', 'label' => 'Transmission', 'type' => 'select', 'required' => true, 'placeholder' => 'Select transmission',
                    'options' => ['manual' => 'Manual', 'automatic' => 'Automatic', 'geared' => 'Geared']],
                ['name' => 'fuel_type', 'label' => 'Fuel Type', 'type' => 'select', 'required' => true, 'placeholder' => 'Select fuel type',
                    'options' => ['petrol' => 'Petrol', 'diesel' => 'Diesel', 'cng' => 'CNG', 'electric' => 'Electric', 'hybrid' => 'Hybrid']],
                ['name' => 'seating_capacity', 'label' => 'Seating Capacity', 'type' => 'number', 'required' => true, 'placeholder' => 'e.g. 5', 'attrs' => 'min="1" max="60"'],
                ['name' => 'engine_cc', 'label' => 'Engine CC', 'type' => 'number', 'placeholder' => 'e.g. 1197', 'attrs' => 'min="0"'],
                ['name' => 'mileage', 'label' => 'Mileage (km/l)', 'type' => 'number', 'placeholder' => 'e.g. 22', 'attrs' => 'min="0" step="0.1"'],
                ['name' => 'range_per_charge', 'label' => 'Range Per Charge (km)', 'type' => 'number', 'placeholder' => 'e.g. 150', 'attrs' => 'min="0"'],
            ],
        ],
        [
            'no' => '04', 'title' => 'Rental Pricing',
            'fields' => [
                ['name' => 'price_per_hour', 'label' => 'Price Per Hour (₹)', 'type' => 'number', 'placeholder' => '199', 'attrs' => 'min="0" step="0.01"'],
                ['name' => 'price_per_day', 'label' => 'Price Per Day (₹)', 'type' => 'number', 'required' => true, 'placeholder' => '1199', 'attrs' => 'min="0" step="0.01"'],
                ['name' => 'price_per_week', 'label' => 'Price Per Week (₹)', 'type' => 'number', 'placeholder' => '6999', 'attrs' => 'min="0" step="0.01"'],
                ['name' => 'security_deposit', 'label' => 'Security Deposit (₹)', 'type' => 'number', 'required' => true, 'placeholder' => '2000', 'attrs' => 'min="0" step="0.01"'],
                ['name' => 'included_km', 'label' => 'Included KM Per Day', 'type' => 'number', 'required' => true, 'placeholder' => '150', 'attrs' => 'min="0"'],
                ['name' => 'extra_km_charge', 'label' => 'Extra KM Charge (₹/km)', 'type' => 'number', 'required' => true, 'placeholder' => '12', 'attrs' => 'min="0" step="0.01"'],
            ],
        ],
        [
            'no' => '05', 'title' => 'Location Details',
            'fields' => [
                ['name' => 'country', 'label' => 'Country', 'type' => 'select', 'required' => true, 'placeholder' => null, 'options' => ['India' => 'India']],
                ['name' => 'state', 'label' => 'State', 'type' => 'select', 'required' => true, 'placeholder' => 'Select state', 'options' => array_combine($states, $states)],
                ['name' => 'city', 'label' => 'City', 'required' => true, 'placeholder' => 'e.g. Jaipur', 'attrs' => 'maxlength="60"'],
                ['name' => 'location_area', 'label' => 'Location / Area', 'required' => true, 'placeholder' => 'e.g. Vaishali Nagar', 'attrs' => 'maxlength="100"'],
                ['name' => 'pickup_location', 'label' => 'Pickup Location', 'required' => true, 'placeholder' => 'e.g. VEHILO Jaipur Hub', 'attrs' => 'maxlength="150"'],
                ['name' => 'pincode', 'label' => 'Pincode', 'required' => true, 'placeholder' => '302021', 'attrs' => 'maxlength="6" inputmode="numeric"'],
                ['name' => 'pickup_address', 'label' => 'Pickup Address', 'type' => 'textarea', 'required' => true, 'full' => true, 'placeholder' => 'Enter complete pickup address', 'attrs' => 'maxlength="500"'],
            ],
        ],
        [
            'no' => '06', 'title' => 'Availability',
            'fields' => [
                ['name' => 'status', 'label' => 'Availability Status', 'type' => 'select', 'required' => true, 'placeholder' => null,
                    'options' => ['available' => 'Available', 'inactive' => 'Inactive', 'maintenance' => 'Maintenance']],
                ['name' => 'available_from', 'label' => 'Available From', 'type' => 'date'],
                ['name' => 'available_to', 'label' => 'Available To', 'type' => 'date'],
                ['name' => 'minimum_rental_days', 'label' => 'Minimum Rental Days', 'type' => 'number', 'value' => '1', 'attrs' => 'min="1" max="365"'],
                ['name' => 'maximum_rental_days', 'label' => 'Maximum Rental Days', 'type' => 'number', 'placeholder' => 'e.g. 30', 'attrs' => 'min="1" max="365"'],
            ],
        ],
        'features',
        'description',
    ];
@endphp

@section('role', 'admin')
@section('title', $isEdit ? 'Edit vehicle' : 'Add vehicle')
@section('page_title', $isEdit ? 'Edit vehicle' : 'Add vehicle')

@section('content')

<style>
    /* =========================================================
       VEHILO ADMIN VEHICLE PAGE
    ========================================================= */
    .vehicle-page { color: #051a13; }
    .vehicle-page [hidden] { display: none !important; }
    .vehicle-container { max-width: 1400px; margin: 0 auto; }

    .white-card { background: #fff; border: 1px solid #e4eee9; border-radius: 14px; box-shadow: 0 6px 20px rgba(5, 26, 19, 0.04); }
    .vehicle-form-card { padding: 16px; }

    .form-header { display: flex; flex-wrap: wrap; align-items: flex-end; justify-content: space-between; gap: 10px; margin-bottom: 16px; }
    .form-header h2 { margin: 0; color: #051a13; font-size: 22px; font-weight: 800; }
    .form-header p { margin: 4px 0 0; color: #7a8983; font-size: 13px; }
    .back-link { color: #188052; font-size: 13px; font-weight: 700; text-decoration: none; }
    .back-link:hover { text-decoration: underline; }

    /* Message */
    .form-message { margin-bottom: 14px; padding: 10px 12px; border-radius: 9px; font-size: 13px; font-weight: 600; }
    .form-message.success { border: 1px solid #bde2cf; background: #ecfaf2; color: #12643f; }
    .form-message.error { border: 1px solid #f1c1c1; background: #fff1f1; color: #b42323; }
    .loading-box { padding: 30px 12px; text-align: center; color: #71817b; font-size: 14px; }

    /* Section */
    .form-section { margin-bottom: 16px; padding: 14px; border: 1px solid #e4eee9; border-radius: 12px; background: #fbfdfc; }
    .section-heading { display: flex; align-items: center; gap: 8px; margin-bottom: 13px; }
    .section-number {
        display: flex; align-items: center; justify-content: center;
        width: 27px; height: 27px; border-radius: 7px;
        background: #051a13; color: #c8f542; font-size: 11px; font-weight: 800; flex-shrink: 0;
    }
    .section-heading h3 { margin: 0; color: #051a13; font-size: 15px; font-weight: 800; }
    .section-heading .hint { margin-left: auto; color: #71817b; font-size: 12px; }

    /* Grid */
    .form-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
    .form-group { min-width: 0; }
    .form-group.full { grid-column: 1 / -1; }
    .form-label { display: block; margin-bottom: 5px; color: #18372d; font-size: 12px; font-weight: 700; }
    .required { color: #e33434; }

    /* Inputs */
    .form-control, .form-select, .form-textarea {
        width: 100%; box-sizing: border-box;
        border: 1px solid #dbe7e1; border-radius: 8px; background: #fff;
        color: #051a13; font-size: 13px; font-family: inherit; outline: none; transition: all 0.2s ease;
    }
    .form-control, .form-select { height: 40px; padding: 0 10px; }
    .form-textarea { min-height: 82px; padding: 9px 10px; resize: vertical; line-height: 1.5; }
    .form-control::placeholder, .form-textarea::placeholder { color: #a1ada8; }
    .form-control:focus, .form-select:focus, .form-textarea:focus { border-color: #188052; box-shadow: 0 0 0 2px rgba(24, 128, 82, 0.08); }
    .form-control.invalid, .form-select.invalid, .form-textarea.invalid, .image-upload.invalid { border-color: #e33434; }

    .field-error { margin-top: 4px; color: #b42323; font-size: 12px; }
    .field-error:empty { display: none; }

    /* Features */
    .feature-toolbar { display: flex; justify-content: flex-end; gap: 12px; margin-bottom: 10px; }
    .link-btn { border: 0; background: none; padding: 0; color: #188052; font-size: 12px; font-weight: 700; cursor: pointer; font-family: inherit; }
    .link-btn.danger { color: #b42323; }
    .feature-list { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; }
    .feature-item { position: relative; }
    .feature-item input { position: absolute; opacity: 0; pointer-events: none; }
    .feature-label {
        display: flex; align-items: center; gap: 9px; min-height: 42px; padding: 9px 11px;
        border: 1px solid #dbe7e1; border-radius: 8px; background: #fff;
        color: #18372d; font-size: 12px; font-weight: 700; cursor: pointer; transition: 0.2s ease;
    }
    .feature-label:hover { border-color: #188052; background: #f0f8f4; }
    .feature-item input:checked + .feature-label { border-color: #188052; background: #ecf8f1; }
    .feature-item input:focus-visible + .feature-label { outline: 2px solid #188052; outline-offset: 2px; }
    .feature-check {
        width: 17px; height: 17px; border: 1px solid #cbdad3; border-radius: 4px; background: #fff;
        flex-shrink: 0; display: flex; align-items: center; justify-content: center;
    }
    .feature-item input:checked + .feature-label .feature-check { border-color: #188052; background: #188052; }
    .feature-item input:checked + .feature-label .feature-check::after { content: "✓"; color: #fff; font-size: 11px; font-weight: 800; }
    .feature-empty, .feature-error-box {
        grid-column: 1 / -1; padding: 12px; border: 1px dashed #cbdad3; border-radius: 8px;
        color: #71817b; background: #fff; font-size: 12px;
    }
    .feature-error-box { border-color: #f1c1c1; color: #b42323; background: #fff5f5; }
    .type-picks { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 10px; }
    .type-pick {
        display: inline-flex; align-items: center; gap: 8px;
        height: 36px; padding: 0 12px; border: 1px solid #dbe7e1; border-radius: 8px;
        background: #fff; color: #051a13; font: inherit; font-size: 13px; font-weight: 700; cursor: pointer;
    }
    .type-pick small { color: #71817b; font-weight: 600; font-size: 11px; }
    .type-pick:hover { border-color: #188052; background: #f0f8f4; }
    .type-pick:focus-visible { outline: 2px solid #188052; outline-offset: 2px; }

    /* Images */
    .image-upload-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; }
    .image-upload-box { position: relative; min-width: 0; }
    .image-upload-label { display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px; color: #18372d; font-size: 12px; font-weight: 700; }
    .image-upload {
        width: 100%; height: 64px; box-sizing: border-box; padding: 6px;
        border: 1px dashed #b9cec3; border-radius: 9px; background: #f5faf7;
        color: #61716a; font-size: 11px; cursor: pointer;
    }
    .image-upload:hover { border-color: #188052; background: #f0f8f4; }
    .image-upload::file-selector-button {
        display: block; margin-bottom: 5px; padding: 5px 9px; border: none; border-radius: 6px;
        background: #051a13; color: #fff; font-size: 11px; font-weight: 600; cursor: pointer;
    }
    .image-preview { display: block; width: 100%; height: 105px; object-fit: cover; margin-top: 6px; border-radius: 8px; border: 1px solid #dbe7e1; }
    .image-hint { margin-top: 8px; color: #71817b; font-size: 12px; }

    /* Buttons */
    .form-actions { display: flex; justify-content: flex-end; align-items: center; gap: 8px; margin-top: 14px; }
    .btn-reset, .btn-submit {
        min-width: 105px; height: 40px; padding: 0 15px; border-radius: 8px;
        font-size: 13px; font-weight: 700; font-family: inherit; cursor: pointer; transition: 0.2s ease;
        display: inline-flex; align-items: center; justify-content: center; text-decoration: none;
    }
    .btn-reset { border: 1px solid #d9e5df; background: #fff; color: #52635c; }
    .btn-submit { border: none; background: #051a13; color: #fff; }
    .btn-submit:hover { background: #0f4a35; transform: translateY(-1px); }
    .btn-submit:disabled { opacity: .6; cursor: not-allowed; transform: none; }

    /* Responsive */
    @media (max-width: 1100px) {
        .form-grid { grid-template-columns: repeat(2, 1fr); }
        .image-upload-grid { grid-template-columns: repeat(2, 1fr); }
        .feature-list { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 768px) {
        .vehicle-form-card { padding: 12px; }
        .form-section { padding: 11px; }
        .form-grid { grid-template-columns: 1fr; }
        .form-group.full { grid-column: auto; }
        .feature-list { grid-template-columns: repeat(2, 1fr); }
        .section-heading .hint { display: none; }
    }
    @media (max-width: 520px) {
        .vehicle-form-card { padding: 9px; }
        .form-section { padding: 9px; }
        .image-upload-grid, .feature-list { grid-template-columns: 1fr; }
        .form-actions { flex-direction: column-reverse; }
        .btn-reset, .btn-submit { width: 100%; }
    }
</style>


<div class="vehicle-page">
    <div class="vehicle-container">
        <div class="white-card vehicle-form-card">

            {{-- HEADER --}}
            <div class="form-header">
                <div>
                    <h2>{{ $isEdit ? 'Edit Vehicle' : 'Add Vehicle' }}</h2>
                    <p>{{ $isEdit ? 'Update your vehicle details.' : 'Register your vehicle with rental and location details.' }}</p>
                </div>
                <a href="{{ url('/admin/vehicle/vehicles') }}" class="back-link">View all vehicles</a>
            </div>

            <div id="formMessage" class="form-message" role="alert" hidden></div>

            <div class="loading-box" id="loadingBox" @if(!$isEdit) hidden @endif>Loading vehicle...</div>

            <form id="vehicleForm" novalidate @if($isEdit) hidden @endif>

                @foreach($sections as $section)

                    {{-- ============ 02 IMAGES ============ --}}
                    @if($section === 'images')
                        <div class="form-section">
                            <div class="section-heading">
                                <div class="section-number">02</div>
                                <h3>Vehicle Images</h3>
                            </div>

                            <div class="image-upload-grid">
                                @foreach([1, 2, 3, 4] as $slot)
                                    <div class="image-upload-box" data-slot="{{ $slot }}">
                                        <label class="image-upload-label" for="vehicle_image_{{ $slot }}">
                                            <span>
                                                Vehicle Image {{ $slot }}
                                                @if($slot === 1)<span class="required">*</span>@endif
                                            </span>
                                            @if($slot > 1)
                                                <button type="button" class="link-btn danger" data-remove-image="{{ $slot }}" hidden>Remove</button>
                                            @endif
                                        </label>
                                        <input type="file" name="vehicle_image_{{ $slot }}" id="vehicle_image_{{ $slot }}"
                                            class="image-upload" accept=".jpg,.jpeg,.png,.webp" data-slot="{{ $slot }}">
                                        <img class="image-preview" id="preview{{ $slot }}" alt="Vehicle image {{ $slot }} preview" hidden>
                                        <p class="field-error" data-error="vehicle_image_{{ $slot }}"></p>
                                    </div>
                                @endforeach
                            </div>
                            <p class="image-hint">JPG, PNG or WEBP, up to 3 MB each. Image 1 is the cover photo riders see first.</p>
                        </div>

                    {{-- ============ 07 FEATURES (API se) ============ --}}
                    @elseif($section === 'features')
                        <div class="form-section">
                            <div class="section-heading">
                                <div class="section-number">07</div>
                                <h3>Vehicle Features</h3>
                                <span class="hint" id="featureHint">Features come from the selected vehicle type.</span>
                            </div>

                            <div class="feature-toolbar" id="featureToolbar" hidden>
                                <button type="button" class="link-btn" id="selectAllFeatures">Select all</button>
                                <button type="button" class="link-btn" id="clearFeatures">Clear</button>
                            </div>

                            <div id="featureList" class="feature-list">
                                <div class="feature-empty">Select a vehicle type to see its features.</div>
                            </div>
                            <p class="field-error" data-error="features"></p>
                        </div>

                    {{-- ============ 08 DESCRIPTION ============ --}}
                    @elseif($section === 'description')
                        <div class="form-section">
                            <div class="section-heading">
                                <div class="section-number">08</div>
                                <h3>Vehicle Description</h3>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="f_description">Description</label>
                                <textarea name="description" id="f_description" class="form-textarea" rows="3" maxlength="2000"
                                    placeholder="Condition, rules, anything riders should know..."></textarea>
                                <p class="field-error" data-error="description"></p>
                            </div>
                        </div>

                    {{-- ============ NORMAL SECTIONS ============ --}}
                    @else
                        <div class="form-section">
                            <div class="section-heading">
                                <div class="section-number">{{ $section['no'] }}</div>
                                <h3>{{ $section['title'] }}</h3>
                            </div>

                            <div class="form-grid">
                                @foreach($section['fields'] as $f)
                                    @php $type = $f['type'] ?? 'text'; @endphp

                                    <div class="form-group {{ !empty($f['full']) ? 'full' : '' }}" data-field="{{ $f['name'] }}">
                                        <label class="form-label" for="f_{{ $f['name'] }}">
                                            {{ $f['label'] }}
                                            @if(!empty($f['required']))<span class="required">*</span>@endif
                                        </label>

                                        @if($type === 'select')
                                            <select name="{{ $f['name'] }}" id="f_{{ $f['name'] }}" class="form-select" @if(!empty($f['required'])) required @endif>
                                                @if(!array_key_exists('placeholder', $f) || $f['placeholder'] !== null)
                                                    <option value="">{{ $f['placeholder'] ?? 'Select' }}</option>
                                                @endif
                                                @foreach(($f['options'] ?? []) as $val => $text)
                                                    <option value="{{ $val }}">{{ $text }}</option>
                                                @endforeach
                                            </select>
                                        @elseif($type === 'textarea')
                                            <textarea name="{{ $f['name'] }}" id="f_{{ $f['name'] }}" class="form-textarea" rows="3"
                                                placeholder="{{ $f['placeholder'] ?? '' }}" {!! $f['attrs'] ?? '' !!}
                                                @if(!empty($f['required'])) required @endif></textarea>
                                        @else
                                            <input type="{{ $type }}" name="{{ $f['name'] }}" id="f_{{ $f['name'] }}" class="form-control"
                                                placeholder="{{ $f['placeholder'] ?? '' }}" value="{{ $f['value'] ?? '' }}"
                                                {!! $f['attrs'] ?? '' !!} @if(!empty($f['required'])) required @endif>
                                        @endif

                                        <p class="field-error" data-error="{{ $f['name'] }}"></p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                @endforeach

                {{-- ACTIONS --}}
                <div class="form-actions">
                    @if($isEdit)
                        <a href="{{ url('/admin/vehicle/vehicles') }}" class="btn-reset">Cancel</a>
                    @else
                        <button type="reset" class="btn-reset">Reset</button>
                    @endif
                    <button type="submit" class="btn-submit" id="submitBtn">{{ $isEdit ? 'Save Changes' : 'Add Vehicle' }}</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection


@push('scripts')
<script>
(function () {
    const token = localStorage.getItem('access_token');
    if (!token) return; // sidebar login par bhej dega

    /* ---------------- API CONFIG ---------------- */
    const API_BASE     = @json(rtrim(config('services.api.base_url') ?: url('/api/v1'), '/'));
    const TYPES_URL    = API_BASE + '/vehicle-types';     // public, sirf active types
    const FEATURES_URL = API_BASE + '/vehicle-features';  // public, ek type ke features
    const VEHICLES_URL = API_BASE + '/admin/vehicles';
    const LIST_URL     = @json(url('/admin/vehicle/vehicles'));
    const VIEW_BASE    = @json(url('/admin/vehicles'));
    const ADD_TYPE_URL = @json(url('/admin/vehicles/add-feature'));
    const LOGIN_URL    = @json(url('/login'));
    const EDIT_ID      = @json($vehicleId ?? null);

    const $       = id => document.getElementById(id);
    const form    = $('vehicleForm');
    const typeSel = $('f_vehicle_type_id');
    const fuelSel = $('f_fuel_type');
    const message = $('formMessage');

    let typeFeatures  = {};      // inactive type ke liye fallback { typeId: [features] }
    const featureCache = {};     // { typeId: [features] } (types API + features API)
    let typeList = [];           // active vehicle types (API se)
    let removeImages  = new Set();
    let vehicle       = null;    // edit mode data

    /* ---------------- Helpers ---------------- */
    function esc(v) {
        return String(v ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    }

    function showMessage(text, type) {
        message.textContent = text;
        message.className = 'form-message ' + type;
        message.hidden = false;
        message.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function fieldEl(name) {
        return form.querySelector(`[name="${name}"]`);
    }

    function setError(name, text) {
        const box = form.querySelector(`[data-error="${name}"]`);
        if (box) box.textContent = text;
        const el = fieldEl(name);
        if (el) el.classList.add('invalid');
    }

    function clearError(name) {
        const box = form.querySelector(`[data-error="${name}"]`);
        if (box) box.textContent = '';
        const el = fieldEl(name);
        if (el) el.classList.remove('invalid');
    }

    function clearAllErrors() {
        message.hidden = true;
        form.querySelectorAll('[data-error]').forEach(el => el.textContent = '');
        form.querySelectorAll('.invalid').forEach(el => el.classList.remove('invalid'));
    }

    function firstErrorIntoView() {
        const box = [...form.querySelectorAll('[data-error]')].find(el => el.textContent);
        if (!box) return;
        box.closest('.form-group, .image-upload-box, .form-section').scrollIntoView({ behavior: 'smooth', block: 'center' });
        const input = box.parentElement.querySelector('input:not([type="checkbox"]), select, textarea');
        if (input) setTimeout(() => input.focus({ preventScroll: true }), 300);
    }

    async function api(url, options = {}) {
        const headers = { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token };
        const res = await fetch(url, { ...options, headers });

        if (res.status === 401) {
            ['access_token', 'token_type', 'user', 'role', 'remember_me'].forEach(k => localStorage.removeItem(k));
            window.location.replace(LOGIN_URL);
            throw new Error('Session expired. Please log in again.');
        }

        const text = await res.text();
        let data = {};
        try { data = text ? JSON.parse(text) : {}; } catch (e) {}

        if (!res.ok) {
            const err = new Error(data.message || `Request failed (error ${res.status}).`);
            err.status = res.status; err.data = data;
            throw err;
        }
        return data;
    }

    /* ---------------- Vehicle types (API) ---------------- */
    async function loadVehicleTypes() {
        try {
            const res = await api(TYPES_URL);
            const types = res.data || [];

            typeList = types;
            types.forEach(t => { featureCache[t.id] = Array.isArray(t.vehicle_features) ? t.vehicle_features : []; });

            typeSel.innerHTML = `<option value="">${types.length ? 'Select vehicle type' : 'No vehicle types yet'}</option>`
                + types.map(t => `<option value="${t.id}">${esc(t.vehicle_type)}</option>`).join('');

            // Sirf ek type ho to apne aap select
            if (types.length === 1 && !EDIT_ID) {
                typeSel.value = String(types[0].id);
            }

            // Koi active type nahi hai -> seedha "Add vehicle type" ka link dikhao
            if (!types.length) {
                typeSel.disabled = true;
                const box = form.querySelector('[data-error="vehicle_type_id"]');
                box.innerHTML = `No vehicle types yet. <a href="${ADD_TYPE_URL}" style="color:#188052;font-weight:700">Add a vehicle type</a> first, then come back here.`;
                $('featureList').innerHTML = `<div class="feature-empty">Features appear here after you <a href="${ADD_TYPE_URL}" style="color:#188052;font-weight:700">add a vehicle type</a>.</div>`;
            } else {
                typeSel.disabled = false;
            }
        } catch (e) {
            typeSel.innerHTML = '<option value="">Could not load types</option>';
            setError('vehicle_type_id', `${e.message} Check that ${TYPES_URL} opens in the browser.`);
        }
    }

    /* ---------------- Features (features API se) ---------------- */
    async function fetchFeatures(typeId) {
        if (featureCache[typeId]) return featureCache[typeId];
        const res = await api(`${FEATURES_URL}?vehicle_type_id=${encodeURIComponent(typeId)}`);
        featureCache[typeId] = (res.data && res.data.features) || [];
        return featureCache[typeId];
    }

    async function renderFeatures(keepChecked) {
        const list    = $('featureList');
        const typeId  = typeSel.value;
        const checked = new Set((keepChecked || []).map(f => f.toLowerCase()));

        $('featureToolbar').hidden = true;

        if (!typeId) {
            list.innerHTML = typeList.length
                ? `<div class="feature-empty">
                        Choose a vehicle type to load its features:
                        <div class="type-picks">
                            ${typeList.map(t => `<button type="button" class="type-pick" data-pick-type="${t.id}">
                                ${esc(t.vehicle_type)} <small>${(t.vehicle_features || []).length} features</small>
                            </button>`).join('')}
                        </div>
                   </div>`
                : '<div class="feature-empty">Select a vehicle type to see its features.</div>';
            return;
        }

        if (!featureCache[typeId]) list.innerHTML = '<div class="feature-empty">Loading features...</div>';

        let features;
        try {
            features = await fetchFeatures(typeId);
        } catch (e) {
            // Type inactive ho gaya ho to gaadi ke saved features dikhao
            if (typeFeatures[typeId]) {
                features = typeFeatures[typeId];
            } else {
                list.innerHTML = `<div class="feature-error-box">${esc(e.message)}</div>`;
                return;
            }
        }

        if (typeSel.value !== typeId) return; // beech me type badal diya

        $('featureToolbar').hidden = !features.length;

        if (!features.length) {
            list.innerHTML = '<div class="feature-empty">This vehicle type has no features yet.</div>';
            return;
        }

        list.innerHTML = features.map((name, i) => `
            <div class="feature-item">
                <input type="checkbox" id="feature_${i}" name="features[]" value="${esc(name)}" ${checked.has(name.toLowerCase()) ? 'checked' : ''}>
                <label class="feature-label" for="feature_${i}">
                    <span class="feature-check"></span>${esc(name)}
                </label>
            </div>`).join('');
    }

    function checkedFeatures() {
        return [...form.querySelectorAll('input[name="features[]"]:checked')].map(i => i.value);
    }

    // Features section ke "type" buttons se type chuno
    $('featureList').addEventListener('click', e => {
        const pick = e.target.closest('[data-pick-type]');
        if (!pick) return;
        typeSel.value = pick.dataset.pickType;
        typeSel.dispatchEvent(new Event('change', { bubbles: true }));
        typeSel.focus();
    });

    typeSel.addEventListener('change', () => {
        clearError('vehicle_type_id');
        clearError('features');
        renderFeatures(checkedFeatures());   // naye type me jo match karein wo checked rahein
    });

    $('selectAllFeatures').addEventListener('click', () => {
        form.querySelectorAll('input[name="features[]"]').forEach(i => i.checked = true);
    });
    $('clearFeatures').addEventListener('click', () => {
        form.querySelectorAll('input[name="features[]"]').forEach(i => i.checked = false);
    });

    /* ---------------- Fuel type ke hisaab se fields ---------------- */
    function syncFuelFields() {
        const fuel = fuelSel.value;
        const show = {
            engine_cc:        fuel !== 'electric',
            mileage:          fuel !== 'electric',
            range_per_charge: fuel === '' || fuel === 'electric' || fuel === 'hybrid'
        };
        Object.entries(show).forEach(([name, visible]) => {
            const group = form.querySelector(`.form-group[data-field="${name}"]`);
            group.hidden = !visible;
            if (!visible) { fieldEl(name).value = ''; clearError(name); }
        });
    }
    fuelSel.addEventListener('change', syncFuelFields);

    /* ---------------- Input helpers ---------------- */
    fieldEl('vehicle_number').addEventListener('input', function () {
        this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
    });

    fieldEl('pincode').addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '').slice(0, 6);
    });

    fieldEl('available_from').addEventListener('change', function () {
        const to = fieldEl('available_to');
        to.min = this.value;
        if (to.value && to.value < this.value) to.value = '';
    });

    form.addEventListener('input', e => { if (e.target.name) clearError(e.target.name); });
    form.addEventListener('change', e => { if (e.target.name) clearError(e.target.name); });

    /* ---------------- Images ---------------- */
    function showPreview(slot, url) {
        const img = $('preview' + slot);
        img.hidden = !url;
        if (url) img.src = url; else img.removeAttribute('src');
        const removeBtn = form.querySelector(`[data-remove-image="${slot}"]`);
        if (removeBtn) removeBtn.hidden = !url;
    }

    form.querySelectorAll('.image-upload').forEach(input => {
        input.addEventListener('change', function () {
            const slot = Number(this.dataset.slot);
            const file = this.files[0];
            clearError(this.name);
            if (!file) return;

            if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
                setError(this.name, 'Choose a JPG, PNG or WEBP image.');
                this.value = '';
                return;
            }
            if (file.size > 3 * 1024 * 1024) {
                setError(this.name, 'Image must be 3 MB or smaller.');
                this.value = '';
                return;
            }

            removeImages.delete(slot);
            showPreview(slot, URL.createObjectURL(file));
        });
    });

    form.querySelectorAll('[data-remove-image]').forEach(btn => {
        btn.addEventListener('click', () => {
            const slot = Number(btn.dataset.removeImage);
            $('vehicle_image_' + slot).value = '';
            if (vehicle && vehicle.images.some(i => i.slot === slot)) removeImages.add(slot);
            showPreview(slot, null);
        });
    });

    /* ---------------- Reset ---------------- */
    form.addEventListener('reset', () => {
        setTimeout(() => {
            [1, 2, 3, 4].forEach(slot => showPreview(slot, null));
            removeImages.clear();
            clearAllErrors();
            renderFeatures([]);
            syncFuelFields();
        }, 0);
    });

    /* ---------------- Edit mode: data bharo ---------------- */
    async function loadVehicle() {
        const res = await api(`${VEHICLES_URL}/${EDIT_ID}`);
        vehicle = res.data;

        // Type ab inactive ho to bhi dropdown me dikhe
        if (!typeSel.querySelector(`option[value="${vehicle.vehicle_type_id}"]`)) {
            typeFeatures[vehicle.vehicle_type_id] = vehicle.features || [];
            typeSel.insertAdjacentHTML('beforeend',
                `<option value="${vehicle.vehicle_type_id}">${esc(vehicle.vehicle_type || 'Current type')} (inactive)</option>`);
        }

        const skip = ['features', 'images'];
        Object.entries(vehicle).forEach(([key, value]) => {
            if (skip.includes(key)) return;
            const el = form.querySelector(`[name="${key}"]:not([type="file"])`);
            if (el) el.value = value ?? '';
        });

        await renderFeatures(vehicle.features || []);
        syncFuelFields();
        (vehicle.images || []).forEach(img => showPreview(img.slot, img.url));
        if (vehicle.available_from) fieldEl('available_to').min = vehicle.available_from;
    }

    /* ---------------- Client validation ---------------- */
    function validate() {
        let ok = true;
        form.querySelectorAll('[required]').forEach(el => {
            if (el.closest('[hidden]')) return;
            if (!String(el.value || '').trim()) {
                const label = form.querySelector(`label[for="${el.id}"]`);
                const name  = label ? label.firstChild.textContent.trim() : 'This field';
                setError(el.name, `${name} is required.`);
                ok = false;
            }
        });

        if (!EDIT_ID && !$('vehicle_image_1').files.length) {
            setError('vehicle_image_1', 'Upload at least the first vehicle image.');
            ok = false;
        }
        if (fieldEl('pincode').value && !/^\d{6}$/.test(fieldEl('pincode').value)) {
            setError('pincode', 'Pincode must be 6 digits.');
            ok = false;
        }
        const min = Number(fieldEl('minimum_rental_days').value || 0);
        const max = Number(fieldEl('maximum_rental_days').value || 0);
        if (min && max && max < min) {
            setError('maximum_rental_days', 'Must be equal to or more than minimum days.');
            ok = false;
        }
        return ok;
    }

    /* ---------------- Submit (API) ---------------- */
    form.addEventListener('submit', async e => {
        e.preventDefault();
        clearAllErrors();

        if (!validate()) {
            showMessage('Fill in the highlighted fields.', 'error');
            firstErrorIntoView();
            return;
        }

        const btn = $('submitBtn');
        const label = btn.textContent;
        btn.disabled = true;
        btn.textContent = 'Saving...';

        const fd = new FormData(form);

        // Khali file inputs mat bhejo
        [1, 2, 3, 4].forEach(slot => {
            const f = fd.get('vehicle_image_' + slot);
            if (!f || !f.size) fd.delete('vehicle_image_' + slot);
        });
        removeImages.forEach(slot => fd.append('remove_images[]', slot));

        try {
            const res = await api(EDIT_ID ? `${VEHICLES_URL}/${EDIT_ID}` : VEHICLES_URL, { method: 'POST', body: fd });

            try { sessionStorage.setItem('vehicle_flash', res.message || 'Saved.'); } catch (err) {}
            // Save ke baad seedha us gaadi ka View page
            window.location.href = res.data && res.data.id ? `${VIEW_BASE}/${res.data.id}` : LIST_URL;

        } catch (err) {
            if (err.data && err.data.errors) {
                Object.entries(err.data.errors).forEach(([field, msgs]) => {
                    const name = field.split('.')[0];
                    setError(name === 'remove_images' ? 'vehicle_image_2' : name, Array.isArray(msgs) ? msgs[0] : msgs);
                });
                showMessage('Some details need fixing. Check the highlighted fields.', 'error');
                firstErrorIntoView();
            } else {
                showMessage(err.message, 'error');
            }
            btn.disabled = false;
            btn.textContent = label;
        }
    });

    /* ---------------- Init ---------------- */
    (async function init() {
        await loadVehicleTypes();
        syncFuelFields();

        if (!EDIT_ID && typeList.length) await renderFeatures([]);

        if (EDIT_ID) {
            try {
                await loadVehicle();
                $('loadingBox').hidden = true;
                form.hidden = false;
            } catch (e) {
                $('loadingBox').textContent = e.status === 404 ? 'This vehicle does not exist or was deleted.' : e.message;
            }
        }
    })();
})();
</script>
@endpush