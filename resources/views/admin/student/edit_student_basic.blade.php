<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css" />

<div class="row mb-3">
    <label for="user-name" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Name') }}<span
            class="text-danger ms-1">*</span></label>
    <div class="col-sm-8">
        <input type="text" name="name" class="form-control ol-form-control" id="user-name" maxlength="50"
            pattern="^[A-Za-z][A-Za-z\s]{0,49}$"
            oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '').replace(/^\s+/g, '')"
            @isset($student->name) value="{{ $student->name }}" @endisset required>
    </div>
</div>
<script>
    const GET_STATES_URL = "{{ route('get.states', ':id') }}";
    const GET_CITIES_URL = "{{ route('get.cities', ':id') }}";
</script>

<div class="row mb-3">
    <label for="user-phone" class="form-label ol-form-label col-sm-2 col-form-label">
        {{ get_phrase('Phone') }}<span class="text-danger ms-1">*</span>
    </label>
    <div class="col-sm-8">
        <input type="tel" id="user-phone" class="form-control ol-form-control" value="{{ $student->phone ?? '' }}">

        <!-- hidden field for final full number -->
        <input type="hidden" name="phone" id="full-phone">
    </div>
</div>
<div class="row mb-3">
    <label for="password" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Password') }}<span
            class="text-danger ms-1">*</span></label>
    <div class="col-sm-8">
        <input type="password" name="password" placeholder="If not changing, leave blank"
            class="form-control ol-form-control" id="password">
    </div>
</div>
@php
    $savedAddress = !empty($student->address) ? json_decode($student->address, true) : null;

    $countries = DB::table('countries1')->select('id', 'name')->orderBy('name')->get();
@endphp

{{-- ADDRESS (EDIT MODE) --}}
<div class="row mb-3">
    <label class="form-label ol-form-label col-sm-2 col-form-label">
        {{ get_phrase('Address') }}
    </label>

    <div class="col-sm-8">

        {{-- Country --}}
        <select id="country" class="form-control mb-2" disabled>
            <option value="">Select Country</option>
            @foreach ($countries as $country)
                <option value="{{ $country->id }}"
                    {{ ($savedAddress['country_id'] ?? '') == $country->id ? 'selected' : '' }}>
                    {{ $country->name }}
                </option>
            @endforeach
        </select>

        {{-- State --}}
        <select id="state" class="form-control mb-2">
            <option value="">Select State</option>
        </select>

        {{-- City --}}
        <select id="city" class="form-control mb-2">
            <option value="">Select City</option>
        </select>

        {{-- FINAL ADDRESS FIELD --}}
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
    const stateSelect = document.getElementById('state');
    const citySelect = document.getElementById('city');
    const addressInput = document.getElementById('user-address');

    const savedAddress = {!! json_encode($savedAddress) !!};

    // Load states
    function loadStates(countryId, selectedState = null) {
        if (!countryId) return;

        const url = GET_STATES_URL.replace(':id', countryId);

        fetch(url)
            .then(res => {
                if (!res.ok) throw new Error('Network error');
                return res.json();
            })
            .then(states => {
                stateSelect.innerHTML = '<option value="">Select State</option>';
                stateSelect.disabled = false;

                states.forEach(state => {
                    const selected = selectedState == state.id ? 'selected' : '';
                    stateSelect.innerHTML +=
                        `<option value="${state.id}" ${selected}>${state.name}</option>`;
                });

                if (selectedState) {
                    loadCities(selectedState, savedAddress?.city_id);
                }
            })
            .catch(err => console.error(err));
    }

    // Load cities
    function loadCities(stateId, selectedCity = null) {
        if (!stateId) return;

        const url = GET_CITIES_URL.replace(':id', stateId);

        fetch(url)
            .then(res => {
                if (!res.ok) throw new Error('Network error');
                return res.json();
            })
            .then(cities => {
                citySelect.innerHTML = '<option value="">Select City</option>';
                citySelect.disabled = false;

                cities.forEach(city => {
                    const selected = selectedCity == city.id ? 'selected' : '';
                    citySelect.innerHTML +=
                        `<option value="${city.id}" ${selected}>${city.name}</option>`;
                });
            })
            .catch(err => console.error(err));
    }

    // Events
    countrySelect.addEventListener('change', function() {
        stateSelect.innerHTML = '<option value="">Select State</option>';
        citySelect.innerHTML = '<option value="">Select City</option>';
        stateSelect.disabled = citySelect.disabled = true;
        addressInput.value = '';

        loadStates(this.value);
    });

    stateSelect.addEventListener('change', function() {
        citySelect.innerHTML = '<option value="">Select City</option>';
        citySelect.disabled = true;
        addressInput.value = '';

        loadCities(this.value);
    });

    citySelect.addEventListener('change', function() {
        if (!this.value) return;

        addressInput.value = JSON.stringify({
            country_id: countrySelect.value,
            state_id: stateSelect.value,
            city_id: this.value,
        });
    });

    // AUTO LOAD SAVED ADDRESS (EDIT MODE)
    if (savedAddress?.country_id) {
        loadStates(savedAddress.country_id, savedAddress.state_id);
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>

{{-- <script>
    document.addEventListener("DOMContentLoaded", function() {

        const phoneInput = document.querySelector("#user-phone");
        const fullPhone = document.querySelector("#full-phone");

        const iti = window.intlTelInput(phoneInput, {
            initialCountry: "in", // default India
            separateDialCode: true,
            preferredCountries: ["in", "us", "gb"],
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
        });

        // Save full international number before submit
        phoneInput.closest("form").addEventListener("submit", function() {
            if (iti.isValidNumber()) {
                fullPhone.value = iti.getNumber(); // +919876543210
            } else {
                alert("Please enter valid phone number");
                event.preventDefault();
            }
        });
    });
</script> --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {

        const phoneInput = document.querySelector("#user-phone");
        const fullPhone = document.querySelector("#full-phone");

        const iti = window.intlTelInput(phoneInput, {
            initialCountry: "in",
            separateDialCode: true,
            preferredCountries: ["in", "us", "gb"],
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
        });

        // ✅ Phone country -> Country dropdown sync
        function syncCountryDropdown() {

            const countryData = iti.getSelectedCountryData();

            if (!countryData || !countryData.iso2) return;

            fetch("{{ url('/get-country-by-code') }}/" + countryData.iso2.toUpperCase())
                .then(res => res.json())
                .then(country => {

                    if (!country) return;

                    // Country auto select
                    countrySelect.value = country.id;

                    // State bhi select ho jayegi
                    loadStates(country.id, savedAddress?.state_id);
                });
        }

        // Default load
        syncCountryDropdown();

        // Jab country code change ho
        phoneInput.addEventListener("countrychange", function() {
            syncCountryDropdown();
        });

        // Save full international number before submit
        phoneInput.closest("form").addEventListener("submit", function(event) {

            if (iti.isValidNumber()) {
                fullPhone.value = iti.getNumber();
            } else {
                alert("Please enter valid phone number");
                event.preventDefault();
            }
        });

    });
</script>
{{-- <div class="d-flex justify-content-end mt-3">
    <button type="button" class="btn ol-btn-primary next-tab" data-next="#v-pills-tab2-tab">
        {{ get_phrase('Next') }}
    </button>
</div> --}}
