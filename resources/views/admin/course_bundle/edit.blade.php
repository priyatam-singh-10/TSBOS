@extends('layouts.admin')
@push('title', get_phrase('Edit course bundle'))

@section('content')
    <div class="row mb-5">
        <div class="col-lg-12">
            <div class="ol-card radius-8px">
                <div class="ol-card-body my-3 py-4 px-20px">
                    <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                        <h4 class="title fs-16px">
                            <i class="fi-rr-settings-sliders me-2"></i>
                            {{ get_phrase('Edit course bundle') }}
                        </h4>
                        <div>
                            <a href="{{ url()->previous() }}"
                                class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                                <i class="fi-rr-arrow-left me-1"></i> {{ get_phrase('Back') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ol-card p-3">
                <div class="ol-card-body">
                    <form action="{{ route('admin.course.bundle.update', $course_bundle->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}<span
                                        class="text-danger ms-1">*</span></label>
                                <input type="text" class="form-control ol-form-control" name="title" id="title"
                                    value="{{ $course_bundle->title }}" required>
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
                                    $current_course_ids = json_decode($course_bundle->course_ids, true);
                                @endphp
                                <select name="course_ids[]" id="select_bundle_courses" {{-- onchange="current_price_of_selected_courses(this)" --}}
                                    class="select2 form-control select2-multiple" data-toggle="select2" multiple="multiple"
                                    required>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}"
                                            {{ in_array($course->id, $current_course_ids) ? 'selected' : '' }}>
                                            {{ $course->title }}
                                        </option>
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
                                    value="{{ $course_bundle->price }}" required>
                            </div>
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label"
                                    for="subscription_limit">{{ get_phrase('validity') }}<span
                                        class="text-danger ms-1">*</span></label>
                                <!--<input type="number" class="form-control ol-form-control" name="subscription_limit" id="subscription_limit" value="{{ $course_bundle->subscription_limit }}" required>-->
                                <input type="hidden" name="subscription_limit" value="0">
                                <p class="form-control ol-form-control bg-light">
                                    {{ get_phrase('Lifetime Access') }}
                                </p>
                            </div>

                            <div class="fpb-7 mb-3">
                                <label for="banner" class="form-label ol-form-label">{{ get_phrase('Thumbnail') }}<span
                                        class="text-danger ms-1">*</span></label>
                                <div class="col-sm-10">
                                    <input type="file" name="thumbnail" class="form-control ol-form-control"
                                        id="banner" />
                                </div>
                            </div>
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label"
                                    for="bundle_details">{{ get_phrase('Bundle details') }}<span
                                        class="text-danger ms-1">*</span></label>
                                <textarea name="bundle_details" class="form-control ol-form-control text_editor">{{ $course_bundle->bundle_details }}</textarea>
                            </div>
                            <div class="pt-2">
                                <button type="submit"
                                    class="btn ol-btn-primary float-end">{{ get_phrase('Update bundle') }}</button>
                            </div>
                            <!--<div class="tab-content w-100">-->
                            <!--    @include('admin.course_bundle.edit_seo')-->
                            <!--</div>-->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        "use strict";

        var selectedCoursesOrder = [];
        var currentCoursesPrice = 0;

        $(document).ready(function() {

            selectedCoursesOrder = $('#select_bundle_courses').val() || [];

            current_price_of_selected_courses();

            $('#select_bundle_courses').on('select2:select select2:unselect', function(e) {
                selectedCoursesOrder = $(this).val() || [];
                current_price_of_selected_courses();
            });

            // 🔥 FORM SUBMIT TIME ORDER FIX + VALIDATIONS
            $('form').on('submit', function(e) {

                // Remove previous errors
                $('.validation-error').remove();

                let isValid = true;

                // Validation 1: At least 2 courses
                if (selectedCoursesOrder.length < 2) {
                    $('#select_bundle_courses').after(
                        '<div class="text-danger validation-error">{{ get_phrase('Please select at least 2 courses.') }}</div>'
                    );
                    isValid = false;
                }

                // Validation 2: Bundle price <= total selected courses price
                var bundlePrice = parseFloat($('#price').val());
                if (!isNaN(bundlePrice) && bundlePrice > currentCoursesPrice) {
                    $('#price').after(
                        '<div class="text-danger validation-error">{{ get_phrase('Bundle price cannot exceed total price of selected courses.') }}</div>'
                    );
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                    return false;
                }

                // 🔥 Fix selected order
                var select = $('#select_bundle_courses');
                selectedCoursesOrder.forEach(function(id) {
                    var option = select.find('option[value="' + id + '"]');
                    select.append(option);
                });

            });

        });

        function current_price_of_selected_courses() {

            if (selectedCoursesOrder.length === 0) {
                currentCoursesPrice = 0;
                $('#current_price_of_the_courses').html("{{ get_phrase('Current price of the courses is') }} ₹0");
                return;
            }

            $.ajax({
                type: 'POST',
                url: "{{ route('admin.course.bundle.current_price') }}",
                data: {
                    selected_course_id: selectedCoursesOrder,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    var currency_symbol = '₹';
                    currentCoursesPrice = parseFloat(response); // store total price of selected courses
                    $('#current_price_of_the_courses').html(
                        "{{ get_phrase('Current price of the courses is') }} " + currency_symbol + response
                    );
                }
            });

        }
    </script>
@endpush
