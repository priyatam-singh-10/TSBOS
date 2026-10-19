@extends('layouts.admin')
@push('title', get_phrase('Edit Batch'))
@php
    use App\Models\Course;
    use App\Models\CourseBundle;
    $courses = Course::where('status', 'active')->get(); // get active courses
    $bundles = CourseBundle::where('status', 'active')->get();
@endphp

@section('content')
    <div class="container-fluid">

        <div class="ol-card radius-8px">
            <div class="ol-card-body my-3 py-4 px-20px">
                <h4 class="title fs-16px">
                    <i class="fi-rr-edit me-2"></i>
                    {{ get_phrase('Edit Batch') }}
                </h4>
            </div>
        </div>

        <div class="ol-card p-3">
            <div class="ol-card-body">

                {{-- ✅ UPDATE FORM --}}
                <form action="{{ route('admin.batch.update', $batch->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        {{-- LEFT SIDE --}}
                        <div class="col-md-6">

                            {{-- Batch Name --}}
                            <div class="mb-3">
                                <label class="form-label">
                                    Batch Name <span class="text-danger">*</span>
                                </label>

                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $batch->name) }}" required>
                            </div>

                            {{-- Start Date --}}
                            <div class="mb-3">
                                <label class="form-label">Start Date <span class="text-danger">*</span></label>

                                <input type="date" name="start_date" id="start_date" class="form-control"
                                    value="{{ old('start_date', $batch->start_date) }}" required>
                            </div>

                            {{-- Batch Price --}}
                            <div class="mb-3">
                                <label class="form-label">Batch Price <span class="text-danger">*</span></label>

                                <input type="number" step="0.01" name="batch_price" class="form-control"
                                    value="{{ old('batch_price', $batch->batch_price) }}">
                            </div>

                            {{-- No of Lecture --}}
                            <div class="mb-3">
                                <label class="form-label">No of Lectures <span class="text-danger">*</span></label>

                                <input type="number" name="no_of_live_class" class="form-control"
                                    value="{{ old('no_of_live_class', $batch->no_of_live_class) }}" required>
                            </div>

                        </div>

                        {{-- RIGHT SIDE --}}
                        <div class="col-md-6">

                           
                            
                            <div class="mb-3">
                                    <label class="form-label">
                                        Select Bundle <span class="text-danger">*</span>
                                    </label>
                                
                                    <select class="ol-select2" name="bundle_id" required>
                                
                                        <option value="">Select Bundle</option>
                                
                                        @foreach ($bundles as $bundle)
                                            <option value="{{ $bundle->id }}"
                                                {{ old('bundle_id', $batch->bundle_id ?? '') == $bundle->id ? 'selected' : '' }}>
                                                {{ $bundle->title }}
                                            </option>
                                        @endforeach
                                
                                    </select>
                                </div>

                            {{-- End Date --}}
                            <div class="mb-3">
                                <label class="form-label">End Date *</label>

                                <input type="date" name="end_date" id="end_date" class="form-control"
                                    value="{{ old('end_date', $batch->end_date) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="thumbnail">
                                    Batch Thumbnail <span class="text-danger">*</span>
                                </label>

                                <input type="file" name="thumbnail" class="form-control"
                                    accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                                    {{ $batch->thumbnail ? '' : 'required' }}>

                                @if ($batch->thumbnail)
                                    <small class="text-muted">Current Thumbnail:</small>
                                    <div class="pt-1">
                                        <img src="{{ asset($batch->thumbnail) }}" alt="Thumbnail" width="120"
                                            class="rounded">
                                    </div>
                                @endif
                            </div>
                            {{-- Description --}}
                            <div class="mb-3">
                                <label class="form-label">
                                    Batch Description
                                </label>

                                <textarea name="description" class="form-control text_editor" rows="6">{{ old('description', $batch->description) }}</textarea>
                            </div>

                            {{-- Status --}}
                            <div class="mb-3">
                                <label>Status</label>

                                <select name="status" class="form-control">
                                    <option value="1" {{ $batch->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $batch->status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                        </div>

                        <div class="pt-2">
                            <button class="btn ol-btn-primary float-end">
                                Update Batch
                            </button>

                            <a href="{{ route('admin.batch.index') }}" class="btn btn-secondary">
                                Back
                            </a>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>

<script>
    window.onload = function() {
        CKEDITOR.replace('description', {
            height: 250
        });
    };
</script>
@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const startInput = document.getElementById('start_date');
            const endInput = document.getElementById('end_date');

            const today = new Date().toISOString().split('T')[0];

            // Initial disable
            endInput.min = today;

            startInput.addEventListener('change', function() {

                let startDate = this.value;

                if (startDate) {
                    endInput.min = startDate;

                    if (endInput.value < startDate) {
                        endInput.value = '';
                    }
                }
            });

        });
    </script>

@endpush
