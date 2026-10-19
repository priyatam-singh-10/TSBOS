<div class="row mb-3">
    <label for="user-name" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Name') }}<span
            class="text-danger ms-1">*</span></label>
    <div class="col-sm-8">
        <input type="text" name="name" class="form-control ol-form-control @error('name') is-invalid @enderror"
            id="user-name" maxlength="50" pattern="^[A-Za-z][A-Za-z\s]{0,49}$"
            oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '').replace(/^\s+/g, '')"
            value="{{ old('name', $student->name ?? '') }}" required>
    </div>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
@php
    $countries = DB::table('countries1')
        ->select('id', 'name', 'phonecode') // ✅ yeh add karo
        ->orderBy('name')
        ->get();
@endphp
<div class="row mb-3">
    <label for="user-phone" class="form-label ol-form-label col-sm-2 col-form-label">
        {{ get_phrase('Phone') }}
        <span class="text-danger ms-1">*</span>
    </label>

    <div class="col-sm-8">
        <div class="input-group">

            {{-- Country Code --}}
            {{-- Phone Code --}}
            <select id="phone-code" class="form-select" style="max-width:120px;">
                <option value="">Code</option>

                @foreach ($countries as $country)
                    <option value="{{ $country->phonecode }}" data-country_id="{{ $country->id }}"
                        {{ $country->phonecode == '91' ? 'selected' : '' }}>
                        {{ $country->phonecode }}
                    </option>
                @endforeach
            </select>

            {{-- Phone Number --}}
            <input type="text" id="user-phone"
                class="form-control ol-form-control @error('phone')
    is-invalid
    @enderror" maxlength="10"
                value="{{ old('phone', isset($student->phone) ? preg_replace('/^\+\d{1,4}/', '', $student->phone) : '') }}"
                pattern="[0-9]*" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                placeholder="Enter phone number">

        </div>

        {{-- Hidden full phone --}}
        <input type="hidden" name="phone" id="full-phone">

        @error('phone')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="row mb-3">
    <label for="password" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Password') }}<span
            class="text-danger ms-1">*</span></label>
    <div class="col-sm-8">
        <input type="password" name="password" class="form-control ol-form-control" id="password">
    </div>
</div>

<script>
    const GET_STATES_URL = "{{ route('get.states', ':id') }}";
    const GET_CITIES_URL = "{{ route('get.cities', ':id') }}";
</script>

{{-- ADDRESS --}}
<div class="row mb-3">
    <label class="form-label ol-form-label col-sm-2 col-form-label">
        {{ get_phrase('Address') }}
    </label>

    <div class="col-sm-8">



        {{-- Country --}}
        <select id="country" class="form-control mb-2" disabled>
            <option value="">Select Country</option>
            @foreach ($countries as $country)
                <option value="{{ $country->id }}">
                    {{ $country->name }}
                </option>
            @endforeach
        </select>

        <input type="hidden" name="country_id" id="country-hidden">



        {{-- State --}}
        <select id="state" class="form-control mb-2" disabled>
            <option value="">Select State</option>
        </select>

        {{-- City --}}
        <select id="city" class="form-control mb-2" disabled>
            <option value="">Select City</option>
        </select>

        {{-- FINAL ADDRESS FIELD (DO NOT CHANGE NAME) --}}
        <input type="hidden" name="address" id="user-address" value="{{ $student->address ?? '' }}">
    </div>
</div>

<div class="row mb-3">
    <label for="photo"
        class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('User image') }}</label>
    <div class="col-sm-8">
        <input type="file" name="photo" class="form-control ol-form-control" id="photo">
    </div>
</div>
<script>
    const countrySelect = document.getElementById('country');
    const countryHidden = document.getElementById('country-hidden');
    const stateSelect = document.getElementById('state');
    const citySelect = document.getElementById('city');
    const addressInput = document.getElementById('user-address');

    const phoneCodeSelect = document.getElementById('phone-code');
    const phoneInput = document.getElementById('user-phone');
    const fullPhoneInput = document.getElementById('full-phone');

    // ✅ FULL PHONE
    function updateFullPhone() {

        let code = phoneCodeSelect.value || '';
        let number = phoneInput.value || '';

        // ✅ remove + if already exists
        code = code.replace('+', '');
        number = number.replace(/^\+/, '');

        fullPhoneInput.value = (code && number) ?
            `+${code}${number}` :
            '';
    }

    // ✅ LOAD STATES
    function loadStates(countryId) {
        stateSelect.innerHTML = '<option value="">Select State</option>';
        citySelect.innerHTML = '<option value="">Select City</option>';

        stateSelect.disabled = true;
        citySelect.disabled = true;

        if (!countryId) return;

        fetch(GET_STATES_URL.replace(':id', countryId))
            .then(res => res.json())
            .then(states => {
                stateSelect.disabled = false;

                states.forEach(state => {
                    stateSelect.innerHTML += `<option value="${state.id}">${state.name}</option>`;
                });
            });
    }

    // ✅ LOAD CITIES
    function loadCities(stateId) {
        citySelect.innerHTML = '<option value="">Select City</option>';
        citySelect.disabled = true;

        if (!stateId) return;

        fetch(GET_CITIES_URL.replace(':id', stateId))
            .then(res => res.json())
            .then(cities => {
                citySelect.disabled = false;

                cities.forEach(city => {
                    citySelect.innerHTML += `<option value="${city.id}">${city.name}</option>`;
                });
            });
    }

    // ✅ COUNTRY AUTO SELECT FROM PHONE CODE
    function syncCountryFromCode() {

        const selectedOption = phoneCodeSelect.options[phoneCodeSelect.selectedIndex];

        const countryId = selectedOption.getAttribute('data-country_id');

        if (!countryId) return;

        // 👇 force correct value
        countrySelect.value = countryId;
        countryHidden.value = countryId;

        // 👇 IMPORTANT: wait for DOM update
        setTimeout(() => {
            loadStates(countryId);
        }, 100);
    }

    // EVENTS
    phoneCodeSelect.addEventListener('change', function() {
        updateFullPhone();
        syncCountryFromCode();
    });

    phoneInput.addEventListener('input', updateFullPhone);

    stateSelect.addEventListener('change', function() {
        loadCities(this.value);
    });

    citySelect.addEventListener('change', function() {
        addressInput.value = JSON.stringify({
            country_id: countryHidden.value,
            state_id: stateSelect.value,
            city_id: this.value
        });
    });

    // DEFAULT LOAD
    window.addEventListener('DOMContentLoaded', function() {

        let existingPhone = "{{ $student->phone ?? '' }}";

        if (existingPhone.startsWith('+')) {

            const match = existingPhone.match(/^\+(\d{1,4})(\d+)/);

            if (match) {
                phoneCodeSelect.value = match[1];
                phoneInput.value = match[2]; // ✅ only number
            }
        }

        updateFullPhone();
        syncCountryFromCode();
    });
</script>
