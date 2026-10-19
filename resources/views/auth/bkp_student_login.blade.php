@extends('layouts' . '.' . get_frontend_settings('theme'))
@push('title', get_phrase('Login'))

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
    <section class="login-area section-padding sam">
        <div class="container">
            <div class="login-container">
                <div class="login-card">

                    <form method="POST" action="{{ route('student.login') }}" id="login-form">
                        @csrf

                        <!-- STEP 1 -->
                        <div id="phoneSection">

                            <div class="form-group">
                                <label>Phone Number</label>

                                <!--  ONLY PHONE INPUT (dial_code removed) -->
                                <input type="text" id="phone" class="form-control mt-3" placeholder="Enter phone"
                                    maxlength="10" inputmode="numeric" oninput="this.value = this.value.replace(/\D/g, '')"
                                    required>
                            </div>

                            <button type="button" id="sendOtpBtn" class="btn-submit w-100 mt-3" onclick="sendOtp()">
                                Send OTP
                            </button>

                            <p class="mt-20">
                                {{ get_phrase('Not have an account yet?') }}
                                <span style="color:#c88e37">
                                    <a href="{{ route('student.register.form') }}">
                                        {{ get_phrase('Create Account') }}
                                    </a>
                                </span>
                            </p>
                        </div>

                        <div id="otpSection" style="display:none;">
                            <div class="form-group mt-3">
                                <label>Enter OTP</label>

                                <div class="otp-container">
                                    <input type="text" maxlength="1" class="otp-input" inputmode="numeric" />
                                    <input type="text" maxlength="1" class="otp-input" inputmode="numeric" />
                                    <input type="text" maxlength="1" class="otp-input" inputmode="numeric" />
                                    <input type="text" maxlength="1" class="otp-input" inputmode="numeric" />
                                </div>

                                <input type="hidden" name="otp" id="otp">

                                <!--  FINAL PHONE -->
                                <input type="hidden" name="phone" id="full_phone">
                            </div>

                            <button type="submit" class="btn-submit w-100 mt-5">
                                Verify & Login
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </section>
@endsection


@push('js')
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.19/build/js/intlTelInput.min.js"></script>

    <script>
        document.getElementById("phone").addEventListener("keydown", function(e) {
            if (e.key === "Enter") {
                e.preventDefault(); // stop submit
                sendOtp(); // call OTP instead
            }
        });
        "use strict";

        let iti;

        document.addEventListener("DOMContentLoaded", function() {

            const phoneInput = document.querySelector("#phone");

            iti = window.intlTelInput(phoneInput, {
                initialCountry: "in",
                preferredCountries: ["in", "us", "gb"],
                separateDialCode: true,
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.19/build/js/utils.js",
            });

        });


        function sendOtp() {

            let btn = document.getElementById('sendOtpBtn');
            let phoneInput = document.getElementById('phone');

            // intl validation
            if (!iti.isValidNumber()) {
                alert("Enter valid phone number");
                phoneInput.focus();
                return;
            }

            btn.disabled = true;
            btn.innerText = "Sending...";

            let full_phone = iti.getNumber(); // full number with country code

            document.getElementById("full_phone").value = full_phone;

            fetch("{{ route('send.otp') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        phone: full_phone
                    })
                })
                .then(res => res.json())
                .then(data => {

                    if (data.status === true) {

                        document.getElementById("phoneSection").style.display = "none";
                        document.getElementById("otpSection").style.display = "block";

                    } else {

                        alert(data.message);
                        btn.disabled = false;
                        btn.innerText = "Send OTP";
                    }

                })
                .catch(err => {

                    alert("Something went wrong");
                    btn.disabled = false;
                    btn.innerText = "Send OTP";

                });
        }


        // OTP logic same
        document.querySelectorAll('.otp-input').forEach((input, index, inputs) => {

            input.addEventListener('input', function() {

                this.value = this.value.replace(/[^0-9]/g, '');

                if (this.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }

                updateOtp();
            });

            input.addEventListener('keydown', function(e) {

                if (e.key === "Backspace" && this.value === "" && index > 0) {
                    inputs[index - 1].focus();
                }

            });

        });

        function updateOtp() {

            let otp = "";

            document.querySelectorAll('.otp-input').forEach(input => {
                otp += input.value;
            });

            document.getElementById('otp').value = otp;

        }
    </script>
@endpush
