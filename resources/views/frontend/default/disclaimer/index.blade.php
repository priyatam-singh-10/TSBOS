@extends('layouts.default')
@push('title', get_phrase('Disclaimer'))
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
                                <li class="breadcrumb-item active" aria-current="page">{{ get_phrase('Disclaimer') }}</li>
                            </ol>
                        </nav>
                        <h1 class="in-title-44px">{{ get_phrase('Disclaimer') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--</section>-->
    
     <section class="terms-content section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="terms-card">
                        <div class="intro-section mb-3">
                            <h3 class="mb-0">About Our Disclaimer</h3>
                        </div>

                        <!-- Section 1 -->
                        <div class="section-item pb-0">
                            <div class="section-content">
                                <p>This is an educational service based on Face Reading, Graphology, Name Numerology, and Mobile Numerology principles. Results may vary based on individual circumstances and efforts. No outcomes are guaranteed.</p>
                                <p>We do not claim or imply that any public figure, celebrity, or famous individual has used, endorsed, or is affiliated with our services. All insights provided are based solely on the principles of Face Reading, Graphology, Mobile Numerology, and Name Numerology.</p>
                                <p>The Sommnath Bhattacharyaa Occult Sciences is not a part of Facebook.com / Facebook.in or Google.com / Google.in. Additionally, The Sommnath Bhattacharyaa Occult Sciences is not endorsed by Facebook or Google.</p>
                            </div>
                        </div>

                        <!-- Section 2 -->
                        <div class="contact-box">
                            <h3>The Sommnath Bhattacharyaa Occult Sciences</h3>
                            
                            <div class="contact-item">
                                <div class="contact-item-content overflow-auto">
                                    <h4>GSTIN:</h4>
                                    <p></p>
                                </div>
                            </div>

                            <div class="contact-item">
                                <div class="contact-item-content overflow-auto">
                                    <h4>Email:</h4>
                                    <p></p>
                                </div>
                            </div>
                            
                            <div class="contact-item mb-0">
                                <div class="contact-item-content overflow-auto">
                                    <h4>Offer Expires On:</h4>
                                    <p></p>
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
