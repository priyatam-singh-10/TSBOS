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
            margin-top: 12px;
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

                    <form method="POST" action="{{ route('student.update.password') }}" id="login-form">
                        @csrf

                        <div class="form-group mb-4">
                            <label>Phone Number</label> <span class="text-danger">*</span>
                            <input type="text" name="phone" id="phone" class="form-control mt-3"
                                placeholder="Enter phone" maxlength="10" inputmode="numeric"
                                oninput="this.value = this.value.replace(/\D/g, '')" required>
                        </div>

                        {{-- <div class="mb-3">
                            <label>Mobile Number</label>
                            <input type="text" name="mobile" class="form-control" required>
                        </div> --}}

                        <div class="mb-3">
                            <label>New Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn-submit w-100 mt-3">
                            Reset Password
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </section>
@endsection


@push('js')
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.19/build/js/intlTelInput.min.js"></script>

    <script>
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

            // Form submit hone se pehle country code add kar do
            document.getElementById('login-form').addEventListener('submit', function() {
                phoneInput.value = iti.getNumber(); // +919876543210
            });

        });
    </script>
@endpush
