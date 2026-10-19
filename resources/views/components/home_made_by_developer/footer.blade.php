{{-- To make a editable image or text need to be add a "builder editable" class and builder identity attribute with a unique value --}}
{{-- builder identity and builder editable --}}
{{-- builder identity value have to be unique under a single file --}}

@if (get_frontend_settings('recaptcha_status'))
    @push('js')
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endpush
@endif

<footer class="footer-area">
    <div class="container">
        <div class="row justify-content-center pb-3">
            <div class="col-lg-8 text-center">
                <h4 class="footer-title mb-0 mb-sm-3">{{ get_phrase('Follow With Us') }}</h4>
                <div class="social-links-wrapper">
                    <a href="https://www.facebook.com/profile.php?id=61586460730042" target="_blank" aria-label="Facebook" class="social-link">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="https://www.instagram.com/tsbos_official/" target="_blank" aria-label="Instagram" class="social-link">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="https://www.youtube.com/@SommnathBhattacharyaa-w6v" target="_blank" aria-label="YouTube" class="social-link">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Legal Links Section -->
        <div class="row justify-content-center py-2">
            <div class="col-lg-10">
                <div class="legal-links-wrapper">
                    <a href="{{ route('privacy.policy') }}" class="legal-link">{{ get_phrase('Privacy Policy') }}</a>
                    <span class="separator">•</span>
                    <a href="{{ route('terms.condition') }}" class="legal-link">{{ get_phrase('Terms and Conditions') }}</a>
                    <span class="separator">•</span>
                    <a href="{{ route('disclaimer') }}" class="legal-link">{{ get_phrase('Disclaimer') }}</a>
                </div>
            </div>
        </div>

        <!-- Copyright Section -->
        <div class="row">
            <div class="col-12">
                <div class="copyright-section">
                    <p class="copyright-text mb-0 builder-editable" builder-identity="4">
                        © {{ date('Y') }} <a href="{{ get_settings('footer_link') ?? '#' }}" target="_blank" class="copyright-link px-1">
                            {{ get_settings('footer_text') ?? 'Kriscent Techno Hub Pvt. Ltd.' }}
                        </a>  - {{ get_phrase('All Rights Reserved') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>


@push('js')
    <script>
        "use strict";

        function onNewslaterSubmit(token) {
            document.getElementById("newslater-form").submit();
        }
    </script>
@endpush
