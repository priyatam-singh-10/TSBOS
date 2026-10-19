@extends('layouts.' . get_frontend_settings('theme'))
@push('title', get_phrase('Sign Up'))
@push('meta')@endpush
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.19/build/css/intlTelInput.min.css">
    <style>
        .iti {
            width: 100%;
        }

        .form-icons .right {
            right: 20px;
            cursor: pointer !important;
        }

        .login-area .iti {
            width: 100%;
        }

        .login-area .btn.gradient {
            padding: 12px 9px;
            min-width: 100px;
            font-size: 13px;
            color: #fff;
            font-weight: 800;
            border-radius: 9px;
        }
    </style>
@endpush
@section('content')
    <section class="login-area section-padding">
        <div class="container">
            <div class="login-container">
                <div class="login-card">
                    <form action="{{ route('student.register') }}" class="global-form login-form" id="login-form" method="post"
                        enctype="multipart/form-data">@csrf
                        <div class="text-center">
                            <h4 class="g-title">{{ get_phrase('Sign Up') }}</h4>
                            <p class="description">{{ get_phrase('See your growth and get consulting support! ') }}</p>
                        </div>
                        <div class="form-group mb-4">
                            <label for="" class="form-label">{{ get_phrase('Name') }}<span
                                    class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Your Name" required
                                maxlength="50" oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '')">

                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label">{{ get_phrase('Phone') }}<span class="text-danger">*</span></label>

                            <div class="d-flex">
                                <input id="phone" type="tel" name="phone_display" class="form-control w-100"
                                    placeholder="Your Phone" required
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,10)">

                                {{-- <button type="button" id="sendOtpBtn" class="btn gradient">
                                    Send OTP
                                </button> --}}
                            </div>

                            <input type="hidden" name="phone" id="full_phone">
                        </div>
                        <div class="form-group mb-4">
                            <label for="" class="form-label">{{ get_phrase('Password') }}<span
                                    class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="Your Password" required
                                maxlength="100" oninput="this.value = this.value.replace(/\s/g, '')">

                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div id="otpSection" style="display:none;" class="mb-4">

                            <label class="form-label">Enter OTP</label>

                            <div style="display:flex; gap:10px; margin-bottom:10px;">
                                <input type="text" maxlength="1" class="form-control otp-box">
                                <input type="text" maxlength="1" class="form-control otp-box">
                                <input type="text" maxlength="1" class="form-control otp-box">
                                <input type="text" maxlength="1" class="form-control otp-box">
                            </div>

                            <input type="hidden" id="otp_value">
                            <div class="text-center">
                                <button type="button" id="verifyOtpBtn" class="btn gradient">
                                    Verify OTP
                                </button>
                            </div>

                        </div>

                        @if (get_frontend_settings('recaptcha_status'))
                            <button class="eBtn gradient w-100 g-recaptcha"
                                data-sitekey="{{ get_frontend_settings('recaptcha_sitekey') }}"
                                data-callback='onLoginSubmit' data-action='submit'>{{ get_phrase('Sign Up') }}</button>
                        @else
                            <button type="submit" class="btn-submit w-100">{{ get_phrase('Sign Up') }}</button>
                        @endif

                        <p class="mt-20">{{ get_phrase('Already have account?') }} <a
                                href="{{ route('student.login.form') }}">{{ get_phrase('Sign in') }}</a></p>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <!-- intl-tel-input JS (Compatible Version) -->
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.19/build/js/intlTelInput.min.js"></script>
    <script>
        "use strict";

        let iti; // Global variable

        document.addEventListener("DOMContentLoaded", function() {

            // Initialize intl-tel-input
            const phoneInput = document.querySelector("#phone");
            const fullPhoneInput = document.getElementById("full_phone");
            const form = document.getElementById("login-form");

            iti = window.intlTelInput(phoneInput, {
                initialCountry: "in",
                preferredCountries: ["in", "us", "gb"],
                separateDialCode: true,
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.19/build/js/utils.js",
            });

            // UPDATED: Set full phone number only on form submit
            form.addEventListener("submit", function(e) {

                if (iti.isValidNumber()) {
                    const fullPhone = iti.getNumber(); // with country code
                    fullPhoneInput.value = fullPhone;
                } else {
                    e.preventDefault();
                    alert('Please enter a valid phone number');
                    phoneInput.focus();
                    return false;
                }
            });

            // Helper function to validate phone
            function validatePhoneField() {
                if (iti.isValidNumber()) {
                    removeError(phoneInput);
                    return true;
                } else {
                    showError(phoneInput, 'Please enter a valid phone number');
                    return false;
                }
            }

            function onLoginSubmit(token) {
                document.getElementById("login-form").submit();
            }


        });

        // SEND OTP
        document.getElementById("sendOtpBtn").addEventListener("click", function() {

            if (iti.isValidNumber()) {

                let phone = iti.getNumber();
                document.getElementById("full_phone").value = phone;

                fetch("{{ route('student.register.sendOtp') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            phone: phone
                        })
                    })
                    .then(res => res.json())
                    .then(data => {

                        document.getElementById("otpSection").style.display = "block";

                        startOtpCooldown();

                        alert("OTP Sent Successfully");

                    });

            } else {
                alert("Enter valid phone number");
            }

        });

        let sendOtpBtn = document.getElementById("sendOtpBtn");
        let cooldown = 60;

        function startOtpCooldown() {

            sendOtpBtn.disabled = true;

            let timer = setInterval(function() {

                cooldown--;

                sendOtpBtn.innerText = "Resend OTP (" + cooldown + "s)";

                if (cooldown <= 0) {

                    clearInterval(timer);

                    sendOtpBtn.disabled = false;

                    sendOtpBtn.innerText = "Send OTP";

                    cooldown = 60;
                }

            }, 1000);

        }

        let otpInputs = document.querySelectorAll(".otp-box");

        otpInputs.forEach((input, index) => {

            input.addEventListener("input", function() {

                if (this.value.length === 1) {

                    if (index < otpInputs.length - 1) {

                        otpInputs[index + 1].focus();

                    }

                }

            });

        });
        // VERIFY OTP
        document.getElementById("verifyOtpBtn").addEventListener("click", function() {

            let otpBoxes = document.querySelectorAll(".otp-box");

            let otp = "";

            otpBoxes.forEach(function(box) {
                otp += box.value;
            });

            document.getElementById("otp_value").value = otp;

            let phone = document.getElementById("full_phone").value;

            fetch("{{ route('student.signup.verify.otp') }}", {

                    method: "POST",

                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },

                    body: JSON.stringify({
                        phone: phone,
                        otp: otp
                    })

                })
                .then(res => res.json())
                .then(data => {

                    if (data.status) {

                        alert("OTP Verified Successfully");

                        document.getElementById("verifyOtpBtn").disabled = true;

                        document.getElementById("verifyOtpBtn").innerText = "Verified ✓";

                    } else {

                        alert("Invalid OTP");

                    }

                });

        });
    </script>

@endpush
