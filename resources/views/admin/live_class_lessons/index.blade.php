@extends('layouts.admin')
@push('title', get_phrase('Upload Live Classes'))

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
@section('content')
    <!-- Header -->
    <div class="ol-card radius-8px mb-3">
        <div class="ol-card-body my-3 py-12px px-20px d-grid gap-2 gap-md-0 d-md-flex align-items-center justify-content-between">

            {{-- Title --}}
            <h4 class="title fs-16px mb-0">
                <i class="fi-rr-video-camera me-2"></i>
                {{ get_phrase('Live Classes Lecture') }}
            </h4>

            {{-- Buttons --}}
            <div class="d-flex gap-2">
                <a href="https://vimeo.com/log_in" target="_blank" class="px-2 px-md-3 btn ol-btn-primary">
                    <i class="fi-rr-plus"></i>
                    {{ get_phrase('Go to Vimeo') }}
                </a>

                <a href="{{ route('admin.live-class-lessons.create') }}" class="px-2 px-md-3 btn ol-btn-primary">
                    <i class="fi-rr-plus"></i>
                    {{ get_phrase('Upload Live Class') }}
                </a>
            </div>

        </div>
    </div>

    <!-- Table Card -->
    <div class="ol-card">
        <div class="ol-card-body p-3">
            <div class="table-responsive">
                <div class="ol-card mb-3">
                    <div class="ol-card-body">
                        <form action="{{ route('admin.live-class-lessons.list') }}" method="GET"
                            class="row g-2 align-items-end">

                            <div class="col-md-2">
                                <label class="form-label">{{ get_phrase('Batch') }}</label>
                                <select name="batch_id" class="ol-select2 form-control batch-search">
                                    <option value="">{{ get_phrase('All Batches') }}</option>
                                    @foreach ($batches as $batch)
                                        <option value="{{ $batch->id }}"
                                            {{ request('batch_id') == $batch->id ? 'selected' : '' }}>
                                            {{ $batch->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Course Filter -->
                            <!--<div class="col-md-3">-->
                            <!--    <label class="form-label">{{ get_phrase('Course') }}</label>-->
                            <!--    <select name="course_id" class="form-control ol-form-control">-->
                            <!--        <option value="">{{ get_phrase('All Courses') }}</option>-->
                            <!--        @foreach ($courses as $course)-->
                            <!--            <option value="{{ $course->id }}"-->
                            <!--                {{ request('course_id') == $course->id ? 'selected' : '' }}>-->
                            <!--                {{ $course->title }}-->
                            <!--            </option>-->
                            <!--        @endforeach-->
                            <!--    </select>-->
                            <!--</div>-->


                            <!-- From Date -->
                            <div class="col-md-3">
                                <label class="form-label">{{ get_phrase('From Date') }}</label>
                                <input type="date" name="from_date" value="{{ request('from_date') }}"
                                    class="form-control ol-form-control">
                            </div>

                            <!-- To Date -->
                            <div class="col-md-3">
                                <label class="form-label">{{ get_phrase('To Date') }}</label>
                                <input type="date" name="to_date" value="{{ request('to_date') }}"
                                    class="form-control ol-form-control">
                            </div>

                            <!-- Filter Button -->
                            <div class="col-md-2">
                                <button type="submit" class="btn ol-btn-primary w-100">
                                    <i class="fi-rr-filter"></i> {{ get_phrase('Filter') }}
                                </button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('admin.live-class-lessons.list') }}" class="btn ol-btn-light w-100">
                                    <i class="fi-rr-refresh"></i>
                                    {{ get_phrase('Reset') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                            <th>{{ get_phrase('#') }}</th> <!-- Serial Number Column -->
                            <th>{{ get_phrase('Title') }}</th>
                            <th>{{ get_phrase('Batch') }}</th>
                            <th>{{ get_phrase('Course') }}</th>
                            <th>{{ get_phrase('Video') }}</th>
                            <th>{{ get_phrase('Duration') }}</th>
                            <th>{{ get_phrase('Created') }}</th>
                            <th class="text-center">{{ get_phrase('Action') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($lessons as $lesson)
                            <tr>
                                <td>{{ $lessons->firstItem() + $loop->index }}</td> <!-- Pagination-safe Serial Number -->
                                <td>{{ $lesson->LiveSchedule->title ?? 'N/A' }}</td>
                                <td>{{ $lesson->batch->name ?? 'N/A' }}</td>
                                <td>
                                    @php
                                        $courseIds = json_decode($lesson->batch->course_id ?? '[]', true);

                                        $titles = collect($courseIds)
                                            ->map(fn($id) => $courseMap[$id] ?? null)
                                            ->filter()
                                            ->implode(', ');
                                    @endphp

                                    {{ $titles ?: 'N/A' }}
                                </td>
                                <td>
                                    <a href="{{ $lesson->lesson_src }}" target="_blank"
                                        class="btn ol-btn-primary btn-sm p-2">
                                        <i class="fi-rr-play"></i> {{ __('Preview') }}
                                    </a>
                                </td>
                                <td>{{ $lesson->duration }}</td>
                                <td>
                                    {{ $lesson->created_at ? $lesson->created_at->format('d M Y h:i A') : '' }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.live-class-lessons.edit', $lesson->id) }}"
                                        class="btn border btn-sm mb-1">
                                        <i class="fi-rr-edit"></i> {{ get_phrase('Edit') }}
                                    </a>

                                    <form action="{{ route('admin.live-class-lessons.delete', $lesson->id) }}"
                                        method="POST" style="display:inline-block;" onsubmit="return confirmDelete();">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn border btn-sm mb-1">
                                            <i class="fi-rr-trash"></i> {{ get_phrase('Delete') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        @if (count($lessons) == 0)
                            <tr>
                                <td colspan="6" class="text-center">{{ get_phrase('No Live Classes Found') }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                </div>
                <div class="mt-3">
                    {{ $lessons->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

<script>

    document.addEventListener('DOMContentLoaded', function() {
        const batchSelect = document.querySelector('select[name="batch_id"]');
        const courseSelect = document.querySelector('select[name="course_id"]');

        batchSelect.addEventListener('change', function() {
            const batchId = this.value;
            if (!batchId) {
                courseSelect.innerHTML = '<option value="">{{ __('All Courses') }}</option>';
                return;
            }

            // Use Laravel route with placeholder replaced
            const url = "{{ route('admin.live-class-batch-by-course', ':batchId') }}".replace(
                ':batchId', batchId);

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    courseSelect.innerHTML = '<option value="">{{ __('All Courses') }}</option>';
                    data.forEach(course => {
                        const option = document.createElement('option');
                        option.value = course.id;
                        option.textContent = course.title;
                        courseSelect.appendChild(option);
                    });
                });
        });
    });
</script>
<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this live class?');
    }
</script>
<script>
$(document).ready(function () {

    $('.batch-search').select2({
        placeholder: "Search Batch",
        allowClear: true,
        width: '100%'
    });

});
</script>
