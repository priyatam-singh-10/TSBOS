
@extends('layouts.default')
@push('title', get_phrase('Booking Invoice ') . $invoice)
@section('content')
@php
    $companyName    = get_settings('system_name');
    $companyLogo    = get_image(get_frontend_settings('dark_logo'));
    $companyAddress = get_settings('address');
    $companyPhone   = get_settings('phone');
    $companyEmail   = get_settings('system_email');
    $companyGST     = get_settings('company_gst'); 
@endphp

<section class="my-course-content mt-50">
    <div class="profile-banner-area"></div>
    <div class="profile-banner-area-container container">
        <div class="row">
            @include('frontend.default.student.left_sidebar')
            <div class="col-lg-9">
                <div class="my-panel purchase-history-panel">
                    <div class="invoice mt-5" id="invoice">
                        <!-- Invoice Header with Company Info -->
                        <div class="top d-flex justify-content-between align-items-start border-bottom mb-5 pb-5">
                            <div class="company-info">
                                <img src="{{ $companyLogo }}" alt="{{ $companyName }} Logo" class="mb-3" style="max-width: 180px; height: auto;">
                                <h4 class="mb-1"><b>{{ $companyName }}</b></h4>
                                <p class="mb-1">{{ $companyAddress }}</p>
                                <p class="mb-1"><strong>Phone:</strong> {{ $companyPhone }}</p>
                                <p class="mb-1"><strong>Email:</strong> {{ $companyEmail }}</p>
                                @if($companyGST)
                                    <p class="mb-1"><strong>GSTIN:</strong> {{ $companyGST }}</p>
                                @endif
                            </div>

                            <div class="invoice-info text-end">
                                <h2 class="mb-2"><span>{{ get_phrase('Invoice') }} #{{ $invoice }}</span></h2>
                                <p class="mb-1"><strong>Date:</strong> {{ date('d-M-Y', $booking->start_time) }}</p>
                            </div>
                        </div>

                        <!-- Billing / Details Area -->
                        <div class="billing-area">
                            <div class="table-responsive">
                                <table class="eTable table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>{{ get_phrase('Subject') }}</th>
                                            <th>{{ get_phrase('Tutor') }}</th>
                                            <th>{{ get_phrase('Time') }}</th>
                                            <th>{{ get_phrase('Method') }}</th>
                                            <th class="text-end">{{ get_phrase('Price') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $booking->booking_to_schedule->schedule_to_tutorSubjects->name ?? 'N/A' }}</td>
                                            <td>{{ $booking->booking_to_tutor->name ?? 'N/A' }}</td>
                                            <td>
                                                <!--{{ date('d-M-Y', $booking->start_time) }}<br>-->
                                                {{ date('h:i a', $booking->start_time) }} - {{ date('h:i a', $booking->end_time) }}
                                            </td>
                                            <td class="text-capitalize">{{ get_phrase('Stripe') }}</td>
                                            <td class="text-end">{{ currency($booking->booking_to_schedule->schedule_to_tutorCanteach->price ?? 0, 2) }}</td>
                                        </tr>

                                        <!-- Billed To & Total -->
                                        <tr>
                                            <td colspan="3">
                                                <strong>{{ get_phrase('Billed to:') }}</strong><br>
                                                {{ $booking->booking_to_student->name ?? 'N/A' }}<br>
                                                <!-- Add student email/phone if available -->
                                                {{ $booking->booking_to_student->email ?? '' }}
                                            </td>
                                            <td class="text-end"><strong>{{ get_phrase('Total:') }}</strong></td>
                                            <td class="text-end fw-bold">
                                                {{ currency($booking->booking_to_schedule->schedule_to_tutorCanteach->price ?? 0, 2) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Footer Note -->
                        <div class="mt-4 text-center text-muted small">
                            Thank you for your booking! For any queries, contact us at <a href="malto:{{ $companyEmail }}" class="text-primary">{{ $companyEmail }}</a> or <a href="tel:{{ $companyPhone }}" class="text-primary">{{ $companyPhone }}</a>.
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-end mt-4 gap-3">
                    <a class="eBtn gradient" href="{{ route('my_bookings') }}">{{ get_phrase('Back') }}</a>
                    <a class="eBtn gradient" id="print" href="javascript:void(0);" onclick="printableDiv('invoice')">
                        <i class="fas fa-print me-2"></i> {{ get_phrase('Print / Download') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('js')
    <script>
        "use strict";
        function printableDiv(printableAreaDivId) {
            var printContents = document.getElementById(printableAreaDivId).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload(); // Optional: Reload to restore JS events if needed
        }
    </script>
@endpush
