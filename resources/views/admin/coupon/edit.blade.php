@php
    $coupon_details = App\Models\Coupon::where('id', $id)->first();
@endphp
<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route('admin.coupon.update', $coupon_details->id) }}" method="post"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="fpb-7 mb-3">
                    <label class="form-label ol-form-label" for="code">{{ get_phrase('Code') }}</label>
                    <input type="text" class="form-control ol-form-control" name="code" id="code"
                        value="{{ $coupon_details->code }}" placeholder="{{ get_phrase('Enter offer code') }}" required>
                </div>

                <div class="fpb-7 mb-3">
                    <label class="form-label ol-form-label" for="discount">{{ get_phrase('Discount (%)') }}</label>
                    <input type="number" max="100" min="0" class="form-control ol-form-control"
                        name="discount" id="discount" value="{{ $coupon_details->discount }}"
                        placeholder="{{ get_phrase('Enter offer discount') }}" required>
                </div>
                @php
                    $courses = \App\Models\Course::where('status', 'active')->get();
                @endphp
                <div class="fpb-7 mb-3">
                    <label class="form-label ol-form-label">{{ get_phrase('Select Course') }}</label>

                    <select name="course_id" class="form-control ol-form-control">
                        <option value="">{{ get_phrase('Select Course') }}</option>

                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}"
                                {{ $coupon_details->course_id == $course->id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @php
                    $bundles = \App\Models\CourseBundle::where('status', 'active')->get();
                @endphp

                <div class="fpb-7 mb-3">
                    <label class="form-label ol-form-label">{{ get_phrase('Select Course Bundle') }}</label>

                    <select name="bundle_id" class="form-control ol-form-control">
                        <option value="">Select Course Bundle</option>
                        <option value="">All Students</option>
                        @foreach ($bundles as $bundle)
                            <option value="{{ $bundle->id }}"
                                {{ $coupon_details->bundle_id == $bundle->id ? 'selected' : '' }}>
                                {{ $bundle->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @php
                    $students = \App\Models\User::where('status', 1)->where('role', 'student')->get();
                @endphp
                <div class="fpb-7 mb-3">
                    <label class="form-label ol-form-label">{{ get_phrase('Select Student') }}</label>

                    <select name="student_id" class="form-control ol-form-control">
                        <option value="">Select Student</option>

                        @foreach ($students as $student)
                            <option value="{{ $student->id }}"
                                {{ $coupon_details->student_id == $student->id ? 'selected' : '' }}>
                                {{ $student->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="fpb-7 mb-3">
                    <label class="form-label ol-form-label" for="expiry">{{ get_phrase('Expiry') }}</label>
                    <input type="date" class="form-control ol-form-control" name="expiry" id="expiry"
                        value="{{ date('Y-m-d', $coupon_details->expiry) }}"
                        placeholder="{{ get_phrase('Enter offer expiry') }}" required>
                </div>

                <div class="fpb-7 mb-3">
                    <label class="form-label ol-form-label" for="status">{{ get_phrase('Status') }}</label>
                    <select for='status' class="form-control ol-form-control ol-select2" name="status" id="status"
                        required>
                        <option value="">{{ get_phrase('Choose status ...') }}</option>
                        <option value="1" @if ($coupon_details->status == 1) selected @endif>
                            {{ get_phrase('Active') }}</option>
                        <option value="0" @if ($coupon_details->status == 0) selected @endif>
                            {{ get_phrase('Inactive') }}</option>
                    </select>
                </div>
            </div>

            <div class="fpb-7 mb-2 d-flex justify-content-end">
                <button type="submit" class="ol-btn-primary">{{ get_phrase('Update coupon') }}</button>
            </div>
        </form>
    </div>
</div>
