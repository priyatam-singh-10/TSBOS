@extends('layouts.default')

@section('content')
    {{-- <section class="container text-center py-5">
        <h2 class="text-success">✅ Payment Successfully</h2>

        <h4 class="mt-3">Thank You For Your Enrollment!</h4>

        <p>
            Your payment has been received successfully.
            Our team will contact you soon.
        </p>

        <a href="{{ route('home') }}" class="btn btn-primary mt-3">
            Go To Home
        </a>
    </section> --}}

    <!-- Payment Success Section -->
    <section class="payment-success-section" id="payment-success">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-9">
                    <div class="success-card">
                        <!-- Success Message -->
                        <h2 class="success-title">Payment Successful!</h2>
                        <h4 class="success-subtitle">Thank You For Your Enrollment</h4>

                        <p class="success-message">
                            Your payment has been received successfully.
                            You're now enrolled in the <strong>Live Workshop</strong>!
                        </p>

                        <!-- Action Buttons -->
                        <div class="success-actions">
                            <a href="{{ route('home') }}"
                                class="btn btn-primary-custom d-flex justify-content-center ps-0 py-2">
                                <i class="fas fa-home"></i>
                                Back to Home
                            </a>
                        </div>

                        <!-- Support Info -->
                        <div class="support-info">
                            <p>
                                <i class="fas fa-question-circle"></i>
                                Need help? Contact us at <a
                                    href="mailto:thesommnathbhattacharyaa@gmail.com">thesommnathbhattacharyaa@gmail.com</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
