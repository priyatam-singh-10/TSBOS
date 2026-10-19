<div class="row mb-3">
    <label for="user-name" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Name') }}<span
            class="text-danger ms-1">*</span></label>
    <div class="col-sm-8">
        <input type="text" name="name" class="form-control ol-form-control" id="user-name"
            @isset($instructor->name) value="{{ $instructor->name }}" @endisset required>
    </div>
</div>


<div class="row mb-3">
    <label for="short_description" class="form-label ol-form-label col-sm-2 col-form-label">
        {{ get_phrase('Biography') }}
    </label>

    <div class="col-sm-8">
        <textarea name="about" rows="3" class="form-control ol-form-control" id="about_editor">
            @isset($instructor->about)
{{ $instructor->about }}
@endisset
        </textarea>
    </div>
</div>


<div class="row mb-3">
    <label for="user-phone" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Phone') }}</label>
    <div class="col-sm-8">
        <input type="text" name="phone" class="form-control ol-form-control" id="user-phone" inputmode="numeric"
            pattern="[0-9]{10}" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
            @isset($instructor->phone) value="{{ $instructor->phone }}" @endisset>
        <input type="hidden" name="phone" id="full-phone">
    </div>
</div>
<script>
    const GET_STATES_URL = "{{ route('get.states', ':id') }}";
    const GET_CITIES_URL = "{{ route('get.cities', ':id') }}";
</script>
<!--<div class="row mb-3">-->
<!--    <label for="user-address" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Address') }}</label>-->
<!--    <div class="col-sm-8">-->
<!--        <input type="text" name="address" class="form-control ol-form-control" id="user-address" @isset($instructor->address) value="{{ $instructor->address }}" @endisset>-->
<!--    </div>-->
<!--</div>-->
{{-- ADDRESS --}}
<div class="row mb-3">
    <label class="form-label ol-form-label col-sm-2 col-form-label">
        {{ get_phrase('Address') }}
    </label>

    <div class="col-sm-8">

        @php
            $countries = DB::table('countries1')->select('id', 'name')->orderBy('name')->get();
        @endphp

        {{-- Country --}}
        <select id="country" class="form-control mb-2">
            <option value="">Select Country</option>
            @foreach ($countries as $country)
                <option value="{{ $country->id }}">{{ $country->name }}</option>
            @endforeach
        </select>

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
    const stateSelect = document.getElementById('state');
    const citySelect = document.getElementById('city');
    const addressInput = document.getElementById('user-address');

    countrySelect.addEventListener('change', function() {
        const countryId = this.value;

        stateSelect.innerHTML = '<option value="">Select State</option>';
        citySelect.innerHTML = '<option value="">Select City</option>';
        stateSelect.disabled = true;
        citySelect.disabled = true;
        addressInput.value = '';

        if (!countryId) return;

        const url = GET_STATES_URL.replace(':id', countryId);

        fetch(url)
            .then(res => {
                if (!res.ok) throw new Error('Network error');
                return res.json();
            })
            .then(states => {
                stateSelect.disabled = false;
                states.forEach(state => {
                    stateSelect.innerHTML += `<option value="${state.id}">${state.name}</option>`;
                });
            })
            .catch(err => console.error(err));
    });

    stateSelect.addEventListener('change', function() {
        const stateId = this.value;

        citySelect.innerHTML = '<option value="">Select City</option>';
        citySelect.disabled = true;
        addressInput.value = '';

        if (!stateId) return;

        const url = GET_CITIES_URL.replace(':id', stateId);

        fetch(url)
            .then(res => {
                if (!res.ok) throw new Error('Network error');
                return res.json();
            })
            .then(cities => {
                citySelect.disabled = false;
                cities.forEach(city => {
                    citySelect.innerHTML += `<option value="${city.id}">${city.name}</option>`;
                });
            })
            .catch(err => console.error(err));
    });

    citySelect.addEventListener('change', function() {
        if (!this.value) return;

        const address = {
            country_id: countrySelect.value,
            country: countrySelect.options[countrySelect.selectedIndex].text,
            state_id: stateSelect.value,
            state: stateSelect.options[stateSelect.selectedIndex].text,
            city_id: this.value,
            city: this.options[this.selectedIndex].text
        };

        addressInput.value = JSON.stringify(address);
    });
</script>
<div class="text-end mt-3">
    <button type="button" class="btn ol-btn-primary next-tab" data-next="#v-pills-tab2-tab">
        {{ get_phrase('Next') }}
    </button>
</div>

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>
    CKEDITOR.replace('about_editor');
</script>
