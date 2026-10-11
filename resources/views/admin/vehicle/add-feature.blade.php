@extends('front.main')

@php $isEdit = !empty($vehicleTypeId); @endphp

@section('role', 'admin')
@section('title', $isEdit ? 'Edit vehicle type' : 'Add vehicle type')
@section('page_title', $isEdit ? 'Edit vehicle type' : 'Add vehicle type')

@section('content')

<style>
    .vehicle-feature-page { padding: 8px 0 24px; }
    .vehicle-feature-page [hidden] { display: none !important; }
    .vehicle-feature-container { max-width: 900px; margin: 0 auto; }

    /* Header */
    .vehicle-feature-header {
        display: flex; flex-wrap: wrap; align-items: flex-end; justify-content: space-between; gap: 12px;
        margin-bottom: 20px;
    }
    .vehicle-feature-header h1 { margin: 0; color: #051A13; font-size: 24px; font-weight: 700; line-height: 1.3; }
    .vehicle-feature-header p { margin: 6px 0 0; color: #6B7280; font-size: 14px; }
    .vehicle-feature-back { color: #188052; font-size: 14px; font-weight: 600; text-decoration: none; }
    .vehicle-feature-back:hover { text-decoration: underline; }

    /* Card */
    .vehicle-feature-card {
        background: #ffffff; border: 1px solid #E5E7EB; border-radius: 18px;
        padding: 30px; box-shadow: 0 5px 20px rgba(5, 26, 19, 0.06);
    }

    /* Grid */
    .vehicle-feature-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; }
    .vehicle-feature-field { width: 100%; min-width: 0; }
    .vehicle-feature-field.full { grid-column: 1 / -1; }

    /* Labels */
    .vehicle-feature-label { display: block; margin-bottom: 9px; color: #051A13; font-size: 14px; font-weight: 600; }
    .required-star { color: #EF4444; margin-left: 2px; }
    .optional { color: #6B7280; font-weight: 400; font-size: 12px; }
    .vehicle-feature-hint { margin-top: 6px; color: #6B7280; font-size: 12px; }

    /* Inputs */
    .vehicle-feature-input {
        width: 100%; height: 48px; padding: 0 15px;
        border: 1px solid #D1D5DB; border-radius: 11px;
        background: #ffffff; color: #051A13; font-size: 14px; font-family: inherit;
        outline: none; box-sizing: border-box; transition: all 0.2s ease;
    }
    textarea.vehicle-feature-input { height: auto; min-height: 96px; padding: 12px 15px; resize: vertical; line-height: 1.5; }
    .vehicle-feature-input::placeholder { color: #9CA3AF; }
    .vehicle-feature-input:hover { border-color: #9CA3AF; }
    .vehicle-feature-input:focus { border-color: #188052; box-shadow: 0 0 0 3px rgba(24, 128, 82, 0.12); }
    .vehicle-feature-input.invalid, .chip-box.invalid, .icon-drop.invalid { border-color: #EF4444; }

    /* Features chips */
    .chip-box {
        display: flex; flex-wrap: wrap; align-items: center; gap: 8px;
        min-height: 48px; padding: 7px 10px;
        border: 1px solid #D1D5DB; border-radius: 11px; background: #fff;
        cursor: text; box-sizing: border-box; transition: all 0.2s ease;
    }
    .chip-box:focus-within { border-color: #188052; box-shadow: 0 0 0 3px rgba(24, 128, 82, 0.12); }
    .chip {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 5px 6px 5px 11px; border-radius: 999px;
        background: #E7F4EC; color: #0F4A35; font-size: 13px; font-weight: 600;
    }
    .chip button {
        width: 20px; height: 20px; display: grid; place-items: center;
        border: 0; border-radius: 50%; background: transparent; color: #0F4A35;
        cursor: pointer; font-size: 15px; line-height: 1;
    }
    .chip button:hover { background: #cfe8d9; }
    .chip-input { flex: 1; min-width: 140px; height: 32px; border: 0; outline: none; font-size: 14px; font-family: inherit; color: #051A13; background: transparent; }
    .chip-input::placeholder { color: #9CA3AF; }

    /* Icon upload */
    .icon-row { display: flex; align-items: center; gap: 16px; flex-wrap: wrap; }
    .icon-preview {
        width: 64px; height: 64px; flex-shrink: 0;
        border-radius: 14px; border: 1px solid #E5E7EB; background: #F0F7F3;
        display: grid; place-items: center; overflow: hidden; color: #9CA3AF; font-size: 12px;
    }
    .icon-preview img { width: 100%; height: 100%; object-fit: cover; }
    .icon-drop {
        position: relative; display: inline-flex; align-items: center; gap: 8px;
        height: 42px; padding: 0 16px;
        border: 1px dashed #D1D5DB; border-radius: 11px; background: #F9FAFB;
        color: #374151; font-size: 14px; font-weight: 600; cursor: pointer;
    }
    .icon-drop:hover, .icon-drop:focus-within { border-color: #188052; color: #188052; }
    .icon-drop input { position: absolute; inset: 0; opacity: 0; cursor: pointer; }
    .link-btn { border: 0; background: none; padding: 0; color: #B91C1C; font-size: 13px; font-weight: 600; cursor: pointer; font-family: inherit; }

    /* Status switch */
    .switch-row { display: flex; align-items: center; gap: 12px; }
    .switch { position: relative; width: 46px; height: 26px; flex-shrink: 0; }
    .switch input { position: absolute; inset: 0; opacity: 0; cursor: pointer; margin: 0; z-index: 1; }
    .switch span { position: absolute; inset: 0; border-radius: 999px; background: #D1D5DB; transition: background .2s; }
    .switch span::after {
        content: ''; position: absolute; top: 3px; left: 3px;
        width: 20px; height: 20px; border-radius: 50%; background: #fff;
        box-shadow: 0 1px 3px rgba(0,0,0,.2); transition: transform .2s;
    }
    .switch input:checked + span { background: #188052; }
    .switch input:checked + span::after { transform: translateX(20px); }
    .switch input:focus-visible + span { outline: 2px solid #188052; outline-offset: 2px; }
    .switch-text { font-size: 14px; color: #374151; }

    /* Errors / alerts */
    .vehicle-feature-error { margin-top: 6px; color: #EF4444; font-size: 13px; }
    .vehicle-feature-error:empty { display: none; }
    .vehicle-feature-alert {
        margin-bottom: 20px; padding: 12px 14px; border-radius: 11px;
        background: #FEF2F2; border: 1px solid #FECACA; color: #B91C1C; font-size: 14px;
    }
    .vehicle-feature-loading { color: #6B7280; font-size: 14px; }

    /* Buttons */
    .vehicle-feature-actions {
        display: flex; justify-content: flex-end; align-items: center; gap: 12px;
        margin-top: 28px; padding-top: 22px; border-top: 1px solid #E5E7EB;
    }
    .vehicle-feature-cancel {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 100px; height: 46px; padding: 0 20px;
        border: 1px solid #D1D5DB; border-radius: 11px; background: #ffffff;
        color: #374151; font-size: 14px; font-weight: 600; text-decoration: none; transition: all 0.2s ease;
    }
    .vehicle-feature-cancel:hover { background: #F9FAFB; border-color: #9CA3AF; }
    .vehicle-feature-save {
        min-width: 110px; height: 46px; padding: 0 22px;
        border: none; border-radius: 11px; background: #188052; color: #ffffff;
        font-size: 14px; font-weight: 600; font-family: inherit; cursor: pointer; transition: all 0.2s ease;
    }
    .vehicle-feature-save:hover { background: #0F4A35; transform: translateY(-1px); box-shadow: 0 5px 12px rgba(15, 74, 53, 0.18); }
    .vehicle-feature-save:active { transform: translateY(0); }
    .vehicle-feature-save:disabled { opacity: .6; cursor: not-allowed; transform: none; box-shadow: none; }

    /* Responsive */
    @media (max-width: 768px) {
        .vehicle-feature-card { padding: 22px; }
        .vehicle-feature-grid { grid-template-columns: 1fr; gap: 20px; }
        .vehicle-feature-header h1 { font-size: 22px; }
    }
    @media (max-width: 480px) {
        .vehicle-feature-card { padding: 18px; border-radius: 14px; }
        .vehicle-feature-actions { flex-direction: column-reverse; align-items: stretch; }
        .vehicle-feature-cancel, .vehicle-feature-save { width: 100%; }
    }
</style>


<div class="vehicle-feature-page">
    <div class="vehicle-feature-container">

        <!-- Header -->
        <div class="vehicle-feature-header">
            <div>
                <h1>{{ $isEdit ? 'Edit vehicle type' : 'Vehicle Type & Features' }}</h1>
                <p>{{ $isEdit ? 'Update this vehicle type and its features.' : 'Add a vehicle type and the features it comes with.' }}</p>
            </div>
            <a href="{{ url('/admin/vehicles/types') }}" class="vehicle-feature-back">View all vehicle types</a>
        </div>

        <!-- Card -->
        <div class="vehicle-feature-card">

            <p class="vehicle-feature-loading" id="loadingBox" @if(!$isEdit) hidden @endif>Loading vehicle type...</p>

            <div class="vehicle-feature-alert" id="formAlert" role="alert" hidden></div>

            <form id="vehicleTypeForm" novalidate @if($isEdit) hidden @endif>

                <div class="vehicle-feature-grid">

                    <!-- Vehicle Type -->
                    <div class="vehicle-feature-field">
                        <label class="vehicle-feature-label" for="vehicle_type">
                            Vehicle Type <span class="required-star">*</span>
                        </label>
                        <input type="text" id="vehicle_type" name="vehicle_type" maxlength="100"
                            placeholder="e.g. Electric Scooter" class="vehicle-feature-input" autocomplete="off" required>
                        <p class="vehicle-feature-error" data-error="vehicle_type"></p>
                    </div>

                    <!-- Status -->
                    <div class="vehicle-feature-field">
                        <span class="vehicle-feature-label">Status</span>
                        <div class="switch-row">
                            <label class="switch">
                                <input type="checkbox" id="status" checked aria-label="Active">
                                <span></span>
                            </label>
                            <span class="switch-text" id="statusText">Active, shown to riders</span>
                        </div>
                    </div>

                    <!-- Vehicle Features (chips) -->
                    <div class="vehicle-feature-field full">
                        <label class="vehicle-feature-label" for="featureInput">
                            Vehicle Features <span class="required-star">*</span>
                        </label>
                        <div class="chip-box" id="chipBox">
                            <input type="text" id="featureInput" class="chip-input" maxlength="50"
                                placeholder="Type a feature and press Enter" autocomplete="off">
                        </div>
                        <p class="vehicle-feature-hint">Press Enter or comma after each feature, e.g. AC, GPS, Bluetooth.</p>
                        <p class="vehicle-feature-error" data-error="vehicle_features"></p>
                    </div>

                    <!-- Description -->
                    <div class="vehicle-feature-field full">
                        <label class="vehicle-feature-label" for="description">
                            Description <span class="optional">(optional)</span>
                        </label>
                        <textarea id="description" name="description" maxlength="1000" rows="3"
                            placeholder="Short note about this vehicle type" class="vehicle-feature-input"></textarea>
                        <p class="vehicle-feature-error" data-error="description"></p>
                    </div>

                    <!-- Icon -->
                    <div class="vehicle-feature-field full">
                        <span class="vehicle-feature-label">Icon <span class="optional">(optional)</span></span>
                        <div class="icon-row">
                            <div class="icon-preview" id="iconPreview">No icon</div>
                            <label class="icon-drop" id="iconDrop">
                                Choose image
                                <input type="file" id="icon" name="icon" accept=".jpg,.jpeg,.png,.webp">
                            </label>
                            <button type="button" class="link-btn" id="removeIcon" hidden>Remove icon</button>
                        </div>
                        <p class="vehicle-feature-hint">JPG, PNG or WEBP, up to 1 MB. A square image looks best.</p>
                        <p class="vehicle-feature-error" data-error="icon"></p>
                    </div>

                </div>

                <!-- Buttons -->
                <div class="vehicle-feature-actions">
                    <a href="{{ url('/admin/vehicles/types') }}" class="vehicle-feature-cancel">Cancel</a>
                    <button type="submit" class="vehicle-feature-save" id="saveBtn">
                        {{ $isEdit ? 'Save changes' : 'Save' }}
                    </button>
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
    if (!token) return;

    /* API base URL: .env me API_BASE_URL do to wahi use hoga, warna isi site ka /api/v1 */
    const API_BASE  = @json(rtrim(config('services.api.base_url') ?: url('/api/v1'), '/'));
    const API_URL   = API_BASE + '/admin/vehicle-types';
    const LIST_URL  = @json(url('/admin/vehicles/types'));
    const LOGIN_URL = @json(url('/login'));
    const EDIT_ID   = @json($vehicleTypeId ?? null);
    const MAX_FEATURES = 30;

    const $         = id => document.getElementById(id);
    const form      = $('vehicleTypeForm');
    const chipBox   = $('chipBox');
    const chipInput = $('featureInput');
    const saveBtn   = $('saveBtn');

    let features   = [];
    let removeIcon = false;
    let objectUrl  = null;

    /* ---------------- Helpers ---------------- */
    function esc(v) {
        return String(v ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    }

    function showAlert(msg) { $('formAlert').textContent = msg; $('formAlert').hidden = false; }
    function hideAlert() { $('formAlert').hidden = true; }

    const errorTargets = { vehicle_features: chipBox, icon: $('iconDrop') };

    function setError(name, msg) {
        const box = form.querySelector(`[data-error="${name}"]`);
        if (box) box.textContent = msg;
        const target = errorTargets[name] || form.querySelector(`[name="${name}"]`);
        if (target) target.classList.add('invalid');
    }

    function clearError(name) {
        const box = form.querySelector(`[data-error="${name}"]`);
        if (box) box.textContent = '';
        const target = errorTargets[name] || form.querySelector(`[name="${name}"]`);
        if (target) target.classList.remove('invalid');
    }

    function clearAllErrors() {
        hideAlert();
        ['vehicle_type', 'vehicle_features', 'description', 'icon'].forEach(clearError);
    }

    function logoutExpired() {
        ['access_token', 'token_type', 'user', 'role', 'remember_me'].forEach(k => localStorage.removeItem(k));
        window.location.replace(LOGIN_URL);
    }

    async function api(url, options = {}) {
        const headers = { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token };
        if (options.body && !(options.body instanceof FormData)) headers['Content-Type'] = 'application/json';

        const res = await fetch(url, { ...options, headers });
        if (res.status === 401) { logoutExpired(); throw new Error('Session expired. Please log in again.'); }

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

    /* ---------------- Status switch ---------------- */
    function syncStatusText() {
        $('statusText').textContent = $('status').checked ? 'Active, shown to riders' : 'Inactive, hidden from riders';
    }
    $('status').addEventListener('change', syncStatusText);

    /* ---------------- Feature chips ---------------- */
    function renderChips() {
        chipBox.querySelectorAll('.chip').forEach(c => c.remove());
        features.forEach((f, i) => {
            const chip = document.createElement('span');
            chip.className = 'chip';
            chip.innerHTML = `${esc(f)}<button type="button" aria-label="Remove ${esc(f)}" data-index="${i}">&times;</button>`;
            chipBox.insertBefore(chip, chipInput);
        });
        chipInput.placeholder = features.length ? 'Add another feature' : 'Type a feature and press Enter';
    }

    function addFeatures(raw) {
        let added = false;
        raw.split(',').map(s => s.trim()).filter(Boolean).forEach(f => {
            if (features.length >= MAX_FEATURES) {
                setError('vehicle_features', `You can add up to ${MAX_FEATURES} features.`);
                return;
            }
            if (!features.some(x => x.toLowerCase() === f.toLowerCase())) {
                features.push(f.slice(0, 50));
                added = true;
            }
        });
        if (added) { clearError('vehicle_features'); renderChips(); }
    }

    chipInput.addEventListener('keydown', e => {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            if (chipInput.value.trim()) { addFeatures(chipInput.value); chipInput.value = ''; }
        } else if (e.key === 'Backspace' && !chipInput.value && features.length) {
            features.pop();
            renderChips();
        }
    });

    // Paste "AC, GPS, Bluetooth" -> 3 chips
    chipInput.addEventListener('paste', e => {
        const text = (e.clipboardData || window.clipboardData).getData('text');
        if (text.includes(',')) { e.preventDefault(); addFeatures(text); }
    });

    // Input chhod kar bahar click kiya to bacha hua text bhi chip ban jaye
    chipInput.addEventListener('blur', () => {
        if (chipInput.value.trim()) { addFeatures(chipInput.value); chipInput.value = ''; }
    });

    chipBox.addEventListener('click', e => {
        const btn = e.target.closest('button[data-index]');
        if (btn) {
            features.splice(Number(btn.dataset.index), 1);
            renderChips();
            chipInput.focus();
        } else if (e.target === chipBox) {
            chipInput.focus();
        }
    });

    /* ---------------- Icon ---------------- */
    function showIcon(url) {
        $('iconPreview').innerHTML = url ? `<img src="${esc(url)}" alt="Vehicle type icon">` : 'No icon';
        $('removeIcon').hidden = !url;
    }

    $('icon').addEventListener('change', function () {
        clearError('icon');
        const file = this.files[0];
        if (!file) return;

        if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
            setError('icon', 'Choose a JPG, PNG or WEBP image.');
            this.value = '';
            return;
        }
        if (file.size > 1024 * 1024) {
            setError('icon', 'Icon must be 1 MB or smaller.');
            this.value = '';
            return;
        }

        if (objectUrl) URL.revokeObjectURL(objectUrl);
        objectUrl = URL.createObjectURL(file);
        removeIcon = false;
        showIcon(objectUrl);
    });

    $('removeIcon').addEventListener('click', () => {
        $('icon').value = '';
        removeIcon = true;
        showIcon(null);
    });

    /* Typing par error hatao */
    form.addEventListener('input', e => { if (e.target.name) clearError(e.target.name); hideAlert(); });

    /* ---------------- Edit mode: data load ---------------- */
    async function loadForEdit() {
        try {
            const res = await api(`${API_URL}/${EDIT_ID}`);
            const t = res.data;

            $('vehicle_type').value = t.vehicle_type || '';
            $('description').value  = t.description || '';
            $('status').checked     = !!t.status;
            features = Array.isArray(t.vehicle_features) ? t.vehicle_features.slice() : [];

            renderChips();
            syncStatusText();
            showIcon(t.icon_url);

            $('loadingBox').hidden = true;
            form.hidden = false;
            $('vehicle_type').focus();
        } catch (e) {
            $('loadingBox').textContent = e.status === 404 ? 'This vehicle type does not exist or was deleted.' : e.message;
        }
    }

    /* ---------------- Submit ---------------- */
    form.addEventListener('submit', async e => {
        e.preventDefault();
        clearAllErrors();

        // Input me likha hua feature bhi add karo
        if (chipInput.value.trim()) { addFeatures(chipInput.value); chipInput.value = ''; }

        const vehicleType = $('vehicle_type').value.trim();
        let hasError = false;
        if (!vehicleType) { setError('vehicle_type', 'Enter the vehicle type.'); hasError = true; }
        if (!features.length) { setError('vehicle_features', 'Add at least one feature.'); hasError = true; }
        if (hasError) {
            (vehicleType ? chipInput : $('vehicle_type')).focus();
            return;
        }

        const fd = new FormData();
        fd.append('vehicle_type', vehicleType);
        features.forEach(f => fd.append('vehicle_features[]', f));
        fd.append('description', $('description').value.trim());
        fd.append('status', $('status').checked ? '1' : '0');
        if ($('icon').files[0]) fd.append('icon', $('icon').files[0]);
        if (EDIT_ID && removeIcon) fd.append('remove_icon', '1');

        saveBtn.disabled = true;
        saveBtn.textContent = 'Saving...';

        try {
            const res = await api(EDIT_ID ? `${API_URL}/${EDIT_ID}` : API_URL, { method: 'POST', body: fd });

            try { sessionStorage.setItem('vehicle_type_flash', res.message || 'Saved.'); } catch (err) {}
            window.location.href = LIST_URL;

        } catch (err) {
            if (err.data && err.data.errors) {
                Object.entries(err.data.errors).forEach(([field, msgs]) => {
                    const name = field.startsWith('vehicle_features') ? 'vehicle_features' : field;
                    setError(name, Array.isArray(msgs) ? msgs[0] : msgs);
                });
                showAlert('Fix the highlighted fields and save again.');
            } else {
                showAlert(err.message);
            }
            saveBtn.disabled = false;
            saveBtn.textContent = EDIT_ID ? 'Save changes' : 'Save';
        }
    });

    /* ---------------- Init ---------------- */
    syncStatusText();
    if (EDIT_ID) loadForEdit();
    else $('vehicle_type').focus();
})();
</script>
@endpush