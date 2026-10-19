@extends('layouts.admin')
@push('title', get_phrase('Upload Live Class'))

@section('content')
    <!-- Header -->
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex justify-content-between align-items-center">

                <h4 class="title fs-16px">
                    <i class="fi-rr-video-camera me-2"></i>
                    {{ get_phrase('Upload Live Class') }}
                </h4>

                <a href="{{ route('admin.live-class-lessons.list') }}" class="btn ol-btn-light">
                    <i class="fi-rr-arrow-left"></i>
                    Back
                </a>

            </div>
        </div>
    </div>


    <!-- Form Card -->
    <div class="ol-card">
        <div class="ol-card-body">

            <form action="{{ route('admin.live-class-lessons.store') }}" method="POST">
                @csrf

                <div class="row">

                    <!-- Batch -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Batch <span class="text-danger">*</span>
                        </label>

                        <select name="batch_id" id="batch_id" class="form-control ol-form-control ol-select2 select2" required>
                            <option value="">Select Batch</option>
                            @foreach ($batches as $batch)
                                <option value="{{ $batch->id }}"
                                    {{ old('batch_id', isset($lesson) ? $lesson->batch_id : '') == $batch->id ? 'selected' : '' }}>
                                    {{ $batch->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Live Class Title -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Live Class Title <span class="text-danger">*</span>
                        </label>

                        <select name="schedule_id" id="schedule_id" class="form-control ol-form-control" required>

                            <option value="">Select Title</option>

                        </select>
                    </div>
                    <!-- Vimeo URL -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Vimeo Video URL <span class="text-danger">*</span>
                        </label>

                        <input type="text" id="vimeo_url" name="lesson_src" class="form-control ol-form-control"
                            placeholder="Enter Vimeo URL"
                            value="{{ old('lesson_src', isset($lesson) ? $lesson->lesson_src : '') }}" required>
                    </div>

                    <!-- Duration -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Duration <span class="text-danger">*</span>
                        </label>

                        <input type="text" id="duration" name="duration" class="form-control ol-form-control"
                            placeholder="Duration will appear here"
                            value="{{ old('duration', isset($lesson) ? $lesson->duration : '') }}" required readonly>
                    </div>

                    <!-- Submit -->
                    <div class="col-md-12 text-end">
                        <button type="submit" class="btn ol-btn-primary">
                            <i class="fi-rr-check"></i>
                            Save Live Class
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#batch_id').select2({
                placeholder: "Select Batch",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const vimeoInput = document.getElementById('vimeo_url');
            const durationInput = document.getElementById('duration');

            vimeoInput.addEventListener('change', function() {
                const url = this.value.trim();
                if (!url) return;

                // AJAX call to get.video.details route with full URL
                fetch("{{ route('get.video.details') }}?url=" + encodeURIComponent(url))
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.duration) {
                            // Directly set HH:MM:SS from response
                            durationInput.value = data.duration;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching video details:', error);
                    });
            });
        });
        $(document).on('change', '#batch_id', function() {

            let batchId = $(this).val();
            let titleDropdown = $('#schedule_id');

            titleDropdown.html('<option value="">Loading...</option>');

            if (!batchId) {
                titleDropdown.html('<option value="">Select Title</option>');
                return;
            }

            fetch("{{ route('admin.get.live.class.titles', '') }}/" + batchId)
                .then(response => response.json())
                .then(data => {

                    titleDropdown.html('<option value="">Select Title</option>');

                    data.forEach(item => {
                        titleDropdown.append(
                            `<option value="${item.id}">${item.title}</option>`
                        );
                    });

                })
                .catch(error => console.error(error));
        });
    </script>
@endpush
