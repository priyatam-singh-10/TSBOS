@extends('layouts.default')
@push('title', get_phrase('My profile'))
@push('meta')@endpush
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.19/build/css/intlTelInput.min.css">

    <style>
        .iti {
            width: 100%;
        }
    </style>

@endpush
@php
    $savedAddress = !empty($user_details->address) ? json_decode($user_details->address, true) : null;

    $countries = DB::table('countries1')->select('id', 'name')->orderBy('name')->get();
@endphp
<script>
    const GET_STATES_URL = "{{ route('get.states', ':id') }}";
    const GET_CITIES_URL = "{{ route('get.cities', ':id') }}";
</script>
@section('content')
    <!------------ My profile area start  ------------>
    <section class="course-content">
        <div class="profile-banner-area"></div>
        <div class="container profile-banner-area-container">
            <div class="row">
                @include('frontend.default.student.left_sidebar')
                <div class="col-lg-9">

                    <div class="my-panel message-panel edit_profile mb-4">
                        <h4 class="g-title mb-5">{{ get_phrase('Personal Information') }}</h4>
                        <form action="{{ route('update.profile', $user_details->id) }}" method="POST">@csrf
                            <div class="row">
                                <div class="col-lg-6 mb-20">
                                    <div class="form-group">
                                        <label for="name" class="form-label">{{ get_phrase('Full Name') }}<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ $user_details->name }}" id="name">
                                    </div>
                                </div>
                                {{-- <div class="col-lg-6 mb-20">
                                    <div class="form-group">
                                        <label for="email" class="form-label">{{ get_phrase('Email Address') }}<span
                                                class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ $user_details->email }}" id="email">
                                    </div>
                                </div> --}}
                                <div class="col-lg-6 mb-20">
                                    <div class="form-group">
                                        <label for="phone" class="form-label">{{ get_phrase('Phone Number') }}<span
                                                class="text-danger">*</span></label>
                                        <!--<input type="tel" class="form-control" name="phone" value="{{ $user_details->phone }}" id="phone">-->
                                        <!-- Visible input -->
                                        <input type="tel" class="form-control" id="phone" readonly>

                                        <!-- Hidden input (actual DB value) -->
                                        <input type="hidden" name="phone" id="full_phone"
                                            value="{{ $user_details->phone }}">
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-20">
                                    <div class="form-group">

                                        <label class="form-label">{{ get_phrase('Address') }}</label>

                                        <!-- Country -->
                                        <select id="country" class="form-control mb-2">
                                            <option value="">Select Country</option>

                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ ($savedAddress['country_id'] ?? '') == $country->id ? 'selected' : '' }}>
                                                    {{ $country->name }}
                                                </option>
                                            @endforeach

                                        </select>

                                        <!-- State -->
                                        <select id="state" class="form-control mb-2">
                                            <option value="">Select State</option>
                                        </select>

                                        <!-- City -->
                                        <select id="city" class="form-control mb-2">
                                            <option value="">Select City</option>
                                        </select>

                                        <!-- FINAL ADDRESS -->
                                        <input type="hidden" name="address" id="user-address"
                                            value="{{ $user_details->address ?? '' }}">

                                    </div>
                                </div>
                                <div class="d-none col-lg-6 mb-20">
                                    <div class="form-group">
                                        <label for="website" class="form-label">{{ get_phrase('Website') }}</label>
                                        <input type="text" class="form-control" name="website"
                                            value="{{ $user_details->website }}" id="website">
                                    </div>
                                </div>
                                <div class="d-none col-lg-6 mb-20">
                                    <div class="form-group">
                                        <label for="facebook" class="form-label">{{ get_phrase('Facebook') }}</label>
                                        <input type="text" class="form-control" name="facebook"
                                            value="{{ $user_details->facebook }}" id="facebook">
                                    </div>
                                </div>
                                <div class="d-none col-lg-6 mb-20">
                                    <div class="form-group">
                                        <label for="twitter" class="form-label">{{ get_phrase('Twitter') }}</label>
                                        <input type="text" class="form-control" name="twitter"
                                            value="{{ $user_details->twitter }}" id="twitter">
                                    </div>
                                </div>
                                <div class="d-none col-lg-6 mb-20">
                                    <div class="form-group">
                                        <label for="linkedin" class="form-label">{{ get_phrase('Linkedin') }}</label>
                                        <input type="text" class="form-control" name="linkedin"
                                            value="{{ $user_details->linkedin }}" id="linkedin">
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-20 d-none">
                                    <div class="form-group">
                                        <label for="skills" class="form-label">{{ get_phrase('Skills') }}</label>
                                        <input type="text" class="form-control tagify" name="skills"
                                            data-role="tagsinput" value="{{ $user_details->skills }}" id="skills">
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-20 d-none">
                                    <div class="form-group">
                                        <label for="biography" class="form-label">{{ get_phrase('Biography') }}</label>
                                        <textarea name="biography" class="form-control" id="biography" cols="30" rows="5">{{ $user_details->biography }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <button class="eBtn btn gradient mt-10">{{ get_phrase('Save Changes') }}</button>
                        </form>
                    </div>

                    {{-- <div class="my-panel message-panel edit_profile">
                        <h4 class="g-title mb-5">{{ get_phrase('Change Password') }}</h4>
                        <form action="{{ route('password.change') }}" method="POST">@csrf
                            <div class="row">
                                <div class="col-lg-12 mb-20">
                                    <div class="form-group">
                                        <label class="form-label">{{ get_phrase('Current password') }}</label>
                                        <input type="password" class="form-control" name="current_password" required>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-20">
                                    <div class="form-group">
                                        <label class="form-label">{{ get_phrase('New password') }}</label>
                                        <input type="password" class="form-control" name="new_password" required>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-20">
                                    <div class="form-group">
                                        <label class="form-label">{{ get_phrase('Confirm password') }}</label>
                                        <input type="password" class="form-control" name="confirm_password" required>
                                    </div>
                                </div>
                            </div>
                            <button class="eBtn btn gradient mt-10">{{ get_phrase('Update password') }}</button>
                        </form>
                    </div> --}}
                </div>

            </div>
        </div>
    </section>
    <!------------ My profile area end  ------------>
@endsection
@push('js')


    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.19/build/js/intlTelInput.min.js"></script>

    <script>
        "use strict";

        document.addEventListener("DOMContentLoaded", function() {

            const phoneInput = document.querySelector("#phone");
            const fullPhoneInput = document.getElementById("full_phone");
            const form = phoneInput.closest("form");

            const iti = window.intlTelInput(phoneInput, {
                preferredCountries: ["in", "us", "gb"],
                separateDialCode: true,
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.19/build/js/utils.js",
            });

            // vERY IMPORTANT PART
            // Set number from DB (+919023432345)
            if (fullPhoneInput.value) {
                iti.setNumber(fullPhoneInput.value);
            }

            // On submit store full E.164 format again
            form.addEventListener("submit", function(e) {

                if (iti.isValidNumber()) {
                    fullPhoneInput.value = iti.getNumber();
                } else {
                    e.preventDefault();
                    alert("Please enter a valid phone number");
                    phoneInput.focus();
                }
            });

        });
    </script>
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
                .then(res => res.json())
                .then(states => {

                    stateSelect.innerHTML = '<option value="">Select State</option>';

                    states.forEach(state => {

                        const selected = selectedState == state.id ? 'selected' : '';

                        stateSelect.innerHTML +=
                            `<option value="${state.id}" ${selected}>${state.name}</option>`;

                    });

                    if (selectedState) {
                        loadCities(selectedState, savedAddress?.city_id);
                    }

                });

        }


        // Load cities
        function loadCities(stateId, selectedCity = null) {

            if (!stateId) return;

            const url = GET_CITIES_URL.replace(':id', stateId);

            fetch(url)
                .then(res => res.json())
                .then(cities => {

                    citySelect.innerHTML = '<option value="">Select City</option>';

                    cities.forEach(city => {

                        const selected = selectedCity == city.id ? 'selected' : '';

                        citySelect.innerHTML +=
                            `<option value="${city.id}" ${selected}>${city.name}</option>`;

                    });

                });

        }


        // EVENTS
        countrySelect.addEventListener('change', function() {

            stateSelect.innerHTML = '<option value="">Select State</option>';
            citySelect.innerHTML = '<option value="">Select City</option>';

            loadStates(this.value);

        });


        stateSelect.addEventListener('change', function() {

            citySelect.innerHTML = '<option value="">Select City</option>';

            loadCities(this.value);

        });


        citySelect.addEventListener('change', function() {

            if (!this.value) return;

            addressInput.value = JSON.stringify({

                country_id: countrySelect.value,
                country: countrySelect.options[countrySelect.selectedIndex].text,

                state_id: stateSelect.value,
                state: stateSelect.options[stateSelect.selectedIndex].text,

                city_id: this.value,
                city: this.options[this.selectedIndex].text

            });

        });


        // Prefill address (edit mode)

        if (savedAddress?.country_id) {
            loadStates(savedAddress.country_id, savedAddress.state_id);
        }
    </script>

@endpush
