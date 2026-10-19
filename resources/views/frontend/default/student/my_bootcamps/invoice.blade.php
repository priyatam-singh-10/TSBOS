@extends('layouts.default')
@push('title', get_phrase('Invoice'))
@push('css')
    <style>
        .table-responsive {
            min-height: 250px;
        }

        .invoice-header {
            border-bottom: 2px solid #eee;
            padding-bottom: 25px;
            margin-bottom: 30px;
        }

        .company-info p {
            margin-bottom: 5px;
            font-size: 14px;
        }

        .print-d-none {
            display: block;
        }

        @media print {
            .print-d-none {
                display: none !important;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
@endpush

@php
    $companyName = get_settings('system_name');
    $companyLogo = get_image(get_frontend_settings('dark_logo'));
    $companyAddress = get_settings('address');
    $companyPhone = get_settings('phone');
    $companyEmail = get_settings('system_email');
    $companyGST = get_settings('company_gst');
@endphp

@section('content')
    <section class="my-course-content mt-50">
        <div class="profile-banner-area"></div>
        <div class="container profile-banner-area-container">
            <div class="row">
                @include('frontend.default.student.left_sidebar')
                <div class="col-lg-9">
                    <h4 class="g-title text-capitalize">{{ get_phrase('Invoice') }}</h4>
                    <div class="my-panel mt-5">
                        <div class="ol-card mb-30px" id="my-invoice">
                            <!-- Invoice Header with Company Info -->
                            <div class="invoice-header d-flex justify-content-between align-items-start flex-wrap">
                                <div class="company-info">
                                    <img src="{{ asset('uploads/dark_logo/darklogo-1769084998.png')}}" alt="{{ $companyName }} Logo" class="mb-3"
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
                                    <h2 class="mb-2">{{ get_phrase('Invoice') }}: {{ $invoice->invoice }}</h2>
                                    <p class="sub-title fs-16px mb-1"><strong>Issue Date:</strong>
                                        {{ date('d M, Y h:i A', strtotime($invoice->created_at)) }}</p>
                                    {{-- <p class="sub-title fs-16px"><strong>Purchase Date:</strong>
                                        {{ date('d M, Y h:i A', strtotime($invoice->created_at)) }}</p> --}}
                                </div>
                            </div>

                            <div class="ol-card-body p-20px">
                                <!-- Invoice To & Payment Details -->
                                <div class="pb-20px ol-border-bottom mb-20px">
                                    <div class="row">
                                        <div class="col-lg-10">
                                            <div class="d-flex gap-5 justify-content-between flex-wrap">
                                                <div>
                                                    <h4 class="title fs-18px text-capitalize mb-20px">
                                                        {{ get_phrase('Invoice To') }}</h4>
                                                    @php
                                                        $user = get_user_info($invoice->user_id);
                                                    @endphp
                                                    <ul class="ol-list-group-2">
                                                        <li class="title fs-16px fw-normal">{{ $user->name ?? 'N/A' }}</li>
                                                        <li class="title fs-16px fw-normal">{{ $user->email ?? 'N/A' }}
                                                        </li>
                                                        <li class="title fs-16px fw-normal">
                                                            {{ optional(json_decode($user->address))->city ?? '' }},
                                                            {{ optional(json_decode($user->address))->state ?? '' }},
                                                            {{ optional(json_decode($user->address))->country ?? '' }}
                                                        </li>
                                                        <li class="title fs-16px fw-normal">{{ $user->phone ?? 'N/A' }}
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="max-w-280px w-100">
                                                    <h4 class="title fs-18px text-capitalize mb-20px">
                                                        {{ get_phrase('Payment Details') }}</h4>
                                                    <ul class="ol-list-group-2 w-100">
                                                        <li>
                                                            <span
                                                                class="title fs-16px fw-normal">{{ get_phrase('Total') }}</span>
                                                            <span
                                                                class="title2 fs-16px">{{ currency($invoice->price, 2) }}</span>
                                                        </li>
                                                        <!--<li class="title">-->
                                                        <!--    <span class="title fs-16px fw-normal">{{ get_phrase('Due') }}</span>-->
                                                        <!--    <span class="title2 fs-16px">{{ currency($invoice->price, 2) }}</span>-->
                                                        <!--</li>-->
                                                        <li>
                                                            <span
                                                                class="title fs-16px fw-normal">{{ get_phrase('Payment Method') }}</span>
                                                            <span
                                                                class="title2 fs-16px text-capitalize">{{ $invoice->payment_method ?? 'N/A' }}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Invoice Table -->
                                <div class="invoice-table-wrap">
                                    <div class="table-responsive">
                                        <table class="table ol-table mb-3 text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th scope="col">{{ get_phrase('Webinar Name') }}</th>
                                                    <th scope="col" class="text-center">{{ get_phrase('Quantity') }}
                                                    </th>
                                                    <th scope="col" class="text-center">{{ get_phrase('Price') }}</th>
                                                    <th scope="col" class="text-end">{{ get_phrase('Amount') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="ellipsis-line-1">{{ $invoice->title }}</td>
                                                    <td class="text-center">1</td>
                                                    <td class="text-center">{{ currency($invoice->price, 2) }}</td>
                                                    <td class="text-end">{{ currency($invoice->price, 2) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer Note -->
                            <div class="mt-4 text-center text-muted small">
                                Thank you for your purchase! For any queries, contact us at <a
                                    href="malto:{{ $companyEmail }}" class="text-primary">{{ $companyEmail }}</a> or <a
                                    href="tel:{{ $companyPhone }}" class="text-primary">{{ $companyPhone }}</a>.
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4 gap-3 no-print">
                            <a href="{{ url()->previous() }}" class="eBtn gradient">
                                <i class="fas fa-arrow-left me-2"></i> {{ get_phrase('Back') }}
                            </a>
                            <a href="javascript:void(0);" onclick="printableDiv('my-invoice')"
                                class="btn ol-btn-light-primary ol-btn-rounded print-d-none">
                                <i class="fas fa-print me-2"></i> {{ get_phrase('Print') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>
        function printableDiv(printableAreaDivId) {
            var printContents = document.getElementById(printableAreaDivId).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload(); // Page को restore करने के लिए
        }
    </script>
@endpush
