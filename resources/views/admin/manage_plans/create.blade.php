<?php
$batches = App\Models\Batch::where('status', 1)->get();
$courses = App\Models\Course::where('status', 'active')->get();
?>

<head>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route('admin.manage.plans.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="fpb-7 mb-3">
                    <label class="form-label ol-form-label" for="b_id">{{ get_phrase('Select Batch') }}<span
                            class="text-danger">*</span></label>
                    <select class="form-control ol-form-control ol-select2" name="b_id" id="b_id" required>
                        <option value="">{{ get_phrase('Choose batch ...') }}
                        </option>
                        @foreach ($batches as $batch)
                            <option value="{{ $batch->id }}">{{ $batch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <!--<div class="fpb-7 mb-3">-->
                <!--    <label class="form-label ol-form-label" for="c_id">{{ get_phrase('Select Course') }}<span-->
                <!--            class="text-danger">*</span></label>-->
                <!--    <select class="form-control ol-form-control ol-select2" name="c_id" id="c_id" required>-->
                <!--        <option value="">Choose course ...</option>-->
                <!--    </select>-->
                <!--</div>-->

                <div class="fpb-7 mb-3">
                    <label class="form-label ol-form-label" for="c_price">{{ get_phrase('Price (₹)') }}<span
                            class="text-danger">*</span></label>
                    <input type="number" min="0" class="form-control ol-form-control" name="c_price"
                        id="c_price" placeholder="{{ get_phrase('Enter price') }}" required>
                </div>


                <div class="fpb-7 mb-3">
                    <label class="form-label ol-form-label" for="c_expiry">
                        {{ get_phrase('Link Expiry') }}<span class="text-danger">*</span>
                    </label>

                    <input type="date" class="form-control ol-form-control" name="c_expiry" id="c_expiry"
                        min="{{ date('Y-m-d') }}" placeholder="{{ get_phrase('Enter link expiry') }}" required>
                </div>

                <div class="fpb-7 mb-3">
                    <label class="form-label ol-form-label" for="c_date">
                        {{ get_phrase('Session Start Date & Time') }}<span class="text-danger">*</span>
                    </label>

                    <input type="datetime-local" class="form-control ol-form-control" name="c_date" id="c_date"
                        min="{{ now()->format('Y-m-d\TH:i') }}"
                        placeholder="{{ get_phrase('Enter session start date and time') }}" required>
                </div>

                <div class="fpb-7 mb-3 d-none">
                    <label class="form-label ol-form-label"
                        for="c_batch">{{ get_phrase('Batch Timing (Label)') }}</label>
                    <input type="text" class="form-control ol-form-control" name="c_batch" id="c_batch"
                        placeholder="{{ get_phrase('e.g. 7 PM IST') }}">
                </div>

            </div>

            <div class="fpb-7 mb-2 d-flex justify-content-end">
                <button type="submit" class="ol-btn-primary">{{ get_phrase('Publish Plan') }}</button>
            </div>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!--<script>-->
<!--    $('#b_id').on('change', function() {-->

<!--        let batch_id = $(this).val();-->

<!--        $('#c_id').html('<option>Loading...</option>');-->

<!--        if (batch_id != '') {-->

<!--            $.ajax({-->
<!--                url: "{{ route('admin.get.course.by.batch', ':id') }}"-->
<!--                    .replace(':id', batch_id),-->
<!--                type: 'GET',-->
<!--                success: function(res) {-->

<!--                    let options = '<option value="">Choose course ...</option>';-->

<!--                    if (res.length > 0) {-->

<!--                        res.forEach(function(course) {-->
<!--                            options += `<option value="${course.id}">-->
<!--                                        ${course.title}-->
<!--                                    </option>`;-->
<!--                        });-->

<!--                    } else {-->
<!--                        options = '<option>No course found</option>';-->
<!--                    }-->

<!--                    $('#c_id').html(options);-->
<!--                }-->
<!--            });-->

<!--        } else {-->
<!--            $('#c_id').html('<option>Choose course ...</option>');-->
<!--        }-->

<!--    });-->
<!--</script>-->
