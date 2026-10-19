@extends('layouts.admin')
@push('title', get_phrase('Create Live Class'))

@section('content')
    <!-- Header -->
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="title fs-16px">
                    <i class="fi-rr-video-camera me-2"></i>
                    {{ get_phrase('Create Live Class Schedule') }}
                </h4>

                <a href="{{ route('admin.live-class-schedule.list') }}" class="btn ol-btn-light">
                    <i class="fi-rr-arrow-left"></i>
                    Back
                </a>
            </div>
        </div>
    </div>


    <!-- Form Card -->
    <div class="ol-card">
        <div class="ol-card-body">

            <form action="{{ route('admin.live-class-schedule.store') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="row">
                    <!-- Batch -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Batch <span class="text-danger">*</span></label>

                        <select name="batch_id" id="batch_id" class="form-control ol-form-control" required>
                            <option value="">Select Batch</option>

                            @foreach ($batches as $batch)
                                <option value="{{ $batch->id }}">
                                    {{ $batch->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>

                        <input type="text" name="title" class="form-control ol-form-control" placeholder="Enter title"
                            required>
                    </div>
                    <!-- Class Date & Time -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Class Date & Time <span class="text-danger">*</span>
                        </label>

                        <input type="datetime-local" name="class_date_and_time" class="form-control ol-form-control"
                            required>
                    </div>


                    <!-- Price -->
                    {{-- <div class="col-md-6 mb-3">
                        <label class="form-label">Price <span class="text-danger">*</span></label>

                        <input type="number" min="1" name="price" class="form-control ol-form-control"
                            placeholder="Enter price" required>
                    </div> --}}


                    <!-- Thumbnail -->
                    {{-- <div class="col-md-6 mb-3">
                        <label class="form-label">Thumbnail</label>

                        <input type="file" name="thumbnail" class="form-control ol-form-control">
                    </div> --}}


                    <!-- Description -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Description</label>

                        <textarea name="description" class="form-control ol-form-control" rows="4" placeholder="Optional description"></textarea>
                    </div>

                    {{-- <div class="col-md-12 mb-3">
                        <label class="form-label">
                            Curriculum <span class="text-danger">*</span>
                        </label>

                        <textarea name="curriculum" id="curriculum_editor" class="form-control ol-form-control" rows="6"
                            placeholder="Enter curriculum..."></textarea>
                    </div> --}}


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
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#curriculum_editor'))
            .catch(error => {
                console.error(error);
            });
    </script>


@endpush
