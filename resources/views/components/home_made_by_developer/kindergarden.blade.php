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
    <style>
        .overlay-content.show-more p:last-child {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0) 0%, rgb(255 232 235) 50%);
        }
    </style>
@endpush
@section('content')
    @php
        $total_students = DB::table('users')->where('role', 'student')->get();
        $total_instructors = DB::table('users')->where('role', 'instructor')->get();
        $free_courses = DB::table('courses')->where('is_paid', 0)->get();
        $premium_courses = DB::table('courses')->where('is_paid', 1)->get();
    @endphp

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
                        <span class="highlight">Ancient Sciences</span>
                    </h1>
                    
                    <p class="hero-subtitle">
                        Master Face Reading, Graphology, Name & Mobile Numerology to unlock success, wealth, health, and happiness in just 2 hours.
                    </p>
                    
                    <div class="hero-features">
                        <div class="hero-feature-item">
                            <i class="fas fa-user-graduate"></i>
                            <span>No Prior Experience Needed</span>
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
                        <div>
                            <button class="btn btn-primary-custom" onclick="scrollToEnroll()">
                                <div class="price-badge">
                                    <i class="fas fa-rupee-sign"></i>99
                                </div>
                                Reserve Your Seat Now
                                <i class="fas fa-arrow-right"></i>
                            </button>
                            
                            <div class="price-label text-color">⏳ Limited Time Offer – Ends Soon!</div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 hero-image-container">
                    <div class="hero-visual">
                        <div class="mystical-circle">
                            <div class="circle-outer">
                                <div class="circle-inner">
                                    <div class="circle-content">
                                        <div class="mystical-symbols">
                                            <div class="symbol">☯</div>
                                            <div class="symbol">🔮</div>
                                            <div class="symbol">✨</div>
                                            <div class="symbol">🌟</div>
                                        </div>
                                        <i class="fas fa-eye center-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
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

    <!-- Courses Section -->
    <section class="courses-section section-padding" id="courses">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">What You'll Master</h2>
                <p class="section-subtitle">7 Powerful Modalities to Transform Every Aspect of Your Life</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="course-card">
                        <div class="course-icon">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <h4>Face Reading</h4>
                        <p>Decode personality, strengths, and life path through facial features. A 3000-year-old science practiced with systematic approach.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="course-card">
                        <div class="course-icon">
                            <i class="fas fa-pen-fancy"></i>
                        </div>
                        <h4>Graphology</h4>
                        <p>Analyze handwriting and signatures to understand behavior patterns and create positive life changes through intentional modifications.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="course-card">
                        <div class="course-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h4>Mobile Numerology</h4>
                        <p>Harness the power of number vibrations to improve financial flow, health, relationships, and career opportunities.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="course-card">
                        <div class="course-icon">
                            <i class="fas fa-signature"></i>
                        </div>
                        <h4>Name Numerology</h4>
                        <p>Align your name vibration with universal energy to attract the right opportunities, people, and success into your life.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="course-card">
                        <div class="course-icon">
                            <i class="fas fa-volume-up"></i>
                        </div>
                        <h4>Pronology</h4>
                        <p>Master name numerology based on sound pronunciation and vibration for deeper energetic alignment and manifestation.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="course-card">
                        <div class="course-icon">
                            <i class="fas fa-hands"></i>
                        </div>
                        <h4>Reiki & Mesmerism</h4>
                        <p>Learn energy healing techniques and mesmerism for physical, mental, and emotional wellbeing and transformation.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="features-section section-padding" id="benefits">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Workshop Outcomes</h2>
                <p class="section-subtitle">Practical Remedies You'll Learn in Just 2 Hours</p>
            </div>
            
            <div class="row">
                <div class="col-lg-6">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-gem"></i>
                        </div>
                        <div class="feature-content">
                            <h5>Attract Luxury Lifestyle</h5>
                            <p>Use your face, signature, name & mobile number to manifest abundance and prosperity</p>
                        </div>
                    </div>
                    
                     <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="feature-content">
                            <h5>Improve Relationships</h5>
                            <p>Enhance personal and professional relationships through correct signature and name vibration</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <div class="feature-content">
                            <h5>Natural Health Enhancement</h5>
                            <p>Improve health naturally without dependency on medicines using ancient remedies</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="feature-content">
                            <h5>Career Success</h5>
                            <p>Get your dream job and grow your business using practical numerology techniques</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="feature-content">
                            <h5>Financial Freedom</h5>
                            <p>Reduce debts, control expenses, and increase income with lucky mobile numbers</p>
                        </div>
                    </div> 
                </div>
                
                <div class="col-lg-6">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-brain"></i>
                        </div>
                        <div class="feature-content">
                            <h5>Mental Clarity</h5>
                            <p>Increase productivity and mental focus through graphology modifications</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-smile"></i>
                        </div>
                        <div class="feature-content">
                            <h5>Emotional Balance</h5>
                            <p>Manage mood swings and achieve emotional stability with proven techniques</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-plane"></i>
                        </div>
                        <div class="feature-content">
                            <h5>Travel & Expansion</h5>
                            <p>Travel internationally without disturbing your business or personal life</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="feature-content">
                            <h5>Personal Growth</h5>
                            <p>Create a personal Life Map for success, health, wealth, and relationships</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="feature-content">
                            <h5>Practical Remedies</h5>
                            <p>Learn actionable remedies for immediate life comfort and continuous growth</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mentor Section -->
    <section class="mentor-section section-padding" id="mentor">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mentor-content">
                    <div class="mentor-badge">Meet Your Mentor</div>
                    <h2 class="mentor-title">Sommnath Bhattacharya</h2>
                    <p class="mentor-subtitle">India's Top Face Reader, Graphologist & Numerologist</p>
                    
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
                    
                    <p style="font-size: 1.2rem; line-height: 1.8; margin-top: 2rem;">
                        A spiritual guide, philosopher & mentor driven by a mission to help people transform from their <strong>current version to their best version</strong>.
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
                        <div class="mentor-placeholder">
                            <i class="fas fa-user-tie"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section section-padding">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Success Stories</h2>
                <p class="section-subtitle">What Our Students Say About Their Transformation</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card">
                        <p class="testimonial-text">
                            "After changing my mobile number based on numerology, my business revenue doubled in just 3 months! The techniques are simple yet incredibly powerful."
                        </p>
                        <div class="testimonial-author">
                            <div class="author-avatar">RP</div>
                            <div class="author-info">
                                <h6>Rajesh Patel</h6>
                                <p>Business Owner, Mumbai</p>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card">
                        <p class="testimonial-text">
                            "The graphology insights helped me understand myself better. Modifying my signature boosted my confidence and I got my dream job within 2 weeks!"
                        </p>
                        <div class="testimonial-author">
                            <div class="author-avatar">PS</div>
                            <div class="author-info">
                                <h6>Priya Sharma</h6>
                                <p>IT Professional, Bangalore</p>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card">
                        <p class="testimonial-text">
                            "Face reading opened a whole new dimension of understanding people. It's helped me in my relationships and career. Truly life-changing!"
                        </p>
                        <div class="testimonial-author">
                            <div class="author-avatar">AM</div>
                            <div class="author-info">
                                <h6>Amit Mehta</h6>
                                <p>HR Manager, Delhi</p>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bonus Section -->
    <section class="bonus-section">
        <div class="container">
            <h2 class="display-4 mb-3" style="font-weight: 900;">Exclusive Bonuses</h2>
            <p style="font-size: 1.3rem; margin-bottom: 2rem;">Enroll Now & Get Bonuses Worth</p>
            <div class="bonus-value">₹42,000</div>
            <p style="font-size: 1.4rem; font-weight: 700;">ABSOLUTELY FREE!</p>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section section-padding" id="faq">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Frequently Asked Questions</h2>
                <p class="section-subtitle">Everything You Need to Know</p>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    Does this science really work?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes. More than 15,000+ students have already learned and applied these sciences successfully. These are time-tested ancient techniques that have transformed countless lives.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    Is it live or recorded?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    It is a live interactive workshop where you can ask questions and get personalized guidance directly from the mentor.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Will recordings be provided?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    This is a live workshop. The focus is on real-time learning and interaction for maximum impact.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    How will the workshop be conducted?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    A 2-hour live session on Zoom where you'll learn practical techniques and remedies you can apply immediately.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                    Can I learn this without prior experience?
                                </button>
                            </h2>
                            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    A 2-hour live session on Zoom where you'll learn practical techniques and remedies you can apply immediately.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



@endsection
