@extends('layouts.admin')
@push('title', get_phrase('Webinar Manager'))
@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <div class="ol-card radius-8px">
        <div class="ol-card-body py-12px px-20px my-3">
            <div class="d-flex align-items-center justify-content-between flex-md-nowrap flex-wrap gap-3">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Manage Webinar') }}
                </h4>

                <a
                    href="{{ route('admin.webinar.create') }}"class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-plus"></span>
                    <span>{{ get_phrase('Add New Webinars') }}</span>
                </a>
            </div>
        </div>
    </div>


    <!-- Start Admin area -->
    <div class="row">
        <div class="col-12">
            <div class="ol-card">
                <div class="ol-card-body mb-5 p-3">
                    <div class="row mb-4 mt-3">
                        <div class="col-md-6 d-flex align-items-center gap-3">
                            <div class="custom-dropdown ms-2">
                                <button class="dropdown-header btn ol-btn-light">
                                    {{ get_phrase('Export') }}
                                    <i class="fi-rr-file-export ms-2"></i>
                                </button>
                                <ul class="dropdown-list">
                                    <li>
                                        <a class="dropdown-item export-btn" href="#"
                                            onclick="downloadPDF('.print-table', 'webinar-list')"><i
                                                class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#"
                                            onclick="exportToExcel('.print-table', 'webinar-list')">
                                            <i class="fi-rr-file-excel"></i> {{ get_phrase('Excel') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item export-btn" href="#" onclick="window.print();"><i
                                                class="fi-rr-print"></i> {{ get_phrase('Print') }}</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="custom-dropdown dropdown-filter @if (!isset($_GET) || (isset($_GET) && count($_GET) == 0))  @endif">
                                <button class="dropdown-header btn ol-btn-light">
                                    <i class="fi-rr-filter me-2"></i>
                                    {{ get_phrase('Filter') }}

                                    <span class="text-12px"> (5)</span>
                                </button>
                                <ul class="dropdown-list w-250px">
                                    <li>
                                        <form id="filter-dropdown"
                                            action="{{ route('admin.webinars', ['type' => request()->route()->parameter('type')]) }}"
                                            method="get">
                                            <input type="hidden" name="search" value="{{ request('search') }}">
                                            <div class="filter-option d-flex flex-column gap-3">
                                                <!--<div class="d-none">-->
                                                <!--    <label for="eDataList"-->
                                                <!--        class="form-label ol-form-label">{{ get_phrase('Category') }}</label>-->
                                                <!--    <select class="form-control ol-form-control ol-select2"-->
                                                <!--        data-toggle="select2" name="category"-->
                                                <!--        data-placeholder="Type to search...">-->
                                                <!--        <option value="all">{{ get_phrase('All') }}</option>-->

                                                <!--        @foreach (App\Models\BootcampCategory::orderBy('title', 'asc')->get() as $category)
    -->
                                                <!--            <option value="{{ $category->slug }}"-->
                                                <!--                @if (request('category') == $category->slug)
    selected
    @endif>-->
                                                <!--                {{ $category->title }}-->
                                                <!--            </option>-->
                                                <!--
    @endforeach-->
                                                <!--    </select>-->
                                                <!--</div>-->
                                                <div>
                                                    <label class="form-label ol-form-label">
                                                        {{ get_phrase('Webinars') }}
                                                    </label>

                                                    <select class="form-control ol-form-control" name="bootcamp_id">

                                                        <option value="all">{{ get_phrase('All') }}</option>

                                                        @foreach ($bootcamps as $bootcamp)
                                                            <option value="{{ $bootcamp->id }}"
                                                                {{ request('bootcamp_id') == $bootcamp->id ? 'selected' : '' }}>
                                                                {{ $bootcamp->title }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                                <div>
                                                    <label for="eDataList"
                                                        class="form-label ol-form-label">{{ get_phrase('Status') }}</label>
                                                    <select class="form-control ol-form-control ol-select2"
                                                        data-toggle="select2" name="status" class="ol-select-2"
                                                        data-placeholder="Type to search...">
                                                        <option value="all">{{ get_phrase('All') }}
                                                        </option>

                                                        <option
                                                            value="active"@if (request('status') == 'active') selected @endif>
                                                            {{ get_phrase('Active') }} </option>
                                                        <option
                                                            value="inactive"@if (request('status') == 'inactive') selected @endif>
                                                            {{ get_phrase('Inactive') }} </option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label for="eDataList"
                                                        class="form-label ol-form-label">{{ get_phrase('Instructor') }}</label>
                                                    <select class="form-control ol-form-control ol-select2"
                                                        data-toggle="select2" name="instructor" class="ol-select-2"
                                                        data-placeholder="Type to search...">
                                                        <option value="all">{{ get_phrase('All') }}
                                                        </option>
                                                        @foreach (App\Models\Course::select('user_id')->distinct()->get() as $course)
                                                            <option
                                                                value="{{ $course->user_id }}"@if (request('instructor') == $course->user_id) selected @endif>
                                                                {{ ucfirst(get_user_info($course->user_id)->name) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div>
                                                    <label for="eDataList"
                                                        class="form-label ol-form-label">{{ get_phrase('Price') }}</label>
                                                    <select class="form-control ol-form-control ol-select2"
                                                        data-toggle="select2" name="price" class="ol-select-2"
                                                        data-placeholder="Type to search...">
                                                        <option value="all">{{ get_phrase('All') }}
                                                        </option>

                                                        <option
                                                            value="free"@if (request('price') == 'free') selected @endif>
                                                            {{ get_phrase('Free') }}</option>
                                                        <option
                                                            value="discounted"@if (request('price') == 'discounted') selected @endif>
                                                            {{ get_phrase('Discounted') }}</option>
                                                        <option
                                                            value="paid"@if (request('price') == 'paid') selected @endif>
                                                            {{ get_phrase('Paid') }}</option>
                                                    </select>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="form-label ol-form-label">From Date</label>
                                                        <input type="date" class="form-control ol-form-control"
                                                            name="from_date" value="{{ request('from_date') }}">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label ol-form-label">To Date</label>
                                                        <input type="date" class="form-control ol-form-control"
                                                            name="to_date" value="{{ request('to_date') }}">
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="filter-button d-flex justify-content-end align-items-center mt-3">
                                                <button type="submit"
                                                    class="ol-btn-primary">{{ get_phrase('Apply') }}</button>
                                            </div>
                                        </form>
                                    </li>
                                </ul>
                            </div>

                            @if (isset($_GET) && count($_GET) > 0)
                                <a href="{{ route('admin.webinars', ['type' => request()->route()->parameter('type')]) }}"
                                    class="me-2" data-bs-toggle="tooltip" title="{{ get_phrase('Clear') }}"><i
                                        class="fi-rr-cross-circle"></i></a>
                            @endif
                        </div>
                        {{-- <div class="col-md-6 mt-md-0 mt-3">
                            <form action="{{ route('admin.webinars', ['type' => request()->route()->parameter('type')]) }}"
                                method="get">

                                @php
                                    $queries = request()->query();
                                    unset($queries['search']);
                                @endphp
                                <div class="row">
                                    <div class="col-9">
                                        <div class="search-input flex-grow-1">
                                            <input type="text" name="search" value="{{ request('search') }}"
                                                placeholder="{{ get_phrase('Search Title') }}"
                                                class="ol-form-control form-control" />
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <button type="submit" class="btn ol-btn-primary w-100"
                                            id="submit-button">{{ get_phrase('Search') }}</button>
                                    </div>
                                </div>
                                @foreach ($queries as $key => $query)
                                    <input type="hidden" name="{{ $key }}" value="{{ $query }}">
                                @endforeach
                            </form>
                        </div> --}}
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            @if ($bootcamps->count() > 0)
                                {{-- <div
                                    class="admin-tInfo-pagi d-flex justify-content-md-between justify-content-center align-items-center gr-15 flex-wrap">
                                    <p class="admin-tInfo">
                                        {{ get_phrase('Showing') . ' ' . count($bootcamps) . ' ' . get_phrase('of') . ' ' . $bootcamps->total() . ' ' . get_phrase('data') }}
                                    </p>
                                </div> --}}
                                <div class="table-responsive course_list overflow-auto overflow-auto" id="course_list">
                                    <table id="webinarTable" class="eTable eTable-2 print-table table">
                                        <thead>
                                            <tr>
                                                <!--& Class-->
                                                <th scope="col">#</th>
                                                <th scope="col">{{ get_phrase('Title') }}</th>
                                                <!--<th scope="col">{{ get_phrase('Category') }}</th>-->
                                                <!--<th scope="col">{{ get_phrase('Module') }}</th>-->
                                                <th scope="col">{{ get_phrase('Enrolled Student') }}</th>
                                                <th scope="col" class="print-d-none">{{ get_phrase('Status') }}</th>
                                                <th scope="col">{{ get_phrase('Price') }}</th>
                                                <th scope="col">{{ get_phrase('Created') }}</th>
                                                <th scope="col" class="print-d-none">{{ get_phrase('Options') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bootcamps as $key => $bootcamp)
                                                <tr>
                                                    <th scope="row">
                                                        <p class="row-number">{{ ++$key }}</p>
                                                    </th>
                                                    <td>
                                                        <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                            <div class="dAdmin_profile_name">
                                                                <h4 class="title fs-14px">
                                                                    <a
                                                                        href="{{ route('admin.webinar.edit', [$bootcamp->id, 'tab' => 'curriculum']) }}">{{ ucfirst($bootcamp->title) }}</a>
                                                                </h4>

                                                                {{-- <a
                                                                    href="{{ route('admin.webinars', ['instructor' => $bootcamp->user_id]) }}">
                                                                    <p class="sub-title2 text-12px">
                                                                        {{ get_phrase('Instructor') }}:
                                                                        {{ get_user_info($bootcamp->user_id)->name }}</p>
                                                                    <p class="sub-title2 text-12px">
                                                                        {{ get_phrase('Email') }}:
                                                                        {{ get_user_info($bootcamp->user_id)->email }}</p>
                                                                </a> --}}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <!--<td>-->
                                                    <!--    <div class="sub-title2 text-12px">-->
                                                    <!--        <a href="{{ route('admin.webinars', ['category' => $bootcamp->category_slug]) }}">{{ $bootcamp->category }}</a>-->
                                                    <!--    </div>-->
                                                    <!--</td>-->
                                                    <!--<td>-->
                                                    <!--    <div class="sub-title2 text-12px">-->
                                                    <!--        <a href="{{ route('admin.webinar.edit', [$bootcamp->id, 'tab' => 'curriculum']) }}">-->
                                                    <!--            <p>{{ get_phrase('Module') }}:-->
                                                    <!--                {{ count_bootcamp_modules($bootcamp->id) }} </p>-->
                                                    <!--            <p style="display:none"> {{ get_phrase('Class') }}:-->
                                                    <!--                {{ count_bootcamp_classes($bootcamp->id) }} </p>-->
                                                    <!--        </a>-->
                                                    <!--    </div>-->
                                                    <!--</td>-->
                                                    <td>
                                                        <div class="sub-title2 text-12px">
                                                            <p>{{ get_phrase('Enrollments') }}:
                                                                {{ bootcamp_enrolls($bootcamp->id) }}
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td class="print-d-none">
                                                        <span
                                                            class="badge bg-{{ $bootcamp->status ? 'active' : 'inactive' }}">{{ get_phrase($bootcamp->status ? 'Active' : 'Inactive') }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="dAdmin_info_name min-w-150px">

                                                            @if ($bootcamp->is_paid == 0)
                                                                <p class="eBadge ebg-soft-success">
                                                                    {{ get_phrase('Free') }}
                                                                </p>
                                                            @else
                                                                <p>
                                                                    @if ($bootcamp->discount_flag == 1)
                                                                        {{ currency($bootcamp->discounted_price) }}
                                                                    @else
                                                                        {{ currency($bootcamp->price) }}
                                                                    @endif
                                                                </p>
                                                            @endif

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="dAdmin_info_name min-w-150px">
                                                            <p>{{ date('d M Y h:i A', strtotime($bootcamp->created_at)) }}


                                                        </div>
                                                    </td>
                                                    <td class="print-d-none">
                                                        <div
                                                            class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent">
                                                            <button class="btn ol-btn-secondary dropdown-toggle"
                                                                type="button" data-bs-toggle="dropdown"
                                                                aria-expanded="false">
                                                                <span class="fi-rr-menu-dots-vertical"></span>
                                                            </button>

                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a class="dropdown-item" target="_blank"
                                                                        href="{{ route('webinar.details', $bootcamp->slug) }}">
                                                                        <i
                                                                            class="fi-rr-eye me-2"></i>{{ get_phrase('Frontend View') }}
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('admin.webinar.edit', [$bootcamp->id, 'tab' => 'basic']) }}">
                                                                        <i
                                                                            class="fi-rr-edit me-2"></i>{{ get_phrase('Edit') }}
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('admin.webinar.edit', [$bootcamp->id, 'tab' => 'curriculum']) }}">
                                                                        <i
                                                                            class="fi-rr-edit me-2"></i>{{ get_phrase('Schedule webinar') }}
                                                                    </a>
                                                                </li>
                                                                {{-- @if ($bootcamp->start_url)
                                                                    <li>
                                                                        <a href="javascript:void(0);"
                                                                            class="dropdown-item"
                                                                            onclick="copyJoinLink('{{ $bootcamp->join_url ?? '' }}')">
                                                                            <i class="fi-rr-copy me-2"></i>
                                                                            {{ get_phrase('Copy Link') }}
                                                                        </a>
                                                                    </li>
                                                                @endif --}}
                                                                @if ($bootcamp->status)
                                                                    <li>
                                                                        <a class="dropdown-item"
                                                                            onclick="confirmModal('{{ route('admin.webinar.status', ['id' => $bootcamp->id]) }}')"
                                                                            href="javascript:void(0)">
                                                                            <i
                                                                                class="fi-rr-cross me-2"></i>{{ get_phrase('Make As Inactive') }}
                                                                        </a>
                                                                    </li>
                                                                @else
                                                                    <li>
                                                                        <a class="dropdown-item"
                                                                            onclick="confirmModal('{{ route('admin.webinar.status', ['id' => $bootcamp->id]) }}')"
                                                                            href="javascript:void(0)">
                                                                            <i
                                                                                class="fi-rr-check me-2"></i>{{ get_phrase('Make As Active') }}
                                                                        </a>
                                                                    </li>
                                                                @endif

                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        onclick="confirmModal('{{ route('admin.webinar.duplicate', $bootcamp->id) }}')"
                                                                        href="javascript:void(0)">
                                                                        <i
                                                                            class="fi-rr-copy me-2"></i>{{ get_phrase('Duplicate') }}
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a class="dropdown-item text-danger"
                                                                        onclick="confirmModal('{{ route('admin.webinar.delete', $bootcamp->id) }}')"
                                                                        href="javascript:void(0)">
                                                                        <i
                                                                            class="fi-rr-trash me-2"></i>{{ get_phrase('Delete') }}
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
                                {{-- <div
                                    class="admin-tInfo-pagi d-flex justify-content-md-between justify-content-center align-items-center gr-15 flex-wrap">
                                    <p class="admin-tInfo">
                                        {{ get_phrase('Showing') . ' ' . count($bootcamps) . ' ' . get_phrase('of') . ' ' . $bootcamps->total() . ' ' . get_phrase('data') }}
                                    </p>
                                    {{ $bootcamps->links() }}
                                </div> --}}
                            @else
                                @include('admin.no_data')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            var table = $('#webinarTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true
            });

            // Reset button search ke pass
            $('#webinarTable_filter').append(
                '<a href="{{ route('admin.webinars', ['type' => request()->route()->parameter('type')]) }}" class="btn btn-secondary ms-2">Reset</a>'
            );

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
    <!-- End Admin area -->
@endsection
