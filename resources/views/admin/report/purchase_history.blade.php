@extends('layouts.admin')
@push('title', get_phrase('Purchase History'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">

                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Payment History') }}
                </h4>

                <div class="custom-dropdown">
                    <button class="dropdown-header btn ol-btn-light">
                        {{ get_phrase('Export') }}
                        <i class="fi-rr-file-export ms-2"></i>
                    </button>

                    <ul class="dropdown-list">
                        <li>
                            <a class="dropdown-item" href="#"
                                onclick="downloadPDF('.print-table', 'payment-history')">
                                <i class="fi-rr-file-pdf"></i>
                                {{ get_phrase('PDF') }}
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="#"
                                onclick="exportToExcel('.print-table', 'payment-history')">
                                <i class="fi-rr-file-excel"></i>
                                {{ get_phrase('Excel') }}
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="#" onclick="window.print();">
                                <i class="fi-rr-print"></i>
                                {{ get_phrase('Print') }}
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
    <ul class="nav nav-tabs mb-3">

        <li class="nav-item">
            <a class="nav-link {{ $type == 'course' ? 'active' : '' }}"
                href="{{ route('admin.purchase.history', ['type' => 'course']) }}">
                Course
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $type == 'webinar' ? 'active' : '' }}"
                href="{{ route('admin.purchase.history', ['type' => 'webinar']) }}">
                Webinar
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $type == 'bundle' ? 'active' : '' }}"
                href="{{ route('admin.purchase.history', ['type' => 'bundle']) }}">
                Bundle
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $type == 'batchwisecourse' ? 'active' : '' }}"
                href="{{ route('admin.purchase.history', ['type' => 'batchwisecourse']) }}">
                Live Course
            </a>
        </li>

    </ul>
    <div class="ol-card p-4">
        <div class="ol-card-body">
            <div class="row row-gap-3">


                <div class="col-md-6">
                    <form class="form-inline" action="{{ route('admin.purchase.history') }}" method="get">
                        <input type="hidden" name="type" value="{{ $type }}">
                        <div class="row row-gap-3">
                            <div class="col-md-9">
                                <div class="mb-3 position-relative position-relative">
                                    <input type="text" class="form-control ol-form-control daterangepicker w-100"
                                        name="eDateRange"value="{{ date('m/d/Y', $start_date) . ' - ' . date('m/d/Y', $end_date) }}" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn ol-btn-primary w-100" id="submit-button"
                                    onclick="update_date_range();"> {{ get_phrase('Filter') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <div class="row mt-4">
                <div class="col-md-12">
                    <!-- Table -->
                    @if (count($reports) > 0)
                        {{-- <div
                            class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($reports) . ' ' . get_phrase('of') . ' ' . $reports->total() . ' ' . get_phrase('data') }}
                            </p>
                        </div> --}}
                        <div class="table-responsive purchase_list" id="purchase_list">
                            <table id="PaymentHistoryTable" class="table eTable eTable-2 print-table">
                                {{-- <thead>
                                    <tr>
                                        <th scope="col">{{ get_phrase('#') }}</th>
                                        <th scope="col">{{ get_phrase('User') }}</th>
                                        <th scope="col">{{ get_phrase('Item') }}</th>
                                        <th scope="col">{{ get_phrase('Paid amount') }}</th>
                                        <th scope="col">{{ get_phrase('Payment method') }}</th>
                                        <th scope="col">{{ get_phrase('Purchased date') }}</th>
                                        <th scope="col" class="print-d-none">{{ get_phrase('Invoice') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reports as $key => $report)
                                        @php
                                            if ($report->course_id > 0) {
                                                $item = App\Models\Course::where(
                                                    'id',
                                                    $report->course_id,
                                                )->firstOrNew();
                                            }
                                        @endphp
                                        <tr>
                                            <th scope="row">
                                                <p class="row-number">{{ $key + 1 }}</p>
                                            </th>
                                            <td>
                                                <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                    <div class="dAdmin_profile_img">
                                                        <img class="img-fluid rounded-circle image-45" width="45"
                                                            height="45" src="{{ get_image($report->photo) }}" />
                                                    </div>
                                                    <div class="ms-1">
                                                        <h4 class="title fs-14px">
                                                            {{ get_user_info($report->user_id)->name }}</h4>
                                                        <p class="sub-title2 text-12px">
                                                            {{ get_user_info($report->user_id)->email }}</p>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                    <div class="dAdmin_profile_name">
                                                        <h4 class="title fs-14px">{{ $item->title }}</h4>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="dAdmin_info_name min-w-200px">
                                                    <p>{{ currency($report->amount) }}</p>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="dAdmin_info_name">
                                                    <p>{{ $report->payment_type }}</p>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="dAdmin_info_name">
                                                    <p>{{ \Carbon\Carbon::parse($report->created_at)->format('d M Y, h:i A') }}
                                                    </p>
                                                </div>
                                            </td>

                                            <td class="print-d-none">
                                                <div class="adminTable-action">
                                                    <a class="btn ol-btn-light ol-icon-btn" data-bs-toggle="tooltip"
                                                        title="{{ get_phrase('Print') }}"
                                                        href="{{ route('admin.purchase.history.invoice', $report->id) }}">
                                                        <i class="fi-rr-print"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>

                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>{{ get_phrase('Total') }} :
                                            {{ currency(App\Models\Payment_history::sum('amount')) }}
                                        </th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tbody> --}}
                                @if ($type == 'course')
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>User</th>
                                            <th>Contact</th>
                                            <th>Item</th>
                                            <th>Paid amount</th>
                                            <th>Payment method</th>
                                            <th>Purchased date</th>
                                            <th>Invoice</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($reports as $key => $report)
                                            @php
                                                $item = App\Models\Course::where('id', $report->course_id)->first();
                                            @endphp

                                            <tr>

                                                <td>{{ $key + 1 }}</td>

                                                <td>
                                                    {{ get_user_info($report->user_id)->name }}
                                                    <br>
                                                    {{ get_user_info($report->user_id)->email }}
                                                </td>
                                                <td>
                                                    {{ get_user_info($report->user_id)->phone }}

                                                </td>
                                                <td>{{ $item->title }}</td>

                                                <td>{{ currency($report->amount) }}</td>

                                                <td>{{ $report->payment_type }}</td>

                                                <td>{{ \Carbon\Carbon::parse($report->created_at)->format('d M Y, h:i A') }}
                                                </td>

                                                <td>
                                                    <a href="{{ route('admin.purchase.history.invoice', $report->id) }}"
                                                        class="btn ol-btn-light px-3">
                                                        Print
                                                    </a>
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                @endif
                                @if ($type == 'webinar')
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>User</th>
                                            <th>Contact</th>
                                            <th>Webinar</th>
                                            <th>Price</th>
                                            {{-- <th>Admin</th>
                                            <th>Author</th> --}}
                                            <th>Issue date</th>
                                            <th>Payment method</th>
                                            <th>Options</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach ($reports as $key => $report)
                                            @php
                                                $bootcamp = App\Models\Bootcamp::where(
                                                    'id',
                                                    $report->bootcamp_id,
                                                )->first();
                                            @endphp

                                            <tr>

                                                <td>{{ $key + 1 }}</td>

                                                <td>
                                                    {{ get_user_info($report->user_id)->name }}
                                                    <br>
                                                    {{ get_user_info($report->user_id)->email }}
                                                </td>
                                                <td>
                                                    {{ get_user_info($report->user_id)->phone }}

                                                </td>
                                                <td>{{ $bootcamp->title ?? 'N/A' }}</td>

                                                <td>{{ currency($report->price) }}
                                                    {{-- Admin :<p> ₹ {{ $report->admin_revenue }}</p>
                                                    Author :<p> ₹ {{ $report->instructor_revenue }}</p> --}}
                                                </td>

                                                {{-- <td>₹ {{ $report->admin_revenue }}</td>

                                                <td>₹ {{ $report->instructor_revenue }}</td> --}}

                                                <td>
                                                    {{ \Carbon\Carbon::parse($report->created_at)->format('d M Y, h:i A') }}
                                                </td>

                                                <td>{{ $report->payment_method }}</td>

                                                <td>
                                                    <a href="{{ route('admin.webinar.purchase.invoice', $report->id) }}"
                                                        class="btn ol-btn-light">
                                                        Invoice
                                                    </a>
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                @endif
                                @if ($type == 'bundle')
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>User</th>
                                            <th>Contact</th>
                                            <th>Bundle</th>
                                            <th>Included courses</th>
                                            <th>Purchase Date</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach ($reports as $key => $bundle)
                                            @php
                                                $courseBundle = \App\Models\CourseBundle::find($bundle->bundle_id);

                                                $courseIds = json_decode($courseBundle?->course_ids ?? '[]', true);

                                                $courses = \App\Models\Course::whereIn('id', $courseIds)->pluck(
                                                    'title',
                                                );

                                                $purchase_date = strtotime($bundle->created_at);

                                                $current_time = time();

                                                $subscription_limit = $courseBundle?->subscription_limit ?? 0;

                                                if ($subscription_limit == 0) {
                                                    $expire_date = null;
                                                    $status = 'Lifetime';
                                                } else {
                                                    $expire_date = strtotime(
                                                        "+{$subscription_limit} days",
                                                        $purchase_date,
                                                    );
                                                    $status = $expire_date > $current_time ? 'Active' : 'Expired';
                                                }
                                            @endphp

                                            <tr>

                                                <td>{{ $key + 1 }}</td>

                                                <td>
                                                    {{ \App\Models\User::find($bundle->user_id)?->name ?? 'Unknown' }}
                                                </td>
                                                <td>
                                                    {{ get_user_info($bundle->user_id)->phone ?? 'N/A' }}

                                                </td>
                                                <td>
                                                    {{ $courseBundle?->title }}
                                                </td>

                                                <td>
                                                    <ul class="bullet-list">
                                                        @foreach ($courses as $course)
                                                            <li>{{ $course }}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>

                                                <td>
                                                    <b>{{ date('d M Y, h:i A', $purchase_date) }}</b>
                                                </td>

                                                <td>
                                                    ₹ {{ $bundle->amount }}
                                                </td>

                                                <td>

                                                    @if ($status == 'Lifetime')
                                                        <span class="badge bg-primary py-2">Lifetime</span>
                                                    @elseif ($status == 'Active')
                                                        <span class="badge bg-success py-2">Active</span>
                                                    @else
                                                        <span class="badge bg-danger py-2">Expired</span>
                                                    @endif

                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                @endif
                                @if ($type == 'batchwisecourse')
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>User</th>
                                            <th>Contact</th>
                                            <th>Batch</th>
                                            <th>Course</th>
                                            <th>Paid amount</th>
                                            <th>Payment method</th>
                                            <th>Purchased date</th>
                                            <th>Invoice</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($reports as $key => $report)
                                            <tr>

                                                <td>{{ $key + 1 }}</td>

                                                <td>
                                                    {{ get_user_info($report->user_id)->name }}
                                                    <br>
                                                    {{ get_user_info($report->user_id)->email }}
                                                </td>

                                                <td>
                                                    {{ get_user_info($report->user_id)->phone }}
                                                </td>

                                                <td>
                                                    {{ $report->batch_name }}

                                                </td>
                                                <td>
                                                    {{ $report->course_title }}

                                                </td>

                                                <td>{{ currency($report->amount) }}</td>

                                                <td>{{ $report->payment_type }}</td>

                                                <td>
                                                    {{ \Carbon\Carbon::parse($report->created_at)->format('d M Y, h:i A') }}
                                                </td>

                                                <td>
                                                    <a href="{{ route('admin.purchase.history.invoice.batchwise', $report->id) }}"
                                                        class="btn ol-btn-light px-3">
                                                        Print
                                                    </a>
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                @endif
                            </table>
                        </div>
                    @else
                        @include('admin.no_data')
                    @endif
                    <!-- Data info and Pagination -->
                    {{-- @if (count($reports) > 0)
                        <div
                            class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($reports) . ' ' . get_phrase('of') . ' ' . $reports->total() . ' ' . get_phrase('data') }}
                            </p>
                            {{ $reports->links() }}
                        </div>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')

    <script>
        $(document).ready(function() {

            $('#PaymentHistoryTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true
            });

            // Reset button search ke pass
            // $('#bundleTable_filter').append(
            //     '<a href="{{ route('admin.course.bundles') }}" class="btn ol-btn-light ms-2">Reset</a>'
            // );

        });
    </script>
    <script type="text/javascript">
        "use strict";

        function Export() {
            const element = document.getElementById("purchase_list");
            var clonedElement = element.cloneNode(true);
            $(clonedElement).css("display", "block");

            var opt = {
                margin: 1,
                filename: 'purchase_list_{{ date('y-m-d') }}.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                }
            };
            html2pdf().set(opt).from(clonedElement).save();
            clonedElement.remove();
        }


        function printableDiv(printableAreaDivId) {
            var printContents = document.getElementById(printableAreaDivId).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
    <script>
        // excel option
        function exportToExcel(selector, filename) {
            // Table element ko select karo
            const table = document.querySelector(selector);
            if (!table) {
                alert('Table not found!');
                return;
            }

            // Table data ko array mein convert karo
            let data = [];
            const rows = table.querySelectorAll('tr');
            rows.forEach(row => {
                const rowData = [];
                const cells = row.querySelectorAll('th, td');
                cells.forEach(cell => {
                    rowData.push(cell.innerText);
                });
                data.push(rowData);
            });

            // Excel file create karne ke liye
            const wb = XLSX.utils.book_new();
            const ws = XLSX.utils.aoa_to_sheet(data);
            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

            // File download karo
            XLSX.writeFile(wb, `${filename}.xlsx`);
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
@endpush
