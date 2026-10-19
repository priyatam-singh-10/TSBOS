@extends('layouts.default')
@push('title', get_phrase('Contact us'))
@push('meta')@endpush
@push('css')
<!-- intl-tel-input CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.19/build/css/intlTelInput.min.css">
<!-- Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
@endpush
@section('content')
    <!------------------- Breadcum Area Start  ------>
    <section class="breadcum-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="eNtry-breadcum">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ get_phrase('Home') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ get_phrase('Contact us') }}</li>
                            </ol>
                        </nav>
                        <h3 class="g-title">{{ get_phrase('Contact Us') }}</h3>
                    </div>
                </div>
            </div>
            <p class="showing-text mt-15">{{ get_phrase("We're always here to help you.") }}</p>
        </div>
    </section>
    <!------------------- Breadcum Area End  --------->

    <div class="eNtery-item">
    <div class="container">
        @php
            $contact_info = get_frontend_settings('contact_info');
            if ($contact_info) {
                $contact_info = json_decode($contact_info, true);
            } else {
                $contact_info = ['email' => '', 'phone' => '', 'address' => '', 'office_hours' => '', 'location' => ''];
            }
        @endphp
        
        <!-- Contact Form & Info -->
        <div class="row section-padding">
            <div class="col-lg-5 mb-4 mb-sm-0">
                <div class="contact-info-box">
                    <h3 class="mb-5 mt-3">{{ get_phrase('Get In Touch') }}</h3>
                    
                    <div class="info-item">
                        <div class="icon-wrapper">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="info-content">
                            <h5>{{ get_phrase('Phone') }}</h5>
                            <p><a href="tel:{{ $contact_info['phone'] }}">{{ $contact_info['phone'] }}</a></p>
                        </div>
                    </div>                    
                    <div class="info-item overflow-auto">
                        <div class="icon-wrapper">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-content">
                            <h5>{{ get_phrase('Email') }}</h5>
                            <p><a href="mailto:{{ $contact_info['email'] }}">{{ $contact_info['email'] }}</a></p>
                        </div>
                    </div>                    
                    <div class="info-item">
                        <div class="icon-wrapper">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="info-content">
                            <h5>{{ get_phrase('Address') }}</h5>
                            <!-- <p>{{ $contact_info['address'] }}</p> -->
                             <p>Opposite Metro Hexa, Opposite ICICI Bank, Kachna Phatak Road, Avanti Vihar, Raipur chhattisgarh, 492001</p>
                        </div>
                    </div>

                    <div>
                    <h4 class="mb-4">{{ get_phrase('Follow Us') }}</h4>
                    <ul class="f-socials d-flex">
                        <li>
                            <a href="https://www.facebook.com/profile.php?id=61586460730042" target="_black">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.instagram.com/tsbos_official/" target="_black">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.youtube.com/@SommnathBhattacharyaa-w6v" target="_black">
                                <i class="fa-brands fa-youtube"></i>
                            </a>
                        </li>
                    </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-7">
                <!-- Display success message -->
                @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Display error messages -->
                <!-- @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif -->

                <div class="contact-form-box">
                    <h4 class="g-title mb-4">{{ get_phrase('Send Message') }}</h4>
                    <form action="{{ route('contact.store') }}" method="post" class="global-form" id="contactForm">
                        @csrf
                        
                        <div class="form-group">
                            <label for="name" class="form-label">{{ get_phrase('Name') }}</label>
                            <input id="name" type="text" name="name" maxlength="50" class="form-control @error('name') border border-danger @enderror" placeholder="Your Name">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label">{{ get_phrase('Email') }}</label>
                                    <input id="email" type="email" name="email" maxlength="50" class="form-control @error('email') border border-danger @enderror" placeholder="Your Email">
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>                                
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone" class="form-label">{{ get_phrase('Phone') }}</label>
                                    <div>
                                    <input id="phone" type="tel" name="phone_display" maxlength="10" class="form-control @error('phone') border border-danger @enderror" placeholder="Your Phone">
                                    <!-- Hidden field for full phone number with country code -->
                                    <input type="hidden" name="phone" id="full_phone">
                                    </div>
                                    @error('phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="message" class="form-label">{{ get_phrase('Message') }}</label>
                            <textarea id="message" name="message" cols="30" rows="6" maxlength="500" class="form-control @error('message') border border-danger @enderror" placeholder="Your message here ..."></textarea>
                            @error('message')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="mt-3 btn-submit">
                            <i class="fas fa-paper-plane me-2"></i>{{ get_phrase('Send Message') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
    <!-- intl-tel-input JS (Compatible Version) -->
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.19/build/js/intlTelInput.min.js"></script>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script>
    let iti; // Global variable

    document.addEventListener("DOMContentLoaded", function() {
        // Initialize intl-tel-input
        const phoneInput = document.querySelector("#phone");
        const fullPhoneInput = document.getElementById("full_phone");
        
        iti = window.intlTelInput(phoneInput, {
            initialCountry: "in",
            preferredCountries: ["in", "us", "gb"],
            separateDialCode: true,
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.19/build/js/utils.js",
        });

        // Name validation - only letters and spaces
        const nameInput = document.querySelector('input[name="name"]');
        nameInput.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/[^a-zA-Z\s]/g, '');
            validateField(e.target, e.target.value.trim().length >= 2, 'Name must be at least 2 characters');
        });

        // Email validation
        const emailInput = document.querySelector('input[name="email"]');
        emailInput.addEventListener('blur', function(e) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            validateField(e.target, emailRegex.test(e.target.value), 'Please enter a valid email address');
        });

        // Phone validation - only digits
        phoneInput.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '');
        });

        // Phone validation on blur
        phoneInput.addEventListener('blur', function(e) {
            if (e.target.value.trim() !== '') {
                validatePhoneField();
            }
        });

        // Message validation
        const messageInput = document.querySelector('textarea[name="message"]');
        messageInput.addEventListener('blur', function(e) {
            validateField(e.target, e.target.value.trim().length >= 10, 'Message must be at least 10 characters');
        });

        // Form submit handler
        document.getElementById("contactForm").addEventListener("submit", function(e) {
            e.preventDefault(); // Prevent default submission
            
            let isValid = true;

            // Validate name
            if (nameInput.value.trim().length < 2) {
                showError(nameInput, 'Name must be at least 2 characters');
                isValid = false;
            }

            // Validate email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(emailInput.value)) {
                showError(emailInput, 'Please enter a valid email address');
                isValid = false;
            }

            // Validate phone number
            if (!iti.isValidNumber()) {
                showError(phoneInput, 'Please enter a valid phone number');
                toastr.error('Please enter a valid phone number');
                isValid = false;
            }

            // Validate message
            if (messageInput.value.trim().length < 10) {
                showError(messageInput, 'Message must be at least 10 characters');
                isValid = false;
            }

            // If all validations pass
            if (isValid) {
                // Get full phone number with country code
                const fullPhone = iti.getNumber();
                fullPhoneInput.value = fullPhone;
                
                // Submit form
                this.submit();
            }
        });

        // Helper function to validate field
        function validateField(field, condition, errorMessage) {
            if (condition) {
                removeError(field);
                return true;
            } else {
                showError(field, errorMessage);
                return false;
            }
        }

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

        // Helper function to show error
        function showError(field, message) {
            // Add error class
            field.classList.add('border', 'border-danger');
            
            // Remove existing error message if any
            const existingError = field.parentElement.querySelector('.error-message');
            if (existingError) {
                existingError.remove();
            }
            
            // Add new error message
            const errorDiv = document.createElement('small');
            errorDiv.className = 'text-danger error-message';
            errorDiv.textContent = message;
            field.parentElement.appendChild(errorDiv);
        }

        // Helper function to remove error
        function removeError(field) {
            field.classList.remove('border', 'border-danger');
            const errorMessage = field.parentElement.querySelector('.error-message');
            if (errorMessage) {
                errorMessage.remove();
            }
        }
    });
</script>
@endpush
