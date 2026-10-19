@extends('layouts.default')
@push('title', get_phrase('Home'))
@push('meta')@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/lexend-deca/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/outfit/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/mulish/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/Poppins/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/dm-sens/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/rubik/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/montserrat/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/ubuntu/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/lato/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/manrope/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/mica-valo/stylesheet.css') }}">
    <style>
        /* ─── Timer Pill ─── */

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.02);
            }
        }

        /* ─── Responsive ─── */
        @media (max-width: 576px) {
            .btn-label {
                font-size: 1rem;
                padding: 0 20px 0 15px;
            }

            .hex-wrapper {
                width: 48px;
                height: 42px;
            }

            .hex-text .amount {
                font-size: 1.5rem;
            }
        }
    </style>
@endpush
@section('content')
    <!-- Hero Section -->
    <section class="hero-section" id="home">
        <div class="hero-decorative-blob blob-1"></div>
        <div class="hero-decorative-blob blob-2"></div>
        <div class="hero-decorative-blob blob-3"></div>

        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <div class="hero-badge">
                        <i class="fas fa-star"></i>
                        Live Interactive Webinar
                    </div>

                    <h1 class="hero-title">
                        Transform Your Life with
                    </h1>

                    <p class="hero-subtitle">
                        Face Reading, Graphology, Name Numerology & Mobile Numerology to unlock success, wealth, health, and
                        happiness in just 2 hours.
                    </p>

                    <div class="hero-features">
                        <div class="hero-feature-item">
                            <i class="fas fa-user-graduate"></i>
                            <span>No Experience Needed</span>
                        </div>
                        <div class="hero-feature-item">
                            <i class="fas fa-video"></i>
                            <span>Live on Zoom</span>
                        </div>
                        <div class="hero-feature-item">
                            <i class="fas fa-clock"></i>
                            <span>2-Hour Workshop</span>
                        </div>
                        <div class="hero-feature-item">
                            <i class="fas fa-language"></i>
                            <span>Hindi & English</span>
                        </div>
                    </div>
                    <div class="hero-cta-section">
                        <a href="{{ route('webinars') }}" class="btn-primary-custom">
                            <div class="hex-wrapper">
                                <svg viewBox="0 0 100 115" xmlns="http://www.w3.org/2000/svg">
                                    <polygon points="50,2 98,26 98,89 50,113 2,89 2,26" fill="#F9D058" />
                                </svg>
                                <div class="hex-text">
                                    <span class="rupee">₹</span>
                                    <span class="amount">51</span>
                                </div>
                            </div>
                            <div class="btn-label">
                                Reserve Your Seat Now
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>
                        <div class="price-label">
                            ⏳ Limited Time Offer – Ends Soon!
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 hero-image-container">
                    <div class="hero-visual">
                        <img class="builder-editable" builder-identity="8"
                            src="{{ asset('assets/frontend/default/image/hero.webp') }}" alt="">

                        <div class="hero-stats-floating stat-top-left">
                            <h4>60,000+</h4>
                            <p>Lives Transformed</p>
                        </div>

                        <div class="hero-stats-floating stat-bottom-right">
                            <h4>15,000+</h4>
                            <p>Students Trained</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="transform-section info-section section-padding">
        <div class="container">
            <div class="text-center">
                <h2 class="section-title">Transform Your Life</h2>
                <p class="section-subtitle">Master ancient sciences for modern success</p>
            </div>

            <div class="bento-grid">
                <div class="bento-card">
                    <h4>Master 4 Sciences</h4>
                    <ul class="bento-list">
                        <li><i class="fas fa-check"></i> Face Reading</li>
                        <li><i class="fas fa-check"></i> Graphology</li>
                        <li><i class="fas fa-check"></i> Mobile Numerology</li>
                        <li><i class="fas fa-check"></i> Name Numerology</li>
                    </ul>
                </div>

                <div class="bento-card">
                    <h4>Numerology Hacks</h4>
                    <ul class="bento-list">
                        <li><i class="fas fa-heart"></i> Love</li>
                        <li><i class="fas fa-heartbeat"></i> Health</li>
                        <li><i class="fas fa-gem"></i> Prosperity</li>
                    </ul>
                </div>

                <div class="bento-card">
                    <h4>Enhance Relationships</h4>
                    <ul class="bento-list">
                        <li><i class="fas fa-eye"></i> Face Reading</li>
                        <li><i class="fas fa-mobile-alt"></i> Mobile Numerology</li>
                        <li><i class="fas fa-signature"></i> Name Numerology</li>
                    </ul>
                </div>

                <div class="bento-card">
                    <h4>Apply Remedies For</h4>
                    <ul class="bento-list">
                        <li><i class="fas fa-spa"></i> Physical Well-being</li>
                        <li><i class="fas fa-brain"></i> Mental Well-being</li>
                        <li><i class="fas fa-smile"></i> Emotional Well-being</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Face Reading -->
    <section class="info-section section-padding bg-accent faceReading">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">What Is Face Reading?</h2>
                <p class="section-subtitle">Also known as Physiognomy - A 3000-year-old science</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="face-card">
                        <div class="modern-icon green-radient">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h3>What It IS</h3>
                        <p class="pb-4"><strong>Face Reading</strong> is the way of reading nature, personality, and life
                            of yourself or any other person. It is around 3000 years old skill.</p>
                        <p>Every face is beautiful, and everything on face has some meaning.</p>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="face-card">
                        <div class="modern-icon red-gradient">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <h3>What It's NOT</h3>
                        <p class="pb-4"><strong>Not Magic:</strong> It is a super-powerful skill that follows a 100%
                            accurate and proven system.</p>
                        <p><strong>Not About Expressions:</strong> Face reading analyzes permanent facial features, not
                            temporary expressions.</p>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="image-card">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=600&fit=crop"
                            alt="Face Reading">
                        <div class="image-overlay">
                            <h4>Decode Every Face</h4>
                            <p>Learn to read personality, nature, and life patterns scientifically</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Graphology -->
    <section class="graphology info-section section-padding">
        <div class="container">
            <div class="text-center">
                <h2 class="section-title">Graphology</h2>
                <p class="section-subtitle">Graphology-Based Personality Decoding</p>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="image-card mb-3 mb-sm-0">
                        <img src="https://images.unsplash.com/photo-1455390582262-044cdead277a?w=600&h=500&fit=crop"
                            alt="Graphology">
                        <div class="image-overlay">
                            <h4>Your Handwriting Reveals Everything</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="modern-card">
                        <div class="modern-icon">
                            <i class="fas fa-pen-fancy"></i>
                        </div>
                        <h3>Graphology</h3>

                        <p>Handwriting and signature analysis is commonly known as Graphology.</p>
                        <p>It is the study of handwriting and signatures for analyzing:</p>
                        <ul class="bento-list">
                            <li><i class="fas fa-check"></i> Personality</li>
                            <li><i class="fas fa-check"></i> Past</li>
                            <li><i class="fas fa-check"></i> Future</li>
                        </ul>
                        <p>The most important thing is that we can reverse-engineer the process.
                            By making a few changes in our handwriting, we can improve the overall quality of life.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mobile Numerology -->
    <section class="info-section section-padding bg-accent">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Mobile Numerology</h2>
                <p class="section-subtitle">Are you attracting bad luck from your mobile number?</p>
            </div>

            <div class="benefits-grid">
                <div class="benefit-card">
                    <i class="fas fa-mobile-alt"></i>
                    <h5>Change Financial Destiny</h5>
                    <p>Small change in mobile number can transform your financial life</p>
                </div>

                <div class="benefit-card">
                    <i class="fas fa-rupee-sign"></i>
                    <h5>Increase Cash Flow</h5>
                    <p>The flow of cash can increase through this technique</p>
                </div>

                <div class="benefit-card">
                    <i class="fas fa-book"></i>
                    <h5>Ancient Wisdom</h5>
                    <p>This knowledge comes from our ancient Shastras</p>
                </div>

                <div class="benefit-card">
                    <i class="fas fa-chart-line"></i>
                    <h5>Improve Everything</h5>
                    <p>Health, wealth, and relationships can be improved</p>
                </div>

                <div class="benefit-card">
                    <i class="fas fa-star"></i>
                    <h5>Celebrity Approved</h5>
                    <p>Many big film stars are using this technique</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Name Numerology -->
    <section class="info-section section-padding">
        <div class="container">
            <div class="text-center">
                <h2 class="section-title">Name Numerology</h2>
                <p class="section-subtitle">Because your name defines your destiny</p>
            </div>

            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="highlight-quote">
                        <p><i class="fas fa-key"></i> The right door opens with the right spelling and the right name.</p>
                    </div>
                    <div class="modern-card">
                        <div class="modern-icon">
                            <i class="fas fa-signature"></i>
                        </div>
                        <h3>Everything is Energy</h3>
                        <p>Everything in this universe is energy, so everything has vibration and frequency.</p>
                        <p>Your name is also a vibration, which attracts opportunities, people, and results into your life.
                        </p>
                        <p>If this vibration is on the wrong frequency, then the universe may give you the wrong
                            opportunities.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="image-card">
                        <img src="https://images.unsplash.com/photo-1484480974693-6ca0a78fb36b?w=600&h=400&fit=crop"
                            alt="Name Numerology">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Webinar Overview Section -->
    <section class="webinar-overview-section section-padding">
        <div class="container">
            <div class="text-center">
                <h2 class="section-title">Upgrade Your Life</h2>
                <p class="section-subtitle">Transform your life with ancient sciences and modern application</p>
            </div>

            <!-- Upgrade Grid -->
            <div class="upgrade-grid">
                <div class="upgrade-card">
                    <div class="upgrade-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h4>Face Reading</h4>
                    <p>Decode personality & potential</p>
                </div>

                <div class="upgrade-card">
                    <div class="upgrade-icon">
                        <i class="fas fa-pen-fancy"></i>
                    </div>
                    <h4>Handwriting & Signature</h4>
                    <p>Reveal hidden patterns</p>
                </div>

                <div class="upgrade-card">
                    <div class="upgrade-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h4>Mobile Number</h4>
                    <p>Align vibrations for success</p>
                </div>

                <div class="upgrade-card">
                    <div class="upgrade-icon">
                        <i class="fas fa-signature"></i>
                    </div>
                    <h4>Name</h4>
                    <p>Optimize energy frequency</p>
                </div>

                <div class="upgrade-card">
                    <div class="upgrade-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h4>Birthdate</h4>
                    <p>Unlock your life path</p>
                </div>
            </div>

            <!-- What You'll Learn Section -->
            <div class="learn-section">
                <h2>What You Will Learn</h2>

                <div class="learn-grid">
                    <div class="learn-card">
                        <i class="fas fa-eye"></i>
                        <h5>Face Reading</h5>
                        <p>Fundamentals</p>
                    </div>

                    <div class="learn-card">
                        <i class="fas fa-pen-fancy"></i>
                        <h5>Graphology</h5>
                        <p>Fundamentals</p>
                    </div>

                    <div class="learn-card">
                        <i class="fas fa-signature"></i>
                        <h5>Name Numerology</h5>
                        <p>Fundamentals</p>
                    </div>

                    <div class="learn-card">
                        <i class="fas fa-mobile-alt"></i>
                        <h5>Mobile Numerology</h5>
                        <p>Fundamentals</p>
                    </div>
                </div>

                <div class="transform-text">
                    <p>Understand, apply, and transform what your <strong>Numbers</strong>, <strong>Name</strong>,
                        <strong>Face</strong>, and <strong>Handwriting & Signature</strong> are trying to tell you.
                    </p>
                    <p class="mt-3">Turn them into a life map for <strong>success</strong>, <strong>health</strong>,
                        <strong>wealth</strong>, and <strong>relationships</strong>.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="features-section section-padding" id="benefits">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Takeaways from this 2-Hour Premium Workshop</h2>
                <p class="section-subtitle text-uppercase fw-bold">Face Reading • Graphology • Mobile Numerology • Name
                    Numerology</p>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-gem"></i>
                        </div>
                        <div class="feature-content">
                            <h5>Attract Luxury Lifestyle</h5>
                            <p>Understand your face, signature, mobile number & name to manifest abundance</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="feature-content">
                            <h5>Build Better Relationships</h5>
                            <p>Use the right signature + aligned name & mobile number for harmony</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <div class="feature-content">
                            <h5>Improve Health Naturally</h5>
                            <p>Enhance well-being without depending on medicines</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="feature-content">
                            <h5>Get Your Dream Job</h5>
                            <p>Unlock powerful secrets for career breakthrough</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="feature-content">
                            <h5>Massive Business Growth</h5>
                            <p>Use lucky mobile number & correctly aligned name</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="urgency-box text-center">
                        <h4>
                            <i class="fa-solid fa-clock"></i> OFFER EXPIRES IN:
                        </h4>

                        <div class="countdown-display countdown">
                            <span class="minutes">15</span> :
                            <span class="seconds">00</span>
                        </div>
                        <small>Minutes : Seconds</small>

                        <div class="mt-4">
                            <a href="{{ route('webinars') }}" class="btn-primary-custom">
                                <div class="hex-wrapper">
                                    <svg viewBox="0 0 100 115" xmlns="http://www.w3.org/2000/svg">
                                        <polygon points="50,2 98,26 98,89 50,113 2,89 2,26" fill="#F9D058" />
                                    </svg>
                                    <div class="hex-text">
                                        <span class="rupee">₹</span>
                                        <span class="amount">51</span>
                                    </div>
                                </div>
                                <div class="btn-label">
                                    Reserve Your Seat Now
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </a>
                        </div>
                        {{-- <div class="offer-label">
                            <i class="fa-solid fa-gem"></i> Free Bonuses Worth ₹42,000
                    </div> --}}
                    </div>
                    <div class="cta-details h-auto mt-0 mt-sm-4 mb-5 mb-sm-0 text-center">
                        <p><strong>Anyone without any experience can learn Face Reading, Graphology, Mobile Numerology, and
                                Name Numerology to manifest their best life.</strong></p>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-4">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-smile"></i>
                        </div>
                        <div class="feature-content">
                            <h5>Attract Comfort & Peace</h5>
                            <p>Bring balance and harmony into daily life</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                        <div class="feature-content">
                            <h5>Resolve Court Cases</h5>
                            <p>Specific mobile number & name techniques for legal relief</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="feature-content">
                            <h5>Increase Productivity & Clear Debts</h5>
                            <p>Lucky numbers + names to boost efficiency & eliminate debts</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-plane"></i>
                        </div>
                        <div class="feature-content">
                            <h5>International Travel</h5>
                            <p>Travel abroad while keeping business stable</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="feature-content">
                            <h5>Control Expenses & Mood</h5>
                            <p>Stop unnecessary spending & achieve emotional balance</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Start -->
    <section class="cta-section" id="enroll">
        <div class="container">
            <div class="cta-content text-center">
                <h2 class="cta-title">
                    ENROLL NOW & GET BONUSES WORTH ₹12,000 FREE
                </h2>

                <p class="cta-subtitle">
                    YES, I WANT TO LEARN <strong>FACE READING | GRAPHOLOGY | MOBILE NUMEROLOGY | NAME NUMEROLOGY</strong>
                </p>
                <div class="ctaBox">
                    <div class="cta-details">
                        <p><strong>This is a paid live training. You will receive:</strong></p>
                        <ul>
                            <li><i class="fas fa-check-circle"></i> Access to a 2-hour live workshop</li>
                            <li><i class="fas fa-check-circle"></i> Bonus software after successful payment</li>
                        </ul>
                    </div>

                    <div class="timer-box mb-5">
                        <h6><i class="fa-solid fa-clock"></i> OFFER EXPIRES IN:</h6>
                        <div class="countdown mt-5">
                            <span class="timer-number minutes">15</span>
                            <span class="timer-separator">:</span>
                            <span class="timer-number seconds">00</span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('webinars') }}" class="btn-primary-custom">
                    <div class="hex-wrapper">
                        <svg viewBox="0 0 100 115" xmlns="http://www.w3.org/2000/svg">
                            <polygon points="50,2 98,26 98,89 50,113 2,89 2,26" fill="#F9D058" />
                        </svg>
                        <div class="hex-text">
                            <span class="rupee">₹</span>
                            <span class="amount">51</span>
                        </div>
                    </div>
                    <div class="btn-label">
                        Reserve Your Seat Now
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>


                <p class="secure-text">
                    <i class="fas fa-lock"></i> Secure Payment |
                    <i class="fas fa-shield-alt"></i> 100% Safe |
                    <i class="fas fa-gift"></i> Instant Access
                </p>
            </div>
        </div>
    </section>

    <!-- Mentor Section -->
    <section class="mentor-section section-padding" id="mentor">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mentor-content">
                    <div class="mentor-badge">Meet Your Mentor</div>
                    <h2 class="mentor-title">Sommnath Bhattacharyaa</h2>
                    <p class="mentor-subtitle">I am India's Top Face Reader, Physiognomist, Graphologist, Numerologist &
                        Pranologist</p>

                    <ul class="credentials-list">
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>Hypnotherapist & Life Coach</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>Reiki Grand Master</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>Mesmerism Coach</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>Motivational & Communication Coach</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>University Topper & Expert in Occult Sciences</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>Corporate Trainer for Leading Organizations</span>
                        </li>
                    </ul>

                    <p>
                        A spiritual guide, philosopher & mentor driven by a mission to help people transform from their
                        <strong>current version to their best version</strong>.
                    </p>

                    <div class="mentor-stats">
                        <div class="stat-item">
                            <span class="stat-number">60K+</span>
                            <span class="stat-label">Lives Transformed</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">15K+</span>
                            <span class="stat-label">Students Trained</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">20+</span>
                            <span class="stat-label">Years Experience</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mentor-image-wrapper">
                    <div class="mentor-image-container">
                        <img class="builder-editable" builder-identity="8"
                            src="{{ asset('assets/frontend/default/image/profile.webp') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Course Start -->
    <section class="courseSec section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="posesjourney-title-area d-flex align-items-start justify-content-between flex-wrap">
                        <h1 class="title">{{ get_phrase('Top Course') }}</h1>
                        <a href="{{ route('courses') }}" class="explore-btn1">
                            <span class="text">{{ get_phrase('See All Courses') }}</span>
                            <span class="icon">
                                <img src="{{ asset('assets/frontend/default/image/arrow-send-white.svg') }}"
                                    alt="">
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row row-30">
                @php
                    $top_courses = DB::table('courses')
                        ->leftJoin('payment_histories', 'courses.id', '=', 'payment_histories.course_id')
                        ->select(
                            'courses.id',
                            'courses.slug',
                            'courses.thumbnail',
                            'courses.title',
                            'courses.average_rating',
                            'courses.discount_flag',
                            'courses.is_paid',
                            'courses.price',
                            'courses.discounted_price',
                            DB::raw('COUNT(payment_histories.id) as total_sales'),
                        )
                        ->groupBy(
                            'courses.id',
                            'courses.slug',
                            'courses.thumbnail',
                            'courses.title',
                            'courses.average_rating',
                            'courses.discount_flag',
                            'courses.is_paid',
                            'courses.price',
                            'courses.discounted_price',
                        )
                        ->where('status', 'active')
                        ->orderByDesc('total_sales')
                        ->take(4) // Number of courses you want to get, e.g., top 4
                        ->get();
                @endphp
                @foreach ($top_courses as $key => $row)
                    <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                        <a href="{{ route('course.details', $row->slug) }}" class="pose-journey-link">
                            <div class="single-posesjourney-yoga">
                                <div class="banner">
                                    <img src="{{ get_image($row->thumbnail) }}" alt="">
                                </div>
                                @if (isset($row->is_paid) && $row->is_paid == 0)
                                    <p class="price">{{ get_phrase('Free') }}</p>
                                @elseif (isset($row->discount_flag) && $row->discount_flag == 1)
                                    <p class="price">
                                        {{ currency($row->discounted_price, 2) }}
                                        <del class="fs-12px text-12px text-light">{{ currency($row->price) }}</del>
                                    </p>
                                @else
                                    <p class="price">{{ currency($row->price, 2) }}</p>
                                @endif
                                @php
                                    $backgroundImage = asset(
                                        'assets/frontend/default/image/pose-journey-shadow' . (($key % 3) + 1) . '.svg',
                                    );
                                @endphp
                                <div class="overlay">
                                    <div class="image-overlay">
                                        <h4>{{ ucfirst($row->title) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Pose's Journey Area End -->

    <!-- Testimonials Area Start -->
    <section class="testimonialSec section-padding">
        <div class="container">
            <div class="text-center mb-5">
                <h1 class="section-title">{{ get_phrase('Success Stories') }}</h1>
                <p class="section-subtitle"> What Our Students Say About Their Transformation</p>
            </div>
        </div>

        <div class="elegant-testimonials-wrap">
            <div class="swiper meditation-testimonial-1">
                <div class="swiper-wrapper">
                    @php
                        $reviews = DB::table('user_reviews')->get();
                    @endphp
                    @foreach ($reviews as $review)
                        @php
                            $userDetails = DB::table('users')->where('id', $review->user_id)->first();
                        @endphp
                        <div class="swiper-slide">
                            <div class="elegant-testimonial-slide">
                                <p class="review fw-400">{{ $review->review }}</p>
                                <div class="ele-testimonial-profile-area d-flex">
                                    <div class="profile">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="ele-testimonial-profile-name">
                                        <h6 class="name">{{ $userDetails->name ?? 'N/A' }}</h6>
                                        <div class="rating d-flex align-items-center">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $review->rating)
                                                    <img src="{{ asset('assets/frontend/default/image/star-yellow-14.svg') }}"
                                                        alt="">
                                                @else
                                                    <img src="{{ asset('assets/frontend/default/image/star.svg') }}"
                                                        alt="">
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>


                <div class="row justify-content-center mt-5 pt-5">
                    <div class="col-md-6 col-lg-5 col-xl-4 position-relative">
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-scrollbar ms-auto me-auto MT-2"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonials Area End -->

    <!-- Faq Start -->
    <section class="faq-section section-padding">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">{{ get_phrase('Frequently Asked Questions') }}</h2>
                <p class="section-subtitle">{{ get_phrase('Everything You Need to Know') }}</p>
            </div>

            @php
                $faqs = json_decode(get_frontend_settings('website_faqs'), true);
                $faqs = count($faqs) > 0 ? $faqs : [['question' => '', 'answer' => '']];
            @endphp

            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <img class="builder-editable" builder-identity="8"
                        src="{{ asset('assets/frontend/default/image/faq.webp') }}" alt="">
                </div>
                <div class="col-lg-8">
                    <div class="accordion qnaaccordion-three" id="accordionFaq">
                        @foreach ($faqs as $key => $faq)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button  {{ $key == 0 ? '' : 'collapsed' }}" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFaq{{ $key }}"
                                        aria-expanded="{{ $key == 0 ? 'true' : 'false' }}"
                                        aria-controls="collapseFaq{{ $key }}">
                                        {{ $faq['question'] }}
                                    </button>
                                </h2>
                                <div id="collapseFaq{{ $key }}"
                                    class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}"
                                    data-bs-parent="#accordionFaq">
                                    <div class="accordion-body">
                                        {{ $faq['answer'] }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script>
        let timeLeft = 15 * 60;
        const timerInterval = setInterval(updateTimer, 1000);

        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;

            document.querySelectorAll('.minutes').forEach(el => {
                el.textContent = minutes < 10 ? '0' + minutes : minutes;
            });

            document.querySelectorAll('.seconds').forEach(el => {
                el.textContent = seconds < 10 ? '0' + seconds : seconds;
            });

            if (timeLeft > 0) {
                timeLeft--;
            } else {
                clearInterval(timerInterval);
                document.querySelectorAll('.countdown').forEach(el => {
                    el.innerHTML =
                        '<div class="offerex"><span style="color:red;font-size:2.2rem;font-weight: 800;">OFFER EXPIRED!</span></div>';
                });
            }
        }
        updateTimer();
    </script>
@endsection
