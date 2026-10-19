@extends('layouts.default')
@push('title', get_phrase('Privacy Policy'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <!-- Start Breadcrumb -->
    <section class="AboutUs breadcum-area mb-30px">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-14px lms1-breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="d-flex align-items-center gap-12px">
                                        <i class="fas fa-house"></i>
                                        <span>{{ get_phrase('Home') }}</span>
                                    </a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ get_phrase('Privacy Policy') }}</li>
                            </ol>
                        </nav>
                        <h1 class="in-title-44px">{{ get_phrase('Privacy Policy') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Breadcrumb -->

    <!-- Start About Us -->
    <!--<section class="course-details-wraper pb-120 pt-30">-->
    <!--    <div class="container description-style">-->
    <!--        {!! htmlspecialchars_decode(removeScripts(get_frontend_settings('privacy_policy'))) !!}-->
    <!--    </div>-->
    <!--</section>-->
    
     <section class="terms-content section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="terms-card">
                        <div class="intro-section">
                            <h3>About Our Privacy Commitment</h3>
                            <p>The Sommnath Bhattacharyaa Occult Sciences operates an online Learning Management System (LMS) that provides live classes, webinars, and recorded courses related to Face Reading, Name &amp; Number Numerology, Graphology, and other occult sciences.</p>
                            <p>We respect your privacy and are committed to protecting your personal information in accordance with applicable laws of India, including the <strong>Information Technology Act, 2000</strong>.</p>
                        </div>

                        <!-- Section 1 -->
                        <div class="section-item">
                            <h2 class="termsTitle">
                                <span class="section-number">1</span>
                                Information We Collect
                            </h2>
                            <div class="section-content">
                                <p>We may collect the following information when you use our website/app:</p>
                                <ul>
                                  <li>Full Name</li>
                                  <li>Email Address</li>
                                  <li>Phone Number</li>
                                  <li>Billing Address</li>
                                  <li>Payment details (processed securely via payment gateway)</li>
                                  <li>Profile information</li>
                                  <li>IP address and device information</li>
                                  <li>Usage data of courses, webinars, and live classes</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Section 2 -->
                        <div class="section-item">
                            <h2 class="termsTitle">
                                <span class="section-number">2</span>
                                How We Use Your Information
                            </h2>
                            <div class="section-content">
                                <p>Your information is used to:</p>
                                <ul>
                                  <li>Create and manage your account</li>
                                  <li>Provide access to live classes, webinars, and recorded courses</li>
                                  <li>Process payments and invoices</li>
                                  <li>Send important updates, class reminders, and course information</li>
                                  <li>Improve our services and user experience</li>
                                  <li>Provide customer support</li>
                                </ul>

                            </div>
                        </div>

                        <!-- Section 3 -->
                        <div class="section-item">
                            <h2 class="termsTitle">
                                <span class="section-number">3</span>
                                Payment Information
                            </h2>
                            <div class="section-content">
                                <div class="info-badge">
                                    <p><i class="fas fa-shield-alt"></i> All payments are processed through secure third-party payment gateways. We do not store your card or banking details on our servers.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Section 4 -->
                        <div class="section-item">
                            <h2 class="termsTitle">
                                <span class="section-number">4</span>
                                Data Sharing
                            </h2>
                            <div class="section-content">
                                <p>We do not sell, rent, or trade your personal data. Information may only be shared with:</p>
                                <ul>
                                  <li>Payment gateway partners</li>
                                  <li>Technical service providers for platform operation</li>
                                  <li>Legal authorities if required by law</li>
                                </ul>

                            </div>
                        </div>

                        <!-- Section 5 -->
                        <div class="section-item">
                            <h2 class="termsTitle">
                                <span class="section-number">5</span>
                                Recording of Live Sessions
                            </h2>
                            <div class="section-content">
                                <p>Live classes and webinars may be recorded for educational and quality purposes. By attending, you consent to such recordings.</p>
                            </div>
                        </div>

                        <!-- Section 6 -->
                        <div class="section-item">
                            <h2 class="termsTitle">
                                <span class="section-number">6</span>
                                Data Security
                            </h2>
                            <div class="section-content">
                                <p>We implement reasonable technical and organizational measures to protect your data from unauthorized access, misuse, or disclosure.</p>
                                <div class="info-badge">
                                    <p><i class="fas fa-lock"></i> Your data is encrypted and stored securely using industry-standard security protocols.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Section 7 -->
                        <div class="section-item">
                            <h2 class="termsTitle">
                                <span class="section-number">7</span>
                                Cookies & Tracking
                            </h2>
                            <div class="section-content">
                                <p>We may use cookies and tracking tools to improve user experience and analyze platform performance.</p>
                            </div>
                        </div>

                        <!-- Section 8 -->
                        <div class="section-item">
                            <h2 class="termsTitle">
                                <span class="section-number">8</span>
                                User Rights
                            </h2>
                            <div class="section-content">
                                <p>You may request to:</p>
                                <ul>
                                  <li>Access your data</li>
                                  <li>Correct your data</li>
                                  <li>Delete your account and data</li>
                                </ul>
                                <p>By contacting us at: <strong>thesommnathbhattacharyaa@gmail.com</strong></p>
                            </div>
                        </div>

                        <!-- Section 9 -->
                        <div class="section-item">
                            <h2 class="termsTitle">
                                <span class="section-number">9</span>
                                Children's Privacy
                            </h2>
                            <div class="section-content">
                                <div class="info-badge">
                                    <p><i class="fas fa-child"></i> Our services are not intended for individuals below 18 years of age.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Section 10 -->
                        <div class="section-item">
                            <h2 class="termsTitle">
                                <span class="section-number">10</span>
                                Changes to Privacy Policy
                            </h2>
                            <div class="section-content">
                                <p>We reserve the right to update this policy. Continued use of the platform implies acceptance of changes.</p>
                            </div>
                        </div>

                        <!-- Section 11 - Contact -->
                        <div class="contact-box">
                            <h3><i class="fas fa-envelope me-3"></i>Contact Us for Privacy Concerns</h3>
                            
                            <div class="contact-item">
                                <i class="fas fa-envelope"></i>
                                <div class="contact-item-content overflow-auto">
                                    <h5>Email</h5>
                                    <p><a href="mailto:thesommnathbhattacharyaa@gmail.com">thesommnathbhattacharyaa@gmail.com</a></p>
                                </div>
                            </div>

                            <div class="contact-item mb-0">
                                <i class="fas fa-map-marker-alt"></i>
                                <div class="contact-item-content">
                                    <h5>Address</h5>
                                    <p>Opposite Metro Hexa, Opposite ICICI Bank, Kachna Phatak Road,<br>Avanti Vihar, Raipur, Chhattisgarh - 492001, India</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- End About Us -->
@endsection
@push('js')@endpush
