@extends('layouts.default')
@push('title', get_phrase('About Us'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <!-- Start Breadcrumb -->
    <section class="AboutUs breadcum-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="eNtry-breadcum">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">{{ get_phrase('Home') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ get_phrase('About Us') }}</li>
                            </ol>
                        </nav>
                        <h3 class="g-title">{{ get_phrase('About Us') }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Breadcrumb -->
    
    <section class="about-story-section section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">    
                    <div class="story-card mb-5">
                        <div class="row align-items-center">
                            <div class="col-md-4 mb-4 mb-sm-0">
                                <div class="image-card imageCard1">
                                    <img src="{{ asset('assets/frontend/default/image/profile.webp') }}" alt="Face Reading">
                                    <div class="image-overlay text-center">
                                        <h4>Mr. Somnath Bhattacharyaa</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h3>Our Story</h3>
                                <p>
                                    The Sommnath Bhattacharyaa Occult Sciences was founded with a singular vision: to make ancient wisdom accessible to modern seekers. For over two decades, we've been bridging the gap between timeless spiritual sciences and contemporary life challenges.
                                </p>
                                <p>
                                    What started as a personal journey of discovery has evolved into a movement that has touched over 60,000 lives. Our founder, Sommnath Bhattacharyaa, recognized the profound power of Face Reading, Graphology, and Numerology not just as predictive tools, but as transformative sciences capable of creating lasting positive change.
                                </p>
                            </div>
                        </div>
                    </div>
    
                    <div class="story-card mb-5">
                        <div class="row align-items-center flex-md-row-reverse">
                            <div class="col-md-4 mb-4 mb-sm-0">
                                <div class="image-card imageCard2">
                                <img src="{{ asset('assets/frontend/default/image/about1.webp') }}"
                                     class="img-fluid rounded shadow" 
                                     alt="Why These Sciences Matter">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h3>Why These Sciences Matter</h3>
                                <p>
                                    In today's fast-paced world, people are searching for authentic guidance and practical solutions. Face Reading reveals your inherent strengths and life path. Graphology shows how your subconscious mind manifests in your handwriting—and how changing it can change your reality. Numerology demonstrates that everything, from your name to your mobile number, carries a vibration that shapes your destiny.
                                </p>
                                <p>
                                    These aren't just abstract concepts. They're proven methodologies that have helped thousands improve their relationships, advance their careers, enhance their health, and achieve financial freedom. When combined with Reiki, Mesmerism, and Life Coaching, they form a complete system for holistic transformation.
                                </p>
                            </div>
                        </div>
                    </div>
    
                    <div class="story-card">
                        <div class="row align-items-center">
                            <div class="col-md-4 mb-4 mb-sm-0">
                                <div class="image-card imageCard1">
                                <img src="{{ asset('assets/frontend/default/image/about2.webp') }}"
                                     class="img-fluid rounded shadow" 
                                     alt="Our Approach">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h3>Our Approach</h3>
                                <p>
                                    We believe in practical, results-oriented education. Every technique we teach is backed by years of research and real-world application. Our workshops are designed to give you immediate, actionable insights you can apply to your life right away.
                                </p>
                                <p>
                                    Whether you're seeking personal growth, professional success, better relationships, or spiritual development, our courses provide the tools and guidance you need. We don't just teach theory—we show you how to create tangible results.
                                </p>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </section>

    <section class="mission-vision-section section-padding">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="mission-card" style="opacity: 1; transform: translateY(0px); transition: 0.6s;">
                        <div class="mission-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h4>Our Mission</h4>
                        <p>
                            To empower individuals worldwide with ancient wisdom and practical techniques that create lasting transformation. We're committed to helping people move from their current version to their best version through scientific yet spiritual methodologies.
                        </p>
                        <p>
                            We believe everyone deserves access to these powerful tools for self-discovery and growth, which is why we've made our workshops affordable and accessible to all.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="mission-card" style="opacity: 1; transform: translateY(0px); transition: 0.6s;">
                        <div class="mission-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h4>Our Vision</h4>
                        <p>
                            To create a world where people live consciously, make informed decisions, and manifest their highest potential. We envision a global community of empowered individuals who use these ancient sciences to create positive ripples in their lives and the lives of others.
                        </p>
                        <p>
                            Through education, practice, and community, we're building a movement of conscious living and purposeful transformation.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="row mt-5">
                <div class="col-12">
                    <div class="mission-card" style="opacity: 1; transform: translateY(0px); transition: 0.6s;">
                        <div class="mission-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h4>Our Values</h4>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <p><strong><i class="fas fa-check-circle" style="color: var(--secondary); margin-right: 10px;"></i>Authenticity:</strong> We teach only proven, time-tested methods</p>
                                <p><strong><i class="fas fa-check-circle" style="color: var(--secondary); margin-right: 10px;"></i>Accessibility:</strong> Knowledge should be available to everyone</p>
                                <p><strong><i class="fas fa-check-circle" style="color: var(--secondary); margin-right: 10px;"></i>Practicality:</strong> Every technique must deliver real-world results</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong><i class="fas fa-check-circle" style="color: var(--secondary); margin-right: 10px;"></i>Integrity:</strong> Honest guidance without false promises</p>
                                <p><strong><i class="fas fa-check-circle" style="color: var(--secondary); margin-right: 10px;"></i>Empowerment:</strong> Teaching you to transform yourself</p>
                                <p><strong><i class="fas fa-check-circle" style="color: var(--secondary); margin-right: 10px;"></i>Excellence:</strong> Continuous improvement in everything we do</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')@endpush
