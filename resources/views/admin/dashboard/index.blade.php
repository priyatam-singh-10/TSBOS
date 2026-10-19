@extends('layouts.admin')
@push('title', get_phrase('Dashboard'))
@push('meta')@endpush
@push('css')
@endpush
@section('content')
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Dashboard') }}
                </h4>
            </div>
        </div>
    </div>

    <div class="row g-2 g-sm-3 my-3 row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4">
        <div class="col">
            <a href="{{ route('admin.courses') }}" class="text-decoration-none w-100">
                <div class="ol-card card-hover">
                    <div class="ol-card-body px-20px py-3">
                        <div class="d-grid ">
                            <p class="title card-title-hover fs-18px my-1">
                                {{ App\Models\Course::count() }}
                            </p>
                            <p class="sub-title fs-14px">
                                {{ get_phrase('Courses') }}
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('admin.purchase.history') }}" class="text-decoration-none w-100">
                <div class="ol-card card-hover">
                    <div class="ol-card-body px-20px py-3">
                        <div class="d-grid ">
                            <p class="title card-title-hover fs-18px my-1">
                                ₹ {{ number_format($totalCourseRevenue, 2) }}
                            </p>
                            <p class="sub-title fs-14px">
                                {{ get_phrase('Courses Revenue') }}
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        {{-- <div class="col">
            <a href="{{ route('admin.courses') }}" class="text-decoration-none">
                <div class="ol-card card-hover">
                    <div class="ol-card-body px-20px py-3">
                        <p class="title card-title-hover fs-18px my-2">{{ App\Models\Lesson::count() }}</p>
                        <p class="sub-title fs-14px">{{ get_phrase('Number of Lessons') }}</p>
                    </div>
                </div>
            </a>
        </div> --}}
        <div class="col">
            <a href="{{ route('admin.webinars') }}" class="text-decoration-none w-100">
                <div class="ol-card card-hover">
                    <div class="ol-card-body px-20px py-3">
                        <div class="d-grid ">
                            <p class="title card-title-hover fs-18px my-1">
                                {{ App\Models\Bootcamp::count() }}
                            </p>
                            <p class="sub-title fs-14px">
                                {{ get_phrase('Webinars') }}
                            </p>
                            {{-- <div class="d-flex justify-content-between align-items-center">
                                <p class="title card-title-hover fs-18px my-1">
                                    ₹ {{ number_format($totalWebinarRevenue, 2) }}
                                </p>
                                <p class="sub-title fs-14px">
                                    {{ get_phrase('Revenue') }}
                                </p>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('admin.purchase.history', ['type' => 'webinar']) }}" class="text-decoration-none w-100">
                <div class="ol-card card-hover">
                    <div class="ol-card-body px-20px py-3">
                        <div class="d-grid ">
                            <p class="title card-title-hover fs-18px my-1">
                                ₹ {{ number_format($totalWebinarRevenue, 2) }}
                            </p>
                            <p class="sub-title fs-14px">
                                {{ get_phrase('Webinar Revenue') }}
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('admin.enroll.history') }}" class="text-decoration-none w-100">
                <div class="ol-card card-hover">
                    <div class="ol-card-body px-20px py-3">
                        <p class="title card-title-hover fs-18px my-2">{{ App\Models\Enrollment::count() }}</p>
                        <p class="sub-title fs-14px">{{ get_phrase('Number of Enrollment') }}</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('admin.student.index') }}" class="text-decoration-none w-100">
                <div class="ol-card card-hover">
                    <div class="ol-card-body px-20px py-3">
                        <p class="title card-title-hover fs-18px my-2">
                            {{ App\Models\User::where('role', 'student')->count() }}</p>
                        <p class="sub-title fs-14px">{{ get_phrase('Number of Students') }}</p>
                    </div>
                </div>
            </a>
        </div>
        {{-- <div class="col">
            <a href="{{ route('admin.instructor.index') }}" class="text-decoration-none">
                <div class="ol-card card-hover">
                    <div class="ol-card-body px-20px py-3">
                        <p class="title card-title-hover fs-18px my-2">
                            {{ App\Models\User::where('role', 'instructor')->count() }}</p>
                        <p class="sub-title fs-14px">{{ get_phrase('Number of Instructor') }}</p>
                    </div>
                </div>
            </a>
        </div> --}}
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="ol-card p-3">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="title fs-14px">{{ get_phrase('Admin Revenue This Year') }}</h2>
                    </div>
                    <div class="col-md-6 text-end">
                        <a class="btn-link" href="{{ route('admin.revenue') }}" data-bs-toggle="tooltip"
                            data-bs-placement="bottom" title="{{ get_phrase('Admin Revenue') }}"><i
                                class="fi-rr-arrow-alt-right"></i></a>
                    </div>
                </div>
                <div class="ol-card-body">
                    <canvas id="myChart" class="mw-100 w-100" height="320px"></canvas>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="ol-card p-3">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h2 class="title fs-14px">{{ get_phrase('Latest Enrollments') }}</h2>
                    </div>
                    <div class="col-md-6 text-end">
                        <a class="btn-link" href="{{ route('admin.enroll.history') }}">
                            <i class="fi-rr-arrow-alt-right"></i>
                        </a>
                    </div>
                </div>

                <div class="ol-card-body table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>{{ get_phrase('Name') }}</th>
                                <th>{{ get_phrase('Phone') }}</th>
                                <th>{{ get_phrase('Course') }}</th>
                                <th>{{ get_phrase('Batch') }}</th>
                                <th>{{ get_phrase('Enrolled Date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($enrolledStudent as $key => $enroll)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $enroll->users->name ?? 'N/A' }}</td>
                                    <td>{{ $enroll->users->phone ?? 'N/A' }}</td>
                                    <td>{{ $enroll->course->title ?? 'N/A' }}</td>
                                    <td>{{ $enroll->batch->name ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($enroll->created_at)->format('d M Y h:i A') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        {{ get_phrase('No enrollments found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row my-3">
        <div class="col-md-5">
            <div class="ol-card">
                <div class="ol-card-body p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="title fs-14px">{{ get_phrase('Course Status') }}</h4>
                        </div>
                        <div class="col-md-6 text-end">
                            <a class="btn-link" href="{{ route('admin.courses') }}" data-bs-toggle="tooltip"
                                data-bs-placement="bottom" title="{{ get_phrase('Explore Courses') }}"><i
                                    class="fi-rr-arrow-alt-right"></i></a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center g-30px flex-wrap flex-xl-nowrap justify-content-center">
                        <div class="pie-chart-sm">
                            <canvas id="pie2"></canvas>
                        </div>
                        <div class="pie-chart-sm-details">
                            <ul class="color-info-list">
                                <li>
                                    <span class="info-list-color bg-active"></span>
                                    <span class="title2 fs-14px">{{ get_phrase('Active') }}</span>
                                </li>
                                <li>
                                    <span class="info-list-color bg-upcoming"></span>
                                    <span class="title2 fs-14px">{{ get_phrase('Upcoming') }}</span>
                                </li>
                                <li>
                                    <span class="info-list-color bg-pending"></span>
                                    <span class="title2 fs-14px">{{ get_phrase('Pending') }}</span>
                                </li>
                                <li>
                                    <span class="info-list-color bg-private"></span>
                                    <span class="title2 fs-14px">{{ get_phrase('Private') }}</span>
                                </li>
                                <li>
                                    <span class="info-list-color bg-draft"></span>
                                    <span class="title2 fs-14px">{{ get_phrase('Draft') }}</span>
                                </li>
                                <li>
                                    <span class="info-list-color bg-inactive"></span>
                                    <span class="title2 fs-14px">{{ get_phrase('Inactive') }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="ol-card" id = 'unpaid-instructor-revenue'>
                <div class="ol-card-body p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="title text-14px mb-3">{{ get_phrase('Pending Requested withdrawal') }}</h4>
                        </div>
                        <div class="col-md-6 text-end">
                            <a class="btn-link" href="{{ route('admin.instructor.payout') }}" data-bs-toggle="tooltip"
                                data-bs-placement="bottom" title="{{ get_phrase('Instructor Payout') }}"><i
                                    class="fi-rr-arrow-alt-right"></i></a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-centered table-hover mb-0">
                            <tbody>
                                @php
                                    $payouts = App\Models\Payout::where('status', '!=', 1)
                                        ->limit(20)
                                        ->orderBy('id')
                                        ->get();
                                @endphp
                                @foreach ($payouts as $payout)
                                    <tr>
                                        <td>
                                            <p class="title fs-14px">{{ get_phrase('Name') }}: {{ $payout->user->name }}
                                            </p>
                                            <small>{{ get_phrase('Email') }}: <span
                                                    class="text-muted font-13">{{ $payout->user->email }}</span></small>
                                        </td>
                                        <td>
                                            <p class="title fs-14px">{{ currency($payout->amount) }}</p>
                                            <small><span
                                                    class="text-muted font-13">{{ get_phrase('Requested withdrawal amount') }}</span></small>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    @php
        $courses = App\Models\Course::get()->groupBy('status');
        $active = isset($courses['active']) ? $courses['active']->count() : 0;
        $upcoming = isset($courses['upcoming']) ? $courses['upcoming']->count() : 0;
        $pending = isset($courses['pending']) ? $courses['pending']->count() : 0;
        $private = isset($courses['private']) ? $courses['private']->count() : 0;
        $draft = isset($courses['draft']) ? $courses['draft']->count() : 0;
        $inactive = isset($courses['inactive']) ? $courses['inactive']->count() : 0;

    @endphp
@endsection

@push('js')

    {{-- Oliv template start --}}
    <script src="{{ asset('assets/backend/vendors/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/backend/vendors/chart-js/chart.js') }}"></script>
    {{-- Oliv template end --}}


    <script>
        "use strict";

        const xValues = [0, "January", "February", "March", "April", "May", "June", "July", "August", "September",
            "October", "November", "December"
        ];
        new Chart("myChart", {
            type: "line",
            data: {
                labels: xValues,
                datasets: [{
                    label: "{{ get_phrase('Admin revenue') }}",
                    fill: false,
                    lineTension: 0,
                    backgroundColor: "rgba(0,0,255,1.0)",
                    borderColor: "rgba(0,0,255,0.1)",
                    data: <?php print_r(json_encode($monthly_amount)); ?>
                }]
            },
            options: {
                legend: {
                    display: true
                },
            }
        });


        // Pie Chart 2
        const project_progress2 = document.getElementById('pie2');
        const progressData2 = {
            labels: ['Active', 'Upcoming', 'Pending', 'Private', 'Draft', 'Inactive'],
            data: [{{ $active }}, {{ $upcoming }}, {{ $pending }}, {{ $private }},
                {{ $draft }}, {{ $inactive }}
            ],
        };
        var barColors = [
            "#12c093",
            "#1b84ff",
            "#ff2583",
            "#000",
            "#878d97",
            "#dadada",
        ];
        new Chart(project_progress2, {
            type: 'doughnut',
            data: {
                labels: progressData2.labels,
                datasets: [{
                    backgroundColor: barColors,
                    label: ' {{ get_phrase('Courses') }}',
                    data: progressData2.data,
                }, ],
            },
            options: {
                responsive: true,
                borderWidth: 5,
                hoverBorderColor: '#fff',
                plugins: {
                    legend: {
                        display: false,
                    },
                },
            },
        });
    </script>
@endpush
