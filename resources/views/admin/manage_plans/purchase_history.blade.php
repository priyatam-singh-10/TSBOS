@extends('layouts.admin')
@push('title', get_phrase('Plan Purchase History'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <!-- Section header -->
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">

            <!-- Row 1 : Heading + Export -->
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    <span>{{ get_phrase('Plan Purchase History') }}</span>
                </h4>

                <div class="custom-dropdown">
                    <button class="dropdown-header btn ol-btn-light">
                        {{ get_phrase('Export') }}
                        <i class="fi-rr-file-export ms-2"></i>
                    </button>
                    <ul class="dropdown-list">
                        <li>
                            <a class="dropdown-item" href="#" onclick="downloadPDF('.print-table', 'plan-purchase')">
                                <i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#"
                                onclick="exportToExcel('.print-table', 'plan-purchase')">
                                <i class="fi-rr-file-excel"></i> {{ get_phrase('Excel') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" onclick="window.print();">
                                <i class="fi-rr-print"></i> {{ get_phrase('Print') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Row 2 : Filters -->
            <form method="GET">
                <div class="row g-2">

                    <div class="col-md-2">
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="form-control ol-form-control" placeholder="Search Name / Mobile">
                    </div>

                    <div class="col-md-2">
                        <select name="course_id" class="form-control ol-form-control">
                            <option value="">All Courses</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}"
                                    {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                    {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="payment_status" class="form-control ol-form-control">
                            <option value="">Payment Status</option>
                            <option value="success" {{ request('payment_status') == 'success' ? 'selected' : '' }}>
                                Success
                            </option>
                            <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>
                                Failed
                            </option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <input type="date" name="from_date" value="{{ request('from_date') }}"
                            class="form-control ol-form-control">
                    </div>

                    <div class="col-md-2">
                        <input type="date" name="to_date" value="{{ request('to_date') }}"
                            class="form-control ol-form-control">
                    </div>

                    <div class="col-md-2 d-flex gap-2">
                        <button class="btn ol-btn-primary">Filter</button>
                        <a href="{{ route('admin.plan.purchase.history') }}"
                            class="px-2 dropdown-header btn ol-btn-light">Reset</a>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <!-- Admin area -->
    <div class="row">
        <div class="col-12">
            <div class="ol-card">
                <div class="ol-card-body p-3">
                    <div class="table-responsive course_list" id="course_list">
                        <table class="table eTable eTable-2 print-table" id="purchaseHistoryTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ get_phrase('Batch Name') }}</th>
                                    <th>{{ get_phrase('Course Name') }}</th>
                                    <th>{{ get_phrase('User Name') }}</th>
                                    <th>{{ get_phrase('Mobile') }}</th>
                                    <th>{{ get_phrase('City') }}</th>
                                    <th>{{ get_phrase('Paid amount') }}</th>
                                    <th>{{ get_phrase('Payment Status') }}</th>
                                    <th>{{ get_phrase('Date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchase_history as $key => $history)
                                    <tr>
                                        <th scope="row">{{ $key + 1 }}</th>
                                        <td>{{ $history->batch_name ?? 'N/A' }}</td>
                                        <td>{{ $history->course_title ?? 'N/A' }}</td>
                                        <td>{{ $history->first_name . ' ' . $history->last_name ?? 'N/A' }}</td>
                                        <td>{{ $history->mobile ?? 'N/A' }}</td>
                                        <td>{{ $history->city ?? 'N/A' }}</td>
                                        <td>₹ {{ number_format($history->amount, 2) }}</td>
                                        <td>
                                            <span
                                                class="badge {{ $history->payment_status == 'success' ? 'bg-success' : 'bg-danger' }}">
                                                {{ ucfirst($history->payment_status) }}
                                            </span>
                                        </td>
                                        <td>{{ date('d M Y h:i A', strtotime($history->created_at)) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        $(document).ready(function() {
            $('#purchaseHistoryTable').DataTable({
                dom: 'i<"table-top"f>rtp', // info at top only
                paging: true,
                searching: true,
                ordering: true
            });
        });

        // Export to Excel
        function exportToExcel(selector, filename) {
            const table = document.querySelector(selector);
            if (!table) {
                alert('Table not found!');
                return;
            }

            let data = [];
            table.querySelectorAll('tr').forEach(row => {
                let rowData = [];
                row.querySelectorAll('th, td').forEach(cell => rowData.push(cell.innerText));
                data.push(rowData);
            });

            const wb = XLSX.utils.book_new();
            const ws = XLSX.utils.aoa_to_sheet(data);
            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
            XLSX.writeFile(wb, `${filename}.xlsx`);
        }

        // Download PDF (you can implement PDF export as needed)
        function downloadPDF(selector, filename) {
            alert('PDF export not implemented yet!');
        }
    </script>
@endsection
