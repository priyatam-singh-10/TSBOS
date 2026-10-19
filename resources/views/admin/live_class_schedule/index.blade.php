@extends('layouts.admin')
@push('title', get_phrase('Live Class Schedule'))

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endpush

@section('content')
    <!-- Header -->
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between">
                <h4 class="title fs-16px">
                    <i class="fi-rr-video-camera me-2"></i>
                    {{ get_phrase('Live Class Schedule') }}
                </h4>

                <a href="{{ route('admin.live-class-schedule.create') }}" class="btn ol-btn-outline-secondary">
                    {{-- <span class="fi-rr-plus"></span> --}}
                    {{ get_phrase('Schedule a new Live Class') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Table Area -->
    <div class="row">
        <div class="col-12">

            <div class="ol-card">
                <div class="ol-card-body p-3">

                    <!-- Export + Filter -->
                    <div class="row mb-3 align-items-center">

                        <div class="col-md-3">
                            <div class="custom-dropdown mt-4">
                                <button class="dropdown-header btn ol-btn-light">
                                    Export <i class="fi-rr-file-export ms-2"></i>
                                </button>
                                <ul class="dropdown-list">
                                    <li>
                                        <a class="dropdown-item" href="#"
                                            onclick="exportToExcel('.print-table','live-class')">
                                            <i class="fi-rr-file-excel"></i> Excel
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="window.print();">
                                            <i class="fi-rr-print"></i> Print
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-9">
                            <form method="GET" class="d-flex justify-content-end gap-2">
                                  <div class="col-md-3">
                                       <label class="form-label">{{ get_phrase('Batch') }}</label>
                                    <select name="batch_id" class="ol-select2 form-control batch-search">
                                        <option value="">All Batches</option>
                                
                                        @foreach($batches as $batch)
                                            <option value="{{ $batch->id }}"
                                                {{ request('batch_id') == $batch->id ? 'selected' : '' }}>
                                                {{ $batch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">{{ get_phrase('From Date') }}</label>
                                    <input type="date" name="from_date" value="{{ request('from_date') }}"
                                        class="form-control ol-form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">{{ get_phrase('To Date') }}</label>
                                    <input type="date" name="to_date" value="{{ request('to_date') }}"
                                        class="form-control ol-form-control">
                                </div>
                                <div class="col-md-2 pt-1">
                                    <button class="btn ol-btn-primary mt-4 py-2 w-100">
                                        <i class="fi-rr-filter"></i> {{ get_phrase('Filter') }}
                                    </button>
                                </div>
                                <div class="col-md-2 pt-1">
                                    <a href="{{ route('admin.live-class-schedule.list') }}" class="btn ol-btn-light mt-4 w-100">
                                        <i class="fi-rr-refresh"></i>
                                        {{ get_phrase('Reset') }}
                                    </a>
                                </div>


                                <!--<input type="date" name="from_date" class="form-control w-auto">-->

                                <!--<input type="date" name="to_date" class="form-control w-auto">-->

                                <!--<button class="btn btn-primary">-->
                                <!--    <i class="fas fa-filter"></i> Filter-->
                                <!--</button>-->

                                <!--<a href="{{ route('admin.live-class-schedule.list') }}" class="btn btn-light">-->
                                <!--    Reset-->
                                <!--</a>-->

                            </form>
                        </div>

                    </div>

                    <!-- Table -->
                    <div class="table-responsive">

                        <table class="table eTable eTable-2 print-table" id="liveClassTable">

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Batch Name</th>
                                    <th>Course Name</th>
                                    <th>Class Date & Time</th>
                                    {{-- <th>Price</th> --}}
                                    {{-- <th>Thumbnail</th> --}}
                                    {{-- <th>Curriculum</th> --}}
                                    <th>Description</th>
                                    <th>Created</th>
                                    <th>Options</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($schedules as $key => $item)
                                
                                @php
                                    $zoom = json_decode($item->additional_info, true);
                                    $join_url = $zoom['join_url'] ?? '';
                                    $password = $zoom['password'] ?? '';
                                @endphp
                                    <tr>

                                        <td>{{ $key + 1 }}</td>


                                        <td>{{ $item->title ?? 'N/A' }}</td>
                                        <td>{{ $item->batch->name ?? 'N/A' }}</td>
                                        <td>
                                            @php
                                                $courseIds = json_decode($item->batch->course_id ?? '[]', true);

                                                $courseTitles = \App\Models\Course::whereIn('id', $courseIds)
                                                    ->pluck('title')
                                                    ->toArray();
                                            @endphp

                                            <div class="dAdmin_profile d-flex align-items-center">
                                                <div>
                                                    <h4 class="title fs-14px">
                                                        {{ implode(', ', $courseTitles) ?: 'N/A' }}
                                                    </h4>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($item->class_date_and_time)->format('d M Y h:i A') }}
                                        </td>
                                        {{-- <td>₹ {{ number_format($item->price, 2) }}</td> --}}

                                        {{-- <td>
                                            @if ($item->thumbnail)
                                                <img src="{{ asset('storage/' . $item->thumbnail) }}" width="60"
                                                    class="radius-6px">
                                            @endif
                                        </td> --}}

                                        <td>
                                            {{ Str::limit($item->description, 40) ?? 'N/A' }}
                                        </td>

                                        {{-- <td>{!! $item->curriculum !!}</td> --}}

                                        <td>
                                            {{ date('d M Y h:i:A', strtotime($item->created_at)) }}
                                        </td>

                                        <td class="print-d-none">
                                            <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent">
                                                <button class="btn ol-btn-secondary dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span class="fi-rr-menu-dots-vertical"></span>
                                                </button>

                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" target="_blank"
                                                            href="{{ route('admin.live.class.schedule.start', $item->id) }}}"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-title="{{ get_phrase('Start live class') }}"><i
                                                                class="fi-rr-video-camera me-2"></i>
                                                            {{ get_phrase('Host Live Class') }}
                                                        </a>
                                                    </li>
                                                    @if($join_url)
                                                    <li>
                                                        <a href="javascript:void(0);" 
                                                           class="dropdown-item"
                                                           onclick="copyText('{{ $join_url }}')">
                                                            <i class="fa fa-link me-2"></i> Student Join Link
                                                        </a>
                                                    </li>
                                                
                                                    <li>
                                                        <a href="javascript:void(0);" 
                                                           class="dropdown-item"
                                                           onclick="copyText('{{ $password }}')">
                                                            <i class="fa fa-key me-2"></i> Student Passcode
                                                        </a>
                                                    </li>
                                                
                                                    <!--<li>-->
                                                    <!--    <a href="javascript:void(0);" -->
                                                    <!--       class="dropdown-item"-->
                                                    <!--       onclick="copyText('{{ $join_url }} | Passcode: {{ $password }}')">-->
                                                    <!--        <i class="fa fa-copy me-2"></i> Copy Full Info-->
                                                    <!--    </a>-->
                                                    <!--</li>-->
                                                @endif
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.live-class-schedule.edit', $item->id) }}">
                                                            <i class="fi-rr-edit me-2"></i> {{ get_phrase('Edit') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <form
                                                            action="{{ route('admin.live-class-schedule.destroy', $item->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Are you sure you want to delete?')">

                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit"
                                                                class="dropdown-item btnDI text-danger ps-2">
                                                                <i class="fi-rr-trash me-2"></i>{{ get_phrase('Delete') }}
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>

                                        <!--<td>-->
                                        <!--    <div class="d-flex gap-2">-->
                                        <!--        <a href="{{ route('admin.live.class.schedule.start', $item->id) }}"-->
                                        <!--            target="_blank" class="btn py-0 ps-1 pe-1 text-dark"-->
                                        <!--            data-bs-toggle="tooltip"-->
                                        <!--            data-bs-title="{{ get_phrase('Start live class') }}"><i-->
                                        <!--                class="fi-rr-video-camera"></i></a>-->
                                        <!--        <a href="{{ route('admin.live-class-schedule.edit', $item->id) }}"-->
                                        <!--            class="btn btn-light btn-sm">-->
                                        <!--            <i class="fi-rr-edit"></i>-->
                                        <!--        </a>-->

                                        <!--        <form action="{{ route('admin.live-class-schedule.destroy', $item->id) }}"-->
                                        <!--            method="POST">-->
                                        <!--            @csrf-->
                                        <!--            @method('DELETE')-->

                                        <!--            <button class="btn btn-light btn-sm text-danger">-->
                                        <!--                <i class="fi-rr-trash"></i>-->
                                        <!--            </button>-->
                                        <!--        </form>-->

                                        <!--    </div>-->
                                        <!--</td>-->

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection


@push('js')

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script>
        $(document).ready(function () {
        $('.batch-search').select2({
            placeholder: "Search Batch",
            allowClear: true,
            width: '100%'
        });
    });
        $(document).ready(function() {

            $('#liveClassTable').DataTable({
                dom: '<"d-flex justify-content-between mb-2"i f>rtp',
                paging: true,
                searching: true,
                ordering: true,
                lengthChange: false
            });

        });
         function copyText(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Toast style message (no alert)
                let msg = document.createElement('div');
                msg.innerText = 'Copied!';
                msg.style.position = 'fixed';
                msg.style.bottom = '20px';
                msg.style.right = '20px';
                msg.style.background = '#28a745';
                msg.style.color = '#fff';
                msg.style.padding = '8px 12px';
                msg.style.borderRadius = '5px';
                msg.style.zIndex = '9999';
                document.body.appendChild(msg);
        
                setTimeout(() => msg.remove(), 1500);
            });
        }    

        // Excel Export
        function exportToExcel(selector, filename) {
            const table = document.querySelector(selector);

            let data = [];

            table.querySelectorAll('tr').forEach(row => {
                let rowData = [];
                row.querySelectorAll('th,td')
                    .forEach(cell => rowData.push(cell.innerText));
                data.push(rowData);
            });

            const wb = XLSX.utils.book_new();
            const ws = XLSX.utils.aoa_to_sheet(data);

            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
            XLSX.writeFile(wb, filename + '.xlsx');
        }
    </script>

@endpush
