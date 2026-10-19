@extends('layouts.admin')
@push('title', get_phrase('Edit Live Class'))

@section('content')
    <!-- Header -->
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="title fs-16px">
                    <i class="fi-rr-video-camera me-2"></i>
                    {{ get_phrase('Edit Live Class Schedule') }}
                </h4>

                <a href="{{ route('admin.live-class-schedule.list') }}" class="btn ol-btn-light">
                    <i class="fi-rr-arrow-left"></i>
                    Back
                </a>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="ol-card">
        <div class="ol-card-body">

            <form action="{{ route('admin.live-class-schedule.update', $liveClass->id) }}" method="POST"
                enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="row">

                    <!-- Batch -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Batch <span class="text-danger">*</span></label>

                        <select name="batch_id" class="form-control ol-form-control ol-select2" required>

                            <option value="">Select Batch</option>

                            @foreach ($batches as $batch)
                                <option value="{{ $batch->id }}"
                                    {{ $liveClass->batch_id == $batch->id ? 'selected' : '' }}>
                                    {{ $batch->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>

                        <input type="text" name="title" value="{{ $liveClass->title }}"
                            class="form-control ol-form-control" placeholder="Enter title" required>
                    </div>
                    <!-- Class Date & Time -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Class Date & Time <span class="text-danger">*</span></label>

                        <input type="datetime-local" name="class_date_and_time"
                            value="{{ date('Y-m-d\TH:i', strtotime($liveClass->class_date_and_time)) }}"
                            class="form-control ol-form-control" required>
                    </div>


                    <!-- Thumbnail -->
                    {{-- <div class="col-md-6 mb-3">
                        <label class="form-label">Thumbnail</label>

                        <input type="file" name="thumbnail" class="form-control ol-form-control">

                        @if ($liveClass->thumbnail)
                            <img src="{{ asset($liveClass->thumbnail) }}" width="120" class="mt-2">
                        @endif
                    </div> --}}

                    <!-- Description -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Description</label>

                        <textarea name="description" class="form-control ol-form-control" rows="4">{{ $liveClass->description }}</textarea>
                    </div>
                    {{-- 
                    <div class="col-md-12 mb-3">
                        <label class="form-label">
                            Curriculum <span class="text-danger">*</span>
                        </label>

                        <textarea name="curriculum" id="curriculum_editor" class="form-control ol-form-control" rows="6"
                            placeholder="Enter curriculum...">{{ old('curriculum', $liveClass->curriculum) }}</textarea>
                    </div> --}}
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
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <script>
        let editor;

        ClassicEditor
            .create(document.querySelector('#curriculum_editor'))
            .then(newEditor => {
                editor = newEditor;
            })
            .catch(error => {
                console.error(error);
            });


        // IMPORTANT → form submit sync
        document.querySelector('form').addEventListener('submit', function() {
            if (editor) {
                document.querySelector('#curriculum_editor').value = editor.getData();
            }
        });
    </script>

@endpush
