@extends('layouts.admin')
@push('title', get_phrase('Batch Manager'))
@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <div class="container-fluid">
        <div class="ol-card radius-8px">
            <div class="ol-card-body my-3 py-12px px-20px">
                <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                    <h4 class="title fs-16px">
                        <i class="fi-rr-settings-sliders me-2"></i>
                        Manage Batches
                    </h4>

                    <a href="{{ route('admin.batch.create') }}"
                        class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                        <span class="fi-rr-plus"></span>
                        <span>Add New Batch</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif --}}

        <div class="card">
            <div class="card-body table-responsive">
                {{-- <div class="card mb-3">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.batch.index') }}">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Search batch or course" value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Filter by batch name" value="{{ request('name') }}">
                                </div>
                                <div class="col-md-3">
                                    <select name="course_id" class="form-control">
                                        <option value="">All Courses</option>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->id }}"
                                                {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                                {{ $course->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-primary">Filter</button>
                                    <a href="{{ route('admin.batch.index') }}" class="btn btn-secondary">
                                        Reset
                                    </a>
                                </div>

                            </div>
                        </form>
                    </div>
                </div> --}}

                <div class="table-responsive course_list overflow-auto overflow-autoo">
                    <table id="batchTable" class="eTable eTable-2 print-table table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Course</th>
                                <th width="85">Start Date</th>
                                <th width="85">End Date</th>
                                {{-- <th scope="col">Max Students</th> --}}
                                <th scope="col">No of Live Classes</th>
                                <th scope="col">Progress</th>
                                <th scope="col">Created</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($batches as $key => $batch)
                                <tr>
                                    <th scope="row">
                                        <p class="row-number">{{ $key + 1 }}</p>
                                    </th>

                                    <td>
                                        <div class="sub-title2 text-12px">{{ $batch->name }}</div>
                                    </td>
                                    <td>
                                        <div class="sub-title2 text-12px">{{ $batch->course->title ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <div class="sub-title2 text-12px">{{ $batch->start_date }}</div>
                                    </td>
                                    <td>
                                        <div class="sub-title2 text-12px">{{ $batch->end_date }}</div>
                                    </td>
                                    {{-- <td>
                                        <div class="sub-title2 text-12px">{{ $batch->max_students }}</div>
                                    </td> --}}
                                    <td>
                                        <div class="sub-title2 text-12px">{{ $batch->no_of_live_class }}</div>
                                    </td>
                                    <td>
                                        @php
                                            $total = $batch->no_of_live_class; // ya no_of_live_classes (jo bhi column hai)
                                            $done = $batch->lessons_count;

                                            $percent = $total > 0 ? ($done / $total) * 100 : 0;
                                        @endphp

                                        <p>{{ $done }} / {{ $total }} </p>

                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar"
                                                style="width: {{ $percent }}%">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="sub-title2 text-12px">
                                            {{ date('d M Y h:i A', strtotime($batch->created_at)) }}</div>
                                    </td>
                                    <td>
                                        @if ($batch->status == 1)
                                            <span class="badge bg-active">Active</span>
                                        @else
                                            <span class="badge bg-inactive">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent">
                                            <button class="btn ol-btn-secondary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="fi-rr-menu-dots-vertical"></span>
                                            </button>

                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" target="_blank"
                                                        href="{{ route('admin.batch.edit', $batch->id) }}">
                                                        <i class="fi-rr-edit me-2"></i>{{ get_phrase('Edit') }}
                                                    </a>
                                                </li>

                                                <li>
                                                    <form action="{{ route('admin.batch.destroy', $batch->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="#" class="dropdown-item"
                                                            onclick="event.preventDefault(); if(confirm('Delete this batch?')) this.closest('form').submit();">
                                                            <i class="fi-rr-trash me-2"></i>Delete
                                                        </a>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No batches found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- <div class="mt-3">
                    {{ $batches->links() }}
                </div> --}}
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            $('#batchTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true
            });

            $('#batchTable_filter').append(
                '<a href="{{ route('admin.batch.index') }}" class="btn btn-secondary ms-2">Reset</a>'
            );

        });
    </script>
@endsection
