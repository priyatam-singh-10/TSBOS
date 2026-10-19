@extends('layouts.admin')
@push('title', get_phrase('Edit Live Class'))

@section('content')
    <!-- Header -->
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex justify-content-between align-items-center">

                <h4 class="title fs-16px">
                    <i class="fi-rr-video-camera me-2"></i>
                    {{ get_phrase('Edit Live Class') }}
                </h4>

                <a href="{{ route('admin.live-class-lessons.list') }}" class="btn ol-btn-light">
                    <i class="fi-rr-arrow-left"></i>
                    Back
                </a>

            </div>
        </div>
    </div>


    <!-- Form -->
    <div class="ol-card">
        <div class="ol-card-body">

            <form action="{{ route('admin.live-class-lessons.update', $lesson->id) }}" method="POST">
                @csrf
                {{-- @method('PUT') --}}

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
                                    {{ old('batch_id', $lesson->batch_id) == $batch->id ? 'selected' : '' }}>
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

                            @foreach ($schedules as $schedule)
                                <option value="{{ $schedule->id }}"
                                    {{ old('schedule_id', $lesson->schedule_id) == $schedule->id ? 'selected' : '' }}>
                                    {{ $schedule->title }}
                                </option>
                            @endforeach

                        </select>
                    </div>


                    <!-- Vimeo URL -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Vimeo Video URL <span class="text-danger">*</span>
                        </label>

                        <input type="text" id="vimeo_url" name="lesson_src" class="form-control ol-form-control"
                            placeholder="Enter Vimeo URL" value="{{ old('lesson_src', $lesson->lesson_src) }}" required>
                    </div>


                    <!-- Duration -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Duration <span class="text-danger">*</span>
                        </label>

                        <input type="text" id="duration" name="duration" class="form-control ol-form-control"
                            value="{{ old('duration', $lesson->duration) }}" readonly required>
                    </div>


                    <!-- Submit -->
                    <div class="col-md-12 text-end">
                        <button type="submit" class="btn ol-btn-primary">
                            <i class="fi-rr-check"></i>
                            Update Live Class
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

            /* ===============================
               SELECT2 INIT
            ===============================*/
            $('.select2').select2({
                width: '100%',
                placeholder: "Select option",
                allowClear: true
            });


            /* ===============================
               VIMEO DURATION AUTO FETCH
            ===============================*/
            $('#vimeo_url').on('change', function() {

                let url = $(this).val().trim();
                if (!url) return;

                fetch("{{ route('get.video.details') }}?url=" + encodeURIComponent(url))
                    .then(res => res.json())
                    .then(data => {

                        if (data && data.duration) {
                            $('#duration').val(data.duration);
                        }

                    })
                    .catch(err => console.log(err));
            });


            /* ===============================
               BATCH CHANGE → LOAD TITLES
            ===============================*/
            $(document).on('change', '#batch_id', function() {

                let batchId = $(this).val();
                let dropdown = $('#schedule_id');

                dropdown.html('<option>Loading...</option>');

                if (!batchId) {
                    dropdown.html('<option value="">Select Title</option>');
                    return;
                }

                fetch("{{ route('admin.get.live.class.titles', '') }}/" + batchId)
                    .then(res => res.json())
                    .then(data => {

                        dropdown.html('<option value="">Select Title</option>');

                        data.forEach(item => {
                            dropdown.append(
                                `<option value="${item.id}">${item.title}</option>`
                            );
                        });

                        // select2 refresh
                        dropdown.trigger('change.select2');

                    })
                    .catch(err => console.log(err));

            });

        });
    </script>
@endpush
