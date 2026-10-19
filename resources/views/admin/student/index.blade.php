@extends('layouts.admin')
@push('title', get_phrase('Student'))
@push('meta')
@endpush
@push('css')
@endpush
@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Student List') }}
                </h4>

                <a href="{{ route('admin.student.create') }}"
                    class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-plus"></span>
                    <span>{{ get_phrase('Add new Student') }}</span>
                </a>
            </div>
        </div>
    </div>
    <div class="ol-card p-4">
        <div class="ol-card-body">

            <div class="row print-d-none mb-3 mt-3 row-gap-3">
                <div class="col-md-3 pt-2 pt-md-0">
                    <div class="custom-dropdown">
                        <button class="dropdown-header btn ol-btn-light">
                            {{ get_phrase('Export') }}
                            <i class="fi-rr-file-export ms-2"></i>
                        </button>
                        <ul class="dropdown-list">
                            <li>
                                <a class="dropdown-item" href="#"
                                    onclick="downloadPDF('.print-table', 'student-list')">
                                    <i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#"
                                    onclick="exportToExcel('.print-table', 'student-list')">
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

                <div class="col-md-9">
                    <form class="form-inline" action="{{ route('admin.student.index') }}" method="get">
                        <div class="row row-gap-3 justify-content-end">
                            <div class="col-md-4">
                                <input type="date" class="form-control ol-form-control" name="from_date"
                                    value="{{ request('from_date') }}">
                            </div>

                            <div class="col-md-4">
                                <input type="date" class="form-control ol-form-control" name="to_date"
                                    value="{{ request('to_date') }}">
                            </div>

                            {{-- <div class="col-md-3">
                                <input type="text" class="form-control ol-form-control" name="search"
                                    value="{{ request('search') }}" placeholder="{{ get_phrase('Search user') }}" />
                            </div> --}}

                            <div class="col-md-3">
                                <button type="submit" class="btn ol-btn-primary w-100" id="submit-button">
                                    {{ get_phrase('Search') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <!-- Table -->
                    @if (count($students) > 0)
                        {{-- <div
                            class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($students) . ' ' . get_phrase('of') . ' ' . $students->total() . ' ' . get_phrase('data') }}
                            </p>
                        </div> --}}
                        <div class="table-responsive course_list" id="course_list">
                            <table id="StudentTable" class="table eTable eTable-2 print-table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ get_phrase('Name') }}</th>
                                        <th scope="col">{{ get_phrase('Phone') }}</th>
                                        <th scope="col">{{ get_phrase('Enrolled Course') }}</th>
                                        <th scope="col">{{ get_phrase('Status') }}</th>
                                        <th scope="col">{{ get_phrase('Registered At') }}</th>
                                        <th class="print-d-none" scope="col">{{ get_phrase('Options') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $key => $row)
                                        <tr>
                                            <th scope="row">
                                                <p class="row-number">{{ ++$key }}</p>
                                            </th>
                                            <td>
                                                <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                    <img class="img-fluid rounded-circle image-45" width="45"
                                                        height="45"
                                                        src="{{ $row->photo ? get_image($row->photo) : asset('uploads/system/default_user.png') }}"
                                                        alt="User Image" />
                                                    <div class="ms-1">
                                                        <h4 class="title fs-14px">{{ ucwords($row->name) }}</h4>
                                                        <p class="sub-title2 text-12px">{{ $row->email }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="dAdmin_info_name min-w-150px">
                                                    <p>{{ $row->phone }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                {{ App\Models\Enrollment::where('user_id', $row->id)->count() }}
                                                {{ get_phrase('Courses') }}
                                            </td>
                                            <td>
                                                @if ($row->is_block == 1)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Blocked</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="d-block min-w-120px">
                                                    {{ date('d M Y, h:i A', strtotime($row->created_at)) }}
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
                                                            @if ($row->is_block == 0)
                                                                {{-- user already blocked → option show Unblock --}}
                                                                <a class="dropdown-item text-success"
                                                                    href="{{ route('admin.student.block_unblock', $row->id) }}">
                                                                    <i
                                                                        class="fi-rr-unlock me-2"></i>{{ get_phrase('Unblock') }}
                                                                </a>
                                                            @else
                                                                {{-- user active → option show Block --}}
                                                                <a class="dropdown-item text-danger"
                                                                    href="{{ route('admin.student.block_unblock', $row->id) }}">
                                                                    <i
                                                                        class="fi-rr-lock me-2"></i>{{ get_phrase('Block') }}
                                                                </a>
                                                            @endif
                                                        </li>

                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                                onclick="showStudentModal({{ $row->id }})">
                                                                <i
                                                                    class="fi-rr-eye me-2"></i>{{ get_phrase('View details') }}
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.student.edit', $row->id) }}">
                                                                <i class="fi-rr-edit me-2"></i>{{ get_phrase('Edit') }}
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a class="dropdown-item text-danger" href="javascript:void(0)"
                                                                onclick="confirmModal('{{ route('admin.student.delete', $row->id) }}')">
                                                                <i
                                                                    class="fi-rr-trash me-2"></i>{{ get_phrase('Remove account') }}
                                                            </a>
                                                        </li>
                                                    </ul>

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        @include('admin.no_data')
                    @endif

                    <!-- Data info and Pagination -->
                    {{-- @if (count($students) > 0)
                        <div
                            class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($students) . ' ' . get_phrase('of') . ' ' . $students->total() . ' ' . get_phrase('data') }}
                            </p>
                            {{ $students->links() }}
                        </div>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="studentDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">{{ get_phrase('Student details') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" id="student-modal-body">
                    <div class="text-center py-4">
                        <span class="spinner-border"></span>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        function showStudentModal(userId) {
            const modal = new bootstrap.Modal(
                document.getElementById('studentDetailsModal')
            );

            document.getElementById('student-modal-body').innerHTML = `
        <div class="text-center py-4">
            <span class="spinner-border"></span>
        </div>
    `;

            fetch(`{{ url('admin/student/view-modal') }}/${userId}`)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('student-modal-body').innerHTML = html;
                    modal.show();
                });
        }
    </script>

@endsection


@push('js')
    <script>
        $(document).ready(function() {

            $('#StudentTable').DataTable({
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
