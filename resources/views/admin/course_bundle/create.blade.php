@extends('layouts.admin')
@push('title', get_phrase('Create crouse bundle'))

@section('content')
    <div class="row mb-5">
        <div class="col-lg-12">
            <div class="ol-card radius-8px">
                <div class="ol-card-body my-3 py-4 px-20px">
                    <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                        <h4 class="title fs-16px">
                            <i class="fi-rr-settings-sliders me-2"></i>
                            {{ get_phrase('Add course bundle') }}
                        </h4>
                    </div>
                </div>
            </div>
            <div class="ol-card p-3">
                <div class="ol-card-body">
                    <form action="{{ route('admin.course.bundle.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}<span
                                        class="text-danger ms-1">*</span></label>
                                <input type="text"
                                    class="form-control ol-form-control @error('title') is-invalid @enderror" name="title"
                                    id="title" value="{{ old('title') }}" maxlength="50"
                                    oninput="this.value = this.value.replace(/^\s+/, '').replace(/\s{2,}/g, ' ')"
                                    placeholder="{{ get_phrase('Course bundle title') }}" required>

                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="fpb-7 mb-3">
                                <label for="course_ids"
                                    class="form-label ol-form-label">{{ get_phrase('Select Courses') }}<span
                                        class="text-danger ms-1">*</span></label>
                                @php
                                    $user_id = auth()->id();
                                    $courses = \App\Models\Course::where('user_id', $user_id)
                                        ->where('status', 'active')
                                        ->get();
                                @endphp
                                <select name="course_ids[]" id="select_bundle_courses" {{-- onchange="current_price_of_selected_courses(this)" --}}
                                    class="select2 form-control select2-multiple" data-toggle="select2" multiple="multiple"
                                    required>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                                    @endforeach
                                </select>
                                <span class="text-muted" id="current_price_of_the_courses">
                                    {{ get_phrase('Current price of the courses is') }} {{ currency() }}
                                </span>
                            </div>
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label"
                                    for="price">{{ get_phrase('Bundle Price') }}<span
                                        class="text-danger ms-1">*</span></label>
                                <input type="number" class="form-control ol-form-control" name="price" id="price"
                                    value="{{ old('price') }}" placeholder="{{ get_phrase('Enter bundle price') }}"
                                    required>
                            </div>
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label"
                                    for="subscription_limit">{{ get_phrase('validity') }}<span
                                        class="text-danger ms-1">*</span></label>
                                <!--<input type="number" class="form-control ol-form-control" name="subscription_limit" id="subscription_limit" placeholder="{{ get_phrase('Enter subscription renew days') }}" required>-->
                                <input type="hidden" name="subscription_limit" value="0">
                                <p class="form-control ol-form-control bg-light">
                                    {{ get_phrase('Lifetime Access') }}
                                </p>
                            </div>
                            <div class="fpb-7 mb-3">
                                <label class="form-label
                                    ol-form-label"
                                    for="thumbnail">{{ get_phrase('Thumbnail') }}<span
                                        class="text-danger ms-1">*</span></label>
                                <input type="file" name="thumbnail" class="form-control ol-form-control" id="thumbnail"
                                    accept="image/*" />
                            </div>
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label"
                                    for="bundle_details">{{ get_phrase('Bundle details') }}<span
                                        class="text-danger ms-1">*</span></label>
                                <textarea name="bundle_details" class="form-control ol-form-control text_editor">{{ old('bundle_details') }}</textarea>

                            </div>
                            <div class="pt-2">
                                <button type="submit"
                                    class="btn ol-btn-primary float-end">{{ get_phrase('Create bundle') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        "use strict";

        var selectedCoursesOrder = [];
        var currentCoursesPrice = 0;

        $(document).ready(function() {

            selectedCoursesOrder = $('#select_bundle_courses').val() || [];

            $('#select_bundle_courses').on('select2:select select2:unselect', function(e) {
                selectedCoursesOrder = $(this).val() || [];
                current_price_of_selected_courses();
            });

            // $('form').on('submit', function(e) {

            //     // Remove previous errors
            //     $('.validation-error').remove();

            //     let isValid = true;

            //     // Validation 1: At least 2 courses
            //     if (selectedCoursesOrder.length < 2) {
            //         $('#select_bundle_courses').after(
            //             '<div class="text-danger validation-error">{{ get_phrase('Please select at least 2 courses.') }}</div>'
            //             );
            //         isValid = false;
            //     }

            //     // Validation 2: Bundle price <= total selected courses price
            //     var bundlePrice = parseFloat($('#price').val());
            //     if (!isNaN(bundlePrice) && bundlePrice > currentCoursesPrice) {
            //         $('#price').after(
            //             '<div class="text-danger validation-error">{{ get_phrase('Bundle price cannot exceed total price of selected courses.') }}</div>'
            //             );
            //         isValid = false;
            //     }

            //     if (!isValid) {
            //         e.preventDefault();
            //         return false;
            //     }
            // });
            $('form').on('submit', function(e) {

                $('.validation-error').remove();
                let isValid = true;

                // DESCRIPTION
                let description = $('[name="bundle_details"]').val().trim();

                if (typeof tinymce !== "undefined" && tinymce.get()) {
                    description = tinymce.activeEditor.getContent().replace(/<[^>]*>/g, '').trim();
                }

                if (!description) {
                    $('[name="bundle_details"]').after(
                        '<div class="text-danger validation-error">Description is required</div>'
                    );
                    isValid = false;
                }

                // THUMBNAIL
                if ($('#thumbnail')[0].files.length === 0) {
                    $('#thumbnail').after(
                        '<div class="text-danger validation-error">Thumbnail is required</div>'
                    );
                    isValid = false;
                }

                // EXISTING VALIDATIONS
                if (selectedCoursesOrder.length < 2) {
                    $('#select_bundle_courses').after(
                        '<div class="text-danger validation-error">Please select at least 2 courses.</div>'
                    );
                    isValid = false;
                }

                var bundlePrice = parseFloat($('#price').val());
                if (!isNaN(bundlePrice) && bundlePrice > currentCoursesPrice) {
                    $('#price').after(
                        '<div class="text-danger validation-error">Bundle price cannot exceed total price.</div>'
                    );
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                }
            });

        });

        function current_price_of_selected_courses() {

            var selected_course_id = selectedCoursesOrder;

            if (selected_course_id.length == 0) {
                currentCoursesPrice = 0;
                $('#current_price_of_the_courses').html("{{ get_phrase('Current price of the courses is') }} ₹0");
                return;
            }

            $.ajax({
                type: 'POST',
                url: "{{ route('admin.course.bundle.current_price') }}",
                data: {
                    selected_course_id: selected_course_id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    var currency_symbol = '₹';
                    currentCoursesPrice = parseFloat(response); // store current courses price
                    $('#current_price_of_the_courses').html(
                        "{{ get_phrase('Current price of the courses is') }} " + currency_symbol + response
                    );
                }
            });

        }
    </script>

@endpush
