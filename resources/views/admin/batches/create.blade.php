@php
    use App\Models\Course;
    use App\Models\CourseBundle;

    $courses = Course::where('status', 'active')->get();
    $bundles = CourseBundle::where('status', 'active')->get();
@endphp

@extends('layouts.admin')
@push('title', get_phrase('Batch Manager'))

@section('content')
    <div class="container-fluid">
        <div class="ol-card radius-8px">
            <div class="ol-card-body my-3 py-4 px-20px">
                <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                    <h4 class="title fs-16px">
                        <i class="fi-rr-settings-sliders me-2"></i>
                        {{ get_phrase('Add New Batch') }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="ol-card p-3">
            <div class="ol-card-body">

                <form action="{{ route('admin.batch.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 pb-2">
                            <div class="eForm-layouts">
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label"
                                        for="name">{{ get_phrase('Batch Name') }}<span
                                            class="text-danger ms-1">*</span></label>
                                    <input type="text" name="name" class="form-control ol-form-control" maxlength="50"
                                        placeholder="{{ get_phrase('Enter Course Batch Name') }}"
                                        value="{{ old('name') }}" oninput="this.value = this.value.replace(/^\s+/, '')"
                                        required>
                                </div>

                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label" for="start_date">
                                        {{ get_phrase('Start Date') }}
                                        <span class="text-danger ms-1">*</span>
                                    </label>

                                    <input type="date" name="start_date" id="start_date"
                                        class="form-control ol-form-control" min="{{ date('Y-m-d') }}"
                                        value="{{ old('start_date') }}" required>
                                </div>
                                {{-- <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label"
                                        for="max_students">{{ get_phrase('Max Students') }}</label>
                                    <input type="number" name="max_students" class="form-control ol-form-control">
                                </div> --}}
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label"
                                        for="no_of_live_class">{{ get_phrase('Batch Price') }}
                                        <span class="text-danger ms-1">*</span>
                                    </label>

                                    <input type="number" name="batch_price" class="form-control ol-form-control"
                                        step="0.01" value="{{ old('batch_price') }}">
                                </div>
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label"
                                        for="no_of_live_class">{{ get_phrase('No of Lectures') }}<span
                                            class="text-danger ms-1">*</span></label>
                                    <input type="number" name="no_of_live_class" class="form-control ol-form-control"
                                        value="{{ old('no_of_live_class') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="eForm-layouts">
                                <div class="fpb-7 mb-3">
                                    <label for="course_id"
                                        class="form-label ol-form-label">{{ get_phrase('Select Bundal') }}<span
                                            class="text-danger ms-1">*</span></label>
                                    <!--<select class="ol-select2" name="course_id[]" multiple required>-->
                                    <!--    <option value="">{{ get_phrase('Select a course') }}</option>-->

                                    <!--    @foreach ($courses as $course)-->
                                    <!--        <option value="{{ $course->id }}"-->
                                    <!--            {{ collect(old('course_id'))->contains($course->id) ? 'selected' : '' }}>-->
                                    <!--            {{ $course->title }}-->
                                    <!--        </option>-->
                                    <!--    @endforeach-->
                                    <!--</select>-->
                                 <select class="ol-select2" name="item_id" required>

                                        <option value="">Select Course / Bundle</option>
                                    
                                             {{-- Bundles --}}
                                        <optgroup label="Bundles">
                                            @foreach ($bundles as $bundle)
                                                <option value="bundle_{{ $bundle->id }}">
                                                    {{ $bundle->title }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                        
                                        {{-- Courses --}}
                                        <optgroup label="Courses">
                                            @foreach ($courses as $course)
                                                <option value="course_{{ $course->id }}">
                                                    {{ $course->title }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    
                               
                                    
                                    </select>
                                    <!--<div id="course_ids_container"></div>-->
                                    <!--<input type="hidden" name="course_id[]" id="course_ids_input">-->
                                </div>
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label"
                                        for="end_date">{{ get_phrase('End Date') }}<span
                                            class="text-danger ms-1">*</span></label>
                                    <input type="date" name="end_date" id="end_date"
                                        class="form-control ol-form-control" min="{{ date('Y-m-d') }}"
                                        value="{{ old('end_date') }}" required>
                                </div>
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label" for="thumbnail">
                                        {{ get_phrase('Batch Thumbnail') }}<span class="text-danger ms-1">*</span>
                                    </label>
                                    <input type="file" name="thumbnail" class="form-control ol-form-control"
                                        accept="image/*">
                                </div>
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label">
                                        {{ get_phrase('Batch Description') }}
                                    </label>

                                    <textarea name="description" class="form-control ol-form-control text_editor" rows="6">{{ old('description') }}</textarea>
                                </div>
                                <div class="fpb-7 mb-3">
                                    <label for="status"
                                        class="form-label ol-form-label">{{ get_phrase('Status') }}</label>
                                    <select class="ol-select2" name="status">
                                        <option value="1">{{ get_phrase('Active') }} </option>
                                        <option value="0">{{ get_phrase('Inactive') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="pt-2">
                            <button class="btn ol-btn-primary float-end">{{ get_phrase('Save Batch') }}</button>
                            <a href="{{ route('admin.batch.index') }}" class="btn btn-secondary">
                                {{ get_phrase('Back') }}
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
