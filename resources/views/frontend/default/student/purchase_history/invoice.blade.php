@extends('layouts.default')
@push('title', get_phrase('Invoice'))
@push('css')
    <style>
        .table-responsive {
            min-height: 250px;
        }

        .invoice-header {
            border-bottom: 2px solid #eee;
            padding-bottom: 30px;
            margin-bottom: 40px;
        }

        .company-info p {
            margin: 4px 0;
            font-size: 14px;
        }

        .invoice-info h2 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .description {
            color: #777;
            font-size: 14px;
        }

        .print-d-none {
            display: block;
        }

        @media print {

            .print-d-none,
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
            }
        }
    </style>
@endpush

@php
    $companyName = get_settings('system_name') ?? 'Your Company Name';
    $companyLogo = get_image(get_frontend_settings('dark_logo')) ?? asset('assets/images/default-logo.png');
    $companyAddress = get_settings('address') ?? '123, Main Street, Kota, Rajasthan, India';
    $companyPhone = get_settings('phone') ?? '+91 98765 43210';
    $companyEmail = get_settings('system_email') ?? 'support@yourcompany.com';
    $companyGST = get_settings('company_gst') ?? '';
@endphp

@section('content')
    <section class="wishlist-content">
        <div class="profile-banner-area"></div>
        <div class="container profile-banner-area-container">
            <div class="row">
                @include('frontend.default.student.left_sidebar')
                <div class="col-lg-9">
                    <h4 class="g-title mb-5">{{ get_phrase('Invoice') }}</h4>
                    <div class="my-panel purchase-history-panel">
                        <div class="invoice mt-5" id="invoice">
                            <!-- Header with Company & Invoice Info -->
                            <div class="invoice-header d-flex justify-content-between align-items-start flex-wrap gap-4">
                                <div class="company-info">
                                    <img src="{{ $companyLogo }}" alt="{{ $companyName }} sam1Logo" class="mb-3"
                                        style="max-width: 180px; height: auto;">
                                    <h4 class="mb-1"><b>{{ $companyName }}</b></h4>
                                    <p>{{ $companyAddress }}</p>
                                    <p><strong>Phone:</strong> {{ $companyPhone }}</p>
                                    <p><strong>Email:</strong> {{ $companyEmail }}</p>
                                    @if ($companyGST)
                                        <p><strong>GSTIN:</strong> {{ $companyGST }}</p>
                                    @endif
                                </div>

                                <div class="invoice-info text-end">
                                    <h2>
                                        <span>{{ get_phrase('Invoice') }}</span>
                                        <span>#{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</span>
                                    </h2>
                                    <p class="description mb-1">
                                        {{ get_phrase('Date') }}:
                                        {{ date('d-m-Y h:i A', strtotime($invoice->created_at)) }}
                                    </p>
                                </div>
                            </div>

                            <!-- Billing Area -->
                            <div class="billing-area">
                                <div class="table-responsive">
                                    <table class="table eTable table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>{{ get_phrase('Item') }}</th>
                                                <th>{{ get_phrase('Date of issue') }}</th>
                                                <th>{{ get_phrase('Payment Method') }}</th>
                                                <th class="text-end">{{ get_phrase('Price') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <p class="mb-0">{{ $invoice->course_title ?? 'Course Purchase' }}</p>
                                                </td>
                                                <td>
                                                    <p class="mb-0">
                                                        {{ date('d-m-Y h:i A', strtotime($invoice->created_at)) }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="mb-0 text-capitalize">
                                                        {{ $invoice->payment_type ?? 'Online' }}</p>
                                                </td>
                                                <td class="text-end">
                                                    <p class="mb-0 fw-bold">{{ currency($invoice->amount, 2) }}</p>
                                                </td>
                                            </tr>

                                            <tr>
                                                @php
                                                    $location = json_decode(auth()->user()->address);
                                                @endphp

                                                <td colspan="2">
                                                    <p class="description mb-0">{{ get_phrase('Billed to :') }}</p>
                                                    <p class="fw-bold mb-0">{{ auth()->user()->name }}</p>

                                                    <p class="mb-0">
                                                        {{ $location->city ?? '' }},
                                                        {{ $location->state ?? '' }},
                                                        {{ $location->country ?? '' }}
                                                    </p>
                                                    <p class=" mb-0">{{ auth()->user()->phone }}</p>
                                                </td>
                                                <td class="text-end">
                                                    <p class="description text-dark mb-0">{{ get_phrase('Total') }}</p>
                                                </td>
                                                <td class="text-end">
                                                    <p class="fw-bold mb-0">{{ currency($invoice->amount, 2) }}</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Thank You Note -->
                            <div class="mt-5 text-center text-muted small">
                                Thank you for your purchase! <br>
                                For any queries, contact us at <a href="malto:{{ $companyEmail }}"
                                    class="text-primary">{{ $companyEmail }}</a> or <a href="tel:{{ $companyPhone }}"
                                    class="text-primary">{{ $companyPhone }}</a>.
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-end gap-3 mt-4 no-print">
                        <a class="eBtn gradient" href="{{ route('purchase.history') }}">
                            <i class="fas fa-arrow-left me-2"></i> {{ get_phrase('Back') }}
                        </a>
                        <a class="eBtn gradient" href="javascript:void(0);" onclick="printableDiv('invoice')">
                            <i class="fas fa-print me-2"></i> {{ get_phrase('Print') }}
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
            location.reload(); // Restore page after print
        }
    </script>
@endpush
