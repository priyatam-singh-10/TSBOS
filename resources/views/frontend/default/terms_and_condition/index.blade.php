@extends('layouts.default')
@push('title', get_phrase('Terms and condition'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
<!-- Breadcrumb Area Start -->
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
                            <li class="breadcrumb-item active" aria-current="page">{{ get_phrase('Terms') }}</li>
                        </ol>
                    </nav>
                    <h1 class="in-title-44px">{{ get_phrase('Terms And Condition') }}</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Area End -->

    <!-- Start About Us -->
    <!--<section class="course-details-wraper pb-120 pt-30">-->
    <!--    <div class="container description-style">-->
    <!--        {!! htmlspecialchars_decode(removeScripts(get_frontend_settings('terms_and_condition'))) !!}-->
    <!--    </div>-->
    <!--</section>-->
    <!-- End About Us -->
    
    <!-- Content Section -->
    <section class="terms-content section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="terms-card">
                        <div class="intro-text">
                            <p><strong>By accessing or using our website, you agree to the following Terms & Conditions.</strong></p>
                        </div>

                        <!-- Section 1 -->
                        <div class="section-item">
                            <h2 class="termsTitle">
                                <span class="section-number">1</span>
                                Nature of Services
                            </h2>
                            <div class="section-content">
                                <p>We provide educational content, live classes, webinars, and recorded courses related to occult sciences such as Face Reading, Numerology, and Graphology.</p>
                                <p>These services are for educational and informational purposes only.</p>
                            </div>
                        </div>

                        <!-- Section 2 -->
                        <div class="section-item">
                            <h2 class="termsTitle">
                                <span class="section-number">2</span>
                                No Guarantee of Results
                                <span class="important-badge">Very Important</span>
                            </h2>
                            <div class="section-content">
                                <div class="highlight-box">
                                    <p><i class="fas fa-exclamation-triangle me-2"></i> Occult sciences are interpretative in nature. We do not guarantee any specific results, outcomes, or predictions. Any guidance provided is based on traditional knowledge and personal interpretation.</p>
                                </div>
                                <p>Users must apply their own judgment before acting on any information.</p>
                            </div>
                        </div>

                        <!-- Section 3 -->
                        <div class="section-item">
                            <h2 class="termsTitle">
                                <span class="section-number">3</span>
                                User Account
                            </h2>
                            <div class="section-content">
                                <ul>
                                    <li>You must provide accurate information while registering</li>
                                    <li>You are responsible for maintaining the confidentiality of your login credentials</li>
                                    <li>One account is for one user only. Sharing access is strictly prohibited</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Section 4 -->
                        <div class="section-item">
                            <h2 class="termsTitle">
                                <span class="section-number">4</span>
                                Payments & Refund Policy
                            </h2>
                            <div class="section-content">
                                <ul>
                                    <li>All course purchases are final</li>
                                    <li>No refunds will be provided once access to a live class, webinar, or recorded course is granted</li>
                                    <li>In case of technical issues from our side, we may provide alternative access at our discretion</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Section 5 -->
                        <div class="section-item">
                            <h2 class="termsTitle">
                                <span class="section-number">5</span>
                                Access to Content
                            </h2>
                            <div class="section-content">
                                <ul>
                                    <li>Recorded courses are for personal use only</li>
                                    <li>Downloading, screen recording, sharing, or redistributing content is strictly prohibited</li>
                                    <li>Violation may lead to legal action and account termination</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Section 6 -->
                        <div class="section-item">
                            <h2 class="termsTitle">
                                <span class="section-number">6</span>
                                Live Class & Webinar Conduct
                            </h2>
                            <div class="section-content">
                                <p>We reserve the right to remove any participant who behaves inappropriately during live sessions.</p>
                            </div>
                        </div>

                        <!-- Section 7 -->
                        <div class="section-item">
                            <h2 class="termsTitle">
                                <span class="section-number">7</span>
                                Intellectual Property
                            </h2>
                            <div class="section-content">
                                <p>All course materials, videos, documents, logos, and content belong to The Sommnath Bhattacharyaa Occult Sciences. Unauthorized use is prohibited.</p>
                            </div>
                        </div>

                        <!-- Section 8 -->
                        <div class="section-item">
                            <h2 class="termsTitle">
                                <span class="section-number">8</span>
                                Limitation of Liability
                            </h2>
                            <div class="section-content">
                                <p>We are not liable for:</p>
                                <ul>
                                    <li>Personal decisions made based on course content</li>
                                    <li>Technical issues from the user's internet/device</li>
                                    <li>Any direct or indirect loss arising from use of our platform</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Section 9 -->
                        <div class="section-item">
                            <h2 class="termsTitle">
                                <span class="section-number">9</span>
                                Termination of Account
                            </h2>
                            <div class="section-content">
                                <p>We reserve the right to suspend or terminate accounts for:</p>
                                <ul>
                                    <li>Misuse of content</li>
                                    <li>Policy violations</li>
                                    <li>Payment disputes or fraud</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Section 10 -->
                        <div class="section-item">
                            <h2 class="termsTitle">
                                <span class="section-number">10</span>
                                Governing Law
                            </h2>
                            <div class="section-content">
                                <p>These terms shall be governed by the laws of India. Any disputes shall be subject to the jurisdiction of Mumbai, Maharashtra courts.</p>
                            </div>
                        </div>

                        <!-- Section 11 - Contact -->
                        <div class="contact-box">
                            <h3>For any queries, contact us at:</h3>
                            
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
    
    
@endsection
@push('js')@endpush
