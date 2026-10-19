@extends('layouts.admin')
@push('title', get_phrase('Manage Plans'))
@push('meta')@endpush

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endpush

@section('content')
    <!-- Section header -->
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    <span>{{ get_phrase('Manage Plans') }}</span>
                </h4>
                <a href="javascript:void(0)" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px"
                    onclick="ajaxModal('{{ route('modal', ['admin.manage_plans.create']) }}', '{{ get_phrase('Create New Plan') }}')">
                    <span class="fi-rr-plus"></span>
                    <span>{{ get_phrase('Create New Plan') }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Admin area -->
    <div class="row">
        <div class="col-12">
            <div class="ol-card">
                <div class="ol-card-body p-3">
                    <div class="row mb-3 print-d-none align-items-center">

                        <!-- Export Left -->
                        <div class="col-md-3">
                            <div class="custom-dropdown">
                                <button class="dropdown-header btn ol-btn-light">
                                    {{ get_phrase('Export') }}
                                    <i class="fi-rr-file-export ms-2"></i>
                                </button>
                                <ul class="dropdown-list">
                                    <li>
                                        <a class="dropdown-item" href="#"
                                            onclick="downloadPDF('.print-table', 'plans')">
                                            <i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#"
                                            onclick="exportToExcel('.print-table', 'plans')">
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

                        <!-- Filters Right -->
                        <div class="col-md-9">
                            <form method="GET" class="">
                                <div class="row g-2">
                                    <div class="col-md-3">
                                        <input type="date" name="from_date" class="form-control ol-form-control"
                                            value="{{ request('from_date') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="date" name="to_date" class="form-control ol-form-control"
                                            value="{{ request('to_date') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <select name="status" class="form-control ol-form-control">
                                            <option value="">All Status</option>
                                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Expired
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 d-flex gap-2">
                                        <button type="submit" class="btn ol-btn-primary">
                                            <i class="fas fa-filter"></i> Filter
                                        </button>

                                        <a href="{{ route('admin.manage.plans') }}"
                                            class="px-2 dropdown-header btn ol-btn-light">
                                            Reset
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                    <!-- Table -->
                    <div class="table-responsive course_list" id="course_list">
                        <table class="table eTable eTable-2 print-table" id="plansTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ get_phrase('Batch') }}</th>
                                    <th>{{ get_phrase('Course') }}</th>
                                    <th>{{ get_phrase('Price') }}</th>
                                    <th>{{ get_phrase('Total Students') }}</th>
                                    <th>{{ get_phrase('Created Date') }}</th>
                                    <th>{{ get_phrase('Expiry Date') }}</th>
                                    <th>{{ get_phrase('Status') }}</th>
                                    <th class="print-d-none">{{ get_phrase('Options') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($plans as $key => $plan)
                                    <tr>
                                        <th scope="row">{{ $key + 1 }}</th>
                                        <td>
                                            <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                <div class="dAdmin_profile_name">
                                                    <h4 class="title fs-14px">{{ $plan->batch->name ?? 'N/A' }}</h4>

                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                <div class="dAdmin_profile_name">
                                                    <h4 class="title fs-14px">{{ $plan->course->title ?? 'N/A' }}</h4>
                                                    <small>{{ $plan->code }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>₹ {{ number_format($plan->price, 2) }}</td>
                                        <td>
                                            <a
                                                href="{{ route('admin.plan.purchase.history', ['batch_id' => $plan->batch_id]) }}">
                                                <i class="fas fa-users me-1"></i>
                                                {{ $plan->total_students }}
                                            </a>
                                        </td>
                                        <td>

                                            {{ date('d M Y', strtotime($plan->created_at)) }}

                                        </td>
                                        <td>

                                            {{ date('d M Y', strtotime($plan->expiry_date)) }}

                                        </td>
                                        <td>
                                            <span class="badge {{ $plan->status ? 'bg-success' : 'bg-danger' }}">
                                                {{ $plan->status ? 'Active' : 'Expired' }}
                                            </span>
                                        </td>
                                        <td class="print-d-none">
                                            <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent">
                                                <button class="btn ol-btn-secondary dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span class="fi-rr-menu-dots-vertical"></span>
                                                </button>

                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="javascript:void(0)"
                                                            onclick="ajaxModal('{{ route('modal', ['admin.manage_plans.edit', 'id' => $plan->id]) }}','Edit Plan')">
                                                            <i class="fi-rr-edit me-2"></i>{{ get_phrase('Edit') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)"
                                                            onclick="copyLink('{{ url('buy-plan?id=' . $plan->code) }}')">

                                                            <i class="fi-rr-link me-2"></i>{{ get_phrase('Copy Link') }}
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item text-danger"
                                                            onclick="confirmModal('{{ route('admin.manage.plans.delete', $plan->id) }}')"
                                                            href="javascript:void(0)">
                                                            <i class="fi-rr-trash me-2"></i>{{ get_phrase('Delete') }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <!--<td class="print-d-none">-->
                                        <!--    <div class="d-flex gap-2">-->
                                        <!--        <a href="javascript:void(0)"-->
                                        <!--            onclick="copyLink('{{ url('buy-plan?id=' . $plan->code) }}')"-->
                                        <!--            class="btn btn-light btn-sm" title="Copy Link">-->
                                        <!--            <i class="fi-rr-link"></i>-->
                                        <!--        </a>-->
                                        <!--         Top Plan Switch -->
                                        <!--        <div class="form-check form-switch m-0">-->
                                        <!--            <input class="form-check-input topPlanSwitch" type="checkbox"-->
                                        <!--                data-id="{{ $plan->id }}"-->
                                        <!--                {{ $plan->is_top == 1 ? 'checked' : '' }} title="Set as Top Plan">-->
                                        <!--        </div>-->
                                        <!--        <a href="javascript:void(0)"-->
                                        <!--            onclick="ajaxModal('{{ route('modal', ['admin.manage_plans.edit', 'id' => $plan->id]) }}','Edit Plan')"-->
                                        <!--            class="btn btn-light btn-sm" title="Edit">-->
                                        <!--            <i class="fi-rr-edit"></i>-->
                                        <!--        </a>-->
                                        <!--        <a href="javascript:void(0)"-->
                                        <!--            onclick="confirmModal('{{ route('admin.manage.plans.delete', $plan->id) }}')"-->
                                        <!--            class="btn btn-light btn-sm text-danger" title="Delete">-->
                                        <!--            <i class="fi-rr-trash"></i>-->
                                        <!--        </a>-->
                                        <!--    </div>-->
                                        <!--</td>-->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div id="copyMessage"
                            style="position: fixed; top: 20px; left: 60%; transform: translateX(-50%);
                                    background:#028f94; color:#fff; padding:10px 20px; border-radius:6px;
                                    display:none; z-index:9999; font-weight:500;">
                            Link copied successfully
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <!--<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>-->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#plansTable').DataTable({
                dom: '<"d-flex justify-content-between mb-2"i f>rtp', // info left, search right
                paging: true,
                searching: true,
                ordering: true,
                lengthChange: false
            });
        });

        $(document).on('change', '.topPlanSwitch', function() {

            let planId = $(this).data('id');
            let currentSwitch = $(this);

            $.ajax({
                url: "{{ route('admin.plan.set.top') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    plan_id: planId
                },
                success: function(response) {

                    // turn off all switches first
                    $('.topPlanSwitch').prop('checked', false);

                    // turn ON the selected switch
                    currentSwitch.prop('checked', true);

                },
                error: function() {
                    alert('Something went wrong while updating the top plan.');
                }
            });

        });

        // Copy Link
        function copyLink(link) {
            navigator.clipboard.writeText(link);

            const msg = document.getElementById("copyMessage");
            msg.style.display = "block";

            setTimeout(function() {
                msg.style.display = "none";
            }, 2000);
        }

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
    </script>
@endpush
